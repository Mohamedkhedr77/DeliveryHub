<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectionReason extends Model
{
<<<<<<< HEAD
    protected $fillable = [
        'order_id',
<<<<<<< Updated upstream
        'type',
        'driver_id',
=======
>>>>>>> Stashed changes
        'reason',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
<<<<<<< Updated upstream

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
=======
>>>>>>> Stashed changes
=======
    //
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
}
