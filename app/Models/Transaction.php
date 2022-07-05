<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'id_transaction';

    protected $fillable = [
        'users_id', 
        'delivering_price',
        'total_price',
        'transaction_status',
        'status_pay',
        'code',
        'created_at'
    ];

    protected $hidden = [

    ];

    public function detail(){
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id_transaction_detail');
    }

    public function user(){
        return $this->belongsTo( User::class, 'users_id', 'id_user');
    }
}
