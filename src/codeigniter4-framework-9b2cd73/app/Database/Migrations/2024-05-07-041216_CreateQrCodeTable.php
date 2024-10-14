<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQrCodeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([ // add required fields for the QR code database table
            'qr_id' => [ 
                //PRIMARY KEY - the information that will be required to call the qr code/identify it
                'type' => 'INT', // integer
                'constraint' => 20, // no more than 20 characters long
                'unsigned' => TRUE, // unsigned, starts from 0
                'auto_increment' => TRUE, // work from 1 and count upwards
            ],
            'qr_link' => [
                // the url that the qr code will refer a user to
                'type' => 'VARCHAR', // varchar as it will include, letters, symbols and numbers
                'constraint' => 255, // should not exceed 255 characters in length
                // might need to add a constraint allowing it to have a null entry, but maybe not

            ],
            'user_id' => [
                // user ID, which will be recieved from session data when a business is adding a table through the add table feature
                'type' => 'INT', // Integer, will only need to be a number
                'constraint' => 20, // should not exceed 20 characters
                


            ],
            'table_name' => [
                // name for the table, to be used so that the ID does not get used as the name
                'type' => 'VARCHAR', // VARCHAR
                'constraint' => 10, // no more than 10 characters
            ],

        ]);
        $this->forge->addKey('qr_id', TRUE); // add primary key (qr_id)
        $this->forge->createTable('qrcode'); // create a table called qrcode which stores the qr codes
    }

    public function down()
    {
        $this->forge->dropTable('menu'); // drop the table
        
    }
}
