<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                // primary key
                'type' => 'INT', // will be an integer
                'constraint' => 20, // no more than 20 digits long, if there are more users than that, there is far too much traffic for the site
                                    // or there is an error somewhere in the code
                'unsigned' => true, // must start from 0.
                'auto_increment' => true, // counts up in values of 1 whole number to avoid duplications
                

            ],
            'username' =>[
                // from the registration form
                // required to be NOTNULL and UNIQUE, which is addressed in the controller method
                'type' => 'VARCHAR', // allows multiple characters
                'constraint' => 20, // no more than 20 characters to match the registration form requirement of being 20 characters or less

            ],
            'password' =>[
                // VARCHAR, not null, allow for password hashing extension to the length
                // not null is managed in both the form data and the controller method handling the post request
                'type' => 'VARCHAR', // will allow letters, numbers, and symbols
                'constraint' => 255, // will not exceed 255 characters. this is good because the password is hashed, so it may be
                                     // significantly longer than the limit on the registration form

            ],
            'user_type' => [
                'type' => 'ENUM', // alphanumeric - allows letters and numbers
                'constraint' => ['Customer', 'Business', 'Admin'], // can only be one of these three options
                
            ],

        ]);
        $this->forge->addKey('id', TRUE); // set 'id' as the primary key
        $this->forge->createTable('users'); // create table named users in the database
        //
    }

    public function down()
    {
        $this->forge->dropTable('users');
        // drop table
    }
}
?>