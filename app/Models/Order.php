<?php

namespace App\Models;
<<<<<<< HEAD
<<<<<<< Updated upstream
use App\Models\User;
use App\Models\Governorate;
use App\Models\Status;
use App\Models\Branch;
=======

>>>>>>> Stashed changes
=======
use App\Models\User;
use App\Models\Governorate;
use App\Models\Status;
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
<<<<<<< HEAD
        'merchant_id',
<<<<<<< Updated upstream
        'branch_id',
        'driver_id',
        'city',
        'customer_name',
        'customer_phone',
        'governorate_id',
        'address',
        'status_id',
        'total_price',
=======
        'customer_name',
        'customer_phone',
        'address',
        'governorate_id',
        'city',
        'order_value',
        'weight',
        'is_village',
        'total_price',
        'status_id',
        'driver_id',
>>>>>>> Stashed changes
        'notes',
    ];
=======
    'merchant_id',
    'customer_name',
    'customer_phone',
    'address',
    'governorate_id',
    'city',
    'order_value',
    'weight',
    'is_village',
    'total_price',
    'status_id',
];
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

<<<<<<< HEAD
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

=======
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
<<<<<<< HEAD

<<<<<<< Updated upstream
=======
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

>>>>>>> Stashed changes
    public function rejectionReasons()
    {
        return $this->hasMany(RejectionReason::class);
    }
<<<<<<< Updated upstream

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }
=======
>>>>>>> Stashed changes
=======
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
}