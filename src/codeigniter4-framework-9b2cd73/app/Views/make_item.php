<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>


<!-- TEST TO DISPLAY IF THEY GOT ADDED TO THE DATABASE. obviously the final product would not show everyone's usernames and passwords-->
<h1>Item created successfully</h1>
<!--script src="scripts.js"></script--><!--This is not being used currently, it is just a placeholder in case there is any js or other thing to be called, we can change it later as required-->
<div>
<!-- TEST TO DISPLAY IF THEY GOT ADDED TO THE DATABASE -->
    <a href="<?= base_url('menu_list'); ?>" class="menu">View Menu</a>
</div>



<?= $this->endSection() ?>