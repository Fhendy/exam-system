@extends('layouts.admin')

@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Siswa Baru')

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
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
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
    
    .row-2cols {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
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
                <i class="fas fa-user-plus"></i>
            </div>
            <h3>Tambah Siswa Baru</h3>
            <p>Isi data siswa dengan lengkap untuk dapat mengakses ujian</p>
        </div>
        
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-id-card"></i> NIS *
                    </label>
                    <input type="text" name="nis" class="form-control" placeholder="2024001" required>
                    <small class="text-muted">Nomor Induk Siswa (unik)</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-layer-group"></i> Kelas
                    </label>
                    <input type="text" name="class_group" class="form-control" placeholder="Contoh: X-RPL-1 / XI-RPL-2">
                    <small class="text-muted">Opsional, untuk pengelompokan</small>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i> Nama Lengkap *
                </label>
                <input type="text" name="name" class="form-control" placeholder="Ahmad Fauzi" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-envelope"></i> Email *
                </label>
                <input type="email" name="email" class="form-control" placeholder="siswa@example.com" required>
            </div>
            
            <div class="row-2cols">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Password *
                    </label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                </div>
            </div>
            
            <div class="checkbox-wrapper">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                <label for="is_active">
                    <i class="fas fa-check-circle" style="color: #10b981;"></i> Aktifkan akun
                </label>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.students') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Optional: Password confirmation validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.querySelector('input[name="password"]').value;
        const confirmation = document.querySelector('input[name="password_confirmation"]').value;
        
        if (confirmation && password !== confirmation) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak sama!');
        }
    });
</script>
@endsection