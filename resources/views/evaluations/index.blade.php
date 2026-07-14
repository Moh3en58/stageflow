<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Evaluations
        </h2>
    </x-slot>

    @php
        $user = auth()->user();
    @endphp

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

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

            @if(in_array($user->role, ['student', 'mentor'], true))
                <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                    <div class="p-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            Start a New Evaluation
                        </h1>

                        <p class="mt-1 text-sm text-gray-600">
                            @if($user->role === 'student')
                                Complete your own midterm or final self-evaluation.
                            @else
                                Complete a midterm or final evaluation for an approved internship.
                            @endif
                        </p>

                        <div class="mt-6 space-y-4">
                            @forelse($availableInternships as $internship)
                                <div class="rounded-lg border border-gray-200 p-5">
                                    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">
                                                {{ $internship->title }}
                                            </h3>

                                            @if($user->role === 'mentor')
                                                <p class="mt-1 text-sm text-gray-600">
                                                    <strong>Student:</strong>
                                                    {{ $internship->user->name ?? 'Unknown student' }}
                                                </p>
                                            @endif

                                            <p class="mt-1 text-sm text-gray-600">
                                                <strong>Company:</strong>
                                                {{ $internship->company->name ?? 'Unknown company' }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-600">
                                                <strong>Period:</strong>
                                                {{ $internship->start_date }}
                                                -
                                                {{ $internship->end_date }}
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-3">
    <a
        href="{{ route('evaluations.create', [
            'internship_id' => $internship->id,
            'evaluation_type' => 'midterm',
        ]) }}"
        style="display:inline-block;background:#1d4ed8;color:#ffffff;padding:10px 16px;border-radius:6px;font-weight:700;text-decoration:none;"
    >
        Midterm Evaluation
    </a>

    <a
        href="{{ route('evaluations.create', [
            'internship_id' => $internship->id,
            'evaluation_type' => 'final',
        ]) }}"
        style="display:inline-block;background:#7e22ce;color:#ffffff;padding:10px 16px;border-radius:6px;font-weight:700;text-decoration:none;"
    >
        Final Evaluation
    </a>
</div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-md border border-gray-200 bg-gray-50 p-5 text-gray-600">
                                    No approved internships are available for evaluation.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Evaluation Overview
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            View submitted midterm and final evaluations.
                        </p>
                    </div>

                    @forelse($evaluations as $evaluation)
                        <div class="mb-5 rounded-lg border border-gray-200 p-5 last:mb-0">
                            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ ucfirst($evaluation->evaluation_type) }} Evaluation
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-600">
                                        <strong>Internship:</strong>
                                        {{ $evaluation->internship->title ?? 'Unknown internship' }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-600">
                                        <strong>Student:</strong>
                                        {{ $evaluation->internship->user->name ?? 'Unknown student' }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-600">
                                        <strong>Company:</strong>
                                        {{ $evaluation->internship->company->name ?? 'Unknown company' }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-600">
                                        <strong>Evaluator:</strong>
                                        {{ $evaluation->evaluator->name ?? 'Unknown evaluator' }}
                                        ({{ ucfirst($evaluation->evaluator_role) }})
                                    </p>

                                    <p class="mt-1 text-sm text-gray-600">
                                        <strong>Date:</strong>
                                        {{ $evaluation->evaluation_date?->format('d/m/Y') ?? '-' }}
                                    </p>
                                </div>

                                <div class="flex flex-col items-start gap-3 md:items-end">
                                    @php
                                        $typeClasses = $evaluation->evaluation_type === 'final'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-blue-100 text-blue-800';
                                    @endphp

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $typeClasses }}">
                                        {{ ucfirst($evaluation->evaluation_type) }}
                                    </span>

                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                        {{ ucfirst($evaluation->evaluator_role) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                                <a
                                    href="{{ route('evaluations.show', $evaluation) }}"
                                    class="font-medium text-blue-600 hover:underline"
                                >
                                    View Evaluation
                                </a>

                                @if($evaluation->evaluator_id === auth()->id())
                                    <a
                                        href="{{ route('evaluations.edit', $evaluation) }}"
                                        class="font-medium text-green-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('evaluations.destroy', $evaluation) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this evaluation?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="font-medium text-red-600 hover:underline"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                @endif

                                <span class="text-gray-500">
                                    Competencies scored:
                                    {{ $evaluation->scores->count() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-md border border-gray-200 bg-gray-50 p-6 text-center text-gray-600">
                            No evaluations have been submitted yet.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>