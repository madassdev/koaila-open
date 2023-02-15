@extends('layouts.app')
@vite(['resources/js/home.js'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="text-xl py-8">{{ __('Configuration') }}</h1>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 class="text-lg"> Conversion channels</h1>
                    <form method="POST" action="{{ route('create-configuration', ['type'=>'aha_moment']) }}">
                        @csrf      
                        
                        @if(session()->has('message'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                                <p>{{ session()->get('message') }}</p>
                            </div>
                        @endif

                        <config-form :existing_config='$existing_config'></config-form>
                
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 mt-3">
                                <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <h1 class="text-lg"> AHA Moment</h1>
                    <form method="POST" action="{{ route('create-configuration', ['type'=>'aha_moment']) }}">
                        @csrf      
                        
                        @if(session()->has('message'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                                <p>{{ session()->get('message') }}</p>
                            </div>
                        @endif

                        <config-form :existing_config='$existing_config'></config-form>
                
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
