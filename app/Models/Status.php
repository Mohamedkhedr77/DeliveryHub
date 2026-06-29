<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
<<<<<<< HEAD
    protected $fillable = ['name'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
=======
    //
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
}
