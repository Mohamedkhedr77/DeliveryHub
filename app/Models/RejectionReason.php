<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectionReason extends Model
{
    protected $fillable = [
        'order_id',
        'type',
        'driver_id',
        'reason',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
