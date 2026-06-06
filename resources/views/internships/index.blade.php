<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Internships
        </h2>
    </x-slot>

    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Internships Overview</h1>

        @forelse($internships as $internship)
            <div class="border p-3 mb-2">
                Internship #{{ $internship->id }}
            </div>
        @empty
            <p>No internships found.</p>
        @endforelse
    </div>
</x-app-layout>