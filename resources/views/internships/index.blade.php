<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Internships
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                Internships Overview
            </h1>

            <a href="{{ route('internships.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                New Internship
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @forelse($internships as $internship)

            <div class="border rounded-lg p-5 mb-5 shadow bg-white">

                <h3 class="text-lg font-bold mb-3">
                    {{ $internship->title }}
                </h3>

                <p>
                    <strong>Company:</strong>
                    {{ $internship->company->name ?? 'N/A' }}
                </p>

                <p>
                    <strong>Description:</strong>
                    {{ $internship->description }}
                </p>

                <p>
                    <strong>Start:</strong>
                    {{ $internship->start_date }}
                </p>

                <p>
                    <strong>End:</strong>
                    {{ $internship->end_date }}
                </p>

                <p class="mb-4">
                    <strong>Status:</strong>
                    {{ ucfirst($internship->status) }}
                </p>

                <div class="flex gap-5">

                    <a href="{{ route('internships.show', $internship) }}"
                       class="text-blue-600 hover:underline">
                        View
                    </a>

                    <a href="{{ route('internships.edit', $internship) }}"
                       class="text-green-600 hover:underline">
                        Edit
                    </a>

                    <form action="{{ route('internships.destroy', $internship) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="text-red-600 hover:underline"
                            onclick="return confirm('Are you sure?')">

                            Delete

                        </button>

                    </form>

                </div>

            </div>

        @empty

            <p>No internships found.</p>

        @endforelse

    </div>

</x-app-layout>