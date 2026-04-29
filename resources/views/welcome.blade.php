@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="card" style="max-width: 500px; margin: 100px auto;">
    <div class="card-header">
        🎓 Sistem Ujian Online
    </div>
    <div class="card-body">
        <p style="margin-bottom: 20px; color: #666;">Masukkan kode ujian untuk memulai</p>
        
        <form action="/exam/26JRRL" method="GET">
            <input type="text" 
                   name="code" 
                   placeholder="Kode Ujian" 
                   value="26JRRL"
                   style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px; margin-bottom: 20px; font-size: 16px;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">Mulai Ujian →</button>
        </form>
        
        <hr style="margin: 30px 0;">
        
        <p style="text-align: center; font-size: 14px; color: #999;">
            Demo: gunakan kode <strong>26JRRL</strong>
        </p>
        
        @if(!Auth::check())
        <p style="text-align: center; margin-top: 20px;">
            <a href="/login" style="color: #667eea;">Login Admin →</a>
        </p>
        @endif
    </div>
</div>
@endsection