<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory ,softDeletes;

    protected $fillable = [
        'name',
        'location',
        'manager_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function items ()
    {
        return $this->hasMany(Item::class);
    }
    public function manager()
    {
        return $this->belongsTo(Employee::class,'manager_id');
    }
    public function elements ()
    {
        return $this->hasManyThrough(Element::class,Item::class);
    }
}
