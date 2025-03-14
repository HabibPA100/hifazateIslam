<div x-data="{ open: false }" class="relative flex h-screen">
    <!-- Sidebar -->
    <aside 
        x-show="open"
        x-transition:enter="transition-transform transform duration-300 ease-in-out"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition-transform transform duration-300 ease-in-out"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        @click.away="open = false"
        class="fixed inset-y-0 left-0 w-64 text-white transition-transform duration-300 ease-in-out transform bg-gray-900">
        
        <div class="flex items-center justify-between p-4">
            <h1 class="text-lg font-bold">Admin Panel</h1>
            <button @click="open = false" class="text-white focus:outline-none">✖</button>
        </div>

        <nav class="mt-5 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('show.user') }}" wire:navigate class="block py-2.5 px-4 rounded hover:bg-gray-700">Users</a>
            <a href="#" class="block py-2.5 px-4 rounded hover:bg-gray-700">Settings</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex flex-col flex-1">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 bg-white shadow-md">
            <button @click="open = !open" class="text-gray-700 focus:outline-none">
                <img src="{{ asset('frontend/images/left-arrow-svgrepo-com.svg') }}" alt="Arrow" width="30px" height="30px">
            </button>
            <p class="text-lg font-semibold text-gray-700 lg:text-2xl">Welcome to admin dashboard</p>
            <span></span> <!-- Placeholder for spacing -->
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('show.user') }}" wire:navigate >
            @livewire('admin.user-count')
            </a>
            @livewire('admin.post-count')
            @livewire('admin.pen-count')
            @livewire('admin.fatwa-count')
        </div>
    </div>
</div>
