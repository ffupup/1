<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>

<h2>Tables</h2>
<?php if (session()->get('user_type') === 'Business'): ?>
    <!-- navigation -->
    <div class="mb-4">
        <a href="<?= base_url('menu_list') ?>" class="btn btn-success">Return to menu list</a>

        <a href="<?= base_url('add_table') ?>" class="btn btn-success">Add Table</a>

    </div>


    <!-- Search form -->
    <form method="get" action="<?= base_url('table_list'); ?>" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search_value" class="form-control" placeholder="Search" value="<?= $searchValue ?>">
            </div>
            <div class="col-md-4">
                <select name="search_field" class="form-select">
                    <option value="qr_id" <?= $searchField === 'qr_id' ? 'selected' : '' ?>>Table ID</option>
                    <option value="table_name" <?= $searchField === 'table_name' ? 'selected' : '' ?>>Table Name</option>
                    
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Search Menu</button>
            </div>
        </div>
    </form>

    <!-- Display tables in boxes  -->
        <div class="row">
        <?php foreach ($qrs as $qr): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <!-- Display table image -->
                    <img src="<?= $qr['qr_link'] ?>" class="card-img-top" alt="<?= $qr['table_name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title">Table Name: <?= $qr['table_name'] ?></h5>
                        <p class="card-text">Table ID: <?= $qr['qr_id'] ?></p>
                        <!-- Button to generate QR code -->
                        <form method="post" action="<?= base_url('qrcode/' . $qr['qr_id']) ?>">
                          
                            <input type="hidden" name="qr_id" value="<?= $qr['qr_id'] ?>">
                            <button type="submit" class="btn btn-primary">Generate QR Code</button>
                        </form>
                    <a href="<?= base_url('table_list/delete/' . $qr['qr_id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this Table?')">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <?php if (!session()->has('user_type')): ?>
        <p>Insufficient permissions. Please log in and try again.</p>
    <?php else: ?>
        <p>Insufficient permissions. This page is for businesses only.</p>
    <?php endif; ?>
    <a href="<?= base_url('/home'); ?>" class="home">Return Home</a>


<?php endif; ?>
<?= $this->endSection() ?>