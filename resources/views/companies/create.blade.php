<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Create Company
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    Add a new internship company.
                </p>
            </div>

            <a
                href="{{ route('companies.index') }}"
                class="text-sm text-gray-600 hover:text-gray-900"
            >
                Back to companies
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                <p class="font-semibold text-red-800">
                    Please correct the following errors:
                </p>

                <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-lg bg-white p-6 shadow">
            <form method="POST" action="{{ route('companies.store') }}">
                @csrf

                <div class="mb-5">
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Company name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div class="mb-5">
                    <label
                        for="contact_person"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Contact person
                    </label>

                    <input
                        id="contact_person"
                        type="text"
                        name="contact_person"
                        value="{{ old('contact_person') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div class="mb-5">
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div class="mb-5">
                    <label
                        for="phone"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Phone
                    </label>

                    <input
                        id="phone"
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div class="mb-6">
                    <label
                        for="address"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Address
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('address') }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <a
                        href="{{ route('companies.index') }}"
                        class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                    >
                        Save Company
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>