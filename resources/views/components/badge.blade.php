@props(['variant'=>'primary'])
@php
    $classes = 'inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 ';
    switch ($variant) {
        case 'secondary':
            $classes .= 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80';
            break;
        case 'destructive':
            $classes .= 'border-transparent bg-destructive text-destructive-foreground shadow hover:bg-destructive/80';
            break;
        case 'outline':
            $classes .= 'text-foreground';
            break;
        case 'primary':
        default:
            $classes .= 'border-transparent bg-primary text-primary-foreground shadow hover:bg-primary/80';
            break;
    }
@endphp
<span {{ $attributes->merge(['class' => $classes]) }}>
    {{$slot}}
</span>
