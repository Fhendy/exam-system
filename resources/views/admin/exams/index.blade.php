@extends('layouts.admin')

@section('title', 'Manajemen Ujian')
@section('page-title', 'Manajemen Ujian')

@section('content')
<style>
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .btn-sm-custom {
        padding: 6px 12px;
        font-size: 12px;
    }
    
    .badge-sm {
        padding: 2px 8px;
        font-size: 10px;
    }
    
    .stats-group .badge {
        font-size: 11px;
        padding: 4px 10px;
    }
    
    /* Stats Cards Compact */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 16px;
    }
    
    .stats-card {
        background: white;
        border-radius: 14px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e2e8f0;
    }
    
    .stats-info h4 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
    }
    
    .stats-info p {
        font-size: 11px;
        color: #64748b;
        margin: 0;
    }
    
    .stats-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #0ea5e9, #3b82f6);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stats-icon i {
        font-size: 18px;
        color: white;
    }
    
    .stats-card.purple .stats-icon {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    
    .stats-card.cyan .stats-icon {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
    }
    
    /* Table Compact */
    .table th, .table td {
        padding: 8px 12px;
        font-size: 12px;
    }
    
    .badge-code {
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 6px;
        font-family: monospace;
        font-weight: 700;
        font-size: 11px;
        color: #0ea5e9;
    }
    
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 16px;
        font-size: 10px;
        font-weight: 600;
    }
    
    .action-buttons {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }
    
    .btn-icon-sm {
        padding: 4px 8px;
        font-size: 11px;
        border-radius: 8px;
    }
    
    .card-body {
        padding: 12px 0 !important;
    }
    
    .card {
        margin-bottom: 16px;
    }
    
    .table tr td:first-child, .table tr th:first-child {
        padding-left: 16px;
    }
    
    .table tr td:last-child, .table tr th:last-child {
        padding-right: 16px;
    }
    
    /* Empty state compact */
    .empty-state {
        padding: 32px;
    }
    
    .empty-state i {
        font-size: 40px;
    }
    
    .empty-state h3 {
        font-size: 16px;
        margin-top: 12px;
    }
    
    /* Responsive */
    @media (max-width: 800px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .stats-card {
            padding: 8px 12px;
        }
        .stats-info h4 {
            font-size: 16px;
        }
        .stats-info p {
            font-size: 9px;
        }
        .stats-icon {
            width: 28px;
            height: 28px;
        }
        .stats-icon i {
            font-size: 14px;
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
            margin-bottom: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 8px 12px;
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
            width: 90px;
            font-size: 11px;
        }
        .action-buttons {
            justify-content: flex-end;
        }
    }
</style>

<div class="header-actions">
    <a href="{{ route('admin.exams.create') }}" class="btn btn-primary btn-sm-custom">
        <i class="fas fa-plus"></i> Buat Ujian
    </a>
    <div class="stats-group">
        <span class="badge badge-info">
            <i class="fas fa-chart-line"></i> Total: {{ $exams->count() }}
        </span>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="table" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Tipe</th>
                        <th>Durasi</th>
                        <th>Strike</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                    <tr>
                        <td data-label="Kode">
                            <span class="badge-code">{{ $exam->code }}</span>
                        </td>
                        <td data-label="Judul">
                            <strong>{{ Str::limit($exam->title, 25) }}</strong>
                        </td>
                        <td data-label="Tipe">
                            @if($exam->iframe_html)
                                <span class="type-badge" style="background: #fed7aa; color: #92400e;">
                                    <i class="fas fa-code"></i> HTML
                                </span>
                            @elseif($exam->iframe_url)
                                <span class="type-badge" style="background: #d1fae5; color: #065f46;">
                                    <i class="fas fa-link"></i> URL
                                </span>
                            @else
                                <span class="type-badge" style="background: #fee2e2; color: #991b1b;">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                        </td>
                        <td data-label="Durasi">
                            <i class="fas fa-clock" style="color: #94a3b8;"></i> {{ $exam->duration_minutes }}m
                        </td>
                        <td data-label="Strike">
                            <span class="badge {{ $exam->max_strikes >= 3 ? 'badge-danger' : 'badge-warning' }}" style="font-size: 10px; padding: 2px 6px;">
                                {{ $exam->max_strikes }}x
                            </span>
                        </td>
                        <td data-label="Status">
                            <span class="badge {{ $exam->is_active ? 'badge-success' : 'badge-danger' }}" style="font-size: 10px; padding: 2px 6px;">
                                <i class="fas {{ $exam->is_active ? 'fa-check' : 'fa-times' }}"></i>
                                {{ $exam->is_active ? 'Aktif' : 'Non' }}
                            </span>
                        </td>
                        <td data-label="Aksi">
                            <div class="action-buttons">
                                <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-primary btn-icon-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.exams.toggle', $exam->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-icon-sm" title="{{ $exam->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $exam->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.exams.delete', $exam->id) }}" style="display: inline;" onsubmit="return confirm('Hapus ujian {{ $exam->title }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <button class="btn btn-outline btn-icon-sm" onclick="copyExamCode('{{ $exam->code }}')" title="Salin Kode">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state" style="text-align: center;">
                            <i class="fas fa-folder-open" style="font-size: 40px; color: #cbd5e1;"></i>
                            <p style="margin-top: 8px; color: #64748b;">Belum ada ujian</p>
                            <a href="{{ route('admin.exams.create') }}" class="btn btn-primary btn-sm-custom" style="margin-top: 8px;">
                                <i class="fas fa-plus"></i> Buat Ujian
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Statistik Cards Compact -->
<div class="stats-grid">
    <div class="stats-card">
        <div class="stats-info">
            <h4>{{ $exams->where('is_active', true)->count() }}</h4>
            <p><i class="fas fa-check-circle" style="color: #10b981;"></i> Aktif</p>
        </div>
        <div class="stats-icon">
            <i class="fas fa-play"></i>
        </div>
    </div>
    
    <div class="stats-card purple">
        <div class="stats-info">
            <h4>{{ $exams->where('iframe_html', '!=', null)->count() }}</h4>
            <p><i class="fas fa-code"></i> HTML</p>
        </div>
        <div class="stats-icon">
            <i class="fas fa-code"></i>
        </div>
    </div>
    
    <div class="stats-card cyan">
        <div class="stats-info">
            <h4>{{ floor($exams->sum('duration_minutes') / 60) > 0 ? floor($exams->sum('duration_minutes') / 60) . 'j' : $exams->sum('duration_minutes') . 'm' }}</h4>
            <p><i class="fas fa-hourglass-half"></i> Durasi</p>
        </div>
        <div class="stats-icon">
            <i class="fas fa-clock"></i>
        </div>
    </div>
</div>

<script>
function copyExamCode(code) {
    navigator.clipboard.writeText(code);
    alert('✓ Kode ' + code + ' disalin');
}
</script>
@endsection