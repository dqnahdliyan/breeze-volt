<x-app-layout>
    <h2 class="mb-4 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Profile
    </h2>

    <div class="mx-auto space-y-6">

        <x-card>
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>
        </x-card>

        <x-card>
            <div class="max-w-xl">
                <livewire:profile.update-profile-photo-form />
            </div>
        </x-card>

        <x-card>
            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>
        </x-card>

        <x-card>
            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </x-card>

    </div>
</x-app-layout>
