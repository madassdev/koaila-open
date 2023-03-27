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
                            $usage_tracking_tools= [
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
                                    'secret' => 'API Secret'
                                ],

                            ]
                        @endphp

                        @if(in_array($type, array_keys($usage_tracking_tools)))

                            @foreach(array_keys($usage_tracking_tools[$type]) as $field)
                                <x-forms.input id={{$field}} name={{$field}} label={{$usage_tracking_tools[$type][$field]}}></x-forms.input>
                            @endforeach

                        @endif

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 mt-3 flex justify-end">
                                <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded" v-track.integration_form_submit>
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
