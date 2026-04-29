<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Dashboard (sudah ada)
    public function dashboard()
    {
        $stats = [
            'total_students' => DB::table('users')->where('role', 'student')->count(),
            'total_exams' => DB::table('exams')->count(),
            'active_exams' => DB::table('exams')->where('is_active', true)->count(),
            'total_sessions' => DB::table('exam_sessions')->count(),
            'active_sessions' => DB::table('exam_sessions')->whereNull('completed_at')->where('is_locked', false)->count(),
            'locked_sessions' => DB::table('exam_sessions')->where('is_locked', true)->count(),
            'total_cheats' => DB::table('cheat_logs')->count(),
            'pending_activations' => DB::table('activation_codes')->where('is_used', false)->where('expires_at', '>', now())->count(),
        ];

        $recentSessions = DB::table('exam_sessions')
            ->join('users', 'exam_sessions.user_id', '=', 'users.id')
            ->select('exam_sessions.*', 'users.name as student_name', 'users.nis')
            ->orderBy('exam_sessions.created_at', 'desc')
            ->limit(10)
            ->get();

        $recentCheats = DB::table('cheat_logs')
            ->join('users', 'cheat_logs.user_id', '=', 'users.id')
            ->select('cheat_logs.*', 'users.name as student_name')
            ->orderBy('cheat_logs.created_at', 'desc')
            ->limit(10)
            ->get();

        $activeCodes = DB::table('activation_codes')
            ->join('users', 'activation_codes.user_id', '=', 'users.id')
            ->select('activation_codes.*', 'users.name as student_name')
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSessions', 'recentCheats', 'activeCodes'));
    }

    // ==================== STUDENT MANAGEMENT ====================
    public function students()
    {
        $students = DB::table('users')->where('role', 'student')->orderBy('created_at', 'desc')->get();
        return view('admin.students.index', compact('students'));
    }

    public function createStudent()
    {
        return view('admin.students.create');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'class_group' => 'nullable|string|max:50',
        ]);

    DB::table('users')->insert([
        'nis' => $request->nis,
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'class_group' => $request->class_group, // TAMBAHKAN INI
        'role' => 'student',
        'is_active' => $request->has('is_active'),
        'created_at' => now(),
    ]);

    return redirect('/admin/students')->with('success', 'Siswa berhasil ditambahkan!');
}

    public function editStudent($id)
    {
        $student = DB::table('users')->where('id', $id)->first();
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|unique:users,nis,' . $id,
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'class_group' => 'nullable|string|max:50',
        ]);

    $data = [
        'nis' => $request->nis,
        'name' => $request->name,
        'email' => $request->email,
        'class_group' => $request->class_group, // TAMBAHKAN INI
        'is_active' => $request->has('is_active'),
        'updated_at' => now(),
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    DB::table('users')->where('id', $id)->update($data);

    return redirect('/admin/students')->with('success', 'Siswa berhasil diupdate!');
}

    public function deleteStudent($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('/admin/students')->with('success', 'Siswa berhasil dihapus!');
    }

    // ==================== EXAM MANAGEMENT ====================
    public function exams()
    {
        $exams = DB::table('exams')->orderBy('created_at', 'desc')->get();
        return view('admin.exams.index', compact('exams'));
    }

    public function createExam()
    {
        return view('admin.exams.create');
    }

// Store Exam - CREATE
public function storeExam(Request $request)
{
    $request->validate([
        'code' => 'required|unique:exams|max:10',
        'title' => 'required',
        'duration_minutes' => 'required|integer|min:1',
        'max_strikes' => 'required|integer|min:1|max:10',
    ]);

    // Proses iframe HTML atau URL
    $iframeHtml = $request->iframe_html;
    $iframeUrl = null;

    if ($iframeHtml) {
        // Extract src URL from iframe HTML
        preg_match('/src="([^"]+)"/', $iframeHtml, $matches);
        if (isset($matches[1])) {
            $iframeUrl = $matches[1];
        }
        // Simpan HTML asli
        $iframeHtml = $iframeHtml;
    } else {
        $iframeUrl = $request->iframe_url;
    }

    DB::table('exams')->insert([
        'code' => strtoupper($request->code),
        'title' => $request->title,
        'description' => $request->description,
        'iframe_url' => $iframeUrl,
        'iframe_html' => $iframeHtml,
        'duration_minutes' => $request->duration_minutes,
        'max_strikes' => $request->max_strikes,
        'passing_score' => $request->passing_score ?? 70,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'is_active' => $request->has('is_active'),
        'created_at' => now(),
    ]);

    return redirect('/admin/exams')->with('success', 'Ujian berhasil dibuat!');
}

// Update Exam - EDIT
public function updateExam(Request $request, $id)
{
    $request->validate([
        'code' => 'required|max:10|unique:exams,code,' . $id,
        'title' => 'required',
        'duration_minutes' => 'required|integer|min:1',
    ]);

    // Proses iframe HTML atau URL
    $iframeHtml = $request->iframe_html;
    $iframeUrl = null;

    if ($iframeHtml) {
        // Extract src URL from iframe HTML
        preg_match('/src="([^"]+)"/', $iframeHtml, $matches);
        if (isset($matches[1])) {
            $iframeUrl = $matches[1];
        }
        $iframeHtml = $iframeHtml;
    } else {
        $iframeUrl = $request->iframe_url;
    }

    DB::table('exams')->where('id', $id)->update([
        'code' => strtoupper($request->code),
        'title' => $request->title,
        'description' => $request->description,
        'iframe_url' => $iframeUrl,
        'iframe_html' => $iframeHtml,
        'duration_minutes' => $request->duration_minutes,
        'max_strikes' => $request->max_strikes,
        'passing_score' => $request->passing_score,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'is_active' => $request->has('is_active'),
        'updated_at' => now(),
    ]);

    return redirect('/admin/exams')->with('success', 'Ujian berhasil diupdate!');
}

    public function editExam($id)
    {
        $exam = DB::table('exams')->where('id', $id)->first();
        if (!$exam) {
            return redirect('/admin/exams')->with('error', 'Ujian tidak ditemukan');
        }
        return view('admin.exams.edit', compact('exam'));
    }



    public function deleteExam($id)
    {
        DB::table('exams')->where('id', $id)->delete();
        return redirect('/admin/exams')->with('success', 'Ujian berhasil dihapus!');
    }

    public function toggleExam($id)
    {
        $exam = DB::table('exams')->where('id', $id)->first();
        DB::table('exams')->where('id', $id)->update([
            'is_active' => !$exam->is_active,
            'updated_at' => now()
        ]);
        return back()->with('success', 'Status ujian berhasil diubah!');
    }

    // ==================== SESSION MONITORING ====================
    public function sessions()
    {
        $sessions = DB::table('exam_sessions')
            ->join('users', 'exam_sessions.user_id', '=', 'users.id')
            ->select('exam_sessions.*', 'users.name as student_name', 'users.nis')
            ->orderBy('exam_sessions.created_at', 'desc')
            ->paginate(20);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function unlockSession($sessionId)
    {
        DB::table('exam_sessions')
            ->where('session_id', $sessionId)
            ->update([
                'is_locked' => false,
                'strikes' => 0,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Sesi ujian berhasil dibuka kembali!');
    }

    // ==================== CHEAT LOGS ====================
    public function cheatLogs()
    {
        // Di AdminController method cheatLogs()
    $cheats = DB::table('cheat_logs')
        ->join('users', 'cheat_logs.user_id', '=', 'users.id')
        ->select('cheat_logs.*', 'users.name as student_name', 'users.nis', 'users.class_group')
        ->orderBy('cheat_logs.created_at', 'desc')
        ->paginate(20);

        return view('admin.cheats.index', compact('cheats'));
    }

    // ==================== ACTIVATION CODES ====================
public function activationCodes()
{
    $codes = DB::table('activation_codes')
        ->join('users', 'activation_codes.user_id', '=', 'users.id')
        ->select('activation_codes.*', 'users.name as student_name', 'users.nis', 'users.class_group')
        ->orderBy('activation_codes.created_at', 'desc')
        ->get();

    return view('admin.activations.index', compact('codes'));
}
public function generateActivationCode($sessionId)
{
    // Generate kode 5 karakter (HURUF BESAR + ANGKA, tanpa huruf mirip O0I1)
    $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $code = '';
    for ($i = 0; $i < 5; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    // Pastikan kode unik (jika sudah ada, generate ulang)
    while (DB::table('activation_codes')->where('code', $code)->exists()) {
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
    }
    
    $session = DB::table('exam_sessions')->where('session_id', $sessionId)->first();

    if (!$session) {
        return response()->json(['error' => 'Session not found'], 404);
    }

    // Hapus kode lama yang belum dipakai untuk session yang sama
    DB::table('activation_codes')
        ->where('session_id', $sessionId)
        ->where('is_used', false)
        ->delete();

    DB::table('activation_codes')->insert([
        'code' => $code,
        'user_id' => $session->user_id,
        'session_id' => $sessionId,
        'is_used' => false,
        'expires_at' => now()->addHours(24),
        'created_at' => now(),
    ]);

    return response()->json(['code' => $code]);
}

    public function useActivationCode(Request $request)
    {
        $code = $request->code;
        
        $activation = DB::table('activation_codes')
            ->where('code', $code)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$activation) {
            return response()->json(['success' => false, 'message' => 'Kode tidak valid atau sudah kadaluarsa.']);
        }

        DB::table('activation_codes')->where('id', $activation->id)->update([
            'is_used' => true,
            'updated_at' => now()
        ]);

        DB::table('exam_sessions')
            ->where('session_id', $activation->session_id)
            ->update([
                'is_locked' => false,
                'strikes' => 0,
                'updated_at' => now()
            ]);

        return response()->json(['success' => true, 'message' => 'Sesi berhasil diaktifkan kembali!']);
    }
}