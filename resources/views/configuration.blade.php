@extends('layouts.app')

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

                    @foreach (
                        [
                            'conversion_channels'=>'Conversion channels',
                            'aha_moment'=>'Aha Moment',
                            'feature' => 'Features'
                        ]
                     as $configType => $configTitle)

                    {{-- Form is in blade to go faster but ultimately, it should be moved to the ConfigForm component. --}}
                    <form method="POST" action="{{ route('create-configuration', ['type'=>$configType]) }}">
                        @csrf

                        <config-form title="{{$configTitle}}" :existing-config='{!!json_encode($existingConfigs->where('type',$configType)->first()?->configuration)!!}'></config-form>

                        <div class="row grid grid-cols-3 px-3">
                            <div class="flex justify-center col-start-2 mt-3">
                                <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded" v-track.configurations_form_submit>
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    @if(!$loop->last)
                        <hr class="m-3">
                    @endif

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
