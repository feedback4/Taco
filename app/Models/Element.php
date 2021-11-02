<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'category_id'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function formula()
    {
        return $this->belongsToMany(Formula::class,'element_formula');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('unit', 'like', '%'.$search.'%')
                ->orWhereHas('category', fn($q) => $q->where('name','like', '%'.$search.'%')->orWhere('type','like', '%'.$search.'%'));
    }
}
