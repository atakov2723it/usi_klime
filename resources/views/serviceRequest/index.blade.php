<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Servisni zahtevi (admin)
            </h2>

            <a href="{{ route('admin.service-requests.create') }}"
               class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                + Novi zahtev
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-xl overflow-hidden">
                @if($serviceRequests->isEmpty())
                    <div class="p-6">
                        <p class="text-gray-500">Nema servisnih zahteva.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-left text-gray-600 bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Korisnik</th>
                                    <th class="px-6 py-3">Telefon</th>
                                    <th class="px-6 py-3">Adresa</th>
                                    <th class="px-6 py-3">Datum</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Akcije</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @foreach($serviceRequests as $sr)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-3">{{ $sr->id }}</td>
                                        <td class="px-6 py-3">{{ $sr->user->name ?? '—' }}</td>
                                        <td class="px-6 py-3">{{ $sr->phone }}</td>
                                        <td class="px-6 py-3">{{ $sr->address }}</td>
                                        <td class="px-6 py-3">
                                            {{ optional($sr->preferred_date)->format('Y-m-d') ?? $sr->preferred_date }}
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                                {{ $sr->status }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-3 text-right space-x-2 whitespace-nowrap">
                                            <a href="{{ route('admin.service-requests.show', $sr) }}"
                                               class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-semibold text-gray-800 hover:bg-gray-200">
                                                Pregled
                                            </a>

                                            <a href="{{ route('admin.service-requests.edit', $sr) }}"
                                               class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-indigo-700">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.service-requests.destroy', $sr) }}"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Obrisati servisni zahtev #{{ $sr->id }}?')"
                                                        class="inline-flex items-center rounded-lg bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-700">
                                                    Obriši
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
