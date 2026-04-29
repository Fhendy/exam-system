@extends('layouts.admin')

@section('title', 'Kode Aktivasi')
@section('page-title', 'Kode Aktivasi (5 Karakter)')

@section('content')
<style>
    /* Stats Row Compact */
    .stats-row {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }
    
    .stat-card-simple {
        background: white;
        border-radius: 10px;
        padding: 6px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #e2e8f0;
    }
    
    .stat-card-simple i {
        font-size: 14px;
        color: #f59e0b;
    }
    
    .stat-card-simple span {
        font-size: 12px;
        font-weight: 600;
        color: #0f172a;
    }
    
    .stat-card-simple small {
        font-size: 10px;
        color: #64748b;
        margin-left: 3px;
    }
    
    /* Filter Bar */
    .filter-bar {
        background: white;
        border-radius: 12px;
        padding: 10px 16px;
        margin-bottom: 16px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        border: 1px solid #e2e8f0;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .filter-select {
        padding: 6px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        background: white;
        color: #334155;
        cursor: pointer;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: #0ea5e9;
    }
    
    /* Table Compact */
    .table th, .table td {
        padding: 10px 12px;
        font-size: 12px;
        vertical-align: middle;
    }
    
    .table th {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        background: #f8fafc;
    }
    
    .student-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 13px;
    }
    
    .student-nis {
        font-size: 10px;
        color: #94a3b8;
    }
    
    .class-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 9px;
        font-weight: 600;
        background: #e0f2fe;
        color: #0284c7;
        margin-top: 4px;
    }
    
    /* Kode Aktivasi Compact */
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
    
    .session-id {
        font-family: monospace;
        font-size: 10px;
        background: #f1f5f9;
        padding: 3px 6px;
        border-radius: 5px;
        display: inline-block;
    }
    
    .badge-sm {
        padding: 3px 10px;
        font-size: 10px;
        border-radius: 20px;
    }
    
    .btn-copy {
        padding: 5px 12px;
        font-size: 11px;
        border-radius: 8px;
    }
    
    .expired-date {
        font-size: 11px;
        white-space: nowrap;
    }
    
    .expired-relative {
        font-size: 9px;
        color: #94a3b8;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px;
    }
    
    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
    }
    
    .empty-state p {
        font-size: 13px;
        margin-top: 10px;
        color: #64748b;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    @media (max-width: 768px) {
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-group {
            justify-content: space-between;
        }
        .stats-row {
            justify-content: center;
        }
    }
    
    @media (max-width: 640px) {
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
        .activation-code {
            font-size: 13px;
            letter-spacing: 2px;
            padding: 3px 8px;
        }
    }
</style>

<!-- Statistik Ringkas -->
@php
    $totalCodes = $codes->count();
    $pendingCodes = $codes->where('is_used', false)->count();
    $usedCodes = $codes->where('is_used', true)->count();
    $expiredCodes = $codes->filter(function($c) { 
        return \Carbon\Carbon::parse($c->expires_at)->isPast() && !$c->is_used; 
    })->count();
    
    // Ambil daftar kelas unik dari data kode
    $uniqueClasses = collect();
    foreach($codes as $code) {
        if(isset($code->class_group) && !empty($code->class_group)) {
            $uniqueClasses->push($code->class_group);
        }
    }
    $uniqueClasses = $uniqueClasses->unique()->filter()->sort();
@endphp

<div class="stats-row">
    <div class="stat-card-simple">
        <i class="fas fa-key"></i>
        <span>{{ $totalCodes }} <small>Total Kode</small></span>
    </div>
    <div class="stat-card-simple">
        <i class="fas fa-clock"></i>
        <span>{{ $pendingCodes }} <small>Pending</small></span>
    </div>
    <div class="stat-card-simple">
        <i class="fas fa-check-circle"></i>
        <span>{{ $usedCodes }} <small>Digunakan</small></span>
    </div>
    @if($expiredCodes > 0)
    <div class="stat-card-simple">
        <i class="fas fa-hourglass-end"></i>
        <span>{{ $expiredCodes }} <small>Expired</small></span>
    </div>
    @endif
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <div class="filter-group">
        <select id="classFilter" class="filter-select" onchange="filterTable()">
            <option value="all">📚 Semua Kelas</option>
            @foreach($uniqueClasses as $class)
                <option value="{{ $class }}">📁 {{ $class }}</option>
            @endforeach
            <option value="unassigned">❓ Tanpa Kelas</option>
        </select>
        
        <select id="statusFilter" class="filter-select" onchange="filterTable()">
            <option value="all">🔄 Semua Status</option>
            <option value="pending">⏳ Pending</option>
            <option value="used">✅ Digunakan</option>
            <option value="expired">⌛ Kadaluarsa</option>
        </select>
        
        <div class="stats-group" style="display: flex; gap: 8px;">
            <span class="stat-badge" style="background: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 11px;">
                <i class="fas fa-filter"></i> <strong id="totalCount">{{ $totalCodes }}</strong> Ditampilkan
            </span>
        </div>
    </div>
    
    <div class="filter-group">
        <input type="text" id="searchInput" class="filter-select" placeholder="🔍 Cari siswa atau kode..." style="width: 200px;">
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="table" style="margin-bottom: 0;" id="activationTable">
                <thead>
                    <tr>
                        <th>Siswa / Kelas</th>
                        <th>Kode Aktivasi</th>
                        <th>Sesi ID</th>
                        <th>Status</th>
                        <th>Expired</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($codes as $code)
                    @php
                        $isExpired = \Carbon\Carbon::parse($code->expires_at)->isPast() && !$code->is_used;
                        $statusType = $code->is_used ? 'used' : ($isExpired ? 'expired' : 'pending');
                        $rowClass = (isset($code->class_group) && $code->class_group) ? $code->class_group : 'unassigned';
                    @endphp
                    <tr class="code-row" 
                        data-class="{{ $rowClass }}"
                        data-status="{{ $statusType }}"
                        data-name="{{ strtolower($code->student_name ?? '') }}"
                        data-code="{{ $code->code ?? '' }}">
                        <td data-label="Siswa">
                            <div class="student-name">{{ $code->student_name ?? '-' }}</div>
                            <div class="student-nis">{{ $code->nis ?? '-' }}</div>
                            @if(isset($code->class_group) && $code->class_group)
                                <div class="class-badge">
                                    <i class="fas fa-layer-group"></i> {{ $code->class_group }}
                                </div>
                            @endif
                        </td>
                        <td data-label="Kode Aktivasi">
                            <span class="activation-code">{{ $code->code }}</span>
                        </td>
                        <td data-label="Sesi ID">
                            <span class="session-id">{{ substr($code->session_id, 0, 12) }}...</span>
                            <br><small style="font-size: 9px;">{{ substr($code->session_id, -8) }}</small>
                        </td>
                        <td data-label="Status">
                            @if($code->is_used)
                                <span class="badge badge-success badge-sm">
                                    <i class="fas fa-check-circle"></i> Digunakan
                                </span>
                            @elseif($isExpired)
                                <span class="badge badge-danger badge-sm">
                                    <i class="fas fa-hourglass-end"></i> Kadaluarsa
                                </span>
                            @else
                                <span class="badge badge-warning badge-sm">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td data-label="Expired">
                            <div class="expired-date">
                                <i class="far fa-calendar-alt" style="color: #94a3b8; margin-right: 3px;"></i>
                                {{ \Carbon\Carbon::parse($code->expires_at)->format('d/m/Y H:i') }}
                            </div>
                            <div class="expired-relative">
                                {{ \Carbon\Carbon::parse($code->expires_at)->diffForHumans() }}
                            </div>
                        </td>
                        <td data-label="Aksi">
                            @if(!$code->is_used && !$isExpired)
                                <button class="btn btn-primary btn-copy" onclick="copyCode('{{ $code->code }}')" title="Salin Kode">
                                    <i class="fas fa-copy"></i> Salin
                                </button>
                            @else
                                <span class="text-muted" style="font-size: 10px;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-key"></i>
                            <p>Belum ada kode aktivasi</p>
                            <p style="font-size: 12px; color: #94a3b8;">Kode akan muncul saat siswa meminta aktivasi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            <table>
        </div>
    </div>
</div>

<script>
function filterTable() {
    const selectedClass = document.getElementById('classFilter').value;
    const selectedStatus = document.getElementById('statusFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.code-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const rowClass = row.getAttribute('data-class');
        const rowStatus = row.getAttribute('data-status');
        const rowName = row.getAttribute('data-name') || '';
        const rowCode = row.getAttribute('data-code') || '';
        
        let show = true;
        
        // Filter kelas
        if (selectedClass !== 'all') {
            if (selectedClass === 'unassigned') {
                if (rowClass !== 'unassigned') show = false;
            } else {
                if (rowClass !== selectedClass) show = false;
            }
        }
        
        // Filter status
        if (show && selectedStatus !== 'all') {
            if (rowStatus !== selectedStatus) show = false;
        }
        
        // Filter pencarian
        if (show && searchTerm !== '') {
            if (!rowName.includes(searchTerm) && !rowCode.toLowerCase().includes(searchTerm)) {
                show = false;
            }
        }
        
        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });
    
    document.getElementById('totalCount').innerText = visibleCount;
}

// Event listeners
document.getElementById('classFilter').addEventListener('change', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);
document.getElementById('searchInput').addEventListener('keyup', filterTable);

function copyCode(code) {
    navigator.clipboard.writeText(code);
    alert('✅ Kode aktivasi 5 karakter: ' + code + '\n\nKode sudah disalin ke clipboard!');
}

// Initial filter
filterTable();
</script>
@endsection