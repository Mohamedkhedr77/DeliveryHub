<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    /**
     */
    public function getDashboardRoute(): string
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) return '/admin';
        if ($user->hasRole('merchant')) return '/merchant';
        if ($user->hasRole('employee')) return '/employee';
        if ($user->hasRole('driver')) return '/driver';

        return '/';
    }
};

?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ $this->getDashboardRoute() }}">
                        <x-application-logo
                            class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-6">

                    {{-- روابط السائق تظهر فقط لمن يملك دور driver --}}
                    @if(auth()->user()->hasRole('driver'))
                        <x-nav-link
                            :href="'/driver'"
                            :active="request()->is('driver')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link
                            :href="'/driver/new-orders'"
                            :active="request()->is('driver/new-orders*')">
                            أوردرات جديدة
                        </x-nav-link>

                        <x-nav-link
                            :href="'/driver/my-orders'"
                            :active="request()->is('driver/my-orders*')">
                            أوردراتي
                        </x-nav-link>

                        <x-nav-link
                            :href="'/driver/delivered-orders'"
                            :active="request()->is('driver/delivered-orders*')">
                            تم تسليمها
                        </x-nav-link>

                        <x-nav-link
                            :href="'/driver/returned-orders'"
                            :active="request()->is('driver/returned-orders*')">
                            المرتجع
                        </x-nav-link>
                    @endif

                    {{-- يمكنك إضافة روابط للأدوار الأخرى هنا بنفس الطريقة --}}
                    @if(auth()->user()->hasRole('admin'))
                         <x-nav-link :href="'/admin'" :active="request()->is('admin*')">
                            Admin Panel
                        </x-nav-link>
                    @endif

                </div>

            </div>

            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white rounded-md">

                            {{ auth()->user()->name }}

                            <svg class="ms-1 h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                Log Out
                            </x-dropdown-link>
                        </button>

                    </x-slot>

                </x-dropdown>

            </div>

        </div>
    </div>

</nav>
