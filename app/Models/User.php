<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser; 
use Filament\Panel; 

#[Fillable(['name', 'email', 'password', 'city'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser 
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * التحكم في مين يقدر يدخل لوحة تحكم Filament
     */
    public function canAccessPanel(Panel $panel): bool
    {
       
        return $this->hasRole('admin') || $this->hasRole('employee');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function city()
{
    return $this->belongsTo(City::class);
}
    public function governorate()
{
    return $this->belongsTo(Governorate::class);
}
}