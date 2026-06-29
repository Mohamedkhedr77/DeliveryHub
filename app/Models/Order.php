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
    'branch_id',
    'city',
    'customer_name',
    'customer_phone',
    'governorate_id',
    'address',
    'status_id',
    'weight',
    'base_price',
    'total_price',
    'is_village',
    'notes',
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