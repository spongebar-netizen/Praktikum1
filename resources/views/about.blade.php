<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('About') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Nama:Lalu Idrak Yadafi Fatan Nuraga") }}
                    <br>
                    {{ __("NIM:20230140134") }}
                    <br>
                    {{ __("Prodi: Teknik Informatika") }}
                    <br>
                    {{ __("Hobi:Memuji KING RIFQI") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>