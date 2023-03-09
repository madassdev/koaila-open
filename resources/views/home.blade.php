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
                    <a href="{{ route('home') }}" class="text-lg text-white bg-blue-600 hover:bg-blue-700 focus:text-black rounded py-1 px-2">{{ __('Dashboard') }}</a>
                </div>
                <div class="p-4">
                    <a href="{{ route('upsell-dashboard') }}" class="text-lg text-white bg-gray-300 hover:bg-blue-600 focus:text-black rounded py-1 px-2">{{ __('Users to upsell') }}</a>
                </div>
                <div class="p-4">
                    <a class="text-lg text-white bg-gray-300 hover:bg-blue-600 focus:text-black rounded py-1 px-2">{{ __('All users') }}</a>
                </div>
            </div>

            @php
                $daumauData = $results->firstWhere('type','daumau');
                $ttl = $results->firstWhere('type','time_to_value');
                $featureAdoption = $results->firstWhere('type','feature_adoption');
                $saleFunnel = $results->firstWhere('type','sale_funnel');
            @endphp

            <sankey-chart :data='{!!json_encode($saleFunnel->data)!!}'></sankey-chart>

            <div id="global_dashboard">
                <x-dashboard.global-dashboard :daumau-data='$daumauData' :ttl='$ttl' :feature-adoption='$featureAdoption' />
            </div>

            @if(!isset($daumauData) & !isset($ttl) & !isset($featureAdoption))
                <x-dashboard.empty-dashboard/>
            @endif
        </div>
    </div>
</div>
@endsection
