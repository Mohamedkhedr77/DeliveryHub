<x-layout>
    <x-slot:title>
        QuickDrop - الرئيسية
    </x-slot:title>

    <div class="p-4 flex justify-end gap-4 bg-base-200">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-outline">لوحة التحكم</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">تسجيل الدخول</a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-ghost">إنشاء حساب</a>
        @endauth
    </div>

    <div class="py-20 text-center">
        <h1 class="text-5xl font-bold text-success">أهلاً بك في QuickDrop!</h1>
        <p class="mt-4 text-xl text-base-content/70">الآن الداتابيز، والـ Layout، ونظام تسجيل الدخول (Breeze) شغالين مع بعض 100%.</p>
    </div>
</x-layout>