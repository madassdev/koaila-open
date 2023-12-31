@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session("status") }}
            </div>
            @endif @if(session()->has('message'))
            <div
                class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4"
                role="alert"
            >
                <p>{{ session()->get('message') }}</p>
            </div>
            @endif
            <div class="flex flex-wrap">
                <div class="py-4">
                    <a
                        href="{{ route('upsell-dashboard') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                        v-track.upsell_dashboard_click
                        >{{ __("Users to upsell") }}</a
                    >
                </div>
                <div class="py-4 px-4">
                    <a
                        href="{{ route('upsell-historic-dashboard') }}"
                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
                        v-track.upsell_historic_dashboard_click
                        >{{ __("Upsell History") }}</a
                    >
                </div>
            </div>

            <div id="upsell_dashboard">
                <x-dashboard.upsell-dashboard
                    :upsell-stats="$upsellStats"
                    :customersByPlans="$customersByPlans"
                    :members="$members"
                />
            </div>

            @if(empty($customersByPlans))
            <x-dashboard.empty-dashboard />
            @endif
        </div>
    </div>
</div>
@endsection
