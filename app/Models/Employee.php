<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['name','phone','position','salary','active','joined_at'];

    protected $casts = ['joined_at'=>'date','active'=>'boolean'];

    public function actions()
    {
        return $this->hasMany(Action::class);
    }



    public function getJoinedAttribute()
    {
        return $this->joined_at?->format('d M Y');
    }
}
