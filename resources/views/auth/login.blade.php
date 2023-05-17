@extends('layouts.app')

@section('content')
    <div class="container flex grow flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
            <img class="w-8 h-8 mr-2" src="{{asset('logo.svg')}}" alt="logo">
            Koaila
        </a>
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Email Address') }}</label>

                        <div>
                            <input id="email" type="email" class="@error('email') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
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

                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="form-check flex items-center h-5">
                                <input class="form-check-input w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-gray-500">Remember me</label>
                                </div>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-blue-600 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>

                    <button class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" v-track.login_click>
                        {{ __('Login') }}
                    </button>

                    <p class="text-sm font-light text-gray-500">
                        Don’t have an account yet? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

@endsection


