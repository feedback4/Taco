<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,softDeletes;

    protected $fillable = ['name','state','address','active','last_action_at'];

    protected $casts = ['last_action_at'=>'date','active'=>'boolean'];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }


    public function getLastActionAttribute()
    {
        return $this->last_action_at?->format('d M Y');
    }
}
