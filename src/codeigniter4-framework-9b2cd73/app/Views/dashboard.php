<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>
<!-- Show a message to display currently active user's username and usertype -->
<p>You are logged in as: <?= $username ?> You are a: <?= $user_type ?></p>


<!--Option to make new item. if UserType is a business Needs if logic -->
<?php if (session()->get('user_type') === 'Business'): ?>
    Want to make a new menu item? <a href="<?= base_url('menu'); ?>" class="home">Create a New Menu Item</a>


<?php endif; ?>

<!--Option to ?create a new order? WIP if UserType is a business Needs if logic -->
<?php if (session()->get('user_type') === 'Customer'): ?>
    <h1 class="text-center mt-3"> Please Scan QR Code to make an order </h1>
    <!-- This might become a function to view the signed in customer's orders instead, as a list/table -->


<?php endif; ?>

<?= $this->endSection() ?>