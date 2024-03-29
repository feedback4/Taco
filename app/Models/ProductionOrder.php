<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class ProductionOrder extends Model
{
    use  BelongsToThrough;

    protected $fillable = ['number','amount','formula_id','status_id','user_id','times','done_at'];

    protected $casts = ['done_at'=>'datetime'];

    public function items()
    {
        return $this->belongsToMany(Item::class,'item_production_order')->withPivot('amount');
    }
    public function element ()
    {
        return $this->belongsToThrough('App\Models\Element','App\Models\Item');
    }
    public function formula ()
    {
        return $this->belongsTo(Formula::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function user ()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedAttribute()
    {
        return $this->created_at?->format('d M Y');
    }
    public function getDoneAttribute()
    {
        return $this->done_at?->format('d M Y');
    }
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('amount', 'like', '%'.$search.'%')
              //  ->orWhere('unit', 'like', '%'.$search.'%')
                ->orWhereHas('items', fn($q) => $q->whereHas('element',fn($q) => $q->where('name','like', '%'.$search.'%')));
    }
}
