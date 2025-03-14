@extends('layouts.master')
@section('content')
<div class="container p-4 mx-auto">
    <p class="tracking-out-expand text-center text-xl text-red-700"> দৈনিক অফিসিয়াল আপডেট দেখুন ! </p>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        {{-- <pre>{{ print_r($posts, true) }}</pre> --}}
       
        @if (!empty($posts))
        @foreach ($posts as $index => $post)
        {{-- @dd($post) --}}
            @php
                $authorName = $post[5] ??  'Unknown';
                $firstLetter = strtoupper(mb_substr($authorName, 0, 1)); // নামের প্রথম অক্ষর
            @endphp

        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center gap-3">
                {{-- @dd($post[6]) --}}
                @if (!empty($post[6]))
                <img src="{{ Storage::url($post[6]) }}" class="object-cover w-10 h-10 border border-gray-300 rounded-full shadow-sm" alt="Profile Image">
                @else
                    <!-- প্রোফাইল ইমেজ না থাকলে প্রথম অক্ষর দেখাবে -->
                    <div class="flex items-center justify-center w-10 h-10 text-lg font-bold text-white bg-blue-500 border border-gray-300 rounded-full shadow-sm">
                        {{ $firstLetter }}
                    </div>
                @endif

                <div class="text-sm text-gray-500">
                    <p class="font-semibold text-gray-700">
                        {{ $authorName }}
                    </p>
                    <p>Posted: {{ optional(\Carbon\Carbon::parse($post[3] ?? ''))->diffForHumans() ?? 'Unknown time' }}</p>
                </div>
            </div>

                     <h2 class="mt-4 mb-2 text-xl font-bold" style="font-family: 'Tiro Bangla', sans-serif;">
            {{ $post[0] ?? '' }}
            </h2>
            <p class="text-gray-900 line-clamp-3">{{ $post[1] ?? '' }}</p>

            @if (!empty($post[2]))
                <img src="{{ asset($post[2]) }}" class="object-cover w-full rounded-lg shadow">
            @endif
            </div>
            @endforeach

    
            @else
                <p class="text-4xl text-center text-red-700">Sorry, No Data Found</p>
            @endif
     </div>
</div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>            
@endsection
