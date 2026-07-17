<?php
use App\Http\Controllers\FinalGradeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompetencyController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StageProposalController;
use App\Http\Controllers\EvaluationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::resource('internships', InternshipController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('competencies', CompetencyController::class);
    Route::resource('logbooks', LogbookController::class);

    Route::post(
        '/stage-proposals/{stageProposal}/feedback',
        [StageProposalController::class, 'feedback']
    )->name('stage-proposals.feedback');

    Route::patch(
        '/stage-proposals/{stageProposal}/approve',
        [StageProposalController::class, 'approve']
    )->name('stage-proposals.approve');

    Route::patch(
        '/stage-proposals/{stageProposal}/reject',
        [StageProposalController::class, 'reject']
    )->name('stage-proposals.reject');

    Route::resource('stage-proposals', StageProposalController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('final-grades', FinalGradeController::class);
    Route::resource('users', UserManagementController::class);
});

require __DIR__.'/auth.php';