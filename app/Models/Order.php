<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'deliver_before',
        'notes',
        'seller',
        'client_id',
        'total'
    ];
    public function client()
    {
        return  $this->belongsTo(Client::class);
    }
    public function product()
    {
        return  $this->belongsTo(Product::class);
    }
}
