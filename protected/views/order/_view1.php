<?php
/* @var $this OrderController */
/* @var $data Order */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cart_id')); ?>:</b>
	<?php echo CHtml::encode($data->cart_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<div class="order-card col-md-6 col-lg-4 mb-4">
		<div class="card h-100 shadow-sm p-3 bg-white text-dark rounded-4">
			<h5 class="card-title mb-2">Order #<?php echo CHtml::encode($data->id); ?></h5>
			<p class="card-text">
			<strong>Date:</strong> <?php echo CHtml::encode($data->created_at); ?><br>
			<strong>Status:</strong> <?php echo CHtml::encode($data->status); ?><br>
			<strong>Total:</strong> ₱<?php echo CHtml::encode($data->total_price); ?>
			</p>
			<a href="<?php echo CHtml::normalizeUrl(array('order/view', 'id'=>$data->id)); ?>" class="btn btn-primary mt-2">View Details</a>
		</div>
	</div>



</div>