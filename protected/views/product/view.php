<div class="back-button-wrapper">
    <?php echo CHtml::link(
        '<i class="fa fa-arrow-left"></i> Back to Products',
        array('product/index'),
        array('class' => 'back-button')
    ); ?>
</div>

<section id="product-view">
  	<div class="product-container">
		<div class="left">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/products/<?php echo CHtml::encode($model->image); ?>" alt="<?php echo CHtml::encode($model->name); ?>" />
		</div>
		<div class="right">
			<p class="brand-label"><?php echo $model->brand ?></p>
			<h2 class="product-title"><?php echo $model->name ?></h2>
			<p class="product-description"><?php echo nl2br($model->description) ?></p>
			<div class="price">
				<span class="current-price">₱ <?php echo number_format($model->price, 2); ?></span>
			</div>
		<div class="purchase">
			<div class="quantity">
				<button id="minus">−</button>
				<input id="quantity-input" value="1" />
				<button id="plus">+</button>
			</div>
			<?php echo CHtml::beginForm(['cart/add'],'post'); ?>
			<?php echo CHtml::hiddenField('productId',$model->id) ?>
			<?php echo CHtml::hiddenField('quantity',1, ['id'=>'hidden-quantity']); ?>
			<a href="#" class="add-to-cart-link" data-id="<?php echo $model->id; ?>">
				<i class="fa-solid fa-cart-plus cart"></i> Add to Cart
			</a>
			<?php echo CHtml::endForm(); ?>
			</div>
		</div>
	</div>
</section>
