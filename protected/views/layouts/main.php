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

	<section id="header">
		<a id="logo" href="<?php echo Yii::app()->createUrl('/'); ?>">
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/logo2.png" alt="logo" style="width: 130px; height: auto;">
		</a>

		<!-- <div id="navbar-div">
			<ul id="navbar">
				<li><a class="<?php //echo Yii::app()->controller->id == 'site' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/'); ?>">Home</a></li>
				<li><a class="<?php //echo Yii::app()->controller->id == 'product' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/product/index'); ?>">Products</a></li>
				<li><a class="<?php //echo Yii::app()->controller->id == 'order' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/order/index'); ?>">Orders</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Contact</a></li>
				<li id="nav-cart"><a href="<?php echo Yii::app()->createUrl('/cart/index'); ?>"><i class="fa-solid fa-cart-shopping"></i></a></li>
				<a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
			</ul>
		</div> -->

		<div id="navbar-div">
			<ul id="navbar">
				<li><a class="<?php echo (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/'); ?>">Home</a></li>
				<li><a class="<?php echo Yii::app()->controller->id == 'product' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/product/index'); ?>">Products</a></li>
				<li><a class="<?php echo Yii::app()->controller->id == 'order' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/order/index'); ?>">Orders</a></li>
				<li><a class="<?php echo (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'about') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/site/about'); ?>">About</a></li>
				<li><a class="<?php echo (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'contact') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/site/contact'); ?>">Contact</a></li>
				<li id="nav-cart"><a class="<?php echo Yii::app()->controller->id == 'cart' ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl('/cart/index'); ?>"><i class="fa-solid fa-cart-shopping"></i></a></li>
				<a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
			</ul>
		</div>


		<div id="mobile">
			<a href="<?php echo Yii::app()->createUrl('/cart/index'); ?>"><i class="fa-solid fa-cart-shopping" style="color: #FFFFFF;"></i></a>
			<i id="bar" class="fa-solid fa-bars"></i>
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

	<?php echo $content; ?>

	<footer class="section-p1 bg-light text-dark">
		<div class="col">
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/logo2.png" alt="logo"  style="width: 200px; height: auto;" class="logo">
			<!-- <h4>Contact</h4> -->
			<p><strong>Address: </strong>MacArthur Hwy, Angeles, 2009 Pampanga</p>
			<p><strong>Phone: </strong>+63 9012345678</p>
			<p><strong>Hours: </strong>10:00 - 18:00, Mon - Sat</p>
		</div>

		<div class="col">
			<h4>About</h4>
			<a href="#">About Us</a>
			<a href="#">Delivery Information</a>
			<a href="#">Contact Us</a>
		</div>

		<div class="col">
			<h4>My Account</h4>
			<a href="#">Sign In</a>
			<a href="#">View Cart</a>
			<a href="#">My Wishlist</a>
		</div>

		<div class="col install">
			<h4>Secured Payment Gateways</h4>
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/payment.png" style="width: 300px; height: auto;" alt="Payment Options">

			<div class="follow">
				<h4>Follow Us</h4>
				<div class="icon">
					<i class="fa-brands fa-facebook-f"></i>
					<i class="fa-brands fa-x-twitter"></i>
					<i class="fa-brands fa-instagram"></i>
					<i class="fa-brands fa-youtube"></i>
				</div>
			</div>
		</div>

		<div class="copyright">
			<p class="text-center small mb-0">© <?php echo date('Y'); ?> InnoTech. All rights reserved.</p>
		</div>

	</footer>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/script.js"></script>
</body>
</html>
