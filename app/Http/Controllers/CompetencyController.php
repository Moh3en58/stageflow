<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{
    public function index()
    {
        $this->authorizeManagement();

        $competencies = Competency::orderBy('title')->get();

        return view('competencies.index', compact('competencies'));
    }

    public function create()
    {
        $this->authorizeManagement();

        return view('competencies.create');
    }

    public function store(Request $request)
    {
        $this->authorizeManagement();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'weight' => ['required', 'integer', 'min:1', 'max:100'],
            'active' => ['nullable', 'boolean'],
        ]);

        $validated['active'] = $request->boolean('active');

        Competency::create($validated);

        return redirect()
            ->route('competencies.index')
            ->with('success', 'Competency created successfully.');
    }

    public function show(Competency $competency)
    {
        $this->authorizeManagement();

        return view('competencies.show', compact('competency'));
    }

    public function edit(Competency $competency)
    {
        $this->authorizeManagement();

        return view('competencies.edit', compact('competency'));
    }

    public function update(Request $request, Competency $competency)
    {
        $this->authorizeManagement();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'weight' => ['required', 'integer', 'min:1', 'max:100'],
            'active' => ['nullable', 'boolean'],
        ]);

        $validated['active'] = $request->boolean('active');

        $competency->update($validated);

        return redirect()
            ->route('competencies.index')
            ->with('success', 'Competency updated successfully.');
    }

    public function destroy(Competency $competency)
    {
        $this->authorizeManagement();

        if ($competency->evaluationScores()->exists()) {
            return redirect()
                ->route('competencies.index')
                ->with(
                    'error',
                    'This competency cannot be deleted because it is already used in evaluations.'
                );
        }

        $competency->delete();

        return redirect()
            ->route('competencies.index')
            ->with('success', 'Competency deleted successfully.');
    }

    private function authorizeManagement(): void
    {
        if (!in_array(auth()->user()->role, ['admin', 'teacher'], true)) {
            abort(403, 'You are not allowed to manage competencies.');
        }
    }
}