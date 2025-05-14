<!-- <section id="index-category" class="section-p1 bg-dark text-light">
	<h2>Shop by Category</h2>
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
</section> -->

<section id="keyboard-section" class="section-p1 category-shop category bg-dark text-light">
	<h2>Shop by Category</h2>

	<div class="keyboard-container">
		<?php foreach ($categories as $category): ?>
			<?php
				$image = $category->image ? $category->image : 'placeholder.jpg';
				$name = CHtml::encode($category->name);
			?>
			<div class="banner-box categories" style="background-image: url('<?php echo Yii::app()->baseUrl . '/images/categories/' . CHtml::encode($image); ?>');">
				<!-- <button class="categories"><?php //echo $name; ?></button> -->
				 <a href="<?php echo Yii::app()->createUrl('product/index', ['categories[]' => $category->id]); ?>" class="categories-link">
					<?php echo $name; ?>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</section>


<section id="banner" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/b2.jpg');">
	<h4>Keyboard Accessories</h4>
	<h2>Accessories that make every keypress count.</h2>
	<?php
	$accessoryCategoryId = null;
	foreach ($categories as $category) {
		if (strtolower($category->name) === 'accessories') {
			$accessoryCategoryId = $category->id;
			break;
		}
	}
	?>

	<?php if ($accessoryCategoryId !== null): ?>
		<button class="normal" onclick="window.location.href='<?php echo Yii::app()->createUrl('product/index', ['categories[]' => $accessoryCategoryId]); ?>'">
			Check It Out
		</button>
	<?php endif; ?>


</section>

<section id="featured" class="section-p1">
	<h2>Newest Products</h2>

	<div class="pro-container">
		<?php foreach ($products as $product): ?>

			<?php $image = $product->image ? $product->image : 'placeholder.jpg'; ?>
			
			<div class="pro">

				<div class="image-wrapper">
					<a href="<?php echo CHtml::normalizeUrl(array('product/view', 'id' => $product->id)); ?>">
						<img src="<?php echo Yii::app()->baseUrl . '/images/products/' . CHtml::encode($image); ?>" alt="<?php echo CHtml::encode($product->name); ?>">
					</a>
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

				<a href="#" class="add-to-cart-link" data-id="<?php echo $product->id; ?>">
					<i class="fa-solid fa-cart-plus cart"></i>
				</a>
			</div>

		<?php endforeach; ?>
	</div>
</section>

<section id="newsletter" class="section-p1" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/newsletter.jpg');">
	<div class="newstext">
		<h3>Sign Up for Newsletters</h3>
		<p>Get E-mail updates about our latest shop and <span>special offers</span>.</p>

		<div class="form">
			<input type="text" placeholder="Your Email Address">
			<button class="normal">Sign Up</button>
		</div>
	</div>
</section>

<!-- <section id="keyboard-section" class="section-p1 keyboard-size">
	<h2>Shop by Keyboard Size</h2>

	<div class="keyboard-container">
		<div class="banner-box" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/fullsize.png');">
			<h3>Full-Size Keyboards</h3>
			<button class="categories">Browse</button>
		</div>

		<div class="banner-box" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/tkl.png');">
			<h3>TKL Keyboards</h3>
			<button class="categories">Browse</button>
		</div>

		<div class="banner-box" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/75.png');">
			<h3>75% Keyboards</h3>
			<button class="categories">Browse</button>
		</div>

		<div class="banner-box" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/65.png');">
			<h3>65% Keyboards</h3>
			<button class="categories">Browse</button>
		</div>

		<div class="banner-box" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/60.png');">
			<h3>60% Keyboards</h3>
			<button class="categories">Browse</button>
		</div>

		<div class="banner-box" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/numpad.png');">
			<h3>Numpad Keyboards</h3>
			<button class="categories">Browse</button>
		</div>
	</div>

</section> -->