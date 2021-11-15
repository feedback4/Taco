<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compound extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function elements()
    {
        return $this->belongsToMany(Element::class,'compound_element')->withPivot('percent');
    }

//    public function formula()
//    {
//        return $this->belongsTo(Formula::class);
//    }
}
