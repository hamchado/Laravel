<!-- قسم الأعمال والحالات -->
<div class="tab-content" id="worksContent">

    <!-- العنوان -->
    <div class="section-title-all">
        <i class="fas fa-clipboard-list"></i>
        <span>الأعمال والحالات</span>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="works-stats-row" id="worksStatsRow">
        <div class="works-stat-card">
            <div class="works-stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                <i class="fas fa-file-medical"></i>
            </div>
            <div class="works-stat-info">
                <span class="works-stat-number" id="totalWorksCount">0</span>
                <span class="works-stat-label">إجمالي الحالات</span>
            </div>
        </div>
        <div class="works-stat-card">
            <div class="works-stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="works-stat-info">
                <span class="works-stat-number" id="completedWorksCount">0</span>
                <span class="works-stat-label">مكتملة</span>
            </div>
        </div>
        <div class="works-stat-card">
            <div class="works-stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="works-stat-info">
                <span class="works-stat-number" id="pendingWorksCount">0</span>
                <span class="works-stat-label">قيد المعالجة</span>
            </div>
        </div>
        <div class="works-stat-card">
            <div class="works-stat-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                <i class="fas fa-snowflake"></i>
            </div>
            <div class="works-stat-info">
                <span class="works-stat-number" id="frozenWorksCount">0</span>
                <span class="works-stat-label">محجوزة مؤقتاً</span>
            </div>
        </div>
    </div>

    <!-- فلاتر التصفية -->
    <div class="filters-container">
        <button class="filter-btn active" data-filter="all" onclick="filterWorks('all', this)">
            الكل
        </button>
        <button class="filter-btn" data-filter="completed" onclick="filterWorks('completed', this)">
            مكتملة
        </button>
        <button class="filter-btn" data-filter="pending" onclick="filterWorks('pending', this)">
            قيد المعالجة
        </button>
        <button class="filter-btn" data-filter="frozen" onclick="filterWorks('frozen', this)">
            محجوزة
        </button>
    </div>

    <!-- قائمة الأعمال -->
    <div class="works-list" id="worksList">
        <!-- يتم ملؤها بواسطة JavaScript -->
    </div>

</div>

<script>
// ========== بيانات الأعمال من API ==========
var worksData = [];
var currentWorksFilter = 'all';

function apiFetchWorks(url) {
    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    return fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    }).then(function(res) {
        if (res.status === 401) {
            window.location.href = '/login';
            throw new Error('Unauthorized');
        }
        return res.json();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    loadWorksData();
});

function loadWorksData() {
    var container = document.getElementById('worksList');
    if (container) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 12px;"></i><p>جاري تحميل البيانات...</p></div>';
    }

    // جلب الحجوزات والحالات من API
    Promise.all([
        apiFetchWorks('/api/reservations'),
        apiFetchWorks('/api/cases')
    ]).then(function(results) {
        var reservationsData = results[0];
        var casesData = results[1];

        worksData = [];

        // 1. إضافة الحجوزات (مؤقتة + مثبتة)
        if (reservationsData.success && reservationsData.reservations) {
            reservationsData.reservations.forEach(function(r) {
                var statusMap = {
                    'confirmed': 'completed',
                    'temporary': 'frozen',
                    'cancelled': null
                };
                var mappedStatus = statusMap[r.status];
                if (mappedStatus === null) return; // تجاهل الملغاة

                worksData.push({
                    id: 'res-' + r.id,
                    patientName: r.patient ? r.patient.full_name : '-',
                    patientRecord: r.patient ? r.patient.record_number : '-',
                    type: r.status === 'confirmed' ? 'حجز مثبت' : 'حجز مؤقت',
                    course: r.course ? r.course.name : '-',
                    session: r.course ? r.course.schedule : '-',
                    date: r.created_at ? new Date(r.created_at).toLocaleDateString('ar-SA') : '-',
                    status: mappedStatus
                });
            });
        }

        // 2. إضافة الحالات السريرية
        if (casesData.success && casesData.cases) {
            casesData.cases.forEach(function(c) {
                var caseStatus = 'pending';
                if (c.status === 'accepted') caseStatus = 'completed';
                else if (c.status === 'rejected') caseStatus = 'pending';

                worksData.push({
                    id: 'case-' + c.id,
                    patientName: c.patient ? c.patient.full_name : '-',
                    patientRecord: c.patient ? c.patient.record_number : '-',
                    type: (c.treatment_label || '-') + (c.tooth_number ? ' (سن ' + c.tooth_number + ')' : ''),
                    course: c.course ? c.course.name : '-',
                    session: '-',
                    date: c.created_at ? new Date(c.created_at).toLocaleDateString('ar-SA') : '-',
                    status: caseStatus
                });
            });
        }

        updateWorksStats();
        renderWorksList();
    }).catch(function(err) {
        console.error('Error loading works:', err);
        worksData = [];
        updateWorksStats();
        renderWorksList();
    });
}

function updateWorksStats() {
    var total = worksData.length;
    var completed = worksData.filter(function(w) { return w.status === 'completed'; }).length;
    var pending = worksData.filter(function(w) { return w.status === 'pending'; }).length;
    var frozen = worksData.filter(function(w) { return w.status === 'frozen'; }).length;

    var totalEl = document.getElementById('totalWorksCount');
    var completedEl = document.getElementById('completedWorksCount');
    var pendingEl = document.getElementById('pendingWorksCount');
    var frozenEl = document.getElementById('frozenWorksCount');

    if (totalEl) totalEl.textContent = total;
    if (completedEl) completedEl.textContent = completed;
    if (pendingEl) pendingEl.textContent = pending;
    if (frozenEl) frozenEl.textContent = frozen;
}

function filterWorks(filter, btn) {
    currentWorksFilter = filter;

    document.querySelectorAll('#worksContent .filter-btn').forEach(function(b) {
        b.classList.remove('active');
    });
    if (btn) btn.classList.add('active');

    renderWorksList();
}

function renderWorksList() {
    var container = document.getElementById('worksList');
    if (!container) return;

    var filtered = worksData;
    if (currentWorksFilter !== 'all') {
        filtered = worksData.filter(function(w) { return w.status === currentWorksFilter; });
    }

    if (filtered.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af;">' +
            '<i class="fas fa-clipboard" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>' +
            '<p>لا توجد أعمال ' + (currentWorksFilter !== 'all' ? 'بهذا التصنيف' : 'مسجلة بعد') + '</p>' +
            '<p style="font-size: 12px; margin-top: 8px;">قم بإضافة مرضى وحالات من الأقسام الأخرى</p>' +
            '</div>';
        return;
    }

    container.innerHTML = filtered.map(function(work, index) {
        var statusColors = {
            completed: { bg: '#dcfce7', color: '#166534', label: 'مكتمل', icon: 'fa-check-circle' },
            pending: { bg: '#fef3c7', color: '#92400e', label: 'قيد المعالجة', icon: 'fa-clock' },
            frozen: { bg: '#ede9fe', color: '#5b21b6', label: 'محجوز مؤقتاً', icon: 'fa-snowflake' }
        };
        var s = statusColors[work.status] || statusColors.pending;

        return '<div class="work-card" style="animation: fadeIn 0.3s ease forwards ' + (index * 0.05) + 's; opacity: 0;">' +
            '<div class="work-card-header">' +
                '<div class="work-patient-name">' +
                    '<i class="fas fa-user-injured" style="color: #6366f1; margin-left: 6px;"></i>' +
                    work.patientName +
                '</div>' +
                '<span class="work-status-badge" style="background: ' + s.bg + '; color: ' + s.color + ';">' +
                    '<i class="fas ' + s.icon + '"></i> ' + s.label +
                '</span>' +
            '</div>' +
            '<div class="work-card-body">' +
                '<div class="work-info-row">' +
                    '<span class="work-info-label"><i class="fas fa-hashtag"></i> السجل:</span>' +
                    '<span class="work-info-value">' + work.patientRecord + '</span>' +
                '</div>' +
                '<div class="work-info-row">' +
                    '<span class="work-info-label"><i class="fas fa-tooth"></i> النوع:</span>' +
                    '<span class="work-info-value">' + work.type + '</span>' +
                '</div>' +
                '<div class="work-info-row">' +
                    '<span class="work-info-label"><i class="fas fa-book"></i> المقرر:</span>' +
                    '<span class="work-info-value">' + work.course + '</span>' +
                '</div>' +
                '<div class="work-info-row">' +
                    '<span class="work-info-label"><i class="fas fa-calendar"></i> التاريخ:</span>' +
                    '<span class="work-info-value">' + work.date + '</span>' +
                '</div>' +
            '</div>' +
        '</div>';
    }).join('');
}
</script>

<style>
.works-stats-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 16px;
}

.works-stat-card {
    background: white;
    border-radius: 12px;
    padding: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid #f3f4f6;
}

.works-stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.works-stat-info {
    display: flex;
    flex-direction: column;
}

.works-stat-number {
    font-size: 20px;
    font-weight: 800;
    color: #1f2937;
    line-height: 1;
}

.works-stat-label {
    font-size: 11px;
    color: #6b7280;
    margin-top: 2px;
}

.works-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.work-card {
    background: white;
    border-radius: 14px;
    padding: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid #f3f4f6;
}

.work-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f3f4f6;
}

.work-patient-name {
    font-weight: 700;
    color: #1f2937;
    font-size: 14px;
    display: flex;
    align-items: center;
}

.work-status-badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
}

.work-card-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

.work-info-row {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.work-info-label {
    font-size: 11px;
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 4px;
}

.work-info-label i {
    font-size: 10px;
}

.work-info-value {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

@media (max-width: 400px) {
    .works-stats-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    .works-stat-card {
        padding: 10px;
    }
    .works-stat-number {
        font-size: 16px;
    }
    .work-card-body {
        grid-template-columns: 1fr;
    }
}
</style>
