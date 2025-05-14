<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'Update Order', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Order', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>

<h1>View Order #<?php echo $model->id; ?></h1>

<?php //$this->widget('zii.widgets.CDetailView', array(
	// 'data'=>$model,
	// 'attributes'=>array(
	// 	'id',
	// 	'user_id',
	// 	'cart_id',
	// 	'total',
	// 	'status',
	// 	'created_at',
	// ),
//)); ?>

<section id="order-view" class="section-p1 bg-dark text-light">
    <h2>Order #<?php echo $order->id; ?> Details</h2>
    <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($order->created_at)); ?></p>
    <p><strong>Status:</strong> <?php echo ucfirst($order->status); ?></p>

    <h3>Items</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->orderItems as $item): ?>
                <tr>
                    <td><?php echo CHtml::encode($item->product->name); ?></td>
                    <td><?php echo CHtml::encode($item->product->description); ?></td>
                    <td><?php echo $item->quantity; ?></td>
                    <td>₱<?php echo number_format($item->price, 2); ?></td>
                    <td>₱<?php echo number_format($item->price * $item->quantity, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: ₱<?php echo number_format($order->total, 2); ?></h3>

    <?php if (!empty($order->payments[0]->receipt_url)): ?>
        <p>
            <a href="<?php echo CHtml::encode($order->payments[0]->receipt_url); ?>" target="_blank" class="btn btn-secondary">
                View Stripe Receipt
            </a>
        </p>
    <?php endif; ?>
</section>
