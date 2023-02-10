@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1 class="text-xl py-8">{{ __('Integrations') }}</h1>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <h1 class="text-base">Usage Tracking</h1>
            <div class="grid grid-cols-4 gap-4 pb-10">
                @foreach([[
                    'name' => 'Amplitude',
                    'image' => 'amplitude.png',
                    'slug' => 'amplitude'
                    ],[
                    'name' => 'Mixpanel',
                    'image' => 'mixpanel.svg',
                    'slug' => 'mixpanel'
                    ],[
                    'name' => 'Intercom',
                    'image' => 'intercom.png',
                    'slug' => 'intercom'
                    ]] as $usage_tracking_provider)
                    <div class="w-full rounded bg-white p-2 relative">
                        <img src="{{ asset('images/'. $usage_tracking_provider['image']) }}"class="block object-contain object-center w-full rounded-lg p-4" alt="{{$usage_tracking_provider['name']}} Logo"/>
                        <p class="text-center">{{$usage_tracking_provider['name']}}</p>
                        <a class="absolute inset-0" href="{{ route('integrations-forms', ['type'=>$usage_tracking_provider['slug']]) }}"></a>
                    </div>
                @endforeach
                    </div>

            <h1 class="text-base">Payment Processing</h1>
            <div class="grid grid-cols-4 gap-4 pb-8">
            @foreach([[
                    'name' => 'Stripe',
                    'image' => 'stripe.jpeg',
                    'slug' => 'stripe'
                    ],[
                    'name' => 'Paypal',
                    'image' => 'paypal.png',
                    'slug' => 'paypal'
                    ]] as $payment_processing_provider)
                    <div class="w-full rounded bg-white p-2 relative">
                        <img src="{{ asset('images/'. $payment_processing_provider['image']) }}"class="block object-contain object-center w-full rounded-lg p-4" alt="{{$payment_processing_provider['name']}} Logo"/>
                        <p class="text-center">{{$payment_processing_provider['name']}}</p>
                        <a class="absolute inset-0" href="{{ route('integrations-forms', ['type'=>$payment_processing_provider['slug']]) }}"></a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
