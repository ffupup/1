<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>

<div class="menu-box">
    <h2>Create New Menu Item</h2>
    <!-- need to use the post method and action it to the function/register--> 
    <form method="post" action="<?= base_url('make_item'); ?>">
        <!-- label saying password (field goes underneath) -->
        <label for="item_name">Item Name:</label><br> 
        <!-- username field -->
        <input type="text" id="item_name" name="item_name" required><br>
        <!-- label stating password where you enter password -->
        <label for="item_category">Item Category:</label><br>
        <!-- password entry field -->
        <input type="item_category" id="item_category" name="item_category" required> <br><br>
        <!-- label for item price -->
        <label for="item_price">Item Price</label><br>
        <!-- Text field for confirming password -->
        <input type="item_price" id="item_price" name="item_price" required><br><br>
        <!-- Submit button -->
        <input type="submit" value="Create Item">
    </form>

</div>

<?= $this->endSection() ?>