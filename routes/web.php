<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingParticipantController;

use App\Http\Controllers\TrainingSummaryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TrainingOverviewController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Public Presence Routes (Protected by Signed URL)
Route::get('trainings/{training}/presence', [TrainingController::class, 'processPresence'])->name('trainings.presence')->middleware('signed');
Route::post('trainings/{training}/presence', [TrainingController::class, 'submitPresence'])->name('trainings.submit_presence');

Route::middleware(['auth', 'verified', 'npk_restrict'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Training Routes (PIC)
    Route::get('trainings/{training}/scoring', [TrainingController::class, 'scoring'])->name('trainings.scoring');
    Route::post('trainings/{training}/scoring', [TrainingController::class, 'updateScoring'])->name('trainings.scoring.update');
    Route::get('trainings/{training}/import', [TrainingController::class, 'importForm'])->name('trainings.importForm');
    Route::post('trainings/{training}/import', [TrainingController::class, 'import'])->name('trainings.import');
    Route::delete('trainings/{training}/participants/{participant}', [TrainingController::class, 'removeParticipant'])->name('trainings.remove_participant');
    Route::get('trainings/{training}/observation-template', [TrainingController::class, 'exportObservationTemplate'])->name('trainings.observation_template');
    Route::get('trainings/{training}/participant-template', [TrainingController::class, 'exportParticipantTemplate'])->name('trainings.participant_template');
    Route::post('trainings/{training}/import-observation', [TrainingController::class, 'importObservation'])->name('trainings.import_observation');
    Route::post('trainings/{training}/sync-observation', [TrainingController::class, 'syncObservationFromGoogleSheets'])->name('trainings.sync_observation');
    Route::resource('trainings', TrainingController::class);

    // Participant Routes
    // Attendance QR Routes
    Route::get('trainings/{training}/attendance-qr', [TrainingController::class, 'showAttendanceQr'])->name('trainings.attendance_qr');
    Route::get('trainings/{training}/scan', [TrainingController::class, 'scanAttendance'])->name('trainings.scan');
    Route::get('trainings/{training}/attendance-list', [TrainingController::class, 'attendanceList'])->name('trainings.attendance_list');

    Route::post('participants/{participant}/toggle-attendance', [TrainingParticipantController::class, 'toggleAttendance'])->name('participants.toggle_attendance');
    Route::post('participants/{participant}/update-score', [TrainingParticipantController::class, 'updateScore'])->name('participants.update_score');
    Route::post('participants/{participant}/update-field', [TrainingParticipantController::class, 'updateField'])->name('participants.update_field');
    Route::resource('trainings.participants', TrainingParticipantController::class)->shallow();



    // Summary Routes
    Route::get('/trainings/{training}/summary', [TrainingSummaryController::class, 'show'])->name('summaries.show');
    Route::post('/trainings/{training}/summary', [TrainingSummaryController::class, 'store'])->name('summaries.store');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::post('employees/bulk-photo', [\App\Http\Controllers\Admin\EmployeeController::class, 'bulkPhotoStore'])->name('employees.bulk-photo');
        Route::get('employees/sync', [\App\Http\Controllers\UserImportController::class, 'index'])->name('import-users.index');
        Route::post('employees/sync', [\App\Http\Controllers\UserImportController::class, 'import'])->name('import-users.run');
        Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);

        // Master Data Training
        Route::get('master-trainings/export', [\App\Http\Controllers\Admin\MasterTrainingController::class, 'exportCsv'])->name('master-trainings.export');
        Route::post('master-trainings/import', [\App\Http\Controllers\Admin\MasterTrainingController::class, 'importCsv'])->name('master-trainings.import');
        Route::get('master-trainings/{master_training}/execute', [\App\Http\Controllers\Admin\MasterTrainingController::class, 'execute'])->name('master-trainings.execute');
        Route::post('master-trainings/{master_training}/execute', [\App\Http\Controllers\Admin\MasterTrainingController::class, 'storeExecution'])->name('master-trainings.store_execution');
        Route::get('master-trainings/get-next-code', [\App\Http\Controllers\Admin\MasterTrainingController::class, 'getNextCode'])->name('master-trainings.get-next-code');
        Route::get('search-users', [\App\Http\Controllers\Admin\MasterTrainingController::class, 'searchUsers'])->name('search-users');
        Route::resource('master-trainings', \App\Http\Controllers\Admin\MasterTrainingController::class);

        Route::get('/trainings', [TrainingOverviewController::class, 'index'])->name('trainings.index');
        Route::get('/trainings/{training}', [TrainingOverviewController::class, 'show'])->name('trainings.show');
        Route::post('/trainings/{training}/bulk-attendance', [TrainingController::class, 'bulkAttendance'])->name('trainings.bulk_attendance');
        Route::post('/trainings/{training}/approve', [TrainingController::class, 'approve'])->name('trainings.approve');
        Route::delete('/trainings/{training}', [TrainingOverviewController::class, 'destroy'])->name('trainings.destroy');

        // Training Evaluation & Atmosphere
        Route::get('/trainings/{training}/csi-template', [\App\Http\Controllers\Admin\TrainingEvaluationController::class, 'exportTemplate'])->name('trainings.csi_template');
        Route::post('/trainings/{training}/import-csi', [\App\Http\Controllers\Admin\TrainingEvaluationController::class, 'import'])->name('trainings.import_csi');
        Route::post('/trainings/{training}/manual-csi', [\App\Http\Controllers\Admin\TrainingEvaluationController::class, 'manualInput'])->name('trainings.manual_csi');
        Route::post('/trainings/{training}/import-csi-json', [\App\Http\Controllers\Admin\TrainingEvaluationController::class, 'importJson'])->name('trainings.import_csi_json');
        Route::post('/trainings/{training}/sync-csi', [\App\Http\Controllers\Admin\TrainingEvaluationController::class, 'syncFromGoogleSheets'])->name('trainings.sync_csi');
        Route::post('/trainings/{training}/atmospheres', [\App\Http\Controllers\Admin\TrainingAtmosphereController::class, 'store'])->name('trainings.atmospheres.store');
        Route::delete('/atmospheres/{atmosphere}', [\App\Http\Controllers\Admin\TrainingAtmosphereController::class, 'destroy'])->name('trainings.atmospheres.destroy');
    });
});

require __DIR__ . '/auth.php';

// TEMPORARY — dev only
require __DIR__ . '/temp_read_excel.php';
