<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    // Dashboard untuk melihat riwayat (opsional, bisa diakses dari menu)
    public function dashboard()
    {
        $sessions = DB::table('exam_sessions')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.dashboard', compact('sessions'));
    }

    // Halaman input kode ujian (HALAMAN UTAMA SISWA)
    public function enterExamCode()
    {
        return view('student.enter-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'exam_code' => 'required|string',
        ]);

        $exam = DB::table('exams')
            ->where('code', $request->exam_code)
            ->where('is_active', true)
            ->first();

        if (!$exam) {
            return back()->with('error', 'Kode ujian tidak valid atau ujian belum aktif.');
        }



        // Cek apakah sudah pernah mengerjakan dan belum selesai
        $existing = DB::table('exam_sessions')
            ->where('user_id', Auth::id())
            ->where('exam_code', $request->exam_code)
            ->whereNull('completed_at')
            ->first();

        if ($existing && $existing->is_locked) {
        session(['exam_session' => null]);
            return redirect()->route('student.enter-code')->with('error', 'Sesi ujian Anda terkunci. Silahkan hubungi admin untuk aktivasi.');
        }

        if ($existing && !$existing->is_locked) {
            // Lanjutkan ujian yang sudah ada
            return redirect()->route('student.exam', ['code' => $request->exam_code]);
        }

        // Buat sesi baru
        return redirect()->route('student.exam', ['code' => $request->exam_code]);
    }

    public function takeExam($code)
    {
        $exam = DB::table('exams')->where('code', $code)->where('is_active', true)->first();

        if (!$exam) {
            return redirect()->route('student.enter-code')->with('error', 'Ujian tidak ditemukan.');
        }

        // Check existing session
        $existingSession = DB::table('exam_sessions')
            ->where('user_id', Auth::id())
            ->where('exam_code', $code)
            ->whereNull('completed_at')
            ->first();

        if ($existingSession && $existingSession->is_locked) {
            return redirect()->route('student.locked', ['sessionId' => $existingSession->session_id]);
        }

        if ($existingSession && !$existingSession->is_locked) {
            $sessionId = $existingSession->session_id;
            $strikes = $existingSession->strikes;
        } else {
            $sessionId = Str::random(40);
            // STRIKES HARUS 0 UNTUK SESI BARU
            $strikes = 0;

            DB::table('exam_sessions')->insert([
                'session_id' => $sessionId,
                'user_id' => Auth::id(),
                'exam_code' => $code,
                'strikes' => 0,  // PASTIKAN 0
                'is_locked' => false,
                'started_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tentukan URL yang akan digunakan
        $iframeUrl = null;
        $iframeHtml = null;
        
        if ($exam->iframe_html) {
            preg_match('/src="([^"]+)"/', $exam->iframe_html, $matches);
            $iframeUrl = isset($matches[1]) ? $matches[1] : null;
            $iframeHtml = $exam->iframe_html;
        } else {
            $iframeUrl = $exam->iframe_url;
        }

        session([
            'exam_session' => [
                'session_id' => $sessionId,
                'exam_code' => $code,
                'exam_title' => $exam->title,
                'iframe_url' => $iframeUrl,
                'iframe_html' => $iframeHtml,
                'strikes' => $strikes,  // PASTIKAN 0 UNTUK SESI BARU
                'max_strikes' => $exam->max_strikes,
                'duration' => $exam->duration_minutes,
                'started_at' => now(),
                'is_active' => true
            ]
        ]);

        $remainingTime = $exam->duration_minutes * 60;
        $maxStrikes = $exam->max_strikes;

        return view('student.exam', compact('exam', 'remainingTime', 'maxStrikes', 'iframeHtml', 'iframeUrl'));
    }


public function requestActivation(Request $request)
{
    $sessionId = $request->session_id;
    $session = DB::table('exam_sessions')->where('session_id', $sessionId)->first();

    if (!$session || $session->user_id != Auth::id()) {
        return response()->json(['error' => 'Invalid session'], 403);
    }

    // Cek apakah sudah ada kode yang belum dipakai
    $existing = DB::table('activation_codes')
        ->where('session_id', $sessionId)
        ->where('is_used', false)
        ->where('expires_at', '>', now())
        ->first();

    if ($existing) {
        return response()->json([
            'success' => true,
            'message' => 'Kode aktivasi: ' . $existing->code
        ]);
    }

    // Generate kode 5 karakter
    $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $code = '';
    for ($i = 0; $i < 5; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    // Pastikan unik
    while (DB::table('activation_codes')->where('code', $code)->exists()) {
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
    }
    
    DB::table('activation_codes')->insert([
        'code' => $code,
        'user_id' => Auth::id(),
        'session_id' => $sessionId,
        'is_used' => false,
        'expires_at' => now()->addHours(24),
        'created_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Kode aktivasi: ' . $code
    ]);
}

    public function reportCheating(Request $request)
    {
        $session = session('exam_session');

        if (!$session || !$session['is_active']) {
            return response()->json(['status' => 'invalid'], 403);
        }

        $violation = $request->input('violation_type');
        
        // JANGAN RECORD HEARTBEAT DAN DUPLIKAT
        if ($violation === 'heartbeat') {
            return response()->json(['status' => 'ok']);
        }
        
        // CEK COOLDOWN - JANGAN RECORD JIKA TERLALU CEPAT (10 DETIK PERTAMA)
        static $lastViolationTime = null;
        $now = microtime(true);
        
        if ($lastViolationTime && ($now - $lastViolationTime) < 2) {
            // Jika kurang dari 2 detik, abaikan (duplikat event)
            return response()->json(['status' => 'ignored_duplicate']);
        }
        $lastViolationTime = $now;
        
        // CEK APAKAH UDAH LOCKED
        if ($session['strikes'] >= $session['max_strikes']) {
            return response()->json(['status' => 'already_locked']);
        }

        $currentStrike = $session['strikes'] + 1;
        
        DB::table('cheat_logs')->insert([
            'user_id' => Auth::id(),
            'exam_code' => $session['exam_code'],
            'session_id' => $session['session_id'],
            'violation_type' => $violation,
            'strike_number' => $currentStrike,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        $isLocked = $currentStrike >= $session['max_strikes'];

        DB::table('exam_sessions')
            ->where('session_id', $session['session_id'])
            ->update([
                'strikes' => $currentStrike,
                'is_locked' => $isLocked,
                'updated_at' => now()
            ]);

        session(['exam_session.strikes' => $currentStrike]);
        
        if ($isLocked) {
            session(['exam_session.is_active' => false]);
        }

        return response()->json([
            'status' => 'recorded',
            'current_strike' => $currentStrike,
            'max_strikes' => $session['max_strikes'],
            'is_locked' => $isLocked
        ]);
    }

    public function submit(Request $request)
    {
        $session = session('exam_session');
        
        if ($session) {
            DB::table('exam_sessions')
                ->where('session_id', $session['session_id'])
                ->update([
                    'completed_at' => now(),
                    'updated_at' => now()
                ]);
        }

        session()->forget('exam_session');
        
        return redirect()->route('student.enter-code')->with('success', 'Ujian telah diselesaikan!');
    }

    public function timeout()
    {
        session()->forget('exam_session');
        return view('student.timeout');
    }
}