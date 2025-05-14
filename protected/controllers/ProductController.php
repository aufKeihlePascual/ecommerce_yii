<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			// array('allow', // allow authenticated user to perform 'create' and 'update' actions
			// 	'actions'=>array('create','update'),
			// 	'users'=>array('@'),
			// ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete'),
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
		$model = new Product;
		$categoryList = CHtml::listData(Category::model()->findAll(['order'=>'name']), 'id','name');

		if (isset($_POST['Product'])) {
			$model->attributes = $_POST['Product'];

			$uploadedFile = CUploadedFile::getInstance($model, 'image');
			if ($uploadedFile !== null) {
				$base      = strtolower($model->brand . ' ' . $model->name);
				$slug      = preg_replace('/[^a-z0-9]+/','_', $base);
				$extension = $uploadedFile->getExtensionName();
				$filename  = "{$slug}.{$extension}";
				$model->image = $filename;
			}

			if ($model->save()) {
				if ($uploadedFile !== null) {
					$uploadPath = Yii::app()->basePath . '/../images/products/' . $filename;
					$uploadedFile->saveAs($uploadPath);
				}
				$this->redirect(['view', 'id' => $model->id]);
			}
		}

		$this->render('create', [
			'model'        => $model,
			'categoryList' => $categoryList,
		]);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// load categories for the dropdown
		$categoryList = CHtml::listData(
			Category::model()->findAll(['order'=>'name']),
			'id',
			'name'
		);

		if (isset($_POST['Product'])) {
			$model->attributes = $_POST['Product'];
			if ($model->save()) {
				$this->redirect(['view','id'=>$model->id]);
			}
		}

		$this->render('update', [
			'model'        => $model,
			'categoryList' => $categoryList,
		]);
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
		$criteria = new CDbCriteria();

		if (isset($_GET['categories']) && is_array($_GET['categories'])) {
			$criteria->addInCondition('category_id', $_GET['categories']);
		}

		if (isset($_GET['availability'])) {
			if ($_GET['availability'] === 'in') {
				$criteria->addCondition('stock > 0');
			} elseif ($_GET['availability'] === 'out') {
				$criteria->addCondition('stock <= 0');
			}
		}

		$criteria->order = 'id DESC';

		$dataProvider = new CActiveDataProvider('Product', array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 8,
			),
		));

		$categories = Category::model()->findAll();
		$brands = Product::model()->getAllBrands();

		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'categories'   => $categories,
			'brands'       => $brands,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Product $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
