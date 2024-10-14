<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home route
$routes->get('/', 'Home::index');

$routes->get('/home', 'Home::home');

//$routes->get('/login', 'Home::login'); REMOVED DUE TO OVERLAP WITH AUTHCONTROLLER

// Route to signup page using public function signup in home controller
$routes->get('/signup', 'Home::signup');

// Route to post for register page using function register in UserController
$routes->post('/register', 'UserController::register');

//Route to get for users page using function index in usercontroller
$routes->get('/users', 'UserController::index');

// Route to get menu using function menu in home controller
$routes->get('/menu', 'Home::menu');

// route to get menu list using the index_menu function in the menucontroller
$routes->get('/menu_list', 'MenuController::index_menu');

// route to post making an item using the make_item function in the menu controler
$routes->post('/make_item', 'MenuController::make_item');

//Route for the admin to view all menu items by all users using the admin_menu in the menucontroller
$routes->get('/menu_list_test', 'MenuController::admin_menu');

//unused, for testing only
$routes->post('/menu_list_test', 'MenuController::index_menu');

// Routers for menu item forms
$routes->get('/menu_list/(:num)', 'MenuController::index_menu/$1');

//Route to add item form
$routes->get('/menu_list/additem', 'MenuController::additem');

// Route for display Edit Menu Item Form for existing item
$routes->get('/menu_list/update/(:num)', 'MenuController::edititem/$1');

// Route for display Edit Menu Item Form for existing item
$routes->post('/menu_list/update/(:num)', 'MenuController::update/$1');


//Route for saving the update on new menu item
$routes->post('/menu_list/saveitem', 'MenuController::saveitem');

//Route for calling the delete button
$routes->get('/menu_list/delete/(:num)', 'MenuController::delete/$1');



// Routes for and login, using get and post with the AuthController function signin

$routes->match(['get','post'], '/login', 'AuthController::signin');

// Route for logout
$routes->get('/logout', 'AuthController::logout');


// Route for User Dashboard
$routes->get('/dashboard','DashController::index');



// Routes for QR codes
// post route

// route for making table
$routes->post('/add_table', 'TableController::makeTable');
$routes->get('/add_table', 'Home::add_table');
$routes->post('/qrcode/(:num)', 'TableController::generateQRCode/$1');
//$routes->get('/qrcode/(:num)', 'Home::qrcode/$1');
// viewing table
$routes->get('/table_list', 'TableController::index_qr');
//Route for calling the delete button for table
$routes->get('/table_list/delete/(:num)', 'TableController::delete/$1');

// Routes for the ordering pages and system
// get route for ordering
$routes->get('/orders/(:num)', 'OrderController::index_menu/$1');

// post route for ordering
//$routes->post('/orders/(:num)', 'OrderController::update/$1');
$routes->get('orders/make_order', 'OrderController::make_order');

// route to verify an order
$routes->post('orders/make_order', 'OrderController::make_order');

// route to place the order into the system
$routes->post('orders/place_order', 'OrderController::place_order');
$routes->get('orders/place_order', 'OrderController::place_order');

// routes for viewing active orders
$routes->get('order_list', 'OrderController::index_orders');

// post route for changing order status to completed
$routes->post('order_list/update/(:num)', 'OrderController::update/$1');

// routes for admin functions on users
//Route for calling the delete button on a user
$routes->get('/users/delete/(:num)', 'UserController::delete/$1');
// post route for updating user name may not be functional
$routes->post('users/update/(:num)', 'UserController::update/$1');
// get route for admin order list
$routes->get('admin_order_list', 'OrderController::admin_index_orders');