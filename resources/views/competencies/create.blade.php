<x-app-layout>
    <div class="p-6">

        <h1 class="text-xl font-bold mb-4">Create Competency</h1>

        <form method="POST" action="{{ route('competencies.store') }}">
            @csrf

            <div>
                <label>Title</label><br>
                <input type="text" name="title">
            </div>

            <br>

            <div>
                <label>Description</label><br>
                <textarea name="description"></textarea>
            </div>

            <br>

            <button type="submit">
                Save
            </button>

        </form>

    </div>
</x-app-layout>