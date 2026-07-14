<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Edit Evaluation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-6 rounded-md border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-md border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                    <p class="font-semibold">
                        Please correct the following errors:
                    </p>

                    <ul class="mt-2 list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">

                    <div class="mb-6 border-b pb-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit {{ ucfirst($evaluation->evaluation_type) }}
                            {{ $evaluation->evaluator_role === 'student'
                                ? 'Self-Evaluation'
                                : 'Mentor Evaluation' }}
                        </h1>

                        <p class="mt-2 text-sm text-gray-600">
                            Update the competency scores and comments below.
                        </p>
                    </div>

                    <div class="mb-8 grid grid-cols-1 gap-5 rounded-lg bg-gray-50 p-5 md:grid-cols-2">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Internship
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $evaluation->internship->title }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Student
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $evaluation->internship->user->name ?? 'Unknown student' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Company
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $evaluation->internship->company->name ?? 'Unknown company' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Evaluator role
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ ucfirst($evaluation->evaluator_role) }}
                            </p>
                        </div>
                    </div>

                    <form
                        action="{{ route('evaluations.update', $evaluation) }}"
                        method="POST"
                        class="space-y-6"
                    >
                        @csrf
                        @method('PUT')

                        <div>
                            <h2 class="text-xl font-bold text-gray-900">
                                Competency Scores
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                1 = insufficient, 5 = excellent.
                            </p>
                        </div>

                        @forelse($competencies as $competency)
                            @php
                                $existingScore = $existingScores->get($competency->id);
                            @endphp

                            <div class="rounded-lg border border-gray-200 p-5">
                                <div class="mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $competency->title }}
                                    </h3>

                                    @if($competency->description)
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ $competency->description }}
                                        </p>
                                    @endif

                                    <p class="mt-1 text-xs text-gray-500">
                                        Weight: {{ $competency->weight }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                                    <div>
                                        <label
                                            for="score_{{ $competency->id }}"
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Score
                                        </label>

                                        <select
                                            id="score_{{ $competency->id }}"
                                            name="scores[{{ $competency->id }}][score]"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        >
                                            <option value="">
                                                Select a score
                                            </option>

                                            @for($score = 1; $score <= 5; $score++)
                                                <option
                                                    value="{{ $score }}"
                                                    @selected(
                                                        old(
                                                            "scores.{$competency->id}.score",
                                                            $existingScore?->score
                                                        ) == $score
                                                    )
                                                >
                                                    {{ $score }}
                                                </option>
                                            @endfor
                                        </select>

                                        @error("scores.{$competency->id}.score")
                                            <p class="mt-1 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label
                                            for="comment_{{ $competency->id }}"
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Competency comment
                                        </label>

                                        <textarea
                                            id="comment_{{ $competency->id }}"
                                            name="scores[{{ $competency->id }}][comment]"
                                            rows="3"
                                            maxlength="2000"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Optional comment..."
                                        >{{ old(
                                            "scores.{$competency->id}.comment",
                                            $existingScore?->comment
                                        ) }}</textarea>

                                        @error("scores.{$competency->id}.comment")
                                            <p class="mt-1 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-md border border-yellow-300 bg-yellow-50 p-5 text-yellow-800">
                                No active competencies are available.
                            </div>
                        @endforelse

                        <div class="rounded-lg border border-gray-200 p-5">
                            <label
                                for="comments"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Overall comments
                            </label>

                            <textarea
                                id="comments"
                                name="comments"
                                rows="6"
                                maxlength="5000"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Write an overall evaluation comment..."
                            >{{ old('comments', $evaluation->comments) }}</textarea>

                            @error('comments')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between border-t pt-6">
                            <a
                                href="{{ route('evaluations.show', $evaluation) }}"
                                class="text-sm font-medium text-gray-600 hover:text-gray-900"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                @disabled($competencies->isEmpty())
                                class="rounded-md bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>