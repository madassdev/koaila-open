<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Koaila") }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com" />
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @stack('customer-dashboard-scripts')
    </head>
    <body>
        <div id="app" class="min-h-screen flex flex-col">
            <div
                class="fixed top-0 left-0 right-0 z-50 w-full h-12 flex items-center px-6 bg-white shadow-sm"
            >
            <div class="flex items-center justify-between w-full">

                <div class="space-x-2 flex items-center">
                    <img src="{{ asset('logo-square.png') }}" class="w-8 h-8" />
                </div>

                <div class="space-x-4">
                    @guest
                    <a href="{{route('login')}}" class="text-gray-600 hover:text-blue-600">Login</a>
                    <a href="{{route('register')}}" class="text-gray-600 hover:text-blue-600">Sign Up</a>
                    @endguest
                </div>
            </div>
            </div>
            @auth
            <x-layouts.sidebar />
            @endauth
            <div class="mt-12 @auth ml-56 @endauth p-3" id="yield">@yield('content')</div>
        </div>

        @if(\Illuminate\Support\Facades\Auth::check())
        <script defer>
            window.onload = function () {
                window.amplitude.setUserId(
                    "{{\Illuminate\Support\Facades\Auth::user()->email}}"
                );
            };
        </script>
        @endif

        <script>
            $(document).ready(function () {
                $(".toggler").on("click", function () {
                    // Toggle visibility of children nav links.
                    const child = $(this)
                        .siblings(".nav-collapsed")
                        .toggleClass("hidden");

                    // Rotate icon.
                    var icon = $(this).children(".toggleIcon");
                    $(icon).toggleClass("rotate-90");
                });
            });
        </script>
    </body>
</html>
