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
                <div class="py-4">
                    <a href="{{ route('upsell-dashboard') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2" v-track.upsell_dashboard_click>{{ __('Users to upsell') }}</a>
                </div>
                <div class="py-4 px-4">
                    <a href="{{ route('upsell-historic-dashboard') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2" v-track.upsell_historic_dashboard_click>{{ __('Upsell History') }}</a>
                </div>
                <div class="py-4">
                    <a href="{{ route('dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2" v-track.global_dashboard_click>{{ __('Dashboard') }}</a>
                </div>
            </div>

            @php
                $daumauData = $results->firstWhere('type','daumau');
                $waumauData = $results->firstWhere('type','waumau');
                $ttl = $results->firstWhere('type','time_to_value');
                $featureAdoption = $results->firstWhere('type','feature_adoption');
            @endphp

            <div id="global_dashboard">
                <x-dashboard.global-dashboard :waumau-data='$waumauData' :daumau-data='$daumauData' :ttl='$ttl' :feature-adoption='$featureAdoption' />
            </div>

            @if(!isset($waumauData) & !isset($daumauData) & !isset($ttl) & !isset($featureAdoption))
                <x-dashboard.empty-dashboard/>
            @endif
        </div>
    </div>
</div>
@endsection
