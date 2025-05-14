<?php $this->pageTitle = 'Payment Successful'; ?>

<div class="payment-status-container">
    <h2 class="text-success"><i class="fa-solid fa-check-circle"></i> Payment Successful</h2>
    <p>Thank you for your purchase. Your Order (Ref No. <strong><?php echo CHtml::encode($networkTransactionId); ?></strong>) has been confirmed and your cart has been cleared.</p>

    <?php if (!empty($items)): ?>
        <div class="checkout-summary">
            <h4>Order Summary</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo CHtml::encode($item['name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₱<?php echo $item['unit_price']; ?></td>
                            <td><strong>₱<?php echo $item['total']; ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right total-amount"><strong>Grand Total = <span>₱ <?php echo $grandTotal; ?></span></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>

    <a href="<?php echo CHtml::normalizeUrl(['site/index']); ?>" class="btn btn-success">Back to Home</a>
</div>
