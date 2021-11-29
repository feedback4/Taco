<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory ,softDeletes;

    protected $fillable = ['action_id','status_id','invoiced_at','due_at','amount','client_id','notes','parent_id','tax_id'];
    protected $casts = ['invoiced_at'=>'date','due_at'=>'date'];

    public function action(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Action::class);
    }
    public function status():\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function client():\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
