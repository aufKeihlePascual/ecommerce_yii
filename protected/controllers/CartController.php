<?php

class CartController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view', 'ajaxCart', 'addToCart', 'updateQuantity', 'removeItem', 'shoppingCart'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index', 'create','update', 'admin','delete'),
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
		$model=new Cart;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cart']))
		{
			$model->attributes=$_POST['Cart'];
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

		if(isset($_POST['Cart']))
		{
			$model->attributes=$_POST['Cart'];
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Cart');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cart('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cart']))
			$model->attributes=$_GET['Cart'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cart the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cart::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cart $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cart-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAjaxCart()
	{
		Yii::app()->layout = false;
		Yii::app()->session->open();

		try {
			if (Yii::app()->user->isGuest) {
				$cart = Cart::model()->find('session_id = :sid AND status = "active"', [
					':sid' => Yii::app()->session->sessionID
				]);
			} else {
				$cart = Cart::model()->find('user_id = :uid AND status = "active"', [
					':uid' => Yii::app()->user->id
				]);
			}

			if (!$cart) {
				echo CJSON::encode([
					'items' => [],
					'subtotal' => 0,
					'totalQuantity' => 0
				]);
				Yii::app()->end();
			}

			$items = [];
			$subtotal = 0;
			$totalQuantity = 0;

			foreach ($cart->cartItems as $cartItem) {
				if (!$cartItem) continue;

				$product = $cartItem->product;
				if (!$product || $product->stock < 1) continue;

				$items[] = [
					'id' => $product->id,
					'name' => $product->name,
					'price' => floatval($product->price),
					'quantity' => intval($cartItem->quantity),
					'image' => $product->image ?? 'placeholder.jpg',
				];

				$subtotal += $product->price * $cartItem->quantity;
				$totalQuantity += $cartItem->quantity;
			}

			echo CJSON::encode([
				'items' => $items,
				'subtotal' => $subtotal,
				'totalQuantity' => $totalQuantity
			]);
		} catch (Exception $e) {
			header('Content-Type: application/json', true, 500);
			echo json_encode(['error' => $e->getMessage()]);
		}

		Yii::app()->end();
	}

	public function actionAddToCart($id)
	{
		Yii::app()->session->open();
		$product = Product::model()->findByPk($id);

		if (!$product || $product->stock < 1) {
			if (Yii::app()->request->isAjaxRequest) {
				echo CJSON::encode(['success' => false, 'message' => 'Out of stock or not found']);
				Yii::app()->end();
			}
			throw new CHttpException(404, 'Product not found or out of stock.');
		}

		$isGuest = Yii::app()->user->isGuest;
		$sessionId = Yii::app()->session->sessionID;

		if ($isGuest) {
			$cart = Cart::model()->find('session_id=:sid AND status="active"', [':sid' => $sessionId]);
		} else {
			$cart = Cart::model()->find('user_id=:uid AND status="active"', [':uid' => Yii::app()->user->id]);
		}

		if (!$cart) {
			$cart = new Cart;
			$cart->status = 'active';
			$cart->created_at = date('Y-m-d H:i:s');

			if ($isGuest) {
				$cart->session_id = $sessionId;
			} else {
				$cart->user_id = Yii::app()->user->id;
			}

			$cart->save();
		}

		$item = CartItem::model()->findByAttributes([
			'cart_id' => $cart->id,
			'product_id' => $id
		]);

		if ($item) {
			if ($product->stock <= 0) {
				if (Yii::app()->request->isAjaxRequest) {
					echo CJSON::encode(['success' => false, 'message' => 'Insufficient stock']);
					Yii::app()->end();
				}
				Yii::app()->user->setFlash('error', 'Insufficient stock');
				$this->redirect(array('product/view', 'id' => $id));
			}
			$item->quantity += 1;
		} else {
			$item = new CartItem;
			$item->cart_id = $cart->id;
			$item->product_id = $id;
			$item->quantity = 1;
		}

		$item->save();
		$product->stock -= 1;
		$product->save();

		if (Yii::app()->request->isAjaxRequest) {
			echo CJSON::encode(['success' => true, 'message' => 'Added to cart']);
			Yii::app()->end();
		}

		Yii::app()->user->setFlash('success', 'Item added to cart');
		$this->redirect(array('cart/view'));
	}


	public function actionUpdateQuantity()
	{
		$data = json_decode(file_get_contents('php://input'), true);

		$productId = (int) $data['productId'];
		$action = $data['action'];

		if (Yii::app()->user->isGuest) {
			$cart = Cart::model()->findByAttributes([
				'session_id' => Yii::app()->session->sessionID,
				'status' => 'active',
			]);
		} else {
			$cart = Cart::model()->findByAttributes([
				'user_id' => Yii::app()->user->id,
				'status' => 'active',
			]);
		}

		$item = CartItem::model()->findByAttributes([
			'cart_id' => $cart->id,
			'product_id' => $productId,
		]);

		$product = Product::model()->findByPk($productId);

		if (!$item || !$product) {
			echo CJSON::encode(['success' => false]);
			Yii::app()->end();
		}

		if ($action === 'increase') {
			if ($product->stock > 0) {
				$item->quantity += 1;
				$product->stock -= 1;
			}
		} elseif ($action === 'decrease') {
			if ($item->quantity > 1) {
				$item->quantity -= 1;
				$product->stock += 1;
			} else {
				$item->delete();
				$product->stock += 1;
				$product->save();
				echo CJSON::encode(['success' => true]);
				Yii::app()->end();
			}
		}

		$item->save();
		$product->save();

		echo CJSON::encode(['success' => true]);
		Yii::app()->end();
	}


	public function actionRemoveItem()
	{
		$data = json_decode(file_get_contents('php://input'), true);

		$productId = (int) $data['productId'];

		if (Yii::app()->user->isGuest) {
			$cart = Cart::model()->findByAttributes([
				'session_id' => Yii::app()->session->sessionID,
				'status' => 'active',
			]);
		} else {
			$cart = Cart::model()->findByAttributes([
				'user_id' => Yii::app()->user->id,
				'status' => 'active',
			]);
		}

		$item = CartItem::model()->findByAttributes([
			'cart_id' => $cart->id,
			'product_id' => $productId,
		]);

		$product = Product::model()->findByPk($productId);

		if ($item && $product) {
			$product->stock += $item->quantity;
			$product->save();
			$item->delete();
		}

		echo CJSON::encode(['success' => true]);
		Yii::app()->end();
	}

	public function actionShoppingCart()
	{
		if (Yii::app()->user->isGuest) {
			$cart = Cart::model()->find('session_id = :sid AND status = "active"', [
				':sid' => Yii::app()->session->sessionID
			]);
		} else {
			$cart = Cart::model()->find('user_id = :uid AND status = "active"', [
				':uid' => Yii::app()->user->id
			]);
		}

		$cartItems = $cart ? $cart->cartItems : [];
		$subtotal = 0;

		foreach ($cartItems as $item) {
			$subtotal += $item->product->price * $item->quantity;
		}

		$this->render('shoppingcart', [
			'cartItems' => $cartItems,
			'subtotal' => $subtotal,
		]);
	}


}
