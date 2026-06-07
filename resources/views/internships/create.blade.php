<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Create Internship
        </h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('internships.store') }}">
            @csrf

            <div>
                <div>
    <label>Company</label><br>

    <select name="company_id">
        @foreach($companies as $company)
            <option value="{{ $company->id }}">
                {{ $company->name }}
            </option>
        @endforeach
    </select>
</div>
                <label>Title</label><br>
                <input type="text" name="title" class="border p-2 w-full">
            </div>

            <div class="mt-4">
                <label>Description</label><br>
                <textarea name="description" class="border p-2 w-full"></textarea>
            </div>

            <div class="mt-4">
                <label>Start date</label><br>
                <input type="date" name="start_date" class="border p-2 w-full">
            </div>

            <div class="mt-4">
                <label>End date</label><br>
                <input type="date" name="end_date" class="border p-2 w-full">
            </div>

            <button class="mt-4 bg-blue-500 text-white px-4 py-2">
                Save
            </button>
        </form>
    </div>
</x-app-layout>