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
        'code'
    ];


    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('name', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhereHas('company', fn($q) => $q->where('name','like', '%'.$search.'%'));
              //  ->orWhere('address', 'like', '%' . $search . '%');
    }

}
