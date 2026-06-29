<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">لوحة تحكم الكابتن</h1>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->name }}</span>
        </div>

        <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li class="me-2">
                    <button wire:click="$set('activeTab', 'new')"
                            class="inline-block p-4 rounded-t-lg border-b-2 {{ $activeTab === 'new' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-gray-500 border-transparent hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300' }}">
                        طلبات جديدة
                        <span class="ms-1 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                            {{ $this->newOrders()->count() }}
                        </span>
                    </button>
                </li>
                <li class="me-2">
                    <button wire:click="$set('activeTab', 'my')"
                            class="inline-block p-4 rounded-t-lg border-b-2 {{ $activeTab === 'my' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-gray-500 border-transparent hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300' }}">
                        طلباتي
                        <span class="ms-1 bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                            {{ $this->myOrders()->count() }}
                        </span>
                    </button>
                </li>
                <li class="me-2">
                    <button wire:click="$set('activeTab', 'completed')"
                            class="inline-block p-4 rounded-t-lg border-b-2 {{ $activeTab === 'completed' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-gray-500 border-transparent hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300' }}">
                        تم التسليم
                        <span class="ms-1 bg-gray-100 text-gray-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-900 dark:text-gray-300">
                            {{ $this->completedOrders()->count() }}
                        </span>
                    </button>
                </li>
            </ul>
        </div>

        @if ($activeTab === 'new')
            @include('livewire.driver.partials.new-orders', ['orders' => $this->newOrders()])
        @elseif ($activeTab === 'my')
            @include('livewire.driver.partials.my-orders', ['orders' => $this->myOrders()])
        @else
            @include('livewire.driver.partials.completed-orders', ['orders' => $this->completedOrders()])
        @endif
    </div>

    @if ($showRejectionModal)
        @include('livewire.driver.partials.rejection-modal')
    @endif
</div>
