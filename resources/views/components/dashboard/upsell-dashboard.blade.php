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

@if($customers->count())
<div class="bg-white rounded mt-4" id="upsell-table">
    <div class="p-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 text-left bg-white dark:text-white dark:bg-gray-800">
                <h1 class="text-lg font-semibold text-gray-900">Users to upsell</h1>
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">The column of this table are the most common events among users who were previously upsold.</p>
            </div>
            <div class="p-4 text-right">
                <div class="flex justify-end items-center">
                    <a href="{{route('upsell-download')}}"
                       target="_blank" class="bg-blue-700 hover:bg-blue-800 text-white font-bold p-3 rounded" v-track.upsell_user_list_download_click>
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
                <table class="relative w-full border text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-center">{{ 'Email' }}</th>
                        @foreach(array_keys($customers->first()->latestState->state) as $header)
                            @switch($header)
                                @case('events')
                                    @break
                                @case('funnel_step')
                                    @break
                                @default
                                    <th scope="col"
                                        class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-center">{{ ucfirst(trans(str_replace('_', ' ', $header))) }}</th>
                            @endswitch
                        @endforeach
                        <th scope="col" class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($customers as $customer)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white text-center">
                                <a href="{{ route('customer-dashboard', ['email'=>$customer['email']]) }}">{{$customer['email']}}</a>
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
                                <form method="POST" action="{{ route('delete-customer-state', $customer->latestState->id) }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="submit" onclick="return confirm('Are you sure you want to delete this user from the upsell list?')" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" value="Delete user">
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
