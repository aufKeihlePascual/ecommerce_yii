<?php

class OrderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'view','create','update', 'stripeOrders'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Order;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	// public function actionIndex()
	// {
	// 	$orders = Order::model()->findAll();

	// 	$dataProvider=new CActiveDataProvider('Order');
	// 	$this->render('index',array(
	// 		'dataProvider'=>$dataProvider,
	// 		'orders' => $orders,
	// 	));
	// }

	public function actionIndex()
	{
		yii::import('application.vendors.stripe.init');
		\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

		try {
			$sessions = \Stripe\Checkout\Session::all([
				'limit' => 100, // fetch many so we can paginate locally
				'expand' => ['data.payment_intent'],
			]);

			$orders = [];

			foreach ($sessions->data as $session) {
				$lineItems = \Stripe\Checkout\Session::allLineItems($session->id, ['limit' => 100]);

				$itemCount = 0;
				foreach ($lineItems->data as $item) {
					$itemCount += $item->quantity;
				}

				$firstItemName = $lineItems->data[0]->description ?? 'Order';
				$displayLabel = $itemCount > 1 ? "$firstItemName (+".($itemCount - 1).")" : $firstItemName;

				$orders[] = (object)[
					'id' => $session->id,
					'summary' => $displayLabel,
					'itemCount' => $itemCount,
					'created_at' => date('Y-m-d H:i:s', $session->created),
					'status' => $session->payment_status === 'unpaid' ? 'pending' : strtolower($session->payment_status),
					'total' => $session->amount_total / 100.0,
				];
			}

			$dataProvider = new CArrayDataProvider($orders, [
				'pagination' => ['pageSize' => 5],
			]);

			$this->render('index', ['dataProvider' => $dataProvider]);

		} catch (Exception $e) {
			Yii::log("Stripe Fetch Error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
			throw new CHttpException(500, 'Failed to load Stripe orders.');
		}
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Order('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Order the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Order $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionStripeOrders()
	{
		yii::import('application.vendors.stripe.init');
		\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

		try {
			$sessions = \Stripe\Checkout\Session::all([
				'limit' => 10,
				'expand' => ['data.payment_intent'],
			]);

			$orders = [];

			foreach ($sessions->data as $session) {
				$lineItems = \Stripe\Checkout\Session::allLineItems($session->id, ['limit' => 100]);

				$items = [];
				foreach ($lineItems->data as $item) {
					$items[] = [
						'name' => $item->description,
						'quantity' => $item->quantity,
						'total' => number_format($item->amount_total / 100, 2),
					];
				}

				$firstItemName = $lineItems->data[0]->description ?? 'Order';
				$itemCount = count($lineItems->data);
				$displayLabel = $itemCount > 1
					? "$firstItemName (+$itemCount)"
					: $firstItemName;

				$orders[] = [
					'id' => $displayLabel,
					'status' => ucfirst($session->payment_status === 'unpaid' ? 'Pending' : $session->payment_status),
					'amount' => number_format($session->amount_total / 100, 2),
					'created' => date('F j, Y', $session->created),
					'items' => $items,
				];

			}

			$this->render('stripeOrders', ['orders' => $orders]);

		} catch (Exception $e) {
			Yii::log("Stripe Orders Error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
			throw new CHttpException(500, 'Failed to retrieve Stripe orders.');
		}
	}

}
