<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            أوردرات جديدة
        </h2>
    </x-slot>

    @php
        $orders = \App\Models\Order::with('governorate')
            ->where('driver_id', auth()->id())
            ->where('status_id', 1)
            ->get();
    @endphp

    <div class="max-w-7xl mx-auto py-8">

        @forelse($orders as $order)

            <div class="bg-white p-6 rounded-xl shadow mb-4">

                <h3 class="font-bold text-lg">
                    Order #{{ $order->id }}
                </h3>

                <p><strong>اسم العميل:</strong> {{ $order->customer_name }}</p>

                <p><strong>رقم العميل:</strong> {{ $order->customer_phone }}</p>

                <p><strong>العنوان:</strong> {{ $order->address }}</p>

                <p><strong>المحافظة:</strong> {{ $order->governorate?->name }}</p>

                <p><strong>المدينة:</strong> {{ $order->city }}</p>

                <p><strong>الوزن:</strong> {{ $order->weight }} كجم</p>

                <p><strong>قيمة الأوردر:</strong> {{ $order->order_value }} جنيه</p>

                <p><strong>السعر الإجمالي:</strong> {{ $order->total_price }} جنيه</p>

                <div class="mt-4 flex gap-2">

    <form action="{{ route('driver.accept', $order) }}" method="POST">
        @csrf
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
            Accept
        </button>
    </form>

    <form action="{{ route('driver.reject', $order) }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
            Reject
        </button>
    </form>

</div>

            </div>

        @empty

            <div class="bg-gray-100 p-4 rounded">
                لا يوجد أوردرات جديدة
            </div>

        @endforelse

    </div>

</x-app-layout>