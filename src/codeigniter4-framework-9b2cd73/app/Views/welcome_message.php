<!--Setup document type and HTML formatting-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Use some basic html setup information -->
        <meta charset="utf-8"> <!--Character encoding-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Use device width so that it will be centred whatver device is being used
         + if the window size is being changed -->
        <!-- Add an icon for when someone is viewing the page -->
        <link rel="icon" href="testicon.png"> <!-- MAKE SURE TO CHANGE THIS HAHA A SMILING FACE IS NOT THE BEST IDEA RIGHT NOW -->
        <link rel="apple-touch-icon" href="/testicon.png">
        <!-- This will be what is displayed when the tab is open (ie google when you are on google)-->
        <title>Menu Ordering System</title> <!--This will be changed in the last iteration when a name is chosen for the application-->

        <link rel="stylesheet" href="styles.css">
    
        <!--<link rel="stylesheet" href="styles.css"> --> <!--********Not sure this is necessary, will evaluate later********-->
        <!-- Setup style for the header bar on the webpage -->
        <style>
            /* CSS for the template styles can go here */
            /* This is the template for the body of the page, this also has an effect on the spacing and could leave white areas
            around the header if it is not used, just from some testing */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                /* I cannot find another way to remove the missing areas around the
                top and bottom of the header if I do not include this */
            }
            /* Styles for the body, header and footer can go in here */
            /* Header style */
            header{
                background-color: aqua;
                color: black;
                padding: 10px;
                text-align: center;
                font-family: 'Franklin Gothic Medium';
                font-size: large;
            }
            /* Now we want to setup a navigation bar. This will start off very basic and simple, but the end goal is to have this
            integrated into the header and to have this section link to the login, signup, home and review pages, although the
            review page may be integrated to the footer or the bottom of the page */
            nav {
                background-color: aquamarine;
                color:red;
                padding: 15px;
                display: flex; /* use a flexbox to allow items to be on both the left and the right... */
                justify-content: space-between; /* align with a space between */
            }

            /* need a second nav component */
            nav a {
                color:purple;
                padding: 0 10px;
            }

            /* Now we will add a template for the FOOTER */
            footer{
                background-color: yellow;
                color:orange;
                padding:10px; /* Tried experimenting with 20 pixels, but for the small amount of content
                inside it felt better to use 10px */
                position:absolute; /* will not change position */
                bottom:0; /* at the bottom of the page */
                width:100%;
            }
            .home{
                /* The home button will need to be called here first so that it won't change the rounded features of the login and register buttons */
                padding: 10px 15px; /* Make the boxes rectangular */
                text-decoration: none;
                background-color:olive; /* Picked this by scrolling through suggested colours on visual studio and it looks good */
                color: white; /* Text colour (white looks best) */
                border:2px solid black;
            }
            /* testing CSS to make the login + signup buttons */
            .login, .signup {
                padding: 10px 15px; /* Make the boxes rectangular */
                text-decoration: none; /* Remove the hyperlink underlining that is still present on the home button/link */
                border:1.5px solid black; /* add a 1.5 px wide solid black outline to the box to make it pop */
                border-radius: 10px; /* Round off the corners, tried with 5 and 15 but 10 looks best */
                /* adjust font size and other parameters if needed */
                font-size: 15px; /* 15 is a good size and translates well to different window sizes */
                
            }
            .login {
                right: 115px; /* Adjusted right position for login button */
                background-color: rgb(33, 192, 33); /* Picked this colour by hand using visual studio code */
                color: white; /* Text colour (white looks best) */
            }
            .signup {
                right: 20px; /* Leaves a small gap between the login button */
                background-color:dodgerblue; /* Picked this by scrolling through suggested colours on visual studio and it looks good */
                color: white; /* Text colour (white looks best) */
            }


        </style>
      </head>
      
      <body>
        <header>
            <h1>Restaurant Ordering System</h1>
        </header>
        <nav>
            <!-- Divide the navbar into two sections -->
            <div>
                <!-- If I use a before this it will make the text the same colour and format
                as the right hand side-->
                <a href="codeigniter4-framework-9b2cd73\app\Views\index.php" class="home">Home</a><!--Call the home button using the class created before-->
            </div>
            <div>
                <a href="login.php" class="codeigniter4-framework-9b2cd73\app\Views\login">Login</a> |<!--This will leave a | in red between the buttons, this will stay for now as
                it is good for testing and visual purposes-->
                <a href="signup.php" class="codeigniter4-framework-9b2cd73\app\Views\signup">Register</a>
            </div>
                
        </nav>
        <h1>This is not part of the template - testing purposes only</h1>
        <script src="scripts.js"></script>
      </body>
      <footer>
        &copy; 2024 My Website. Created by *Fan Yang*. <!-- Change this to be whatever looks best, good to just have something basic for now-->
      </footer>


</html>
