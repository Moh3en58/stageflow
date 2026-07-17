<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Company Details
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    View company information.
                </p>
            </div>

            <a
                href="{{ route('companies.index') }}"
                class="text-sm text-gray-600 hover:text-gray-900"
            >
                Back to companies
            </a>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <dl class="divide-y divide-gray-200">
                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3">
                    <dt class="font-medium text-gray-700">
                        Company name
                    </dt>

                    <dd class="sm:col-span-2 text-gray-900">
                        {{ $company->name }}
                    </dd>
                </div>

                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3">
                    <dt class="font-medium text-gray-700">
                        Contact person
                    </dt>

                    <dd class="sm:col-span-2 text-gray-900">
                        {{ $company->contact_person ?: '—' }}
                    </dd>
                </div>

                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3">
                    <dt class="font-medium text-gray-700">
                        Email
                    </dt>

                    <dd class="sm:col-span-2 text-gray-900">
                        {{ $company->email ?: '—' }}
                    </dd>
                </div>

                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3">
                    <dt class="font-medium text-gray-700">
                        Phone
                    </dt>

                    <dd class="sm:col-span-2 text-gray-900">
                        {{ $company->phone ?: '—' }}
                    </dd>
                </div>

                <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3">
                    <dt class="font-medium text-gray-700">
                        Address
                    </dt>

                    <dd class="sm:col-span-2 whitespace-pre-line text-gray-900">
                        {{ $company->address ?: '—' }}
                    </dd>
                </div>
            </dl>

            <div class="mt-6 flex justify-end">
                <a
                    href="{{ route('companies.edit', $company) }}"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                >
                    Edit Company
                </a>
            </div>
        </div>
    </div>
</x-app-layout>