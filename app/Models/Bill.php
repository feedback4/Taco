<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'status_id', 'billed_at', 'due_at', 'amount', 'notes','parent_id','tax_id'];

    protected $casts = [
        'billed_at' => 'date',
        'due_at' => 'date',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
