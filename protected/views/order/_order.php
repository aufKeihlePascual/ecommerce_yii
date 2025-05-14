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
    </td>
</tr>
