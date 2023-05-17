@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="flex flex-wrap">
                <div class="py-4">
                    <a href="{{ route('configuration') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2" v-track.configuration_page_click>{{ __('Configurations') }}</a>
                </div>
                <div class="p-4">
                    <a href="{{ route('api-configuration') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none" v-track.api_configuration_page_click>{{ __('API Configuration') }}</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div>
                        <div class="flex justify-center row py-3">
                            <div class="flex flex-row">
                                <div class="p-2"><p>UUID</p></div>
                                <div class="bg-gray-50 rounded p-2"><p class="px-2">{{!! !empty($existingConfigs) ? $existingConfigs->uuid : null }}</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
