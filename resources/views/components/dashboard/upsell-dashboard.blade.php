@props(['upsellStats','upsell', 'customersByPlans'])

@php
    // Extract all hidden  customers in each group and flatten to a single array
    $hiddenCustomers=$customersByPlans?->map(function($plan){
        return $plan['customers']->filter(function($customer){
            return $customer->hidden_at;
        });
    })->flatten();
@endphp

@if($customersByPlans?->count())
<div class="bg-white rounded mt-4" id="upsell-table">
    <div class="p-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 text-left bg-white">
                <h1 class="text-lg font-semibold text-gray-900">Users to upsell</h1>
                <p class="mt-1 text-sm font-normal text-gray-500">The column of this table are the most common events among users who were previously upsold.</p>
            </div>
            <div class="p-4 text-right">
                <div class="flex justify-end items-center">
                    <a href="{{route('upsell-download', ['type'=>'visible'])}}"
                       target="_blank" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200" v-track.upsell_user_list_download_click>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        <span>{{ __('Download') }}</span>
                    </a>
                </div>
            </div>
        </div>

        <customer-upsell-list-by-plan :data='{!!json_encode($customersByPlans)!!}'>
        </customer-upsell-list-by-plan>

        
    </div>
</div>
@endif

