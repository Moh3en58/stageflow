<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Final Grade Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-6">

            @if(session('success'))
                <div class="mb-6 rounded border border-green-300 bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h1 class="text-2xl font-bold">
                    {{ $finalGrade->internship->title }}
                </h1>

                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    <div>
                        <p class="text-gray-500">Student</p>
                        <p class="font-bold">
                            {{ $finalGrade->internship->user->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Company</p>
                        <p class="font-bold">
                            {{ $finalGrade->internship->company->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Teacher</p>
                        <p class="font-bold">
                            {{ $finalGrade->teacher->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Final Grade</p>
                        <p class="text-3xl font-bold">
                            {{ $finalGrade->grade }} / 20
                        </p>
                    </div>
                </div>

                <div class="mt-8 border-t pt-6">
                    <h2 class="text-lg font-bold">Feedback</h2>

                    <p class="mt-3 whitespace-pre-line">
                        {{ $finalGrade->feedback ?: 'No feedback provided.' }}
                    </p>
                </div>

                <div class="mt-8 flex gap-4 border-t pt-6">
                    <a
                        href="{{ route('final-grades.index') }}"
                        style="background:#4b5563;color:white;padding:10px 16px;border-radius:6px;text-decoration:none;"
                    >
                        Back
                    </a>

                    @if(in_array(auth()->user()->role, ['teacher', 'admin'], true))
                        <a
                            href="{{ route('final-grades.edit', $finalGrade) }}"
                            style="background:#15803d;color:white;padding:10px 16px;border-radius:6px;text-decoration:none;"
                        >
                            Edit
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>