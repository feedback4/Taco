<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'manager',

    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function items ()
    {
        return $this->hasMany(Item::class);
    }
    public function elements ()
    {
        return $this->hasManyThrough(Element::class,Item::class);
    }
}
