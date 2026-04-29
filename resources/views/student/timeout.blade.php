@extends('layouts.student')

@section('title', 'Waktu Habis')

@section('content')
<style>
    .timeout-card {
        background: white;
        border-radius: 32px;
        padding: 48px 32px;
        text-align: center;
        max-width: 480px;
        margin: 60px auto;
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .timeout-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }
    
    .timeout-icon i {
        font-size: 50px;
        color: #ef4444;
    }
    
    .timeout-title {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
    }
    
    .timeout-message {
        color: #475569;
        font-size: 16px;
        line-height: 1.5;
        margin-bottom: 32px;
    }
    
    .timeout-details {
        background: #f8fafc;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 32px;
        text-align: left;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #64748b;
        font-size: 14px;
    }
    
    .detail-value {
        font-weight: 700;
        color: #0f172a;
        font-size: 14px;
    }
    
    .btn-dashboard {
        background: linear-gradient(135deg, #0ea5e9, #3b82f6);
        border: none;
        padding: 14px 28px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 15px;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
    }
    
    .btn-dashboard:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.4);
        background: linear-gradient(135deg, #0284c7, #0369a1);
    }
    
    .btn-dashboard i {
        font-size: 14px;
    }
    
    .info-note {
        margin-top: 24px;
        padding: 12px;
        background: #f0f9ff;
        border-radius: 16px;
        font-size: 12px;
        color: #0284c7;
        text-align: center;
    }
    
    .info-note i {
        margin-right: 6px;
    }
    
    @media (max-width: 640px) {
        .timeout-card {
            margin: 30px 20px;
            padding: 36px 24px;
        }
        
        .timeout-title {
            font-size: 28px;
        }
        
        .timeout-icon {
            width: 80px;
            height: 80px;
        }
        
        .timeout-icon i {
            font-size: 40px;
        }
        
        .btn-dashboard {
            padding: 12px 24px;
            font-size: 14px;
        }
    }
</style>

<div class="timeout-card">
    <div class="timeout-icon">
        <i class="fas fa-hourglass-end"></i>
    </div>
    
    <h1 class="timeout-title">⏰ Waktu Habis</h1>
    
    <p class="timeout-message">
        Maaf, waktu ujian Anda telah berakhir.<br>
        Ujian tidak dapat dilanjutkan.
    </p>
    
    <div class="timeout-details">
        <div class="detail-item">
            <span class="detail-label">
                <i class="fas fa-calendar-alt" style="margin-right: 6px; color: #94a3b8;"></i>
                Tanggal
            </span>
            <span class="detail-value">{{ now()->format('d F Y') }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">
                <i class="fas fa-clock" style="margin-right: 6px; color: #94a3b8;"></i>
                Waktu Berakhir
            </span>
            <span class="detail-value">{{ now()->format('H:i:s') }}</span>
        </div>
    </div>
    
    <a href="/student/dashboard" class="btn-dashboard">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Dashboard
    </a>
    
    <div class="info-note">
        <i class="fas fa-info-circle"></i>
        Silahkan hubungi guru Anda jika ingin mengikuti ujian susulan.
    </div>
</div>
@endsection