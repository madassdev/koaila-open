@extends('layouts.app')

@section('content')
<div class="container flex grow flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
    <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
        <img class="w-8 h-8 mr-2" src="{{asset('logo.svg')}}" alt="logo">
        Koaila
    </a>
    <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Name') }}</label>
                    <div>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Email Address') }}</label>
                    <div>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Company Name') }}</label>
                    <div>
                        <input id="company_name" type="company_name" class="form-control @error('company_name') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" name="company_name" value="{{ old('company_name') }}" required autocomplete="company-name">
                        @error('company_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Password') }}</label>
                    <div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Confirm Password') }}</label>
                    <div>
                        <input id="password-confirm" type="password" class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <button class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" v-track.register_click>
                    {{ __('Register') }}
                </button>

            </form>
        </div>
    </div>
</div>

@endsection
