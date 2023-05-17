@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex justify-content-between items-center">
                    <div class="flex items-center gap-4">
                        <img width="100" class="bg-blue-600" src="{{ asset('images/koala.svg') }}">
                        <h1>{{$customer->first()->email}}</h1>
                    </div>

                    <div class="bg-white rounded p-4">
                        <h1 class="text-lg font-semibold text-gray-900 text-center">{{$customer->first()->states->first()->plans}}</h1>
                    </div>
                </div>

                <div>
                    @php
                       $funnelStep= $customer->first()->latestState->state['funnel_step'];
                    @endphp
                    <x-dashboard.timeline :sale-funnel='$saleFunnel' :customer-step='$funnelStep'/>
                </div>

                <div class="grid lg:grid-cols-3 md:grid-cols-1 gap-4 mt-4 h-auto">
                    @foreach([
                        'user_creation_time',
                        'time_to_value',
                        'likelihood',
                    ] as $customer_info)
                        <div class="bg-white rounded p-4">
                            @if($customer_info=='likelihood')
                                <div class="flex justify-center">
                                    @foreach (range(1, $customer->first()->states->first()->state[$customer_info]) as $item)
                                        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400"
                                             fill="currentColor" viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title>
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endforeach
                                    @if(5-$customer->first()->states->first()->state[$customer_info] != 0)
                                        @foreach(range(1, 5-$customer->first()->states->first()->state[$customer_info]) as $item)
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-200"
                                                 fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title>
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                <h1 class="text-lg font-semibold text-gray-900 text-center">{{$customer->first()->states->first()->state[$customer_info]}}</h1>
                            @endif
                            <h1 class="text-center">{{ ucfirst(trans(str_replace('_', ' ', $customer_info))) }}</h1>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white rounded mt-4" id="upsell-table">
                    <div class="p-4">
                        <div class="p-4 text-left bg-white">
                            <h1 class="text-lg font-semibold text-gray-900">User behaviour</h1>
                            <p class="mt-1 text-sm font-normal text-gray-500">Click on the dates below to see the evolution of the user's behaviour over time</p>
                        </div>
                        @foreach($customer->first()->states as $state)
                            <div class="p-4">
                                <h1 onclick="toggleDiv({{json_encode($state['date'])}})" class="flex items-center gap-2 hover:text-blue-600">{{$state['date']}}
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </span>
                                </h1>
                                <div class="flex flex-col">
                                    <div class="flex grow overflow-x-auto">
                                        <table id="{{$state['date']}}" style="display:none" class="relative w-full border text-sm text-left text-gray-500F">
                                                <thead>
                                                    <tr class="bg-white border-b">
                                                        @foreach($state['state']['events'] as $key=>$value)
                                                            <th scope="col" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap text-center">
                                                                {{ ucfirst(trans(str_replace('_', ' ', $key))) }}
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="bg-white border-b">
                                                        @foreach($state['state']['events'] as $key=>$value)
                                                            <td class="px-6 py-4 text-center">{{$value}}</td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('customer-dashboard-scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function toggleDiv(divId) {
            var div = document.getElementById(divId);
            if (div.style.display === "none") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>
@endpush
