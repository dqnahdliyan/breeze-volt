<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
]);

$updatePassword = function () {
    try {
        $validated = $this->validate();
    } catch (ValidationException $e) {
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    $this->reset('current_password', 'password', 'password_confirmation');

    $this->dispatch('password-updated');
};

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-3">
        <div>
            <x-label for="update_password_current_password">{{ __('Current Password') }}</x-label>
            <x-input wire:model="current_password" id="update_password_current_password" name="current_password"
                     type="password" class="mt-1 block w-full" autocomplete="current-password"
                     :messages="$errors->get('current_password')"/>
        </div>

        <div>
            <x-label for="update_password_password">{{ __('New Password') }}</x-label>
            <x-input wire:model="password" id="update_password_password" name="password" type="password"
                     class="mt-1 block w-full" autocomplete="new-password" :messages="$errors->get('password')"/>
        </div>

        <div>
            <x-label for="update_password_password_confirmation">{{ __('Confirm New Password') }}</x-label>
            <x-input wire:model="password_confirmation" id="update_password_password_confirmation"
                     name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password"
                     :messages="$errors->get('password_confirmation')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-button type="submit">{{ __('Save') }}</x-button>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
