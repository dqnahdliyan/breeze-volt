@props([
    'disabled' => false,
    'name' => null,
    'value' => null,
])

<div class='flex items-center gap-2'>
    <input {{ $disabled ? 'disabled' : '' }} type="radio" name="{{ $name }}" value="{{ $value }}"
        id="{{ $value }}"
        {{ $attributes->merge(['class' => 'w-4 h-4 border rounded-full shadow appearance-none peer border-primary focus:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 checked:bg-background checked:text-primary-foreground']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="absolute w-4 h-4 text-background fill-background peer-checked:fill-foreground" viewBox="0 0 16 16">
        <path
            d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
    </svg>
    <label for="{{ $value }}"
        class='text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70'>
        {{ $slot }}
    </label>
</div>
