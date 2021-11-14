<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'category_id',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function categories ()
    {
        return $this->belongsToMany(Category::class,'category_formula')->withPivot('amount');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function orders()
    {
        return $this->hasManyThrough(Order::class,Product::class);
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('code', 'like', '%'.$search.'%')
                ->orWhereHas('category', fn($q) => $q->where('name','like', '%'.$search.'%')->orWhere('type','like', '%'.$search.'%'));
    }
}
