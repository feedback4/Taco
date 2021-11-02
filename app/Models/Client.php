<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'phone',
        'status',
        'balance',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
