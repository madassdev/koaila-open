@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="flex flex-wrap">
                <div class="p-4">
                    <a href="{{ route('configuration') }}" class="text-lg text-white bg-blue-600 hover:bg-blue-700 rounded py-1 px-2" v-track.configuration_page_click>{{ __('Configurations') }}</a>
                </div>
                <div class="p-4">
                    <a href="{{ route('api-configuration') }}" class="text-lg text-white bg-gray-300 hover:bg-blue-600 rounded py-1 px-2" v-track.api_configuration_page_click>{{ __('API Configuration') }}</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                            <p>{{ session()->get('message') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form is in blade to go faster but ultimately, it should be moved to the ConfigForm component. --}}
                    <form method="POST" action="{{ route('create-configuration') }}">
                        @csrf

                        @foreach (
                            [
                                'pricing_page_url' => 'Pricing Page',
                                'conversion_channel'=>'Conversion channels',
                                'aha_moment'=>'Aha Moment',
                                'features' => 'Features'
                            ]
                            as $configType => $configTitle)
                            @if($configType!='pricing_page_url')
                                <config-form type="{{$configType}}" title="{{$configTitle}}" :existing-config='{{!! !empty($existingConfigs) ? json_encode($existingConfigs->$configType) : '[]' }}'></config-form>
                            @else
                                <div class="grid grid-cols-3">
                                    <div class="flex justify-center col-start-1 p-3">
                                        <h1 class="text-lg">{{$configTitle}}</h1>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3">
                                    <div class="flex justify-center row py-3">
                                        <label for="{{$configType}}" class="col-md-4 col-form-label text-md-end">URL</label>

                                        <div class="col-md-6">
                                            <input id="{{$configType}}" name="pricing_page_url" type="text" class="form-control" autocomplete="{{$configType}}" value='{{!! !empty($existingConfigs) ? $existingConfigs->pricing_page_url : null }}' autofocus>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!$loop->last)
                                <hr class="m-3">
                            @endif
                        @endforeach

                        <div class="row grid grid-cols-3 px-3">
                            <div class="flex justify-center col-start-2 mt-3">
                                <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded" v-track.configurations_form_submit>
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
