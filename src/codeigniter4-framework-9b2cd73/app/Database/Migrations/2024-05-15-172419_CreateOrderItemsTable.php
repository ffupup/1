<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up()
    { // this database table stores the information about the order items and the number of each item ordered, as well as their price
        $this->forge->addField([ // add required fields for the orders database table
            'order_items_id' => [ 
                //PRIMARY KEY - the identifier for the items in the order, auto-generated integer with auto increment
                'type' => 'INT', // integer
                'constraint' => 20, // no more than 20 characters long
                'unsigned' => TRUE, // unsigned, starts from 0
                'auto_increment' => TRUE,
            ],


            'order_id' => [
                // order ID will be given when the order is placed in the other database table
                'type' => 'INT', // Integer, will only need to be a number
                'constraint' => 20, // should not exceed 20 characters
                'unsigned' => TRUE, // unsigned, starts from 0
                //'auto_increment' => TRUE, // work from 1 and count upwards


            ],

            'item_id' => [
                // item id stored as an int no longer than 20 characters
                'type' => 'INT', // an integer
                'constraint' => 20, // no more than 20 characters
            ],

            'item_price' => [
                // stores the price of each item
                'type' => 'DECIMAL', // decimal, allows to show as a dollar value
                'constraint' => '10,2', // 10 digits long, with an accuracy of 2 decimals, will round if above this
                
            ],

            'order_quantity' => [
                // stores information about the quantity of an item ordered
                // will be an integer no longer than 10 digits. 
                //Realistically, however, a user should not order more than 50 of an item in usual business practices
                'type' => 'INT',
                'constraint' => 10,

            ],

        ]);
        $this->forge->addKey('order_items_id', TRUE); // add primary key (order_items_id)
        //$this->forge->addForeignKey('order_id', 'orders', 'CASCADE');

        $this->forge->addForeignKey('order_id', 'orders', 'order_id', false, 'CASCADE'); // add the order ID as a foreign key so that it can be called in views and functions
                                                                                         // with the corresponding order and not individually
        $this->forge->createTable('order_items'); // create a table called order_items which stores information about order specifics
    }

    // function to drop the order table
    public function down()
    {
        $this->forge->dropTable('order_items'); // drop the table
        
    }
}

