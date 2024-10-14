<?php
namespace App\Models;

use CodeIgniter\Model;

class QRModel extends Model {
    protected $table = 'qrcode'; // table name - qrcode
    protected $primaryKey = 'qr_id'; // primary key = qr_id
    protected $returnType = 'array'; // array, standard table format
    protected $protectFields = true; // protect fields
    protected $useSoftDeletes   = false; // do not use soft deletes
    protected $allowedFields = ['qr_link', 'user_id','table_name'];  // allowed fields are qr_link and table_id
}
?>
