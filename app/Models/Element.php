<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function formulas()
    {
        return $this->belongsToMany(Formula::class,'element_formula')->withPivot('amount');;
    }
    public function compounds()
    {
        return $this->belongsToMany(Compound::class,'compound_element')->withPivot('percent');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('name', 'like', '%'.$search.'%')
                ->orWhere('code', 'like', '%'.$search.'%')
                ->orWhereHas('category', fn($q) => $q->where('name','like', '%'.$search.'%'));
    }
}
