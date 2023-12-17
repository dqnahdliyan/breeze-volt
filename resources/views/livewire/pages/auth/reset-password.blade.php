<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state('token')->locked();

state([
    'email' => fn() => request()->string('email')->value(),
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'token' => ['required'],
    'email' => ['required', 'string', 'email'],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$resetPassword = function () {
    $this->validate();

    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    $status = Password::reset(
        $this->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) {
            $user->forceFill([
                'password' => Hash::make($this->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    // If the password was successfully reset, we will redirect the user back to
    // the application's home authenticated view. If there is an error we can
    // redirect them back to where they came from with their error message.
    if ($status != Password::PASSWORD_RESET) {
        $this->addError('email', __($status));

        return;
    }

    Session::flash('status', __($status));

    $this->redirectRoute('login', navigate: true);
};

?>

<div>
    <form wire:submit="resetPassword">
        <!-- Email Address -->
        <div>
            <x-label for="email">{{__('Email')}}</x-label>
            <x-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
                     autofocus autocomplete="username" :messages="$errors->get('email')"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-label for="password">{{ __('Password') }}</x-label>
            <x-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
                     required autocomplete="new-password" :messages="$errors->get('password')"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-label for="password_confirmation">{{ __('Confirm Password') }}</x-label>
            <x-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                     type="password"
                     name="password_confirmation" required autocomplete="new-password"
                     :messages="$errors->get('password_confirmation')"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button type="submit">
                {{ __('Reset Password') }}
            </x-button>
        </div>
    </form>
</div>
