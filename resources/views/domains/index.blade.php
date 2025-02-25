@extends('layouts.app')

@section('title', 'Domains')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(empty(env('CLOUDFLARE_API_TOKEN')))
        <!-- API Token Not Set Warning -->
        <div class="rounded-2xl bg-yellow-50 p-6 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-yellow-800">Cloudflare API Token Required</h3>
                    <div class="mt-2">
                        <p class="text-yellow-700">Please set your Cloudflare API token in the .env file:</p>
                        <div class="mt-3 bg-yellow-100 rounded-lg p-4 font-mono text-sm">
                            CLOUDFLARE_API_TOKEN=your_api_token_here
                        </div>
                        <p class="mt-3 text-sm text-yellow-700">
                            You can generate an API token from your 
                            <a href="https://dash.cloudflare.com/profile/api-tokens" target="_blank" class="font-medium underline hover:text-yellow-800">
                                Cloudflare dashboard
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Header with Stats -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Your Domains</h2>
                        <p class="mt-1 text-sm text-gray-500">Manage your Cloudflare domains and DNS records</p>
                    </div>
                    <button type="button" 
                            onclick="window.location.reload()"
                            class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-sm hover:shadow">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh
                    </button>
                </div>
                
                <!-- Quick Stats -->
                <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="bg-orange-50 rounded-xl px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ count($domains) }}</h3>
                                <p class="text-sm text-gray-500">Total Domains</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-xl px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ count(array_filter($domains, fn($domain) => $domain['status'] === 'active')) }}
                                </h3>
                                <p class="text-sm text-gray-500">Active Domains</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-xl px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ array_sum(array_map(fn($domain) => count($domain['name_servers'] ?? []), $domains)) }}</h3>
                                <p class="text-sm text-gray-500">Name Servers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Domain Cards Grid -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            @foreach($domains as $domain)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden border border-gray-100">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $domain['name'] }}</h3>
                                <span class="flex-shrink-0 inline-block px-3 py-0.5 text-sm font-medium {{ $domain['status'] === 'active' ? 'text-green-800 bg-green-100' : 'text-yellow-800 bg-yellow-100' }} rounded-full">
                                    {{ ucfirst($domain['status']) }}
                                </span>
                            </div>
                            <div class="mt-3 flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    {{ $domain['type'] }}
                                </span>
                                @if($domain['name_servers'] ?? false)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ count($domain['name_servers']) }} NS
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="flex-shrink-0">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full {{ time() - strtotime($domain['modified_on']) < 3600 ? 'bg-green-100' : 'bg-gray-100' }}">
                                        <svg class="h-4 w-4 {{ time() - strtotime($domain['modified_on']) < 3600 ? 'text-green-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium text-gray-500">Last checked</span>
                                    <span class="text-sm {{ time() - strtotime($domain['modified_on']) < 3600 ? 'text-green-600 font-medium' : 'text-gray-900' }}">
                                        {{ \Carbon\Carbon::parse($domain['modified_on'])->diffForHumans([
                                            'parts' => 2,
                                            'short' => true,
                                            'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW
                                        ]) }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('domains.records', $domain['id']) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Manage Records
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if(count($domains) === 0)
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No domains found</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding your first domain to Cloudflare.</p>
        </div>
        @endif
    </div>
</div>
@endsection 