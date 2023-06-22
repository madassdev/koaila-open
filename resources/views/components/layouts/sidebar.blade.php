<div
    class="fixed top-0 bottom-0 left-0 w-56 z-20 bg-gray-900 text-white mt-12 p-3"
>
    <div class="space-y-8 p-3">
        <div class="">
            <p class="font-bold">{{auth()->user()->name}}</p>
            <p class="text-gray-400 text-sm">{{auth()->user()->email}}</p>
        </div>
        <hr />
        <div class="w-full">
            <div
                class="flex items-center justify-between cursor-pointer space-x-2 toggler uppercase"
            >
                <div class="flex items-center space-x-2">
                    @svg('chart-bar-square', '', 'currentColor')
                    <span>{{ __("Dashboard") }}</span>
                </div>
                <span class="toggleIcon transform rotate-180">
                    @svg('chevron-right', '', 'currentColor')
                </span>
            </div>
            <div class="space-y-2 nav-collapsed p-3">
                <a
                    class="flex items-center space-x-2 text-gray-400 hover:text-white"
                    href="{{ route('upsell-dashboard') }}"
                >
                    <span>{{ __("Upsell") }}</span>
                </a>
                <a
                    class="flex items-center space-x-2 text-gray-400 hover:text-white"
                    href="{{ route('upsell-historic-dashboard') }}"
                >
                    <span>{{ __("Upsell History") }}</span>
                </a>
            </div>
        </div>

        <div class="w-full">
            <div
                class="flex items-center justify-between cursor-pointer space-x-2 toggler uppercase"
            >
                <div class="flex items-center space-x-2">
                    @svg('cog-8-tooth','', 'currentColor')

                    <span>{{ __("Settings") }}</span>
                </div>
                <span class="toggleIcon transform rotate-180">
                    @svg('chevron-right', '', 'currentColor')
                </span>
            </div>
            <div class="space-y-2 nav-collapsed p-3">
                <a
                    class="flex items-center space-x-2 text-gray-400 hover:text-white"
                    href="{{ route('integrations') }}"
                >
                    <span>{{ __("Integrations") }}</span>
                </a>
                <a
                    class="flex items-center space-x-2 text-gray-400 hover:text-white"
                    href="{{ route('configuration') }}"
                >
                    <span>{{ __("Configuration") }}</span>
                </a>
            </div>
        </div>

        <div class="w-full">
            <div
                class="flex items-center justify-between cursor-pointer space-x-2 toggler uppercase"
            >
                <div class="flex items-center space-x-2">
                    @svg('account-circle','', 'currentColor')

                    <span>{{ __("Account") }}</span>
                </div>
                <span class="toggleIcon transform rotate-180">
                    @svg('chevron-right', '', 'currentColor')
                </span>
            </div>
            <div class="space-y-2 nav-collapsed p-3">
                <a
                    class="flex items-center space-x-2 text-gray-400 hover:text-white"
                    href="{{ route('account-settings.index') }}"
                >
                    <span>{{ __("Profile") }}</span>
                </a>
            </div>
        </div>

        <div
            class="flex items-center cursor-pointer space-x-2 toggler uppercase"
        >
            <a
                class="flex items-center space-x-2"
                href="{{
                    url(
                        'https://illustrious-perch-600.notion.site/Getting-started-10min-37dd19cc7503474a8409893aebacaaa6'
                    )
                }}"
            >
                @svg('life-buoy', '', 'currentColor')
                <span>{{ __("Help") }}</span>
            </a>
        </div>

        <hr />
        <div
            class="flex items-center cursor-pointer space-x-2 toggler uppercase"
        >
            <a
                class="flex items-center space-x-2"
                href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            >
                @svg('logout', '', 'currentColor')

                <span>{{ __("Logout") }}</span>
            </a>
        </div>
        <form
            id="logout-form"
            action="{{ route('logout') }}"
            method="POST"
            class="d-none"
        >
            @csrf
        </form>
    </div>
</div>
