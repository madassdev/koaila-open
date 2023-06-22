@extends('layouts.app') @section('content')
<div class="container">
    <div class="mb-4">
        <p class="font-bold text-2xl">Account settings</p>
        <p class="text-gray-500 text-xs">
            Manage your account settings and update your personal information and password here.
        </p>
    </div>
    <div class="card">
        <div class="card-body space-y-8 p-5">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif @if(session()->has('message'))
            <div
                class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4"
                role="alert"
            >
                <p>{{ session()->get('message') }}</p>
            </div>
            @endif 
            @php 
                $routes = [ 
                    "personal_info" => route('settings.personalInfo.save'),
                    "password" => route('settings.password.save'), 
                ]; 
            @endphp

            <user-account-settings
                :user="{{ json_encode($user) }}"
                :errors="{{json_encode($errors->messages())}}"
                :routes="{{ json_encode($routes) }}"
                :old-values="{{ json_encode(old()) }}"
            ></user-account-settings>
        </div>
    </div>
</div>
@endsection
