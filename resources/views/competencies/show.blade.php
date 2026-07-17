<x-app-layout>
    <div style="max-width: 760px; margin: 0 auto; padding: 32px 24px;">
        <h1 style="font-size: 26px; font-weight: 700; margin-bottom: 24px;">
            Competency Details
        </h1>

        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 10px; padding: 24px;">
            <p><strong>Title:</strong> {{ $competency->title }}</p>

            <p style="margin-top: 16px;">
                <strong>Description:</strong><br>
                {{ $competency->description ?: '—' }}
            </p>

            <p style="margin-top: 16px;">
                <strong>Weight:</strong> {{ $competency->weight }}
            </p>

            <p style="margin-top: 16px;">
                <strong>Status:</strong>
                {{ $competency->active ? 'Active' : 'Inactive' }}
            </p>

            <div style="margin-top: 24px; display: flex; gap: 10px;">
                <a
                    href="{{ route('competencies.edit', $competency) }}"
                    style="background: #d97706; color: white; padding: 10px 16px; border-radius: 7px; text-decoration: none;"
                >
                    Edit
                </a>

                <a
                    href="{{ route('competencies.index') }}"
                    style="border: 1px solid #d1d5db; color: #374151; padding: 10px 16px; border-radius: 7px; text-decoration: none;"
                >
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>