<x-app-layout>
    <style>
        .form-page {
            max-width: 760px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .form-card {
            padding: 24px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background-color: #ffffff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>

    <div class="form-page">
        <h1 style="font-size: 26px; font-weight: 700; margin-bottom: 24px;">
            Edit Competency
        </h1>

        @if ($errors->any())
            <div style="margin-bottom: 20px; padding: 14px; background: #fef2f2; color: #991b1b; border-radius: 8px;">
                <ul style="padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form
                method="POST"
                action="{{ route('competencies.update', $competency) }}"
            >
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title" class="form-label">
                        Title
                    </label>

                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title', $competency->title) }}"
                        required
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="form-control"
                    >{{ old('description', $competency->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="weight" class="form-label">
                        Weight
                    </label>

                    <input
                        id="weight"
                        type="number"
                        name="weight"
                        value="{{ old('weight', $competency->weight) }}"
                        min="1"
                        max="100"
                        required
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label>
                        <input
                            type="checkbox"
                            name="active"
                            value="1"
                            {{ old('active', $competency->active) ? 'checked' : '' }}
                        >

                        Active
                    </label>
                </div>

                <div class="form-actions">
                    <a
                        href="{{ route('competencies.index') }}"
                        style="border: 1px solid #d1d5db; color: #374151; padding: 10px 16px; border-radius: 7px; text-decoration: none;"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        style="border: none; background: #4f46e5; color: white; padding: 10px 16px; border-radius: 7px; cursor: pointer;"
                    >
                        Update Competency
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>