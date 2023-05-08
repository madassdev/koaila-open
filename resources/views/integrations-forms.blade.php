@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="inline-flex p-3">
                <p class="capitalize"> {{ $type }} integration</p>
                @if(Auth::user()->integrations()->where('type', $type)->first()?->data)
                <p class="inline-block rounded-full text-white bg-green-400 px-2 py-1 text-xs font-bold ml-3">Connected</p>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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

                    <form method="POST" action="{{ route('create-integration', ['type'=>$type]) }}">
                        @csrf

                        @if(session()->has('message'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                                <p>{{ session()->get('message') }}</p>
                            </div>
                        @endif

                        @php
                            $basic_authentication= [
                                'amplitude' => [
                                    'key' => 'API Key',
                                    'secret' => 'API Secret'
                                ],
                                'mixpanel' => [
                                    'key' => 'Service Account Name',
                                    'secret' => 'Service Account Secret'
                                ],
                                'stripe' => [
                                    'key' => 'API Key',
                                ],
                            ];
                            $oauth_authentication=[
                                'hubspot'=> [
                                    'image'=>'hubspot.png'
                                ]
                            ]
                        @endphp

                        @if(in_array($type, array_keys($basic_authentication)))
                            @foreach(array_keys($basic_authentication[$type]) as $field)
                                <x-forms.input id={{$field}} name={{$field}} label={{$basic_authentication[$type][$field]}}></x-forms.input>
                            @endforeach
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 mt-3 flex justify-end">
                                    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" v-track.integration_form_submit>
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if(in_array($type, array_keys($oauth_authentication)))
                            <div class="grid justify-items-center">
                                    <img src="{{ asset('images/'. $oauth_authentication[$type]['image']) }}" class="block object-contain object-center w-20 rounded-lg py-4" alt="{{$type}} Logo"/>
                                    <h1 class="text-lg">Hubspot</h1>
                                    <a class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{ route('oauth.redirect', $type) }}">Connect</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
