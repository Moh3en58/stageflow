<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Internship details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4">
                    {{ $internship->title }}
                </h3>

                <div class="space-y-2">
                    <p><strong>Student:</strong> {{ $internship->user->name ?? 'Unknown' }}</p>
                    <p><strong>Company:</strong> {{ $internship->company->name ?? 'No company' }}</p>
                    <p><strong>Description:</strong> {{ $internship->description }}</p>
                    <p><strong>Start date:</strong> {{ $internship->start_date }}</p>
                    <p><strong>End date:</strong> {{ $internship->end_date }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($internship->status) }}</p>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('internships.index') }}" class="text-blue-600">
                        Back
                    </a>

                    <a href="{{ route('internships.edit', $internship) }}" class="text-green-600">
                        Edit
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>