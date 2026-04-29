<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $exam->title }} - Ujian Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 50%, #7dd3fc 100%);
            overflow: hidden;
            height: 100vh;
            position: fixed;
            width: 100%;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 0 24px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f0f9ff;
            padding: 5px 16px 5px 12px;
            border-radius: 50px;
            border: 1px solid rgba(14, 165, 233, 0.2);
        }

        .student-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 15px;
            color: white;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
        }

        .student-details {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .student-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 14px;
        }

        .student-nis {
            font-size: 10px;
            color: #64748b;
        }

        .exam-badge {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            color: white;
            margin-left: 8px;
            box-shadow: 0 2px 6px rgba(14, 165, 233, 0.25);
        }

        .right-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .timer-wrapper {
            text-align: center;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            padding: 5px 20px;
            border-radius: 40px;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
            min-width: 110px;
        }

        .timer-label {
            font-size: 9px;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
        }

        .timer {
            font-size: 22px;
            font-weight: 700;
            font-family: 'Inter', monospace;
            color: white;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }

        .strike-container {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            padding: 5px 14px;
            border-radius: 40px;
            border: 1px solid #e2e8f0;
        }

        .strike-label {
            font-size: 10px;
            color: #64748b;
            font-weight: 600;
        }

        .strike-dots {
            display: flex;
            gap: 6px;
        }

        .strike-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
            transition: all 0.2s ease;
        }

        .strike-dot.active {
            background: linear-gradient(135deg, #f43f5e, #e11d48);
            color: white;
            box-shadow: 0 2px 8px rgba(244, 63, 94, 0.3);
        }

        .exit-btn {
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            backdrop-filter: blur(4px);
        }

        .exit-btn:hover {
            background: #dc2626;
            transform: scale(1.02);
        }

        .iframe-container {
            margin-top: 70px;
            height: calc(100vh - 70px);
            width: 100%;
            background: #ffffff;
            position: relative;
        }

        .iframe-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }

        .warning-modal, .lock-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 20px;
        }

        .warning-card {
            background: white;
            padding: 32px 24px;
            border-radius: 32px;
            text-align: center;
            max-width: 380px;
            width: 100%;
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.25);
            animation: shake 0.4s ease;
        }

        .warning-card h2 {
            font-size: 28px;
            margin: 12px 0 8px;
            color: #f43f5e;
        }

        .strike-number {
            font-size: 40px;
            font-weight: 800;
            color: #f43f5e;
            margin: 12px 0;
            font-family: monospace;
        }

        .lock-card {
            text-align: center;
            padding: 28px 20px;
            background: white;
            border-radius: 32px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .lock-icon {
            font-size: 52px;
        }

        .lock-card h1 {
            font-size: 26px;
            margin: 10px 0;
            color: #0f172a;
        }

        .activation-input {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 24px 0;
        }

        .activation-input input {
            width: 100%;
            padding: 12px;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            letter-spacing: 6px;
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            border-radius: 60px;
            font-family: monospace;
        }

        .activation-input input:focus {
            outline: none;
            border-color: #0ea5e9;
            background: white;
        }

        .activation-input button {
            width: 100%;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            border: none;
            padding: 12px 16px;
            border-radius: 60px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: 0.2s;
            font-size: 14px;
        }

        .request-btn {
            width: 100%;
            background: #f1f5f9;
            color: #0f172a;
            border: 1px solid #e2e8f0;
            padding: 12px 16px;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 8px;
            font-size: 14px;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
        }

        #exitForm {
            display: none;
        }

        .swal2-container {
            pointer-events: auto !important;
            z-index: 10000 !important;
        }

        @media (max-width: 700px) {
            .header { padding: 0 16px; height: 60px; }
            .iframe-container { margin-top: 60px; height: calc(100vh - 60px); }
            .student-info { padding: 4px 12px; gap: 8px; }
            .student-avatar { width: 30px; height: 30px; font-size: 13px; }
            .student-name { font-size: 12px; }
            .student-nis { font-size: 9px; }
            .exam-badge { display: none; }
            .timer-wrapper { padding: 3px 14px; min-width: 90px; }
            .timer { font-size: 18px; }
            .strike-container { padding: 4px 10px; }
            .strike-dot { width: 24px; height: 24px; font-size: 10px; }
            .exit-btn { padding: 4px 10px; font-size: 10px; }
        }
        
        * {
            overscroll-behavior: none;
        }
        
        /* Mencegah resize window */
        body {
            resize: none;
            overflow: hidden;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="student-info">
        <div class="student-avatar" id="studentAvatar"></div>
        <div class="student-details">
            <span class="student-name" id="studentName">Memuat...</span>
            <span class="student-nis" id="studentNis"></span>
        </div>
        <div class="exam-badge" id="examCodeBadge">{{ $exam->code }}</div>
    </div>

    <div class="timer-wrapper">
        <div class="timer-label">SISA WAKTU</div>
        <div class="timer" id="timer">00:00</div>
    </div>

    <div class="right-section">
        <div class="strike-container">
            <span class="strike-label">PELANGGARAN</span>
            <div class="strike-dots" id="strikeIndicator">
                <div class="strike-dot" id="strike1">⚠️</div>
                <div class="strike-dot" id="strike2">⚠️</div>
                <div class="strike-dot" id="strike3">⚠️</div>
            </div>
        </div>
        <button class="exit-btn" id="exitButton" title="Keluar dari ujian">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
    </div>
</div>

<div class="iframe-container" id="iframeContainer">
    @if($iframeHtml)
        {!! $iframeHtml !!}
    @else
        <iframe id="examFrame" src="{{ $iframeUrl }}" allow="fullscreen" sandbox="allow-same-origin allow-scripts allow-popups allow-forms allow-modals allow-downloads"></iframe>
    @endif
</div>

<form id="exitForm" action="{{ route('student.submit') }}" method="POST">
    @csrf
</form>

<div class="warning-modal" id="warningModal">
    <div class="warning-card">
        <div class="warning-icon">⚠️</div>
        <h2>Peringatan!</h2>
        <p>Anda terdeteksi melakukan tindakan mencurigakan:</p>
        <p style="color: #f43f5e; margin: 12px 0; font-weight: bold;" id="violationText">-</p>
        <div class="strike-number" id="strikeCount">0 / {{ $maxStrikes }}</div>
        <p style="font-size: 13px; color: #64748b;">Mencapai {{ $maxStrikes }}x → ujian terkunci</p>
    </div>
</div>

<div class="lock-modal" id="lockModal">
    <div class="lock-card">
        <div class="lock-icon">🔒</div>
        <h1>Ujian Terkunci</h1>
        <p>Anda telah melakukan <strong>{{ $maxStrikes }} pelanggaran</strong>.</p>
        <p style="color: #0ea5e9; margin: 8px 0 16px 0; font-weight: 500;">Hubungi admin/guru untuk meminta kode aktivasi</p>
        
        <div class="activation-input">
            <input type="text" id="activationCode" placeholder="Kode (5 digit)" maxlength="5" style="text-transform: uppercase; text-align: center;" autocomplete="off">
            <button onclick="activateExam()">Aktivasi</button>
        </div>
        
        <button class="request-btn" onclick="requestActivation()">📨 Minta Kode ke Admin</button>
        
        <form action="{{ route('student.submit') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 12px; width: 100%; padding: 8px;">← Kembali ke Dashboard</button>
        </form>
    </div>
</div>

<script>
    (function() {
        // ==================== CEK SPLIT SCREEN / LAYAR BELAH ====================
        let lastWidth = window.innerWidth;
        let lastHeight = window.innerHeight;
        let splitScreenWarningCount = 0;
        
        function checkSplitScreen() {
            const screenWidth = window.screen.width;
            const screenHeight = window.screen.height;
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            
            // Deteksi split screen (jika lebar window kurang dari 80% lebar layar)
            if (windowWidth < screenWidth * 0.8 || windowHeight < screenHeight * 0.85) {
                if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit) {
                    splitScreenWarningCount++;
                    if (splitScreenWarningCount > 2) {
                        reportCheating('split_screen');
                    } else {
                        // Tampilkan peringatan tapi jangan langsung report
                        Swal.fire({
                            icon: 'warning',
                            title: '⚠️ Peringatan!',
                            text: 'Jangan menggunakan split screen / layar belah saat ujian!',
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            } else {
                splitScreenWarningCount = 0;
            }
            
            // Deteksi resize window (mencoba memperkecil)
            if (Math.abs(windowWidth - lastWidth) > 50 || Math.abs(windowHeight - lastHeight) > 50) {
                if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit) {
                    reportCheating('window_resize');
                }
            }
            
            lastWidth = windowWidth;
            lastHeight = windowHeight;
        }
        
        // ==================== CEK POP UP APLIKASI / MULTITASKING ====================
        let wasHidden = false;
        let hiddenTime = 0;
        
        document.addEventListener('visibilitychange', function() {
            if (!antiCheatActive || isLocked || strikes >= maxStrikes || isManualExit) return;
            
            if (document.hidden) {
                wasHidden = true;
                hiddenTime = Date.now();
                reportCheating('app_switch_detected');
                
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ Peringatan!',
                    text: 'Terdeteksi membuka aplikasi lain! Pelanggaran dicatat.',
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
        
        // ==================== CEK POP UP LAINNYA (melalui blur) ====================
        let blurCount = 0;
        let lastBlurTime = 0;
        
        window.addEventListener('blur', function() {
            if (!antiCheatActive || isLocked || strikes >= maxStrikes || isManualExit) return;
            
            const now = Date.now();
            if (now - lastBlurTime > 500) { // Hindari duplikat dalam 500ms
                blurCount++;
                lastBlurTime = now;
                
                if (blurCount > 2) {
                    reportCheating('popup_app_detected');
                }
                
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ Peringatan!',
                    text: 'Terdeteksi membuka aplikasi/popup lain!',
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
        
        // Reset counter setelah kembali
        window.addEventListener('focus', function() {
            blurCount = 0;
        });
        
        // ==================== CEK UKURAN LAYAR SECARA BERKALA ====================
        setInterval(() => {
            if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit) {
                checkSplitScreen();
            }
        }, 3000);
        
        // ==================== FLAG UNTUK KELUAR MANUAL ====================
        let isManualExit = false;
        
        // ==================== AMBIL DATA SESSION ====================
        let strikes = parseInt("{{ session('exam_session.strikes', 0) }}") || 0;
        let maxStrikes = parseInt("{{ $maxStrikes ?? 3 }}") || 3;
        let remainingSeconds = parseInt("{{ $remainingTime ?? 5400 }}") || 5400;
        let sessionId = "{{ session('exam_session.session_id') }}";
        let isLocked = false;
        let antiCheatActive = false;
        let lastReportTime = 0;

        let studentName = "{{ Auth::user()->name ?? 'Siswa' }}";
        let studentNis = "{{ Auth::user()->nis ?? '-' }}";
        let studentInitial = studentName.charAt(0).toUpperCase();

        const timerEl = document.getElementById('timer');
        const strikeIndicators = {
            1: document.getElementById('strike1'),
            2: document.getElementById('strike2'),
            3: document.getElementById('strike3')
        };
        const warningModal = document.getElementById('warningModal');
        const lockModal = document.getElementById('lockModal');

        if (document.getElementById('studentName')) document.getElementById('studentName').innerText = studentName;
        if (document.getElementById('studentNis')) document.getElementById('studentNis').innerText = 'NIS: ' + studentNis;
        if (document.getElementById('studentAvatar')) document.getElementById('studentAvatar').innerText = studentInitial;
        if (document.getElementById('examCodeBadge')) document.getElementById('examCodeBadge').innerText = '📋 ' + "{{ $exam->code }}";

        // Timer logic
        function updateTimerDisplay() {
            if (remainingSeconds <= 0) {
                window.location.href = '{{ route("student.timeout") }}';
                return;
            }
            let mins = Math.floor(remainingSeconds / 60);
            let secs = remainingSeconds % 60;
            timerEl.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            remainingSeconds--;
        }
        updateTimerDisplay();
        let timerInterval = setInterval(updateTimerDisplay, 1000);

        function updateStrikeUI() {
            for (let i = 1; i <= 3; i++) {
                let el = strikeIndicators[i];
                if (el) {
                    if (i <= strikes) el.classList.add('active');
                    else el.classList.remove('active');
                }
            }
        }

        function showWarning(violationType, currentStrike) {
            const violationMap = {
                'tab_switch': 'Berpindah ke tab/window lain',
                'tab_minimize': 'Meminimize halaman',
                'right_click': 'Klik kanan',
                'devtools': 'Membuka Developer Tools',
                'copy_attempt': 'Mencoba menyalin teks',
                'paste_attempt': 'Mencoba menempel teks',
                'page_refresh': 'Mencoba me-refresh halaman',
                'screenshot': 'Mencoba screenshot',
                'inactivity': 'Tidak aktif terlalu lama',
                'back_button': 'Menekan tombol kembali',
                'split_screen': 'Menggunakan split screen / layar belah',
                'window_resize': 'Mengubah ukuran jendela',
                'app_switch_detected': 'Membuka aplikasi lain',
                'popup_app_detected': 'Membuka popup aplikasi'
            };
            let text = violationMap[violationType] || violationType;
            document.getElementById('violationText').innerText = text;
            document.getElementById('strikeCount').innerHTML = `${currentStrike} / ${maxStrikes}`;
            warningModal.style.display = 'flex';
            
            setTimeout(() => {
                warningModal.style.display = 'none';
            }, 3000);
        }

        async function reportCheating(violationType) {
            if (!antiCheatActive || isLocked || strikes >= maxStrikes) return;
            if (isManualExit) return;

            const now = Date.now();
            if (now - lastReportTime < 800) return;
            lastReportTime = now;

            try {
                const response = await fetch('{{ route("student.report-cheating") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ violation_type: violationType })
                });
                const data = await response.json();
                if (data.current_strike && data.current_strike > strikes) {
                    strikes = data.current_strike;
                    updateStrikeUI();
                    if (!isManualExit && violationType !== 'manual_exit') {
                        showWarning(violationType, strikes);
                    }
                    if (data.is_locked) {
                        isLocked = true;
                        lockModal.style.display = 'flex';
                        if (document.getElementById('iframeContainer')) {
                            document.getElementById('iframeContainer').innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f0f9ff;"><p style="color:#475569;">🔒 Ujian terkunci. Hubungi admin.</p></div>';
                        }
                        clearInterval(timerInterval);
                    }
                }
            } catch (err) {
                console.warn(err);
            }
        }

        // ==================== KELUAR MANUAL ====================
        function exitExam() {
            isManualExit = true;
            antiCheatActive = false;
            
            fetch('{{ route("student.report-cheating") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ violation_type: 'manual_exit' })
            }).finally(() => {
                document.getElementById('exitForm').submit();
            });
        }
        
        document.getElementById('exitButton').addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            
            Swal.fire({
                title: '⚠️ Keluar dari Ujian?',
                html: `
                    <div style="text-align: left;">
                        <p>Apakah Anda yakin ingin keluar dari ujian?</p>
                        <ul style="margin-left: 20px; color: #dc2626; margin-top: 10px;">
                            <li>Progres ujian tidak akan tersimpan</li>
                            <li>Anda tidak dapat melanjutkan ujian ini lagi</li>
                            <li>Nilai akan tetap kosong</li>
                        </ul>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal, Lanjutkan',
                reverseButtons: true,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Keluar...',
                        text: 'Mengakhiri sesi ujian',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 1000,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    
                    setTimeout(() => {
                        exitExam();
                    }, 1000);
                }
            });
        });

        // ==================== REQUEST ACTIVATION ====================
        window.requestActivation = async function() {
            Swal.fire({
                title: 'Minta Kode Aktivasi',
                text: 'Apakah Anda yakin ingin meminta kode aktivasi ke admin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0ea5e9',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengirim...',
                        text: 'Mohon tunggu sebentar',
                        icon: 'info',
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    
                    try {
                        const res = await fetch('{{ route("student.request-activation") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ session_id: sessionId })
                        });
                        const data = await res.json();
                        
                        if (data.success) {
                            Swal.fire({
                                title: '✅ Berhasil!',
                                text: 'Permintaan kode aktivasi telah dikirim ke admin.',
                                icon: 'success',
                                confirmButtonColor: '#0ea5e9'
                            });
                        } else {
                            Swal.fire({
                                title: '❌ Gagal',
                                text: data.message || 'Gagal mengirim permintaan',
                                icon: 'error',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    } catch(e) {
                        Swal.fire({
                            title: '❌ Error',
                            text: 'Gagal menghubungi server',
                            icon: 'error',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                }
            });
        };

        // ==================== ACTIVATE EXAM ====================
        window.activateExam = async function() {
            let code = document.getElementById('activationCode').value.trim().toUpperCase();
            if (code.length !== 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kode tidak valid',
                    text: 'Kode aktivasi harus 5 karakter!',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }
            
            Swal.fire({
                title: 'Verifikasi...',
                text: 'Sedang memverifikasi kode',
                icon: 'info',
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            try {
                const res = await fetch('{{ route("admin.use-activation") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ code: code })
                });
                const data = await res.json();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '✅ Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#0ea5e9',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Gagal',
                        text: data.message || 'Kode tidak valid',
                        confirmButtonColor: '#dc2626'
                    });
                }
            } catch(e) { 
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal aktivasi',
                    confirmButtonColor: '#dc2626'
                });
            }
        };

        // ==================== ANTI CHEAT DELAY ====================
        setTimeout(() => {
            antiCheatActive = true;
        }, 3000);

        // ==================== EVENT LISTENER ANTICURANG ====================
        document.addEventListener('keydown', function(e) {
            if (!antiCheatActive || isManualExit) return;
            const key = e.key;
            if (key === 'F12' || (e.ctrlKey && e.shiftKey && key === 'I')) {
                e.preventDefault(); reportCheating('devtools');
            }
            if (e.ctrlKey && (key === 'c' || key === 'C')) { e.preventDefault(); reportCheating('copy_attempt'); }
            if (e.ctrlKey && (key === 'v' || key === 'V')) { e.preventDefault(); reportCheating('paste_attempt'); }
            if (e.ctrlKey && key === 'r') { e.preventDefault(); reportCheating('page_refresh'); }
            if (key === 'PrintScreen') { e.preventDefault(); reportCheating('screenshot'); }
        });
        
        window.addEventListener('blur', () => { if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit) reportCheating('tab_switch'); });
        document.addEventListener('contextmenu', (e) => { e.preventDefault(); if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit) reportCheating('right_click'); });
        document.addEventListener('copy', (e) => { e.preventDefault(); if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit) reportCheating('copy_attempt'); });
        document.addEventListener('paste', (e) => { e.preventDefault(); if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit) reportCheating('paste_attempt'); });
        document.addEventListener('selectstart', (e) => e.preventDefault());

        setInterval(() => {
            if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit) {
                fetch('{{ route("student.report-cheating") }}', {
                    method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ violation_type: 'heartbeat' })
                }).catch(e=>null);
            }
        }, 30000);

        let lastActive = Date.now();
        setInterval(() => {
            if (antiCheatActive && !isLocked && strikes < maxStrikes && !isManualExit && (Date.now() - lastActive) > 70000) {
                reportCheating('inactivity');
                lastActive = Date.now();
            }
        }, 15000);
        ['mousemove', 'keydown', 'touchstart', 'click'].forEach(ev => document.addEventListener(ev, () => lastActive = Date.now()));

        history.pushState(null, null, location.href);
        window.addEventListener('popstate', function(event) {
            if (!isManualExit && !isLocked && strikes < maxStrikes && antiCheatActive) {
                reportCheating('back_button');
                history.pushState(null, null, location.href);
            } else {
                history.pushState(null, null, location.href);
            }
        });

        updateStrikeUI();
        if (strikes >= maxStrikes || "{{ session('exam_session.is_active') }}" === "false") {
            isLocked = true;
            lockModal.style.display = 'flex';
            if (document.getElementById('iframeContainer')) {
                document.getElementById('iframeContainer').innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f0f9ff;"><p style="color:#475569;">🔒 Ujian terkunci. Hubungi admin.</p></div>';
            }
            clearInterval(timerInterval);
        }
    })();
</script>
</body>
</html>