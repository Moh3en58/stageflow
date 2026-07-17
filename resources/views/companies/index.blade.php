<x-app-layout>
    <style>
        .companies-page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .companies-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .companies-title {
            margin: 0;
            color: #111827;
            font-size: 26px;
            font-weight: 700;
        }

        .companies-subtitle {
            margin-top: 5px;
            color: #6b7280;
            font-size: 14px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 7px;
            padding: 9px 16px;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
            text-decoration: none;
            cursor: pointer;
            transition:
                background-color 0.15s ease,
                transform 0.15s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-create {
            background-color: #4f46e5;
            color: #ffffff !important;
        }

        .btn-create:hover {
            background-color: #4338ca;
        }

        .btn-view {
            background-color: #2563eb;
            color: #ffffff !important;
        }

        .btn-view:hover {
            background-color: #1d4ed8;
        }

        .btn-edit {
            background-color: #d97706;
            color: #ffffff !important;
        }

        .btn-edit:hover {
            background-color: #b45309;
        }

        .btn-delete {
            background-color: #dc2626;
            color: #ffffff !important;
        }

        .btn-delete:hover {
            background-color: #b91c1c;
        }

        .message-success {
            margin-bottom: 20px;
            padding: 12px 16px;
            border: 1px solid #86efac;
            border-radius: 8px;
            background-color: #f0fdf4;
            color: #166534;
        }

        .message-error {
            margin-bottom: 20px;
            padding: 12px 16px;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            background-color: #fef2f2;
            color: #991b1b;
        }

        .companies-card {
            overflow: hidden;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .companies-table-wrapper {
            overflow-x: auto;
        }

        .companies-table {
            width: 100%;
            border-collapse: collapse;
        }

        .companies-table th {
            padding: 14px 18px;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f9fafb;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .companies-table td {
            padding: 18px;
            border-bottom: 1px solid #e5e7eb;
            color: #4b5563;
            font-size: 14px;
            vertical-align: middle;
        }

        .companies-table tbody tr:last-child td {
            border-bottom: none;
        }

        .company-name {
            color: #111827 !important;
            font-weight: 600;
        }

        .company-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            white-space: nowrap;
        }

        .company-actions form {
            display: inline-flex;
            margin: 0;
        }

        .empty-state {
            padding: 30px;
            color: #6b7280;
            text-align: center;
        }

        @media (max-width: 700px) {
            .companies-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .btn-create {
                width: 100%;
            }

            .company-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .company-actions .btn,
            .company-actions form,
            .company-actions form button {
                width: 100%;
            }
        }
    </style>

    <div class="companies-page">
        <div class="companies-header">
            <div>
                <h1 class="companies-title">Companies</h1>

                <p class="companies-subtitle">
                    Manage internship companies.
                </p>
            </div>

            <a
                href="{{ route('companies.create') }}"
                class="btn btn-create"
            >
                Create Company
            </a>
        </div>

        @if (session('success'))
            <div class="message-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="message-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="companies-card">
            @if ($companies->isEmpty())
                <div class="empty-state">
                    No companies have been created yet.
                </div>
            @else
                <div class="companies-table-wrapper">
                    <table class="companies-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact person</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td class="company-name">
                                        {{ $company->name }}
                                    </td>

                                    <td>
                                        {{ $company->contact_person ?: '—' }}
                                    </td>

                                    <td>
                                        {{ $company->email ?: '—' }}
                                    </td>

                                    <td>
                                        {{ $company->phone ?: '—' }}
                                    </td>

                                    <td>
                                        <div class="company-actions">
                                            <a
                                                href="{{ route('companies.show', $company) }}"
                                                class="btn btn-view"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('companies.edit', $company) }}"
                                                class="btn btn-edit"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('companies.destroy', $company) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this company?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-delete"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>