<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'unite',
        'img_url',
        'user_id',
        'category_id'
    ];
}
