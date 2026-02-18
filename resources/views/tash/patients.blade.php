@extends('layouts.tash')

@section('title', 'سجل المرضى - المشرف السريري')
@section('page_title', 'سجل المرضى')

@section('content')
<!-- شريط البحث -->
<div class="search-box" style="position: relative; margin-bottom: 16px;">
    <input type="text" class="text-input" placeholder="ابحث باسم المريض أو رقم الملف أو الهاتف..." id="searchPatients" style="padding-right: 40px;">
    <i class="fas fa-search" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
</div>

<!-- فلاتر -->
<div style="display: flex; gap: 10px; margin-bottom: 16px; overflow-x: auto; padding: 4px;">
    <button class="filter-chip active" onclick="filterPatients('all', this)"><i class="fas fa-users"></i> الكل (<span id="countAll">0</span>)</button>
    <button class="filter-chip" onclick="filterPatients('private', this)"><i class="fas fa-lock"></i> خاص (<span id="countPrivate">0</span>)</button>
    <button class="filter-chip" onclick="filterPatients('public', this)"><i class="fas fa-globe"></i> عام (<span id="countPublic">0</span>)</button>
</div>

<!-- إحصائيات -->
<div style="display: flex; gap: 10px; margin-bottom: 20px; overflow-x: auto; padding-bottom: 8px;">
    <div style="flex-shrink: 0; background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 14px 24px; border-radius: 14px; color: white; min-width: 110px; text-align: center;">
        <div style="font-size: 26px; font-weight: 800;" id="statTotal">0</div>
        <div style="font-size: 12px; opacity: 0.9;">إجمالي المرضى</div>
    </div>
    <div style="flex-shrink: 0; background: white; padding: 14px 24px; border-radius: 14px; border: 2px solid var(--secondary); min-width: 110px; text-align: center;">
        <div style="font-size: 26px; font-weight: 800; color: var(--secondary);" id="statPrivate">0</div>
        <div style="font-size: 12px; color: var(--gray);">خاص</div>
    </div>
    <div style="flex-shrink: 0; background: white; padding: 14px 24px; border-radius: 14px; border: 2px solid var(--accent); min-width: 110px; text-align: center;">
        <div style="font-size: 26px; font-weight: 800; color: var(--accent);" id="statPublic">0</div>
        <div style="font-size: 12px; color: var(--gray);">عام</div>
    </div>
</div>

<!-- قائمة المرضى -->
<div id="patientsList" style="display: flex; flex-direction: column; gap: 12px;">
    <div style="text-align: center; padding: 40px; color: #9ca3af;">
        <i class="fas fa-spinner fa-spin" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
        جاري تحميل المرضى...
    </div>
</div>

<style>
.filter-chip { background: white; border: 2px solid #e5e7eb; color: var(--dark); padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer; white-space: nowrap; font-family: inherit; transition: all 0.2s; }
.filter-chip.active { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border-color: transparent; }
.filter-chip i { margin-left: 4px; }
.patient-item { background: white; border: 1px solid #e5e7eb; border-radius: 16px; padding: 16px; cursor: pointer; transition: all 0.2s; }
.patient-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
</style>

<script>
var patients = [];
var currentFilter = 'all';

function apiFetch(url, options) {
    options = options || {};
    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    var defaults = {
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    };
    var merged = Object.assign({}, defaults, options);
    if (options.headers) merged.headers = Object.assign({}, defaults.headers, options.headers);
    return fetch(url, merged).then(function(res) {
        if (res.status === 401) { window.location.href = '/login'; return; }
        return res.json();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    loadPatients();
    document.getElementById('searchPatients').addEventListener('input', function() { renderPatients(); });
});

function loadPatients() {
    apiFetch('/api/patients').then(function(data) {
        if (data && data.success) {
            patients = data.patients || [];
            updateStats();
            renderPatients();
        }
    }).catch(function(err) {
        console.error('Error:', err);
        document.getElementById('patientsList').innerHTML = '<div style="text-align: center; padding: 40px; color: #ef4444;">حدث خطأ في تحميل البيانات</div>';
    });
}

function updateStats() {
    var prv = patients.filter(function(p) { return p.access_type === 'private'; }).length;
    var pub = patients.filter(function(p) { return p.access_type === 'public'; }).length;
    document.getElementById('statTotal').textContent = patients.length;
    document.getElementById('statPrivate').textContent = prv;
    document.getElementById('statPublic').textContent = pub;
    document.getElementById('countAll').textContent = patients.length;
    document.getElementById('countPrivate').textContent = prv;
    document.getElementById('countPublic').textContent = pub;
}

function filterPatients(filter, btn) {
    currentFilter = filter;
    document.querySelectorAll('.filter-chip').forEach(function(c) { c.classList.remove('active'); });
    if (btn) btn.classList.add('active');
    renderPatients();
}

function renderPatients() {
    var container = document.getElementById('patientsList');
    var search = (document.getElementById('searchPatients')?.value || '').toLowerCase();

    var filtered = patients.filter(function(p) {
        if (currentFilter !== 'all' && p.access_type !== currentFilter) return false;
        if (search) {
            var text = (p.full_name || '') + ' ' + (p.record_number || '') + ' ' + (p.phone || '');
            if (!text.toLowerCase().includes(search)) return false;
        }
        return true;
    });

    if (filtered.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-inbox" style="font-size: 40px; margin-bottom: 12px; opacity: 0.3; display: block;"></i>لا يوجد مرضى</div>';
        return;
    }

    container.innerHTML = '';
    filtered.forEach(function(p) {
        var letter = (p.full_name || '?')[0];
        var typeColor = p.access_type === 'private' ? '#6366f1' : '#10b981';
        var typeLabel = p.access_type === 'private' ? 'خاص' : 'عام';
        var typeIcon = p.access_type === 'private' ? 'fa-lock' : 'fa-globe';

        var card = document.createElement('div');
        card.className = 'patient-item';
        card.innerHTML = '<div style="display: flex; align-items: center; gap: 12px;">' +
            '<div style="width: 48px; height: 48px; background: linear-gradient(135deg, ' + typeColor + ', ' + typeColor + '99); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; flex-shrink: 0;">' + letter + '</div>' +
            '<div style="flex: 1; min-width: 0;">' +
                '<div style="font-size: 15px; font-weight: 700; color: #1f2937;">' + (p.full_name || '') + '</div>' +
                '<div style="font-size: 12px; color: #6b7280; margin: 4px 0;"><i class="fas fa-hashtag" style="margin-left: 4px;"></i>' + (p.record_number || '') + '</div>' +
                '<div style="display: flex; gap: 6px; flex-wrap: wrap;">' +
                    '<span style="background: ' + typeColor + '15; color: ' + typeColor + '; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;"><i class="fas ' + typeIcon + '" style="margin-left: 4px;"></i>' + typeLabel + '</span>' +
                    '<span style="font-size: 11px; color: #9ca3af;"><i class="fas fa-phone" style="margin-left: 4px;"></i>' + (p.phone || '') + '</span>' +
                    '<span style="font-size: 11px; color: #9ca3af;">' + (p.age || 0) + ' سنة</span>' +
                '</div>' +
            '</div>' +
        '</div>';
        container.appendChild(card);
    });
}
</script>
@endsection
