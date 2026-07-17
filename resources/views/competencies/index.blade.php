<x-app-layout>
    <style>
        .competencies-page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .competencies-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .competencies-title {
            margin: 0;
            color: #111827;
            font-size: 26px;
            font-weight: 700;
        }

        .competencies-subtitle {
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
        }

        .btn-create {
            background-color: #4f46e5;
            color: #ffffff !important;
        }

        .btn-view {
            background-color: #2563eb;
            color: #ffffff !important;
        }

        .btn-edit {
            background-color: #d97706;
            color: #ffffff !important;
        }

        .btn-delete {
            background-color: #dc2626;
            color: #ffffff !important;
        }

        .message-success,
        .message-error {
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 8px;
        }

        .message-success {
            border: 1px solid #86efac;
            background-color: #f0fdf4;
            color: #166534;
        }

        .message-error {
            border: 1px solid #fca5a5;
            background-color: #fef2f2;
            color: #991b1b;
        }

        .competencies-card {
            overflow: hidden;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .competencies-table {
            width: 100%;
            border-collapse: collapse;
        }

        .competencies-table th {
            padding: 14px 18px;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 12px;
            text-align: left;
            text-transform: uppercase;
        }

        .competencies-table td {
            padding: 18px;
            border-bottom: 1px solid #e5e7eb;
            color: #4b5563;
            vertical-align: middle;
        }

        .competency-title-cell {
            color: #111827 !important;
            font-weight: 600;
        }

        .status-active {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background-color: #dcfce7;
            color: #166534;
            font-size: 12px;
            font-weight: 600;
        }

        .status-inactive {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background-color: #fee2e2;
            color: #991b1b;
            font-size: 12px;
            font-weight: 600;
        }

        .competency-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .competency-actions form {
            margin: 0;
        }

        .empty-state {
            padding: 30px;
            color: #6b7280;
            text-align: center;
        }
    </style>

    <div class="competencies-page">
        <div class="competencies-header">
            <div>
                <h1 class="competencies-title">Competencies</h1>

                <p class="competencies-subtitle">
                    Manage evaluation competencies.
                </p>
            </div>

            <a
                href="{{ route('competencies.create') }}"
                class="btn btn-create"
            >
                Create Competency
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

        <div class="competencies-card">
            @if ($competencies->isEmpty())
                <div class="empty-state">
                    No competencies have been created yet.
                </div>
            @else
                <table class="competencies-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Weight</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($competencies as $competency)
                            <tr>
                                <td class="competency-title-cell">
                                    {{ $competency->title }}
                                </td>

                                <td>
                                    {{ $competency->description ?: '—' }}
                                </td>

                                <td>
                                    {{ $competency->weight }}
                                </td>

                                <td>
                                    @if ($competency->active)
                                        <span class="status-active">
                                            Active
                                        </span>
                                    @else
                                        <span class="status-inactive">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="competency-actions">
                                        <a
                                            href="{{ route('competencies.show', $competency) }}"
                                            class="btn btn-view"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('competencies.edit', $competency) }}"
                                            class="btn btn-edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('competencies.destroy', $competency) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this competency?');"
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
            @endif
        </div>
    </div>
</x-app-layout>