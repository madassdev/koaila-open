@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="flex flex-wrap">
                <div class="p-4">
                    <a href="{{ route('configuration') }}" class="text-lg text-white bg-gray-300 hover:bg-blue-600 rounded py-1 px-2" v-track.configuration_page_click>{{ __('Configurations') }}</a>
                </div>
                <div class="p-4">
                    <a href="{{ route('api-configuration') }}" class="text-lg text-white bg-blue-600 hover:bg-blue-700 rounded py-1 px-2" v-track.api_configuration_page_click>{{ __('API Configuration') }}</a>
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
