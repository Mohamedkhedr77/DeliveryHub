<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            المرتجع
        </h2>
    </x-slot>

    @php
        $orders = \App\Models\Order::with('governorate')
            ->where('driver_id', auth()->id())
            ->where('status_id', 5)
            ->get();
    @endphp

    <div class="max-w-7xl mx-auto py-8">

        @forelse($orders as $order)

            <div class="bg-white p-6 rounded-xl shadow mb-4">

                <h3>Order #{{ $order->id }}</h3>

                <p>العميل: {{ $order->customer_name }}</p>
                <p>التليفون: {{ $order->customer_phone }}</p>
                <p>العنوان: {{ $order->address }}</p>
                <p>المحافظة: {{ $order->governorate?->name }}</p>
                <p>المدينة: {{ $order->city }}</p>
                <p>السعر: {{ $order->total_price }}</p>
                <p>الوزن: {{ $order->weight }}</p>

            </div>

        @empty

            <div class="bg-white p-6 rounded-xl shadow">
                لا يوجد أوردرات مرتجعة
            </div>

        @endforelse

    </div>

</x-app-layout>