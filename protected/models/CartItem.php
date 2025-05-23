<?php

/**
 * This is the model class for table "cart_items".
 *
 * The followings are the available columns in table 'cart_items':
 * @property integer $id
 * @property integer $cart_id
 * @property integer $product_id
 * @property integer $quantity
 *
 * The followings are the available model relations:
 * @property Cart $cart
 * @property Product $product
 */
class CartItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cart_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cart_id, product_id, quantity', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cart_id, product_id, quantity', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cart' => array(self::BELONGS_TO, 'Cart', 'cart_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cart_id' => 'Cart',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cart_id',$this->cart_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity',$this->quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CartItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCurrentUserCartItems()
	{
		$cartId = null;

		if (!Yii::app()->user->isGuest) {
			$userId = Yii::app()->user->id;
			$cart = Cart::model()->find('user_id = :user_id', [':user_id' => $userId]);
			$cartId = $cart ? $cart->id : null;
		} else {
			$sessionId = Yii::app()->session->sessionID;
			$cart = Cart::model()->find('session_id = :session_id AND user_id IS NULL', [':session_id' => $sessionId]);
			$cartId = $cart ? $cart->id : null;
		}

		if (!$cartId) return [];

		return self::model()->with('product')->findAll('cart_id = :cart_id', [':cart_id' => $cartId]);
	}

}
