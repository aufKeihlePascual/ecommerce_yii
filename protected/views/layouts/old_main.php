<?php /* @var $this Controller */ ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Products', 'url'=>array('/product/index')),
				array('label'=>'Orders', 'url'=>array('/order/index'), 'visible' => !Yii::app()->user->isGuest),
				array('label'=>'View Cart', 'url'=>array('/cart/index')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->

	<!-- Minimal Header -->
	<!-- <header class="py-3 border-bottom border-secondary sticky-top bg-dark">
		<div class="container d-flex justify-content-between align-items-center">
			<a class="text-white fw-bold fs-4 text-decoration-none" href="<?php echo Yii::app()->homeUrl; ?>">InnoTech</a>
			<nav>
			<?php
				// $this->widget('zii.widgets.CMenu', array(
				// 	'htmlOptions' => array('class' => 'nav gap-3'),
				// 	'items' => array(
				// 		array('label'=>'Home', 'url'=>array('/site/index'), 'linkOptions'=>array('class'=>'nav-link text-light')),
				// 		array('label'=>'Products', 'url'=>array('/product/index'), 'linkOptions'=>array('class'=>'nav-link text-light')),
				// 		array('label'=>'Orders', 'url'=>array('/order/index'), 'visible'=>!Yii::app()->user->isGuest, 'linkOptions'=>array('class'=>'nav-link text-light')),
				// 		array('label'=>'View Cart', 'url'=>array('/cart/index'), 'linkOptions'=>array('class'=>'nav-link text-light')),
				// 		array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest, 'linkOptions'=>array('class'=>'nav-link text-light')),
				// 		array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest, 'linkOptions'=>array('class'=>'nav-link text-light')),
				// 	),
				// ));
				?>
			</nav>
		</div>
	</header> -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
