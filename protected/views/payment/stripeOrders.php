<section class="section-p1 bg-dark text-light">
    <h2>Live Stripe Orders</h2>

    <table class="order-table">
        <thead>
            <tr>
                <th>Session ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Items</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['created']; ?></td>
                    <td><span class="status"><?php echo $order['status']; ?></span></td>
                    <td>₱<?php echo $order['amount']; ?></td>
                    <td>
                        <ul>
                            <?php foreach ($order['items'] as $item): ?>
                                <li><?php echo $item['quantity'] . '× ' . $item['name'] . ' — ₱' . $item['total']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
