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
                    <a href="{{ route('home') }}" class="text-lg text-white bg-blue-600 hover:bg-blue-700 focus:text-black rounded py-1 px-2" v-track._dashboard_click>{{ __('Dashboard') }}</a>
                </div>
                <div class="p-4">
                    <a href="{{ route('upsell-dashboard') }}" class="text-lg text-white bg-gray-300 hover:bg-blue-600 focus:text-black rounded py-1 px-2" v-track.upsell_dashboard_click>{{ __('Users to upsell') }}</a>
                </div>
            </div>

            @php
                $daumauData = $results->firstWhere('type','daumau');
                $waumauData = $results->firstWhere('type','waumau');
                $ttl = $results->firstWhere('type','time_to_value');
                $featureAdoption = $results->firstWhere('type','feature_adoption');
                $saleFunnel = $results->firstWhere('type','sale_funnel');
            @endphp

            @if(isset($saleFunnel))
                <sankey-chart :data='{!!json_encode($saleFunnel->data)!!}'></sankey-chart>
            @endif

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
