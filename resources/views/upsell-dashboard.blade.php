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
                    <a href="{{ route('upsell-dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" v-track.upsell_dashboard_click>{{ __('Users to upsell') }}</a>
                </div>
                <div class="py-4 px-4">
                    <a href="{{ route('upsell-historic-dashboard') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" v-track.upsell_historic_dashboard_click>{{ __('Upsell History') }}</a>
                </div>
                <div class="py-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" v-track.global_dashboard_click>{{ __('Dashboard') }}</a>
                </div>
            </div>

            @php
               $saleFunnel = $results->firstWhere('type','sale_funnel');
               $upsellStats = $results->firstWhere('type','upsell_stats');
               @endphp

            <div id="upsell_dashboard">
                <x-dashboard.timeline :sale-funnel='$saleFunnel' customerStep=""/>
                <x-dashboard.upsell-dashboard :upsell-stats='$upsellStats' :customers='$customers' />
            </div>

            @if(empty($customers))
                <x-dashboard.empty-dashboard/>
            @endif

        </div>
    </div>
</div>
@endsection
