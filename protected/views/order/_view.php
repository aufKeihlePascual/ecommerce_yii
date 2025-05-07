<?php
/* @var $this OrderController */
/* @var $data Order */
?>

<div class="view">

<h3>Order #<?php echo $data->id; ?> (<?php echo $data->created_at; ?>)</h3>
<ul>
    <?php foreach($data->orderItems as $item): ?>
        <li>
            <?php echo $item->product->name; ?> — 
            Qty: <?php echo $item->quantity; ?> — 
            ₱<?php echo number_format($item->price, 2); ?>
        </li>
    <?php endforeach; ?>
</ul>

</div>