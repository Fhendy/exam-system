@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<style>
    /* Stats Grid Compact */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }
    
    .stat-info h3 {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }
    
    .stat-info p {
        font-size: 11px;
        color: #64748b;
        margin: 0;
    }
    
    .stat-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #0ea5e9, #3b82f6);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }
    
    /* Recent Tables */
    .recent-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }
    
    .card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    
    .card-header {
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
        font-size: 14px;
        background: #f8fafc;
    }
    
    .card-body {
        padding: 0;
    }
    
    .table {
        width: 100%;
        margin-bottom: 0;
    }
    
    .table th, .table td {
        padding: 10px 12px;
        font-size: 12px;
        vertical-align: middle;
    }
    
    .table th {
        background: #f8fafc;
        font-weight: 600;
        color: #64748b;
        font-size: 11px;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    .student-name {
        font-weight: 600;
        color: #0f172a;
    }
    
    .badge-sm {
        padding: 3px 8px;
        font-size: 10px;
        border-radius: 30px;
    }
    
    .btn-sm-custom {
        padding: 4px 10px;
        font-size: 10px;
        border-radius: 8px;
    }
    
    /* Activation Code */
    .activation-code {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        display: inline-block;
        padding: 5px 12px;
        border-radius: 30px;
        font-family: monospace;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 3px;
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .empty-state-small {
        text-align: center;
        padding: 30px;
        color: #94a3b8;
    }
    
    .empty-state-small i {
        font-size: 32px;
        margin-bottom: 8px;
        opacity: 0.5;
    }
    
    .empty-state-small p {
        font-size: 12px;
    }
    
    @media (max-width: 1000px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .recent-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .table, .table tbody, .table tr, .table td {
            display: block;
        }
        .table thead {
            display: none;
        }
        .table tr {
            margin-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 0;
        }
        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 12px;
            border: none;
        }
        .table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            width: 100px;
            font-size: 11px;
        }
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['total_students'] }}</h3>
            <p>Total Siswa</p>
        </div>
        <div class="stat-icon"><i class="fas fa-users"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['total_exams'] }}</h3>
            <p>Total Ujian</p>
        </div>
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['active_exams'] }}</h3>
            <p>Ujian Aktif</p>
        </div>
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['total_sessions'] }}</h3>
            <p>Sesi Ujian</p>
        </div>
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['active_sessions'] }}</h3>
            <p>Sesi Aktif</p>
        </div>
        <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['locked_sessions'] }}</h3>
            <p>Sesi Terkunci</p>
        </div>
        <div class="stat-icon"><i class="fas fa-lock"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['total_cheats'] }}</h3>
            <p>Pelanggaran</p>
        </div>
        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>{{ $stats['pending_activations'] }}</h3>
            <p>Pending Aktivasi</p>
        </div>
        <div class="stat-icon"><i class="fas fa-key"></i></div>
    </div>
</div>

<!-- Recent Data -->
<div class="recent-grid">
    <!-- Sesi Ujian Terbaru -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-clock" style="margin-right: 8px; color: #0ea5e9;"></i>
            Sesi Ujian Terbaru
        </div>
        <div class="card-body">
            @if($recentSessions->count() > 0)
            <table class="table">
                <thead>
                    <tr><th>Siswa</th><th>Kode</th><th>Strike</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($recentSessions as $session)
                    <tr>
                        <td data-label="Siswa">
                            <span class="student-name">{{ $session->student_name }}</span>
                            <br><small style="font-size: 9px;">{{ $session->nis ?? '-' }}</small>
                        </td>
                        <td data-label="Kode">
                            <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 5px; font-size: 10px;">{{ $session->exam_code }}</code>
                        </td>
                        <td data-label="Strike">
                            <span class="badge {{ $session->strikes >= 3 ? 'badge-danger' : ($session->strikes > 0 ? 'badge-warning' : 'badge-success') }}" style="padding: 2px 8px; font-size: 10px;">
                                {{ $session->strikes }}/3
                            </span>
                        </td>
                        <td data-label="Status">
                            @if($session->completed_at)
                                <span class="badge badge-success badge-sm">Selesai</span>
                            @elseif($session->is_locked)
                                <span class="badge badge-danger badge-sm">Terkunci</span>
                            @else
                                <span class="badge badge-info badge-sm">Aktif</span>
                            @endif
                        </td>
                        <td data-label="Aksi">
                            @if($session->is_locked && !$session->completed_at)
                                <button class="btn btn-primary btn-sm-custom" onclick="generateCode('{{ $session->session_id }}')" title="Generate Kode">
                                    <i class="fas fa-key"></i>
                                </button>
                            @else
                                <span class="text-muted" style="font-size: 10px;">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state-small">
                <i class="fas fa-clock"></i>
                <p>Belum ada sesi ujian</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Pelanggaran Terbaru -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-exclamation-triangle" style="margin-right: 8px; color: #ef4444;"></i>
            Pelanggaran Terbaru
        </div>
        <div class="card-body">
            @if($recentCheats->count() > 0)
            <table class="table">
                <thead>
                    <tr><th>Siswa</th><th>Pelanggaran</th><th>Strike</th><th>Waktu</th></tr>
                </thead>
                <tbody>
                    @foreach($recentCheats as $cheat)
                    @php
                        $violationDisplay = str_replace('_', ' ', ucfirst($cheat->violation_type));
                    @endphp
                    <tr>
                        <td data-label="Siswa">
                            <span class="student-name">{{ $cheat->student_name }}</span>
                            <br><small style="font-size: 9px;">{{ $cheat->nis ?? '-' }}</small>
                        </td>
                        <td data-label="Pelanggaran">
                            <span class="badge badge-danger" style="background: #fee2e2; color: #991b1b; padding: 2px 8px; font-size: 10px;">
                                {{ $violationDisplay }}
                            </span>
                        </td>
                        <td data-label="Strike">
                            <span class="badge {{ $cheat->strike_number >= 3 ? 'badge-danger' : 'badge-warning' }}" style="padding: 2px 8px; font-size: 10px;">
                                {{ $cheat->strike_number }}/3
                            </span>
                        </td>
                        <td data-label="Waktu">
                            <small>{{ \Carbon\Carbon::parse($cheat->created_at)->diffForHumans() }}</small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state-small">
                <i class="fas fa-shield-alt"></i>
                <p>Belum ada pelanggaran</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Kode Aktivasi Pending -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-key" style="margin-right: 8px; color: #f59e0b;"></i>
        Kode Aktivasi Pending
    </div>
    <div class="card-body">
        @if($activeCodes->count() > 0)
        <table class="table">
            <thead>
                <tr><th>Siswa</th><th>Kode Aktivasi</th><th>Expired</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($activeCodes as $code)
                <tr>
                    <td data-label="Siswa">
                        <span class="student-name">{{ $code->student_name }}</span>
                        <br><small style="font-size: 9px;">{{ $code->nis ?? '-' }}</small>
                    </td>
                    <td data-label="Kode Aktivasi">
                        <span class="activation-code">{{ $code->code }}</span>
                    </td>
                    <td data-label="Expired">
                        <small>{{ \Carbon\Carbon::parse($code->expires_at)->diffForHumans() }}</small>
                    </td>
                    <td data-label="Aksi">
                        <button class="btn btn-success btn-sm-custom" onclick="copyCode('{{ $code->code }}')" title="Salin Kode">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state-small" style="padding: 30px;">
            <i class="fas fa-key"></i>
            <p>Tidak ada kode aktivasi pending</p>
        </div>
        @endif
    </div>
</div>

<script>
function generateCode(sessionId) {
    if (!confirm('Generate kode aktivasi untuk sesi ini?')) return;
    
    fetch(`/admin/activation/generate/${sessionId}`)
        .then(res => res.json())
        .then(data => {
            if (data.code) {
                alert('✅ Kode Aktivasi: ' + data.code + '\n\nKode 5 karakter, berikan ke siswa.');
                location.reload();
            } else {
                alert('❌ Gagal generate kode');
            }
        })
        .catch(err => alert('❌ Terjadi kesalahan'));
}

function copyCode(code) {
    navigator.clipboard.writeText(code);
    alert('✅ Kode aktivasi 5 karakter: ' + code + '\n\nKode sudah disalin ke clipboard!');
}
</script>
@endsection