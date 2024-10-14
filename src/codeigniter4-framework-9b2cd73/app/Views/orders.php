<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>
<div class="mb-4">
        <a href="<?= base_url('orders/20') ?>" class="btn btn-success">Test URL</a>

        

    </div>
<h2>Menu Items</h2>

<!-- Check if there are any menu items -->
<?php if (!empty($menus)): ?>
    <!-- Group items by item_category -->
    <?php
    $groupedItems = [];
    foreach ($menus as $menu) {
        $category = $menu['item_category'];
        $groupedItems[$category][] = $menu;
    }
    ?>


<!-- Display items in boxes labelled by their item category -->
<form action="<?= base_url('orders/make_order') ?>" method="post">    
    <?php foreach ($groupedItems as $category => $items): ?>
        <div class="card mb-1">
            <div class="card-header"><?= $category ?></div>
            <div class="card-body">
                <div class="row">
                    <!-- loop to view each item in each category and display them to the ordering page -->
                    <?php foreach ($items as $item): ?>
                        <div class="card menu_item">
                            <div class="card">
                                <!-- Display item image -->
                                <img src="<?= $item['image_url'] ?>" class="card-img-top" alt="<?= $item['image_url'] ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['item_name'] ?></h5>
                                    <!-- input to select quantity of an item in an order -->
                                    <input type="number" name="order_items[<?= $item['item_id'] ?>]" value="0" min="0" onchange="CartInformation()">
                                    <!-- hidden input to track the item id of the menu item that is selected so that this information is also collected -->
                                    <input type="hidden" name="item_id[]" value="<?= $item['item_id'] ?>"> 
                                    <!-- item price is also displayed and gathered -->
                                    <p class="card-text">$<?= $item['item_price'] ?></p>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <input type="hidden" name="table_name" value="<?= $table_identifier ?>">
    <button type="submit" class="btn btn-success">Confirm Order</a>
</form>
<?php else: ?>
    <!-- If no items found -->
    <p>No menu items available.</p>
<?php endif; ?>


<!-- JAVASCRIPT TO MANAGE THE ORDER CART -->
<script>
    // create a function to update the cart

    function CartInformation(){
        // this function needs to determine the total price and number of items selected
        // start by defining the sum of cost and items
        let sumCost = 0;
        let sumItems = 0;
        // query the document form information to get menu items and query the cost and number of items
        document.querySelectorAll('.menu_item').forEach(item => {
            let number = parseInt(item.querySelector('input[type="number"]').value);
            let cost = parseFloat(item.querySelector('p').textContent.replace('$', ''));
            // add cost and number of items to display in cart
            sumCost += cost * number;
            sumItems += number;
            
            });

        // now update the cart total - NEED TO USE BACK TICKS FOR THIS - had issues with not using them
        document.getElementById('cart-total').innerHTML = `
            <p>Number of Items: ${sumItems}</p>
            <p>Total Cost: $${sumCost.toFixed(2)}</p>
            <button onclick="showcart()">View Cart</button>
        `;
    }
    // check for changes in the value fields of the form
        document.querySelectorAll('input[type="number"]').forEach(input => {
            // add an event listener to query for changes in the input fields
            input.addEventListener('change', CartInformation);
        });
    


</script>


<!-- Cart total -->
<div id="cart-total">
    <!-- uses javascript to update as it is changed -->
    
    <p>Number of Items Items: 0</p>
    <p>Total Cost: $0.00</p>
    <!-- Button to show the cart information -->
    <button onclick="showCart()">View Cart</button>
</div>
<script>
    // Initialise the cart on loading the page
    CartInformation();
</script>
<?= $this->endSection() ?>
