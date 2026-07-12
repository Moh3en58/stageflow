<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Stage Proposals
            </h2>

            @if(auth()->user()->role === 'student')
                <a
                    href="{{ route('stage-proposals.create') }}"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    New Stage Proposal
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 rounded-md border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-md border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            @if(auth()->user()->role === 'student')
                                My Stage Proposals
                            @else
                                Stage Proposals Overview
                            @endif
                        </h1>

                        <p class="mt-1 text-sm text-gray-600">
                            Review the submitted stage proposals and their current status.
                        </p>
                    </div>

                    @forelse($stageProposals as $stageProposal)
                        <div class="mb-5 rounded-lg border border-gray-200 p-5 last:mb-0">

                            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $stageProposal->title }}
                                    </h3>

                                    @if(auth()->user()->role !== 'student')
                                        <p class="mt-1 text-sm text-gray-600">
                                            <strong>Student:</strong>
                                            {{ $stageProposal->student->name ?? 'Unknown student' }}
                                        </p>
                                    @endif

                                    <p class="mt-1 text-sm text-gray-600">
                                        <strong>Company:</strong>
                                        {{ $stageProposal->company->name ?? 'Unknown company' }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-600">
                                        <strong>Period:</strong>
                                        {{ $stageProposal->start_date ?? 'Not specified' }}
                                        -
                                        {{ $stageProposal->end_date ?? 'Not specified' }}
                                    </p>
                                </div>

                                <div>
                                    @php
                                        $statusClasses = match ($stageProposal->status) {
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-yellow-100 text-yellow-800',
                                        };
                                    @endphp

                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                        {{ ucfirst($stageProposal->status) }}
                                    </span>
                                </div>
                            </div>

                            @if($stageProposal->description)
                                <p class="mt-4 text-sm text-gray-700">
                                    {{ \Illuminate\Support\Str::limit($stageProposal->description, 180) }}
                                </p>
                            @endif

                            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                                <a
                                    href="{{ route('stage-proposals.show', $stageProposal) }}"
                                    class="font-medium text-blue-600 hover:underline"
                                >
                                    View details
                                </a>

                                @if(
                                    auth()->user()->role === 'student'
                                    && $stageProposal->student_id === auth()->id()
                                    && $stageProposal->status === 'pending'
                                )
                                    <a
                                        href="{{ route('stage-proposals.edit', $stageProposal) }}"
                                        class="font-medium text-green-600 hover:underline"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('stage-proposals.destroy', $stageProposal) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this proposal?');"
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
                                    Feedback messages:
                                    {{ $stageProposal->feedback->count() }}
                                </span>
                            </div>

                        </div>
                    @empty
                        <div class="rounded-md border border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-gray-600">
                                No stage proposals found.
                            </p>

                            @if(auth()->user()->role === 'student')
                                <a
                                    href="{{ route('stage-proposals.create') }}"
                                    class="mt-4 inline-block font-medium text-blue-600 hover:underline"
                                >
                                    Submit your first stage proposal
                                </a>
                            @endif
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>