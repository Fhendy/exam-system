@extends('layouts.admin')

@section('title', 'Edit Siswa')
@section('page-title', 'Edit Data Siswa')

@section('content')
<style>
    .form-card {
        max-width: 550px;
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
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
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
        color: #f59e0b;
        width: 18px;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    
    .text-muted {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 6px;
        display: block;
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
        accent-color: #f59e0b;
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
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
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
    
    .row-2cols {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    
    .info-badge {
        background: #fef3c7;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-left: 4px solid #f59e0b;
    }
    
    .info-badge i {
        font-size: 20px;
        color: #f59e0b;
    }
    
    .info-badge .info-text {
        flex: 1;
    }
    
    .info-badge .info-text strong {
        font-size: 13px;
        color: #92400e;
        display: block;
    }
    
    .info-badge .info-text span {
        font-size: 11px;
        color: #b45309;
    }
    
    @media (max-width: 560px) {
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
                <i class="fas fa-user-edit"></i>
            </div>
            <h3>Edit Data Siswa</h3>
            <p>Perbarui informasi siswa yang diperlukan</p>
        </div>
        
        <!-- Info Card -->
        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            <div class="info-text">
                <strong>ID Siswa: {{ $student->nis }}</strong>
                <span>Terdaftar sejak {{ \Carbon\Carbon::parse($student->created_at)->format('d F Y') }}</span>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
            @csrf
            @method('PUT')
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-id-card"></i> NIS *
                    </label>
                    <input type="text" name="nis" class="form-control" value="{{ old('nis', $student->nis) }}" required>
                    <small class="text-muted">Nomor Induk Siswa (unik)</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-layer-group"></i> Kelas
                    </label>
                    <input type="text" name="class_group" class="form-control" value="{{ old('class_group', $student->class_group) }}" placeholder="Contoh: X-RPL-1 / XI-RPL-2">
                    <small class="text-muted">Opsional, untuk pengelompokan</small>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i> Nama Lengkap *
                </label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-envelope"></i> Email *
                </label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" required>
            </div>
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Password Baru
                    </label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                    <small class="text-muted">Kosongkan jika tidak diubah</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>
            </div>
            
            <div class="checkbox-wrapper">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $student->is_active ? 'checked' : '' }}>
                <label for="is_active">
                    <i class="fas fa-check-circle" style="color: #10b981;"></i> Aktifkan akun
                </label>
            </div>
            <small class="text-muted" style="margin-top: -8px; display: block; margin-left: 28px;">
                Jika nonaktif, siswa tidak bisa login
            </small>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.students') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Password confirmation validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.querySelector('input[name="password"]').value;
        const confirmation = document.querySelector('input[name="password_confirmation"]').value;
        
        if (password && confirmation && password !== confirmation) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak sama!');
        }
    });
</script>
@endsection