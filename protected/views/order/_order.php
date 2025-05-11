<tr>
    <td><?php echo CHtml::encode($data->email); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo (int)$data->itemCount; ?></td>
    <td><?php echo date('F j, Y', strtotime($data->created_at)); ?></td>
    <td>
        <span class="status <?php echo strtolower($data->status); ?>">
            <?php echo ucfirst($data->status); ?>
        </span>
    </td>
    <td>₱ <strong><?php echo number_format($data->total, 2); ?></strong></td>
    <td>
        <a href="https://dashboard.stripe.com/test/payments/<?php echo CHtml::encode($data->id); ?>" class="view-btn" target="_blank">View</a>
    </td>
</tr>
