<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Evaluation Details
            </h2>

            <a
                href="{{ route('evaluations.index') }}"
                class="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700"
            >
                Back to Evaluations
            </a>
        </div>
    </x-slot>

    @php
        $scoreValues = $evaluation->scores->pluck('score');
        $averageScore = $scoreValues->isNotEmpty()
            ? round($scoreValues->average(), 2)
            : null;

        $typeClasses = $evaluation->evaluation_type === 'final'
            ? 'bg-green-100 text-green-800'
            : 'bg-blue-100 text-blue-800';
    @endphp

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">

                    <div class="flex flex-col justify-between gap-4 border-b pb-6 md:flex-row md:items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ ucfirst($evaluation->evaluation_type) }}
                                {{ $evaluation->evaluator_role === 'student'
                                    ? 'Self-Evaluation'
                                    : 'Mentor Evaluation' }}
                            </h1>

                            <p class="mt-2 text-sm text-gray-500">
                                Submitted on
                                {{ $evaluation->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $typeClasses }}">
                                {{ ucfirst($evaluation->evaluation_type) }}
                            </span>

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                {{ ucfirst($evaluation->evaluator_role) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Internship
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $evaluation->internship->title ?? 'Unknown internship' }}
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
                                Evaluator
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $evaluation->evaluator->name ?? 'Unknown evaluator' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Evaluation date
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $evaluation->evaluation_date?->format('d/m/Y') ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Average score
                            </p>

                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $averageScore !== null ? $averageScore . ' / 5' : '-' }}
                            </p>
                        </div>

                    </div>

                    @if($evaluation->comments)
                        <div class="mt-8 border-t pt-6">
                            <h2 class="text-lg font-bold text-gray-900">
                                Overall Comments
                            </h2>

                            <p class="mt-3 whitespace-pre-line text-gray-700">
                                {{ $evaluation->comments }}
                            </p>
                        </div>
                    @endif

                    @if($evaluation->evaluator_id === auth()->id())
                        <div class="mt-8 border-t pt-6">
                            <a
                                href="{{ route('evaluations.edit', $evaluation) }}"
                                class="inline-flex rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
                            >
                                Edit Evaluation
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900">
                            Competency Scores
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Scores are given on a scale from 1 to 5.
                        </p>
                    </div>

                    <div class="space-y-4">
                        @forelse($evaluation->scores as $evaluationScore)
                            <div class="rounded-lg border border-gray-200 p-5">
                                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $evaluationScore->competency->title ?? 'Unknown competency' }}
                                        </h3>

                                        @if($evaluationScore->competency?->description)
                                            <p class="mt-1 text-sm text-gray-600">
                                                {{ $evaluationScore->competency->description }}
                                            </p>
                                        @endif

                                        @if($evaluationScore->comment)
                                            <p class="mt-3 whitespace-pre-line text-sm text-gray-700">
                                                <strong>Comment:</strong>
                                                {{ $evaluationScore->comment }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="shrink-0">
                                        <span class="inline-flex rounded-full bg-blue-100 px-4 py-2 text-sm font-bold text-blue-800">
                                            {{ $evaluationScore->score }} / 5
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-md border border-gray-200 bg-gray-50 p-5 text-gray-600">
                                No competency scores were found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>