<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.meta')
        <title>@yield('title', 'হিফাজতে ইসলাম বাংলাদেশ - অফিসিয়াল ওয়েবসাইট')</title>
        @livewireStyles
    </head>
    <body style="font-family: 'Tiro Bangla', sans-serif;">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
        @include('layouts.toaster')
    </body>
</html>
