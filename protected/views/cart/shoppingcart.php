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
        <div id="shopping-cart-table">
            <?php $this->renderPartial('_cartTable', array('cartItems' => $cartItems, 'subtotal' => $subtotal)); ?>
        </div>
    <?php endif; ?>
</section>
