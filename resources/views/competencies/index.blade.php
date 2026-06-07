<x-app-layout>
    <div class="p-6">

        <h1 class="text-xl font-bold mb-4">Competencies</h1>

        <a href="{{ route('competencies.create') }}">
            Create Competency
        </a>

        <br><br>

        @foreach($competencies as $competency)

            <div class="border p-3 mb-2">
                <strong>{{ $competency->title }}</strong><br>

                {{ $competency->description }}
            </div>

        @endforeach

    </div>
</x-app-layout>