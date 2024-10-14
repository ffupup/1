<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderItemsModel extends Model {
    protected $table = 'order_items'; // table name - order_items this is how it shows in the database
    protected $primaryKey = 'order_items_id'; // primary key = order_items_id
    protected $returnType = 'array'; // array, standard table format
    protected $protectFields = true; // protect fields
    protected $useSoftDeletes   = false; // do not use soft deletes
    protected $allowedFields = ['order_id', 'item_id', 'item_price', 'order_quantity'];  
    // these are the allowed fields of the database
}
?>
