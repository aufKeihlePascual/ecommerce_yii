<?php
/* @var $this CartController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array('Shopping-Cart');
?>

<h2>Your Shopping Cart</h2>

<?php if (empty($cartItems)): ?>
    <p>You currently have no items in the cart.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo CHtml::encode($item->product->name); ?></td>
                    <td><?php echo $item->quantity; ?></td>
                    <td>₱<?php echo number_format($item->product->price, 2); ?></td>
                    <td>₱<?php echo number_format($item->product->price * $item->quantity, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><strong>Subtotal:</strong> ₱<?php echo number_format($subtotal, 2); ?></p>
<?php endif; ?>
