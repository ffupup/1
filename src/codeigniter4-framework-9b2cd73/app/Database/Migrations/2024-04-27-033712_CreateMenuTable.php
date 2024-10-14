<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
        // menu_id (INT, PK)
        'item_id' => [ 
            //PRIMARY KEY
            // May need more than this for now, however this functionality is enough for the moment (such as making the 
            // menu item link to a specific restaurant/user for them to not see other restaurants items
            // in this menu)
            'type' => 'INT', // integer
            'constraint' => 20, // no more than 20 characters
            'unsigned' => true, // start from 0
            'auto_increment' => true, // count up one at a time to avoid duplication

        ],
        
        // name (VARCHAR)
        'item_name' =>[
            'type' => 'VARCHAR', // varcahr
            'constraint' => 50, // Could make the constraint higher, it just depends how long the item name will be
                                // for now, using 50 characters seems appropriate
        ],

        // category (VARCHAR) (can use the same settings as the item name just shorter constraint)
        'item_category' => [
            // item category may be changed to be a separate database matched to the user_id,
            // in this case there will be a form to add menu categories and they will be selected
            // through the use of a drop down menu
            'type' => 'VARCHAR', // varchar
            'constraint' => '10', // could increase if category name is longer (ie condiments + extras)
                                  // of all things that may need to be lengthened, this is the most likely
        ],

        // price
        'item_price' => [
            // item price - DECIMAL, NOT NULL
            'type' => 'DECIMAL', // set as a decimal
            'constraint' => '10,2', // precision 10, 2 decimal places (10 digits with two decimals)
            
        ],
        
        'user_id' => [ // Add user_id column to associate menu items with users
            // this will take information from the session ID
            'type' => 'INT', // integer
            'constraint' => 20, // no more than 20 characters
            'unsigned' => true, // start from 0
        ],
        // Image url (will be VARCHAR)
        'image_url' => [
            // allows null entries, varchar
            'type' => 'VARCHAR', // set up as a varchar
            'constraint' => 255, // no more than 255 characters long
            'null' => true, // allow for entry with no picture included, default entry in controller is null

        ],
        //
        ]);
        $this->forge->addKey('item_id', TRUE); // add item_id as the primary key
        $this->forge->createTable('menu'); // create the menu table

        
    }
    
    // function to drop the table
    public function down()
    {
        $this->forge->dropTable('menu'); // drop the table
        //
    }
}
