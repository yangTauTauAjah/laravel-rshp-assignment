@if(session('success'))
<div class="fixed top-4 right-4 z-50 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-lg animate-fade-in" id="flash-message">
    <div class="flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="closeFlashMessage()" class="ml-4 text-green-700 hover:text-green-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
@endif

@if(session('error'))
<div class="fixed top-4 right-4 z-50 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-lg animate-fade-in" id="flash-message">
    <div class="flex items-center justify-between">
        <span>{{ session('error') }}</span>
        <button onclick="closeFlashMessage()" class="ml-4 text-red-700 hover:text-red-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
@endif

@if(session('info'))
<div class="fixed top-4 right-4 z-50 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg shadow-lg animate-fade-in" id="flash-message">
    <div class="flex items-center justify-between">
        <span>{{ session('info') }}</span>
        <button onclick="closeFlashMessage()" class="ml-4 text-blue-700 hover:text-blue-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
@endif

<script>
    function closeFlashMessage() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.display = 'none';
        }
    }

    // Auto-close flash message after 5 seconds
    setTimeout(() => {
        closeFlashMessage();
    }, 5000);
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>
