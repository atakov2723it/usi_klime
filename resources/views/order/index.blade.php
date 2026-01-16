<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            @if(auth()->user()->is_admin)
                Sve porudžbine
            @else
                Moje porudžbine
            @endif
        </h2>

    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Narudžbina #{{ $order->id }}</div>

                                <div class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                    @if($order->status === 'paid') bg-green-100 text-green-700
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700
                                    @endif
                                ">
                                    {{ strtoupper($order->status) }}
                                </div>
                                    
                            </div>

                            <div class="text-right">
                                <div class="text-xs text-gray-500">Ukupno</div>
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ number_format((int)$order->total, 0, ',', '.') }} RSD
                                </div>
                                <td class="text-right">
    <a href="{{ route('admin.orders.edit', $order) }}"
       class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-indigo-700">
        Edit
    </a>

    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit"
                onclick="return confirm('Obrisati porudžbinu?')"
                class="inline-flex items-center rounded-lg bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-700">
            Obriši
        </button>
    </form>
</td>

                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-sm text-gray-600">
                            Trenutno nemate narudžbina.
                        </div>
                    @endforelse
                </div>
            </div>
                
        </div>
    </div>
    
</x-app-layout>
