<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Izmena servisnog zahteva #{{ $serviceRequest->id }}
            </h2>

            <a href="{{ route('admin.service-requests.index') }}"
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
                <form method="POST" action="{{ route('admin.service-requests.update', $serviceRequest) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                            <input name="phone"
                                   value="{{ old('phone', $serviceRequest->phone) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Željeni datum</label>
                            <input type="date"
                                   name="preferred_date"
                                   value="{{ old('preferred_date', optional($serviceRequest->preferred_date)->format('Y-m-d')) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresa</label>
                        <input name="address"
                               value="{{ old('address', $serviceRequest->address) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @php
                                $statuses = ['new' => 'new', 'scheduled' => 'scheduled', 'done' => 'done', 'cancelled' => 'cancelled'];
                                $current = old('status', $serviceRequest->status);
                            @endphp
                            @foreach($statuses as $val => $label)
                                <option value="{{ $val }}" @selected($current === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Napomena</label>
                        <textarea name="note" rows="4"
                                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('note', $serviceRequest->note) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <a href="{{ route('admin.service-requests.index') }}"
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
