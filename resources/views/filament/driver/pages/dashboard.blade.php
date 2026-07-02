<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            لوحة تحكم الدليفري
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">

            <div class="grid grid-cols-4 gap-4">

                <div class="bg-yellow-100 rounded-xl p-6 shadow">
                    <h3>Assigned</h3>
                    <p class="text-3xl font-bold">
                        {{ \App\Models\Order::where('driver_id', auth()->id())->where('status_id',2)->count() }}
                    </p>
                </div>

                <div class="bg-blue-100 rounded-xl p-6 shadow">
                    <h3>Out For Delivery</h3>
                    <p class="text-3xl font-bold">
                        {{ \App\Models\Order::where('driver_id', auth()->id())->where('status_id',3)->count() }}
                    </p>
                </div>

                <div class="bg-green-100 rounded-xl p-6 shadow">
                    <h3>Delivered</h3>
                    <p class="text-3xl font-bold">
                        {{ \App\Models\Order::where('driver_id', auth()->id())->where('status_id',4)->count() }}
                    </p>
                </div>

                <div class="bg-red-100 rounded-xl p-6 shadow">
                    <h3>Returned</h3>
                    <p class="text-3xl font-bold">
                        {{ \App\Models\Order::where('driver_id', auth()->id())->where('status_id',5)->count() }}
                    </p>
                </div>  
    </div>
</div>
</x-app-layout>