<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Edit User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">

                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit User
                        </h1>

                        <p class="mt-1 text-sm text-gray-600">
                            Update the user information, role or password.
                        </p>
                    </div>

                    @if($errors->any())
                        <div class="mb-6 rounded-md border border-red-300 bg-red-50 p-4 text-red-800">
                            <p class="font-semibold">
                                Please correct the following errors:
                            </p>

                            <ul class="mt-2 list-disc pl-5 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('users.update', $user) }}"
                        class="space-y-6"
                    >
                        @csrf
                        @method('PUT')

                        <div>
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Name
                            </label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                autofocus
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error('name')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
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
                                value="{{ old('email', $user->email) }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error('email')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="role"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Role
                            </label>

                            <select
                                id="role"
                                name="role"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option
                                    value="student"
                                    @selected(old('role', $user->role) === 'student')
                                >
                                    Student
                                </option>

                                <option
                                    value="mentor"
                                    @selected(old('role', $user->role) === 'mentor')
                                >
                                    Mentor
                                </option>

                                <option
                                    value="teacher"
                                    @selected(old('role', $user->role) === 'teacher')
                                >
                                    Teacher
                                </option>

                                <option
                                    value="committee"
                                    @selected(old('role', $user->role) === 'committee')
                                >
                                    Committee
                                </option>

                                <option
                                    value="admin"
                                    @selected(old('role', $user->role) === 'admin')
                                >
                                    Admin
                                </option>
                            </select>

                            @error('role')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="border-t pt-6">
                            <h2 class="text-lg font-semibold text-gray-900">
                                Change Password
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Leave both password fields empty to keep the current password.
                            </p>
                        </div>

                        <div>
                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700"
                            >
                                New Password
                            </label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="password_confirmation"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Confirm New Password
                            </label>

                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div class="flex items-center justify-between border-t pt-6">
                            <a
                                href="{{ route('users.index') }}"
                                style="background:#4b5563;color:#ffffff;padding:10px 18px;border-radius:6px;font-weight:700;text-decoration:none;"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                style="background:#15803d;color:#ffffff;padding:10px 18px;border-radius:6px;font-weight:700;"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>