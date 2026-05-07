<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a202c] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    
                    {{-- Header --}}
                    <div class="flex items-center mb-6">
                        <a href="{{ route('category.index') }}" class="p-1.5 rounded-md text-gray-400 hover:text-gray-200 hover:bg-gray-700 transition mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-xl font-bold tracking-tight">Add Category</h2>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('category.store') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Electronic"
                                   class="w-full px-4 py-2.5 rounded-lg border bg-[#2d3748] text-gray-100 placeholder-gray-500
                                   {{ $errors->has('name') ? 'border-red-500' : 'border-gray-600 focus:border-indigo-500' }}
                                   focus:outline-none focus:ring-1 focus:ring-indigo-500 transition">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-4">
                            <a href="{{ route('category.index') }}" class="px-4 py-2.5 rounded-lg border border-gray-600 text-sm font-medium text-gray-300 hover:bg-gray-700 transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                Save Category
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
