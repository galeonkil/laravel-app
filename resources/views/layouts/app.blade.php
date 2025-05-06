<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100"">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full overflow-hidden">
        <div class="h-full bg-gray-100">
    
            <!--
            This example requires updating your template:
          
            ```
            <html class="h-full bg-gray-100">
            <body class="h-full overflow-hidden">
            ```
            -->
            <div class="flex h-full flex-col">

              {{ $slot }}
            </div>
             
          
        </div>
    </body>
</html>
