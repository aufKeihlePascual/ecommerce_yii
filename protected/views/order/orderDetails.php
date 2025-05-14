
<div class="order-details-container">
    <div class="order-details-header">
        <h2>Order Details</h2>
        <p>Your Order Ref No #<strong><?php echo CHtml::encode(strtoupper(substr($paymentIntentId, 3))); ?></strong></p>
    </div>

    <div class="order-meta">
        <span class="status <?php echo strtolower(trim($dispatchStatus)); ?>">
            <?php echo ucfirst(trim($dispatchStatus)); ?>
        </span>
    </div>

    <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
            <div class="order-summary-card">
                <img src="<?php echo CHtml::encode($item['image']); ?>" alt="Product image">
                <div class="order-summary-info">
                    <h4><?php echo CHtml::encode($item['name']); ?></h4>
                    <p><strong>Brand:</strong> <?php echo CHtml::encode($item['brand']); ?></p>
                    <p><strong>Category:</strong> <?php echo CHtml::encode($item['category']); ?></p>
                    <p><strong>Description:</strong> <?php echo CHtml::encode($item['description']); ?></p>
                    <p><strong>Quantity:</strong> <?php echo $item['quantity']; ?></p>
                    <p style="font-size: 20px; font-weight: 600;">₱ <?php echo $item['unit_price']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="order-total-footer">
            Grand Total: ₱<?php echo $grandTotal; ?>
        </div>
    <?php endif; ?>

    <a href="<?php echo CHtml::normalizeUrl(['order/stripeOrders']); ?>" class="btn btn-secondary">← Back to Orders</a>
</div>