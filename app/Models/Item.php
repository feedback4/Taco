<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable= [
      'element_id','name','quantity','cost','price','description','unit','expire_at','inventory_id','user_id','bill_id','production_order_id','invoice_id'
    ];
    protected $casts = [
        'expire_at' => 'date'
    ];
    public static $units = ['kg','g','t'];
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
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    public function productionOrders (): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductionOrder::class,'item_production_order')->withPivot('amount');
    }
    public function getCreatedAttribute()
    {
        return $this->created_at?->format('d M Y');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('quantity', 'like', '%'.$search.'%')
                ->orWhere('price', 'like', '%'.$search.'%')
                ->orWhereHas('element', fn($q) => $q->where('name','like', '%'.$search.'%')->orWhere('code','like', '%'.$search.'%'))
                ->orWhereHas('category', fn($q) => $q->where('categories.name','like', '%'.$search.'%'));
    }
}
