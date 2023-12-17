<!DOCTYPE html>
<html x-cloak x-data="{ darkMode: $persist(false) }" :class="{ 'dark': darkMode === true }"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    <script>
        function setMetaThemeColor(setting) {
            const metaThemeColor = document.getElementById("theme-color-meta");
            if (metaThemeColor) {
                switch (setting) {
                    case 'dark':
                        metaThemeColor.setAttribute("content", "#09090b");
                        break;
                    case 'light':
                        metaThemeColor.setAttribute("content", "#ffffff");
                        break;
                    case 'system':
                        window.matchMedia('(prefers-color-scheme: dark)').matches ? metaThemeColor.setAttribute("content",
                            "#020713") : metaThemeColor.setAttribute("content", "#ffffff");
                        break;
                    default:
                        metaThemeColor.setAttribute("content", "#ffffff")
                }
            }
        }

        function updateTheme() {
            const themes = ['light', 'dark', 'system'];
            const currentTheme = localStorage.getItem('theme') || 'system';
            themes.forEach((theme) => {
                document.documentElement.classList.remove(theme)
            });
            if (currentTheme === 'system') {
                window.matchMedia('(prefers-color-scheme: dark)').matches ? document.documentElement.classList.add('dark') :
                    document.documentElement.classList.add('light')
            } else {
                document.documentElement.classList.add(currentTheme)
            }
            setMetaThemeColor(currentTheme)
        }

        updateTheme();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (localStorage.getItem('theme') === 'system') {
                e.matches ? document.documentElement.classList.add('dark') : document.documentElement.classList
                    .remove('dark');
                setMetaThemeColor('system')
            }
        })
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0">
        <x-theme-switch class="absolute top-4 right-4" />
        <div>
            <a href="/" wire:navigate>
                <x-application-logo class="w-20 h-20 fill-current" />
            </a>
        </div>

        <x-card class="w-full mt-6 overflow-hidden sm:max-w-md">
            {{ $slot }}
        </x-card>
    </div>
</body>

</html>
