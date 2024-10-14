<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>

<h2 class="text-center mt-3">All Orders</h2>

<!-- Display orders and related item quantities -->
<div class="row">
    <?php foreach ($orders as $order): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Order ID: <?= $order['order_id'] ?></div>
                <div class="card-body">
                    <h5 class="card-title">Table ID: <?= $order['table_name'] ?></h5>
                    
                    <p class="card-text">Order Status: <?= $order['order_status'] ?></p>
                    <ul>
                        <!-- Display related item quantities -->
                        <?php $totalPrice = 0; ?>
                        <?php foreach ($order['items'] as $item): ?>
                            <li>
                                Item: <?= $item['item_name'] ?>,
                                Quantity: <?= $item['order_quantity'] ?>,
                                Items Price: $<?= number_format($item['item_price'] * $item['order_quantity'], 2) ?>
                            </li>
                            <?php $totalPrice += $item['item_price'] * $item['order_quantity']; ?>
                        <?php endforeach; ?>
                    </ul>
                    <!-- total price of the order -->
                    <div class="text-center mt-3">
                        Order Total Price: $<?= number_format($totalPrice, 2) ?>
                    </div>
                    <!-- Button to change order status  (centered at the bottom of the box!) -->
                    <!-- use if logic to only include this button on an order that is currently active -->
                    <?php if ($order['order_status'] === 'Active'): ?>
                    <div class="text-center mt-3">
                        <form method="post" action="<?= base_url('order_list/update/' . $order['order_id']) ?>">
                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                            <button type="submit" class="btn btn-primary">Order Completed</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>