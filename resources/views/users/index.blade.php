<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 rounded-md border border-green-300 bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-md border border-red-300 bg-red-50 p-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold">
                                Users
                            </h1>

                            <p class="mt-1 text-sm text-gray-600">
                                Create users and manage their roles and access rights.
                            </p>
                        </div>

                        <a
                            href="{{ route('users.create') }}"
                            style="background:#2563eb;color:#ffffff;padding:10px 18px;border-radius:6px;font-weight:700;text-decoration:none;"
                        >
                            Create User
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Name
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Email
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Role
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($users as $user)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            {{ $user->name }}

                                            @if($user->id === auth()->id())
                                                <span class="ml-2 rounded bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-700">
                                                    You
                                                </span>
                                            @endif
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-4">
                                            {{ $user->email }}
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-4">
                                            <span class="rounded bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                <a
                                                    href="{{ route('users.show', $user) }}"
                                                    style="background:#0284c7;color:#ffffff;padding:7px 12px;border-radius:5px;font-weight:700;text-decoration:none;"
                                                >
                                                    View
                                                </a>

                                                <a
                                                    href="{{ route('users.edit', $user) }}"
                                                    style="background:#d97706;color:#ffffff;padding:7px 12px;border-radius:5px;font-weight:700;text-decoration:none;"
                                                >
                                                    Edit
                                                </a>

                                                @if($user->id !== auth()->id())
                                                    <form
                                                        method="POST"
                                                        action="{{ route('users.destroy', $user) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            style="background:#dc2626;color:#ffffff;padding:7px 12px;border-radius:5px;font-weight:700;"
                                                        >
                                                            Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <button
                                                        type="button"
                                                        disabled
                                                        style="background:#9ca3af;color:#ffffff;padding:7px 12px;border-radius:5px;font-weight:700;cursor:not-allowed;"
                                                    >
                                                        Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>