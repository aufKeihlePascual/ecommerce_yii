<?php
/* @var $this CartController */
/* @var $cartItems array */
/* @var $subtotal float */

$this->breadcrumbs = array('Shopping Cart');
?>

<section id="shopping-cart" class="section-p1">
    <div class="section-header">
        <h2>Your Shopping Cart</h2>
    </div>

    <?php if (empty($cartItems)): ?>
        <p class="empty-cart-message">You currently have no items in the cart.</p>
    <?php else: ?>
        <div class="cart-table-wrapper">
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
                            <td>₱<?php echo number_format($item->product->price, 2); ?></td>
                            <td>₱<?php echo number_format($item->product->price * $item->quantity, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <h3>Order Summary</h3>
                <p><strong>Subtotal:</strong> ₱<?php echo number_format($subtotal, 2); ?></p>
                <button class="btn btn-primary checkout-btn">Proceed to Checkout</button>
            </div>
        </div>
    <?php endif; ?>
</section>
