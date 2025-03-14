<header class="bg-white shadow-md">
    <div class="container px-4 py-3 mx-auto">
        <nav class="grid grid-cols-6 text-center">
            <a href="/" wire:navigate title="Go To Home" class="text-gray-700 transition hover:text-blue-600">
                <i class="text-2xl fas fa-home"></i>
            </a>
            <a href="{{route('open.pen')}}" wire:navigate title="কলাম পড়ুন" class="text-2xl text-gray-700 transition hover:text-blue-600">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <a href="{{ route('read.fatwa') }}" class="text-gray-700 transition hover:text-blue-600">
                <i class="text-2xl fa-solid fa-umbrella"></i>
            </a>
            <a href="{{ url('/about') }}" wire:navigate class="text-gray-700 transition hover:text-blue-600">
                <i class="text-2xl fas fa-cog"></i>
            </a>
            <a href="{{ url('/contact') }}" wire:navigate class="text-gray-700 transition hover:text-blue-600">
                <i class="text-2xl fa-solid fa-phone-volume"></i>
            </a>
            <a href="{{ route('register') }}" wire:navigate class="text-gray-700 transition hover:text-blue-600">
                <i class="text-2xl fa-solid fa-globe"></i>
            </a> 
        </nav>
    </div>
</header>