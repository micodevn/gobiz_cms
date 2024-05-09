<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $connection = 'mysql';
    public $table = 'banners';

    protected $fillable = ['name', 'url', 'slug', 'image', 'platform', 'is_active'];
}
