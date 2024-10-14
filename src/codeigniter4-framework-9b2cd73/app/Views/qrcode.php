<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>


<?php if (session()->get('user_type') === 'Business'): ?>
    <form method="post" action="<?= base_url('qrcode'); ?>">
        <!-- label stating password where you enter password -->
        <label for="table_name">Table number:</label><br>
        <!-- input form for the table number -->
        <input type="table_name" id="table_name" name="table_name" required> <br><br>
        <input type="submit" value="Create">
    </form>

<?php endif; ?>

<!-- If user_type is customer, return home -->
<?php if (session()->get('user_type') === 'Customer'): ?>
    Insufficient permissions. Return home? <a href="<?= base_url('/home'); ?>" class="home">Home</a>

<?php endif; ?>

<!-- If the user is an admin, show page to return home -->
<?php if (session()->get('user_type') === 'Customer'): ?>
    Insufficient permissions. Return home? <a href="<?= base_url('/home'); ?>" class="home">Home</a>

<?php endif; ?>

<?= $this->endSection() ?>