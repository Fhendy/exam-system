<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ExamSession;
use App\Models\CheatLog;

class ExamAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $session = session('exam_session');
        
        if (!$session || !$session['active']) {
            return redirect()->route('exam.locked')->with('error', 'Sesi ujian tidak valid!');
        }

        // Cek apakah sudah melebihi durasi
        $startTime = $session['started_at'];
        $duration = $session['duration'];
        $endTime = $startTime->addMinutes($duration);
        
        if (now()->greaterThan($endTime)) {
            return redirect()->route('exam.timeout')->with('error', 'Waktu ujian telah habis!');
        }

        // Cek strike
        if ($session['strikes'] >= 3) {
            return redirect()->route('exam.locked')->with('error', 'Ujian terkunci karena pelanggaran!');
        }

        return $next($request);
    }
}