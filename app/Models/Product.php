<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class Product extends Model
{
    use HasFactory ,BelongsToThrough;

    public static $textures = ['smooth','rough'];

    protected $fillable = [
        'name',
        'code','category_id','texture','gloss','color_family','curing_time',
        'formula_id','last_price'
    ];


    public function formula()
    {
        return $this->belongsTo(Formula::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('texture', 'like', '%' . $search . '%')
                ->orWhere('gloss', 'like', '%' . $search . '%')
                ->orWhere('color_family', 'like', '%' . $search . '%')
//
                ->orWhereHas('formula', fn($q) => $q->where('name','like', '%'.$search.'%')->orWhere('code','like', '%'.$search.'%'))
                ->orWhereHas('category', fn($q) => $q->where('name','like', '%'.$search.'%'));
    }
}
