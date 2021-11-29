<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = ['name','phone','email','address','active'];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
