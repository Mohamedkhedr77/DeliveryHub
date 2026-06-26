<?php

namespace App\Models;
use App\Models\User;
use App\Models\Governorate;
use App\Models\Status;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'merchant_id',
        'branch_id',
        'driver_id',
        'city',
        'customer_name',
        'customer_phone',
        'governorate_id',
        'address',
        'status_id',
        'total_price',
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

    public function rejectionReasons()
    {
        return $this->hasMany(RejectionReason::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }
}