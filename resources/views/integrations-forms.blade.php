@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header capitalize">{{ $type }} integration</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    <form method="POST" action="{{ route('create-integration', ['type'=>$type]) }}">
                        @csrf      
                        
                        @if(session()->has('message'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                                <p>{{ session()->get('message') }}</p>
                            </div>
                        @endif

                        <div class="row mb-3 mt-3">
                            <label for="api-key" class="col-md-4 col-form-label text-md-end">{{ __('API Key') }}</label>

                            <div class="col-md-6">
                                <input id="api-key" name="api_key" class="form-control" autocomplete="api-amplitude" autofocus>
                            </div>
                        </div>

                        @error('api_key')
                            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                <p>{{ $message }}</p>
                            </div>
                        @enderror

                        @if(in_array($type, [
                            'amplitude',
                            'mixpanel', 
                            'intercom'
                            ]))
                        <div class="row mb-3 mt-3">
                            <label for="api-secret" class="col-md-4 col-form-label text-md-end">{{ __('API Secret') }}</label>

                            <div class="col-md-6">
                                <input id="api-secret" name="api_secret" class="form-control" autocomplete="current-password">
                            </div>
                        </div>

                        @error('api_secret')
                            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                                <p>{{ $message }}</p>
                            </div>
                        @enderror

                        @endif

                
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 mt-3">
                                <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
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