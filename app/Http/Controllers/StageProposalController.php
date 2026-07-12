<?php

namespace App\Http\Controllers;

use App\Models\CommitteeFeedback;
use App\Models\Company;
use App\Models\Internship;
use App\Models\StageProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StageProposalController extends Controller
{
    /**
     * Display the proposals.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'student') {
            $stageProposals = StageProposal::with([
                'company',
                'feedback.committeeUser',
                'internship',
            ])
                ->where('student_id', $user->id)
                ->latest()
                ->get();
        } elseif (in_array($user->role, ['committee', 'teacher', 'admin'], true)) {
            $stageProposals = StageProposal::with([
                'student',
                'company',
                'feedback.committeeUser',
                'internship',
            ])
                ->latest()
                ->get();
        } else {
            abort(403, 'You are not allowed to view stage proposals.');
        }

        return view('stage_proposals.index', compact('stageProposals'));
    }

    /**
     * Show the form for creating a proposal.
     */
    public function create()
    {
        $this->ensureRole('student');

        $companies = Company::orderBy('name')->get();

        return view('stage_proposals.create', compact('companies'));
    }

    /**
     * Store a new proposal.
     */
    public function store(Request $request)
    {
        $this->ensureRole('student');

        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'motivation' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $validated['student_id'] = auth()->id();
        $validated['status'] = 'pending';

        StageProposal::create($validated);

        return redirect()
            ->route('stage-proposals.index')
            ->with('success', 'Your stage proposal was submitted successfully.');
    }

    /**
     * Display one proposal.
     */
    public function show(StageProposal $stageProposal)
    {
        $user = auth()->user();

        $isOwner = $user->role === 'student'
            && $stageProposal->student_id === $user->id;

        $canReview = in_array(
            $user->role,
            ['committee', 'teacher', 'admin'],
            true
        );

        if (!$isOwner && !$canReview) {
            abort(403, 'You are not allowed to view this proposal.');
        }

        $stageProposal->load([
            'student',
            'company',
            'approvedBy',
            'feedback.committeeUser',
            'internship',
        ]);

        return view('stage_proposals.show', compact('stageProposal'));
    }

    /**
     * Show the edit form.
     */
    public function edit(StageProposal $stageProposal)
    {
        $this->ensureStudentOwner($stageProposal);

        if ($stageProposal->status !== 'pending') {
            return redirect()
                ->route('stage-proposals.show', $stageProposal)
                ->with('error', 'Only pending proposals can be edited.');
        }

        $companies = Company::orderBy('name')->get();

        return view(
            'stage_proposals.edit',
            compact('stageProposal', 'companies')
        );
    }

    /**
     * Update a pending proposal.
     */
    public function update(Request $request, StageProposal $stageProposal)
    {
        $this->ensureStudentOwner($stageProposal);

        if ($stageProposal->status !== 'pending') {
            return redirect()
                ->route('stage-proposals.show', $stageProposal)
                ->with('error', 'Only pending proposals can be updated.');
        }

        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'motivation' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $stageProposal->update($validated);

        return redirect()
            ->route('stage-proposals.show', $stageProposal)
            ->with('success', 'The stage proposal was updated successfully.');
    }

    /**
     * Delete a pending proposal.
     */
    public function destroy(StageProposal $stageProposal)
    {
        $this->ensureStudentOwner($stageProposal);

        if ($stageProposal->status !== 'pending') {
            return redirect()
                ->route('stage-proposals.show', $stageProposal)
                ->with('error', 'Only pending proposals can be deleted.');
        }

        $stageProposal->delete();

        return redirect()
            ->route('stage-proposals.index')
            ->with('success', 'The stage proposal was deleted successfully.');
    }

    /**
     * Add committee feedback without making a final decision.
     */
    public function feedback(Request $request, StageProposal $stageProposal)
    {
        $this->ensureCommitteeOrAdmin();

        $validated = $request->validate([
            'feedback' => ['required', 'string'],
        ]);

        CommitteeFeedback::create([
            'stage_proposal_id' => $stageProposal->id,
            'committee_user_id' => auth()->id(),
            'feedback' => $validated['feedback'],
            'decision' => 'feedback',
        ]);

        return redirect()
            ->route('stage-proposals.show', $stageProposal)
            ->with('success', 'Feedback was sent to the student.');
    }

    /**
     * Approve the proposal and create the internship.
     */
    public function approve(Request $request, StageProposal $stageProposal)
    {
        $this->ensureCommitteeOrAdmin();

        if ($stageProposal->status === 'approved') {
            return redirect()
                ->route('stage-proposals.show', $stageProposal)
                ->with('error', 'This proposal has already been approved.');
        }

        $validated = $request->validate([
            'feedback' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($stageProposal, $validated) {
            $internship = $stageProposal->internship;

            if (!$internship) {
                $internship = Internship::create([
                    'user_id' => $stageProposal->student_id,
                    'company_id' => $stageProposal->company_id,
                    'title' => $stageProposal->title,
                    'description' => $stageProposal->description,
                    'start_date' => $stageProposal->start_date,
                    'end_date' => $stageProposal->end_date,
                    'status' => 'approved',
                ]);
            }

            $stageProposal->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'internship_id' => $internship->id,
            ]);

            CommitteeFeedback::create([
                'stage_proposal_id' => $stageProposal->id,
                'committee_user_id' => auth()->id(),
                'feedback' => $validated['feedback']
                    ?? 'The proposal was approved.',
                'decision' => 'approved',
            ]);
        });

        return redirect()
            ->route('stage-proposals.show', $stageProposal)
            ->with('success', 'The proposal was approved successfully.');
    }

    /**
     * Reject the proposal.
     */
    public function reject(Request $request, StageProposal $stageProposal)
    {
        $this->ensureCommitteeOrAdmin();

        $validated = $request->validate([
            'feedback' => ['required', 'string'],
        ]);

        DB::transaction(function () use ($stageProposal, $validated) {
            $stageProposal->update([
                'status' => 'rejected',
                'approved_by' => null,
                'approved_at' => null,
                'internship_id' => null,
            ]);

            CommitteeFeedback::create([
                'stage_proposal_id' => $stageProposal->id,
                'committee_user_id' => auth()->id(),
                'feedback' => $validated['feedback'],
                'decision' => 'rejected',
            ]);
        });

        return redirect()
            ->route('stage-proposals.show', $stageProposal)
            ->with('success', 'The proposal was rejected and feedback was sent.');
    }

    /**
     * Allow only a specific role.
     */
    private function ensureRole(string $role): void
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'You are not allowed to perform this action.');
        }
    }

    /**
     * Allow only the student who owns the proposal.
     */
    private function ensureStudentOwner(StageProposal $stageProposal): void
    {
        $user = auth()->user();

        if (
            $user->role !== 'student'
            || $stageProposal->student_id !== $user->id
        ) {
            abort(403, 'You are not allowed to modify this proposal.');
        }
    }

    /**
     * Allow only committee members and admins.
     */
    private function ensureCommitteeOrAdmin(): void
    {
        if (
            !in_array(
                auth()->user()->role,
                ['committee', 'admin'],
                true
            )
        ) {
            abort(403, 'Only the stage committee can perform this action.');
        }
    }
}