<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Zakazivanje servisa
            </h2>

            <div class="text-sm text-gray-500">
                Prodaja i servis klima uređaja
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">
                <form method="POST" action="{{ route('service.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresa</label>
                        <input name="address" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('address') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                            <input name="phone" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('phone') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Željeni datum</label>
                            <input type="date" name="preferred_date" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('preferred_date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Opis problema</label>
                        <textarea name="note" rows="4" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('description') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('catalog.index') }}"
                           class="inline-flex items-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                            Nazad
                        </a>

                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Pošalji zahtev
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
