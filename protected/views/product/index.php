<?php
/* @var $this ProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Products',
);

// $this->menu=array(
// 	array('label'=>'Create Product', 'url'=>array('create')),
// 	array('label'=>'Manage Product', 'url'=>array('admin')),
// );
// ?>

<?php //$this->widget('zii.widgets.CListView', array(
	//'dataProvider'=>$dataProvider,
	//'itemView'=>'_view',
//)); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css">
	<script src="https://kit.fontawesome.com/4e3a20099e.js"></script>
</head>

<section id="index-category" class="section-p1 bg-dark text-light">
	<!-- Breadcrumbs -->
	<div id="products-page" class="section-header">
		<div class="breadcrumbs">
			<?php if (isset($this->breadcrumbs)): ?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links' => $this->breadcrumbs,
					'htmlOptions' => array('class' => 'breadcrumb-links'),
				)); ?>
			<?php endif; ?>
		</div>
		<h2>Products</h2>
	</div>

	<div class="pro-container">

		<?php foreach ($products as $product): ?>
			<?php
				$image = $product->image ? $product->image : 'placeholder.jpg';
			?>
			<div class="pro">

				<div class="image-wrapper">
					<img src="<?php echo Yii::app()->baseUrl . '/images/products/' . CHtml::encode($image); ?>" alt="<?php echo CHtml::encode($product->name); ?>">
				</div>
				
				<div class="des">
					<span><?php echo CHtml::encode($product->brand); ?></span>
					<h5><?php echo CHtml::encode($product->name); ?></h5>

					<div class="star">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
					</div>

					<h4>₱<?php echo number_format($product->price, 2); ?></h4>
				</div>
				<a href="#"><i class="fa-solid fa-cart-plus cart"></i></a>
			</div>
		<?php endforeach; ?>

	</div>
</section>