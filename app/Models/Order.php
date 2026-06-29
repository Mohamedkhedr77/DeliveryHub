<?php

namespace App\Models;
use App\Models\User;
use App\Models\Governorate;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
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

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}