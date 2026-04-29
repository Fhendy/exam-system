@extends('layouts.admin')

@section('title', 'Manajemen Siswa')
@section('page-title', 'Manajemen Siswa')

@section('content')
<style>
    /* Stats Row */
    .stats-row {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .stat-card-simple {
        background: white;
        border-radius: 14px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #e2e8f0;
    }
    
    .stat-card-simple i {
        font-size: 16px;
        color: #0ea5e9;
    }
    
    .stat-card-simple span {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
    }
    
    .stat-card-simple small {
        font-size: 10px;
        color: #64748b;
        margin-left: 4px;
    }
    
    /* Header Actions */
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    /* Filter Bar */
    .filter-bar {
        background: white;
        border-radius: 14px;
        padding: 10px 16px;
        margin-bottom: 20px;
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
        border-radius: 10px;
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
    
    .search-input {
        width: 200px;
        padding: 6px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 12px;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #0ea5e9;
    }
    
    /* Table */
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
    }
    
    .class-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: #e0f2fe;
        color: #0284c7;
    }
    
    .badge-sm {
        padding: 3px 10px;
        font-size: 11px;
        border-radius: 20px;
    }
    
    .btn-icon-sm {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 8px;
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
        color: #64748b;
        margin-top: 10px;
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
        .search-input {
            width: 100%;
        }
        .stats-row {
            justify-content: center;
        }
        .header-actions {
            flex-direction: column;
            align-items: stretch;
        }
        .header-actions .btn {
            text-align: center;
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
    }
</style>

<!-- Header dengan Tombol Tambah -->
<div class="header-actions">
    <div class="stats-row" style="margin-bottom: 0;">
        <div class="stat-card-simple">
            <i class="fas fa-users"></i>
            <span>{{ $students->count() }} <small>Total Siswa</small></span>
        </div>
        <div class="stat-card-simple">
            <i class="fas fa-user-check"></i>
            <span>{{ $students->where('is_active', true)->count() }} <small>Aktif</small></span>
        </div>
        <div class="stat-card-simple">
            <i class="fas fa-layer-group"></i>
            <span>{{ $students->pluck('class_group')->unique()->filter()->count() }} <small>Kelas</small></span>
        </div>
    </div>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Tambah Siswa
    </a>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <div class="filter-group">
        <select id="classFilter" class="filter-select" onchange="filterTable()">
            <option value="all">📚 Semua Kelas</option>
            @php
                $uniqueClasses = $students->pluck('class_group')->unique()->filter()->sort();
            @endphp
            @foreach($uniqueClasses as $class)
                <option value="{{ $class }}">📁 {{ $class }}</option>
            @endforeach
            <option value="unassigned">❓ Tanpa Kelas</option>
        </select>
        
        <select id="statusFilter" class="filter-select" onchange="filterTable()">
            <option value="all">🔄 Semua Status</option>
            <option value="active">✅ Aktif</option>
            <option value="inactive">❌ Nonaktif</option>
        </select>
        
        <div class="stats-group" style="display: flex; gap: 8px;">
            <span class="stat-badge" style="background: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 11px;">
                <i class="fas fa-users"></i> <strong id="totalCount">{{ $students->count() }}</strong> Ditampilkan
            </span>
        </div>
    </div>
    
    <div class="filter-group">
        <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari NIS atau nama...">
        <button class="btn btn-outline" onclick="exportToExcel()" style="padding: 6px 12px;">
            <i class="fas fa-download"></i> Export
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="table" id="studentTable" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Ujian</th>
                        <th>Pelanggaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    @forelse($students as $student)
                    @php
                        $examCount = DB::table('exam_sessions')->where('user_id', $student->id)->count();
                        $cheatCount = DB::table('cheat_logs')->where('user_id', $student->id)->count();
                        $cheatClass = $cheatCount == 0 ? 'badge-success' : ($cheatCount < 3 ? 'badge-warning' : 'badge-danger');
                    @endphp
                    <tr class="student-row" 
                        data-nis="{{ $student->nis }}"
                        data-name="{{ $student->name }}"
                        data-class="{{ $student->class_group ?? 'unassigned' }}"
                        data-status="{{ $student->is_active ? 'active' : 'inactive' }}">
                        <td data-label="NIS"><strong>{{ $student->nis }}</strong></td>
                        <td data-label="Nama">
                            <div class="student-name">{{ $student->name }}</div>
                            <small style="color: #94a3b8;">{{ $student->email }}</small>
                        </td>
                        <td data-label="Kelas">
                            @if($student->class_group)
                                <span class="class-badge">
                                    <i class="fas fa-layer-group"></i> {{ $student->class_group }}
                                </span>
                            @else
                                <span class="badge badge-warning badge-sm" style="background: #fef3c7; color: #92400e;">
                                    <i class="fas fa-question-circle"></i> -
                                </span>
                            @endif
                        </td>
                        <td data-label="Status">
                            <span class="badge {{ $student->is_active ? 'badge-success' : 'badge-danger' }} badge-sm">
                                <i class="fas {{ $student->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $student->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td data-label="Ujian">
                            <span class="badge badge-info badge-sm">
                                <i class="fas fa-file-alt"></i> {{ $examCount }}
                            </span>
                        </td>
                        <td data-label="Pelanggaran">
                            <span class="badge {{ $cheatClass }} badge-sm">
                                <i class="fas fa-exclamation-triangle"></i> {{ $cheatCount }}
                            </span>
                        </td>
                        <td data-label="Aksi">
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary btn-icon-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.students.delete', $student->id) }}" style="display: inline;" onsubmit="return confirm('Hapus siswa {{ $student->name }}? Semua data terkait akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <button class="btn btn-outline btn-icon-sm" onclick="viewDetail({{ $student->id }})" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-user-graduate"></i>
                            <p>Belum ada data siswa</p>
                            <a href="{{ route('admin.students.create') }}" class="btn btn-primary" style="margin-top: 10px;">
                                <i class="fas fa-user-plus"></i> Tambah Siswa
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterTable() {
    const selectedClass = document.getElementById('classFilter').value;
    const selectedStatus = document.getElementById('statusFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.student-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const rowClass = row.getAttribute('data-class');
        const rowStatus = row.getAttribute('data-status');
        const nis = row.getAttribute('data-nis')?.toLowerCase() || '';
        const name = row.getAttribute('data-name')?.toLowerCase() || '';
        
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
            if (!nis.includes(searchTerm) && !name.includes(searchTerm)) show = false;
        }
        
        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });
    
    document.getElementById('totalCount').innerText = visibleCount;
}

document.getElementById('searchInput').addEventListener('keyup', filterTable);
document.getElementById('classFilter').addEventListener('change', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);

function exportToExcel() {
    const rows = document.querySelectorAll('.student-row');
    let csvContent = "NIS,Nama Lengkap,Email,Kelas,Status,Ujian,Pelanggaran\n";
    
    rows.forEach(row => {
        if (row.style.display !== 'none') {
            const nis = row.querySelector('[data-label="NIS"]')?.innerText.trim() || '';
            const name = row.querySelector('[data-label="Nama"] .student-name')?.innerText.trim() || '';
            const email = row.querySelector('[data-label="Nama"] small')?.innerText.trim() || '';
            const kelas = row.querySelector('[data-label="Kelas"] .class-badge')?.innerText.trim() || '-';
            const status = row.querySelector('[data-label="Status"] .badge')?.innerText.trim() || '';
            const ujian = row.querySelector('[data-label="Ujian"] .badge')?.innerText.trim() || '';
            const pelanggaran = row.querySelector('[data-label="Pelanggaran"] .badge')?.innerText.trim() || '';
            
            csvContent += `"${nis}","${name}","${email}","${kelas}","${status}","${ujian}","${pelanggaran}"\n`;
        }
    });
    
    const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.setAttribute('download', 'siswa_export.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

function viewDetail(id) {
    window.location.href = '/admin/students/' + id;
}

// Initial filter
filterTable();
</script>
@endsection