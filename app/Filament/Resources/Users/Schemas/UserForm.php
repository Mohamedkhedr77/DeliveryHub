<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Hash;
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
<<<<<<< HEAD
                    ->required(),
=======
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
                Select::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
<<<<<<< HEAD
=======
                Select::make('governorate_id')
                    ->relationship('governorate', 'name')
                    ->label('Governorate')
                    ->searchable()
                    ->preload(),
                TextInput::make('city')
                    ->label('City')
                    ->required()
                    ->maxLength(255)
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
            ]);
    }
}
