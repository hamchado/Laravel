@extends('layouts.app')

@section('title', 'الصفحة الرئيسية')
@section('page_title', 'الرئيسية')

@section('content')

{{-- ========================================== --}}
{{-- GOOGLE FONTS - خط Tajawal فقط --}}
{{-- ========================================== --}}
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">

{{-- ========================================== --}}
{{-- CSS VARIABLES & RESET - أحجام الخطوط المحدثة --}}
{{-- ========================================== --}}
<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #6366f1;
        --secondary: #10b981;
        --accent: #ec4899;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1f2937;
        --gray: #6b7280;
        --gray-light: #f3f4f6;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        
        /* Responsive Spacing */
        --space-xs: clamp(0.25rem, 0.5vw, 0.375rem);
        --space-sm: clamp(0.5rem, 1vw, 0.75rem);
        --space-md: clamp(0.75rem, 1.5vw, 1rem);
        --space-lg: clamp(1rem, 2vw, 1.25rem);
        --space-xl: clamp(1.25rem, 2.5vw, 1.5rem);
        --space-2xl: clamp(1.5rem, 3vw, 2rem);
        
        /* ==========================================
           Responsive Font Sizes - مطابقة لـ app.css
           ========================================== */
        
        /* الأرقام والإحصائيات (Stats) */
        --text-3xl: clamp(18px, 5vw, 24px);
        --text-2xl: clamp(16px, 4.5vw, 22px);
        
        /* العناوين الرئيسية */
        --text-xl: clamp(15px, 4vw, 18px);
        --text-lg: clamp(14px, 3.8vw, 16px);
        
        /* النصوص العادية */
        --text-base: clamp(13px, 3.5vw, 15px);
        --text-md: clamp(12px, 3.2vw, 14px);
        
        /* النصوص الصغيرة */
        --text-sm: clamp(11px, 3vw, 13px);
        --text-xs: clamp(10px, 2.8vw, 12px);
        
        /* Responsive Radius */
        --radius-sm: clamp(0.25rem, 0.8vw, 0.375rem);
        --radius: clamp(0.375rem, 1vw, 0.5rem);
        --radius-lg: clamp(0.5rem, 1.5vw, 0.75rem);
        --radius-xl: clamp(0.75rem, 2vw, 1rem);
        
        /* Responsive Icons */
        --icon-xs: clamp(10px, 3vw, 12px);
        --icon-sm: clamp(11px, 3.2vw, 13px);
        --icon-base: clamp(13px, 3.8vw, 15px);
        --icon-lg: clamp(14px, 4vw, 16px);
        --icon-xl: clamp(16px, 4.5vw, 18px);
    }
    
    * { box-sizing: border-box; margin: 0; padding: 0; }
    
    body {
        font-family: 'Tajawal', sans-serif !important;
        font-size: var(--text-base);
        line-height: 1.5;
        color: var(--dark);
        background: #fafafa;
    }
    
    h1, h2, h3, h4, h5, h6, p, span, div, input, textarea, select, button, 
    label, a, li, th, td, strong, small {
        font-family: 'Tajawal', sans-serif !important;
    }
</style>

{{-- ========================================== --}}
{{-- HEADER --}}
{{-- ========================================== --}}
<style>
    .page-header {
        text-align: center;
        margin-bottom: var(--space-xl);
        padding: var(--space-lg) 0;
    }
    .page-header h1 {
        font-size: var(--text-2xl);
        color: var(--dark);
        margin-bottom: var(--space-sm);
        font-weight: 700;
        line-height: 1.2;
    }
    .page-header p {
        color: var(--gray);
        font-size: var(--text-md);
    }
</style>

<div class="page-header">
    <h1>مرحباً بك في النظام الطبي</h1>
    <p>نظرة عامة على نشاطك اليومي</p>
</div>

{{-- ========================================== --}}
{{-- 1. STATS SECTION --}}
{{-- ========================================== --}}
<style>
    .section-card {
        margin-bottom: var(--space-lg);
        border-radius: var(--radius);
        overflow: hidden;
        background: white;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }
    .section-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    
    .section-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: var(--space-md) var(--space-lg);
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
        border-bottom: 1px solid transparent;
    }
    .section-header-bar:hover { background: rgba(79, 70, 229, 0.02); }
    .section-card.active .section-header-bar { border-bottom-color: var(--gray-200); }
    
    .section-title-group {
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }
    .section-icon-box {
        width: clamp(32px, 8vw, 40px);
        height: clamp(32px, 8vw, 40px);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--icon-lg);
        flex-shrink: 0;
    }
    .section-title-text {
        font-size: var(--text-xl);
        font-weight: 700;
        color: var(--dark);
        line-height: 1.3;
    }
    .section-subtitle-text {
        font-size: var(--text-xs);
        color: var(--gray);
        margin-top: 2px;
    }
    .section-controls {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }
    .section-badge {
        background: var(--gray-light);
        color: var(--gray);
        padding: var(--space-xs) var(--space-sm);
        border-radius: 12px;
        font-size: var(--text-xs);
        font-weight: 600;
        white-space: nowrap;
    }
    .section-toggle-btn {
        width: clamp(28px, 6vw, 32px);
        height: clamp(28px, 6vw, 32px);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        background: var(--gray-light);
        border: none;
        cursor: pointer;
        flex-shrink: 0;
    }
    .section-toggle-btn i {
        transition: transform 0.3s ease;
        color: var(--gray);
        font-size: var(--icon-sm);
    }
    .section-card.active .section-toggle-btn { background: var(--primary); }
    .section-card.active .section-toggle-btn i { color: white; transform: rotate(180deg); }
    
    .section-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
        opacity: 0;
    }
    .section-card.active .section-body {
        max-height: 5000px;
        opacity: 1;
    }
    .section-inner { padding: 0 var(--space-lg) var(--space-lg); }
    
    .stats-section .section-icon-box { 
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(236, 72, 153, 0.1)); 
        color: var(--primary); 
    }
    
    .scroll-hint {
        font-size: var(--text-xs);
        color: var(--gray);
        background: rgba(79, 70, 229, 0.08);
        padding: var(--space-xs) var(--space-sm);
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
        margin-bottom: var(--space-md);
    }
    .scroll-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        margin: 0 calc(-1 * var(--space-md));
        padding: 0 var(--space-md);
    }
    .scroll-container::-webkit-scrollbar { display: none; }
    .cards-row {
        display: flex;
        gap: var(--space-md);
        padding-bottom: var(--space-sm);
    }
    .stat-card {
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        padding: var(--space-md);
        min-width: clamp(120px, 35vw, 160px);
        flex-shrink: 0;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .stat-icon {
        width: clamp(32px, 8vw, 40px);
        height: clamp(32px, 8vw, 40px);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: var(--space-sm);
        font-size: var(--icon-lg);
    }
    .stat-label { font-size: var(--text-xs); color: var(--gray); margin-bottom: 2px; }
    .stat-value {
        font-size: var(--text-3xl);
        font-weight: 700;
        margin-bottom: 2px;
        line-height: 1;
    }
    .stat-trend { font-size: var(--text-xs); display: flex; align-items: center; gap: 4px; }
    .progress-bar {
        height: 3px;
        background: var(--gray-200);
        border-radius: 2px;
        overflow: hidden;
        margin-top: var(--space-sm);
    }
    .progress-fill { height: 100%; background: var(--primary); width: 0%; transition: width 0.1s; }
</style>

<div class="section-card stats-section active" id="stats-section">
    <div class="section-header-bar" onclick="toggleSection('stats')">
        <div class="section-title-group">
            <div class="section-icon-box">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div>
                <div class="section-title-text">الإحصائيات الحيوية</div>
                <div class="section-subtitle-text">نظرة سريعة على أدائك</div>
            </div>
        </div>
        <div class="section-controls">
            <span class="section-badge">6 مؤشرات</span>
            <button class="section-toggle-btn">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </div>
    
    <div class="section-body">
        <div class="section-inner">
            <div class="scroll-hint">اسحب للمزيد</div>
            <div class="scroll-container">
                <div class="cards-row">
                    @php
                        $stats = [
                            ['icon' => 'fa-check-circle', 'color' => 'var(--secondary)', 'bg' => 'rgba(16, 185, 129, 0.1)', 'label' => 'المرضى الجدد', 'value' => 48, 'trend' => '+12%', 'trendColor' => 'var(--secondary)'],
                            ['icon' => 'fa-spinner', 'color' => 'var(--warning)', 'bg' => 'rgba(245, 158, 11, 0.1)', 'label' => 'قيد الإنجاز', 'value' => 23, 'trend' => '5 حالات', 'trendColor' => 'var(--warning)'],
                            ['icon' => 'fa-exclamation-circle', 'color' => 'var(--danger)', 'bg' => 'rgba(239, 68, 68, 0.1)', 'label' => 'بانتظار الموافقة', 'value' => 7, 'trend' => 'مراجعة', 'trendColor' => 'var(--danger)'],
                            ['icon' => 'fa-user-check', 'color' => 'var(--primary)', 'bg' => 'rgba(79, 70, 229, 0.1)', 'label' => 'المعالجين', 'value' => 156, 'trend' => '+24%', 'trendColor' => 'var(--primary)'],
                            ['icon' => 'fa-calendar-check', 'color' => 'var(--accent)', 'bg' => 'rgba(236, 72, 153, 0.1)', 'label' => 'المواعيد', 'value' => 14, 'trend' => '3 قادمة', 'trendColor' => 'var(--accent)'],
                            ['icon' => 'fa-file-medical', 'color' => '#8b5cf6', 'bg' => 'rgba(139, 92, 246, 0.1)', 'label' => 'التقارير', 'value' => 89, 'trend' => 'مكتملة', 'trendColor' => '#8b5cf6']
                        ];
                    @endphp
                    
                    @foreach($stats as $stat)
                    <div class="stat-card" onclick="showStatDetail('{{ $stat['label'] }}', {{ $stat['value'] }})">
                        <div class="stat-icon" style="background: {{ $stat['bg'] }}; color: {{ $stat['color'] }};">
                            <i class="fas {{ $stat['icon'] }}"></i>
                        </div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                        <div class="stat-value" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}</div>
                        <div class="stat-trend" style="color: {{ $stat['trendColor'] }};">{{ $stat['trend'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="progress-bar"><div class="progress-fill" id="stats-progress"></div></div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- 2. COURSES SECTION - المقررات السريرية --}}
{{-- ========================================== --}}
<style>
    .courses-section .section-icon-box { 
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05)); 
        color: var(--secondary); 
    }
    
    .data-table-wrapper {
        overflow-x: auto;
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray-200);
        -webkit-overflow-scrolling: touch;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }
    .data-table th,
    .data-table td {
        padding: var(--space-md);
        text-align: right;
        border-bottom: 1px solid var(--gray-200);
        font-size: var(--text-sm);
    }
    .data-table th {
        background: rgba(16, 185, 129, 0.08);
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
        font-size: var(--text-xs);
    }
    .data-table tr:hover { background: rgba(16, 185, 129, 0.02); }
    
    .course-title { font-size: var(--text-base); font-weight: 700; color: var(--dark); margin-bottom: 2px; }
    .course-meta { font-size: var(--text-xs); color: var(--gray); }
    
    .status-badge {
        padding: var(--space-xs) var(--space-sm);
        border-radius: 12px;
        font-size: var(--text-xs);
        font-weight: 600;
        color: white;
        display: inline-block;
        white-space: nowrap;
    }
    
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: var(--space-md);
        padding-top: var(--space-md);
        border-top: 1px solid var(--gray-200);
        flex-wrap: wrap;
        gap: var(--space-sm);
    }
    .pagination-info { font-size: var(--text-xs); color: var(--gray); }
    .pagination-btns { display: flex; gap: var(--space-sm); }
    .page-btn {
        padding: var(--space-sm) var(--space-md);
        border: 1.5px solid var(--gray-200);
        background: white;
        color: var(--gray);
        border-radius: var(--radius);
        font-size: var(--text-xs);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
        font-weight: 600;
    }
    .page-btn:hover:not(:disabled) {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(79, 70, 229, 0.05);
    }
    .page-btn:disabled { 
        opacity: 0.5; 
        cursor: not-allowed; 
        background: var(--gray-100);
        border-color: var(--gray-200);
        color: var(--gray);
    }
    .page-btn.primary {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .page-btn.primary:hover:not(:disabled) { 
        background: #4338ca; 
        border-color: #4338ca;
    }
    .page-btn.primary:disabled {
        background: #a5b4fc;
        border-color: #a5b4fc;
        color: white;
        opacity: 0.6;
    }
</style>

<div class="section-card courses-section active" id="courses-section">
    <div class="section-header-bar" onclick="toggleSection('courses')">
        <div class="section-title-group">
            <div class="section-icon-box">
                <i class="fas fa-book-medical"></i>
            </div>
            <div>
                <div class="section-title-text">المقررات السريرية</div>
                <div class="section-subtitle-text">المقررات النشطة حالياً</div>
            </div>
        </div>
        <div class="section-controls">
            <span class="section-badge">4 مقررات</span>
            <button class="section-toggle-btn">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </div>
    
    <div class="section-body">
        <div class="section-inner">
            <div class="data-table-wrapper">
                <table class="data-table" id="courses-table">
                    <thead>
                        <tr>
                            <th>المقرر</th>
                            <th style="text-align: center;">المشرف</th>
                            <th style="text-align: center;">القسم</th>
                            <th style="text-align: center;">الوقت</th>
                            <th style="text-align: center;">العيادة</th>
                            <th style="text-align: center;">الحالة</th>
                        </tr>
                    </thead>
                    <tbody id="courses-tbody">
                        <!-- يتم ملؤه بالJavaScript -->
                    </tbody>
                </table>
            </div>
            
            <div class="table-footer">
                <span class="pagination-info" id="courses-pagination-info">عرض 1-4 من 8</span>
                <div class="pagination-btns">
                    <button class="page-btn" id="courses-prev" onclick="changePage('courses', 'prev')">
                        <i class="fas fa-chevron-right"></i> السابق
                    </button>
                    <button class="page-btn primary" id="courses-next" onclick="changePage('courses', 'next')">
                        التالي <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- 3. REJECTED CASES - الحالات المرفوضة --}}
{{-- ========================================== --}}
<style>
    .rejected-section .section-icon-box { 
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.05)); 
        color: var(--danger); 
    }
    
    .toolbar {
        display: flex;
        gap: var(--space-md);
        margin-bottom: var(--space-md);
        flex-wrap: wrap;
    }
    .search-box { position: relative; flex: 1; min-width: 200px; }
    .search-input {
        width: 100%;
        padding: var(--space-sm) var(--space-md);
        padding-left: calc(var(--space-xl) + var(--space-sm));
        border: 1.5px solid var(--gray-200);
        border-radius: var(--radius-sm);
        font-size: var(--text-base);
        transition: all 0.2s;
        font-family: 'Tajawal', sans-serif;
    }
    .search-input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    .search-btn {
        position: absolute;
        left: var(--space-sm);
        top: 50%;
        transform: translateY(-50%);
        background: var(--danger);
        color: white;
        border: none;
        border-radius: var(--radius-sm);
        width: clamp(28px, 6vw, 32px);
        height: clamp(28px, 6vw, 32px);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: var(--icon-sm);
        transition: transform 0.2s;
    }
    .search-btn:hover { transform: translateY(-50%) scale(1.05); }
    .search-btn i { font-size: var(--icon-xs); }
    
    /* نتائج البحث */
    .search-results-info {
        font-size: var(--text-xs);
        color: var(--primary);
        margin-bottom: var(--space-sm);
        padding: var(--space-xs) var(--space-sm);
        background: rgba(79, 70, 229, 0.05);
        border-radius: var(--radius-sm);
        display: none;
    }
    .search-results-info.show { display: block; }
    .search-results-info .clear-search {
        color: var(--danger);
        cursor: pointer;
        font-weight: 700;
        margin-right: var(--space-sm);
    }
    
    .rejected-table th {
        background: rgba(239, 68, 68, 0.08) !important;
    }
    .rejected-table tr:hover { background: rgba(239, 68, 68, 0.02) !important; }
    
    .patient-cell {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }
    .patient-avatar-sm {
        width: clamp(28px, 6vw, 32px);
        height: clamp(28px, 6vw, 32px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: var(--text-xs);
        font-weight: 700;
        flex-shrink: 0;
    }
    .patient-info-sm { display: flex; flex-direction: column; }
    .patient-name-sm { font-weight: 700; font-size: var(--text-base); color: var(--dark); }
    .patient-id-sm { font-size: var(--text-xs); color: var(--gray); font-family: 'Tajawal', monospace; }
    
    .tooth-badge-sm {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: var(--text-xs);
        font-weight: 700;
        display: inline-block;
    }
    
    .status-change {
        display: flex;
        align-items: center;
        gap: var(--space-xs);
        font-size: var(--text-xs);
        flex-wrap: wrap;
        justify-content: center;
    }
    .status-old {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        padding: 2px 6px;
        border-radius: 4px;
        text-decoration: line-through;
    }
    .status-arrow { color: var(--gray); font-size: var(--icon-xs); }
    .status-new {
        background: rgba(16, 185, 129, 0.1);
        color: var(--secondary);
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 700;
    }
    
    .supervisor-cell {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        justify-content: center;
    }
    .supervisor-avatar-sm {
        width: clamp(24px, 5vw, 28px);
        height: clamp(24px, 5vw, 28px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: var(--text-xs);
        font-weight: 700;
    }
    .supervisor-name-sm { font-size: var(--text-xs); font-weight: 700; }
    
    .date-cell { font-size: var(--text-xs); color: var(--gray); white-space: nowrap; }
    
    /* أزرار الإجراءات الموحدة */
    .action-btn {
        padding: var(--space-xs) var(--space-sm);
        border-radius: var(--radius-sm);
        font-size: var(--text-xs);
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
        border: 1.5px solid transparent;
        white-space: nowrap;
    }
    .action-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    .action-btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border-color: var(--primary);
    }
    .action-btn-primary:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .action-btn-success {
        background: linear-gradient(135deg, var(--secondary), #059669);
        color: white;
        border-color: var(--secondary);
    }
    .action-btn-success:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    .action-btn-danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        border-color: var(--danger);
    }
    .action-btn-danger:hover:not(:disabled) {
        background: var(--danger);
        color: white;
        transform: translateY(-1px);
    }
    .action-btn-secondary {
        background: var(--gray-light);
        color: var(--gray);
        border-color: var(--gray-200);
    }
    
    .request-code-sm {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary);
        padding: 2px 6px;
        border-radius: 4px;
        font-size: var(--text-xs);
        font-weight: 700;
        font-family: 'Tajawal', monospace;
    }
</style>

<div class="section-card rejected-section active" id="rejected-section">
    <div class="section-header-bar" onclick="toggleSection('rejected')">
        <div class="section-title-group">
            <div class="section-icon-box">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <div class="section-title-text">الحالات المرفوضة والمعدلة</div>
                <div class="section-subtitle-text">سجل التعديلات والموافقات</div>
            </div>
        </div>
        <div class="section-controls">
            <span class="section-badge" id="rejected-count">3 حالات</span>
            <button class="section-toggle-btn">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </div>
    
    <div class="section-body">
        <div class="section-inner">
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" class="search-input" id="rejected-search" placeholder="ابحث باسم المريض، رقم الحالة، السن، أو المشرف..." autocomplete="off">
                    <button class="search-btn" onclick="searchRejected()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <div class="search-results-info" id="rejected-search-info">
                <span id="rejected-search-text"></span>
                <span class="clear-search" onclick="clearRejectedSearch()">مسح البحث</span>
            </div>
            
            <div class="data-table-wrapper">
                <table class="data-table rejected-table" id="rejected-table">
                    <thead>
                        <tr>
                            <th>المريض</th>
                            <th style="text-align: center;">السن</th>
                            <th style="text-align: center;">التغيير</th>
                            <th style="text-align: center;">المشرف</th>
                            <th style="text-align: center;">التاريخ</th>
                            <th style="text-align: center;">رمز الطلب</th>
                            <th style="text-align: center;">إجراء</th>
                        </tr>
                    </thead>
                    <tbody id="rejected-tbody">
                        <!-- يتم ملؤه بالJavaScript -->
                    </tbody>
                </table>
            </div>
            
            <div class="table-footer">
                <span class="pagination-info" id="rejected-pagination-info">عرض 1-3 من 3</span>
                <div class="pagination-btns">
                    <button class="page-btn" id="rejected-prev" onclick="changePage('rejected', 'prev')">
                        <i class="fas fa-chevron-right"></i> السابق
                    </button>
                    <button class="page-btn primary" id="rejected-next" onclick="changePage('rejected', 'next')">
                        التالي <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- 4. RADIOLOGY FORM - طلب أشعة جديد --}}
{{-- ========================================== --}}
<style>
    .radiology-form-section .section-icon-box { 
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05)); 
        color: var(--warning); 
    }
    
    .form-group { margin-bottom: var(--space-lg); }
    .form-label {
        display: block;
        font-size: var(--text-base);
        font-weight: 700;
        color: var(--dark);
        margin-bottom: var(--space-sm);
    }
    
    /* البحث الذكي المطور */
    .smart-search { position: relative; }
    .smart-input {
        width: 100%;
        padding: var(--space-md);
        padding-left: calc(var(--space-xl) + var(--space-sm));
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        font-size: var(--text-base);
        transition: all 0.3s;
        background: white;
        font-family: 'Tajawal', sans-serif;
    }
    .smart-input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
    .smart-icon {
        position: absolute;
        left: var(--space-md);
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
        font-size: var(--icon-lg);
        transition: color 0.3s;
    }
    .smart-search:focus-within .smart-icon { color: var(--primary); }
    
    .smart-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid var(--primary);
        border-top: none;
        border-radius: 0 0 var(--radius) var(--radius);
        max-height: 280px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        display: none;
    }
    .smart-dropdown.show { display: block; animation: slideDown 0.2s ease; }
    
    .smart-item {
        padding: var(--space-md);
        cursor: pointer;
        border-bottom: 1px solid var(--gray-200);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }
    .smart-item:hover, .smart-item.selected { background: rgba(79, 70, 229, 0.05); }
    
    .smart-avatar {
        width: clamp(32px, 7vw, 36px);
        height: clamp(32px, 7vw, 36px);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: var(--text-xs);
        flex-shrink: 0;
    }
    .smart-info { flex: 1; text-align: right; }
    .smart-name { font-size: var(--text-base); font-weight: 700; color: var(--dark); margin-bottom: 2px; }
    .smart-meta { font-size: var(--text-xs); color: var(--gray); }
    .smart-badge {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary);
        padding: var(--space-xs) var(--space-sm);
        border-radius: 4px;
        font-size: var(--text-xs);
        font-weight: 700;
    }
    
    .selected-card {
        display: none;
        margin-top: var(--space-md);
        padding: var(--space-md);
        border-radius: var(--radius-sm);
        border-right: 3px solid;
        animation: fadeIn 0.3s ease;
    }
    .selected-card.show { display: block; }
    .selected-content { display: flex; align-items: center; gap: var(--space-md); }
    .selected-avatar {
        width: clamp(36px, 8vw, 40px);
        height: clamp(36px, 8vw, 40px);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: var(--text-base);
        flex-shrink: 0;
    }
    .selected-info { flex: 1; }
    .selected-name { font-weight: 700; color: var(--dark); font-size: var(--text-base); margin-bottom: 2px; }
    .selected-meta { font-size: var(--text-xs); color: var(--gray); }
    .selected-remove {
        background: none;
        border: none;
        color: var(--danger);
        cursor: pointer;
        padding: var(--space-sm);
        font-size: var(--icon-lg);
        transition: transform 0.2s;
    }
    .selected-remove:hover { transform: scale(1.1); }
    
    /* Select Box المطور */
    .custom-select-wrapper { position: relative; }
    .custom-select-trigger {
        width: 100%;
        padding: var(--space-md);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: var(--text-base);
        color: var(--gray);
    }
    .custom-select-trigger:hover { border-color: var(--primary); }
    .custom-select-wrapper.active .custom-select-trigger {
        border-color: var(--primary);
        border-bottom-color: transparent;
        border-radius: var(--radius) var(--radius) 0 0;
    }
    .custom-select-trigger-text { color: var(--dark); font-weight: 600; }
    .custom-select-trigger-text.placeholder { color: var(--gray); font-weight: 400; }
    .custom-select-arrow {
        transition: transform 0.3s;
        font-size: var(--icon-sm);
        color: var(--gray);
    }
    .custom-select-wrapper.active .custom-select-arrow { transform: rotate(180deg); }
    
    .custom-select-options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid var(--primary);
        border-top: none;
        border-radius: 0 0 var(--radius) var(--radius);
        max-height: 250px;
        overflow-y: auto;
        z-index: 100;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .custom-select-wrapper.active .custom-select-options { display: block; animation: slideDown 0.2s ease; }
    .custom-select-option {
        padding: var(--space-md);
        cursor: pointer;
        border-bottom: 1px solid var(--gray-200);
        font-size: var(--text-sm);
        transition: background 0.2s;
        color: var(--dark);
        font-weight: 600;
    }
    .custom-select-option:hover { background: rgba(79, 70, 229, 0.05); }
    .custom-select-option:last-child { border-bottom: none; }
    
    .form-textarea {
        width: 100%;
        padding: var(--space-md);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        font-size: var(--text-base);
        resize: vertical;
        min-height: 100px;
        font-family: 'Tajawal', sans-serif;
        transition: all 0.3s;
    }
    .form-textarea:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
    
    .form-actions {
        display: flex;
        gap: var(--space-md);
        flex-wrap: wrap;
    }
    .form-btn {
        flex: 1;
        min-width: 140px;
        padding: var(--space-md) var(--space-lg);
        border-radius: var(--radius);
        font-weight: 700;
        font-size: var(--text-base);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-sm);
        transition: all 0.3s;
        border: none;
    }
    .form-btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    .form-btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }
    .form-btn-primary:active:not(:disabled) { transform: translateY(0); }
    .form-btn-primary:disabled {
        opacity: 0.8;
        cursor: wait;
        transform: none;
    }
    .form-btn-secondary {
        background: var(--gray-light);
        color: var(--dark);
    }
    .form-btn-secondary:hover { background: var(--gray-200); }
    .form-btn i { font-size: var(--icon-base); }
    
    /* Spinner للزر */
    .btn-spinner {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin-left: 8px;
    }
    
    @keyframes spin { to { transform: rotate(360deg); } }
    @keyframes slideDown { 
        from { opacity: 0; transform: translateY(-10px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    @keyframes fadeIn { 
        from { opacity: 0; } 
        to { opacity: 1; } 
    }
</style>

<div class="section-card radiology-form-section active" id="radiology-form-section">
    <div class="section-header-bar" onclick="toggleSection('radiology-form')">
        <div class="section-title-group">
            <div class="section-icon-box">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div>
                <div class="section-title-text">طلب أشعة جديد</div>
                <div class="section-subtitle-text">طلب تصوير للمريض</div>
            </div>
        </div>
        <div class="section-controls">
            <span class="section-badge">نموذج</span>
            <button class="section-toggle-btn">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </div>
    
    <div class="section-body">
        <div class="section-inner">
            {{-- البحث عن المريض --}}
            <div class="form-group">
                <label class="form-label">
                    اختيار المريض <span style="color: var(--danger);">*</span>
                </label>
                <div class="smart-search" id="patient-search">
                    <input type="text" 
                           class="smart-input" 
                           id="patient-input"
                           placeholder="ابحث عن المريض..."
                           autocomplete="off"
                           oninput="searchPatients(this.value)"
                           onkeydown="navigateResults(event, 'patient')"
                           onblur="hideDropdownDelayed('patient')">
                    <i class="fas fa-search smart-icon" id="patient-search-icon"></i>
                    <div class="smart-dropdown" id="patient-dropdown"></div>
                </div>
                <div class="selected-card" id="patient-selected" style="background: rgba(16, 185, 129, 0.05); border-color: var(--secondary);">
                    <div class="selected-content">
                        <div class="selected-avatar" style="background: linear-gradient(135deg, var(--secondary), #059669);">
                            <i class="fas fa-user-injured"></i>
                        </div>
                        <div class="selected-info">
                            <div class="selected-name" id="patient-sel-name"></div>
                            <div class="selected-meta" id="patient-sel-meta"></div>
                        </div>
                        <button class="selected-remove" onclick="clearPatient()" title="إزالة الاختيار">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- سبب الطلب - Select Box مطور --}}
            <div class="form-group">
                <label class="form-label">
                    سبب الطلب <span style="color: var(--danger);">*</span>
                </label>
                <div class="custom-select-wrapper" id="reason-select-wrapper">
                    <div class="custom-select-trigger" onclick="toggleReasonSelect(event)">
                        <span id="reason-text" class="custom-select-trigger-text placeholder">اختر السبب...</span>
                        <i class="fas fa-chevron-down custom-select-arrow"></i>
                    </div>
                    <div class="custom-select-options">
                        <div class="custom-select-option" onclick="selectReason('no_image', 'السجل ليس به صورة للمريض')">السجل ليس به صورة للمريض</div>
                        <div class="custom-select-option" onclick="selectReason('follow_up', 'متابعة حالة سابقة')">متابعة حالة سابقة</div>
                        <div class="custom-select-option" onclick="selectReason('diagnosis', 'تأكيد تشخيص')">تأكيد تشخيص</div>
                        <div class="custom-select-option" onclick="selectReason('emergency', 'حالة طارئة')">حالة طارئة</div>
                    </div>
                </div>
            </div>

            {{-- ملاحظات --}}
            <div class="form-group">
                <label class="form-label">ملاحظات إضافية (اختياري)</label>
                <textarea class="form-textarea" id="notes" placeholder="أي معلومات إضافية..."></textarea>
            </div>

            {{-- أزرار --}}
            <div class="form-actions">
                <button type="button" class="form-btn form-btn-primary" id="submit-btn" onclick="submitForm()">
                    <i class="fas fa-paper-plane"></i> <span>إرسال الطلب</span>
                </button>
                <button type="button" class="form-btn form-btn-secondary" onclick="clearForm()">
                    <i class="fas fa-eraser"></i> مسح النموذج
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- 5. RADIOLOGY LIST - سجل طلبات الأشعة --}}
{{-- ========================================== --}}
<style>
    .radiology-list-section .section-icon-box { 
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(79, 70, 229, 0.05)); 
        color: var(--primary); 
    }
    
    .status-pill {
        padding: var(--space-xs) var(--space-sm);
        border-radius: 12px;
        font-size: var(--text-xs);
        font-weight: 700;
        display: inline-block;
        white-space: nowrap;
    }
    .status-pending { background: rgba(79, 70, 229, 0.1); color: var(--primary); }
    .status-progress { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
    .status-done { background: rgba(16, 185, 129, 0.1); color: var(--secondary); }
    .status-cancelled { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
    
    .radiology-table th {
        background: rgba(79, 70, 229, 0.08) !important;
    }
    .radiology-table tr:hover { background: rgba(79, 70, 229, 0.02) !important; }
    
    .patient-name-cell {
        font-weight: 700;
        font-size: var(--text-base);
        color: var(--dark);
    }
    .patient-record {
        font-size: var(--text-xs);
        color: var(--gray);
        font-family: 'Tajawal', monospace;
        margin-top: 2px;
    }
    
    .request-reason {
        font-size: var(--text-sm);
        color: var(--gray);
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .action-btns-cell {
        display: flex;
        gap: var(--space-xs);
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .radiology-search-container {
        position: relative;
        flex: 1;
        min-width: 250px;
    }
    .radiology-search-input {
        width: 100%;
        padding: var(--space-sm) var(--space-md);
        padding-left: calc(var(--space-xl) + var(--space-sm));
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        font-size: var(--text-base);
        transition: all 0.3s;
        background: white;
        font-family: 'Tajawal', sans-serif;
    }
    .radiology-search-input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
    .radiology-search-icon {
        position: absolute;
        left: var(--space-md);
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
        font-size: var(--icon-base);
        transition: color 0.3s;
    }
    .radiology-search-container:focus-within .radiology-search-icon { color: var(--primary); }
    
    .radiology-search-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid var(--primary);
        border-top: none;
        border-radius: 0 0 var(--radius) var(--radius);
        max-height: 280px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        display: none;
    }
    .radiology-search-dropdown.show { display: block; animation: slideDown 0.2s ease; }
    
    .radiology-search-item {
        padding: var(--space-md);
        cursor: pointer;
        border-bottom: 1px solid var(--gray-200);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }
    .radiology-search-item:hover, .radiology-search-item.selected { background: rgba(79, 70, 229, 0.05); }
    
    .radiology-search-avatar {
        width: clamp(32px, 7vw, 36px);
        height: clamp(32px, 7vw, 36px);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: var(--text-xs);
        flex-shrink: 0;
    }
    .radiology-search-info { flex: 1; text-align: right; }
    .radiology-search-name { font-size: var(--text-base); font-weight: 700; color: var(--dark); margin-bottom: 2px; }
    .radiology-search-meta { font-size: var(--text-xs); color: var(--gray); }
    .radiology-search-status {
        padding: 2px 8px;
        border-radius: 10px;
        font-size: var(--text-xs);
        font-weight: 700;
    }
    
    .cancelled-info {
        font-size: var(--text-xs);
        color: var(--danger);
        margin-top: 4px;
        padding: 4px 8px;
        background: rgba(239, 68, 68, 0.05);
        border-radius: 4px;
        border-right: 2px solid var(--danger);
    }
    .cancelled-reason {
        font-weight: 700;
    }
</style>

<div class="section-card radiology-list-section active" id="radiology-list-section">
    <div class="section-header-bar" onclick="toggleSection('radiology-list')">
        <div class="section-title-group">
            <div class="section-icon-box">
                <i class="fas fa-x-ray"></i>
            </div>
            <div>
                <div class="section-title-text">سجل طلبات الأشعة</div>
                <div class="section-subtitle-text">طلبات مكتب الاستقبال</div>
            </div>
        </div>
        <div class="section-controls">
            <span class="section-badge" id="radiology-count">8 طلبات</span>
            <button class="section-toggle-btn">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </div>
    
    <div class="section-body">
        <div class="section-inner">
            {{-- البحث الذكي --}}
            <div class="toolbar">
                <div class="radiology-search-container">
                    <input type="text" 
                           class="radiology-search-input" 
                           id="radiology-search-input"
                           placeholder="ابحث عن مريض، رقم السجل، أو السبب..."
                           autocomplete="off"
                           oninput="searchRadiologyRequests(this.value)"
                           onkeydown="navigateRadiologySearch(event)"
                           onblur="hideRadiologySearchDelayed()">
                    <i class="fas fa-search radiology-search-icon"></i>
                    <div class="radiology-search-dropdown" id="radiology-search-dropdown"></div>
                </div>
            </div>
            
            <div class="data-table-wrapper">
                <table class="data-table radiology-table" id="radiology-table">
                    <thead>
                        <tr>
                            <th>المريض</th>
                            <th style="text-align: center;">سبب الطلب</th>
                            <th style="text-align: center;">تاريخ الطلب</th>
                            <th style="text-align: center;">الحالة</th>
                            <th style="text-align: center;">إجراء</th>
                        </tr>
                    </thead>
                    <tbody id="radiology-tbody">
                        <!-- يتم ملؤه بالJavaScript -->
                    </tbody>
                </table>
            </div>
            
            <div class="table-footer">
                <span class="pagination-info" id="radiology-pagination-info">عرض 1-4 من 8</span>
                <div class="pagination-btns">
                    <button class="page-btn" id="radiology-prev" onclick="changePage('radiology', 'prev')">
                        <i class="fas fa-chevron-right"></i> السابق
                    </button>
                    <button class="page-btn primary" id="radiology-next" onclick="changePage('radiology', 'next')">
                        التالي <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL OVERLAY - نافذة التأكيد --}}
{{-- ========================================== --}}
<div id="modal-overlay" class="modal-overlay" style="display: none;">
    <div class="modal-content" id="modal-content">
        <!-- يتم ملؤه ديناميكياً -->
    </div>
</div>

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--space-md);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-content {
        background: white;
        border-radius: var(--radius-lg);
        max-width: 450px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(30px) scale(0.95);
        transition: all 0.3s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .modal-overlay.active .modal-content {
        transform: translateY(0) scale(1);
    }
    .modal-header {
        padding: var(--space-lg);
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-title {
        font-size: var(--text-lg);
        font-weight: 700;
        color: var(--dark);
    }
    .modal-close {
        background: none;
        border: none;
        color: var(--gray);
        font-size: var(--icon-lg);
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .modal-close:hover {
        background: var(--gray-light);
        color: var(--dark);
    }
    .modal-body {
        padding: var(--space-lg);
    }
    .modal-footer {
        padding: var(--space-lg);
        border-top: 1px solid var(--gray-200);
        display: flex;
        gap: var(--space-md);
        justify-content: flex-end;
    }
    .modal-btn {
        padding: var(--space-sm) var(--space-lg);
        border-radius: var(--radius);
        font-weight: 700;
        font-size: var(--text-sm);
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
    }
    .modal-btn-secondary {
        background: var(--gray-light);
        color: var(--dark);
    }
    .modal-btn-secondary:hover { background: var(--gray-200); }
    .modal-btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
    }
    .modal-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .modal-btn-danger {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
    }
    .modal-btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    .modal-btn-success {
        background: linear-gradient(135deg, var(--secondary), #059669);
        color: white;
    }
    .modal-btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .modal-info-box {
        background: var(--gray-light);
        padding: var(--space-md);
        border-radius: var(--radius);
        margin-bottom: var(--space-lg);
    }
    .modal-info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: var(--space-sm);
        font-size: var(--text-sm);
    }
    .modal-info-row:last-child { margin-bottom: 0; }
    .modal-info-label { color: var(--gray); font-weight: 600; }
    .modal-info-value { color: var(--dark); font-weight: 700; }
    
    .modal-success-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--space-lg);
        font-size: var(--text-2xl);
        color: var(--secondary);
    }
    .modal-success-title {
        text-align: center;
        color: var(--dark);
        font-size: var(--text-xl);
        font-weight: 700;
        margin-bottom: var(--space-sm);
    }
    .modal-success-text {
        text-align: center;
        color: var(--gray);
        font-size: var(--text-sm);
        margin-bottom: var(--space-lg);
    }
</style>

{{-- ========================================== --}}
{{-- NOTIFICATION TOAST - محسن --}}
{{-- ========================================== --}}
<div id="notification-container" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 10000; pointer-events: none;"></div>

<style>
    .notification-toast {
        background: white;
        border-radius: var(--radius);
        padding: var(--space-md) var(--space-lg);
        margin-bottom: var(--space-sm);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: var(--space-md);
        min-width: 320px;
        max-width: 90vw;
        animation: notificationSlideIn 0.3s ease;
        pointer-events: auto;
        border-right: 4px solid;
        position: relative;
        overflow: hidden;
    }
    .notification-toast.hiding {
        animation: notificationSlideOut 0.3s ease forwards;
    }
    .notification-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--icon-lg);
        flex-shrink: 0;
    }
    .notification-content { flex: 1; }
    .notification-title {
        font-weight: 700;
        font-size: var(--text-sm);
        color: var(--dark);
        margin-bottom: 3px;
    }
    .notification-message {
        font-size: var(--text-xs);
        color: var(--gray);
        line-height: 1.4;
    }
    .notification-close {
        background: none;
        border: none;
        color: var(--gray);
        cursor: pointer;
        font-size: var(--icon-sm);
        padding: var(--space-xs);
        transition: color 0.2s;
    }
    .notification-close:hover { color: var(--dark); }
    
    .notification-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: currentColor;
        opacity: 0.3;
        animation: notificationProgress 4s linear forwards;
    }
    
    .notification-success { border-color: var(--secondary); }
    .notification-success .notification-icon { background: rgba(16, 185, 129, 0.1); color: var(--secondary); }
    .notification-success .notification-progress { background: var(--secondary); }
    
    .notification-error { border-color: var(--danger); }
    .notification-error .notification-icon { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
    .notification-error .notification-progress { background: var(--danger); }
    
    .notification-warning { border-color: var(--warning); }
    .notification-warning .notification-icon { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
    .notification-warning .notification-progress { background: var(--warning); }
    
    .notification-info { border-color: var(--primary); }
    .notification-info .notification-icon { background: rgba(79, 70, 229, 0.1); color: var(--primary); }
    .notification-info .notification-progress { background: var(--primary); }
    
    @keyframes notificationSlideIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes notificationSlideOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
    @keyframes notificationProgress {
        from { width: 100%; }
        to { width: 0%; }
    }
</style>

{{-- ========================================== --}}
{{-- JAVASCRIPT - معدل بالكامل --}}
{{-- ========================================== --}}
<script>
// ==========================================
// بيانات البحث والجداول
// ==========================================
const patientsData = [
    { id: 1, name: 'خالد العلي', record: 'MED-2024-001', age: 45, type: 'فحص روتيني', color: 'var(--primary)' },
    { id: 2, name: 'فاطمة حسن', record: 'MED-2024-002', age: 32, type: 'ألم أسنان', color: 'var(--secondary)' },
    { id: 3, name: 'عمر النجار', record: 'MED-2024-003', age: 58, type: 'تيجان', color: 'var(--accent)' },
    { id: 4, name: 'ليلى أحمد', record: 'MED-2024-004', age: 28, type: 'تقويم', color: 'var(--warning)' },
    { id: 5, name: 'يوسف محمود', record: 'MED-2024-005', age: 52, type: 'قلع', color: 'var(--danger)' }
];

const allCourses = [
    { id: 'cardiology', title: 'طب القلب السريري المتقدم', doctor: 'د. أحمد النجار', dept: 'أمراض القلب', time: 'السبت 8:00 - 12:00', clinic: 'العيادة 10', status: 'نشط', statusColor: 'var(--primary)' },
    { id: 'respiratory', title: 'أمراض الجهاز التنفسي', doctor: 'د. سارة عبدالله', dept: 'الأمراض الصدرية', time: 'الأحد 9:00 - 13:00', clinic: 'العيادة 7', status: 'جاري', statusColor: 'var(--secondary)' },
    { id: 'neurology', title: 'طب الأعصاب السريري', doctor: 'د. خالد محمود', dept: 'الأمراض العصبية', time: 'الثلاثاء 10:00 - 14:00', clinic: 'العيادة 15', status: 'جاري', statusColor: 'var(--accent)' },
    { id: 'clinical', title: 'الفحص السريري المتقدم', doctor: 'د. لينا حسن', dept: 'المهارات السريرية', time: 'الأربعاء 8:00 - 11:00', clinic: 'معمل المهارات 3', status: 'مكتمل', statusColor: 'var(--warning)' },
    { id: 'surgery', title: 'الجراحة العامة', doctor: 'د. محمد علي', dept: 'الجراحة', time: 'الخميس 9:00 - 13:00', clinic: 'غرفة العمليات 2', status: 'نشط', statusColor: 'var(--primary)' },
    { id: 'pediatrics', title: 'طب الأطفال', doctor: 'د. فاطمة أحمد', dept: 'الأطفال', time: 'السبت 10:00 - 14:00', clinic: 'العيادة 5', status: 'جاري', statusColor: 'var(--secondary)' },
    { id: 'dermatology', title: 'الأمراض الجلدية', doctor: 'د. ليلى خالد', dept: 'الجلدية', time: 'الأحد 11:00 - 15:00', clinic: 'العيادة 8', status: 'مكتمل', statusColor: 'var(--warning)' },
    { id: 'orthopedics', title: 'جراحة العظام', doctor: 'د. عمر حسن', dept: 'العظام', time: 'الاثنين 8:00 - 12:00', clinic: 'العيادة 12', status: 'نشط', statusColor: 'var(--primary)' }
];

let allRejectedCases = [
    {
        id: 'CASE-2024-001', name: 'أحمد محمد علي', age: 45, tooth: 'سن 16', color: 'var(--danger)',
        old_status: 'حشو', new_status: 'قلع', supervisor: 'د. سامر علي', supervisor_color: 'var(--primary)',
        date: '٢٠٢٤-٠١-١٥', time: '14:30', request_code: 'REQ-2024-0089', confirmed: false
    },
    {
        id: 'CASE-2024-002', name: 'سارة خالد حسن', age: 32, tooth: 'سن 8', color: '#ec4899',
        old_status: 'حشو تجميلي', new_status: 'تيجان', supervisor: 'د. ليلى أحمد', supervisor_color: '#ec4899',
        date: '٢٠٢٤-٠١-١٤', time: '11:15', request_code: 'REQ-2024-0085', confirmed: false
    },
    {
        id: 'CASE-2024-003', name: 'محمد عمر النجار', age: 58, tooth: 'سن 30', color: '#8b5cf6',
        old_status: 'استئصال لب', new_status: 'علاج جذور', supervisor: 'د. محمد حسن', supervisor_color: '#8b5cf6',
        date: '٢٠٢٤-٠١-١٢', time: '16:00', request_code: 'REQ-2024-0082', confirmed: true
    },
    {
        id: 'CASE-2024-004', name: 'فاطمة علي أحمد', age: 35, tooth: 'سن 16', color: 'var(--warning)',
        old_status: 'ترميم', new_status: 'تيجان', supervisor: 'د. سارة خالد', supervisor_color: 'var(--secondary)',
        date: '٢٠٢٤-٠١-١٠', time: '09:00', request_code: 'REQ-2024-0079', confirmed: false
    },
    {
        id: 'CASE-2024-005', name: 'خالد يوسف محمود', age: 42, tooth: 'سن 22', color: 'var(--primary)',
        old_status: 'حشو عادي', new_status: 'حشو عصب', supervisor: 'د. أحمد النجار', supervisor_color: 'var(--primary)',
        date: '٢٠٢٤-٠١-٠٨', time: '13:45', request_code: 'REQ-2024-0075', confirmed: false
    }
];

let allRadiologyRequests = [
    { id: 1, patient: 'خالد العلي', record: 'MED-2024-001', reason: 'السجل ليس به صورة للمريض', date: '٢٠٢٤-٠١-١٥', time: '10:30', status: 'معلق', statusClass: 'status-pending', confirmed: false, cancelled: false, cancel_reason: null, cancel_date: null, cancel_time: null },
    { id: 2, patient: 'فاطمة حسن', record: 'MED-2024-002', reason: 'متابعة حالة سابقة', date: '٢٠٢٤-٠١-١٤', time: '14:15', status: 'تمت', statusClass: 'status-done', confirmed: true, cancelled: false, cancel_reason: null, cancel_date: null, cancel_time: null },
    { id: 3, patient: 'عمر النجار', record: 'MED-2024-003', reason: 'تأكيد تشخيص', date: '٢٠٢٤-٠١-١٣', time: '09:00', status: 'قيد التنفيذ', statusClass: 'status-progress', confirmed: false, cancelled: false, cancel_reason: null, cancel_date: null, cancel_time: null },
    { id: 4, patient: 'ليلى أحمد', record: 'MED-2024-004', reason: 'حالة طارئة', date: '٢٠٢٤-٠١-١٢', time: '11:30', status: 'تمت', statusClass: 'status-done', confirmed: true, cancelled: false, cancel_reason: null, cancel_date: null, cancel_time: null },
    { id: 5, patient: 'يوسف محمود', record: 'MED-2024-005', reason: 'السجل ليس به صورة للمريض', date: '٢٠٢٤-٠١-١١', time: '15:45', status: 'معلق', statusClass: 'status-pending', confirmed: false, cancelled: false, cancel_reason: null, cancel_date: null, cancel_time: null },
    { id: 6, patient: 'أحمد علي', record: 'MED-2024-006', reason: 'متابعة حالة سابقة', date: '٢٠٢٤-٠١-١٠', time: '08:20', status: 'معلق', statusClass: 'status-pending', confirmed: false, cancelled: false, cancel_reason: null, cancel_date: null, cancel_time: null },
    { id: 7, patient: 'سارة خالد', record: 'MED-2024-007', reason: 'تأكيد تشخيص', date: '٢٠٢٤-٠١-٠٩', time: '13:10', status: 'قيد التنفيذ', statusClass: 'status-progress', confirmed: false, cancelled: false, cancel_reason: null, cancel_date: null, cancel_time: null },
    { id: 8, patient: 'محمد عمر', record: 'MED-2024-008', reason: 'حالة طارئة', date: '٢٠٢٤-٠١-٠٨', time: '10:00', status: 'تمت', statusClass: 'status-done', confirmed: true, cancelled: false, cancel_reason: null, cancel_date: null, cancel_time: null }
];

// متغيرات البحث
let selectedPatient = null;
let selectedReason = null;
let currentFocus = { patient: -1, radiology: -1 };
let radiologySearchResults = [];
let rejectedSearchResults = [];
let isSubmitting = false;

const paginationConfig = {
    courses: { currentPage: 1, perPage: 4, total: allCourses.length },
    rejected: { currentPage: 1, perPage: 3, total: allRejectedCases.length, filteredData: null },
    radiology: { currentPage: 1, perPage: 4, total: allRadiologyRequests.length, filteredData: null }
};

// ==========================================
// إدارة الأقسام
// ==========================================
function toggleSection(sectionId) {
    const section = document.getElementById(sectionId + '-section');
    if (section) {
        section.classList.toggle('active');
    }
}

// ==========================================
// البحث الذكي - المرضى
// ==========================================
function searchPatients(query) {
    const dropdown = document.getElementById('patient-dropdown');
    currentFocus.patient = -1;
    
    if (!query) {
        dropdown.classList.remove('show');
        return;
    }
    
    const matches = patientsData.filter(p => p.name.includes(query) || p.record.toLowerCase().includes(query.toLowerCase()));
    
    if (matches.length === 0) {
        dropdown.innerHTML = '<div style="padding: 12px; text-align: center; color: var(--gray); font-size: var(--text-sm);">لا توجد نتائج</div>';
    } else {
        dropdown.innerHTML = matches.map((p, index) => `
            <div class="smart-item" onclick="selectPatient(${p.id})" data-index="${index}">
                <div class="smart-avatar" style="background: linear-gradient(135deg, ${p.color}, ${p.color}dd);"><i class="fas fa-user"></i></div>
                <div class="smart-info">
                    <div class="smart-name">${highlightText(p.name, query)}</div>
                    <div class="smart-meta">${highlightText(p.record, query)} • ${p.age} سنة • ${p.type}</div>
                </div>
                <span class="smart-badge">اختر</span>
            </div>
        `).join('');
    }
    
    dropdown.classList.add('show');
}

function selectPatient(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (!patient) return;
    
    selectedPatient = patient;
    
    document.getElementById('patient-input').style.display = 'none';
    document.getElementById('patient-search-icon').style.display = 'none';
    
    document.getElementById('patient-selected').classList.add('show');
    document.getElementById('patient-sel-name').textContent = patient.name;
    document.getElementById('patient-sel-meta').innerHTML = `${patient.record} • ${patient.age} سنة • ${patient.type}`;
    
    hideDropdown('patient');
    
    showNotification(`تم اختيار المريض: ${patient.name}`, 'success');
}

function clearPatient() {
    selectedPatient = null;
    
    document.getElementById('patient-input').style.display = 'block';
    document.getElementById('patient-input').value = '';
    document.getElementById('patient-search-icon').style.display = 'block';
    
    document.getElementById('patient-selected').classList.remove('show');
    document.getElementById('patient-input').focus();
}

// ==========================================
// Select Box مخصص - سبب الطلب
// ==========================================
function toggleReasonSelect(event) {
    event.stopPropagation();
    const wrapper = document.getElementById('reason-select-wrapper');
    const isActive = wrapper.classList.contains('active');
    
    document.querySelectorAll('.custom-select-wrapper').forEach(s => s.classList.remove('active'));
    
    if (!isActive) {
        wrapper.classList.add('active');
    }
}

function selectReason(value, text) {
    selectedReason = value;
    const textEl = document.getElementById('reason-text');
    textEl.textContent = text;
    textEl.classList.remove('placeholder');
    textEl.classList.add('custom-select-trigger-text');
    
    document.getElementById('reason-select-wrapper').classList.remove('active');
    
    showNotification(`تم اختيار السبب: ${text}`, 'info');
}

document.addEventListener('click', (e) => {
    if (!e.target.closest('.custom-select-wrapper')) {
        document.querySelectorAll('.custom-select-wrapper').forEach(s => s.classList.remove('active'));
    }
});

// ==========================================
// البحث الذكي - طلبات الأشعة
// ==========================================
function searchRadiologyRequests(query) {
    const dropdown = document.getElementById('radiology-search-dropdown');
    currentFocus.radiology = -1;
    
    if (!query) {
        dropdown.classList.remove('show');
        paginationConfig.radiology.filteredData = null;
        paginationConfig.radiology.currentPage = 1;
        renderTable('radiology');
        return;
    }
    
    radiologySearchResults = allRadiologyRequests.filter(r => 
        r.patient.includes(query) || 
        r.record.toLowerCase().includes(query.toLowerCase()) ||
        r.reason.includes(query) ||
        r.status.includes(query)
    );
    
    if (radiologySearchResults.length === 0) {
        dropdown.innerHTML = '<div style="padding: 12px; text-align: center; color: var(--gray); font-size: var(--text-sm);">لا توجد نتائج</div>';
    } else {
        dropdown.innerHTML = radiologySearchResults.map((r, index) => {
            const statusColors = {
                'معلق': 'var(--primary)',
                'قيد التنفيذ': 'var(--warning)',
                'تمت': 'var(--secondary)',
                'ملغى': 'var(--danger)'
            };
            return `
            <div class="radiology-search-item" onclick="selectRadiologySearch(${r.id})" data-index="${index}">
                <div class="radiology-search-avatar" style="background: ${statusColors[r.status] || 'var(--gray)'};">
                    <i class="fas fa-user"></i>
                </div>
                <div class="radiology-search-info">
                    <div class="radiology-search-name">${highlightText(r.patient, query)}</div>
                    <div class="radiology-search-meta">${highlightText(r.record, query)} • ${r.reason}</div>
                </div>
                <span class="radiology-search-status" style="background: ${statusColors[r.status]}20; color: ${statusColors[r.status]};">${r.status}</span>
            </div>
        `}).join('');
    }
    
    dropdown.classList.add('show');
}

function selectRadiologySearch(requestId) {
    const request = allRadiologyRequests.find(r => r.id === requestId);
    if (!request) return;
    
    paginationConfig.radiology.filteredData = [request];
    paginationConfig.radiology.currentPage = 1;
    renderTable('radiology');
    
    document.getElementById('radiology-search-input').value = request.patient;
    hideRadiologySearch();
    
    showNotification(`تم العثور على طلب: ${request.patient}`, 'success');
}

function navigateRadiologySearch(event) {
    const dropdown = document.getElementById('radiology-search-dropdown');
    const items = dropdown.querySelectorAll('.radiology-search-item');
    
    if (event.key === 'ArrowDown') {
        event.preventDefault();
        currentFocus.radiology++;
        if (currentFocus.radiology >= items.length) currentFocus.radiology = 0;
        updateRadiologySearchFocus(items);
    } else if (event.key === 'ArrowUp') {
        event.preventDefault();
        currentFocus.radiology--;
        if (currentFocus.radiology < 0) currentFocus.radiology = items.length - 1;
        updateRadiologySearchFocus(items);
    } else if (event.key === 'Enter') {
        event.preventDefault();
        if (currentFocus.radiology > -1 && items[currentFocus.radiology]) {
            items[currentFocus.radiology].click();
        }
    } else if (event.key === 'Escape') {
        hideRadiologySearch();
    }
}

function updateRadiologySearchFocus(items) {
    items.forEach((item, index) => {
        if (index === currentFocus.radiology) {
            item.classList.add('selected');
            item.scrollIntoView({ block: 'nearest' });
        } else {
            item.classList.remove('selected');
        }
    });
}

function hideRadiologySearch() {
    document.getElementById('radiology-search-dropdown').classList.remove('show');
}

function hideRadiologySearchDelayed() {
    setTimeout(() => hideRadiologySearch(), 200);
}

// ==========================================
// البحث في الحالات المرفوضة - شغال 100%
// ==========================================
function searchRejected() {
    const query = document.getElementById('rejected-search').value.trim();
    
    if (!query) {
        clearRejectedSearch();
        return;
    }
    
    rejectedSearchResults = allRejectedCases.filter(c => 
        c.name.includes(query) || 
        c.id.toLowerCase().includes(query.toLowerCase()) ||
        c.tooth.includes(query) ||
        c.supervisor.includes(query) ||
        c.request_code.toLowerCase().includes(query.toLowerCase())
    );
    
    // تحديث معلومات البحث
    const infoDiv = document.getElementById('rejected-search-info');
    const textSpan = document.getElementById('rejected-search-text');
    
    if (rejectedSearchResults.length > 0) {
        textSpan.textContent = `تم العثور على ${rejectedSearchResults.length} نتيجة للبحث: "${query}"`;
        infoDiv.classList.add('show');
        
        // تخزين البيانات المفلترة والعرض
        paginationConfig.rejected.filteredData = rejectedSearchResults;
        paginationConfig.rejected.currentPage = 1;
        renderTable('rejected');
        
        showNotification(`تم العثور على ${rejectedSearchResults.length} حالة`, 'success');
    } else {
        textSpan.textContent = `لا توجد نتائج للبحث: "${query}"`;
        infoDiv.classList.add('show');
        paginationConfig.rejected.filteredData = [];
        renderTable('rejected');
        
        showNotification('لا توجد نتائج للبحث', 'warning');
    }
}

function clearRejectedSearch() {
    document.getElementById('rejected-search').value = '';
    document.getElementById('rejected-search-info').classList.remove('show');
    paginationConfig.rejected.filteredData = null;
    paginationConfig.rejected.currentPage = 1;
    rejectedSearchResults = [];
    renderTable('rejected');
}

// البحث الفوري أثناء الكتابة
document.getElementById('rejected-search').addEventListener('input', function(e) {
    if (e.target.value.trim() === '') {
        clearRejectedSearch();
    } else {
        // تأخير بسيط لتجنب البحث عند كل حرف
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => searchRejected(), 300);
    }
});

// ==========================================
// مساعدو البحث
// ==========================================
function highlightText(text, query) {
    if (!query) return text;
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<span style="background: rgba(245, 158, 11, 0.3); padding: 0 2px; border-radius: 2px;">$1</span>');
}

function navigateResults(event, type) {
    const dropdown = document.getElementById(type + '-dropdown');
    const items = dropdown.querySelectorAll('.smart-item');
    
    if (event.key === 'ArrowDown') {
        event.preventDefault();
        currentFocus[type]++;
        if (currentFocus[type] >= items.length) currentFocus[type] = 0;
        updateFocus(type, items);
    } else if (event.key === 'ArrowUp') {
        event.preventDefault();
        currentFocus[type]--;
        if (currentFocus[type] < 0) currentFocus[type] = items.length - 1;
        updateFocus(type, items);
    } else if (event.key === 'Enter') {
        event.preventDefault();
        if (currentFocus[type] > -1 && items[currentFocus[type]]) {
            items[currentFocus[type]].click();
        }
    } else if (event.key === 'Escape') {
        hideDropdown(type);
    }
}

function updateFocus(type, items) {
    items.forEach((item, index) => {
        if (index === currentFocus[type]) {
            item.classList.add('selected');
            item.scrollIntoView({ block: 'nearest' });
        } else {
            item.classList.remove('selected');
        }
    });
}

function hideDropdown(type) {
    document.getElementById(type + '-dropdown').classList.remove('show');
}

function hideDropdownDelayed(type) {
    setTimeout(() => hideDropdown(type), 200);
}

// ==========================================
// إرسال النموذج - مع spinner وما بعلق
// ==========================================
function submitForm() {
    if (isSubmitting) return; // منع الضغط المتكرر
    
    // التحقق من المريض
    if (!selectedPatient) {
        showNotification('يرجى اختيار المريض', 'warning');
        document.getElementById('patient-input').focus();
        return;
    }
    
    // التحقق من السبب
    if (!selectedReason) {
        showNotification('يرجى اختيار سبب الطلب', 'warning');
        document.getElementById('reason-select-wrapper').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }
    
    // التحقق من وجود طلب سابق
    const existingRequest = allRadiologyRequests.find(r => 
        r.patient === selectedPatient.name && 
        !r.cancelled && 
        (r.status === 'معلق' || r.status === 'قيد التنفيذ')
    );
    
    if (existingRequest) {
        showNotification(
            `لا يمكن إضافة طلب جديد للمريض ${selectedPatient.name} لوجود طلب سابق بحالة ${existingRequest.status}`,
            'error'
        );
        return;
    }
    
    const reasonText = document.getElementById('reason-text').textContent;
    
    showConfirmModal(
        'تأكيد إرسال الطلب',
        `
        <div class="modal-info-box">
            <div class="modal-info-row">
                <span class="modal-info-label">المريض:</span>
                <span class="modal-info-value">${selectedPatient.name}</span>
            </div>
            <div class="modal-info-row">
                <span class="modal-info-label">رقم السجل:</span>
                <span class="modal-info-value">${selectedPatient.record}</span>
            </div>
            <div class="modal-info-row">
                <span class="modal-info-label">سبب الطلب:</span>
                <span class="modal-info-value">${reasonText}</span>
            </div>
        </div>
        <p style="color: var(--gray); font-size: var(--text-sm);">هل أنت متأكد من إرسال طلب الأشعة؟</p>
        `,
        () => { 
            // استخدام setTimeout لتجنب تعليق الـ UI
            setTimeout(() => executeSubmit(), 50);
            return true; 
        },
        'إرسال الطلب',
        'primary'
    );
}

function executeSubmit() {
    if (isSubmitting) return;
    isSubmitting = true;
    
    const btn = document.getElementById('submit-btn');
    const originalContent = btn.innerHTML;
    
    // تفعيل حالة التحميل
    btn.disabled = true;
    btn.innerHTML = '<span class="btn-spinner"></span> <span>جاري الإرسال...</span>';
    
    // محاكاة الـ API call بدون تعليق الواجهة
    setTimeout(() => {
        const reasonText = document.getElementById('reason-text').textContent;
        
        const newRequest = {
            id: allRadiologyRequests.length + 1,
            patient: selectedPatient.name,
            record: selectedPatient.record,
            reason: reasonText,
            date: new Date().toLocaleDateString('ar-SA'),
            time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' }),
            status: 'معلق',
            statusClass: 'status-pending',
            confirmed: false,
            cancelled: false,
            cancel_reason: null,
            cancel_date: null,
            cancel_time: null
        };
        
        allRadiologyRequests.unshift(newRequest);
        paginationConfig.radiology.total = allRadiologyRequests.length;
        
        renderTable('radiology');
        updateCounts();
        
        // إعادة الزر لوضعه الطبيعي
        btn.disabled = false;
        btn.innerHTML = originalContent;
        isSubmitting = false;
        
        // تصفية النموذج
        clearForm();
        
        // إشعار النجاح
        showNotification('تم إضافة طلب الأشعة إلى السجل بنجاح', 'success');
        
        // عرض مودال النجاح
        showSuccessModal(
            'تم إرسال الطلب بنجاح!',
            `
            <div class="modal-info-box" style="background: rgba(16, 185, 129, 0.05); border-right: 3px solid var(--secondary);">
                <div class="modal-info-row">
                    <span class="modal-info-label">المريض:</span>
                    <span class="modal-info-value">${selectedPatient.name}</span>
                </div>
                <div class="modal-info-row">
                    <span class="modal-info-label">السبب:</span>
                    <span class="modal-info-value">${reasonText}</span>
                </div>
                <div class="modal-info-row">
                    <span class="modal-info-label">التاريخ:</span>
                    <span class="modal-info-value">${newRequest.date} ${newRequest.time}</span>
                </div>
            </div>
            `
        );
    }, 800); // 800ms تأخير محاكاة للـ API
}

function clearForm() {
    clearPatient();
    selectedReason = null;
    document.getElementById('reason-text').textContent = 'اختر السبب...';
    document.getElementById('reason-text').classList.add('placeholder');
    document.getElementById('notes').value = '';
}

// ==========================================
// Pagination
// ==========================================
function renderTable(section) {
    const config = paginationConfig[section];
    let dataToRender = [];
    
    if (section === 'rejected' && config.filteredData) {
        dataToRender = config.filteredData;
    } else if (section === 'radiology' && config.filteredData) {
        dataToRender = config.filteredData;
    } else {
        const start = (config.currentPage - 1) * config.perPage;
        const end = Math.min(start + config.perPage, config.total);
        dataToRender = getSectionData(section).slice(start, end);
    }
    
    let html = '';
    
    if (section === 'courses') {
        html = dataToRender.map(course => `
            <tr onclick="viewCourse('${course.id}')" style="cursor: pointer;">
                <td>
                    <div class="course-title">${course.title}</div>
                    <div class="course-meta">رمز المقرر: ${course.id.toUpperCase().substring(0, 4)}-2024</div>
                </td>
                <td style="text-align: center; font-weight: 700; font-size: var(--text-sm);">${course.doctor}</td>
                <td style="text-align: center; font-size: var(--text-sm);">${course.dept}</td>
                <td style="text-align: center; color: var(--gray); font-size: var(--text-xs);">${course.time}</td>
                <td style="text-align: center; font-size: var(--text-sm);">${course.clinic}</td>
                <td style="text-align: center;">
                    <span class="status-badge" style="background: ${course.statusColor};">${course.status}</span>
                </td>
            </tr>
        `).join('');
        document.getElementById('courses-tbody').innerHTML = html;
        
    } else if (section === 'rejected') {
        if (dataToRender.length === 0) {
            html = `<tr><td colspan="7" style="text-align: center; padding: var(--space-xl); color: var(--gray);">
                <i class="fas fa-inbox" style="font-size: var(--text-2xl); margin-bottom: var(--space-md); display: block; opacity: 0.5;"></i>
                لا توجد حالات مطابقة للبحث
            </td></tr>`;
        } else {
            html = dataToRender.map((caseItem) => `
                <tr>
                    <td>
                        <div class="patient-cell">
                            <div class="patient-avatar-sm" style="background: linear-gradient(135deg, ${caseItem.color}, ${caseItem.color}dd);">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="patient-info-sm">
                                <span class="patient-name-sm">${caseItem.name}</span>
                                <span class="patient-id-sm">${caseItem.id}</span>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <span class="tooth-badge-sm">${caseItem.tooth}</span>
                    </td>
                    <td style="text-align: center;">
                        <div class="status-change">
                            <span class="status-old">${caseItem.old_status}</span>
                            <i class="fas fa-arrow-left status-arrow"></i>
                            <span class="status-new">${caseItem.new_status}</span>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="supervisor-cell">
                            <div class="supervisor-avatar-sm" style="background: linear-gradient(135deg, ${caseItem.supervisor_color}, ${caseItem.supervisor_color}dd);">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <span class="supervisor-name-sm">${caseItem.supervisor}</span>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="date-cell">${caseItem.date}<br>${caseItem.time}</div>
                    </td>
                    <td style="text-align: center;">
                        <span class="request-code-sm">${caseItem.request_code}</span>
                    </td>
                    <td style="text-align: center;">
                        ${caseItem.confirmed 
                            ? `<button class="action-btn action-btn-success" type="button" disabled><i class="fas fa-check"></i> تم</button>`
                            : `<button class="action-btn action-btn-primary" type="button" onclick="event.stopPropagation(); confirmRejectedCase('${caseItem.id}')"><i class="fas fa-check"></i> تأكيد</button>`
                        }
                    </td>
                </tr>
            `).join('');
        }
        document.getElementById('rejected-tbody').innerHTML = html;
        
    } else if (section === 'radiology') {
        html = dataToRender.map(req => {
            let actionButtons = '';
            let cancelledInfo = '';
            
            if (req.cancelled) {
                cancelledInfo = `
                    <div class="cancelled-info">
                        <div><strong>ملغى:</strong> ${req.cancel_date} ${req.cancel_time}</div>
                        <div class="cancelled-reason">السبب: ${req.cancel_reason}</div>
                    </div>
                `;
                actionButtons = `
                    <button class="action-btn action-btn-secondary" type="button" disabled>
                        <i class="fas fa-ban"></i> ملغى
                    </button>
                `;
            } else if (req.status === 'معلق') {
                actionButtons = `
                    <button class="action-btn action-btn-danger" type="button" onclick="event.stopPropagation(); cancelRadiologyRequest(${req.id})">
                        <i class="fas fa-times"></i> إلغاء
                    </button>
                `;
            } else {
                actionButtons = `
                    <button class="action-btn action-btn-secondary" type="button" disabled>
                        <i class="fas fa-lock"></i> لا يمكن
                    </button>
                `;
            }
            
            return `
            <tr>
                <td>
                    <div class="patient-name-cell">${req.patient}</div>
                    <div class="patient-record">${req.record}</div>
                    ${cancelledInfo}
                </td>
                <td style="text-align: center;">
                    <div class="request-reason" title="${req.reason}">${req.reason}</div>
                </td>
                <td style="text-align: center;">
                    <div class="date-cell">${req.date}<br>${req.time}</div>
                </td>
                <td style="text-align: center;">
                    <span class="status-pill ${req.statusClass}">${req.status}</span>
                </td>
                <td style="text-align: center;">
                    <div class="action-btns-cell">
                        ${actionButtons}
                    </div>
                </td>
            </tr>
        `}).join('');
        document.getElementById('radiology-tbody').innerHTML = html;
    }
    
    let infoText;
    if ((section === 'radiology' || section === 'rejected') && config.filteredData) {
        infoText = config.filteredData.length === 0 ? 'لا توجد نتائج' : `تم العثور على ${config.filteredData.length} نتيجة`;
    } else {
        const start = (config.currentPage - 1) * config.perPage;
        const end = Math.min(start + config.perPage, config.total);
        infoText = config.total === 0 ? 'لا توجد بيانات' : `عرض ${start + 1}-${end} من ${config.total}`;
    }
    document.getElementById(`${section}-pagination-info`).textContent = infoText;
    
    updatePaginationButtons(section);
}

function getSectionData(section) {
    switch(section) {
        case 'courses': return allCourses;
        case 'rejected': return allRejectedCases;
        case 'radiology': return allRadiologyRequests;
        default: return [];
    }
}

function updatePaginationButtons(section) {
    const config = paginationConfig[section];
    const btnPrev = document.getElementById(`${section}-prev`);
    const btnNext = document.getElementById(`${section}-next`);
    
    if ((section === 'radiology' || section === 'rejected') && config.filteredData) {
        btnPrev.disabled = true;
        btnPrev.classList.remove('primary');
        btnNext.disabled = true;
        btnNext.classList.remove('primary');
        return;
    }
    
    if (config.currentPage <= 1) {
        btnPrev.disabled = true;
        btnPrev.classList.remove('primary');
    } else {
        btnPrev.disabled = false;
        btnPrev.classList.add('primary');
    }
    
    const totalPages = Math.ceil(config.total / config.perPage);
    if (config.currentPage >= totalPages) {
        btnNext.disabled = true;
        btnNext.classList.remove('primary');
    } else {
        btnNext.disabled = false;
        btnNext.classList.add('primary');
    }
}

function changePage(section, direction) {
    const config = paginationConfig[section];
    const totalPages = Math.ceil(config.total / config.perPage);
    
    if (direction === 'next' && config.currentPage < totalPages) {
        config.currentPage++;
    } else if (direction === 'prev' && config.currentPage > 1) {
        config.currentPage--;
    } else {
        return;
    }
    
    renderTable(section);
}

// ==========================================
// إلغاء طلب الأشعة
// ==========================================
function cancelRadiologyRequest(requestId) {
    const request = allRadiologyRequests.find(r => r.id === requestId);
    if (!request) {
        showNotification('لم يتم العثور على الطلب', 'error');
        return;
    }
    
    if (request.status !== 'معلق') {
        showNotification('لا يمكن إلغاء الطلب إلا إذا كان معلقاً', 'warning');
        return;
    }
    
    showConfirmModal(
        'إلغاء طلب الأشعة',
        `
        <div class="modal-info-box" style="background: rgba(239, 68, 68, 0.05); border-right: 3px solid var(--danger);">
            <div class="modal-info-row">
                <span class="modal-info-label">المريض:</span>
                <span class="modal-info-value">${request.patient}</span>
            </div>
            <div class="modal-info-row">
                <span class="modal-info-label">السبب:</span>
                <span class="modal-info-value">${request.reason}</span>
            </div>
            <div class="modal-info-row">
                <span class="modal-info-label">التاريخ:</span>
                <span class="modal-info-value">${request.date} ${request.time}</span>
            </div>
        </div>
        <div style="margin-bottom: 12px;">
            <label style="display: block; font-size: var(--text-sm); font-weight: 700; color: var(--dark); margin-bottom: 8px;">
                سبب الإلغاء <span style="color: var(--danger);">*</span>
            </label>
            <textarea id="cancel-reason-input" class="form-textarea" placeholder="أدخل سبب إلغاء الطلب..." style="min-height: 80px; border-color: var(--danger);"></textarea>
        </div>
        `,
        () => { return executeCancellation(requestId); },
        'تأكيد الإلغاء',
        'danger'
    );
}

function executeCancellation(requestId) {
    const cancelReason = document.getElementById('cancel-reason-input').value;
    if (!cancelReason || cancelReason.trim() === '') {
        showNotification('يرجى إدخال سبب الإلغاء', 'warning');
        return false;
    }
    
    const request = allRadiologyRequests.find(r => r.id === requestId);
    if (!request) return false;
    
    const now = new Date();
    request.cancelled = true;
    request.cancel_reason = cancelReason;
    request.status = 'ملغى';
    request.statusClass = 'status-cancelled';
    request.cancel_date = now.toLocaleDateString('ar-SA');
    request.cancel_time = now.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' });
    
    renderTable('radiology');
    updateCounts();
    
    showNotification('تم إلغاء الطلب وحفظ السبب في السجل', 'success');
    
    return true;
}

// ==========================================
// تأكيد حالة مرفوضة
// ==========================================
function confirmRejectedCase(caseId) {
    const caseItem = allRejectedCases.find(c => c.id === caseId);
    if (!caseItem) {
        showNotification('لم يتم العثور على الحالة', 'error');
        return;
    }
    if (caseItem.confirmed) {
        showNotification('هذه الحالة مؤكدة مسبقاً', 'info');
        return;
    }
    
    showConfirmModal(
        'تأكيد تعديل الحالة',
        `
        <div class="modal-info-box">
            <div class="modal-info-row">
                <span class="modal-info-label">المريض:</span>
                <span class="modal-info-value">${caseItem.name}</span>
            </div>
            <div class="modal-info-row">
                <span class="modal-info-label">التغيير:</span>
                <span class="modal-info-value">${caseItem.old_status} → ${caseItem.new_status}</span>
            </div>
            <div class="modal-info-row">
                <span class="modal-info-label">المشرف:</span>
                <span class="modal-info-value">${caseItem.supervisor}</span>
            </div>
            <div class="modal-info-row">
                <span class="modal-info-label">رمز الطلب:</span>
                <span class="modal-info-value">${caseItem.request_code}</span>
            </div>
        </div>
        <p style="color: var(--gray); font-size: var(--text-sm);">هل تريد تأكيد هذا التعديل؟</p>
        `,
        () => { return executeRejectedConfirmation(caseId); },
        'تأكيد',
        'primary'
    );
}

function executeRejectedConfirmation(caseId) {
    const caseItem = allRejectedCases.find(c => c.id === caseId);
    if (!caseItem) return false;
    
    caseItem.confirmed = true;
    
    renderTable('rejected');
    updateCounts();
    
    showNotification('تم تأكيد التعديل وحفظه في السجل', 'success');
    
    return true;
}

// ==========================================
// نظام المودال
// ==========================================
let currentModalCallback = null;
let modalOpen = false;
let modalClosing = false;

function showConfirmModal(title, content, onConfirm, confirmText = 'تأكيد', confirmType = 'primary') {
    if (modalOpen) {
        forceCloseModal();
        setTimeout(() => {
            openConfirmModal(title, content, onConfirm, confirmText, confirmType);
        }, 300);
        return;
    }
    
    openConfirmModal(title, content, onConfirm, confirmText, confirmType);
}

function openConfirmModal(title, content, onConfirm, confirmText, confirmType) {
    const overlay = document.getElementById('modal-overlay');
    const modalContent = document.getElementById('modal-content');
    
    if (!overlay || !modalContent) {
        console.error('Modal elements not found!');
        return;
    }
    
    currentModalCallback = onConfirm;
    modalOpen = true;
    modalClosing = false;
    
    const confirmBtnClass = confirmType === 'danger' ? 'modal-btn-danger' : (confirmType === 'success' ? 'modal-btn-success' : 'modal-btn-primary');
    
    modalContent.innerHTML = `
        <div class="modal-header">
            <h3 class="modal-title">${title}</h3>
            <button class="modal-close" type="button" id="modal-close-btn" aria-label="إغلاق">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            ${content}
        </div>
        <div class="modal-footer">
            <button class="modal-btn modal-btn-secondary" type="button" id="modal-cancel-btn">
                <i class="fas fa-times"></i> إلغاء
            </button>
            <button class="modal-btn ${confirmBtnClass}" type="button" id="modal-confirm-btn">
                <i class="fas fa-check"></i> ${confirmText}
            </button>
        </div>
    `;
    
    overlay.style.display = 'flex';
    
    requestAnimationFrame(() => {
        overlay.classList.add('active');
    });
    
    document.body.style.overflow = 'hidden';
    
    bindModalEvents();
}

function bindModalEvents() {
    const closeBtn = document.getElementById('modal-close-btn');
    const cancelBtn = document.getElementById('modal-cancel-btn');
    const confirmBtn = document.getElementById('modal-confirm-btn');
    const overlay = document.getElementById('modal-overlay');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            forceCloseModal();
        });
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            forceCloseModal();
        });
    }
    
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (this.disabled) return;
            this.disabled = true;
            this.style.opacity = '0.7';
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري...';
            
            if (currentModalCallback) {
                const result = currentModalCallback();
                if (result !== false) {
                    forceCloseModal();
                } else {
                    this.disabled = false;
                    this.style.opacity = '1';
                    this.innerHTML = `<i class="fas fa-check"></i> ${this.textContent.replace('جاري...', '').trim()}`;
                }
            } else {
                forceCloseModal();
            }
        });
    }
    
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            forceCloseModal();
        }
    });
    
    document.addEventListener('keydown', handleEscapeKey);
}

function handleEscapeKey(e) {
    if (e.key === 'Escape' && modalOpen) {
        forceCloseModal();
    }
}

function showSuccessModal(title, content, onClose) {
    if (modalOpen) {
        forceCloseModal();
        setTimeout(() => {
            openSuccessModal(title, content, onClose);
        }, 300);
        return;
    }
    
    openSuccessModal(title, content, onClose);
}

function openSuccessModal(title, content, onClose) {
    const overlay = document.getElementById('modal-overlay');
    const modalContent = document.getElementById('modal-content');
    
    if (!overlay || !modalContent) return;
    
    modalOpen = true;
    modalClosing = false;
    
    modalContent.innerHTML = `
        <div class="modal-body" style="text-align: center; padding: 24px;">
            <div class="modal-success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h3 class="modal-success-title">${title}</h3>
            <div style="margin-bottom: 16px;">
                ${content}
            </div>
            <button class="modal-btn modal-btn-success" type="button" id="modal-success-btn" style="min-width: 120px;">
                <i class="fas fa-check"></i> حسناً
            </button>
        </div>
    `;
    
    overlay.style.display = 'flex';
    requestAnimationFrame(() => {
        overlay.classList.add('active');
    });
    document.body.style.overflow = 'hidden';
    
    const successBtn = document.getElementById('modal-success-btn');
    if (successBtn) {
        successBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            forceCloseModal();
            if (onClose) setTimeout(onClose, 300);
        });
    }
    
    document.addEventListener('keydown', handleEscapeKey);
    
    setTimeout(() => {
        if (modalOpen) {
            forceCloseModal();
            if (onClose) setTimeout(onClose, 300);
        }
    }, 5000);
}

function forceCloseModal() {
    const overlay = document.getElementById('modal-overlay');
    
    if (!overlay) return;
    
    modalOpen = false;
    modalClosing = true;
    currentModalCallback = null;
    
    document.removeEventListener('keydown', handleEscapeKey);
    
    overlay.classList.remove('active');
    
    setTimeout(() => {
        overlay.style.display = 'none';
        document.body.style.overflow = '';
        modalClosing = false;
        
        const modalContent = document.getElementById('modal-content');
        if (modalContent) {
            modalContent.innerHTML = '';
        }
    }, 300);
}

// ==========================================
// نظام الإشعارات
// ==========================================
function showNotification(message, type = 'info') {
    const container = document.getElementById('notification-container');
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-times-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    const titles = {
        success: 'نجاح',
        error: 'خطأ',
        warning: 'تنبيه',
        info: 'معلومة'
    };
    
    const toastId = 'toast-' + Date.now();
    
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `notification-toast notification-${type}`;
    toast.innerHTML = `
        <div class="notification-icon">
            <i class="fas ${icons[type]}"></i>
        </div>
        <div class="notification-content">
            <div class="notification-title">${titles[type]}</div>
            <div class="notification-message">${message}</div>
        </div>
        <button class="notification-close" type="button" onclick="removeNotification('${toastId}')" aria-label="إغلاق">
            <i class="fas fa-times"></i>
        </button>
        <div class="notification-progress"></div>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        removeNotification(toastId);
    }, 4000);
}

function removeNotification(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.classList.add('hiding');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }
}

// ==========================================
// دوال المساعدة
// ==========================================
function updateCounts() {
    const activeRequests = allRadiologyRequests.filter(r => r.status === 'معلق' || r.status === 'قيد التنفيذ').length;
    document.getElementById('radiology-count').textContent = activeRequests + ' طلبات نشطة';
    document.getElementById('rejected-count').textContent = allRejectedCases.filter(c => !c.confirmed).length + ' حالات';
}

function showStatDetail(title, value) {
    showConfirmModal(
        title,
        `<div style="text-align: center; padding: 16px;">
            <div style="font-size: var(--text-2xl); font-weight: 700; color: var(--primary); margin-bottom: 8px;">${value}</div>
            <p style="color: var(--gray); font-size: var(--text-sm);">إجمالي ${title}</p>
        </div>`,
        () => { return true; },
        'إغلاق',
        'secondary'
    );
}

function viewCourse(courseId) {
    // لا يحدث شيء عند النقر
}

// ==========================================
// INIT
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    const scrollContainer = document.querySelector('.scroll-container');
    const progressBar = document.getElementById('stats-progress');
    
    if (scrollContainer && progressBar) {
        scrollContainer.addEventListener('scroll', () => {
            const max = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            const current = scrollContainer.scrollLeft;
            progressBar.style.width = max > 0 ? (current / max * 100) + '%' : '0%';
        });
    }
    
    // تهيئة الجداول
    renderTable('courses');
    renderTable('rejected');
    renderTable('radiology');
    updateCounts();
    
    // إشعار ترحيبي
    setTimeout(() => {
        showNotification('مرحباً بك في النظام الطبي', 'info');
    }, 1000);
});

</script>

@endsection

