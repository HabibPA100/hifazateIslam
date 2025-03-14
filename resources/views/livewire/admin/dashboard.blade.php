@extends('layouts.admin')
@section('content')
    <div class="py-2">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @include('livewire.admin.components.toggle')
                </div>
                
            </div>
        </div>
    </div>
@endsection
