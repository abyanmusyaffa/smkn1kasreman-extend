<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">Edit Nilai: {{ $alumni->name }}</h2>

    <form wire:submit.prevent="updateScores">
        <table class="w-full table-auto text-sm border mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Mata Pelajaran</th>
                    <th class="px-4 py-2 border">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scores as $index => $score)
                    <tr>
                        <td class="px-4 py-2 border">{{ $score['subject'] }}</td>
                        <td class="px-4 py-2 border">
                            <input
                                type="number"
                                wire:model.defer="scores.{{ $index }}.score"
                                class="border rounded px-2 py-1 w-full"
                                min="0"
                                max="100"
                            >
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <x-filament::button type="submit">
            Simpan Nilai
        </x-filament::button>
    </form>
</x-filament-panels::page>
