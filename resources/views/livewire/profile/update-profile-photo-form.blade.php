<?php

use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\{rules, state, usesFileUploads};

usesFileUploads();

state(['photo']);

rules([
    'photo' => ['required', 'max:2048', 'image', 'mimes:png,jpg,jpeg'],
]);

$updatePhoto = function () {
    $this->validate();
    if (file_exists(Auth::user()->photo)) {
        unlink(Auth::user()->photo);
    }
    $validated['photo'] = 'storage/' . $this->photo->store('profile-photos');
    Auth::user()->update([
        'photo' => $validated['photo'],
    ]);

    $this->reset('photo');
    $this->dispatch('photo-updated');
};

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile photo.') }}
        </p>
    </header>

    <form wire:submit="updatePhoto" class="mt-6 space-y-3">
        <div class="flex items-center gap-2">
            @if($photo)
                <x-avatar src="{{$photo->temporaryUrl()}}" alt="Preview"
                          class="w-16 h-16 border-2 cursor-pointer"
                          @click="document.getElementById('photo').click()"
                />
            @else
                <x-avatar src="{{Auth::user()->photo}}" alt="{{Auth::user()->name}}"
                          class="w-16 h-16 border-2 cursor-pointer"
                          @click="document.getElementById('photo').click()"
                />
            @endif
            @error('photo') <span class="text-sm text-red-600 space-y-0.5">{{ $message }}</span> @enderror
            <input type="file" wire:model="photo" name="photo" id="photo" class="hidden" accept="image/*">
        </div>

        <div class="flex items-center gap-4">
            <x-button type="submit">{{ __('Save') }}</x-button>

            <x-action-message class="me-3" on="photo-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
