<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="language" content="en">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css">
	<script src="https://kit.fontawesome.com/4e3a20099e.js" crossorigin="anonymous"></script>

	<?php
	// Prevent Yii from loading default CSS
	Yii::app()->clientScript->scriptMap = array(
		'jquery.js' => false,
		'yii.css' => false,
		'form.css' => false,
		'screen.css' => false,
	);
	Yii::app()->clientScript->reset();
	?>
</head>

<body class="bg-dark text-light">

	<!-- NAVBAR HEADER -->
	<section id="header">
		<a id="logo" href="<?php echo Yii::app()->createUrl('/'); ?>">
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/logo3.png" alt="logo" style="width: 130px; height: auto;">
		</a>

		<div id="navbar-div">
			<ul id="navbar">
				<li><a class="<?php echo Yii::app()->controller->id == 'site' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/'); ?>">Home</a></li>
				<li><a class="<?php echo Yii::app()->controller->id == 'product' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/product/index'); ?>">Products</a></li>
				<li><a class="<?php echo Yii::app()->controller->id == 'order' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/order/index'); ?>">Orders</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Contact</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('/cart/index'); ?>"><i class="fa-solid fa-cart-shopping"></i></a></li>
			</ul>
		</div>
	</section>

	<!-- HERO SECTION -->
	<?php if (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index'): ?>
		<section id="hero" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/hero_keyboard.png');">
			<h1>Elevate your typing experience</h1>
			<p>Explore premium keyboards, switches, and keycaps for the ultimate setup.</p>
			<button>Shop Now</button>
		</section>
	<?php endif; ?>

	<!-- PAGE CONTENT -->
	<?php if (isset($this->breadcrumbs)): ?>
		<div class="container py-3">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links' => $this->breadcrumbs,
			)); ?>
		</div>
	<?php endif; ?>

	<?php echo $content; ?>

	<!-- Footer -->
	<footer class="bg-black text-secondary py-5 mt-5">
		<div class="container">
			<p class="text-center small mb-0">© <?php echo date('Y'); ?> InnoTech. All rights reserved.</p>
		</div>
	</footer>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
