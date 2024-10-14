<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>




<!-- We can copy a lot of the information from the login page to create the registration page -->
<div class="register-box">
    <h2>Register to MenuScanOrder</h2>
    <!-- need to use the post method and action it to the function/register--> 
    <form method="post" action="<?= base_url('register'); ?>">
        <!-- label saying password (field goes underneath) -->
        <label for="username">Username:</label><br> 
        <!-- username field -->
        <input type="text" id="username" name="username" required><br>
        <!-- label stating password where you enter password -->
        <label for="password">Password:</label><br>
        <!-- password entry field -->
        <input type="password" id="password" name="password" required> <br><br>
        <!-- User Type (dropdown menu, this will look much better in the final copy)    -->
        <label for="user_type">I am a:</label><br>
        <select name="user_type" id="user_type">
            <option value="Customer">Customer</option>
            <option value="Business">Business</option>
            <option value="Admin">Admin</option>
        </select><br><br>
    <!-- <label for="password-confirm">Confirm Password</label><br> Password confimation, will be added for the final version -->
       <!-- <input type="password" id="password-confirm" name="password_confirm"><br><br> -->
        <!-- Submit button -->
        <input type="submit" value="Register">
    </form>
    <!-- This section will be functional in the future -->
    <div class="additional-register">
        <a href="<?= base_url('login'); ?>">Already have an account?</a>
        
    </div>
</div>

<?= $this->endSection() ?>