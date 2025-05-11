<div id="shopping-cart-table" class="cart-table-wrapper">
    <table class="cart-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Details</th>
                <th>Quantity</th>
                <th>Item Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td class="cart-thumbnail">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/products/' . CHtml::encode($item->product->image); ?>" alt="<?php echo CHtml::encode($item->product->name); ?>">
                    </td>
                    <td class="cart-info">
                        <strong><?php echo CHtml::encode($item->product->name); ?></strong><br>
                        <span class="cart-description"><?php echo CHtml::encode($item->product->description); ?></span>
                    </td>
                    <td>
                        <div class="cart-qty-controls">
                            <button class="qty-btn page-cart-btn" data-action="decrease" data-id="<?php echo $item->product_id; ?>">–</button>
                            <span class="cart-qty"><?php echo $item->quantity; ?></span>
                            <button class="qty-btn page-cart-btn" data-action="increase" data-id="<?php echo $item->product_id; ?>">+</button>
                        </div>
                    </td>
                    <td>₱ <?php echo number_format($item->product->price, 2); ?></td>
                    <td>₱ <?php echo number_format($item->product->price * $item->quantity, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="cart-summary-wrapper">
        <div class="cart-summary">
            <h3>Subtotal:<strong> ₱ <?php echo number_format($subtotal, 2); ?></strong></h3>
        </div>
        
        <?php if (!empty($cartItems)): ?>
        <div class="checkout-button-wrapper">
            <form method="post" action="<?php echo CHtml::normalizeUrl(['payment/checkout']); ?>">
                <?php echo CHtml::hiddenField(Yii::app()->request->csrfTokenName, Yii::app()->request->csrfToken); ?>
                <button class="btn btn-primary checkout-btn" type="submit">Proceed to Checkout</button>
            </form> 
        </div>
        <?php endif; ?>
    </div>

</div>