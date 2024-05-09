<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $connection = 'mysql';
    public $table = 'config';

    protected $fillable = ['key', 'code', 'value', 'description', 'is_active'];
}
