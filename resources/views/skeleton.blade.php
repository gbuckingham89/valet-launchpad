<!DOCTYPE html>
<html lang="en" class="min-h-screen">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}

    <link rel="stylesheet" href="{{ mix('/assets/build/app.css') }}" type="text/css">
</head>
<body class="bg-gray-100 dark:bg-zinc-800 antialiased" x-data="{ search: '', numSearchResults: null }" x-on:keyup.slash="$refs.search.focus()" x-on:keydown.cmd.f.prevent="$refs.search.focus()" x-on:keydown.ctrl.f.prevent="$refs.search.focus()">

    <nav class="bg-white border-b shadow-sm dark:bg-zinc-500 dark:bg-opacity-30 dark:border-b-transparent">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col items-center sm:flex-row sm:justify-between">
            <p class="shrink-0 mb-3 sm:mb-0 text-lg sm:text-xl px-3 py-2 leading-none rounded shadow-md font-bold text-center text-shadow text-white bg-gradient-to-r from-laravel-600 via-laravel-500 to-laravel-600 dark:bg-none dark:bg-zinc-800">{{ config('app.name') }}</p>
            <div class="w-full sm:w-80">
                <input autofocus type="search" placeholder="Search projects..."  autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" x-ref="search" x-model="search" x-on:keydown.esc.prevent="$refs.search.blur()" x-on:keyup="numSearchResults = $refs.projects.querySelectorAll('div.js--project:not(.hidden)').length" x-on:change="numSearchResults = $refs.projects.querySelectorAll('div.js--project:not(.hidden)').length" class="appearance-none w-full block px-2 sm:px-3 py-1 leading-6 sm:leading-7 rounded border shadow text-sm text-gray-700 bg-white focus:outline-none focus:ring-1 focus:ring-laravel-300 focus:border-laravel-300 dark:bg-zinc-800 dark:border-zinc-500 dark:shadow-none dark:text-zinc-200 dark:focus:ring-zinc-200 dark:focus:border-zinc-200 dark:placeholder-zinc-400">
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-3">
            @yield('page')
        </div>
        <div class="mt-6 border-t dark:border-t-zinc-500 py-6">
            <p class="text-xs text-center text-gray-400 dark:text-zinc-400">Powered by <a class="text-gray-400 underline hover:text-laravel-500 focus:rounded-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-laravel-200 dark:text-zinc-400 dark:hover:text-zinc-100 dark:focus:ring-zinc-200 dark:focus:ring-offset-zinc-800" href="https://www.github.com/gbuckingham89/valet-launchpad" title="gbuckingham89/valet-launchpad" target="_blank">Valet Launchpad</a>.</p>
        </div>
    </div>

<script type="application/javascript" src="{{ mix('/assets/build/app.js') }}" defer></script>
</body>
</html>
