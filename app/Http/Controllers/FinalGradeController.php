<?php

namespace App\Http\Controllers;

use App\Models\FinalGrade;
use App\Models\Internship;
use Illuminate\Http\Request;

class FinalGradeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!in_array($user->role, ['student', 'teacher', 'admin'], true)) {
            abort(403, 'You are not allowed to view final grades.');
        }

        $query = FinalGrade::with([
            'internship.user',
            'internship.company',
            'teacher',
        ])->latest();

        if ($user->role === 'student') {
            $query->whereHas('internship', function ($internshipQuery) use ($user) {
                $internshipQuery->where('user_id', $user->id);
            });
        }

        $finalGrades = $query->get();

        $availableInternships = collect();

        if (in_array($user->role, ['teacher', 'admin'], true)) {
            $availableInternships = Internship::with(['user', 'company'])
                ->where('status', 'approved')
                ->orderBy('start_date')
                ->get();
        }

        return view(
            'final-grades.index',
            compact('finalGrades', 'availableInternships')
        );
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['teacher', 'admin'], true)) {
            abort(403, 'Only teachers and administrators can register a final grade.');
        }

        $request->validate([
            'internship_id' => ['required', 'exists:internships,id'],
        ]);

        $internship = Internship::with(['user', 'company'])
            ->findOrFail($request->integer('internship_id'));

        if ($internship->status !== 'approved') {
            abort(403, 'Only approved internships can receive a final grade.');
        }

        $existingGrade = FinalGrade::where('internship_id', $internship->id)->first();

        if ($existingGrade) {
            return redirect()
                ->route('final-grades.edit', $existingGrade)
                ->with('error', 'A final grade already exists for this internship.');
        }

        return view('final-grades.create', compact('internship'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['teacher', 'admin'], true)) {
            abort(403, 'Only teachers and administrators can register a final grade.');
        }

        $validated = $request->validate([
            'internship_id' => ['required', 'exists:internships,id'],
            'grade' => ['required', 'numeric', 'between:0,20'],
            'feedback' => ['nullable', 'string', 'max:5000'],
        ]);

        $internship = Internship::findOrFail($validated['internship_id']);

        if ($internship->status !== 'approved') {
            abort(403, 'Only approved internships can receive a final grade.');
        }

        if (FinalGrade::where('internship_id', $internship->id)->exists()) {
            return redirect()
                ->route('final-grades.index')
                ->with('error', 'A final grade already exists for this internship.');
        }

        $finalGrade = FinalGrade::create([
            'internship_id' => $internship->id,
            'teacher_id' => $user->id,
            'grade' => $validated['grade'],
            'feedback' => $validated['feedback'] ?? null,
        ]);

        return redirect()
            ->route('final-grades.show', $finalGrade)
            ->with('success', 'The final grade was registered successfully.');
    }

    public function show(FinalGrade $finalGrade)
    {
        $this->authorizeView($finalGrade);

        $finalGrade->load([
            'internship.user',
            'internship.company',
            'teacher',
        ]);

        return view('final-grades.show', compact('finalGrade'));
    }

    public function edit(FinalGrade $finalGrade)
    {
        $this->authorizeManage();

        $finalGrade->load([
            'internship.user',
            'internship.company',
            'teacher',
        ]);

        return view('final-grades.edit', compact('finalGrade'));
    }

    public function update(Request $request, FinalGrade $finalGrade)
    {
        $this->authorizeManage();

        $validated = $request->validate([
            'grade' => ['required', 'numeric', 'between:0,20'],
            'feedback' => ['nullable', 'string', 'max:5000'],
        ]);

        $finalGrade->update([
            'grade' => $validated['grade'],
            'feedback' => $validated['feedback'] ?? null,
            'teacher_id' => auth()->id(),
        ]);

        return redirect()
            ->route('final-grades.show', $finalGrade)
            ->with('success', 'The final grade was updated successfully.');
    }

    public function destroy(FinalGrade $finalGrade)
    {
        $this->authorizeManage();

        $finalGrade->delete();

        return redirect()
            ->route('final-grades.index')
            ->with('success', 'The final grade was deleted successfully.');
    }

    private function authorizeManage(): void
    {
        if (!in_array(auth()->user()->role, ['teacher', 'admin'], true)) {
            abort(403, 'You are not allowed to manage final grades.');
        }
    }

    private function authorizeView(FinalGrade $finalGrade): void
    {
        $user = auth()->user();

        $finalGrade->loadMissing('internship');

        $isStudentOwner =
            $user->role === 'student'
            && $finalGrade->internship->user_id === $user->id;

        $canReview = in_array($user->role, ['teacher', 'admin'], true);

        if (!$isStudentOwner && !$canReview) {
            abort(403, 'You are not allowed to view this final grade.');
        }
    }
}