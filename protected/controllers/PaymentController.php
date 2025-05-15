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
                'actions' => array('createSession', 'checkout', 'success', 'cancel', 'syncStripeTransactions', 'markAsShipped'),
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

		$lineItems = [];
		$brandIds = [];
		$categoryIds = [];
		$descriptions = [];
		$imageFilenames = [];

		Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

		$lineItems = [];
		foreach ($cart->cartItems as $item) {
			$product = $item->product;
			$imageUrl = $_ENV['NGROK_URL'] . Yii::app()->baseUrl . '/images/products/' . $product->image;

			$brands[] = $product->brand;
			$categoryIds[] = $product->category_id;
			$descriptions[] = mb_substr($product->description, 0, 100);
			$imageFilenames[] = $product->image;

			$lineItems[] = [
				'price_data' => [
					'currency' => 'php',
					'product_data' => [
						'name' => $product->name,
						'description' => $product->description,
						'images' => [$imageUrl],
						'metadata' => [
							'product_id' => $product->id,
						],
					],
					'unit_amount' => intval($product->price * 100),
				],
				'quantity' => $item->quantity,
			];
		}

		$metadata = [
			'cart_id' => $cart->id,
			'user_id' => $cart->user_id,
			'brand_names' => implode(',', $brands),
			'category_ids' => implode(',', $categoryIds),
			'descriptions' => implode('|', $descriptions),
			'image_filenames' => implode(',', $imageFilenames),
		];
		
		try {
			$session = Session::create([
				'payment_method_types' => ['card'],
				'line_items' => $lineItems,
				'mode' => 'payment',
				'success_url' => Yii::app()->createAbsoluteUrl("/payment/success") . "?session_id={CHECKOUT_SESSION_ID}",
                'cancel_url' => Yii::app()->createAbsoluteUrl("/payment/cancel") . "?session_id={CHECKOUT_SESSION_ID}",
				'payment_intent_data' => [
                    'metadata' => $metadata,
                ],
			]);

			$order = new Order();
			$order->user_id = Yii::app()->user->isGuest ? null : Yii::app()->user->id;
			$order->cart_id = $cart->id;
			$order->total = $cart->getTotal();
			$order->status = 'pending';
			$order->dispatch_status = 'pending';
			$order->stripe_session_id = $session->id;
			$order->created_at = new CDbExpression('NOW()');
			$order->save();

			$this->redirect($session->url);
		} catch (Exception $e) {
			// Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
			// throw new CHttpException(500, 'Payment processing failed.');
			throw new CHttpException(500, 'Payment processing failed: ' . $e->getMessage());

		}
	}

	// public function actionSuccess()
	// {
	// 	Yii::app()->user->setFlash('success', 'Payment successful! Thank you for your purchase.');

	// 	$sessionId = Yii::app()->request->getQuery('session_id');
	// 	if (!$sessionId) {
	// 		throw new CHttpException(400, 'Missing session_id.');
	// 	}

	// 	\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

	// 	try {
	// 		$retryCount = 0;
	// 		$maxRetries = 3;
	// 		$session = null;

	// 		do {
	// 			try {
	// 				$session = \Stripe\Checkout\Session::retrieve([
	// 					'id' => $sessionId,
	// 					'expand' => ['line_items.data.price.product', 'payment_intent'],
	// 				]);
	// 				break;
	// 			} catch (Exception $e) {
	// 				Yii::log("⚠️ Attempt $retryCount failed to retrieve session: " . $e->getMessage(), CLogger::LEVEL_WARNING);
	// 				usleep(500000);
	// 				$retryCount++;
	// 			}
	// 		} while ($retryCount < $maxRetries);

	// 		if (!$session) {
	// 			throw new CHttpException(500, 'Unable to retrieve Stripe session after multiple attempts.');
	// 		}


	// 		$lineItems = \Stripe\Checkout\Session::allLineItems($sessionId, ['limit' => 100]);
	// 		$paymentIntent = $session->payment_intent;

	// 		$items = [];
	// 		$grandTotal = 0;

	// 		foreach ($lineItems->data as $item) {
	// 			$unitPrice = $item->amount_subtotal / $item->quantity / 100;
	// 			$total = $item->amount_total / 100;

	// 			$items[] = [
	// 				'name' => $item->description,
	// 				'quantity' => $item->quantity,
	// 				'unit_price' => number_format($unitPrice, 2),
	// 				'total' => number_format($total, 2),
	// 			];

	// 			$grandTotal += $total;
	// 		}

	// 		$cart = Yii::app()->user->isGuest
	// 			? Cart::model()->find('session_id = :sid AND status = "active"', [':sid' => Yii::app()->session->sessionID])
	// 			: Cart::model()->find('user_id = :uid AND status = "active"', [':uid' => Yii::app()->user->id]);

	// 		if ($cart) {
	// 			$cart->status = 'pending';
	// 			$cart->save();

	// 			$order = Order::model()->findByAttributes(['stripe_session_id' => $session->id]);
	// 			if (!$order) {
	// 				Yii::log("❌ No pending order found for session ID: " . $session->id, CLogger::LEVEL_ERROR);
	// 				throw new CHttpException(404, 'Order not found.');
	// 			}

	// 			$order->user_id = Yii::app()->user->isGuest ? null : Yii::app()->user->id;
	// 			$order->cart_id = $cart->id;
	// 			$order->total = $grandTotal;
	// 			$order->status = 'paid';
	// 			$order->created_at = new CDbExpression('NOW()');

	// 			if ($order->save()) {

	// 				foreach ($lineItems->data as $item) {
	// 					$productId = null;

	// 					if (!empty($item->price->product->metadata['product_id'])) {
	// 						Yii::log("🧪 Checking item metadata: " . print_r($item->price->product->metadata, true), CLogger::LEVEL_INFO);

	// 						$productId = $item->price->product->metadata['product_id'];
	// 					} else {
	// 						$productName = $item->description;
	// 						$product = Product::model()->findByAttributes(['name' => $productName]);
	// 						if ($product) {
	// 							$productId = $product->id;
	// 						}
	// 					}

	// 					$product = $productId ? Product::model()->findByPk($productId) : null;

	// 					if ($product) {
	// 						$orderItem = new OrderItem();
	// 						$orderItem->order_id = $order->id;
	// 						$orderItem->product_id = $product->id;
	// 						$orderItem->quantity = $item->quantity;
	// 						$orderItem->price = $product->price;
	// 						$orderItem->save();
	// 					} else {
	// 						Yii::log("⚠️ Could not resolve product for line item: " . print_r($item, true), CLogger::LEVEL_WARNING);
	// 					}

	// 					if ($product) {
	// 						$orderItem = new OrderItem();
	// 						$orderItem->order_id = $order->id;
	// 						$orderItem->product_id = $product->id;
	// 						$orderItem->quantity = $item->quantity;
	// 						$orderItem->price = $product->price;
	// 						$orderItem->save();
	// 					} else {
	// 						Yii::log("⚠️ Product not found for product_id: " . print_r($productId, true), CLogger::LEVEL_WARNING);
	// 					}
	// 				}

	// 				$payment = new Payment();
	// 				$payment->order_id = $order->id;
	// 				$payment->stripe_intent_id = $paymentIntent->id;
	// 				$payment->receipt_url = $paymentIntent->charges->data[0]->receipt_url ?? null;
	// 				$payment->status = 'paid';
	// 				$payment->save();

	// 				Yii::log("✅ Payment record created for order ID: " . $order->id, CLogger::LEVEL_INFO);
	// 			} else {
	// 				Yii::log("❌ Failed to save order. Errors: " . print_r($order->getErrors(), true), CLogger::LEVEL_ERROR);
	// 			}

	// 			CartItem::model()->deleteAll('cart_id = :cartId', [':cartId' => $cart->id]);
	// 		} else {
	// 			Yii::log("⚠️ Cart not found for current user/session.", CLogger::LEVEL_WARNING);
	// 		}

	// 		$this->actionSyncStripeTransactions();

	// 		$this->render('success', [
	// 			'items' => $items,
	// 			'grandTotal' => number_format($grandTotal, 2),
	// 			'paymentIntentId' => strtoupper($paymentIntent->id)
	// 		]);

	// 	} catch (Exception $e) {
	// 		Yii::log("❌ Stripe session or payment fetch failed: " . $e->getMessage(), CLogger::LEVEL_ERROR);
	// 		Yii::log("📄 Stack trace: " . $e->getTraceAsString(), CLogger::LEVEL_ERROR);
	// 		throw new CHttpException(500, 'Failed to fetch Stripe session details.');
	// 	}
	// }

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
			$grandTotal = 0;

            foreach ($lineItems->data as $item) {
				$unitPrice = $item->amount_subtotal / $item->quantity / 100;
				$totalAmount = $item->amount_total / 100;

				$items[] = [
					'name' => $item->description,
					'quantity' => $item->quantity,
					'unit_price' => number_format($unitPrice, 2),
					'total' => number_format($totalAmount, 2),
				];

				$grandTotal += $totalAmount;
            }

			$grandTotal = number_format($grandTotal, 2);

            $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
			$paymentIntentId = strtoupper($paymentIntent->id);
			
			$cart = Yii::app()->user->isGuest
                ? Cart::model()->find('session_id = :sid AND status = "active"', [':sid' => Yii::app()->session->sessionID])
                : Cart::model()->find('user_id = :uid AND status = "active"', [':uid' => Yii::app()->user->id]);

            if ($cart) {
                $cart->status = 'pending_confirmation';
                $cart->save();
            }

            $this->actionSyncStripeTransactions();

            $this->render('success', [
				'items' => $items,
				'paymentIntentId' => $paymentIntentId,
				'grandTotal' => $grandTotal,
			]);

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
					'accepted' => ['order' => 'accepted', 'cart' => 'completed'],
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
					'succeeded' => 'accepted',
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

			// echo "Orders and payments synced from Stripe.";
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

	public function actionSyncPaymentStatus()
	{
		Yii::import('application.vendors.stripe.init');
		\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

		$orders = Order::model()->findAllByAttributes(['dispatch_status' => 'unpaid']);

		foreach ($orders as $order) {
			if (!$order->stripe_session_id) continue;

			try {
				$session = \Stripe\Checkout\Session::retrieve($order->stripe_session_id);
				$paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

				if ($paymentIntent->status === 'succeeded') {
					$order->status = 'accepted';
					$order->dispatch_status = 'pending';
					$order->save(false);
				}

			} catch (Exception $e) {
				Yii::log("Stripe sync error for Order ID {$order->id}: " . $e->getMessage(), CLogger::LEVEL_ERROR);
			}
		}

		echo "Dispatch statuses updated where applicable.";
	}

	public function actionMarkAsShipped($session_id)
	{
		// echo "Received session ID: " . CHtml::encode($session_id) . "<br>";

		$order = Order::model()->findByAttributes(['stripe_session_id' => $session_id]);

		if (!$order) {
			throw new CHttpException(404, 'Order not found.');
		}

		$order->status = 'paid';
		$order->dispatch_status = 'shipped';
		$order->save(false);

		// echo "Order marked as shipped.";
	}

}
