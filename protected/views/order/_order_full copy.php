<!-- <table class="order-table">
    <thead>
        <tr>
            <th>Email</th>
            <th>Customer Name</th>
            <th>Items</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo CHtml::encode($row->email); ?></td>
                <td><?php echo CHtml::encode($row->name); ?></td>
                <td><?php echo (int)$row->itemCount; ?></td>
                <td><?php echo date('F j, Y', strtotime($row->created_at)); ?></td>
                <td>
                    <span class="status <?php echo strtolower($row->status); ?>">
                        <?php echo ucfirst($row->status); ?>
                    </span>
                </td>
                <td>₱ <strong><?php echo number_format($row->total, 2); ?></strong></td>
                <td>
                    <a href="https://dashboard.stripe.com/test/payments/<?php echo CHtml::encode($row->id); ?>" class="view-btn" target="_blank">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table> -->
