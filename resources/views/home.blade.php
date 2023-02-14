@extends('layouts.app')
@vite(['resources/js/home.js'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="text-xl py-8">{{ __('Dashboard') }}</h1>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($ttl = $results->firstWhere('type','time_to_value'))
                    <h1>hello1</h1>
                        {{-- <line-chart :labels= "[
                            '2022-04-08',
                            '2022-04-09',
                        ]"
                        :data= "[
                            1,
                            2,
                        ]"
                        :name= "'Time to value'"></line-chart> --}}
                    @endif

                    @if($daumauData = $results->firstWhere('type','daumau'))
                        {{-- <line-chart 
                        :labels= "['2022-04-08','2022-04-09']" 
                        :datasets= "[{
                              label: 'Data One',
                              data: [40, 39]
                        }]"></line-chart> --}}
                        <line-chart 
                        :data= '{!!json_encode($daumauData)!!}'
                        :label= '"DAU/MAU"'
                        ></line-chart>
                    @endif

                    @if ($upsell = $results->firstWhere('type','upsell'))
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 text-left bg-white dark:text-white dark:bg-gray-800">
                                <p class="text-lg font-semibold text-gray-900">Users to upsell</p>
                                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Here is a list of users to upsell with the reason we believe they might convert! 
                                <br/>The column of this table are the most common events among users who were previously upsold.</p>
                            </div>
                            <div class="p-4 text-right">
                                <p class="text-lg font-semibold text-gray-900">Number of users identified</p>
                                <p class="text-3xl text-green-400 mb-4">{{count($upsell->data['rows'])}}</p>
                                <a href="{{URL('/csv/'.Auth::user()->result_file_name)}}" target="_blank" class="bg-blue-700 hover:bg-blue-800 text-white font-bold p-3 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    <span>{{ __('Download') }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="flex grow overflow-x-auto">
                            <table class="relative w-full border text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead>
                                    <tr>
                                    @foreach($upsell->data['headers'] as $header)
                                        <th scope="col" class="sticky top-0 px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">{{ ucfirst(trans(str_replace('_', ' ', $header))) }}</th>
                                    @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($upsell->data['rows'] as $row)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            @foreach($row as $key=>$value)
                                                @if($key=='')
                                                    <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                        {{$value}}
                                                    </th>
                                                @elseif($key=='likelihood')
                                                    @if($value=='high')
                                                        <td class="px-6 py-4 text-center text-2xl text-green-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline">
                                                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                            </svg>
                                                        </td>
                                                    @else
                                                        <td class="px-6 py-4 text-center text-2xl text-blue-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 inline">
                                                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                            </svg>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td class="px-6 py-4 text-center">{{$value}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(!isset($row) & !isset($daumauData) & !isset($timeToValueFilePath))
                        {{ __('You are logged in!') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
