<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static $types = ['formula','element'];

    protected $fillable = ['name','type','parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id');
    }
    public function formulas()
    {
        return $this->hasMany(Formula::class);
    }
    public function elements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Element::class);
    }
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('type', 'like', '%'.$search.'%')
                ->orWhereHas('parent', fn($q) => $q->where('name','like', '%'.$search.'%'))
                ->orWhereHas('elements', fn($q) => $q->where('name','like', '%'.$search.'%'));
    }

}
