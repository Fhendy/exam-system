@extends('layouts.student')

@section('title', 'Riwayat Ujian')

@section('content')
<style>
    .history-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }
    
    .history-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .history-title i {
        font-size: 28px;
        color: #0ea5e9;
        background: #e0f2fe;
        padding: 12px;
        border-radius: 16px;
    }
    
    .history-title h2 {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    
    .stats-badge {
        background: #f1f5f9;
        padding: 8px 16px;
        border-radius: 40px;
        font-size: 13px;
        font-weight: 500;
        color: #475569;
    }
    
    .stats-badge i {
        margin-right: 6px;
        color: #0ea5e9;
    }
    
    /* Table Styles */
    .table-container {
        overflow-x: auto;
        border-radius: 20px;
    }
    
    .exam-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    
    .exam-table thead {
        background: #f8fafc;
    }
    
    .exam-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: #475569;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    
    .exam-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    
    .exam-table tr:hover {
        background: #fafcff;
    }
    
    .exam-code {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        display: inline-block;
        color: #0ea5e9;
    }
    
    .date-info {
        display: flex;
        flex-direction: column;
        font-size: 12px;
    }
    
    .date-main {
        font-weight: 500;
        color: #0f172a;
    }
    
    .date-time {
        font-size: 11px;
        color: #94a3b8;
    }
    
    .strike-indicator {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
    }
    
    .strike-0 { color: #10b981; }
    .strike-1 { color: #f59e0b; }
    .strike-2 { color: #f97316; }
    .strike-3 { color: #ef4444; }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-locked {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .status-active {
        background: #fed7aa;
        color: #92400e;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .empty-icon i {
        font-size: 40px;
        color: #94a3b8;
    }
    
    .empty-state h4 {
        font-size: 20px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: #94a3b8;
        font-size: 14px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .history-header-custom {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .exam-table th {
            padding: 12px 16px;
            font-size: 12px;
        }
        
        .exam-table td {
            padding: 12px 16px;
            font-size: 13px;
        }
        
        .status-badge {
            padding: 4px 10px;
            font-size: 11px;
        }
    }
    
    @media (max-width: 640px) {
        .exam-table, .exam-table thead, .exam-table tbody, .exam-table tr, .exam-table td {
            display: block;
        }
        
        .exam-table thead {
            display: none;
        }
        
        .exam-table tr {
            margin-bottom: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px;
            background: white;
        }
        
        .exam-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .exam-table td:last-child {
            border-bottom: none;
        }
        
        .exam-table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            width: 110px;
            font-size: 12px;
        }
    }
</style>

<div class="card" style="border-radius: 28px; overflow: hidden;">
    <div class="card-body" style="padding: 28px 24px;">
        
        <div class="history-header-custom">
            <div class="history-title">
                <i class="fas fa-clock"></i>
                <h2>Riwayat Ujian</h2>
            </div>
            <div class="stats-badge">
                <i class="fas fa-chart-line"></i>
                Total: {{ $sessions->count() }} Ujian
            </div>
        </div>
        
        @if($sessions->count() > 0)
        <div class="table-container">
            <table class="exam-table">
                <thead>
                    <tr>
                        <th>Kode Ujian</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Pelanggaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                    <tr>
                        <td data-label="Kode Ujian">
                            <span class="exam-code">
                                <i class="fas fa-qrcode" style="margin-right: 6px; font-size: 10px;"></i>
                                {{ $session->exam_code }}
                            </span>
                        </td>
                        <td data-label="Tanggal Mulai">
                            <div class="date-info">
                                <span class="date-main">
                                    {{ \Carbon\Carbon::parse($session->started_at)->format('d/m/Y') }}
                                </span>
                                <span class="date-time">
                                    {{ \Carbon\Carbon::parse($session->started_at)->format('H:i:s') }}
                                </span>
                            </div>
                        </td>
                        <td data-label="Tanggal Selesai">
                            @if($session->completed_at)
                            <div class="date-info">
                                <span class="date-main">
                                    {{ \Carbon\Carbon::parse($session->completed_at)->format('d/m/Y') }}
                                </span>
                                <span class="date-time">
                                    {{ \Carbon\Carbon::parse($session->completed_at)->format('H:i:s') }}
                                </span>
                            </div>
                            @else
                            <span style="color: #94a3b8;">-</span>
                            @endif
                        </td>
                        <td data-label="Pelanggaran">
                            <span class="strike-indicator strike-{{ min($session->strikes, 3) }}">
                                @if($session->strikes == 0)
                                    <i class="fas fa-check-circle"></i> 0/3
                                @elseif($session->strikes == 1)
                                    <i class="fas fa-exclamation-triangle"></i> 1/3
                                @elseif($session->strikes == 2)
                                    <i class="fas fa-exclamation-circle"></i> 2/3
                                @else
                                    <i class="fas fa-lock"></i> 3/3
                                @endif
                            </span>
                        </td>
                        <td data-label="Status">
                            @if($session->completed_at)
                                <span class="status-badge status-completed">
                                    <i class="fas fa-check-circle"></i> Selesai
                                </span>
                            @elseif($session->is_locked)
                                <span class="status-badge status-locked">
                                    <i class="fas fa-lock"></i> Terkunci
                                </span>
                            @else
                                <span class="status-badge status-active">
                                    <i class="fas fa-play"></i> Berlangsung
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h4>Belum Ada Riwayat Ujian</h4>
            <p>Silakan masukkan kode ujian untuk memulai ujian pertama Anda.</p>
        </div>
        @endif
        
    </div>
</div>
@endsection