<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Internship</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('internships.update', $internship) }}">
            @csrf
            @method('PUT')

            <div>
                <label>Title</label><br>
                <input type="text" name="title" value="{{ $internship->title }}" class="border p-2 w-full">
            </div>

            <div class="mt-4">
                <label>Description</label><br>
                <textarea name="description" class="border p-2 w-full">{{ $internship->description }}</textarea>
            </div>

            <div class="mt-4">
                <label>Start date</label><br>
                <input type="date" name="start_date" value="{{ $internship->start_date }}" class="border p-2 w-full">
            </div>

            <div class="mt-4">
                <label>End date</label><br>
                <input type="date" name="end_date" value="{{ $internship->end_date }}" class="border p-2 w-full">
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
</x-app-layout>