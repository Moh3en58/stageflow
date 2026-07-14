<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Final Grades</h2>
    </x-slot>

    @php
        $user = auth()->user();
    @endphp

    <div class="py-12">
        <div class="mx-auto max-w-6xl space-y-6 px-6">

            @if(session('success'))
                <div class="rounded border border-green-300 bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="rounded border border-red-300 bg-red-50 p-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if(in_array($user->role, ['teacher', 'admin'], true))
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h2 class="text-2xl font-bold">Register Final Grade</h2>

                    <div class="mt-5 space-y-4">
                        @forelse($availableInternships as $internship)
                            @php
                                $existingGrade = $finalGrades
                                    ->firstWhere('internship_id', $internship->id);
                            @endphp

                            <div class="flex flex-col justify-between gap-4 rounded-lg border p-5 md:flex-row md:items-center">
                                <div>
                                    <h3 class="font-bold">{{ $internship->title }}</h3>
                                    <p>Student: {{ $internship->user->name ?? '-' }}</p>
                                    <p>Company: {{ $internship->company->name ?? '-' }}</p>
                                </div>

                                @if($existingGrade)
                                    <a
                                        href="{{ route('final-grades.edit', $existingGrade) }}"
                                        style="background:#15803d;color:white;padding:10px 16px;border-radius:6px;font-weight:700;text-decoration:none;"
                                    >
                                        Edit Final Grade
                                    </a>
                                @else
                                    <a
                                        href="{{ route('final-grades.create', ['internship_id' => $internship->id]) }}"
                                        style="background:#1d4ed8;color:white;padding:10px 16px;border-radius:6px;font-weight:700;text-decoration:none;"
                                    >
                                        Register Grade
                                    </a>
                                @endif
                            </div>
                        @empty
                            <p>No approved internships are available.</p>
                        @endforelse
                    </div>
                </div>
            @endif

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-bold">Final Grade Overview</h2>

                <div class="mt-5 space-y-4">
                    @forelse($finalGrades as $finalGrade)
                        <div class="rounded-lg border p-5">
                            <h3 class="text-lg font-bold">
                                {{ $finalGrade->internship->title ?? 'Internship' }}
                            </h3>

                            <p>Student: {{ $finalGrade->internship->user->name ?? '-' }}</p>
                            <p>Teacher: {{ $finalGrade->teacher->name ?? '-' }}</p>
                            <p class="mt-2 text-xl font-bold">
                                Grade: {{ $finalGrade->grade }} / 20
                            </p>

                            <div class="mt-4 flex gap-4">
                                <a
                                    href="{{ route('final-grades.show', $finalGrade) }}"
                                    class="font-semibold text-blue-600"
                                >
                                    View
                                </a>

                                @if(in_array($user->role, ['teacher', 'admin'], true))
                                    <a
                                        href="{{ route('final-grades.edit', $finalGrade) }}"
                                        class="font-semibold text-green-600"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('final-grades.destroy', $finalGrade) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this final grade?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="font-semibold text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p>No final grades have been registered yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>