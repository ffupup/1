<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>
<?php if (!empty($menus)): ?>
    <h2>Selected Items</h2>
    <ul>
        <?php foreach ($menus as $menuItem): ?>
            <?php if (isset($menuItem['order_quantity']) && $menuItem['order_quantity'] > 0): ?>
                <li>
                    Item: <?= $menuItem['item_name'] ?>,
                    Quantity: <?= $menuItem['order_quantity'] ?>,
                    Total Price: <?= $menuItem['item_price'] * $menuItem['order_quantity'] ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <p>Total Price: <?= $final_price ?></p>
<?php else: ?>
    <p>No items selected.</p>
<?php endif; ?>
<form method="post" action="<?= base_url('orders/place_order') ?>">
    <!-- Include any hidden fields needed for the order data -->
    <input type="hidden" name="table_name" value="<?= $table_name ?>">
    <input type="hidden" name="customer_ordering_id" value="<?= $customer_ordering_id ?>">
    <!-- Add hidden fields for each order item with non-zero quantity -->
    <?php foreach ($menus as $menuItem): ?>
        <?php if (isset($menuItem['order_quantity']) && $menuItem['order_quantity'] > 0): ?>
            <input type="hidden" name="order_items[<?= $menuItem['item_id'] ?>]" value="<?= $menuItem['order_quantity'] ?>">
        <?php endif; ?>
    <?php endforeach; ?>
    <!-- Add other hidden fields for additional data if needed -->
    <button type="submit" class="btn btn-success">Confirm Order</button>
</form>

<?= $this->endSection() ?>
