<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'formula_id',
        'inventory_id',
        'value',
    //    'client_id'

    ];

    public function formula()
    {
        return $this->belongsTo(Formula::class);
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
