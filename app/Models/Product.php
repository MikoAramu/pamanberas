<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'name', 'users_id', 'price', 'description', 'stock', 'slug'
    ];

    protected $hidden = [

    ];

    public function galleries(){
        return $this->hasMany( ProductGallery::class, 'products_id', 'id_product');
    }

    public function user(){
        return $this->hasOne( User::class, 'id_user', 'users_id');
    }
}