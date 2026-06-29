<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{
<<<<<<< HEAD
    protected $fillable = [
        'order_id',
        'status_id',
        'changed_by',
        'notes',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
=======
    //
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
}
