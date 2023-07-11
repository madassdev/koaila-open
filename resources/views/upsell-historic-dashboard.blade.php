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
                        <a href="{{ route('upsell-historic-dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none" v-track.upsell_historic_dashboard_click>{{ __('Upsell History') }}</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-1">
                            @if($customers?->count()!=0)
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 text-left bg-white">
                                        <h1 class="text-lg font-semibold text-gray-900">Previously detected users</h1>
                                        <p class="mt-1 text-sm font-normal text-gray-500">These are the users who were previously detected to have a high probability to convert.</p>
                                    </div>
                                </div>
                                <table class="relative w-full border text-sm text-left text-gray-500">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center">
                                                {{ __('Date')}}
                                            </th>
                                            <th scope="col" class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center">
                                                {{ __('Email')}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr class="bg-white border-b">
                                                <th scope="row"
                                                    class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap text-center">
                                                    <h1>{{$customer->states()?->latest()?->first()?->date}}</h1>
                                                </th>
                                                <th scope="row"
                                                    class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap text-center">
                                                    <a href="{{ route('customer-dashboard', ['id'=>$customer['id']]) }}">{{$customer['email']}}</a>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div>
                                    <h1>No historical data to show yet.</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
