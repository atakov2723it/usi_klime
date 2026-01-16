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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-data="{ tab: 'orders' }" class="bg-white shadow-sm rounded-xl">
                {{-- Tabs --}}
                <div class="border-b border-gray-100 px-6">
                    <nav class="-mb-px flex gap-6">
                        <button
                            type="button"
                            @click="tab='orders'"
                            :class="tab==='orders' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="py-4 border-b-2 text-sm font-medium"
                        >
                            Moje porudžbine
                        </button>

                        <button
                            type="button"
                            @click="tab='services'"
                            :class="tab==='services' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="py-4 border-b-2 text-sm font-medium"
                        >
                            Moji servisi
                        </button>
                    </nav>
                </div>

                {{-- ORDERS --}}
                <div x-show="tab==='orders'" class="p-6">
                    @if($orders->isEmpty())
                        <div class="text-gray-600">Nema porudžbina.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-gray-500">
                                    <tr>
                                        <th class="py-2">ID</th>
                                        <th class="py-2">Status</th>
                                        <th class="py-2">Ukupno</th>
                                        <th class="py-2">Datum</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($orders as $o)
                                        <tr class="text-gray-800">
                                            <td class="py-3">{{ $o->id }}</td>
                                            <td class="py-3">{{ $o->status }}</td>
                                            <td class="py-3">{{ number_format((float)$o->total, 0, ',', '.') }} RSD</td>
                                            <td class="py-3">{{ optional($o->created_at)->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- SERVICES --}}
                <div x-show="tab==='services'" class="p-6">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div class="text-gray-600">Pregled tvojih servisnih zahteva.</div>
                        <a href="{{ route('service.create') }}"
                           class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Zakaži servis
                        </a>
                    </div>

                    @if($services->isEmpty())
                        <div class="text-gray-600">Nema servisnih zahteva.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-gray-500">
                                    <tr>
                                        <th class="py-2">ID</th>
                                        <th class="py-2">Adresa</th>
                                        <th class="py-2">Telefon</th>
                                        <th class="py-2">Željeni datum</th>
                                        <th class="py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($services as $s)
                                        <tr class="text-gray-800">
                                            <td class="py-3">{{ $s->id }}</td>
                                            <td class="py-3">{{ $s->address ?? '-' }}</td>
                                            <td class="py-3">{{ $s->phone ?? '-' }}</td>
                                            <td class="py-3">{{ $s->desired_date ?? '-' }}</td>
                                            <td class="py-3">{{ $s->status ?? 'pending' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
