<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>


<!-- Display account registered successfully. This could be flashdata -->
<h1>Account registered successfully</h1>
<!--script src="scripts.js"></script--><!--This is not being used currently, it is just a placeholder in case there is any js or other thing to be called, we can change it later as required-->

<div>
<!-- TEST TO DISPLAY IF THEY GOT ADDED TO THE DATABASE -->
    <a href="<?= base_url('users'); ?>" class="users">View Users (DEBUG OPTION)</a>
</div>
<div>
    Would you like to sign into your account?
</div>

<?= $this->endSection() ?>