<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>

<h2>Menu Items</h2>
<?php if (session()->get('user_type') === 'Business'): ?>
    <!-- add item -->
    <div class="mb-4">
        <a href="<?= base_url('menu_list/additem') ?>" class="btn btn-success">Add Item</a>

        <a href="<?= base_url('add_table') ?>" class="btn btn-success">Add Table</a>

        <a href="<?= base_url('table_list') ?>" class="btn btn-success">View Tables</a>        
    </div>


    <!-- Search form -->
    <form method="get" action="<?= base_url('menu_list'); ?>" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search_value" class="form-control" placeholder="Search" value="<?= $searchValue ?>">
            </div>
            <div class="col-md-4">
                <select name="search_field" class="form-select">
                    <option value="item_id" <?= $searchField === 'item_id' ? 'selected' : '' ?>>ID</option>
                    <option value="item_name" <?= $searchField === 'item_name' ? 'selected' : '' ?>>Item Name</option>
                    <option value="item_category" <?= $searchField === 'item_category' ? 'selected' : '' ?>>Item Category</option>
                    <option value="item_price" <?= $searchField === 'item_price' ? 'selected' : '' ?>>Item Price</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Search Menu</button>
            </div>
        </div>
    </form>

    <!-- Group items by item_category -->
    <?php
    $groupedItems = [];
    foreach ($menus as $menu) {
        $category = $menu['item_category'];
        $groupedItems[$category][] = $menu;
    }
    ?>

    <!-- Display items in boxes labelled by their item category -->
    <?php foreach ($groupedItems as $category => $items): ?>
        <div class="card mb-4">
            <div class="card-header"><?= $category ?></div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($items as $item): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <!-- Display item image -->
                                <img src="<?= $item['image_url'] ?>" class="card-img-top" alt="<?= $item['item_name'] ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['item_name'] ?></h5>
                                    <p class="card-text">$<?= $item['item_price'] ?></p>
                                    <a href="<?= base_url('menu_list/update/' . $item['item_id']) ?>" class="btn btn-primary">Update</a>
                                    <a href="<?= base_url('menu_list/delete/' . $item['item_id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this item?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
    <?php if (!session()->has('user_type')): ?>
        <p>Insufficient permissions. Please log in and try again.</p>
    <?php else: ?>
        <p>Insufficient permissions. This page is for businesses only.</p>
    <?php endif; ?>
    <a href="<?= base_url('/home'); ?>" class="home">Return Home</a>


<?php endif; ?>
<?= $this->endSection() ?>