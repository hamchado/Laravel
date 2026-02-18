@extends('layouts.tash')

@section('title', 'سجل الحالات - المشرف السريري')
@section('page_title', 'سجل الحالات')

@section('content')
<!-- زر مسح QR -->
<div style="margin-bottom: 16px;">
    <button onclick="openQrScanner()" style="width: 100%; padding: 14px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; border-radius: 14px; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 16px; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 16px rgba(99,102,241,0.3);">
        <i class="fas fa-qrcode" style="font-size: 22px;"></i>
        مسح رمز QR لتقييم حالة
    </button>
</div>

<!-- شريط البحث -->
<div class="input-container" style="position: relative; overflow: hidden; margin-bottom: 16px;">
    <div style="position: relative;">
        <input type="text" class="text-input" placeholder="ابحث برقم الملف أو اسم المريض أو الطالب..." id="searchCases" style="padding-right: 40px;">
        <i class="fas fa-search" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
    </div>
</div>

<!-- فلاتر الحالة -->
<div class="input-container" style="padding: 16px;">
    <div style="display: flex; gap: 10px; overflow-x: auto; padding: 4px;">
        <button class="filter-chip active" data-status="all" onclick="filterCases('all', this)">
            <i class="fas fa-list"></i> الكل (<span id="countAll">0</span>)
        </button>
        <button class="filter-chip" data-status="pending" onclick="filterCases('pending', this)">
            <i class="fas fa-hourglass-half"></i> بانتظار (<span id="countPending">0</span>)
        </button>
        <button class="filter-chip" data-status="accepted" onclick="filterCases('accepted', this)">
            <i class="fas fa-check"></i> مقبولة (<span id="countAccepted">0</span>)
        </button>
        <button class="filter-chip" data-status="completed" onclick="filterCases('completed', this)">
            <i class="fas fa-check-double"></i> مكتملة (<span id="countCompleted">0</span>)
        </button>
        <button class="filter-chip" data-status="rejected" onclick="filterCases('rejected', this)">
            <i class="fas fa-times"></i> مرفوضة (<span id="countRejected">0</span>)
        </button>
    </div>
</div>

<!-- قائمة الحالات -->
<div id="casesList" style="display: flex; flex-direction: column; gap: 12px; margin-top: 16px;">
    <div style="text-align: center; padding: 40px; color: #9ca3af;">
        <i class="fas fa-spinner fa-spin" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
        جاري تحميل الحالات...
    </div>
</div>

<!-- مودال تفاصيل الحالة + التقييم -->
<div id="caseDetailModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 2000; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 20px; width: 94%; max-width: 450px; max-height: 85vh; overflow-y: auto; box-shadow: 0 25px 70px rgba(0,0,0,0.3); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 18px; font-weight: 700; color: var(--dark); margin: 0;">
                <i class="fas fa-file-medical" style="color: var(--primary); margin-left: 6px;"></i>
                تفاصيل الحالة
            </h3>
            <button onclick="closeCaseDetail()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="caseDetailContent">
            <!-- يتم ملؤه ديناميكياً -->
        </div>

        <!-- قسم التقييم -->
        <div id="evaluationSection" style="display: none; margin-top: 20px; padding-top: 16px; border-top: 2px solid #e5e7eb;">
            <h4 style="font-size: 15px; font-weight: 700; color: var(--dark); margin-bottom: 12px;">
                <i class="fas fa-star" style="color: #f59e0b; margin-left: 6px;"></i>
                تقييم الحالة
            </h4>
            <div style="margin-bottom: 12px;">
                <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">المرحلة:</label>
                <select id="evalStage" style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: inherit; font-size: 14px;">
                    <option value="">-- اختر مرحلة التقييم --</option>
                </select>
            </div>
            <div style="margin-bottom: 12px;">
                <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">الدرجة:</label>
                <select id="evalGrade" style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: inherit; font-size: 14px;">
                    <option value="excellent">ممتاز</option>
                    <option value="good">جيد</option>
                    <option value="acceptable">مقبول</option>
                    <option value="fail">راسب</option>
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">ملاحظات:</label>
                <textarea id="evalNotes" rows="3" style="width: 100%; padding: 10px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: inherit; font-size: 14px; resize: vertical; box-sizing: border-box;" placeholder="ملاحظات اختيارية..."></textarea>
            </div>
            <button onclick="submitEvaluation()" id="submitEvalBtn" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 15px;">
                <i class="fas fa-check-circle" style="margin-left: 6px;"></i>
                حفظ التقييم
            </button>
        </div>
    </div>
</div>

<!-- مودال ماسح QR -->
<div id="qrScannerModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.85); z-index: 3000; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 20px; width: 94%; max-width: 420px; overflow: hidden; box-shadow: 0 25px 70px rgba(0,0,0,0.4);">
        <!-- رأس -->
        <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 20px; text-align: center;">
            <div style="width: 56px; height: 56px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                <i class="fas fa-qrcode" style="font-size: 24px; color: white;"></i>
            </div>
            <h3 style="color: white; font-size: 18px; font-weight: 700; margin: 0 0 4px;">مسح رمز QR</h3>
            <p style="color: rgba(255,255,255,0.8); font-size: 13px; margin: 0;">وجّه الكاميرا نحو رمز QR الخاص بالحالة</p>
        </div>

        <!-- منطقة الكاميرا -->
        <div style="padding: 20px;">
            <div id="qrReaderContainer" style="width: 100%; border-radius: 12px; overflow: hidden; border: 3px solid var(--primary); position: relative;">
                <video id="qrVideo" style="width: 100%; display: block;" playsinline></video>
                <canvas id="qrCanvas" style="display: none;"></canvas>
                <!-- خط المسح -->
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, var(--primary), transparent); animation: scanLine 2s infinite;"></div>
            </div>

            <!-- حقل إدخال يدوي -->
            <div style="margin-top: 16px;">
                <div style="text-align: center; color: #9ca3af; font-size: 13px; margin-bottom: 12px;">
                    <span style="background: white; padding: 0 12px;">أو أدخل رقم الحالة يدوياً</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <input type="number" id="manualCaseId" placeholder="رقم الحالة" style="flex: 1; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: inherit; font-size: 14px; text-align: center;">
                    <button onclick="lookupManualCase()" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: 12px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: inherit;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- زر الإغلاق -->
        <div style="padding: 0 20px 20px;">
            <button onclick="closeQrScanner()" style="width: 100%; padding: 14px; background: #f3f4f6; color: #6b7280; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 15px;">
                <i class="fas fa-times" style="margin-left: 6px;"></i>
                إغلاق
            </button>
        </div>
    </div>
</div>

<style>
.filter-chip { background: white; border: 2px solid #e5e7eb; color: var(--dark); padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer; white-space: nowrap; font-family: inherit; transition: all 0.2s; }
.filter-chip.active { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border-color: transparent; }
.filter-chip i { margin-left: 4px; }
.case-card { background: white; border: 1px solid #e5e7eb; border-radius: 16px; padding: 16px; cursor: pointer; transition: all 0.2s; }
.case-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); transform: translateY(-1px); }
@keyframes scanLine { 0% { top: 0; } 50% { top: calc(100% - 3px); } 100% { top: 0; } }
</style>

<script>
var cases = [];
var currentFilter = 'all';
var selectedCaseId = null;
var qrStream = null;
var qrScanInterval = null;

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
    loadCases();
    document.getElementById('searchCases').addEventListener('input', function() {
        renderCases();
    });
});

function loadCases() {
    apiFetch('/api/cases').then(function(data) {
        if (data && data.success) {
            cases = data.cases || [];
            updateCounts();
            renderCases();
        }
    }).catch(function(err) {
        console.error('Error loading cases:', err);
        document.getElementById('casesList').innerHTML = '<div style="text-align: center; padding: 40px; color: #ef4444;">حدث خطأ في تحميل الحالات</div>';
    });
}

function updateCounts() {
    document.getElementById('countAll').textContent = cases.length;
    document.getElementById('countPending').textContent = cases.filter(function(c) { return c.status === 'pending'; }).length;
    document.getElementById('countAccepted').textContent = cases.filter(function(c) { return c.status === 'accepted' || c.status === 'in_progress'; }).length;
    document.getElementById('countCompleted').textContent = cases.filter(function(c) { return c.status === 'completed'; }).length;
    document.getElementById('countRejected').textContent = cases.filter(function(c) { return c.status === 'rejected'; }).length;
}

function filterCases(status, btn) {
    currentFilter = status;
    document.querySelectorAll('.filter-chip').forEach(function(c) { c.classList.remove('active'); });
    if (btn) btn.classList.add('active');
    renderCases();
}

function renderCases() {
    var container = document.getElementById('casesList');
    var search = (document.getElementById('searchCases')?.value || '').toLowerCase();

    var filtered = cases.filter(function(c) {
        if (currentFilter !== 'all') {
            if (currentFilter === 'accepted' && c.status !== 'accepted' && c.status !== 'in_progress') return false;
            else if (currentFilter !== 'accepted' && c.status !== currentFilter) return false;
        }
        if (search) {
            var text = (c.patient?.full_name || '') + ' ' + (c.patient?.record_number || '') + ' ' + (c.treatment_label || '') + ' ' + (c.user?.name || '') + ' ' + (c.user?.student_id || '');
            if (!text.toLowerCase().includes(search)) return false;
        }
        return true;
    });

    if (filtered.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-inbox" style="font-size: 40px; margin-bottom: 12px; opacity: 0.3; display: block;"></i>لا توجد حالات</div>';
        return;
    }

    container.innerHTML = '';
    filtered.forEach(function(c) {
        var statusColors = { pending: '#f59e0b', accepted: '#3b82f6', in_progress: '#6366f1', completed: '#10b981', rejected: '#ef4444' };
        var statusLabels = { pending: 'بانتظار القبول', accepted: 'مقبولة', in_progress: 'قيد الإنجاز', completed: 'مكتملة', rejected: 'مرفوضة' };
        var statusIcons = { pending: 'fa-hourglass-half', accepted: 'fa-check', in_progress: 'fa-spinner', completed: 'fa-check-double', rejected: 'fa-times' };

        var color = statusColors[c.status] || '#6b7280';
        var letter = (c.patient?.full_name || '?')[0];
        var date = c.created_at ? new Date(c.created_at).toLocaleDateString('ar-SA') : '';

        var evalBadge = '';
        if (c.evaluation_count > 0) {
            var totalStages = 3;
            evalBadge = '<span style="background: rgba(16,185,129,0.1); color: #10b981; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;"><i class="fas fa-star" style="margin-left: 3px;"></i>' + c.evaluation_count + '/' + totalStages + '</span>';
        }

        var toothBadge = c.tooth_number ? ' | سن ' + c.tooth_number : '';

        var card = document.createElement('div');
        card.className = 'case-card';
        card.onclick = function() { openCaseDetail(c.id); };
        card.innerHTML = '<div style="display: flex; align-items: center; gap: 12px;">' +
            '<div style="width: 48px; height: 48px; background: linear-gradient(135deg, ' + color + ', ' + color + '99); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; flex-shrink: 0;">' + letter + '</div>' +
            '<div style="flex: 1; min-width: 0;">' +
                '<div style="font-size: 15px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">' + (c.patient?.full_name || 'غير معروف') + '</div>' +
                '<div style="font-size: 12px; color: #6b7280; margin-bottom: 6px;"><i class="fas fa-hashtag" style="margin-left: 4px;"></i>' + (c.patient?.record_number || '') + ' | ' + (c.treatment_label || c.treatment_type || '') + toothBadge + '</div>' +
                '<div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">' +
                    '<span style="background: ' + color + '15; color: ' + color + '; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;"><i class="fas ' + (statusIcons[c.status] || 'fa-circle') + '" style="margin-left: 4px;"></i>' + (statusLabels[c.status] || c.status) + '</span>' +
                    '<span style="background: rgba(99,102,241,0.1); color: #6366f1; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">' + (c.course?.code || '') + '</span>' +
                    '<span style="font-size: 11px; color: #9ca3af;">' + date + '</span>' +
                    evalBadge +
                    (c.user ? '<span style="font-size: 11px; color: #6b7280;"><i class="fas fa-user-graduate" style="margin-left: 3px;"></i>' + c.user.name + '</span>' : '') +
                '</div>' +
            '</div>' +
            '<i class="fas fa-chevron-left" style="color: #d1d5db; flex-shrink: 0;"></i>' +
        '</div>';

        container.appendChild(card);
    });
}

function openCaseDetail(caseId) {
    selectedCaseId = caseId;
    apiFetch('/api/cases/' + caseId).then(function(data) {
        if (!data || !data.success) return;
        renderCaseDetail(data.case);
    });
}

function renderCaseDetail(c) {
    var content = document.getElementById('caseDetailContent');
    var statusLabels = { pending: 'بانتظار القبول', accepted: 'مقبولة', in_progress: 'قيد الإنجاز', completed: 'مكتملة', rejected: 'مرفوضة' };
    var statusColors = { pending: '#f59e0b', accepted: '#3b82f6', in_progress: '#6366f1', completed: '#10b981', rejected: '#ef4444' };

    var totalStages = (c.course?.evaluation_stages && c.course.evaluation_stages.length) || 3;

    content.innerHTML = '<div style="background: #f9fafb; border-radius: 12px; padding: 16px; margin-bottom: 16px;">' +
        '<div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><span style="color: #6b7280;">المريض:</span><span style="font-weight: 700;">' + (c.patient?.full_name || '') + '</span></div>' +
        '<div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><span style="color: #6b7280;">رقم السجل:</span><span style="font-weight: 700;">' + (c.patient?.record_number || '') + '</span></div>' +
        '<div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><span style="color: #6b7280;">المعالجة:</span><span style="font-weight: 700;">' + (c.treatment_label || c.treatment_type || '') + '</span></div>' +
        (c.tooth_number ? '<div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><span style="color: #6b7280;">رقم السن:</span><span style="font-weight: 700; color: #3b82f6;">' + c.tooth_number + '</span></div>' : '') +
        '<div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><span style="color: #6b7280;">المقرر:</span><span style="font-weight: 700;">' + (c.course?.name || '') + '</span></div>' +
        '<div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><span style="color: #6b7280;">الطالب:</span><span style="font-weight: 700;">' + (c.user?.name || '') + ' (' + (c.user?.student_id || '') + ')</span></div>' +
        '<div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb;"><span style="color: #6b7280;">الحالة:</span><span style="font-weight: 700; color: ' + (statusColors[c.status] || '#6b7280') + ';">' + (statusLabels[c.status] || c.status) + '</span></div>' +
        '<div style="display: flex; justify-content: space-between; padding: 8px 0;"><span style="color: #6b7280;">التقييمات:</span><span style="font-weight: 700;">' + (c.evaluation_count || 0) + '/' + totalStages + '</span></div>' +
    '</div>';

    // عرض التقييمات السابقة
    if (c.evaluations && c.evaluations.length > 0) {
        content.innerHTML += '<h4 style="font-size: 14px; font-weight: 700; margin-bottom: 8px;"><i class="fas fa-history" style="color: var(--primary); margin-left: 6px;"></i>التقييمات السابقة</h4>';
        var evalsHtml = '';
        c.evaluations.forEach(function(ev) {
            var gradeColors = { excellent: '#10b981', good: '#3b82f6', acceptable: '#f59e0b', fail: '#ef4444' };
            var gradeLabels = { excellent: 'ممتاز', good: 'جيد', acceptable: 'مقبول', fail: 'راسب' };
            evalsHtml += '<div style="background: #f9fafb; border-radius: 8px; padding: 10px; margin-bottom: 8px; border-right: 3px solid ' + (gradeColors[ev.grade] || '#6b7280') + ';">' +
                '<div style="display: flex; justify-content: space-between;"><span style="font-weight: 700; font-size: 13px;">المرحلة ' + ev.stage + ': ' + (ev.stage_name || '') + '</span><span style="color: ' + (gradeColors[ev.grade] || '#6b7280') + '; font-weight: 700; font-size: 13px;">' + (gradeLabels[ev.grade] || ev.grade) + '</span></div>' +
                (ev.notes ? '<div style="font-size: 12px; color: #6b7280; margin-top: 4px;">' + ev.notes + '</div>' : '') +
                '<div style="font-size: 11px; color: #9ca3af; margin-top: 4px;">' + (ev.evaluator?.name || '') + ' - ' + (ev.evaluated_at ? new Date(ev.evaluated_at).toLocaleDateString('ar-SA') : '') + '</div>' +
            '</div>';
        });
        content.innerHTML += evalsHtml;
    }

    // إظهار قسم التقييم لأي حالة لم تكتمل ولم ترفض
    var evalSection = document.getElementById('evaluationSection');
    if (c.status !== 'completed' && c.status !== 'rejected' && (c.evaluation_count || 0) < totalStages) {
        evalSection.style.display = 'block';
        var stageSelect = document.getElementById('evalStage');
        stageSelect.innerHTML = '<option value="">-- اختر مرحلة التقييم --</option>';
        if (c.course?.evaluation_stages && c.course.evaluation_stages.length > 0) {
            c.course.evaluation_stages.forEach(function(stage) {
                var done = c.evaluations?.some(function(e) { return e.stage === stage.stage_number; });
                if (!done) {
                    stageSelect.innerHTML += '<option value="' + stage.stage_number + '" data-name="' + stage.stage_name + '">' + stage.stage_name + ' (المرحلة ' + stage.stage_number + ')</option>';
                }
            });
        } else {
            var nextStage = (c.evaluation_count || 0) + 1;
            for (var i = nextStage; i <= 3; i++) {
                stageSelect.innerHTML += '<option value="' + i + '">المرحلة ' + i + '</option>';
            }
        }
        // Reset form
        document.getElementById('evalGrade').value = 'excellent';
        document.getElementById('evalNotes').value = '';
    } else {
        evalSection.style.display = 'none';
    }

    document.getElementById('caseDetailModal').style.display = 'block';
}

function closeCaseDetail() {
    document.getElementById('caseDetailModal').style.display = 'none';
    selectedCaseId = null;
}

function submitEvaluation() {
    if (!selectedCaseId) return;
    var stageSelect = document.getElementById('evalStage');
    var stage = stageSelect.value;
    var grade = document.getElementById('evalGrade').value;
    var notes = document.getElementById('evalNotes').value;

    if (!stage) {
        showToast('الرجاء اختيار مرحلة التقييم', 'error');
        return;
    }

    var stageName = stageSelect.options[stageSelect.selectedIndex].getAttribute('data-name') || '';

    var btn = document.getElementById('submitEvalBtn');
    btn.disabled = true;

    apiFetch('/api/cases/' + selectedCaseId + '/evaluate', {
        method: 'POST',
        body: JSON.stringify({ stage: parseInt(stage), stage_name: stageName, grade: grade, notes: notes })
    }).then(function(data) {
        if (data && data.success) {
            showToast('تم حفظ التقييم بنجاح (' + data.evaluation_count + '/' + data.total_stages + ')', 'success');
            closeCaseDetail();
            loadCases();
        } else {
            showToast(data?.message || 'حدث خطأ', 'error');
        }
    }).catch(function(err) {
        showToast('حدث خطأ في الاتصال', 'error');
    }).finally(function() {
        btn.disabled = false;
    });
}

// ========== QR Scanner ==========
function openQrScanner() {
    document.getElementById('qrScannerModal').style.display = 'block';
    startCamera();
}

function closeQrScanner() {
    document.getElementById('qrScannerModal').style.display = 'none';
    stopCamera();
}

function startCamera() {
    var video = document.getElementById('qrVideo');
    navigator.mediaDevices.getUserMedia({
        video: { facingMode: 'environment', width: { ideal: 640 }, height: { ideal: 480 } }
    }).then(function(stream) {
        qrStream = stream;
        video.srcObject = stream;
        video.play();
        // Start scanning frames
        qrScanInterval = setInterval(scanQrFrame, 500);
    }).catch(function(err) {
        console.error('Camera error:', err);
        showToast('لا يمكن الوصول للكاميرا - استخدم الإدخال اليدوي', 'warning');
    });
}

function stopCamera() {
    if (qrScanInterval) {
        clearInterval(qrScanInterval);
        qrScanInterval = null;
    }
    if (qrStream) {
        qrStream.getTracks().forEach(function(track) { track.stop(); });
        qrStream = null;
    }
    var video = document.getElementById('qrVideo');
    video.srcObject = null;
}

function scanQrFrame() {
    var video = document.getElementById('qrVideo');
    var canvas = document.getElementById('qrCanvas');
    if (!video || video.readyState !== video.HAVE_ENOUGH_DATA) return;

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    var ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);
    var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

    // Use jsQR if available
    if (typeof jsQR !== 'undefined') {
        var code = jsQR(imageData.data, imageData.width, imageData.height);
        if (code && code.data) {
            handleQrResult(code.data);
        }
    }
}

function handleQrResult(qrData) {
    stopCamera();
    showToast('تم مسح QR بنجاح، جاري تحميل الحالة...', 'info');

    // Try to decode base64 and get case_id
    try {
        var decoded = JSON.parse(atob(qrData));
        if (decoded && decoded.case_id) {
            closeQrScanner();
            selectedCaseId = decoded.case_id;
            // Open case detail directly
            apiFetch('/api/cases/' + decoded.case_id).then(function(data) {
                if (data && data.success) {
                    renderCaseDetail(data.case);
                } else {
                    showToast('لم يتم العثور على الحالة', 'error');
                }
            });
            return;
        }
    } catch(e) {}

    // Fallback: send to lookup API
    apiFetch('/api/evaluations/lookup-qr', {
        method: 'POST',
        body: JSON.stringify({ qr_data: qrData })
    }).then(function(data) {
        if (data && data.success) {
            closeQrScanner();
            selectedCaseId = data.case.id;
            renderCaseDetail(data.case);
        } else {
            showToast(data?.message || 'رمز QR غير صالح', 'error');
            startCamera(); // Resume scanning
        }
    });
}

function lookupManualCase() {
    var caseId = document.getElementById('manualCaseId').value;
    if (!caseId) {
        showToast('أدخل رقم الحالة', 'warning');
        return;
    }

    closeQrScanner();
    selectedCaseId = parseInt(caseId);

    apiFetch('/api/cases/' + caseId).then(function(data) {
        if (data && data.success) {
            renderCaseDetail(data.case);
        } else {
            showToast('لم يتم العثور على الحالة رقم ' + caseId, 'error');
        }
    }).catch(function() {
        showToast('حدث خطأ في الاتصال', 'error');
    });
}

function showToast(message, type) {
    type = type || 'info';
    var existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();
    var colors = { success: 'linear-gradient(135deg, #10b981, #059669)', error: 'linear-gradient(135deg, #ef4444, #dc2626)', info: 'linear-gradient(135deg, #3b82f6, #2563eb)', warning: 'linear-gradient(135deg, #f59e0b, #d97706)' };
    var toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = 'position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: ' + (colors[type] || colors.info) + '; color: white; padding: 14px 24px; border-radius: 12px; font-size: 14px; font-weight: 600; z-index: 100000; box-shadow: 0 10px 30px rgba(0,0,0,0.2); min-width: 280px; text-align: center; font-family: inherit;';
    toast.innerHTML = '<i class="fas fa-' + (type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle') + '" style="margin-left: 8px;"></i>' + message;
    document.body.appendChild(toast);
    setTimeout(function() { toast.remove(); }, 3000);
}

// إغلاق المودال عند النقر خارجه
document.addEventListener('click', function(e) {
    if (e.target.id === 'caseDetailModal') closeCaseDetail();
    if (e.target.id === 'qrScannerModal') closeQrScanner();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
@endsection
