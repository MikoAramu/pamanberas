<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transactions_id', 
        'products_id',
        'price',
        'delivering_status',
        'code',
        'quantity'
    ];

    protected $hidden = [

    ];

    public function product(){
        return $this->hasOne( Product::class, 'id_product', 'products_id' );
    }

    public function transaction(){
        return $this->hasOne( Transaction::class, 'id_transaction', 'transactions_id' );
    }
}
