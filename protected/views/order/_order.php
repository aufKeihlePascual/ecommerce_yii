<tr>
    <td><?php echo CHtml::encode($data->email); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo (int)$data->itemCount; ?></td>
    <td><?php echo date('F j, Y g:i A', strtotime($data->created_at)); ?></td>
    <td>
        <span class="status <?php echo strtolower($data->status); ?>">
            <?php echo ucfirst($data->status); ?>
        </span>
    </td>
    <td>
        <span class="status <?php echo strtolower(trim($data->dispatch_status)); ?>">
            <?php echo ucfirst(trim($data->dispatch_status)); ?>
        </span>
    </td>
    <td id="order-table-total">₱ <strong><?php echo number_format($data->total, 2); ?></strong></td>
    <td>
        <a href="<?php echo CHtml::normalizeUrl(['order/viewOrderDetails', 'session_id' => $data->id]); ?>" class="view-btn">View</a>
         <form action="<?php echo CHtml::normalizeUrl(['payment/markAsShipped', 'session_id' => $data->id]); ?>" method="post" style="margin-top: 5px;">
            <button type="submit" class="normal ship-btn" onclick="return confirm('Mark this order as shipped?');">Ship</button>
        </form>
    </td>
</tr>