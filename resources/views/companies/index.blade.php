<x-app-layout>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Companies</h1>

        <a href="{{ route('companies.create') }}">Create Company</a>

        <br><br>

        @foreach($companies as $company)
            <div class="border p-3 mb-2">
                {{ $company->name }}
            </div>
        @endforeach
    </div>
</x-app-layout>