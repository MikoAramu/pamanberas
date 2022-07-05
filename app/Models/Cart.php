<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'products_id', 'users_id', 'quantity'
    ];

    protected $hidden = [

    ];

    public function product(){
        return $this->hasOne( Product::class, 'id_product', 'products_id', 'quantity' );
    }

    public function user(){
        return $this->belongsTo( User::class, 'users_id', 'id_user');
    }
}
