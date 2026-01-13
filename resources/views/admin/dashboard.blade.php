@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid #667eea;
    }

    .stat-card h3 {
        color: #888;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .stat-card .number {
        font-size: 32px;
        font-weight: 700;
        color: #333;
    }

    /* Header action button */
    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .page-header .header-left { flex: 1; }
    .header-actions { display: flex; gap: 10px; align-items: center; }
    .btn-visit { background: #fff; color: #2b6cb0; padding: 10px 14px; border-radius: 8px; border: 2px solid #dbeafe; text-decoration: none; font-weight: 600; box-shadow: 0 2px 8px rgba(43,108,176,0.08); }
    .btn-visit:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(43,108,176,0.12); }
</style>
@endsection

@section('content')
<div class="page-header" style="margin-bottom: 30px;">
    <div class="header-left">
        <h1 style="color: #333; font-size: 28px; margin-bottom: 10px;">
            <i class="fas fa-home"></i> Dashboard
        </h1>
        <p style="color: #888;">Welcome back, {{ Auth::user()->name }}!</p>
    </div>

    <div class="header-actions">
        <a href="{{ route('home') }}" class="btn-visit" target="_blank" rel="noopener">Visit Website</a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Cities</h3>
        <div class="number">{{ $cities }}</div>
    </div>

    <div class="stat-card">
        <h3>Total News</h3>
        <div class="number">{{ $news }}</div>
    </div>

    <div class="stat-card">
        <h3>Total Videos</h3>
        <div class="number">{{ $videos }}</div>
    </div>

    <div class="stat-card">
        <h3>Active News</h3>
        <div class="number">{{ $activeNews }}</div>
    </div>
</div>
@endsection