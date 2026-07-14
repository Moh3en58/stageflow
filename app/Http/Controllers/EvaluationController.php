<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use App\Models\Evaluation;
use App\Models\EvaluationScore;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EvaluationController extends Controller
{
    /**
     * Display evaluations relevant to the logged-in user.
     */
    public function index()
    {
        $user = auth()->user();

        $query = Evaluation::with([
            'internship.user',
            'internship.company',
            'evaluator',
            'scores.competency',
        ])->latest('evaluation_date');

        if ($user->role === 'student') {
            $query->whereHas('internship', function ($internshipQuery) use ($user) {
                $internshipQuery->where('user_id', $user->id);
            });
        } elseif ($user->role === 'mentor') {
            $query->where('evaluator_id', $user->id);
        } elseif (!in_array($user->role, ['teacher', 'admin'], true)) {
            abort(403, 'You are not allowed to view evaluations.');
        }

        $evaluations = $query->get();

        $availableInternships = collect();

        if ($user->role === 'student') {
            $availableInternships = Internship::with('company')
                ->where('user_id', $user->id)
                ->where('status', 'approved')
                ->orderBy('start_date')
                ->get();
        } elseif ($user->role === 'mentor') {
            $availableInternships = Internship::with(['company', 'user'])
                ->where('status', 'approved')
                ->orderBy('start_date')
                ->get();
        }

        return view(
            'evaluations.index',
            compact('evaluations', 'availableInternships')
        );
    }

    /**
     * Show the evaluation form.
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['student', 'mentor'], true)) {
            abort(403, 'Only students and mentors can create evaluations.');
        }

        $request->validate([
            'internship_id' => ['required', 'exists:internships,id'],
            'evaluation_type' => [
                'required',
                Rule::in(['midterm', 'final']),
            ],
        ]);

        $internship = Internship::with(['company', 'user'])
            ->findOrFail($request->integer('internship_id'));

        $this->ensureInternshipCanBeEvaluated($internship);

        if (
            $user->role === 'student'
            && $internship->user_id !== $user->id
        ) {
            abort(403, 'You can only evaluate your own internship.');
        }

        $evaluatorRole = $user->role;

        $existingEvaluation = Evaluation::where(
            'internship_id',
            $internship->id
        )
            ->where('evaluator_id', $user->id)
            ->where('evaluation_type', $request->evaluation_type)
            ->where('evaluator_role', $evaluatorRole)
            ->first();

        if ($existingEvaluation) {
            return redirect()
                ->route('evaluations.edit', $existingEvaluation)
                ->with(
                    'error',
                    'You already created this evaluation. You can edit it here.'
                );
        }

        $competencies = Competency::where('active', true)
            ->orderBy('title')
            ->get();

        return view(
            'evaluations.create',
            [
                'internship' => $internship,
                'competencies' => $competencies,
                'evaluationType' => $request->evaluation_type,
            ]
        );
    }

    /**
     * Store a new evaluation and its competency scores.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['student', 'mentor'], true)) {
            abort(403, 'Only students and mentors can create evaluations.');
        }

        $validated = $request->validate([
            'internship_id' => ['required', 'exists:internships,id'],
            'evaluation_type' => [
                'required',
                Rule::in(['midterm', 'final']),
            ],
            'comments' => ['nullable', 'string', 'max:5000'],
            'scores' => ['required', 'array', 'min:1'],
            'scores.*.score' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'scores.*.comment' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $internship = Internship::findOrFail(
            $validated['internship_id']
        );

        $this->ensureInternshipCanBeEvaluated($internship);

        if (
            $user->role === 'student'
            && $internship->user_id !== $user->id
        ) {
            abort(403, 'You can only evaluate your own internship.');
        }

        $activeCompetencyIds = Competency::where('active', true)
            ->pluck('id')
            ->map(fn ($id) => (string) $id);

        $submittedCompetencyIds = collect(
            array_keys($validated['scores'])
        )->map(fn ($id) => (string) $id);

        if (
            $activeCompetencyIds->sort()->values()->all()
            !== $submittedCompetencyIds->sort()->values()->all()
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'scores' => 'A score is required for every active competency.',
                ]);
        }

        $duplicateEvaluation = Evaluation::where(
            'internship_id',
            $internship->id
        )
            ->where('evaluator_id', $user->id)
            ->where('evaluation_type', $validated['evaluation_type'])
            ->where('evaluator_role', $user->role)
            ->exists();

        if ($duplicateEvaluation) {
            return redirect()
                ->route('evaluations.index')
                ->with(
                    'error',
                    'This evaluation has already been submitted.'
                );
        }

        $evaluation = DB::transaction(function () use (
            $validated,
            $user
        ) {
            $evaluation = Evaluation::create([
                'internship_id' => $validated['internship_id'],
                'evaluator_id' => $user->id,
                'evaluation_type' => $validated['evaluation_type'],
                'evaluator_role' => $user->role,
                'evaluation_date' => now()->toDateString(),
                'comments' => $validated['comments'] ?? null,
            ]);

            foreach ($validated['scores'] as $competencyId => $scoreData) {
                EvaluationScore::create([
                    'evaluation_id' => $evaluation->id,
                    'competency_id' => $competencyId,
                    'score' => $scoreData['score'],
                    'comment' => $scoreData['comment'] ?? null,
                ]);
            }

            return $evaluation;
        });

        return redirect()
            ->route('evaluations.show', $evaluation)
            ->with('success', 'The evaluation was submitted successfully.');
    }

    /**
     * Display one evaluation.
     */
    public function show(Evaluation $evaluation)
    {
        $this->authorizeEvaluationView($evaluation);

        $evaluation->load([
            'internship.user',
            'internship.company',
            'evaluator',
            'scores.competency',
        ]);

        return view('evaluations.show', compact('evaluation'));
    }

    /**
     * Show the edit form.
     */
    public function edit(Evaluation $evaluation)
    {
        $this->authorizeEvaluationModification($evaluation);

        $evaluation->load([
            'internship.user',
            'internship.company',
            'scores.competency',
        ]);

        $competencies = Competency::where('active', true)
            ->orderBy('title')
            ->get();

        $existingScores = $evaluation->scores->keyBy('competency_id');

        return view(
            'evaluations.edit',
            compact(
                'evaluation',
                'competencies',
                'existingScores'
            )
        );
    }

    /**
     * Update an evaluation and its scores.
     */
    public function update(
        Request $request,
        Evaluation $evaluation
    ) {
        $this->authorizeEvaluationModification($evaluation);

        $validated = $request->validate([
            'comments' => ['nullable', 'string', 'max:5000'],
            'scores' => ['required', 'array', 'min:1'],
            'scores.*.score' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'scores.*.comment' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $activeCompetencyIds = Competency::where('active', true)
            ->pluck('id')
            ->map(fn ($id) => (string) $id);

        $submittedCompetencyIds = collect(
            array_keys($validated['scores'])
        )->map(fn ($id) => (string) $id);

        if (
            $activeCompetencyIds->sort()->values()->all()
            !== $submittedCompetencyIds->sort()->values()->all()
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'scores' => 'A score is required for every active competency.',
                ]);
        }

        DB::transaction(function () use ($evaluation, $validated) {
            $evaluation->update([
                'comments' => $validated['comments'] ?? null,
                'evaluation_date' => now()->toDateString(),
            ]);

            foreach ($validated['scores'] as $competencyId => $scoreData) {
                EvaluationScore::updateOrCreate(
                    [
                        'evaluation_id' => $evaluation->id,
                        'competency_id' => $competencyId,
                    ],
                    [
                        'score' => $scoreData['score'],
                        'comment' => $scoreData['comment'] ?? null,
                    ]
                );
            }
        });

        return redirect()
            ->route('evaluations.show', $evaluation)
            ->with('success', 'The evaluation was updated successfully.');
    }

    /**
     * Delete an evaluation.
     */
    public function destroy(Evaluation $evaluation)
    {
        $user = auth()->user();

        if (
            $evaluation->evaluator_id !== $user->id
            && $user->role !== 'admin'
        ) {
            abort(403, 'You are not allowed to delete this evaluation.');
        }

        DB::transaction(function () use ($evaluation) {
            $evaluation->scores()->delete();
            $evaluation->delete();
        });

        return redirect()
            ->route('evaluations.index')
            ->with('success', 'The evaluation was deleted successfully.');
    }

    /**
     * Ensure the internship is approved.
     */
    private function ensureInternshipCanBeEvaluated(
        Internship $internship
    ): void {
        if ($internship->status !== 'approved') {
            abort(403, 'Only approved internships can be evaluated.');
        }
    }

    /**
     * Check whether the logged-in user can view an evaluation.
     */
    private function authorizeEvaluationView(
        Evaluation $evaluation
    ): void {
        $user = auth()->user();

        $evaluation->loadMissing('internship');

        $isStudentOwner =
            $user->role === 'student'
            && $evaluation->internship->user_id === $user->id;

        $isEvaluator = $evaluation->evaluator_id === $user->id;

        $canReview = in_array(
            $user->role,
            ['teacher', 'admin'],
            true
        );

        if (!$isStudentOwner && !$isEvaluator && !$canReview) {
            abort(403, 'You are not allowed to view this evaluation.');
        }
    }

    /**
     * Check whether the logged-in user can edit an evaluation.
     */
    private function authorizeEvaluationModification(
        Evaluation $evaluation
    ): void {
        if ($evaluation->evaluator_id !== auth()->id()) {
            abort(403, 'You can only edit your own evaluation.');
        }
    }
}