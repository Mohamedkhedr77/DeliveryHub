<x-layout>
    <x-slot:title>
        QuickDrop - الرئيسية
    </x-slot:title>

    <div class="p-4 flex justify-end gap-4 bg-base-200">
            @auth

            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline">
                 لوحة التحكم
                </a>
            @elseif(auth()->user()->hasRole('merchant'))
                <a href="{{ route('merchant.dashboard') }}" class="btn btn-sm btn-outline">
                 لوحة التحكم
                </a>
            @elseif(auth()->user()->hasRole('employee'))
                <a href="{{ route('employee.dashboard') }}" class="btn btn-sm btn-outline">
                 لوحة التحكم
                </a>
            @elseif(auth()->user()->hasRole('driver'))
                <a href="{{ route('driver.dashboard') }}" class="btn btn-sm btn-outline">
                 لوحة التحكم
                </a>
            @endif

        @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
             تسجيل الدخول
            </a>

            <a href="{{ route('register') }}" class="btn btn-sm btn-ghost">
             إنشاء حساب
            </a>
        @endauth
    </div>

    <div class="py-20 text-center">
        <h1 class="text-5xl font-bold text-success">أهلاً بك في deliveryhub!</h1>
        <p class="mt-4 text-xl text-base-content/70">الآن الداتابيز، والـ Layout، ونظام تسجيل الدخول (Breeze) شغالين مع بعض 100%.</p>
    </div>
</x-layout>