<?php
/* @var $this OrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array('Orders');
?>

<section id="index-orders" class="section-p1 bg-dark text-light">

    <div id="orders-page" class="section-header">
        <div class="breadcrumbs">
            <?php if (isset($this->breadcrumbs)): ?>
                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'htmlOptions' => array('class' => 'breadcrumb-links'),
                )); ?>
            <?php endif; ?>
        </div>
        <h2>Orders</h2>
    </div>

	<div class="order-page d-flex">
		<div class="order-table-wrapper">
			<table class="order-table">
				<thead>
					<tr>
						<th>Order ID</th>
						<th>Items</th>
						<th>Date</th>
						<th>Status</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataProvider->getData() as $data): ?>
						<tr>
							<td><?php echo $data->id; ?></td>
							<td><?php echo $data->itemCount; ?></td>
							<td><?php echo date('F j, Y g:i A', strtotime($data->created_at)); ?></td>
							<td><span class="status <?php echo strtolower($data->status); ?>"><?php echo ucfirst($data->status); ?></span></td>
							<td>₱ <strong><?php echo number_format($data->total, 2); ?></strong></td>
							<!-- <td>
								<?php //echo CHtml::link('View', array('order/view', 'id' => $data->id), array('class' => 'view-btn')); ?>
							</td> -->

							<td>
								<?php echo CHtml::link('View', array('order/view', 'id' => $data->id), array('class' => 'view-btn')); ?>
								<?php if (!empty($data->payments) && !empty($data->payments[0]->stripe_intent_id)): ?>
									<br>
									<?php echo CHtml::link('Stripe Status', array('payment/stripePaymentStatus', 'orderId' => $data->id), array(
										'class' => 'stripe-btn',
										'target' => '_blank'
									)); ?>
								<?php endif; ?>
							</td>

						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
    </div>

</section>
