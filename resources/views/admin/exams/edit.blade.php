@extends('layouts.admin')

@section('title', 'Edit Ujian')
@section('page-title', 'Edit Ujian: {{ $exam->code }}')

@section('content')
<style>
    .form-card {
        max-width: 750px;
        margin: 0 auto;
        border-radius: 24px;
        overflow: hidden;
    }
    
    .form-card .card-body {
        padding: 24px 28px;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 24px;
    }
    
    .form-header .icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        box-shadow: 0 6px 16px rgba(245, 158, 11, 0.25);
    }
    
    .form-header .icon i {
        font-size: 24px;
        color: white;
    }
    
    .form-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }
    
    .form-header p {
        font-size: 12px;
        color: #64748b;
    }
    
    .form-group {
        margin-bottom: 18px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        font-size: 12px;
        color: #334155;
    }
    
    .form-label i {
        margin-right: 6px;
        color: #f59e0b;
        width: 16px;
        font-size: 12px;
    }
    
    .form-control, .form-select {
        width: 100%;
        padding: 8px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }
    
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 70px;
    }
    
    .text-muted {
        font-size: 10px;
        color: #94a3b8;
        margin-top: 4px;
        display: block;
    }
    
    .row-2cols {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 0;
    }
    
    .checkbox-wrapper input {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #f59e0b;
    }
    
    .checkbox-wrapper label {
        font-weight: 500;
        font-size: 12px;
        color: #334155;
        cursor: pointer;
        margin: 0;
    }
    
    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }
    
    .btn {
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        justify-content: center;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4);
    }
    
    .btn-outline {
        background: transparent;
        border: 1px solid #e2e8f0;
        color: #475569;
    }
    
    .btn-outline:hover {
        border-color: #f59e0b;
        color: #f59e0b;
        background: #fffbeb;
    }
    
    .info-box {
        background: #fef3c7;
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-left: 3px solid #f59e0b;
    }
    
    .info-box i {
        font-size: 16px;
        color: #f59e0b;
    }
    
    .info-box .info-text {
        flex: 1;
        font-size: 11px;
        color: #92400e;
    }
    
    hr {
        margin: 20px 0;
        border: none;
        border-top: 1px solid #e2e8f0;
    }
    
    .method-badge {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 12px;
        font-size: 9px;
        font-weight: 600;
        margin-left: 6px;
    }
    
    .method-badge.url {
        background: #d1fae5;
        color: #065f46;
    }
    
    .method-badge.html {
        background: #fed7aa;
        color: #92400e;
    }
    
    @media (max-width: 640px) {
        .form-card .card-body {
            padding: 16px;
        }
        .row-2cols {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .btn-group {
            flex-direction: column;
        }
        .form-header .icon {
            width: 48px;
            height: 48px;
        }
        .form-header .icon i {
            font-size: 20px;
        }
        .form-header h3 {
            font-size: 16px;
        }
    }
</style>

<div class="form-card card">
    <div class="card-body">
        <div class="form-header">
            <div class="icon">
                <i class="fas fa-pencil-alt"></i>
            </div>
            <h3>Edit Ujian</h3>
            <p>Perbarui informasi ujian yang diperlukan</p>
        </div>
        
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <div class="info-text">
                <strong>Kode Ujian: {{ $exam->code }}</strong> — Ubah pengaturan sesuai kebutuhan
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.exams.update', $exam->id) }}">
            @csrf @method('PUT')
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-qrcode"></i> Kode Ujian *
                    </label>
                    <input type="text" name="code" value="{{ $exam->code }}" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tachometer-alt"></i> Durasi (menit) *
                    </label>
                    <input type="number" name="duration_minutes" value="{{ $exam->duration_minutes }}" class="form-control" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading"></i> Judul Ujian *
                </label>
                <input type="text" name="title" value="{{ $exam->title }}" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left"></i> Deskripsi
                </label>
                <textarea name="description" class="form-control" rows="2">{{ $exam->description }}</textarea>
            </div>
            
            <hr>
            
            <!-- Pilihan Input -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-code"></i> Metode Input
                </label>
                <select id="inputMethod" class="form-select" onchange="toggleInputMethod()">
                    <option value="url" {{ $exam->iframe_url && !$exam->iframe_html ? 'selected' : '' }}>
                        🔗 URL Iframe <span class="method-badge url">Rekomendasi</span>
                    </option>
                    <option value="html" {{ $exam->iframe_html ? 'selected' : '' }}>
                        📝 Kode Iframe (HTML) <span class="method-badge html">Custom</span>
                    </option>
                </select>
            </div>
            
            <!-- Input URL -->
            <div id="urlInput" class="form-group" style="display: {{ $exam->iframe_url && !$exam->iframe_html ? 'block' : 'none' }};">
                <label class="form-label">
                    <i class="fas fa-link"></i> URL Iframe
                </label>
                <input type="url" name="iframe_url" value="{{ $exam->iframe_url }}" class="form-control" placeholder="https://forms.office.com/...">
                <small class="text-muted">Contoh: https://forms.office.com/r/xxxxx?embed=true</small>
            </div>
            
            <!-- Input HTML Iframe -->
            <div id="htmlInput" class="form-group" style="display: {{ $exam->iframe_html ? 'block' : 'none' }};">
                <label class="form-label">
                    <i class="fas fa-code"></i> Kode Iframe (HTML)
                </label>
                <textarea name="iframe_html" class="form-control" rows="4">{{ $exam->iframe_html }}</textarea>
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> Tempel seluruh kode iframe dari Microsoft Forms/Google Forms
                </small>
            </div>
            
            <hr>
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-gavel"></i> Max Strike *
                    </label>
                    <input type="number" name="max_strikes" value="{{ $exam->max_strikes }}" class="form-control" required>
                    <small class="text-muted">Maksimal pelanggaran</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-star"></i> Nilai Minimal
                    </label>
                    <input type="number" name="passing_score" value="{{ $exam->passing_score }}" class="form-control">
                    <small class="text-muted">Nilai kelulusan</small>
                </div>
            </div>
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt"></i> Waktu Mulai
                    </label>
                    <input type="datetime-local" name="start_time" value="{{ $exam->start_time ? date('Y-m-d\TH:i', strtotime($exam->start_time)) : '' }}" class="form-control">
                    <small class="text-muted">Kosongkan jika langsung bisa</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-check"></i> Waktu Selesai
                    </label>
                    <input type="datetime-local" name="end_time" value="{{ $exam->end_time ? date('Y-m-d\TH:i', strtotime($exam->end_time)) : '' }}" class="form-control">
                    <small class="text-muted">Kosongkan jika tanpa batas</small>
                </div>
            </div>
            
            <div class="checkbox-wrapper">
                <input type="checkbox" name="is_active" id="is_active" {{ $exam->is_active ? 'checked' : '' }}>
                <label for="is_active">
                    <i class="fas fa-check-circle" style="color: #10b981;"></i> Aktifkan Ujian
                </label>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Ujian
                </button>
                <a href="{{ route('admin.exams') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleInputMethod() {
    const method = document.getElementById('inputMethod').value;
    const urlDiv = document.getElementById('urlInput');
    const htmlDiv = document.getElementById('htmlInput');
    
    if (method === 'url') {
        urlDiv.style.display = 'block';
        htmlDiv.style.display = 'none';
    } else {
        urlDiv.style.display = 'none';
        htmlDiv.style.display = 'block';
    }
}
</script>
@endsection