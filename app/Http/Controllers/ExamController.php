<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    public function show($code)
    {
        $exam = DB::table('exams')
            ->where('code', $code)
            ->where('is_active', true)
            ->first();
        
        if (!$exam) {
            return redirect('/')->with('error', 'Kode ujian tidak valid atau ujian belum aktif!');
        }
        
        // Check time restrictions
        if ($exam->start_time && now()->lt($exam->start_time)) {
            return redirect('/')->with('error', 'Ujian belum dimulai!');
        }
        
        if ($exam->end_time && now()->gt($exam->end_time)) {
            return redirect('/')->with('error', 'Ujian sudah berakhir!');
        }
        
        $sessionId = Str::random(40);
        
        session([
            'exam_session' => [
                'session_id' => $sessionId,
                'exam_code' => $exam->code,
                'exam_title' => $exam->title,
                'iframe_url' => $exam->iframe_url,
                'student_name' => 'Student_' . rand(1000, 9999),
                'started_at' => now(),
                'strikes' => 0,
                'max_strikes' => $exam->max_strikes,
                'duration' => $exam->duration_minutes,
                'is_active' => true
            ]
        ]);
        
        DB::table('exam_sessions')->insert([
            'session_id' => $sessionId,
            'exam_code' => $exam->code,
            'student_name' => 'Student_' . rand(1000, 9999),
            'strikes' => 0,
            'started_at' => now(),
            'is_active' => true,
            'is_locked' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $remainingTime = $exam->duration_minutes * 60;
        $maxStrikes = $exam->max_strikes;
        
        return view('exam.iframe', compact('exam', 'remainingTime', 'maxStrikes'));
    }
    
    public function reportCheating(Request $request)
    {
        $session = session('exam_session');
        
        if (!$session || !$session['is_active']) {
            return response()->json(['status' => 'invalid_session'], 403);
        }
        
        $violation = $request->input('violation_type');
        
        // Skip heartbeat from incrementing strikes
        if ($violation === 'heartbeat') {
            return response()->json(['status' => 'ok']);
        }
        
        $currentStrike = $session['strikes'] + 1;
        $session['strikes'] = $currentStrike;
        
        if ($currentStrike >= $session['max_strikes']) {
            $session['is_active'] = false;
        }
        
        session(['exam_session' => $session]);
        
        DB::table('cheat_logs')->insert([
            'session_id' => $session['session_id'],
            'exam_code' => $session['exam_code'],
            'student_name' => $session['student_name'],
            'violation_type' => $violation,
            'current_strike' => $currentStrike,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('exam_sessions')
            ->where('session_id', $session['session_id'])
            ->update([
                'strikes' => $currentStrike,
                'is_active' => $currentStrike < $session['max_strikes'],
                'is_locked' => $currentStrike >= $session['max_strikes'],
                'updated_at' => now()
            ]);
        
        return response()->json([
            'status' => 'recorded',
            'current_strike' => $currentStrike,
            'max_strikes' => $session['max_strikes'],
            'is_locked' => $currentStrike >= $session['max_strikes']
        ]);
    }
    
    public function submit(Request $request)
    {
        $session = session('exam_session');
        
        if ($session) {
            DB::table('exam_sessions')
                ->where('session_id', $session['session_id'])
                ->update([
                    'is_active' => false,
                    'completed_at' => now(),
                    'updated_at' => now()
                ]);
        }
        
        session()->forget('exam_session');
        
        return redirect('/')->with('success', 'Ujian telah diselesaikan!');
    }
    
    public function locked()
    {
        return view('exam.locked');
    }
    
    public function timeout()
    {
        session()->forget('exam_session');
        return view('exam.timeout');
    }
}