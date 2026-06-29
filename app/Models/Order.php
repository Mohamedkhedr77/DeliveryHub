<?php

namespace App\Models;
<<<<<<< Updated upstream
use App\Models\User;
use App\Models\Governorate;
use App\Models\Status;
use App\Models\Branch;
=======

>>>>>>> Stashed changes
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
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

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

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
}