<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Register Final Grade
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-6">
            <div class="rounded-lg bg-white p-6 shadow-sm">

                <h1 class="text-2xl font-bold">{{ $internship->title }}</h1>

                <div class="mt-4 rounded-lg bg-gray-50 p-4">
                    <p><strong>Student:</strong> {{ $internship->user->name ?? '-' }}</p>
                    <p><strong>Company:</strong> {{ $internship->company->name ?? '-' }}</p>
                </div>

                @if($errors->any())
                    <div class="mt-5 rounded border border-red-300 bg-red-50 p-4 text-red-700">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('final-grades.store') }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <input type="hidden" name="internship_id" value="{{ $internship->id }}">

                    <div>
                        <label for="grade" class="block font-semibold">
                            Final grade (0–20)
                        </label>

                        <input
                            id="grade"
                            name="grade"
                            type="number"
                            min="0"
                            max="20"
                            step="0.1"
                            value="{{ old('grade') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300"
                        >
                    </div>

                    <div>
                        <label for="feedback" class="block font-semibold">
                            Teacher feedback
                        </label>

                        <textarea
                            id="feedback"
                            name="feedback"
                            rows="6"
                            maxlength="5000"
                            class="mt-1 block w-full rounded-md border-gray-300"
                        >{{ old('feedback') }}</textarea>
                    </div>

                    <div class="flex justify-between border-t pt-5">
                        <a href="{{ route('final-grades.index') }}">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            style="background:#1d4ed8;color:white;padding:10px 18px;border-radius:6px;font-weight:700;"
                        >
                            Save Final Grade
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>