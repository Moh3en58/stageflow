<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Stage Proposal Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    {{ $stageProposal->title }}
                </h1>

                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <strong>Student</strong><br>
                        {{ $stageProposal->student->name }}
                    </div>

                    <div>
                        <strong>Company</strong><br>
                        {{ $stageProposal->company->name }}
                    </div>

                    <div>
                        <strong>Start date</strong><br>
                        {{ $stageProposal->start_date }}
                    </div>

                    <div>
                        <strong>End date</strong><br>
                        {{ $stageProposal->end_date }}
                    </div>

                    <div>
                        <strong>Status</strong><br>
                        {{ ucfirst($stageProposal->status) }}
                    </div>

                    <div>
                        <strong>Approved by</strong><br>

                        @if($stageProposal->approvedBy)
                            {{ $stageProposal->approvedBy->name }}
                        @else
                            -
                        @endif
                    </div>

                </div>

                <hr class="my-6">

                <h3 class="font-bold text-lg">
                    Description
                </h3>

                <p class="mt-2 whitespace-pre-line">
                    {{ $stageProposal->description }}
                </p>

                <hr class="my-6">

                <h3 class="font-bold text-lg">
                    Motivation
                </h3>

                <p class="mt-2 whitespace-pre-line">
                    {{ $stageProposal->motivation }}
                </p>

                <div class="mt-8 flex gap-3">

                    <a
                        href="{{ route('stage-proposals.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded"
                    >
                        Back
                    </a>

                    @if(auth()->id()==$stageProposal->student_id && $stageProposal->status=='pending')

                        <a
                            href="{{ route('stage-proposals.edit',$stageProposal) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            Edit
                        </a>

                    @endif

                </div>

            </div>

        </div>
    </div>
</x-app-layout>