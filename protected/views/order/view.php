<?php
/* @var $this OrderController */
/* @var $order Order */

$this->breadcrumbs = array(
    'Orders' => array('index'),
    $order->id,
);

// $this->menu = array(
//     array('label' => 'List Order', 'url' => array('index')),
//     array('label' => 'Create Order', 'url' => array('create')),
//     array('label' => 'Update Order', 'url' => array('update', 'id' => $order->id)),
//     array('label' => 'Delete Order', 'url' => '#', 'linkOptions' => array(
//         'submit' => array('delete', 'id' => $order->id),
//         'confirm' => 'Are you sure you want to delete this item?'
//     )),
//     array('label' => 'Manage Order', 'url' => array('admin')),
// );
?>

<div class="order-details-container">
    <div class="order-details-header">
        <h2>Order Details</h2>
        <p>Your Order No. <strong><?php echo CHtml::encode($order->id); ?></strong></p>
    </div>

    <div class="order-meta">
        <p><strong>Date:</strong> <?php echo date('F j, Y g:i A', strtotime($order->created_at)); ?></p>
        <p><strong>Status:</strong> 
            <span class="status <?php echo strtolower($order->status); ?>">
                <?php echo ucfirst($order->status); ?>
            </span>
        </p>
    </div>

    <?php if (!empty($order->orderItems)): ?>
        <?php foreach ($order->orderItems as $item): ?>
            <div class="order-summary-card">
                <img src="<?php echo Yii::app()->baseUrl . '/images/products/' . CHtml::encode($item->product->image ?: 'placeholder.jpg'); ?>" alt="Product image">
                <div class="order-summary-info">
                    <h4><?php echo CHtml::encode($item->product->name); ?></h4>
                    <p><strong>Brand:</strong> <?php echo CHtml::encode($item->product->brand); ?></p>
                    <p><strong>Description:</strong> <?php echo CHtml::encode($item->product->description); ?></p>
                    <p><strong>Quantity:</strong> <?php echo $item->quantity; ?></p>
                    <p class="order-summary-price">₱ <?php echo number_format($item->price, 2); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="order-total-footer">
            Grand Total: ₱<?php echo number_format($order->total, 2); ?>
        </div>
    <?php else: ?>
        <p>No items found in this order.</p>
    <?php endif; ?>

    <a href="<?php echo CHtml::normalizeUrl(['order/index']); ?>" class="btn btn-secondary">← Back to Orders</a>
</div>
