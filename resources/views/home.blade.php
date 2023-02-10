@extends('layouts.app')

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
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 text-left bg-white dark:text-white dark:bg-gray-800">
                            <p class="text-lg font-semibold text-gray-900">Users to upsell</p>
                            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Here is a list of users to upsell with the reason we believe they might convert! 
                            </br>The column of this table are the most common events among users who were previously upsold.</p>
                        </div>
                        <div class="p-4 text-right">
                            <p class="text-lg font-semibold text-gray-900">Number of users identified</p>
                            <p class="text-3xl text-green-400 mb-4">{{count($rows)}}</p>
                            <a href="{{URL('/csv/'.Auth::user()->result_file_name)}}" target="_blank" class="bg-blue-700 hover:bg-blue-800 text-white font-bold p-3 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                <span>{{ __('Download') }}</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 divide-y">
                        @if (isset($rows))
                            <div class="relative overflow-x-auto max-h-96">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                        @foreach($headers as $header)
                                            @if($headers!='cluster' & $headers!='paying')
                                                <th scope="col" class="px-6 py-3">{{ ucfirst(trans(str_replace('_', ' ', $header))) }}</th>
                                            @endif
                                        @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $row)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                @foreach($row as $key=>$value)
                                                    @if($key=='')
                                                        <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                            {{$value}}
                                                        </th>
                                                    @elseif($key=='likelihood')
                                                        @if($value=='high')
                                                            <td class="px-6 py-4 text-center text-2xl">&#128516;</td>
                                                        @else
                                                            <td class="px-6 py-4 text-center text-2xl">&#128522;</td>
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
                        </div>
                        @else
                            {{ __('You are logged in!') }}
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
