<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Izmena porudžbine #{{ $order->id }}
            </h2>

            <a href="{{ route('admin.orders.index') }}"
               class="inline-flex items-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-200">
                Nazad
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-red-800">
                    <div class="font-semibold mb-1">Greške:</div>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-xl p-6">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>

                        @php
                            $current = old('status', $order->status);
                            $statuses = [
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'shipped' => 'Shipped',
                                'cancelled' => 'Cancelled',
                            ];
                        @endphp

                        <select name="status"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" @selected($current === $value)>{{ $label }}</option>
                            @endforeach
                        </select>

                        <p class="mt-2 text-xs text-gray-500">
                            Dozvoljeni statusi: pending, paid, shipped, cancelled
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <a href="{{ route('admin.orders.index') }}"
                           class="inline-flex items-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-200">
                            Otkaži
                        </a>

                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Sačuvaj
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
                            