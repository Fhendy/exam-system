@extends('layouts.student')

@section('title', 'Masukkan Kode Ujian')

@section('content')
<style>
    /* Additional styles for enter code page */
    .hero-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #0ea5e9, #3b82f6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.4);
    }
    
    .hero-icon i {
        font-size: 40px;
        color: white;
    }
    
    .exam-input {
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
        text-align: center;
        font-size: 18px;
    }
    
    .exam-input::placeholder {
        text-transform: none;
        letter-spacing: normal;
        font-weight: 400;
        font-size: 14px;
    }
    
    .btn-start {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        border: none;
        padding: 14px 24px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .btn-start:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
        background: linear-gradient(135deg, #0284c7, #0369a1);
    }
    
    .info-badge {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        padding: 12px 16px;
        border-radius: 16px;
        margin-top: 20px;
        text-align: center;
    }
    
    .info-badge p {
        color: #0284c7;
        font-size: 13px;
        margin: 0;
    }
    
    .history-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .history-header i {
        font-size: 20px;
        color: #0ea5e9;
    }
    
    .empty-history {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
    }
    
    .empty-history i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.5;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
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
    
    table {
        font-size: 14px;
    }
    
    @media (max-width: 640px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }
        
        thead {
            display: none;
        }
        
        tr {
            margin-bottom: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
        }
        
        td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border: none;
        }
        
        td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            width: 100px;
        }
    }
</style>

<div style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
    <div class="card" style="max-width: 500px; width: 100%; border-radius: 32px; box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);">
        <div class="card-body" style="padding: 40px 32px;">
            
            <div class="hero-icon">
                <i class="fas fa-laptop-code"></i>
            </div>
            
            <h3 style="text-align: center; font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                Masukkan Kode Ujian
            </h3>
            <p style="text-align: center; color: #64748b; font-size: 14px; margin-bottom: 32px;">
                Masukkan kode yang diberikan oleh guru Anda untuk memulai ujian
            </p>
            
            <form method="POST" action="{{ route('student.verify-code') }}">
                @csrf
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="font-weight: 600; margin-bottom: 8px; display: block;">
                        <i class="fas fa-qrcode" style="margin-right: 8px; color: #0ea5e9;"></i> 
                        Kode Ujian
                    </label>
                    <input type="text" 
                           name="exam_code" 
                           class="form-control exam-input" 
                            placeholder="Masukkan kode ujian (5 karakter)"
                           style="padding: 14px 16px; border-radius: 16px; border: 2px solid #e2e8f0; font-size: 16px;"
                           required 
                           autofocus>
                </div>
                
                <button type="submit" class="btn btn-primary btn-start" style="width: 100%; border-radius: 16px;">
                    <i class="fas fa-arrow-right" style="margin-right: 8px;"></i>
                    Mulai Ujian
                </button>
            </form>
            
            <div class="info-badge">
                <p>
                    <i class="fas fa-info-circle" style="margin-right: 6px;"></i>
                    Pastikan kode ujian yang dimasukkan benar. Ujian akan dimulai setelah kode terverifikasi.
                </p>
            </div>
            
        </div>
    </div>
</div>

<!-- Riwayat Ujian -->
@if(isset($sessions) && $sessions->count() > 0)
<div class="card" style="margin-top: 32px; border-radius: 24px;">
    <div class="card-header" style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
        <div class="history-header">
            <i class="fas fa-history"></i>
            <h4 style="margin: 0; font-weight: 600;">Riwayat Ujian Saya</h4>
        </div>
    </div>
    <div class="card-body" style="padding: 0; overflow-x: auto;">
        <table style="width: 100%;">
            <thead style="background: #f8fafc;">
                <tr>
                    <th style="padding: 16px; text-align: left;">Kode</th>
                    <th style="padding: 16px; text-align: left;">Mulai</th>
                    <th style="padding: 16px; text-align: left;">Selesai</th>
                    <th style="padding: 16px; text-align: left;">Pelanggaran</th>
                    <th style="padding: 16px; text-align: left;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td data-label="Kode" style="padding: 16px;">
                        <strong style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-family: monospace; font-size: 13px;">
                            {{ $session->exam_code }}
                        </strong>
                    </td>
                    <td data-label="Mulai" style="padding: 16px; color: #475569;">
                        <i class="far fa-calendar-alt" style="margin-right: 6px; color: #94a3b8; font-size: 12px;"></i>
                        {{ \Carbon\Carbon::parse($session->started_at)->format('d/m/Y H:i') }}
                    </td>
                    <td data-label="Selesai" style="padding: 16px; color: #475569;">
                        @if($session->completed_at)
                            <i class="fas fa-check-circle" style="margin-right: 6px; color: #10b981; font-size: 12px;"></i>
                            {{ \Carbon\Carbon::parse($session->completed_at)->format('d/m/Y H:i') }}
                        @else
                            <span style="color: #94a3b8;">-</span>
                        @endif
                    </td>
                    <td data-label="Pelanggaran" style="padding: 16px;">
                        @if($session->strikes == 0)
                            <span style="color: #10b981;">✓ {{ $session->strikes }}/3</span>
                        @elseif($session->strikes < 3)
                            <span style="color: #f59e0b;">⚠️ {{ $session->strikes }}/3</span>
                        @else
                            <span style="color: #ef4444;">🔒 {{ $session->strikes }}/3</span>
                        @endif
                    </td>
                    <td data-label="Status" style="padding: 16px;">
                        @if($session->completed_at)
                            <span class="status-badge status-completed">
                                <i class="fas fa-check-circle" style="margin-right: 4px; font-size: 10px;"></i> Selesai
                            </span>
                        @elseif($session->is_locked)
                            <span class="status-badge status-locked">
                                <i class="fas fa-lock" style="margin-right: 4px; font-size: 10px;"></i> Terkunci
                            </span>
                        @else
                            <span class="status-badge status-active">
                                <i class="fas fa-play" style="margin-right: 4px; font-size: 10px;"></i> Berlangsung
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="card" style="margin-top: 32px; border-radius: 24px; background: linear-gradient(135deg, #f8fafc, #f1f5f9);">
    <div class="empty-history">
        <i class="fas fa-inbox"></i>
        <p style="color: #64748b;">Belum ada riwayat ujian</p>
        <p style="color: #94a3b8; font-size: 13px;">Silakan masukkan kode ujian untuk memulai</p>
    </div>
</div>
@endif
@endsection