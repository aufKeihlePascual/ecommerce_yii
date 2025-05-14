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
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/logo2.png" alt="logo" style="width: 150px; height: auto;">
		</a>

		<?php
		$menuItems = array(
			array('label' => 'Home', 'url' => array('/'), 'controller' => 'site', 'action' => 'index'),
			array('label' => 'Products', 'url' => array('/product/index'), 'controller' => 'product'),
			// array('label' => 'Orders', 'url' => array('/order/index'), 'controller' => 'order', 'visible' => !Yii::app()->user->isGuest),
			array('label' => 'Orders', 'url' => array('/order/index'), 'controller' => 'order', 'visible' => !Yii::app()->user->isGuest),
			array('label' => 'About', 'url' => array('/site/about'), 'controller' => 'site', 'action' => 'about'),
			array('label' => 'Contact', 'url' => array('/site/contact'), 'controller' => 'site', 'action' => 'contact'),
		);

		$cartItem = array('label' => '<i class="fa-solid fa-cart-shopping"></i>', 'url' => array('/cart/index'), 'controller' => 'cart', 'encode' => false);

		$userItem = $this->userItem;
		?>

		<div id="navbar-div">
			<ul id="navbar">
				<?php
					$menuItems = array_filter($menuItems, function($item) {
						return !isset($item['visible']) || $item['visible'] === true;
					});
					 
					foreach ($menuItems as $item): ?>
					<?php
						$isActive = false;
						if (isset($item['action'])) {
							$isActive = (Yii::app()->controller->id == $item['controller'] && Yii::app()->controller->action->id == $item['action']);
						} else {
							$isActive = (Yii::app()->controller->id == $item['controller']);
						}
					?>
					<li>
						<a class="<?php echo $isActive ? 'active' : ''; ?>" href="<?php echo Yii::app()->createUrl($item['url'][0]); ?>">
							<?php echo CHtml::encode($item['label']); ?>
						</a>
					</li>
				<?php endforeach; ?>

				<li id="nav-cart">
					<a href="#" id="cart-icon">
						<?php echo $cartItem['encode'] === false ? $cartItem['label'] : CHtml::encode($cartItem['label']); ?>
					</a>
				</li>

				<?php if ($userItem['visible']): ?>
					<li id="nav-user">
						<a href="<?php echo Yii::app()->createUrl($userItem['url'][0]); ?>" title="<?php echo $userItem['tooltip']; ?>">
							<?php echo $userItem['encode'] === false ? $userItem['label'] : CHtml::encode($userItem['label']); ?>
						</a>
					</li>
				<?php endif; ?>


				<a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
			</ul>
		</div>

		<div id="mobile">
			<a href="<?php echo Yii::app()->createUrl('/cart/index'); ?>"><i class="fa-solid fa-cart-shopping" style="color: #FFFFFF;"></i></a>
			<i id="bar" class="fa-solid fa-bars"></i>
		</div>
	</section>

	<?php if (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index'): ?>
		<section id="hero" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/hero_keyboard.png'); background-color: rgba(0,0,0,0.4); background-blend-mode:darken">
			<h1>Elevate your typing experience</h1>
			<p>Explore premium keyboards, switches, and keycaps for the ultimate setup.</p>
			<button>Shop Now</button>
		</section>
	<?php endif; ?>

	<?php echo $content; ?>

	<footer id="footer" class="section-p1 bg-light text-dark">
		<div class="col">
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/logo2.png" alt="logo"  style="width: 200px; height: auto;" class="logo">
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

	<div id="cart-overlay"></div>

	<div id="cart-sidebar">
		<div class="cart-header">
			<h4>Your Cart</h4>
			<button id="cart-close"><i class="fa-solid fa-xmark"></i></button>
		</div>

		<div id="cart-content">

			<!-- Cart items -->

		</div>

		<div class="cart-footer">
			<p class="subtotal">Subtotal: <span id="cart-subtotal">₱0.00</span></p>

				<form method="post" action="<?php echo CHtml::normalizeUrl(['payment/checkout']); ?>">
					<?php echo CHtml::hiddenField(Yii::app()->request->csrfTokenName, Yii::app()->request->csrfToken); ?>
					<button class="btn btn-primary checkout-btn" type="submit">Proceed to Checkout</button>
				</form> 
			
			<a href="<?php echo Yii::app()->createUrl('/cart/shoppingCart'); ?>">Go to Cart</a>
		</div>
	</div>

	<div id="cart-toast" class="cart-toast hidden">
		<i class="fa-solid fa-check"></i>
		<span id="cart-toast-message">Added to cart</span>
	</div>



	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		const ajaxCartUrl = "<?php echo Yii::app()->createUrl('/cart/ajaxCart'); ?>";
		const baseUrl = "<?php echo Yii::app()->baseUrl; ?>";
	</script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/script.js?<?php echo time(); ?>"></script>
	<script src="https://js.stripe.com/v3/"></script>
</body>
</html>