<!DOCTYPE html>
<html lang="en">
<head>
        <!-- Use some basic html setup information -->
        <meta charset="utf-8"> <!--Character encoding-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Use device width so that it will be centred whatver device is being used
         + if the window size is being changed -->
        <!-- Add an icon for when someone is viewing the page -->
        <link rel="icon" href="<?= base_url('/testicon.ico'); ?>">
         <!-- MAKE SURE TO CHANGE THIS CURRENTLY USING ONE I FOUND ONLINE (above) -->


        <!-- This will be what is displayed when the tab is open (ie google when you are on google)-->
        <title>MenuScanOrder</title> <!--This will be changed in the last iteration when a name is chosen for the application-->
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <link rel="stylesheet" href="<?= base_url('styles/mystyle.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('styles/registerstyle.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('styles/loginstyle.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('styles/css/bootstrap.min.css'); ?>">
        
    </head> 
    <script src="scripts.js"></script>
    <body>
         <!-- The header is currently using an image I drew by hand -->
        <header>
            <h1><img src="<?= base_url('/menuscanorderhero.png')?>"alt="MenuScanOrder Logo"></h1>
        </header>
        <nav>
            <!-- Divide the navbar into two sections -->
            <div>
                <!-- If I use a before this it will make the text the same colour and format
                as the right hand side-->
                <a href="<?= base_url('/home'); ?>" class="home">Home</a><!--Call the home button using the class created before-->
                <!-- Check if the usertype is 'Business' so they can make orders, or 'Admin' (for debugging purposes) -->
                <!-- An if function is sufficient for this task -->
                <?php if (session()->get('user_type') === 'Business'): ?>
                    <!-- Call the menu list page with the formatting of the home button -->
                    <a href="<?= base_url('menu_list'); ?>" class="home">My Menu Items</a>
                    <!-- Call the orders list page with the formatting of the home button -->
                    <a href="<?= base_url('order_list'); ?>" class="home">Customer Orders</a>
                <?php endif; ?>
                <!-- Display an admin search menu to view all menu items -->
                <?php if (session()->get('user_type') === 'Admin'): ?>
                    <!-- Call the admin page's special test menu list which will display all items -->
                    <a href="<?= base_url('menu_list_test'); ?>" class="home">All Menu Items</a>
                    <!-- Call the admin page's order list which will display all items -->
                    <a href="<?= base_url('admin_order_list'); ?>" class="home">All Orders</a>
                    <!-- View Users Page with format of home button, for admin users only -->
                    <a href="<?= base_url('users'); ?>" class="home">View Users</a>
                <?php endif; ?>
                <!-- Check if user type is Customer AND ADMIN FOR ADMIN PURPOSES -->
                <?php if (session()->get('user_type') === 'Customer'|| session()->get('user_type') === 'Admin'): ?> 

                <?php endif; ?>

  
            </div>
            <div>
                <!-- IF statement to see if there is a user currently logged in, if not, display the login and register buttons -->
                <?php if (!session()->get('logged_in')): ?> 
                    <!-- Display login button -->
                    <a href="<?= base_url('login'); ?>" class="login">Login</a> |
                    <!-- Display Sign Up button -->
                    <a href="<?= base_url('signup'); ?>" class="signup">Register</a> <!-- Show register button if not logged in -->
                <?php endif; ?>
                <!-- If there is a user currently logged in, display buttons for logout and for the dashboard -->
                <?php if (session()->get('logged_in')): ?> 
                    <!-- Button to go to the user dashboard -->
                    <a href="<?= base_url('dashboard'); ?>" class="login">User Dashboard</a>
                    <!-- Button linking to function to sign out of active user account -->
                    <a href="<?= base_url('logout'); ?>" class="signup">Logout</a>
                <?php endif; ?>
            </div>
                
        </nav>

        <!--Render content-->
        <main>
        <!-- Display all flashdata messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-warning" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

            <?= $this->renderSection('content') ?> <!--Content placeholder-->
        </main>
        

        
      <!-- Basic Footer information -->
      <footer>
        <p>&copy; 2024 MenuScanOrder. </p> <!-- Change this to be whatever looks best, good to just have something basic for now-->
      </footer>
    </body>


</html>