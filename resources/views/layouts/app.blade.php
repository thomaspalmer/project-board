@extends('layouts.base')

@section('body')
    <div class="flex flex-col min-h-screen bg-gray-50">
        <div class="w-full bg-white border-b border-gray-100">
            <div class="max-w-7xl w-full mx-auto py-4 flex justify-between items-center">
                <a href="{{ route('home') }}">
                    <x-logo />
                </a>

                <div class="space-x-4">
                    @auth
                        <x-nav-link
                            href="{{ route('home') }}"
                        >
                            Dashboard
                        </x-nav-link>

                        <x-nav-link
                            href="{{ route('sources') }}"
                        >
                            Sources
                        </x-nav-link>

                        <x-nav-link
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                            Log Out
                        </x-nav-link>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="max-w-7xl w-full mx-auto py-12">
            @yield('content')

            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
    </div>
@endsection
