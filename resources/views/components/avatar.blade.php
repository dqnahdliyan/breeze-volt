@props(['src','alt'])
@php
    $image = ($src === 'NULL') ? 'https://www.gravatar.com/avatar/?d=mp&f=y' : $src ;
@endphp

<div {{ $attributes->merge(['class' => 'relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full']) }} >
    <img alt="{{$alt}}" src="{{ $image }}" class="aspect-square w-full h-full">
</div>
