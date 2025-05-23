<?php

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
	public $layout = '//layouts/column2';

	public function filters()
	{
		return array('accessControl');
	}

	public function accessRules()
	{
		return array(
			array('allow',
                'actions' => array('createSession', 'checkout', 'success', 'cancel', 'syncStripeTransactions'),
                'users' => array('*')),
            array('deny',
                'users' => array('*')),
		);
	}

	public function actionCreateSession()
	{
		yii::import('application.vendors.stripe.init');
		Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

		$cart = Yii::app()->user->isGuest
			? Cart::model()->find('session_id = :sid AND status = "active"', [':sid' => Yii::app()->session->sessionID])
			: Cart::model()->find('user_id = :uid AND status = "active"', [':uid' => Yii::app()->user->id]);

		if (!$cart || empty($cart->cartItems)) {
			echo CJSON::encode(['success' => false, 'message' => 'Cart is empty.']);
			Yii::app()->end();
		}

		$lineItems = [];
		foreach ($cart->cartItems as $item) {
			$lineItems[] = [
				'price_data' => [
					'currency' => 'php',
					'product_data' => ['name' => $item->product->name],
					'unit_amount' => $item->product->price * 100,
				],
				'quantity' => $item->quantity,
			];
		}

		$session = Session::create([
			'payment_method_types' => ['card'],
			'line_items' => $lineItems,
			'mode' => 'payment',
			'success_url' => Yii::app()->createAbsoluteUrl("/payment/success") . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => Yii::app()->createAbsoluteUrl("/payment/cancel") . "?session_id={CHECKOUT_SESSION_ID}",
			'customer_email' => Yii::app()->user->email,
            'payment_intent_data' => [
                'metadata' => [
                    'cart_id' => $cart->id,
                    'user_id' => $cart->user_id,
                ]
            ],
		]);

		echo CJSON::encode(['id' => $session->id]);
		Yii::app()->end();
	}

	public function actionCheckout()
	{
		Yii::app()->session->open();

		$cart = Yii::app()->user->isGuest
			? Cart::model()->find('session_id = :sid AND status = "active"', [':sid' => Yii::app()->session->sessionID])
			: Cart::model()->find('user_id = :uid AND status = "active"', [':uid' => Yii::app()->user->id]);

		if (!$cart || empty($cart->cartItems)) {
			throw new CHttpException(400, 'Your cart is empty.');
		}

		Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

		$lineItems = [];
		foreach ($cart->cartItems as $item) {
			$imageUrl = $_ENV['NGROK_URL'] . Yii::app()->baseUrl . '/images/products/' . $item->product->image;
			$lineItems[] = [
				'price_data' => [
					'currency' => 'php',
					'product_data' => [
						'name' => $item->product->name,
						'description' => $item->product->description,
						'images' => [$imageUrl],
					],
					'unit_amount' => intval($item->product->price * 100),
				],
				'quantity' => $item->quantity,
			];
		}

		try {
			$session = Session::create([
				'payment_method_types' => ['card'],
				'line_items' => $lineItems,
				'mode' => 'payment',
				'success_url' => Yii::app()->createAbsoluteUrl("/payment/success") . "?session_id={CHECKOUT_SESSION_ID}",
                'cancel_url' => Yii::app()->createAbsoluteUrl("/payment/cancel") . "?session_id={CHECKOUT_SESSION_ID}",
				'payment_intent_data' => [
                    'metadata' => [
                        'cart_id' => $cart->id,
                        'user_id' => $cart->user_id,
                    ]
                ],
			]);

			$this->redirect($session->url);
		} catch (Exception $e) {
			Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
			throw new CHttpException(500, 'Payment processing failed.');
		}
	}

	public function actionSuccess()
    {
        Yii::app()->user->setFlash('success', 'Payment successful! Thank you for your purchase.');

        $sessionId = Yii::app()->request->getQuery('session_id');
        if (!$sessionId) {
            throw new CHttpException(400, 'Missing session_id.');
        }

        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $lineItems = \Stripe\Checkout\Session::allLineItems($sessionId, ['limit' => 100]);

            $items = [];
            foreach ($lineItems->data as $item) {
                $items[] = [
                    'name' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => number_format($item->amount_subtotal / $item->quantity / 100, 2),
                    'total' => number_format($item->amount_total / 100, 2),
                ];
            }

            $cart = Yii::app()->user->isGuest
                ? Cart::model()->find('session_id = :sid AND status = "active"', [':sid' => Yii::app()->session->sessionID])
                : Cart::model()->find('user_id = :uid AND status = "active"', [':uid' => Yii::app()->user->id]);

            if ($cart) {
                $cart->status = 'pending_confirmation';
                $cart->save();
            }

            $this->actionSyncStripeTransactions();

            $this->render('success', ['items' => $items]);

        } catch (Exception $e) {
            Yii::log("Stripe line item fetch failed: " . $e->getMessage(), CLogger::LEVEL_ERROR);
            throw new CHttpException(500, 'Failed to fetch Stripe session details.');
        }
    }

	public function actionCancel()
	{
		$sessionId = Yii::app()->request->getQuery('session_id');

		if ($sessionId) {
			Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

			$session = Session::retrieve($sessionId);
			$paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
			$cartId = isset($session->metadata->cart_id) ? (int)$session->metadata->cart_id : null;

			if ($paymentIntent->status === 'requires_payment_method' && $cartId) {
				$cart = Cart::model()->findByPk($cartId);
				if ($cart) {
					$cart->status = 'cancelled';
					$cart->save();
				}
			}
		}

		$this->actionSyncStripeTransactions();
		$this->render('cancel');
	}

	public function actionSyncStripeTransactions()
	{
		yii::import('application.vendors.stripe.init');
		Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

		try {
			$sessions = Session::all([
				'limit' => 10,
				'expand' => ['data.payment_intent'],
			]);

			foreach ($sessions->data as $session) {
				$cartId = isset($session->metadata->cart_id) ? (int)$session->metadata->cart_id : null;
				$stripeStatus = $session->payment_status ?? 'unpaid';
				$totalAmount = $session->amount_total / 100.0;

				if (!$cartId) continue;

				$cart = Cart::model()->findByPk($cartId);
				if (!$cart) continue;

				$userId = $cart->user_id;
				$order = Order::model()->findByAttributes(['cart_id' => $cartId]);

				$statusMap = [
					'paid' => ['order' => 'paid', 'cart' => 'completed'],
					'unpaid' => ['order' => 'pending', 'cart' => 'active'],
				];

				$mapped = isset($statusMap[$stripeStatus]) ? $statusMap[$stripeStatus] : ['order' => 'cancelled', 'cart' => 'cancelled'];
				$orderStatus = $mapped['order'];
				$cartStatus = $mapped['cart'];

				if (!$order) {
					$order = new Order;
					$order->user_id = $userId;
					$order->cart_id = $cart->id;
					$order->total = $totalAmount;
					$order->status = $orderStatus;
					$order->created_at = date('Y-m-d H:i:s');
					$order->save();
				} else {
					$order->status = $orderStatus;
					$order->save();
				}

				$cart->status = $cartStatus;
				$cart->save();

				$intent = $session->payment_intent;
				$paymentMethod = isset($intent->payment_method_types[0]) ? ucfirst($intent->payment_method_types[0]) : 'Unknown';
				$paymentStatus = $intent->status ?? $stripeStatus;
				$paymentAmount = isset($intent->amount_received) ? $intent->amount_received / 100.0 : 0;
				$paymentDate = isset($intent->created) ? date('Y-m-d H:i:s', $intent->created) : date('Y-m-d H:i:s');

				$paymentStatusMap = [
					'succeeded' => 'paid',
					'processing' => 'pending',
					'requires_payment_method' => 'pending',
					'canceled' => 'cancelled',
				];

				$mappedStatus = isset($paymentStatusMap[$paymentStatus]) ? $paymentStatusMap[$paymentStatus] : 'cancelled';

				$existingPayment = Payment::model()->findByAttributes(['order_id' => $order->id]);

				if (!$existingPayment) {
					$payment = new Payment;
					$payment->order_id = $order->id;
					$payment->method = $paymentMethod;
					$payment->amount = $paymentAmount;
					$payment->payment_status = $mappedStatus;
					$payment->payment_date = $paymentDate;
					$payment->save();
				} else {
					$existingPayment->method = $paymentMethod;
					$existingPayment->amount = $paymentAmount;
					$existingPayment->payment_status = $mappedStatus;
					$existingPayment->payment_date = $paymentDate;
					$existingPayment->save();
				}
			}

			echo "Orders and payments synced from Stripe.";
		} catch (Exception $e) {
			Yii::log("Stripe Sync Error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
			throw new CHttpException(500, 'Failed to sync Stripe transactions.');
		}
	}

    public function actionStripePaymentStatus($orderId)
    {
        $order = Order::model()->findByPk($orderId);

        if (!$order || empty($order->payments)) {
            throw new CHttpException(404, 'Order or payment not found.');
        }

        $payment = $order->payments[0];
        if (empty($payment->stripe_intent_id)) {
            echo 'No Stripe intent available.';
            Yii::app()->end();
        }

        \Stripe\Stripe::setApiKey(Yii::app()->params['stripeSecretKey']);
        try {
            $intent = \Stripe\PaymentIntent::retrieve($payment->stripe_intent_id);
            echo "<pre>";
            print_r($intent);
            echo "</pre>";
        } catch (\Exception $e) {
            echo "Stripe API error: " . $e->getMessage();
        }

        Yii::app()->end();
    }

}
