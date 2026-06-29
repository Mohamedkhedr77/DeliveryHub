<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest') ] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';
<<<<<<< HEAD
=======
    public ?int $governorate_id = null;
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:merchant,employee,driver'],
<<<<<<< HEAD
    ]);

        $validated['password'] = Hash::make($validated['password']);
=======
        'governorate_id' => ['nullable','required_if:role,driver',],
    ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['governorate_id'] = $this->governorate_id;
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5

        event(new Registered($user = User::create($validated)));

        $user->assignRole($this->role);

        Auth::login($user);

        if ($user->hasRole('merchant')) {
<<<<<<< HEAD
    $this->redirect(route('merchant.dashboard', absolute: false), navigate: true);
}

if ($user->hasRole('employee')) {
    $this->redirect(route('employee.dashboard', absolute: false), navigate: true);
}

if ($user->hasRole('driver')) {
    $this->redirect(route('driver.dashboard', absolute: false), navigate: true);
}
=======
            $this->redirect(route('merchant.dashboard', absolute: false), navigate: true);
        }

        if ($user->hasRole('employee')) {
             $this->redirect(route('employee.dashboard', absolute: false), navigate: true);
        }

        if ($user->hasRole('driver')) {
             $this->redirect(route('driver.dashboard', absolute: false), navigate: true);
        }
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
         <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
<<<<<<< HEAD
            <select wire:model="role"
=======
            <select wire:model.live="role"
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
                    id="role"
                    class="block mt-1 w-full border-gray-300 rounded-md">
                <option value="">Choose Role</option>
                <option value="merchant">Merchant</option>
                <option value="employee">Employee</option>
                <option value="driver">Driver</option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
<<<<<<< HEAD
=======
<!--governorate-->
        @if($role == 'driver')
    <div class="mt-4">
        <x-input-label for="governorate_id" value="Governorate" />

        <select wire:model="governorate_id"
                id="governorate_id"
                class="block mt-1 w-full rounded-md border-gray-300">

            <option value="">Choose Governorate</option>

            @foreach(\App\Models\Governorate::all() as $governorate)
                <option value="{{ $governorate->id }}">
                    {{ $governorate->name }}
                </option>
            @endforeach

        </select>

        <x-input-error :messages="$errors->get('form.governorate_id')" class="mt-2" />
    </div>
@endif
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
