<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Katalog uređaja') }}
            </h2>

            <div class="text-sm text-gray-500">
                {{ __('Prodaja i servis klima uređaja') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- FILTER BAR --}}
            <div class="bg-white shadow-sm rounded-xl p-4">
                <form method="GET" action="{{ route('catalog.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pretraga</label>
                        <input
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="npr. Samsung, inverter..."
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min cena</label>
                        <input
                            name="min_price"
                            value="{{ request('min_price') }}"
                            placeholder="0"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max cena</label>
                        <input
                            name="max_price"
                            value="{{ request('max_price') }}"
                            placeholder="500000"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="w-full inline-flex justify-center items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                        >
                            Filtriraj
                        </button>

                        <a
                            href="{{ route('catalog.index') }}"
                            class="w-full inline-flex justify-center items-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200"
                        >
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- LISTA PROIZVODA --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($products as $p)
                    <div class="bg-white shadow-sm rounded-xl p-5 flex flex-col">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $p->name }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ $p->brand }}
                                </p>
                            </div>

                            <div class="text-right">
                                <div class="text-xs text-gray-500">Cena</div>
                                <div class="text-lg font-bold text-gray-900">
                                    {{ number_format((float)$p->price, 0, ',', '.') }} RSD
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-gray-600 space-y-1">
                            @if(!empty($p->power))
                                <div><span class="font-medium text-gray-800">Snaga:</span> {{ $p->power }}</div>
                            @endif

                            @if(!empty($p->type))
                                <div><span class="font-medium text-gray-800">Tip:</span> {{ $p->type }}</div>
                            @endif

                            @if(!empty($p->warranty_months))
                                <div><span class="font-medium text-gray-800">Garancija:</span> {{ $p->warranty_months }} meseci</div>
                            @endif
                        </div>

                        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between gap-3">
                            <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">

                                <input
                                    type="number"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    class="w-20 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-black"
                                >
                                    Dodaj
                                </button>
                            </form>

                            @auth
                                <form method="POST" action="{{ route('checkout.store') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700"
                                    >
                                        Kupi
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                    Login za kupovinu
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white shadow-sm rounded-xl p-6 text-gray-600">
                            Nema proizvoda za zadate filtere.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
