<?php
/* @var $data Order */

$orderItems = $data->orderItems; // assuming relation `orderItems` exists
?>

<div class="order-card">
    <div class="order-header">
        <h4>Order #<?php echo $data->id; ?> — <?php echo date('F j, Y', strtotime($data->created_at)); ?></h4>
        <span class="status"><?php echo CHtml::encode($data->status); ?></span>
    </div>

    <div class="order-items">
        <?php foreach ($orderItems as $item): ?>
            <div class="order-item">
                <img src="<?php echo Yii::app()->baseUrl . '/images/products/' . CHtml::encode($item->product->image); ?>" alt="" class="item-thumb">
                <div class="item-details">
                    <strong><?php echo CHtml::encode($item->product->name); ?></strong>
                    <p>Qty: <?php echo $item->quantity; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="order-footer">
        <span>Total: ₱<?php echo number_format($data->total, 2); ?></span>
    </div>
</div>
