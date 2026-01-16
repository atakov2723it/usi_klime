<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Moje narudžbine
            </h2>

            <div class="text-sm text-gray-500">
                Prodaja i servis klima uređaja
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- TABOVI --}}
            <div class="bg-white shadow-sm rounded-xl p-4 flex gap-3">
                <a href="{{ route('orders.mine') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('orders.mine') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Narudžbine
                </a>

                <a href="{{ route('service.mine') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('service.mine') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Moji servisi
                </a>
            </div>

            {{-- LISTA SERVISA --}}
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="font-semibold text-gray-900">Moji servisi</div>
                    <a href="{{ route('service.create') }}"
                       class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        Novi zahtev
                    </a>
                </div>

                <div class="p-4">
                    @forelse($serviceRequests as $sr)
                        <div class="border border-gray-100 rounded-xl p-4 mb-3">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $sr->address ?? 'Adresa nije uneta' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Telefon: {{ $sr->phone ?? '-' }} · Datum: {{ $sr->preferred_date ?? '-' }}
                                    </div>
                                </div>

                                <div class="text-sm font-semibold text-gray-700">
                                    {{ $sr->status ?? 'pending' }}
                                </div>
                            </div>

                            @if(!empty($sr->description))
                                <div class="mt-3 text-sm text-gray-700">
                                    {{ $sr->description }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-gray-600">
                            Nemaš nijedan zahtev za servis.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
