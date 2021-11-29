<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory ,softDeletes ;

    protected $fillable = [
        'name',
        'phone',
        'status_id',
        'company_id',
        'balance',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }


}
