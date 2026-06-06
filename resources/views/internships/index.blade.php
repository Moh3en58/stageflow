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
                <br>
<a href="{{ route('internships.edit', $internship) }}">Edit</a>
<form action="{{ route('internships.destroy', $internship) }}" method="POST">
    @csrf
    @method('DELETE')

    <button type="submit">Delete</button>
</form>
                <strong>{{ $internship->title }}</strong><br>
                {{ $internship->description }}<br>
                {{ $internship->start_date }} - {{ $internship->end_date }}<br>
                Status: {{ $internship->status }}
            </div>
        @empty
            <p>No internships found.</p>
        @endforelse

    </div>
</x-app-layout>