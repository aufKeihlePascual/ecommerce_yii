<?php $this->pageTitle = 'Order Details'; ?>

<div class="order-details-container">
    <div class="order-details-header">
        <h2>Order Details</h2>
        <p>Reference Number: <strong><?php echo CHtml::encode($paymentIntentId); ?></strong></p>
    </div>

    <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
            <div class="order-summary-card">
                <img src="<?php echo isset($item['image']) ? CHtml::encode($item['image']) : '/ecommerce/images/default-product.png'; ?>" alt="Product image">
                <div class="order-summary-info">
                    <h4><?php echo CHtml::encode($item['name']); ?></h4>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                    <p class="order-summary-price">₱<?php echo $item['unit_price']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="order-total-footer">
            Grand Total: ₱<?php echo $grandTotal; ?>
        </div>
    <?php endif; ?>

    <a href="<?php echo CHtml::normalizeUrl(['order/stripeOrders']); ?>" class="btn btn-primary mt-4">Back to Orders</a>
</div>