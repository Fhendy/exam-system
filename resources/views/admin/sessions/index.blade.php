@extends('layouts.admin')

@section('title', 'Sesi Ujian')
@section('page-title', 'Monitoring Sesi Ujian')

@section('content')
<style>
    .stats-row {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .stat-card-simple {
        background: white;
        border-radius: 14px;
        padding: 10px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #e2e8f0;
    }
    
    .stat-card-simple i {
        font-size: 20px;
        color: #0ea5e9;
    }
    
    .stat-card-simple span {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
    }
    
    .stat-card-simple small {
        font-size: 11px;
        color: #64748b;
        margin-left: 4px;
    }
    
    .table th, .table td {
        padding: 10px 12px;
        font-size: 12px;
        vertical-align: middle;
    }
    
    .session-id {
        font-family: monospace;
        font-size: 11px;
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 6px;
        display: inline-block;
    }
    
    .student-name {
        font-weight: 600;
        color: #0f172a;
    }
    
    .badge-sm {
        padding: 2px 8px;
        font-size: 10px;
        border-radius: 20px;
    }
    
    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    
    .btn-icon-sm {
        padding: 5px 10px;
        font-size: 11px;
        border-radius: 8px;
    }
    
    .pagination {
        margin-top: 20px;
        justify-content: center;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px;
    }
    
    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
    }
    
    @media (max-width: 768px) {
        .table, .table tbody, .table tr, .table td {
            display: block;
        }
        .table thead {
            display: none;
        }
        .table tr {
            margin-bottom: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px;
        }
        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border: none;
        }
        .table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            width: 100px;
            font-size: 11px;
        }
        .action-buttons {
            justify-content: flex-end;
        }
        .stats-row {
            justify-content: center;
        }
    }
</style>

<!-- Statistik Ringkas -->
<div class="stats-row">
    <div class="stat-card-simple">
        <i class="fas fa-play-circle"></i>
        <span>{{ $sessions->filter(function($s) { return !$s->completed_at && !$s->is_locked; })->count() }} <small>Aktif</small></span>
    </div>
    <div class="stat-card-simple">
        <i class="fas fa-lock"></i>
        <span>{{ $sessions->filter(function($s) { return $s->is_locked; })->count() }} <small>Terkunci</small></span>
    </div>
    <div class="stat-card-simple">
        <i class="fas fa-check-circle"></i>
        <span>{{ $sessions->filter(function($s) { return $s->completed_at; })->count() }} <small>Selesai</small></span>
    </div>
    <div class="stat-card-simple">
        <i class="fas fa-chart-line"></i>
        <span>{{ $sessions->total() }} <small>Total Sesi</small></span>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="table" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th>Sesi ID</th>
                        <th>Siswa / NIS</th>
                        <th>Kode Ujian</th>
                        <th>Waktu Mulai</th>
                        <th>Strike</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                    @php
                        // Tentukan status berdasarkan data yang ada
                        if($session->completed_at) {
                            $statusText = 'Selesai';
                            $statusClass = 'badge-success';
                            $statusIcon = 'fa-check-circle';
                        } elseif($session->is_locked) {
                            $statusText = 'Terkunci';
                            $statusClass = 'badge-danger';
                            $statusIcon = 'fa-lock';
                        } else {
                            $statusText = 'Aktif';
                            $statusClass = 'badge-info';
                            $statusIcon = 'fa-play';
                        }
                    @endphp
                    <tr>
                        <td data-label="Sesi ID">
                            <span class="session-id">{{ substr($session->session_id, 0, 16) }}...</span>
                            <br><small style="color:#94a3b8;">{{ substr($session->session_id, -8) }}</small>
                        </td>
                        <td data-label="Siswa">
                            <div class="student-name">{{ $session->student_name }}</div>
                            <small style="color: #94a3b8;">NIS: {{ $session->nis ?? '-' }}</small>
                        </td>
                        <td data-label="Kode Ujian">
                            <span style="background: #f1f5f9; padding: 2px 8px; border-radius: 6px; font-family: monospace; font-size: 11px;">
                                {{ $session->exam_code }}
                            </span>
                        </td>
                        <td data-label="Waktu Mulai">
                            <i class="far fa-calendar-alt" style="color: #94a3b8; margin-right: 4px;"></i>
                            {{ \Carbon\Carbon::parse($session->started_at)->format('d/m/Y H:i') }}
                            <br><small>{{ \Carbon\Carbon::parse($session->started_at)->diffForHumans() }}</small>
                        </td>
                        <td data-label="Strike">
                            <span class="badge {{ $session->strikes >= 3 ? 'badge-danger' : ($session->strikes > 0 ? 'badge-warning' : 'badge-success') }}" style="font-size: 10px; padding: 4px 10px;">
                                <i class="fas {{ $session->strikes >= 3 ? 'fa-exclamation-triangle' : ($session->strikes > 0 ? 'fa-gavel' : 'fa-shield-alt') }}"></i>
                                {{ $session->strikes }}/3
                            </span>
                            @if($session->strikes > 0)
                                <br><small style="font-size: 9px;">{{ $session->strikes }} pelanggaran</small>
                            @endif
                        </td>
                        <td data-label="Status">
                            <span class="badge {{ $statusClass }}" style="padding: 4px 10px;">
                                <i class="fas {{ $statusIcon }}"></i> {{ $statusText }}
                            </span>
                            @if($session->completed_at)
                                <br><small>{{ \Carbon\Carbon::parse($session->completed_at)->format('d/m/Y H:i') }}</small>
                            @endif
                        </td>
                        <td data-label="Aksi">
                            @if($session->is_locked && !$session->completed_at)
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-icon-sm" onclick="generateCode('{{ $session->session_id }}')" title="Generate Kode Aktivasi (5 digit)">
                                        <i class="fas fa-key"></i> Kode
                                    </button>
                                    <form method="POST" action="{{ route('admin.sessions.unlock', $session->session_id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-icon-sm" title="Buka Paksa Sesi" onclick="return confirm('Buka paksa sesi ini? Siswa akan bisa melanjutkan ujian.')">
                                            <i class="fas fa-unlock-alt"></i> Buka
                                        </button>
                                    </form>
                                </div>
                            @elseif(!$session->completed_at && !$session->is_locked)
                                <div class="action-buttons">
                                    <span class="text-muted" style="font-size: 11px; background: #f1f5f9; padding: 5px 8px; border-radius: 8px;">
                                        <i class="fas fa-check"></i> Berjalan
                                    </span>
                                </div>
                            @elseif($session->completed_at)
                                <div class="action-buttons">
                                    <span class="text-muted" style="font-size: 11px;">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </span>
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 11px;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-clock"></i>
                            <p style="margin-top: 10px; color: #64748b;">Belum ada sesi ujian</p>
                            <p style="color: #94a3b8; font-size: 12px;">Siswa akan muncul setelah mulai mengerjakan ujian</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($sessions->hasPages())
        <div style="padding: 16px; border-top: 1px solid #e2e8f0;">
            {{ $sessions->links() }}
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
                alert('✅ Kode Aktivasi: ' + data.code + '\n\nKode 5 karakter. Berikan ke siswa untuk membuka ujian yang terkunci.');
                location.reload();
            } else {
                alert('❌ Gagal generate kode');
            }
        })
        .catch(err => {
            alert('❌ Terjadi kesalahan: ' + err.message);
        });
}
</script>
@endsection