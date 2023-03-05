@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="flex flex-wrap">
                <div class="p-4">
                    <a href="{{ route('home') }}" class="text-lg text-white bg-gray-300 hover:bg-blue-600 rounded py-1 px-2">{{ __('Dashboard') }}</a>
                </div>
                <div class="p-4">
                    <a href="{{ route('upsell-dashboard') }}" class="text-lg text-white bg-blue-600 hover:bg-blue-700 rounded py-1 px-2">{{ __('Users to upsell') }}</a>
                </div>
                <div class="p-4">
                    <a class="text-lg text-white bg-gray-300 hover:bg-blue-600 rounded py-1 px-2">{{ __('All users') }}</a>
                </div>
            </div>

            @php
                $upsell = $results->firstWhere('type','upsell');
            @endphp

            <div id="upsell_dashboard">
                <x-upsell-dashboard :upsell='$upsell' />
            </div>

            @if(!isset($upsell))
                <x-empty-dashboard/>
            @endif

        </div>
    </div>
</div>
@endsection