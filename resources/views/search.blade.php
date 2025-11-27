<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Search</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white shadow rounded-lg p-6">

        <form action="{{ route('search.results') }}" method="GET" class="flex gap-3">
            <input type="text" name="query" class="w-full border rounded px-3 py-2" placeholder="Cari produk...">
           <button type="submit" class="px-4 py-2 bg-[#D90368] text-white rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </form>
    </div>
</x-app-layout>
