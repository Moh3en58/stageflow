<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $user = auth()->user();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <h2 class="text-2xl font-bold">
                            StageFlow Dashboard
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Logged in as:
                            <strong>{{ ucfirst($user->role) }}</strong>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                        {{-- Admin user management --}}
                        @if($user->role === 'admin')
                            <div class="rounded-lg bg-red-100 p-4">
                                <a href="{{ route('users.index') }}">
                                    <h3 class="font-bold">
                                        User Management
                                    </h3>

                                    <p>
                                        Create users, edit accounts and manage roles
                                    </p>
                                </a>
                            </div>
                        @endif

                        {{-- Student stage proposals --}}
                        @if($user->role === 'student')
                            <div class="rounded-lg bg-indigo-100 p-4">
                                <a href="{{ route('stage-proposals.index') }}">
                                    <h3 class="font-bold">
                                        My Stage Proposals
                                    </h3>

                                    <p>
                                        Submit and follow your stage proposal
                                    </p>
                                </a>
                            </div>
                        @endif

                        {{-- Committee, teacher and admin proposal review --}}
                        @if(in_array($user->role, ['committee', 'teacher', 'admin'], true))
                            <div class="rounded-lg bg-indigo-100 p-4">
                                <a href="{{ route('stage-proposals.index') }}">
                                    <h3 class="font-bold">
                                        Review Stage Proposals
                                    </h3>

                                    <p>
                                        Review proposals, feedback and decisions
                                    </p>
                                </a>
                            </div>
                        @endif

                        {{-- Evaluations --}}
                        @if(in_array($user->role, ['student', 'mentor', 'teacher', 'admin'], true))
                            <div class="rounded-lg bg-orange-100 p-4">
                                <a href="{{ route('evaluations.index') }}">
                                    <h3 class="font-bold">
                                        @if($user->role === 'student')
                                            My Evaluations
                                        @elseif($user->role === 'mentor')
                                            Internship Evaluations
                                        @else
                                            Evaluation Overview
                                        @endif
                                    </h3>

                                    <p>
                                        @if($user->role === 'student')
                                            Complete midterm and final self-evaluations
                                        @elseif($user->role === 'mentor')
                                            Evaluate students based on competencies
                                        @elseif($user->role === 'teacher')
                                            Review student and mentor evaluations
                                        @else
                                            View and manage evaluations
                                        @endif
                                    </p>
                                </a>
                            </div>
                        @endif

                        {{-- Final grades --}}
                        @if(in_array($user->role, ['student', 'teacher', 'admin'], true))
                            <div class="rounded-lg bg-purple-100 p-4">
                                <a href="{{ route('final-grades.index') }}">
                                    <h3 class="font-bold">
                                        @if($user->role === 'student')
                                            My Final Grade
                                        @else
                                            Final Grades
                                        @endif
                                    </h3>

                                    <p>
                                        @if($user->role === 'student')
                                            View your final internship grade
                                        @elseif($user->role === 'teacher')
                                            Register and manage final internship grades
                                        @else
                                            View and manage final grades
                                        @endif
                                    </p>
                                </a>
                            </div>
                        @endif

                        {{-- Internships --}}
                        @if(in_array($user->role, ['student', 'mentor', 'teacher', 'admin'], true))
                            <div class="rounded-lg bg-blue-100 p-4">
                                <a href="{{ route('internships.index') }}">
                                    <h3 class="font-bold">
                                        Internships
                                    </h3>

                                    <p>
                                        Manage internships
                                    </p>
                                </a>
                            </div>
                        @endif

                        {{-- Logbooks --}}
                        @if(in_array($user->role, ['student', 'mentor', 'teacher', 'admin'], true))
                            <div class="rounded-lg bg-green-100 p-4">
                                <a href="{{ route('logbooks.index') }}">
                                    <h3 class="font-bold">
                                        Logbooks
                                    </h3>

                                    <p>
                                        Weekly reports
                                    </p>
                                </a>
                            </div>
                        @endif

                        {{-- Competencies --}}
                        @if(in_array($user->role, ['student', 'mentor', 'teacher', 'admin'], true))
                            <div class="rounded-lg bg-yellow-100 p-4">
                                <a href="{{ route('competencies.index') }}">
                                    <h3 class="font-bold">
                                        Competencies
                                    </h3>

                                    <p>
                                        Skills used in evaluations
                                    </p>
                                </a>
                            </div>
                        @endif

                        {{-- Companies --}}
                        @if(in_array($user->role, ['committee', 'teacher', 'admin'], true))
                            <div class="rounded-lg bg-purple-100 p-4">
                                <a href="{{ route('companies.index') }}">
                                    <h3 class="font-bold">
                                        Companies
                                    </h3>

                                    <p>
                                        Partner companies
                                    </p>
                                </a>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>