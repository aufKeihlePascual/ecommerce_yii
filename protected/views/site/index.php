<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css">
	<script src="https://kit.fontawesome.com/4e3a20099e.js"></script>
</head>

<!-- Homepage Featured Products -->
<!-- <section id="featured" class="section-p1">
	<h2>Featured Products</h2>
	<p>Elevate your typing experience</p>
	<div class="pro-container">
		<div class="pro">
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/featured/gmmk_pro.jpg" alt="">
			
			<div class="des">
				<span>brand name</span>
				<h5>product name</h5>

				<div class="star">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>

				<h4>price</h4>
			</div>
			<a href="#"><i class="fa-solid fa-cart-plus cart"></i></a>

		</div>
	</div>
</section> -->

<section id="featured" class="section-p1">
	<h2>Featured Products</h2>
	<p>Elevate your typing experience</p>
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

<section id="banner" class="section-m1" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/b1.jpg');">
	<h4>Keyboard Accessories</h4>
	<h2>Accessories that make every keypress count.</h2>
	<button class="normal">Check It Out</button>
</section>