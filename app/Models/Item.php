<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable= [
      'element_id','amount','unit','expire_at','inventory_id','user_id'
    ];
    protected $casts = [
        'expire_at' => 'date'
    ];
    public function element()
    {
        return $this->belongsTo(Element::class);
    }
    public function category()
    {
        return $this->belongsToThrough('App\Models\Category', 'App\Models\Element');
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('amount', 'like', '%'.$search.'%')
                ->orWhere('unit', 'like', '%'.$search.'%')
                ->orWhereHas('element', fn($q) => $q->where('name','like', '%'.$search.'%')->orWhere('code','like', '%'.$search.'%'))
                ->orWhereHas('category', fn($q) => $q->where('categories.name','like', '%'.$search.'%'));
    }
}
