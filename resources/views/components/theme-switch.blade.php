<div {{$attributes->merge(['class' => 'block'])}}>
    <x-tooltip>
        <x-slot name="trigger">
            <x-button size="icon" variant="ghost" x-data
                      @click="darkMode=!darkMode">
                <x-lucide-moon class="h-6 w-6 dark:hidden block"/>
                <x-lucide-sun class="h-6 w-6 hidden dark:block"/>
            </x-button>
        </x-slot>
        <span>Theme Switch</span>
    </x-tooltip>
</div>
