<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['name','value'];

    public static $currencies = ['EGP','USD','EUR'];
    public static $languages = ['EN',"AR"];
}
