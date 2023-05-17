@props(['upsellStats','upsell', 'customers'])

@if($upsellStats)
    <div class="grid lg:grid-cols-3 md:grid-cols-1 gap-4 mt-4 h-auto">
        <div class="bg-white rounded p-4">
            <h1 class="text-lg font-semibold text-gray-900 text-center">{{$upsellStats->data['number_of_users_to_upsell']}} users to upsell</h1>
        </div>
        <div class="bg-white rounded p-4">
            <h1 class="text-lg font-semibold text-center">
                <span class="text-gray-900">Predicted MRR:</span>
                <span class="text-green-500"> + {{$upsellStats->data['total_predicted_mrr']}} USD</span>
            </h1>
        </div>
        <div class="bg-white rounded p-4">
            <h1 class="text-lg font-semibold text-center">
                <span class="text-gray-900">Predicted ARR:</span>
                <span class="text-green-500"> + {{$upsellStats->data['total_predicted_arr']}} USD</span>
            </h1>
        </div>
    </div>
@endif

@php
    $hiddenCustomers=$customers?->whereNotNull('hidden_at');
    $customers=$customers?->whereNull('hidden_at');
@endphp

@if($customers?->count())
<div class="bg-white rounded mt-4" id="upsell-table">
    <div class="p-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 text-left bg-white">
                <h1 class="text-lg font-semibold text-gray-900">Users to upsell</h1>
                <p class="mt-1 text-sm font-normal text-gray-500">The column of this table are the most common events among users who were previously upsold.</p>
            </div>
            <div class="p-4 text-right">
                <div class="flex justify-end items-center">
                    <a href="{{route('upsell-download')}}"
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

        <div class="flex flex-col h-screen">
            <div class="flex grow overflow-x-auto">
                <table class="relative w-full border text-sm text-left text-gray-500">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center">{{ 'Email' }}</th>
                        @foreach(array_keys($customers->first()->latestState->state) as $header)
                            @switch($header)
                                @case('events')
                                    @break
                                @case('funnel_step')
                                    @break
                                @default
                                    <th scope="col"
                                        class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center">{{ ucfirst(trans(str_replace('_', ' ', $header))) }}</th>
                            @endswitch
                        @endforeach
                        <th scope="col" class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($customers as $customer)
                        <tr class="bg-white border-b">
                            <th scope="row"
                                class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap text-center">
                                <a href="{{ route('customer-dashboard', ['id'=>$customer['id']]) }}">{{$customer['email']}}</a>
                            </th>
                            @foreach($customer->latestState->state as $key=>$value)
                                @if($key=='likelihood')
                                    <td class="px-6 py-4 text-center text-2xl text-green-600">
                                        <div class="flex items-center">
                                            @foreach (range(1, $value) as $item)
                                                <svg aria-hidden="true" class="w-5 h-5 text-yellow-400"
                                                     fill="currentColor" viewBox="0 0 20 20"
                                                     xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title>
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endforeach
                                            @if(5-$value != 0)
                                                @foreach(range(1, 5-$value) as $item)
                                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-200"
                                                         fill="currentColor" viewBox="0 0 20 20"
                                                         xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title>
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                @elseif($key=='funnel_step')
                                @elseif($key!='events')
                                    <td class="px-6 py-4 text-center">{{$value}}</td>
                                @endif
                            @endforeach
                            <td>
                                <form method="POST" action="{{ route('hide-customer-state', $customer->id) }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <button type="submit" onclick="return confirm('Are you sure you want to hide this user from the list?')" class="focus:outline-none text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

@if($hiddenCustomers?->count())
    <div class="bg-white rounded mt-4" id="upsell-table">
        <div class="p-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 text-left bg-white">
                    <h1 class="text-lg font-semibold text-gray-900">Hidden users</h1>
                    <p class="mt-1 text-sm font-normal text-gray-500">These are users you chose to hide but appear in the analysis.</p>
                </div>
                <div class="p-4 text-right">
                    <div class="flex justify-end items-center">
                        <a href="{{route('upsell-download')}}"
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

            <div class="flex flex-col">
                <div class="flex">
                    <table class="w-full border text-sm text-left text-gray-500">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center">{{ 'Email' }}</th>
                            @foreach(array_keys($hiddenCustomers->first()->latestState->state) as $header)
                                @switch($header)
                                    @case('events')
                                        @break
                                    @case('funnel_step')
                                        @break
                                    @default
                                        <th scope="col"
                                            class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center">{{ ucfirst(trans(str_replace('_', ' ', $header))) }}</th>
                                @endswitch
                            @endforeach
                            <th scope="col" class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($hiddenCustomers as $hiddenCustomer)
                            <tr class="bg-white border-b">
                                <th scope="row"
                                    class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap text-center">
                                    <a href="{{ route('customer-dashboard', ['id'=>$hiddenCustomer['id']]) }}">{{$hiddenCustomer['email']}}</a>
                                </th>
                                @foreach($hiddenCustomer->latestState->state as $key=>$value)
                                    @if($key=='likelihood')
                                        <td class="px-6 py-4 text-center text-2xl text-green-600">
                                            <div class="flex items-center">
                                                @foreach (range(1, $value) as $item)
                                                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400"
                                                         fill="currentColor" viewBox="0 0 20 20"
                                                         xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title>
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endforeach
                                                @if(5-$value != 0)
                                                    @foreach(range(1, 5-$value) as $item)
                                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-200"
                                                             fill="currentColor" viewBox="0 0 20 20"
                                                             xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title>
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                    @elseif($key=='funnel_step')
                                    @elseif($key!='events')
                                        <td class="px-6 py-4 text-center">{{$value}}</td>
                                    @endif
                                @endforeach
                                <td>
                                    <form method="POST" action="{{ route('hide-customer-state', $hiddenCustomer->id) }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <button type="submit" onclick="return confirm('Are you sure you want to hide this user from the list?')" class="focus:outline-none text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
