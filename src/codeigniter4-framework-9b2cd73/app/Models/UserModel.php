<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['username','password', 'user_type']; // Will allow for a user to input a username, password and user type 
                                                                    // when they submit their registration (also removed a redundant function in here)

    

  
}
?>

