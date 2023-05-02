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
                    <a href="{{ route('upsell-dashboard') }}" class="text-lg text-white bg-blue-600 hover:bg-blue-700 rounded py-1 px-2" v-track.upsell_dashboard_click>{{ __('Users to upsell') }}</a>
                </div>
                <div class="p-4">
                    <a href="{{ route('dashboard') }}" class="text-lg text-white bg-gray-300 hover:bg-blue-600 rounded py-1 px-2" v-track.global_dashboard_click>{{ __('Dashboard') }}</a>
                </div>
            </div>

            @php
               $saleFunnel = $results->firstWhere('type','sale_funnel');
               $dropOffData = $results->firstWhere('type','drop_offs');
               $upsell = $results->firstWhere('type','upsell');
               $upsellStats = $results->firstWhere('type','upsell_stats');
            @endphp

            <div id="upsell_dashboard">
                <x-dashboard.upsell-dashboard :sale-funnel='$saleFunnel' :drop-off-data='$dropOffData' :upsell-stats='$upsellStats' :upsell='$upsell' :customers='$customers' />
            </div>

            @if(empty($customers))
                <x-dashboard.empty-dashboard/>
            @endif

        </div>
    </div>
</div>
@endsection
