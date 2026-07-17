<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <h1 class="text-2xl font-bold">
                            User Information
                        </h1>

                        <p class="mt-1 text-sm text-gray-600">
                            View the selected user's account details.
                        </p>
                    </div>

                    <div class="space-y-5">
                        <div class="rounded-md bg-gray-50 p-4">
                            <p class="text-sm font-semibold text-gray-500">
                                Name
                            </p>

                            <p class="mt-1 text-lg font-medium text-gray-900">
                                {{ $user->name }}
                            </p>
                        </div>

                        <div class="rounded-md bg-gray-50 p-4">
                            <p class="text-sm font-semibold text-gray-500">
                                Email
                            </p>

                            <p class="mt-1 text-lg font-medium text-gray-900">
                                {{ $user->email }}
                            </p>
                        </div>

                        <div class="rounded-md bg-gray-50 p-4">
                            <p class="text-sm font-semibold text-gray-500">
                                Role
                            </p>

                            <p class="mt-1 text-lg font-medium text-gray-900">
                                {{ ucfirst($user->role) }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between border-t pt-6">
                        <a
                            href="{{ route('users.index') }}"
                            style="background:#4b5563;color:#ffffff;padding:10px 18px;border-radius:6px;font-weight:700;text-decoration:none;"
                        >
                            Back
                        </a>

                        <a
                            href="{{ route('users.edit', $user) }}"
                            style="background:#d97706;color:#ffffff;padding:10px 18px;border-radius:6px;font-weight:700;text-decoration:none;"
                        >
                            Edit User
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>