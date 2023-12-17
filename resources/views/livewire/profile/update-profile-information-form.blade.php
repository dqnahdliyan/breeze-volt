<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use function Livewire\Volt\state;

state([
    'name' => fn() => auth()->user()->name,
    'email' => fn() => auth()->user()->email,
    'username' => fn() => auth()->user()->username,
    'about' => fn() => auth()->user()->about
]);

$updateProfileInformation = function () {
    $user = Auth::user();

    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        'username' => ['nullable', 'string', 'alpha_dash', Rule::unique(User::class)->ignore($user->id)],
        'about' => ['nullable', 'string', 'max:255'],
    ]);

    $user->fill($validated);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();
    $this->dispatch('profile-updated', name: $user->name);
};

$sendVerification = function () {
    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        $path = session('url.intended', RouteServiceProvider::HOME);

        $this->redirect($path);

        return;
    }
    $user->sendEmailVerificationNotification();

    Session::flash('status', 'verification-link-sent');
};

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-4">
        <div>
            <x-label for="name">{{ __('Name') }}</x-label>
            <x-input wire:model="name" id="name" name="name" type="text" required
                     autofocus autocomplete="name" :messages="$errors->get('name')"/>
        </div>

        <div>
            <x-label for="email">{{ __('Email') }}</x-label>
            <x-input wire:model="email" id="email" name="email" type="email" required
                     autocomplete="username" :messages="$errors->get('email')"/>

            @if (auth()->user() instanceof MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-label for="username">{{ __('Username') }}</x-label>
            <x-input wire:model="username" id="username" username="name" type="text"
                     autocomplete="username" :messages="$errors->get('username')"/>
        </div>

        <div>
            <x-label for="about">{{ __('About') }}</x-label>
            <x-textarea wire:model="about" id="about"
                        autocomplete="about" :messages="$errors->get('username')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-button type="submit">{{ __('Save') }}</x-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
        <x-toast on="profile-updated">Saved</x-toast>
    </form>
</section>
