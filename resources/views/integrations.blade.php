@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="bg-white rounded mt-4" id="upsell-table">
            <div class="p-4">

            <h1 class="text-xl py-3">{{ __('Integrations') }}</h1>
            <p class="py-3">If the tool you're using is not listed, please contact us and we'll get it up running!</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div >
                <div >
                    <div class="grid grid-cols-2 gap-4 pb-10">
                        @foreach([[
                            'name' => 'Amplitude',
                            'image' => 'amplitude.png',
                            'slug' => 'amplitude',
                            'description' =>'Sync your Amplitude data to uncover upsell opportunities'
                            ],[
                            'name' => 'Mixpanel',
                            'image' => 'mixpanel.svg',
                            'slug' => 'mixpanel',
                            'description' =>'Sync your Mixpanel data to uncover upsell opportunities'
                            ],[
                            'name' => 'Stripe',
                            'image' => 'stripe.jpeg',
                            'slug' => 'stripe',
                            'description' =>'Sync your Stripe data for more accurate results'
                            ],
                            [
                            'name' => 'Hubspot',
                            'image' => 'hubspot.png',
                            'slug' => 'hubspot',
                            'description' =>'Sync your Hubspot data for more accurate results'
                            ],
                            ] as $usage_tracking_provider)
                            <div class="w-full rounded border border-gray-200 p-2 relative hover:bg-gray-50">
                                <div class="grid grid-cols-2 items-center p-2">
                                    <div class="w-12">
                                        <img src="{{ asset('images/'. $usage_tracking_provider['image']) }}" class="block object-contain object-center w-full rounded-lg" alt="{{$usage_tracking_provider['name']}} Logo"/>
                                    </div>
                                    @if(Auth::user()->integrations()->where('type', $usage_tracking_provider['slug'])->first()?->data)
                                        <div class="flex justify-end">
                                            <p class="h-6 inline-block rounded text-green-500 bg-green-200 px-2 py-1 text-xs font-bold mr-3">Connected</p>
                                        </div>
                                    @endif
                                </div>
                                <p class="p-2 font-bold">{{$usage_tracking_provider['name']}}</p>
                                <p class="px-2">{{$usage_tracking_provider['description']}}</p>
                                <a class="absolute inset-0" href="{{ route('integrations-forms', ['type'=>$usage_tracking_provider['slug']]) }}"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>
@endsection
