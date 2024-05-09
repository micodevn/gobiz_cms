<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $connection = 'mysql_lms';
    public $table = 'teachers';
}
