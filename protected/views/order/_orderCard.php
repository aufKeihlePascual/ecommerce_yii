<?php
/* @var $data Order */

// $orderItems = $data->orderItems;
?>



<div class="order-card">
    <div class="order-details">
        <div class="order-number">Order #<?php echo $data->id; ?></div>
        <div class="order-date">
            <?php echo date('F j, Y', strtotime($data->created_at)); ?>
        </div>
        <div class="order-total">
            Total: ₱<?php echo number_format($data->total, 2); ?>
        </div>
    </div>
    <span class="order-status"><?php echo ucfirst($data->status); ?></span>
</div>
