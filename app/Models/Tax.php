<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('name', 'like', '%' . $search . '%')
                ->orWhere('percent', 'like', '%' . $search . '%');
    }
}
