<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.meta')
    <title>@yield('title', 'হিফাজতে ইসলাম বাংলাদেশ - অফিসিয়াল ওয়েবসাইট')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @livewireStyles
</head>
<body style="font-family: 'Tiro Bangla', sans-serif;">
    @include('layouts.header')
    <main>
        @yield('content')
    </main>
    @include('layouts.footer')

    @livewireScripts
    @include('layouts.toaster')
</body>
</html>