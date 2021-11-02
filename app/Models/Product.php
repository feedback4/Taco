<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'unit',

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
}
