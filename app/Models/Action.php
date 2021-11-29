<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public static $types= ['call','meeting','mail','Manufacture','other'];

    protected $fillable= [
        'type','description','due_at','done_at','employee_id','user_id','client_id'
    ];
    protected $casts = [
        'due_at' => 'date',
        'done_at' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

}
