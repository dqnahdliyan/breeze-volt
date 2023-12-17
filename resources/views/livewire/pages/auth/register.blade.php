<?php

use App\Livewire\Forms\RegisterForm;
use App\Providers\RouteServiceProvider;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');
form(RegisterForm::class);

$register = function () {
    $this->form->store();
    $this->redirect(RouteServiceProvider::HOME, navigate: true);
};

?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-label for="name">{{ __('Name') }}</x-label>
            <x-input wire:model="form.name" id="name" class="block mt-1 w-full" type="text" name="name" required
                     autofocus autocomplete="name" :messages="$errors->get('form.name')"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-label for="email">{{ __('Email') }}</x-label>
            <x-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required
                     autocomplete="username" :messages="$errors->get('form.email')"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-label for="password">{{ __('Password') }}</x-label>
            <x-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password" name="password"
                     required autocomplete="new-password" :messages="$errors->get('form.password')"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-label for="password_confirmation">{{ __('Confirm Password') }}</x-label>
            <x-input wire:model="form.password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                     type="password" name="password_confirmation" required autocomplete="new-password"
                     :messages="$errors->get('form.password_confirmation')"/>

        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('login'))
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                   href="{{ route('login') }}" wire:navigate>
                    {{ __('Already registered?') }}
                </a>
            @endif
            <x-button type="submit" class="ms-4">
                {{ __('Register') }}
            </x-button>
        </div>
    </form>
</div>
