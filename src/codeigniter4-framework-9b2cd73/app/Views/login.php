<?= $this->extend('base_template') ?>


<?= $this->section('content') ?>

    <!--Basic Login Form from CSS stylesheet (named login-box) -->
    <div class="login-box">
        <h2>Login to MenuScanOrder</h2>
        <!-- Create a form which sends an action to /login with the method == POST (important that this is capitalised for some reason) -->
        <form action="<?= base_url('/login');?>" method="POST">
        <!-- Add a CSRF field -->
        <?= csrf_field() ?>    
        <label for="username">Username:</label><br> <!-- Label stating "Username:" -->
            <input type="username" id="username" name="username" required><br> <!-- Text field for entering username, this will accept all text (not sure if it accepts special characters but can test this easily) -->
        <label for="password">Password:</label><br> <!-- Label stating Password: -->
            <input type="password" id="password" name="password" required><br><br><!-- Text field for entering the password into the form -->
            <input type="submit" value="Login"> <!-- Button to submit the form. Right now this has no functionality -->
        </form>
        <!-- Use the formatting for additional signin on this box (CURRENTLY NON-FUNCTIONAL) -->
        
    </div>

<?= $this->endSection() ?>
