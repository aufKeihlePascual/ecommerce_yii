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

    <!-- <div class="product-page"> -->
	<div class="order-page d-flex">
		<aside class="sidebar">
            <div class="filter-section">
                <h4>Actions</h4>
                <ul class="menu-links">
                    <li>
                        <a href="<?php echo CHtml::normalizeUrl(array('order/create')); ?>">
                            <i class="fa fa-plus-circle"></i> Create Order
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo CHtml::normalizeUrl(array('order/admin')); ?>">
                            <i class="fa fa-cogs"></i> Manage Orders
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

		<div class="order-table-wrapper">
			<table class="order-table">
				<thead>
					<tr>
						<th>Order</th>
						<th>Date</th>
						<th>Status</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataProvider->getData() as $data): ?>
						<tr>
							<td>#<?php echo $data->id; ?></td>
							<td><?php echo date('F j, Y', strtotime($data->created_at)); ?></td>
							<td><span class="status <?php echo strtolower($data->status); ?>"><?php echo ucfirst($data->status); ?></span></td>
							<td>₱<?php echo number_format($data->total, 2); ?></td>
							<td>
								<?php echo CHtml::link('View', array('order/view', 'id' => $data->id), array('class' => 'view-btn')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
    </div>

</section>
