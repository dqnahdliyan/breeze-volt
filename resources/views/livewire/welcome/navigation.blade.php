<div class="z-50 flex items-center justify-end p-6 space-x-3 sm:fixed sm:top-0 sm:right-0 text-end">
    <x-theme-switch class="inline-flex items-center"/>
    @auth
        <a href="{{ url('/dashboard') }}" class="font-semibold hover:text-zinc-500 focus:outline-none" wire:navigate>Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="font-semibold hover:text-zinc-500 focus:outline-none" wire:navigate>Log
            in</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ms-4 font-semibold hover:text-zinc-500 focus:outline-none"
               wire:navigate>Register</a>
        @endif
    @endauth
</div>
