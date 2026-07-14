<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Stage Proposal Details
            </h2>

            <a
                href="{{ route('stage-proposals.index') }}"
                class="rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700"
            >
                Back to Proposals
            </a>
        </div>
    </x-slot>

    @php
        $user = auth()->user();
        $isStudentOwner =
            $user->role === 'student'
            && $stageProposal->student_id === $user->id;

        $canReview = in_array($user->role, ['committee', 'admin'], true);

        $statusClasses = match ($stageProposal->status) {
            'approved' => 'bg-green-100 text-green-800 border-green-200',
            'rejected' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        };
    @endphp

    <div class="py-12">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">

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

            @if($errors->any())
                <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-red-800">
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

            {{-- Main proposal information --}}
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">

                    <div class="flex flex-col justify-between gap-4 border-b pb-6 md:flex-row md:items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $stageProposal->title }}
                            </h1>

                            <p class="mt-2 text-sm text-gray-500">
                                Submitted on
                                {{ $stageProposal->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </p>
                        </div>

                        <span class="inline-flex w-fit rounded-full border px-4 py-1.5 text-sm font-semibold {{ $statusClasses }}">
                            {{ ucfirst($stageProposal->status) }}
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Student
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $stageProposal->student->name ?? 'Unknown student' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Company
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $stageProposal->company->name ?? 'Unknown company' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Start date
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $stageProposal->start_date ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                End date
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $stageProposal->end_date ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Approved by
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $stageProposal->approvedBy->name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Approval date
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $stageProposal->approved_at
                                    ? \Illuminate\Support\Carbon::parse($stageProposal->approved_at)->format('d/m/Y H:i')
                                    : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Internship
                            </p>

                            <p class="mt-1 text-gray-900">
                                @if($stageProposal->internship)
                                    Created — ID {{ $stageProposal->internship->id }}
                                @else
                                    Not created yet
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Last updated
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $stageProposal->updated_at?->format('d/m/Y H:i') ?? '-' }}
                            </p>
                        </div>

                    </div>

                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Description
                        </h3>

                        <p class="mt-3 whitespace-pre-line text-gray-700">
                            {{ $stageProposal->description }}
                        </p>
                    </div>

                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Motivation
                        </h3>

                        <p class="mt-3 whitespace-pre-line text-gray-700">
                            {{ $stageProposal->motivation ?: 'No motivation was provided.' }}
                        </p>
                    </div>

                    @if($isStudentOwner && $stageProposal->status === 'pending')
                        <div class="mt-8 border-t pt-6">
                            <a
                                href="{{ route('stage-proposals.edit', $stageProposal) }}"
                                class="inline-flex rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                            >
                                Edit Proposal
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Timeline --}}
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900">
                        Proposal Timeline
                    </h2>

                    <div class="mt-6 space-y-5">

                        <div class="flex gap-4">
                            <div class="mt-1 h-3 w-3 shrink-0 rounded-full bg-blue-600"></div>

                            <div>
                                <p class="font-semibold text-gray-900">
                                    Proposal submitted
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ $stageProposal->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </p>

                                <p class="mt-1 text-sm text-gray-700">
                                    {{ $stageProposal->student->name ?? 'Student' }}
                                    submitted the stage proposal.
                                </p>
                            </div>
                        </div>

                        @foreach($stageProposal->feedback->sortBy('created_at') as $feedback)
                            @php
                                $timelineColor = match ($feedback->decision) {
                                    'approved' => 'bg-green-600',
                                    'rejected' => 'bg-red-600',
                                    default => 'bg-yellow-500',
                                };
                            @endphp

                            <div class="flex gap-4">
                                <div class="mt-1 h-3 w-3 shrink-0 rounded-full {{ $timelineColor }}"></div>

                                <div>
                                    <p class="font-semibold text-gray-900">
                                        @if($feedback->decision === 'approved')
                                            Proposal approved
                                        @elseif($feedback->decision === 'rejected')
                                            Proposal rejected
                                        @else
                                            Committee feedback added
                                        @endif
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $feedback->created_at?->format('d/m/Y H:i') ?? '-' }}
                                        —
                                        {{ $feedback->committeeUser->name ?? 'Committee member' }}
                                    </p>

                                    <p class="mt-1 whitespace-pre-line text-sm text-gray-700">
                                        {{ $feedback->feedback }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        @if(
                            $stageProposal->updated_at
                            && $stageProposal->created_at
                            && $stageProposal->updated_at->gt($stageProposal->created_at)
                        )
                            <div class="flex gap-4">
                                <div class="mt-1 h-3 w-3 shrink-0 rounded-full bg-purple-600"></div>

                                <div>
                                    <p class="font-semibold text-gray-900">
                                        Proposal updated
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $stageProposal->updated_at->format('d/m/Y H:i') }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-700">
                                        The stage proposal information was updated.
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Feedback history --}}
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">
                            Committee Feedback
                        </h2>

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                            {{ $stageProposal->feedback->count() }}
                            message(s)
                        </span>
                    </div>

                    <div class="mt-6 space-y-4">
                        @forelse($stageProposal->feedback->sortByDesc('created_at') as $feedback)
                            @php
                                $feedbackClasses = match ($feedback->decision) {
                                    'approved' => 'border-green-300 bg-green-50',
                                    'rejected' => 'border-red-300 bg-red-50',
                                    default => 'border-yellow-300 bg-yellow-50',
                                };
                            @endphp

                            <div class="rounded-lg border p-4 {{ $feedbackClasses }}">
                                <div class="flex flex-col justify-between gap-2 sm:flex-row">
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $feedback->committeeUser->name ?? 'Committee member' }}
                                        </p>

                                        <p class="text-sm text-gray-500">
                                            {{ $feedback->created_at?->format('d/m/Y H:i') ?? '-' }}
                                        </p>
                                    </div>

                                    <span class="text-sm font-semibold uppercase text-gray-700">
                                        {{ $feedback->decision }}
                                    </span>
                                </div>

                                <p class="mt-3 whitespace-pre-line text-gray-700">
                                    {{ $feedback->feedback }}
                                </p>
                            </div>
                        @empty
                            <div class="rounded-md border border-gray-200 bg-gray-50 p-5 text-gray-600">
                                No committee feedback has been added yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Committee actions --}}
            @if($canReview)
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                    {{-- Feedback only --}}
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900">
                            Send Feedback
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Send feedback without approving or rejecting the proposal.
                        </p>

                        <form
                            action="{{ route('stage-proposals.feedback', $stageProposal) }}"
                            method="POST"
                            class="mt-5"
                        >
                            @csrf

                            <textarea
                                name="feedback"
                                rows="5"
                                required
                                placeholder="Write feedback for the student..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >{{ old('feedback') }}</textarea>

                            <button
                                type="submit"
                                class="mt-4 w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                            >
                                Send Feedback
                            </button>
                        </form>
                    </div>

                    {{-- Approve --}}
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-green-700">
                            Approve Proposal
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Approval automatically creates an internship.
                        </p>

                        <form
                            action="{{ route('stage-proposals.approve', $stageProposal) }}"
                            method="POST"
                            class="mt-5"
                        >
                            @csrf
                            @method('PATCH')

                            <textarea
                                name="feedback"
                                rows="5"
                                placeholder="Optional approval feedback..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            ></textarea>

                            <button
                                type="submit"
                                class="mt-4 w-full rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
                                onclick="return confirm('Are you sure you want to approve this proposal?');"
                                @disabled($stageProposal->status === 'approved')
                            >
                                {{ $stageProposal->status === 'approved'
                                    ? 'Already Approved'
                                    : 'Approve Proposal' }}
                            </button>
                        </form>
                    </div>

                    {{-- Reject --}}
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-red-700">
                            Reject Proposal
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            A reason is required when rejecting a proposal.
                        </p>

                        <form
                            action="{{ route('stage-proposals.reject', $stageProposal) }}"
                            method="POST"
                            class="mt-5"
                        >
                            @csrf
                            @method('PATCH')

                            <textarea
                                name="feedback"
                                rows="5"
                                required
                                placeholder="Explain why the proposal is rejected..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                            ></textarea>

                            <button
                                type="submit"
                                class="mt-4 w-full rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                onclick="return confirm('Are you sure you want to reject this proposal?');"
                            >
                                Reject Proposal
                            </button>
                        </form>
                    </div>

                </div>
            @endif

        </div>
    </div>
</x-app-layout>