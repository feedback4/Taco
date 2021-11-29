<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = ['name','percent','active'];
    protected $casts = ['active'=>'boolean'];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
