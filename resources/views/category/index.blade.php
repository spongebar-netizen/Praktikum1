<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a202c] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight">Category List</h2>
                            <p class="text-sm text-gray-400 mt-1">Manage your category</p>
                        </div>
                        <a href="{{ route('category.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition duration-150 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Category
                        </a>
                    </div>

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-900/50 border border-green-500 rounded-lg text-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-700 bg-[#2d3748]">
                        <table class="w-full text-left text-sm whitespace-nowrap text-gray-300">
                            <thead class="bg-[#2a3441] border-b border-gray-700 font-medium text-gray-400 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-4">#</th>
                                    <th class="px-6 py-4">NAME</th>
                                    <th class="px-6 py-4">TOTAL PRODUCT</th>
                                    <th class="px-6 py-4 text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse($categories as $index => $category)
                                    <tr class="hover:bg-[#344054] transition">
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">{{ $category->name }}</td>
                                        <td class="px-6 py-4">{{ $category->products_count }}</td>
                                        <td class="px-6 py-4 flex justify-center gap-3">
                                            <a href="{{ route('category.edit', $category) }}" class="text-gray-400 hover:text-indigo-400 transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('category.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-400 transition" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada kategori yang ditambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
