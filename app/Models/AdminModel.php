<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'login';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['username', 'password', 'email'];




}
?>
