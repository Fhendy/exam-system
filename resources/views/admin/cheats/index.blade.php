@extends('layouts.admin')

@section('title', 'Log Pelanggaran')
@section('page-title', 'Log Pelanggaran')

@section('content')
<style>
    /* Compact Stats */
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
        color: #ef4444;
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
    
    /* Table Compact */
    .table th, .table td {
        padding: 8px 10px;
        font-size: 11px;
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
        font-size: 12px;
    }
    
    .student-nis {
        font-size: 9px;
        color: #94a3b8;
    }
    
    /* Violation Badge Compact */
    .violation-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 16px;
        font-size: 10px;
        font-weight: 600;
    }
    
    .violation-badge i {
        font-size: 10px;
    }
    
    .violation-tab_switch { background: #fee2e2; color: #991b1b; }
    .violation-tab_minimize { background: #fed7aa; color: #92400e; }
    .violation-click_outside { background: #fef3c7; color: #92400e; }
    .violation-right_click { background: #fce7f3; color: #9d174d; }
    .violation-devtools { background: #dbeafe; color: #1e40af; }
    .violation-copy_attempt { background: #e0e7ff; color: #3730a3; }
    .violation-paste_attempt { background: #e0e7ff; color: #3730a3; }
    .violation-page_refresh { background: #fecaca; color: #991b1b; }
    .violation-screenshot { background: #ccfbf1; color: #0f766e; }
    .violation-inactivity { background: #f1f5f9; color: #475569; }
    .violation-touch_outside { background: #fef3c7; color: #92400e; }
    .violation-back_button { background: #fee2e2; color: #991b1b; }
    
    /* Strike Badge Compact */
    .badge-strike {
        padding: 2px 6px;
        border-radius: 16px;
        font-size: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    
    .badge-strike i {
        font-size: 9px;
    }
    
    .strike-1 { background: #fed7aa; color: #92400e; }
    .strike-2 { background: #fecaca; color: #991b1b; }
    .strike-3 { background: #fee2e2; color: #991b1b; }
    
    .exam-code-badge {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 5px;
        font-family: monospace;
        font-size: 10px;
    }
    
    .ip-code {
        font-size: 9px;
        background: #f1f5f9;
        padding: 2px 5px;
        border-radius: 4px;
        font-family: monospace;
    }
    
    .time-main {
        font-size: 10px;
        white-space: nowrap;
    }
    
    .time-relative {
        font-size: 9px;
        color: #94a3b8;
    }
    
    /* Pagination Compact */
    .pagination-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .showing-info {
        font-size: 11px;
        color: #64748b;
    }
    
    .showing-info i {
        margin-right: 4px;
        color: #0ea5e9;
    }
    
    .pagination {
        display: flex;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    
    .page-item {
        margin: 0;
    }
    
    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        font-size: 12px;
        font-weight: 500;
        color: #475569;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .page-link:hover {
        background: #f1f5f9;
        border-color: #0ea5e9;
        color: #0ea5e9;
    }
    
    .active .page-link {
        background: linear-gradient(135deg, #0ea5e9, #3b82f6);
        border-color: #0ea5e9;
        color: white;
    }
    
    .disabled .page-link {
        background: #f8fafc;
        color: #cbd5e1;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .page-link i {
        font-size: 11px;
    }
    
    .empty-state {
        text-align: center;
        padding: 30px;
    }
    
    .empty-state i {
        font-size: 36px;
        color: #cbd5e1;
    }
    
    .empty-state p {
        font-size: 12px;
        margin-top: 8px;
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
            margin-bottom: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px;
        }
        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border: none;
        }
        .table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            width: 100px;
            font-size: 10px;
        }
        .stats-row {
            justify-content: center;
        }
        .time-main {
            white-space: normal;
        }
        .pagination-info {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<!-- Statistik Ringkas -->
@php
    $totalViolations = $cheats->total();
    $uniqueStudents = $cheats->pluck('student_name')->unique()->count();
    $topViolation = $cheats->groupBy('violation_type')->sortDesc()->keys()->first();
    $avgStrike = round($cheats->avg('strike_number') ?? 0, 1);
    
    // Hitung range yang ditampilkan
    $currentPage = $cheats->currentPage();
    $perPage = $cheats->perPage();
    $start = ($currentPage - 1) * $perPage + 1;
    $end = min($currentPage * $perPage, $totalViolations);
    
    // Ambil daftar kelas unik dari data pelanggaran
    $uniqueClasses = $cheats->pluck('class_group')->unique()->filter()->sort();
@endphp

<div class="stats-row">
    <div class="stat-card-simple">
        <i class="fas fa-exclamation-triangle"></i>
        <span>{{ $totalViolations }} <small>Total</small></span>
    </div>
    <div class="stat-card-simple">
        <i class="fas fa-users"></i>
        <span>{{ $uniqueStudents }} <small>Siswa</small></span>
    </div>
    <div class="stat-card-simple">
        <i class="fas fa-chart-line"></i>
        <span>{{ $avgStrike }} <small>Rata Strike</small></span>
    </div>
    @if($topViolation)
    <div class="stat-card-simple">
        <i class="fas fa-trophy"></i>
        <span>{{ str_replace('_', ' ', ucfirst($topViolation)) }} <small>Terbanyak</small></span>
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
        
        <select id="violationFilter" class="filter-select" onchange="filterTable()">
            <option value="all">⚠️ Semua Pelanggaran</option>
            <option value="tab_switch">🪟 Pindah Tab</option>
            <option value="tab_minimize">📉 Minimize</option>
            <option value="click_outside">🖱️ Klik Luar</option>
            <option value="right_click">🔍 Klik Kanan</option>
            <option value="devtools">💻 DevTools</option>
            <option value="copy_attempt">📋 Copy</option>
            <option value="paste_attempt">📋 Paste</option>
            <option value="page_refresh">🔄 Refresh</option>
            <option value="screenshot">📸 Screenshot</option>
        </select>
        
        <div class="stats-group" style="display: flex; gap: 8px;">
            <span class="stat-badge" style="background: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 11px;">
                <i class="fas fa-filter"></i> <strong id="totalCount">{{ $totalViolations }}</strong> Ditampilkan
            </span>
        </div>
    </div>
    
    <div class="filter-group">
        <input type="text" id="searchInput" class="filter-select" placeholder="🔍 Cari siswa..." style="width: 180px;">
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="table" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th>Siswa / Kelas</th>
                        <th>Kode</th>
                        <th>Pelanggaran</th>
                        <th>Strike</th>
                        <th>IP</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($cheats as $cheat)
                    @php
                        $violationClass = 'violation-' . str_replace('_', '-', $cheat->violation_type);
                        $violationDisplay = str_replace('_', ' ', ucfirst($cheat->violation_type));
                        $rowClass = (isset($cheat->class_group) && $cheat->class_group) ? $cheat->class_group : 'unassigned';
                        
                        $violationIcon = [
                            'tab_switch' => 'fa-window-restore',
                            'tab_minimize' => 'fa-window-minimize',
                            'click_outside' => 'fa-mouse-pointer',
                            'right_click' => 'fa-hand-back-fist',
                            'devtools' => 'fa-laptop-code',
                            'copy_attempt' => 'fa-copy',
                            'paste_attempt' => 'fa-paste',
                            'page_refresh' => 'fa-sync',
                            'screenshot' => 'fa-camera',
                            'inactivity' => 'fa-bed',
                            'touch_outside' => 'fa-hand-peace',
                            'back_button' => 'fa-arrow-left',
                        ][$cheat->violation_type] ?? 'fa-exclamation-triangle';
                    @endphp
                    <tr class="cheat-row" 
                        data-class="{{ $rowClass }}"
                        data-violation="{{ $cheat->violation_type }}"
                        data-name="{{ strtolower($cheat->student_name ?? '') }}">
                        <td data-label="Siswa">
                            <div class="student-name">{{ $cheat->student_name }}</div>
                            <div class="student-nis">{{ $cheat->nis ?? '-' }}</div>
                            @if(isset($cheat->class_group) && $cheat->class_group)
                                <div class="class-badge">
                                    <i class="fas fa-layer-group"></i> {{ $cheat->class_group }}
                                </div>
                            @endif
                        </td>
                        <td data-label="Kode">
                            <span class="exam-code-badge">{{ $cheat->exam_code }}</span>
                        </td>
                        <td data-label="Pelanggaran">
                            <span class="violation-badge {{ $violationClass }}">
                                <i class="fas {{ $violationIcon }}"></i>
                                {{ $violationDisplay }}
                            </span>
                        </td>
                        <td data-label="Strike">
                            <span class="badge-strike strike-{{ min($cheat->strike_number, 3) }}">
                                <i class="fas fa-gavel"></i> {{ $cheat->strike_number }}/3
                            </span>
                        </td>
                        <td data-label="IP">
                            @if($cheat->ip_address)
                                <code class="ip-code">{{ $cheat->ip_address }}</code>
                            @else
                                <span class="student-nis">-</span>
                            @endif
                        </td>
                        <td data-label="Waktu">
                            <div class="time-main">{{ \Carbon\Carbon::parse($cheat->created_at)->format('d/m/Y H:i') }}</div>
                            <div class="time-relative">{{ \Carbon\Carbon::parse($cheat->created_at)->diffForHumans() }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-shield-alt"></i>
                            <p>Belum ada pelanggaran</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($cheats->hasPages())
        <div class="pagination-info">
            <div class="showing-info">
                <i class="fas fa-chart-simple"></i>
                Showing {{ $start }} to {{ $end }} of {{ $totalViolations }} results
            </div>
            <div>
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($cheats->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $cheats->previousPageUrl() }}" rel="prev">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif
                    
                    {{-- Pagination Elements --}}
                    @foreach ($cheats->getUrlRange(1, $cheats->lastPage()) as $page => $url)
                        @if ($page == $cheats->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                    
                    {{-- Next Page Link --}}
                    @if ($cheats->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $cheats->nextPageUrl() }}" rel="next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function filterTable() {
    const selectedClass = document.getElementById('classFilter').value;
    const selectedViolation = document.getElementById('violationFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.cheat-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const rowClass = row.getAttribute('data-class');
        const rowViolation = row.getAttribute('data-violation');
        const rowName = row.getAttribute('data-name') || '';
        
        let show = true;
        
        // Filter kelas
        if (selectedClass !== 'all') {
            if (selectedClass === 'unassigned') {
                if (rowClass !== 'unassigned') show = false;
            } else {
                if (rowClass !== selectedClass) show = false;
            }
        }
        
        // Filter jenis pelanggaran
        if (show && selectedViolation !== 'all') {
            if (rowViolation !== selectedViolation) show = false;
        }
        
        // Filter pencarian
        if (show && searchTerm !== '') {
            if (!rowName.includes(searchTerm)) show = false;
        }
        
        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });
    
    document.getElementById('totalCount').innerText = visibleCount;
}

// Event listeners
document.getElementById('classFilter').addEventListener('change', filterTable);
document.getElementById('violationFilter').addEventListener('change', filterTable);
document.getElementById('searchInput').addEventListener('keyup', filterTable);

// Initial filter
filterTable();
</script>
@endsection