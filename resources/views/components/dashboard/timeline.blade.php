@props(['saleFunnel','customerStep'])

@if($saleFunnel)
    <ol class="items-center sm:flex py-4">
        @foreach($saleFunnel->data as $step)
            <li class="relative mb-6 sm:mb-0">
                <div class="flex items-center">
                    @if($customerStep == $step)
                        <div class="z-10 flex items-center justify-center w-6 h-6 bg-green-100 rounded-full ring-0 ring-green-500 dark:bg-green-700 sm:ring-8 dark:ring-green-900 shrink-0">
                            <svg aria-hidden="true" class="w-3 h-3 text-green-800 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                    @else
                        <div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-gray-100 dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                            <svg aria-hidden="true" class="w-3 h-3 text-blue-800 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                    @endif
                    <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                </div>
                <div class="mt-3 sm:pr-8">
                    <h3 class="text-md font-semibold text-gray-900 dark:text-white">{{ ucfirst(trans(str_replace('_', ' ', $step))) }}</h3>
                </div>
            </li>
        @endforeach
    </ol>
@endif
