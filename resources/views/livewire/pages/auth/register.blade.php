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
    public ?int $governorate_id = null;

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
            'governorate_id' => ['nullable', 'required_if:role,driver'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = $this->role;
        $validated['governorate_id'] = $this->role === 'driver' ? $this->governorate_id : null;

        event(new Registered($user = User::create($validated)));

        $user->assignRole($this->role);

        Auth::login($user);

        if ($user->hasRole('merchant')) {
            $this->redirect('/merchant');
        } elseif ($user->hasRole('employee')) {
            $this->redirect('/employee');
        } elseif ($user->hasRole('driver')) {
            $this->redirect('/driver');
        } else {
            $this->redirect('/');
        }
    }
}; ?>

<div>
    <form wire:submit="register">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select wire:model.live="role"
                    id="role"
                    class="block mt-1 w-full border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-700 text-gray-700 dark:text-gray-300 shadow-sm focus:ring-indigo-500">
                <option value="">Choose Role</option>
                <option value="merchant">Merchant</option>
                <option value="employee">Employee</option>
                <option value="driver">Driver</option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        @if($role == 'driver')
            <div class="mt-4">
                <x-input-label for="governorate_id" value="Governorate" />

                <select wire:model="governorate_id"
                        id="governorate_id"
                        class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-gray-700 dark:text-gray-300 shadow-sm focus:ring-indigo-500">
                    <option value="">Choose Governorate</option>
                    @foreach(\App\Models\Governorate::all() as $governorate)
                        <option value="{{ $governorate->id }}">
                            {{ $governorate->name }}
                        </option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('governorate_id')" class="mt-2" />
            </div>
        @endif

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

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