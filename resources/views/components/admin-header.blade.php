@props(['title', 'subtitle', 'backRoute' => null, 'backText' => 'Kembali', 'actionButton' => null])

<div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-rshp-dark-gray">{{ $title }}</h1>
                @if($subtitle)
                    <p class="text-gray-600 mt-1">{{ $subtitle }}</p>
                @endif
            </div>
            <div class="flex items-center space-x-4">
                @if($backRoute)
                    <a href="{{ $backRoute }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ $backText }}
                    </a>
                @endif
                
                @if($actionButton)
                    {{ $actionButton }}
                @endif
            </div>
        </div>
    </div>
</div>
