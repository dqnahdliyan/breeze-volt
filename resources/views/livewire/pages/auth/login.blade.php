<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');
form(LoginForm::class);

$login = function () {
    $this->validate();
    $this->form->authenticate();
    Session::regenerate();
    $this->redirect(
        session('url.intended', RouteServiceProvider::HOME),
        navigate: true
    );
};

?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form wire:submit="login">
        <!-- Email Address / Username -->
        <div>
            <x-label for="username">{{ __('Email / Username') }}</x-label>
            <x-input wire:model="form.username" id="username" type="text" name="username" class="mt-1"
                     required autofocus autocomplete="username" :messages="$errors->get('login')"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <x-label for="password">{{ __('Password') }}</x-label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                       href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <x-input wire:model="form.password" id="password" class="block mt-1 w-full"
                     type="password"
                     name="password"
                     required autocomplete="current-password" :messages="$errors->get('password')"/>
        </div>


        <!-- Remember Me -->
        <div class="flex items-center justify-between my-4">
            <div class="flex items-center space-x-2">
                <x-checkbox wire:model="form.remember" id="remember" type="checkbox"
                            name="remember"/>
                <x-label for="remember">{{ __('Remember me') }}</x-label>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('register'))
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                   href="{{ route('register') }}" wire:navigate>
                    {{ __('Don\'t have an account?') }}
                </a>
            @endif
            <x-button type="submit" class="ms-3">
                {{ __('Login') }}
            </x-button>
        </div>
    </form>
</div>
