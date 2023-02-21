@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1 class="text-xl py-3">{{ __('Integrations') }}</h1>
            <p class="py-3">If the tool you're using is not listed, please contact us and we'll get it up running!</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h1 class="text-base">Usage Tracking Tools</h1>
                    <div class="grid grid-cols-4 gap-4 pb-10">
                        @foreach([[
                            'name' => 'Amplitude',
                            'image' => 'amplitude.png',
                            'slug' => 'amplitude'
                            ],[
                            'name' => 'Mixpanel',
                            'image' => 'mixpanel.svg',
                            'slug' => 'mixpanel'
                            ]] as $usage_tracking_provider)
                            <div class="w-full rounded bg-gray-50 p-2 relative">
                                @if(Auth::user()->integrations()->where('type', $usage_tracking_provider['slug'])->first()?->data)
                                <div class="flex justify-end">
                                    <p class="inline-block rounded-full text-white bg-green-400 px-2 py-1 text-xs font-bold mr-3">Connected</p>
                                </div>
                                @endif
                                <img src="{{ asset('images/'. $usage_tracking_provider['image']) }}"class="block object-contain object-center w-full rounded-lg p-4" alt="{{$usage_tracking_provider['name']}} Logo"/>
                                <p class="text-center">{{$usage_tracking_provider['name']}}</p>
                                <a class="absolute inset-0" href="{{ route('integrations-forms', ['type'=>$usage_tracking_provider['slug']]) }}"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
