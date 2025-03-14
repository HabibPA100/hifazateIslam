<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.meta')
        <title>@yield('title', 'Admin Dashboard')</title>
        @livewireStyles
    </head>
    <body style="font-family: 'Tiro Bangla', sans-serif;">
        <div>
            <header>
                <livewire:layout.admin-nav />
            </header>
            <main>
               @yield('content')
            </main>
        </div>
        @livewireScripts
        @include('layouts.toaster')
    </body>
</html>
