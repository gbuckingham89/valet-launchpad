@extends('skeleton')

@section('page')

    @if($projects->isNotEmpty())
        <div class="w-full space-y-3" x-ref="projects">
            @foreach($projects as $project)
                <div class="js--project bg-white shadow rounded px-3 py-2 flex flex-col sm:flex-row sm:items-center sm:justify-between dark:bg-zinc-700" x-data="{ name: {{ \Illuminate\Support\Js::from($project->getName()) }} }" x-bind:class="search.length && !name.toLowerCase().includes(search.toLowerCase()) && 'hidden'">
                    <div>
                        <div class="mb-1 flex items-center justify-start">
                            <p class="font-semibold leading-snug">
                                <a href="{{ $project->getSites()->first()->getUrl() }}" title="{{ $project->getName() }}" class="rounded-sm line-clamp-1 text-laravel-500 hover:text-laravel-700 hover:underline focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-laravel-200 dark:text-white dark:hover:text-zinc-300 dark:focus:ring-offset-zinc-700 dark:focus:ring-zinc-300">
                                    {{ $project->getName() }}
                                </a>
                            </p>
                            @if($project->getSites()->count()>1)
                                <div class="flex items-center relative ml-1" x-data="{ open: false }" x-on:click.outside="open = false">
                                    <button x-on:click.prevent="open = !open" type="button" title="More hosts" class="rounded-sm text-laravel-300 hover:text-laravel-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-laravel-200 focus:text-laravel-400 dark:text-zinc-300 dark:hover:text-zinc-100 dark:hover:bg-zinc-800 dark:focus:ring-zinc-400 dark:focus:text-zinc-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="absolute z-10 bg-white shadow-md rounded border top-5 left-0 w-48 dark:bg-zinc-800 dark:border-zinc-400" x-show="open" x-cloak>
                                        <ul class="text-xs leading-snug py-1">
                                            @foreach($project->getSites() as $site)
                                                <li>
                                                    <a href="{{ $site->getUrl() }}" title="{{ $site->getUrl() }}" class="block break-all px-2 py-1 text-laravel-500 hover:bg-gray-50 hover:text-laravel-600 focus:outline-none focus:ring-2 focus:ring-laravel-200 focus:rounded-sm dark:text-zinc-300 dark:hover:bg-zinc-900 dark:hover:text-white dark:focus:ring-zinc-300">{{ $site->getUrl() }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p class="text-xs break-all text-gray-400 dark:text-zinc-400">{{ $project->getPath() }}</p>
                    </div>
                    @if($project->getPhpSemverConstraint()!==null)
                        <div class="my-1 sm:my-0 sm:ml-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium dark:opacity-90 {{ $project->supportedOnCurrentPhpVersion() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">PHP: {{ $project->getPhpSemverConstraint() }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div x-cloak x-show="!numSearchResults && search.length" class="my-6 py-3 text-center text-sm">
            <p class="text-gray-700 dark:text-zinc-100">You don't have any projects with a name containing <span class="font-bold" x-text="search"></span>.</p>
        </div>

    @else
        <div class="my-6 py-3 text-center text-sm">
            <p class="text-gray-700 dark:text-zinc-100">It appears you don't have any projects being served through Laravel Valet.</p>
            <p class="text-gray-500 dark:text-zinc-400 mt-4 text-xs">Need some help? <a class="text-gray-500 underline hover:text-laravel-500 focus:rounded-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-laravel-200 dark:text-zinc-400 dark:hover:text-zinc-100 dark:focus:ring-zinc-200 dark:focus:ring-offset-zinc-800" href="https://laravel.com/docs/valet#serving-sites" target="_blank" title="Laravel Valet documentation">Read the Laravel Valet docs &raquo;</a></p>
        </div>
    @endif

@endsection
