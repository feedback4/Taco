<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_ids',
        'value',
        'cust_name',
        'cust_num',
        'address',
        'deliver_before',
        'notes',
        'user_id',
        'total'
    ];
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
