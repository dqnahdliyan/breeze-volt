<div className="relative w-full overflow-auto">
    <table {{ $attributes->merge(['class' => 'w-full caption-bottom text-sm']) }}>
        {{ $slot }}
    </table>
</div>
