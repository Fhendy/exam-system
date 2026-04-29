<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root ke login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect('/admin/dashboard') 
            : redirect()->route('student.enter-code');
    }
    return redirect('/login');
});

// Student Routes
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/enter-code', [StudentController::class, 'enterExamCode'])->name('enter-code');
    Route::post('/verify-code', [StudentController::class, 'verifyCode'])->name('verify-code');
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/exam/{code}', [StudentController::class, 'takeExam'])->name('exam');
    Route::post('/report-cheating', [StudentController::class, 'reportCheating'])->name('report-cheating');
    Route::post('/submit', [StudentController::class, 'submit'])->name('submit');
    Route::post('/request-activation', [StudentController::class, 'requestActivation'])->name('request-activation');
    Route::get('/timeout', [StudentController::class, 'timeout'])->name('timeout');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Students
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('students.delete');
    
    // Exams
    Route::get('/exams', [AdminController::class, 'exams'])->name('exams');
    Route::get('/exams/create', [AdminController::class, 'createExam'])->name('exams.create');
    Route::post('/exams', [AdminController::class, 'storeExam'])->name('exams.store');
    Route::get('/exams/{id}/edit', [AdminController::class, 'editExam'])->name('exams.edit');
    Route::put('/exams/{id}', [AdminController::class, 'updateExam'])->name('exams.update');
    Route::delete('/exams/{id}', [AdminController::class, 'deleteExam'])->name('exams.delete');
    Route::post('/exams/{id}/toggle', [AdminController::class, 'toggleExam'])->name('exams.toggle');
    
    // Sessions
    Route::get('/sessions', [AdminController::class, 'sessions'])->name('sessions');
    Route::post('/sessions/{sessionId}/unlock', [AdminController::class, 'unlockSession'])->name('sessions.unlock');
    
    // Cheats
    Route::get('/cheats', [AdminController::class, 'cheatLogs'])->name('cheats');
    
    // Activations
    Route::get('/activations', [AdminController::class, 'activationCodes'])->name('activations');
    Route::get('/activation/generate/{sessionId}', [AdminController::class, 'generateActivationCode']);
    Route::post('/activation/use', [AdminController::class, 'useActivationCode'])->name('use-activation');
});