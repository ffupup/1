<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderTable extends Migration
{
    public function up()
    { // it was decided to use a separate table for the order items and add the information as foreign keys to improve 
        // the speed and reduce potential issues with the data storage and retrievals.
        $this->forge->addField([ // add required fields for the orders database table
            'order_id' => [ 
                //PRIMARY KEY - the identifier for a specific order, auto-generated integer with auto increment
                'type' => 'INT', // integer
                'constraint' => 20, // no more than 20 characters long
                'unsigned' => TRUE, // unsigned, starts from 0
                'auto_increment' => TRUE, // work from 1 and count upwards
            ],


            'user_id' => [
                // user ID, which will be recieved from session data and the unique QR code link when a customer has scanned the QR code
                // barcode and will allow the user to be assigned based on their table where they can see the previous order and the cost until
                // the restaurant marks it as completed, in which case it will be no longer accessible to the user
                'type' => 'INT', // Integer, will only need to be a number
                'constraint' => 20, // should not exceed 20 characters
                


            ],
            'business_id' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            
            'customer_ordering_id' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            
            'table_name' => [
                // name for the table, to be used so that the ID does not get used as the name
                'type' => 'VARCHAR', // VARCHAR
                'constraint' => 10, // no more than 10 characters
            ],

            'order_status' => [
                // this will be used by the restaurant employess to mark an order as either completed or active
                // This will allow for the advanced feature of allowing the business to mark an order as completed.
                'type' => 'ENUM', // alphanumeric - allows letters and numbers
                'constraint' => ['Active', 'Complete'], // order can only be active or complete
                
            ],

        ]);
        $this->forge->addKey('order_id', TRUE); // add primary key (order_id)
        $this->forge->createTable('orders'); // create a table called orders which stores important information about the orders
    }

    // function to drop the order table
    public function down()
    {
        $this->forge->dropTable('orders'); // drop the table
        
    }
}

