<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model {
    protected $table = 'orders'; // table name - orders
    protected $primaryKey = 'order_id'; // primary key = order_id
    protected $returnType = 'array'; // array, standard table format
    protected $protectFields = true; // protect fields
    protected $useSoftDeletes   = false; // do not use soft deletes
    protected $allowedFields = ['business_id', 'user_id', 'table_name', 'order_status'];  
    // these are the allowed fields of the database
}
?>
