@extends('layouts.app')

@section('title', 'الصفحة الرئيسية')
@section('page_title', 'الرئيسية')

@section('content')
<div class="welcome-header" style="text-align: center; margin-bottom: clamp(16px, 4vw, 24px); padding: clamp(8px, 2vw, 10px) 0;">
    <h1 style="font-size: clamp(18px, 5vw, 24px); color: var(--dark); margin-bottom: clamp(6px, 2vw, 10px); font-weight: 700; letter-spacing: -0.5px;">مرحباً {{ Auth::user()->name }}</h1>
    <p style="color: var(--gray); font-size: clamp(12px, 3.5vw, 14px);">نظرة عامة على نشاطك اليومي</p>
</div>

<!-- شريط الإحصائيات -->
<div class="stats-section" style="margin-bottom: clamp(16px, 4vw, 20px);">
    <div class="section-title" style="margin-bottom: clamp(10px, 3vw, 12px);">
        <div style="display: flex; align-items: center; gap: clamp(8px, 2vw, 10px);">
            <div style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(236, 72, 153, 0.1));
                      border-radius: 10px; display: flex; align-items: center; justify-content: center;
                      box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15); flex-shrink: 0;">
                <i class="fas fa-chart-bar" style="color: var(--primary); font-size: clamp(14px, 3.5vw, 16px);"></i>
            </div>
            <span style="font-weight: 700; font-size: clamp(14px, 4vw, 16px);">الإحصائيات الحيوية</span>
        </div>
    </div>
    
    <div class="horizontal-scroll-container">
        <div class="horizontal-cards" style="display: flex; gap: 12px; overflow-x: auto; padding: 8px 4px 16px; scrollbar-width: none; -ms-overflow-style: none; scroll-behavior: smooth; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;">
            <!-- الحالات المنجزة -->
            <div class="horizontal-card" style="flex: 0 0 auto; width: clamp(140px, 40vw, 160px); min-width: clamp(140px, 40vw, 160px); background: white; border-radius: 16px; padding: clamp(16px, 4vw, 20px); border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 8px; scroll-snap-align: start; height: clamp(180px, 45vw, 200px);">
                <div style="width: clamp(48px, 12vw, 56px); height: clamp(48px, 12vw, 56px); background: rgba(79, 70, 229, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: clamp(20px, 5vw, 24px); flex-shrink: 0;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; color: var(--dark); margin: 0; line-height: 1.3;">الحالات المنجزة</h3>
                <p id="stat-completed" style="font-size: clamp(24px, 7vw, 28px); font-weight: 800; color: var(--primary); margin: 0; line-height: 1;">-</p>
            </div>

            <!-- الحالات قيد الإنجاز -->
            <div class="horizontal-card" style="flex: 0 0 auto; width: clamp(140px, 40vw, 160px); min-width: clamp(140px, 40vw, 160px); background: white; border-radius: 16px; padding: clamp(16px, 4vw, 20px); border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 8px; scroll-snap-align: start; height: clamp(180px, 45vw, 200px);">
                <div style="width: clamp(48px, 12vw, 56px); height: clamp(48px, 12vw, 56px); background: rgba(79, 70, 229, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: clamp(20px, 5vw, 24px); flex-shrink: 0;">
                    <i class="fas fa-spinner"></i>
                </div>
                <h3 style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; color: var(--dark); margin: 0; line-height: 1.3;">قيد الإنجاز</h3>
                <p id="stat-pending" style="font-size: clamp(24px, 7vw, 28px); font-weight: 800; color: var(--primary); margin: 0; line-height: 1;">-</p>
            </div>

            <!-- الحالات التي بحاجة للموافقة -->
            <div class="horizontal-card" style="flex: 0 0 auto; width: clamp(140px, 40vw, 160px); min-width: clamp(140px, 40vw, 160px); background: white; border-radius: 16px; padding: clamp(16px, 4vw, 20px); border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 8px; scroll-snap-align: start; height: clamp(180px, 45vw, 200px);">
                <div style="width: clamp(48px, 12vw, 56px); height: clamp(48px, 12vw, 56px); background: rgba(79, 70, 229, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: clamp(20px, 5vw, 24px); flex-shrink: 0;">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3 style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; color: var(--dark); margin: 0; line-height: 1.3;">بحاجة للموافقة</h3>
                <p id="stat-approval" style="font-size: clamp(24px, 7vw, 28px); font-weight: 800; color: var(--primary); margin: 0; line-height: 1;">-</p>
            </div>

            <!-- المرضى المعالجين -->
            <div class="horizontal-card" style="flex: 0 0 auto; width: clamp(140px, 40vw, 160px); min-width: clamp(140px, 40vw, 160px); background: white; border-radius: 16px; padding: clamp(16px, 4vw, 20px); border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 8px; scroll-snap-align: start; height: clamp(180px, 45vw, 200px);">
                <div style="width: clamp(48px, 12vw, 56px); height: clamp(48px, 12vw, 56px); background: rgba(79, 70, 229, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: clamp(20px, 5vw, 24px); flex-shrink: 0;">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3 style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; color: var(--dark); margin: 0; line-height: 1.3;">المرضى المعالجين</h3>
                <p id="stat-patients" style="font-size: clamp(24px, 7vw, 28px); font-weight: 800; color: var(--primary); margin: 0; line-height: 1;">-</p>
            </div>

            <!-- المواعيد اليوم -->
            <div class="horizontal-card" style="flex: 0 0 auto; width: clamp(140px, 40vw, 160px); min-width: clamp(140px, 40vw, 160px); background: white; border-radius: 16px; padding: clamp(16px, 4vw, 20px); border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 8px; scroll-snap-align: start; height: clamp(180px, 45vw, 200px);">
                <div style="width: clamp(48px, 12vw, 56px); height: clamp(48px, 12vw, 56px); background: rgba(79, 70, 229, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: clamp(20px, 5vw, 24px); flex-shrink: 0;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; color: var(--dark); margin: 0; line-height: 1.3;">المواعيد اليوم</h3>
                <p id="stat-appointments" style="font-size: clamp(24px, 7vw, 28px); font-weight: 800; color: var(--primary); margin: 0; line-height: 1;">-</p>
            </div>

            <!-- التقارير المنجزة -->
            <div class="horizontal-card" style="flex: 0 0 auto; width: clamp(140px, 40vw, 160px); min-width: clamp(140px, 40vw, 160px); background: white; border-radius: 16px; padding: clamp(16px, 4vw, 20px); border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 8px; scroll-snap-align: start; height: clamp(180px, 45vw, 200px);">
                <div style="width: clamp(48px, 12vw, 56px); height: clamp(48px, 12vw, 56px); background: rgba(79, 70, 229, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: clamp(20px, 5vw, 24px); flex-shrink: 0;">
                    <i class="fas fa-file-medical"></i>
                </div>
                <h3 style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; color: var(--dark); margin: 0; line-height: 1.3;">التقارير المنجزة</h3>
                <p id="stat-reports" style="font-size: clamp(24px, 7vw, 28px); font-weight: 800; color: var(--primary); margin: 0; line-height: 1;">-</p>
            </div>
        </div>
    </div>
</div>

<!-- خط فاصل -->
<div class="section-divider" style="margin: clamp(16px, 4vw, 20px) 0;"></div>

<!-- قائمة المقررات -->
<div class="courses-list-section" style="margin-bottom: 20px;">
    <div class="section-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: clamp(12px, 3vw, 16px);">
        <div style="display: flex; align-items: center; gap: clamp(8px, 2vw, 10px);">
            <div style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(79, 70, 229, 0.05));
                      border-radius: 10px; display: flex; align-items: center; justify-content: center;
                      box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15); flex-shrink: 0;">
                <i class="fas fa-book-medical" style="color: var(--primary); font-size: clamp(14px, 3.5vw, 16px);"></i>
            </div>
            <span style="font-weight: 700; font-size: clamp(15px, 4vw, 17px);">المقررات السريرية المسجلة</span>
        </div>
    </div>

    <!-- بطاقات المقررات - يتم تحميلها ديناميكياً -->
    <div id="coursesContainer" class="vertical-cards" style="display: flex; flex-direction: column; gap: clamp(10px, 3vw, 12px); margin-top: clamp(12px, 3vw, 16px);">
        <div style="text-align:center;padding:30px;color:var(--gray);">
            <i class="fas fa-spinner fa-spin" style="font-size:24px;margin-bottom:10px;display:block;"></i>
            جاري تحميل المقررات...
        </div>
    </div>
</div>

<!-- مودال الأعمال المطلوبة - خطوط أصغر جداً -->
<div id="courseWorksModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 2000; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 16px; padding: clamp(16px, 4vw, 20px); width: 94%; max-width: 480px; max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid rgba(79, 70, 229, 0.1); padding-bottom: 12px;">
            <h3 style="font-size: clamp(13px, 3.8vw, 15px); color: var(--dark); font-weight: 700; margin: 0; line-height: 1.4; text-align: right; flex: 1;">
                <i class="fas fa-tasks" style="color: var(--primary); margin-left: 6px; font-size: 0.85em;"></i>
                الأعمال المطلوبة في مقرر<br>
                <span id="modalCourseName" style="color: var(--primary); font-size: clamp(12px, 3.5vw, 14px); display: inline-block; margin-top: 4px;"></span>
            </h3>
            <button onclick="closeCourseWorksModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 16px; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; margin-right: 8px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 300px;">
                <thead>
                    <tr style="background: rgba(79, 70, 229, 0.05);">
                        <th style="padding: 8px 4px; text-align: right; font-size: clamp(10px, 3vw, 12px); font-weight: 700; color: var(--dark); border-bottom: 1px solid rgba(79, 70, 229, 0.15);">اسم الحالة / العمل</th>
                        <th style="padding: 8px 4px; text-align: center; font-size: clamp(10px, 3vw, 12px); font-weight: 700; color: var(--dark); border-bottom: 1px solid rgba(79, 70, 229, 0.15); width: 50px;">المطلوب</th>
                        <th style="padding: 8px 4px; text-align: center; font-size: clamp(10px, 3vw, 12px); font-weight: 700; color: var(--dark); border-bottom: 1px solid rgba(79, 70, 229, 0.15); width: 50px;">المنجز</th>
                        <th style="padding: 8px 4px; text-align: center; font-size: clamp(10px, 3vw, 12px); font-weight: 700; color: var(--dark); border-bottom: 1px solid rgba(79, 70, 229, 0.15); width: 60px;">قيد الإنجاز</th>
                    </tr>
                </thead>
                <tbody id="worksTableBody">
                    <!-- يتم ملؤه ديناميكياً -->
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 14px; padding: 8px 10px; background: rgba(79, 70, 229, 0.03); border-radius: 8px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 4px;">
            <span style="font-size: clamp(11px, 3.2vw, 12px); color: var(--gray); font-weight: 600;">الإجمالي:</span>
            <div style="display: flex; gap: clamp(8px, 2vw, 12px); font-size: clamp(11px, 3.2vw, 12px); flex-wrap: wrap;">
                <span style="color: var(--primary); font-weight: 700;"><span id="totalRequired">0</span> مطلوب</span>
                <span style="color: var(--secondary); font-weight: 700;"><span id="totalCompleted">0</span> منجز</span>
                <span style="color: var(--warning); font-weight: 700;"><span id="totalInProgress">0</span> قيد الإنجاز</span>
            </div>
        </div>
    </div>
</div>

<script>
// بيانات المقررات من الخادم
var coursesCache = {};

function apiFetchHome(url) {
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

// تحميل الإحصائيات من API
document.addEventListener('DOMContentLoaded', function() {
    apiFetchHome('/api/stats').then(function(data) {
        if (data.success && data.stats) {
            var s = data.stats;
            var el;
            el = document.getElementById('stat-completed'); if (el) el.textContent = s.completed_cases || 0;
            el = document.getElementById('stat-pending'); if (el) el.textContent = s.pending_cases || 0;
            el = document.getElementById('stat-approval'); if (el) el.textContent = s.rejected_cases || 0;
            el = document.getElementById('stat-patients'); if (el) el.textContent = s.treated_patients || 0;
            el = document.getElementById('stat-appointments'); if (el) el.textContent = s.active_reservations || 0;
            el = document.getElementById('stat-reports'); if (el) el.textContent = s.total_grants || 0;
        }
    }).catch(function(err) {
        console.error('Error loading stats:', err);
    });

    // تحميل المقررات ديناميكياً
    apiFetchHome('/api/courses').then(function(data) {
        if (data.success && data.courses) {
            data.courses.forEach(function(c) {
                coursesCache[c.id] = c;
            });
            renderCoursesCards(data.courses);
        }
    }).catch(function(err) {
        console.error('Error loading courses:', err);
    });

    function renderCoursesCards(courses) {
        var container = document.getElementById('coursesContainer');
        if (!container) return;
        container.innerHTML = '';
        if (courses.length === 0) {
            container.innerHTML = '<div style="text-align:center;padding:30px;color:var(--gray);"><i class="fas fa-book-open" style="font-size:24px;margin-bottom:10px;display:block;"></i>لا توجد مقررات مسجلة</div>';
            return;
        }
        courses.forEach(function(c) {
            var schedule = c.schedule || '';
            if (c.schedules && c.schedules.length > 0) {
                var dayMap = {saturday:'السبت',sunday:'الأحد',monday:'الاثنين',tuesday:'الثلاثاء',wednesday:'الأربعاء',thursday:'الخميس',friday:'الجمعة'};
                var s = c.schedules[0];
                schedule = (dayMap[s.day_of_week] || s.day_of_week) + ' ' + (s.start_time||'').substring(0,5) + ' - ' + (s.end_time||'').substring(0,5);
            }
            var location = c.location || (c.schedules && c.schedules.length > 0 ? c.schedules[0].location : '') || '';
            var card = document.createElement('div');
            card.className = 'vertical-card';
            card.style.cssText = 'cursor:pointer;background:white;border-radius:clamp(12px,3vw,16px);padding:clamp(14px,4vw,18px);border:1px solid #e5e7eb;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:all 0.3s ease;';
            card.onclick = function() { showCourseWorks(c.slug || c.id); };
            card.innerHTML = '<div style="display:flex;align-items:center;gap:clamp(12px,3vw,16px);">' +
                '<div style="width:clamp(44px,11vw,52px);height:clamp(44px,11vw,52px);background:rgba(79,70,229,0.1);color:var(--dark);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:clamp(18px,4.5vw,22px);font-weight:700;flex-shrink:0;">' + (c.code || '') + '</div>' +
                '<div style="flex:1;min-width:0;">' +
                    '<h3 style="font-size:clamp(15px,4.5vw,17px);margin-bottom:6px;color:var(--dark);font-weight:700;line-height:1.3;">' + c.name + '</h3>' +
                    (c.supervisors ? '<p style="margin-bottom:8px;color:var(--gray);font-size:clamp(12px,3.5vw,14px);line-height:1.4;">المشرفين: ' + c.supervisors + '</p>' : '') +
                    '<div style="display:flex;gap:8px;flex-wrap:wrap;">' +
                        (schedule ? '<span style="background:rgba(79,70,229,0.08);color:var(--primary);padding:4px 10px;border-radius:20px;font-size:clamp(11px,3vw,12px);display:inline-flex;align-items:center;gap:4px;font-weight:500;"><i class="fas fa-clock" style="font-size:0.9em;"></i>' + schedule + '</span>' : '') +
                        (location ? '<span style="background:rgba(79,70,229,0.08);color:var(--primary);padding:4px 10px;border-radius:20px;font-size:clamp(11px,3vw,12px);display:inline-flex;align-items:center;gap:4px;font-weight:500;"><i class="fas fa-hospital" style="font-size:0.9em;"></i>' + location + '</span>' : '') +
                    '</div>' +
                '</div>' +
            '</div>';
            container.appendChild(card);
        });
    }
});

// عرض مودال الأعمال - يجلب من API
function showCourseWorks(courseSlugPrefix) {
    var modal = document.getElementById('courseWorksModal');
    var tbody = document.getElementById('worksTableBody');
    tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: #9ca3af;">جاري التحميل...</td></tr>';
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';

    // البحث عن المقرر بالـ slug أو ID
    var courseId = null;
    var courseName = '';
    Object.keys(coursesCache).forEach(function(id) {
        var c = coursesCache[id];
        if (c.id == courseSlugPrefix || (c.slug && c.slug.indexOf(courseSlugPrefix) === 0)) {
            courseId = c.id;
            courseName = c.name;
        }
    });

    document.getElementById('modalCourseName').textContent = courseName || courseSlugPrefix;

    if (!courseId) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: #ef4444;">لم يتم العثور على المقرر</td></tr>';
        return;
    }

    apiFetchHome('/api/courses/' + courseId + '/works').then(function(data) {
        if (!data.success) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: #ef4444;">خطأ في تحميل البيانات</td></tr>';
            return;
        }

        var works = data.works || [];
        tbody.innerHTML = '';

        var totalRequired = 0, totalCompleted = 0, totalInProgress = 0;

        works.forEach(function(work, index) {
            totalRequired += work.required || 0;
            totalCompleted += work.completed || 0;
            totalInProgress += work.in_progress || 0;

            var row = document.createElement('tr');
            row.style.background = index % 2 === 0 ? 'white' : 'rgba(79, 70, 229, 0.02)';
            row.innerHTML = '<td style="padding: 8px 4px; text-align: right; font-size: clamp(11px, 3.2vw, 12px); color: var(--dark); font-weight: 600; border-bottom: 1px solid #f3f4f6; line-height: 1.3;">' + work.name + '</td>' +
                '<td style="padding: 8px 4px; text-align: center; font-size: clamp(12px, 3.5vw, 14px); color: var(--primary); font-weight: 700; border-bottom: 1px solid #f3f4f6;">' + (work.required || 0) + '</td>' +
                '<td style="padding: 8px 4px; text-align: center; font-size: clamp(12px, 3.5vw, 14px); color: var(--secondary); font-weight: 700; border-bottom: 1px solid #f3f4f6;">' + (work.completed || 0) + '</td>' +
                '<td style="padding: 8px 4px; text-align: center; font-size: clamp(12px, 3.5vw, 14px); color: var(--warning); font-weight: 700; border-bottom: 1px solid #f3f4f6;">' + (work.in_progress || 0) + '</td>';
            tbody.appendChild(row);
        });

        document.getElementById('totalRequired').textContent = totalRequired;
        document.getElementById('totalCompleted').textContent = totalCompleted;
        document.getElementById('totalInProgress').textContent = totalInProgress;
    }).catch(function(err) {
        console.error('Error loading course works:', err);
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: #ef4444;">خطأ في الاتصال</td></tr>';
    });
}

// إغلاق المودال
function closeCourseWorksModal() {
    document.getElementById('courseWorksModal').style.display = 'none';
    document.body.style.overflow = '';
}

// إغلاق المودال عند النقر خارج المحتوى
document.getElementById('courseWorksModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCourseWorksModal();
    }
});
</script>

<style>
/* إخفاء شريط التمرير الأفقي */
.horizontal-cards::-webkit-scrollbar {
    display: none;
}
.horizontal-cards {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* تحسينات للبطاقات الأفقية */
.horizontal-card {
    transition: transform 0.2s ease;
}
.horizontal-card:active {
    transform: scale(0.98);
}

/* تحسينات للبطاقات العمودية */
.vertical-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.vertical-card:active {
    transform: translateY(0);
}

/* توسيط الحرف في المربع بشكل دقيق */
.vertical-card-content > div:first-child {
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}

/* تحسينات responsive */
@media (max-width: 480px) {
    .horizontal-card {
        width: 140px !important;
        min-width: 140px !important;
        height: 170px !important;
        padding: 16px !important;
    }
    
    .vertical-card {
        padding: 14px !important;
    }
}

@media (max-width: 360px) {
    .horizontal-card {
        width: 130px !important;
        min-width: 130px !important;
        height: 160px !important;
    }
    
    .horizontal-cards {
        gap: 10px !important;
    }
}

/* تنسيقات المودال */
#courseWorksModal {
    animation: fadeIn 0.2s ease;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>
@endsection

