
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            أوردراتي
        </h2>
    </x-slot>

    @php
    $orders = \App\Models\Order::with('governorate')
        ->where('driver_id', auth()->id())
        ->whereIn('status_id', [2,3]) // Assigned و Out For Delivery
        ->get();
    @endphp

    <div class="max-w-7xl mx-auto py-8">

        @foreach($orders as $order)

            <div class="bg-white p-6 rounded-xl shadow mb-4">

                <h3>Order #{{ $order->id }}</h3>

                <p>العميل: {{ $order->customer_name }}</p>
                <p>التليفون: {{ $order->customer_phone }}</p>
                <p>العنوان: {{ $order->address }}</p>
                <p>المحافظة: {{ $order->governorate?->name }}</p>
                <p>المدينة: {{ $order->city }}</p>
                <p>السعر: {{ $order->total_price }}</p>
                <p>الوزن: {{ $order->weight }}</p>
                    <form action="{{ route('driver.orders.update-status', $order) }}" method="POST" class="mt-4 flex items-center gap-2">
    @csrf

    <select name="status_id" class="border rounded px-3 py-2">
        <option value="2" {{ $order->status_id == 2 ? 'selected' : '' }}>
            Assigned
        </option>

        <option value="3" {{ $order->status_id == 3 ? 'selected' : '' }}>
            Out For Delivery
        </option>

        <option value="4" {{ $order->status_id == 4 ? 'selected' : '' }}>
            Delivered
        </option>

        <option value="5" {{ $order->status_id == 5 ? 'selected' : '' }}>
            Returned
        </option>
    </select>

    <button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded">
       status
    </button>
</form>
            </div>
            
        @endforeach

    </div>

</x-app-layout>
