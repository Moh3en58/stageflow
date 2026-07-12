<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">StageFlow Dashboard</h2>

<div class="grid grid-cols-2 gap-4">
    <div class="p-4 bg-blue-100 rounded">
        <a href="{{ route('internships.index') }}">
    <h3 class="font-bold">Internships</h3>
    <p>Manage internships</p>
</a>
    </div>

    <div class="p-4 bg-green-100 rounded">
       <a href="{{ route('logbooks.index') }}">
    <h3 class="font-bold">Logbooks</h3>
    <p>Weekly reports</p>
</a>
    </div>

   <div class="p-4 bg-yellow-100 rounded">
    <a href="{{ route('competencies.index') }}">
        <h3 class="font-bold">Competencies</h3>
        <p>Skills tracking</p>
    </a>
</div>

    <div class="p-4 bg-purple-100 rounded">
        <a href="{{ route('companies.index') }}">
    <h3 class="font-bold">Companies</h3>
    <p>Partner companies</p>
</a>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
