@extends('layouts.admin')

@section('title', 'Buat Ujian')
@section('page-title', 'Buat Ujian Baru')

@section('content')
<style>
    .form-card {
        max-width: 750px;
        margin: 0 auto;
        border-radius: 24px;
        overflow: hidden;
    }
    
    .form-card .card-body {
        padding: 28px 32px;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 28px;
    }
    
    .form-header .icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #0ea5e9, #3b82f6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
    }
    
    .form-header .icon i {
        font-size: 28px;
        color: white;
    }
    
    .form-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }
    
    .form-header p {
        font-size: 13px;
        color: #64748b;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #334155;
    }
    
    .form-label i {
        margin-right: 6px;
        color: #0ea5e9;
        width: 18px;
    }
    
    .form-control, .form-select {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }
    
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }
    
    .text-muted {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 6px;
        display: block;
    }
    
    .row-2cols {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
    }
    
    .checkbox-wrapper input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #0ea5e9;
    }
    
    .checkbox-wrapper label {
        font-weight: 500;
        font-size: 13px;
        color: #334155;
        cursor: pointer;
        margin: 0;
    }
    
    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 28px;
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        justify-content: center;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9, #3b82f6);
        color: white;
        box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4);
    }
    
    .btn-outline {
        background: transparent;
        border: 1px solid #e2e8f0;
        color: #475569;
    }
    
    .btn-outline:hover {
        border-color: #0ea5e9;
        color: #0ea5e9;
        background: #f0f9ff;
    }
    
    .info-box {
        background: #f0f9ff;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-left: 4px solid #0ea5e9;
    }
    
    .info-box i {
        font-size: 18px;
        color: #0ea5e9;
    }
    
    .info-box .info-text {
        flex: 1;
        font-size: 12px;
        color: #0284c7;
    }
    
    .method-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 16px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 8px;
    }
    
    .method-badge.url {
        background: #d1fae5;
        color: #065f46;
    }
    
    .method-badge.html {
        background: #fed7aa;
        color: #92400e;
    }
    
    hr {
        margin: 24px 0;
        border: none;
        border-top: 1px solid #e2e8f0;
    }
    
    @media (max-width: 640px) {
        .form-card .card-body {
            padding: 20px;
        }
        .row-2cols {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .btn-group {
            flex-direction: column;
        }
    }
</style>

<div class="form-card card">
    <div class="card-body">
        <div class="form-header">
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3>Buat Ujian Baru</h3>
            <p>Atur detail ujian dan metode penyisipan soal</p>
        </div>
        
        <div class="info-box">
            <i class="fas fa-lightbulb"></i>
            <div class="info-text">
                <strong>Tips:</strong> Gunakan URL Iframe untuk Microsoft Forms/Google Forms, atau tempel kode HTML untuk embed kustom.
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.exams.store') }}">
            @csrf
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-qrcode"></i> Kode Ujian *
                    </label>
                    <input type="text" name="code" class="form-control" placeholder="26JRRL" required>
                    <small class="text-muted">Kode unik untuk akses siswa (maks 10 karakter)</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tachometer-alt"></i> Durasi (menit) *
                    </label>
                    <input type="number" name="duration_minutes" value="90" class="form-control" required>
                    <small class="text-muted">Waktu pengerjaan ujian</small>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading"></i> Judul Ujian *
                </label>
                <input type="text" name="title" class="form-control" placeholder="ASAS RPL" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left"></i> Deskripsi
                </label>
                <textarea name="description" class="form-control" rows="2" placeholder="Deskripsikan ujian (opsional)"></textarea>
            </div>
            
            <hr>
            
            <!-- Pilihan Input -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-code"></i> Metode Input
                </label>
                <select id="inputMethod" class="form-select" onchange="toggleInputMethod()">
                    <option value="url">🔗 URL Iframe <span class="method-badge url">Rekomendasi</span></option>
                    <option value="html">📝 Kode Iframe (HTML) <span class="method-badge html">Custom</span></option>
                </select>
                <small class="text-muted">Pilih metode sesuai kebutuhan</small>
            </div>
            
            <!-- Input URL -->
            <div id="urlInput" class="form-group">
                <label class="form-label">
                    <i class="fas fa-link"></i> URL Iframe
                </label>
                <input type="url" name="iframe_url" class="form-control" placeholder="https://forms.office.com/...">
                <small class="text-muted">Contoh: https://forms.office.com/r/xxxxx?embed=true</small>
            </div>
            
            <!-- Input HTML Iframe -->
            <div id="htmlInput" class="form-group" style="display: none;">
                <label class="form-label">
                    <i class="fas fa-code"></i> Kode Iframe (HTML)
                </label>
                <textarea name="iframe_html" class="form-control" rows="4" placeholder='<iframe width="640px" height="480px" src="https://forms.office.com/r/xxxxx?embed=true" frameborder="0" ...></iframe>'></textarea>
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Cara mendapatkan:</strong> Microsoft Forms → Bagikan → Embed → Salin seluruh kode iframe
                </small>
            </div>
            
            <hr>
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-gavel"></i> Max Strike *
                    </label>
                    <input type="number" name="max_strikes" value="3" class="form-control" required>
                    <small class="text-muted">Maksimal pelanggaran sebelum ujian terkunci</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-star"></i> Nilai Minimal
                    </label>
                    <input type="number" name="passing_score" value="70" class="form-control">
                    <small class="text-muted">Nilai minimal untuk dinyatakan lulus</small>
                </div>
            </div>
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt"></i> Waktu Mulai
                    </label>
                    <input type="datetime-local" name="start_time" class="form-control">
                    <small class="text-muted">Kosongkan agar langsung bisa dimulai</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-check"></i> Waktu Selesai
                    </label>
                    <input type="datetime-local" name="end_time" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ada batas</small>
                </div>
            </div>
            
            <div class="checkbox-wrapper">
                <input type="checkbox" name="is_active" id="is_active" checked>
                <label for="is_active">
                    <i class="fas fa-check-circle" style="color: #10b981;"></i> Aktifkan Ujian
                </label>
            </div>
            <small class="text-muted" style="margin-top: -8px; display: block; margin-left: 28px;">
                Jika aktif, siswa dapat mengakses ujian dengan kode yang diberikan
            </small>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Ujian
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