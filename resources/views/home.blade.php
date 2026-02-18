@extends('layouts.app')

@section('title', 'الصفحة الرئيسية')
@section('page_title', 'الرئيسية')

@section('content')
<div class="welcome-header" style="text-align: center; margin-bottom: 28px; padding: 10px 0;">
    <h1 style="font-size: 24px; color: var(--dark); margin-bottom: 10px; font-weight: 700; letter-spacing: -0.5px;">مرحباً د. أيهام</h1>
    <p style="color: var(--gray); font-size: 15px;">نظرة عامة على نشاطك اليومي</p>
</div>

<!-- شريط الإحصائيات المتحركة -->
<div class="stats-section" style="margin-bottom: 24px;">
    <div class="section-title" style="margin-bottom: 12px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(236, 72, 153, 0.1));
                      border-radius: 10px; display: flex; align-items: center; justify-content: center;
                      box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);">
                <i class="fas fa-chart-bar" style="color: var(--primary); font-size: 15px;"></i>
            </div>
            <span style="font-weight: 700;">الإحصائيات الحيوية</span>
        </div>
        <span style="margin-right: auto; font-size: 11px; color: var(--gray); background: rgba(79, 70, 229, 0.08); padding: 4px 10px; border-radius: 12px;">
            <i class="fas fa-arrow-left" style="margin-right: 4px;"></i>
            اسحب
        </span>
    </div>
    
    <div class="horizontal-scroll-container">
        <div class="horizontal-cards">
            <!-- الحالات المنجزة -->
            <div class="horizontal-card" onclick="showStatsDetails('completed')">
                <div class="card-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>الحالات المنجزة</h3>
                <p class="stats-number" style="font-size: 24px; font-weight: 700; color: var(--secondary); margin: 8px 0;">
                    48
                </p>
                <div class="stats-trend" style="font-size: 10px; color: var(--secondary);">
                    <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
                    +12% عن الشهر الماضي
                </div>
            </div>
            
            <!-- الحالات قيد الإنجاز -->
            <div class="horizontal-card" onclick="showStatsDetails('inProgress')">
                <div class="card-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                    <i class="fas fa-spinner"></i>
                </div>
                <h3>قيد الإنجاز</h3>
                <p class="stats-number" style="font-size: 24px; font-weight: 700; color: var(--warning); margin: 8px 0;">
                    23
                </p>
                <div class="stats-trend" style="font-size: 10px; color: var(--warning);">
                    <i class="fas fa-arrow-right" style="margin-left: 4px;"></i>
                    5 حالات جديدة اليوم
                </div>
            </div>
            
            <!-- الحالات التي بحاجة للموافقة -->
            <div class="horizontal-card" onclick="showStatsDetails('pending')">
                <div class="card-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3>بحاجة للموافقة</h3>
                <p class="stats-number" style="font-size: 24px; font-weight: 700; color: var(--danger); margin: 8px 0;">
                    7
                </p>
                <div class="stats-trend" style="font-size: 10px; color: var(--danger);">
                    <i class="fas fa-clock" style="margin-left: 4px;"></i>
                    منتظر مراجعتك
                </div>
            </div>
            
            <!-- المرضى الذين تم علاجهم -->
            <div class="horizontal-card" onclick="showStatsDetails('treated')">
                <div class="card-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3>المرضى المعالجين</h3>
                <p class="stats-number" style="font-size: 24px; font-weight: 700; color: var(--primary); margin: 8px 0;">
                    156
                </p>
                <div class="stats-trend" style="font-size: 10px; color: var(--primary);">
                    <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
                    +24% عن العام الماضي
                </div>
            </div>
            
            <!-- إحصائيات إضافية -->
            <div class="horizontal-card" onclick="showStatsDetails('appointments')">
                <div class="card-icon" style="background: rgba(236, 72, 153, 0.1); color: var(--accent);">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>المواعيد اليوم</h3>
                <p class="stats-number" style="font-size: 24px; font-weight: 700; color: var(--accent); margin: 8px 0;">
                    14
                </p>
                <div class="stats-trend" style="font-size: 10px; color: var(--accent);">
                    <i class="fas fa-clock" style="margin-left: 4px;"></i>
                    3 مواعيد قادمة
                </div>
            </div>
            
            <!-- إحصائيات إضافية 2 -->
            <div class="horizontal-card" onclick="showStatsDetails('reports')">
                <div class="card-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                    <i class="fas fa-file-medical"></i>
                </div>
                <h3>التقارير المنجزة</h3>
                <p class="stats-number" style="font-size: 24px; font-weight: 700; color: #8b5cf6; margin: 8px 0;">
                    89
                </p>
                <div class="stats-trend" style="font-size: 10px; color: #8b5cf6;">
                    <i class="fas fa-check" style="margin-left: 4px;"></i>
                    جميعها مكتملة
                </div>
            </div>
        </div>
    </div>
    <!-- مؤشر التقدم -->
    <div class="scroll-indicator">
        <div class="scroll-progress"></div>
    </div>
    <!-- تلميح السحب -->
    <div class="scroll-hint">
        <i class="fas fa-hand-point-left"></i>
        <span>اسحب لمشاهدة المزيد</span>
    </div>
</div>

<!-- خط فاصل بين الأقسام -->
<div class="section-divider"></div>

<!-- المقررات السريرية المسجلة -->
<div class="courses-section">
    <div class="section-title" style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
                      border-radius: 10px; display: flex; align-items: center; justify-content: center;
                      box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);">
                <i class="fas fa-book-medical" style="color: var(--secondary); font-size: 15px;"></i>
            </div>
            <span style="font-weight: 700;">المقررات السريرية المسجلة</span>
        </div>
        <span style="font-size: 12px; color: white; background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 5px 12px; border-radius: 12px; font-weight: 600; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.2);">
            3 مقررات
        </span>
    </div>
    
    <div class="vertical-cards">
        <!-- المقرر 1 -->
        <div class="vertical-card" onclick="viewCourseDetails('cardiology')">
            <div class="vertical-card-content">
                <div class="card-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="vertical-card-info">
                    <h3>طب القلب السريري المتقدم</h3>
                    <p style="margin-bottom: 6px; color: var(--gray); font-size: 13px;">
                        د. أحمد النجار • القسم: أمراض القلب
                    </p>
                    <div style="display: flex; gap: 8px; margin-top: 4px; flex-wrap: wrap;">
                        <span class="course-badge" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                            <i class="fas fa-clock" style="margin-left: 4px;"></i>
                            السبت 8:00 - 12:00
                        </span>
                        <span class="course-badge" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                            <i class="fas fa-hospital" style="margin-left: 4px;"></i>
                            العيادة 10
                        </span>
                        <span class="course-badge" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                            <i class="fas fa-users" style="margin-left: 4px;"></i>
                            12 طالب
                        </span>
                    </div>
                </div>
                <div style="text-align: center; min-width: 60px;">
                    <div class="course-status" style="background: var(--primary); color: white; padding: 6px 12px; 
                          border-radius: 12px; font-size: 12px; font-weight: 600; margin-bottom: 4px;">
                        جاري
                    </div>
                    <div style="font-size: 10px; color: var(--gray);">
                        الأسبوع 4/12
                    </div>
                </div>
            </div>
        </div>
        
        <!-- المقرر 2 -->
        <div class="vertical-card" onclick="viewCourseDetails('respiratory')">
            <div class="vertical-card-content">
                <div class="card-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                    <i class="fas fa-lungs"></i>
                </div>
                <div class="vertical-card-info">
                    <h3>أمراض الجهاز التنفسي</h3>
                    <p style="margin-bottom: 6px; color: var(--gray); font-size: 13px;">
                        د. سارة عبدالله • القسم: الأمراض الصدرية
                    </p>
                    <div style="display: flex; gap: 8px; margin-top: 4px; flex-wrap: wrap;">
                        <span class="course-badge" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                            <i class="fas fa-clock" style="margin-left: 4px;"></i>
                            الأحد 9:00 - 13:00
                        </span>
                        <span class="course-badge" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                            <i class="fas fa-hospital" style="margin-left: 4px;"></i>
                            العيادة 7
                        </span>
                        <span class="course-badge" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                            <i class="fas fa-users" style="margin-left: 4px;"></i>
                            8 طلاب
                        </span>
                    </div>
                </div>
                <div style="text-align: center; min-width: 60px;">
                    <div class="course-status" style="background: var(--secondary); color: white; padding: 6px 12px; 
                          border-radius: 12px; font-size: 12px; font-weight: 600; margin-bottom: 4px;">
                        جاري
                    </div>
                    <div style="font-size: 10px; color: var(--gray);">
                        الأسبوع 6/10
                    </div>
                </div>
            </div>
        </div>
        
        <!-- المقرر 3 -->
        <div class="vertical-card" onclick="viewCourseDetails('neurology')">
            <div class="vertical-card-content">
                <div class="card-icon" style="background: rgba(236, 72, 153, 0.1); color: var(--accent);">
                    <i class="fas fa-brain"></i>
                </div>
                <div class="vertical-card-info">
                    <h3>طب الأعصاب السريري</h3>
                    <p style="margin-bottom: 6px; color: var(--gray); font-size: 13px;">
                        د. خالد محمود • القسم: الأمراض العصبية
                    </p>
                    <div style="display: flex; gap: 8px; margin-top: 4px; flex-wrap: wrap;">
                        <span class="course-badge" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                            <i class="fas fa-clock" style="margin-left: 4px;"></i>
                            الثلاثاء 10:00 - 14:00
                        </span>
                        <span class="course-badge" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                            <i class="fas fa-hospital" style="margin-left: 4px;"></i>
                            العيادة 15
                        </span>
                        <span class="course-badge" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                            <i class="fas fa-users" style="margin-left: 4px;"></i>
                            15 طالب
                        </span>
                    </div>
                </div>
                <div style="text-align: center; min-width: 60px;">
                    <div class="course-status" style="background: var(--accent); color: white; padding: 6px 12px; 
                          border-radius: 12px; font-size: 12px; font-weight: 600; margin-bottom: 4px;">
                        جاري
                    </div>
                    <div style="font-size: 10px; color: var(--gray);">
                        الأسبوع 8/12
                    </div>
                </div>
            </div>
        </div>
        
        <!-- المقرر 4 -->
        <div class="vertical-card" onclick="viewCourseDetails('clinical')">
            <div class="vertical-card-content">
                <div class="card-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div class="vertical-card-info">
                    <h3>الفحص السريري المتقدم</h3>
                    <p style="margin-bottom: 6px; color: var(--gray); font-size: 13px;">
                        د. لينا حسن • القسم: المهارات السريرية
                    </p>
                    <div style="display: flex; gap: 8px; margin-top: 4px; flex-wrap: wrap;">
                        <span class="course-badge" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                            <i class="fas fa-clock" style="margin-left: 4px;"></i>
                            الأربعاء 8:00 - 11:00
                        </span>
                        <span class="course-badge" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                            <i class="fas fa-hospital" style="margin-left: 4px;"></i>
                            معمل المهارات 3
                        </span>
                        <span class="course-badge" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                            <i class="fas fa-users" style="margin-left: 4px;"></i>
                            20 طالب
                        </span>
                    </div>
                </div>
                <div style="text-align: center; min-width: 60px;">
                    <div class="course-status" style="background: var(--warning); color: white; padding: 6px 12px; 
                          border-radius: 12px; font-size: 12px; font-weight: 600; margin-bottom: 4px;">
                        مكتمل
                    </div>
                    <div style="font-size: 10px; color: var(--gray);">
                        الأسبوع 12/12
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- خط فاصل -->
<div class="section-divider"></div>

<!-- حقل البحث السريع -->
<div class="quick-search-container">
    <div class="input-container" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -20px; left: -20px; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.06), transparent); border-radius: 50%;"></div>
        <div class="section-title" style="margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(79, 70, 229, 0.05));
                          border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-search" style="color: var(--primary); font-size: 13px;"></i>
                </div>
                <span style="font-weight: 700;">بحث سريع</span>
            </div>
        </div>
        <div style="position: relative;">
            <input type="text" 
                   id="quickSearch"
                   class="text-input" 
                   placeholder="ابحث عن مريض، تقرير، أو موعد..." 
                   style="padding-right: 40px;">
            <button onclick="performQuickSearch()" 
                    style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); 
                           background: var(--primary); color: white; border: none; border-radius: 8px; 
                           width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; 
                           cursor: pointer;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>

<!-- خط فاصل -->
<div class="section-divider"></div>

<!-- أزرار إجراءات سريعة -->
<div class="quick-actions">
    <div style="display: flex; gap: 12px;">
        <button class="quick-action-btn primary" onclick="navigateTo('new-case')">
            <i class="fas fa-plus" style="margin-left: 8px;"></i>
            حالة جديدة
        </button>
        <button class="quick-action-btn secondary" onclick="navigateTo('schedule')">
            <i class="fas fa-calendar" style="margin-left: 8px;"></i>
            الجدول اليومي
        </button>
    </div>
</div>

<!-- خط فاصل -->
<div class="section-divider"></div>

<!-- إشعارات مهمة -->
<div class="important-notices">
    <div class="input-container" style="position: relative; overflow: hidden; border: 1.5px solid rgba(245, 158, 11, 0.2);">
        <div style="position: absolute; top: -30px; right: -30px; width: 100px; height: 100px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.08), transparent); border-radius: 50%;"></div>
        <div class="section-title" style="margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.08));
                          border-radius: 10px; display: flex; align-items: center; justify-content: center;
                          box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15); animation: pulse 2s infinite;">
                    <i class="fas fa-exclamation-circle" style="color: var(--warning); font-size: 16px;"></i>
                </div>
                <span style="font-weight: 700;">إشعارات مهمة</span>
            </div>
            <span style="font-size: 11px; color: white; background: linear-gradient(135deg, var(--warning), #d97706); padding: 4px 10px; border-radius: 12px; font-weight: 600;">
                2 جديد
            </span>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: rgba(245, 158, 11, 0.1); border-radius: 8px;">
                <div style="width: 24px; height: 24px; background: var(--warning); border-radius: 50%; 
                            display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 13px; font-weight: 600; color: var(--dark);">اجتماع الكلية</div>
                    <div style="font-size: 12px; color: var(--gray);">غداً الساعة 10:00 صباحاً</div>
                </div>
                <button onclick="dismissNotice('meeting')" 
                        style="background: none; border: none; color: var(--gray); cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: rgba(239, 68, 68, 0.1); border-radius: 8px;">
                <div style="width: 24px; height: 24px; background: var(--danger); border-radius: 50%; 
                            display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                    <i class="fas fa-exclamation"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 13px; font-weight: 600; color: var(--dark);">تقارير طارئة</div>
                    <div style="font-size: 12px; color: var(--gray);">3 تقارير بحاجة للمراجعة العاجلة</div>
                </div>
                <button onclick="reviewReports()" 
                        style="background: var(--danger); color: white; border: none; padding: 6px 12px; 
                               border-radius: 6px; font-size: 12px; cursor: pointer;">
                    عرض
                </button>
            </div>
        </div>
    </div>
</div>

<!-- أسلوب إضافي محسن -->
<style>
/* Home Page Enhanced Styles */
.welcome-header h1 {
    background: linear-gradient(135deg, var(--dark), var(--primary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Stats Section Enhancement */
.stats-section {
    position: relative;
}

.stats-section::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -30px;
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, rgba(79, 70, 229, 0.06) 0%, transparent 70%);
    pointer-events: none;
    z-index: -1;
}

/* Horizontal Cards Animation */
.horizontal-card {
    animation: cardFloat 0.5s ease backwards;
    position: relative;
    overflow: hidden;
}

.horizontal-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.6s;
}

.horizontal-card:hover::before {
    left: 100%;
}

.horizontal-card:nth-child(1) { animation-delay: 0.05s; }
.horizontal-card:nth-child(2) { animation-delay: 0.1s; }
.horizontal-card:nth-child(3) { animation-delay: 0.15s; }
.horizontal-card:nth-child(4) { animation-delay: 0.2s; }
.horizontal-card:nth-child(5) { animation-delay: 0.25s; }
.horizontal-card:nth-child(6) { animation-delay: 0.3s; }

@keyframes cardFloat {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Vertical Cards Enhancement */
.vertical-card {
    position: relative;
    overflow: hidden;
}

.vertical-card::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 4px;
    height: 0;
    background: linear-gradient(180deg, var(--primary), var(--accent));
    transition: height 0.3s ease;
    border-radius: 0 0 0 4px;
}

.vertical-card:hover::after {
    height: 100%;
}

/* Quick Action Buttons */
.quick-action-btn {
    position: relative;
    overflow: hidden;
}

.quick-action-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255,255,255,0.2);
    transform: translate(-50%, -50%);
    border-radius: 50%;
    transition: all 0.5s;
}

.quick-action-btn:active::before {
    width: 300%;
    height: 300%;
}

.quick-action-btn.primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.quick-action-btn.primary:hover {
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    transform: translateY(-2px);
}

.quick-action-btn.secondary {
    background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
}

.quick-action-btn.secondary:hover {
    background: linear-gradient(135deg, var(--gray-200), var(--gray-300));
    transform: translateY(-2px);
}

/* Course Status Badge Animation */
.course-status {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.85; }
}

/* Important Notices Enhancement */
.important-notices .input-container {
    position: relative;
    overflow: hidden;
}

.important-notices .input-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--warning), var(--danger), var(--warning));
    background-size: 200% 100%;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Search Input Enhancement */
#quickSearch {
    border: 2px solid var(--gray-200);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#quickSearch:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    outline: none;
}

/* Section Title Icons */
.section-title [style*="width: 36px"] {
    transition: all 0.3s ease;
}

.section-title:hover [style*="width: 36px"] {
    transform: scale(1.1) rotate(-5deg);
}

/* Course Badge Enhancement */
.course-badge {
    transition: all 0.2s ease;
}

.vertical-card:hover .course-badge {
    transform: translateY(-1px);
}

/* Stats Number Counter Animation */
.stats-number {
    position: relative;
}

.stats-number::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: currentColor;
    transition: width 0.3s ease;
    border-radius: 1px;
}

.horizontal-card:hover .stats-number::after {
    width: 50%;
}

/* Scroll Hint Animation */
.scroll-hint {
    animation: bounceLeft 2s infinite;
}

@keyframes bounceLeft {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(-5px); }
}

/* Input Container Hover */
.input-container {
    transition: all 0.3s ease;
}

.input-container:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}
</style>

<script>
// تفعيل شريط الإحصائيات الأفقية
document.addEventListener('DOMContentLoaded', function() {
    const horizontalCards = document.querySelector('.horizontal-cards');
    const progressBar = document.querySelector('.scroll-progress');
    
    if (horizontalCards && progressBar) {
        // تهيئة شريط التقدم
        const updateProgressBar = () => {
            const scrollWidth = horizontalCards.scrollWidth - horizontalCards.clientWidth;
            const scrollLeft = horizontalCards.scrollLeft;
            const progress = scrollWidth > 0 ? (scrollLeft / scrollWidth) * 100 : 0;
            progressBar.style.width = progress + '%';
        };
        
        horizontalCards.addEventListener('scroll', updateProgressBar);
        
        // تحديث أولي
        setTimeout(updateProgressBar, 100);
        
        // إضافة تأثير عند النقر على بطاقات الإحصائيات
        document.querySelectorAll('.horizontal-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
                
                const title = this.querySelector('h3').textContent;
                const count = this.querySelector('.stats-number').textContent;
                showToast(`إحصائيات ${title}: ${count}`);
            });
        });
        
        // إضافة تأثير عند النقر على بطاقات المقررات
        document.querySelectorAll('.vertical-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'translateX(-4px)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
        
        // تهيئة حقل البحث
        const quickSearch = document.getElementById('quickSearch');
        if (quickSearch) {
            quickSearch.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performQuickSearch();
                }
            });
        }
    }
});

function showStatsDetails(type) {
    const statsMap = {
        'completed': {
            title: 'الحالات المنجزة',
            count: '48',
            details: '• 32 حالة قلبية\n• 10 حالات صدرية\n• 6 حالات عصبية',
            color: 'var(--secondary)'
        },
        'inProgress': {
            title: 'الحالات قيد الإنجاز',
            count: '23',
            details: '• 12 حالة في مرحلة التشخيص\n• 8 حالات في مرحلة العلاج\n• 3 حالات في مرحلة المتابعة',
            color: 'var(--warning)'
        },
        'pending': {
            title: 'الحالات التي بحاجة للموافقة',
            count: '7',
            details: '• 4 تقارير طبية\n• 2 طلبات إجازة\n• 1 طلب أدوية خاصة',
            color: 'var(--danger)'
        },
        'treated': {
            title: 'المرضى المعالجين',
            count: '156',
            details: '• 98 مريض قلب\n• 42 مريض صدر\n• 16 مريض أعصاب',
            color: 'var(--primary)'
        }
    };
    
    const stat = statsMap[type];
    if (stat) {
        showModal(`
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 60px; height: 60px; background: ${stat.color}20; 
                          border-radius: 50%; display: flex; align-items: center; 
                          justify-content: center; margin: 0 auto 12px;">
                    <i class="fas fa-chart-pie" style="font-size: 24px; color: ${stat.color};"></i>
                </div>
                <h3 style="font-size: 20px; color: var(--dark); margin-bottom: 8px;">${stat.title}</h3>
                <div style="font-size: 32px; font-weight: 700; color: ${stat.color}; margin: 12px 0;">${stat.count}</div>
            </div>
            <div style="background: var(--gray-light); padding: 16px; border-radius: var(--radius-sm);">
                <div style="font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">التفاصيل:</div>
                <div style="font-size: 13px; color: var(--gray-dark); white-space: pre-line;">${stat.details}</div>
            </div>
        `, stat.title);
    }
}

function viewCourseDetails(courseId) {
    const coursesMap = {
        'cardiology': {
            title: 'طب القلب السريري المتقدم',
            code: 'MED-401',
            instructor: 'د. أحمد النجار',
            department: 'أمراض القلب',
            schedule: 'السبت والأربعاء 8:00 - 12:00',
            location: 'العيادة 10 - مبنى الكلية الطبية',
            students: '12 طالب',
            progress: '33%',
            weeks: 'الأسبوع 4 من 12'
        },
        'respiratory': {
            title: 'أمراض الجهاز التنفسي',
            code: 'MED-402',
            instructor: 'د. سارة عبدالله',
            department: 'الأمراض الصدرية',
            schedule: 'الأحد والإثنين 9:00 - 13:00',
            location: 'العيادة 7 - مبنى الكلية الطبية',
            students: '8 طلاب',
            progress: '60%',
            weeks: 'الأسبوع 6 من 10'
        }
    };
    
    const course = coursesMap[courseId] || coursesMap['cardiology'];
    
    showModal(`
        <div style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 50px; height: 50px; background: var(--primary-light); 
                          border-radius: 12px; display: flex; align-items: center; 
                          justify-content: center; color: white; font-size: 20px;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div style="flex: 1;">
                    <h3 style="font-size: 18px; color: var(--dark); margin-bottom: 4px;">${course.title}</h3>
                    <div style="font-size: 12px; color: var(--gray);">${course.code} • ${course.department}</div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <div style="background: var(--gray-light); padding: 12px; border-radius: 8px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">المحاضر</div>
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark);">${course.instructor}</div>
                </div>
                <div style="background: var(--gray-light); padding: 12px; border-radius: 8px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">عدد الطلاب</div>
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark);">${course.students}</div>
                </div>
            </div>
            
            <div style="background: white; border: 1px solid #e5e7eb; border-radius: var(--radius-sm); padding: 16px; margin-bottom: 16px;">
                <div style="font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">معلومات الجدول:</div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 12px; color: var(--gray);">المواعيد:</span>
                        <span style="font-size: 13px; color: var(--dark); font-weight: 500;">${course.schedule}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 12px; color: var(--gray);">الموقع:</span>
                        <span style="font-size: 13px; color: var(--dark); font-weight: 500;">${course.location}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 12px; color: var(--gray);">التقدم:</span>
                        <span style="font-size: 13px; color: var(--primary); font-weight: 600;">${course.progress} • ${course.weeks}</span>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button onclick="navigateTo('course-details')" 
                        style="flex: 1; background: var(--primary); color: white; border: none; 
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-external-link-alt" style="margin-left: 8px;"></i>
                    التفاصيل الكاملة
                </button>
                <button onclick="closeModal()" 
                        style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb; 
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    إغلاق
                </button>
            </div>
        </div>
    `, 'تفاصيل المقرر');
}

function performQuickSearch() {
    const query = document.getElementById('quickSearch').value.trim();
    if (query) {
        showToast(`جاري البحث عن: "${query}"`);
        // هنا يمكن إضافة منطق البحث الفعلي
        setTimeout(() => {
            showToast(`تم العثور على 5 نتائج لـ "${query}"`);
        }, 1000);
    } else {
        showToast('يرجى إدخال نص للبحث', 'warning');
    }
}

function navigateTo(page) {
    const routes = {
        'new-case': { title: 'حالة جديدة', url: '/cases/new' },
        'schedule': { title: 'الجدول اليومي', url: '/schedule/today' },
        'course-details': { title: 'تفاصيل المقرر', url: '/courses/details' }
    };
    
    const route = routes[page];
    if (route) {
        showToast(`جاري التوجه إلى ${route.title}...`);
        // في التطبيق الحقيقي: window.location.href = route.url;
        setTimeout(() => {
            showToast(`تم فتح ${route.title}`);
        }, 500);
    }
}

function dismissNotice(noticeId) {
    const notice = event.target.closest('[style*="background:"]');
    if (notice) {
        notice.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            notice.remove();
        }, 300);
        showToast('تم إخفاء الإشعار');
    }
}

function reviewReports() {
    showModal(`
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 60px; height: 60px; background: rgba(239, 68, 68, 0.1); 
                      border-radius: 50%; display: flex; align-items: center; 
                      justify-content: center; margin: 0 auto 12px;">
                <i class="fas fa-file-medical" style="font-size: 24px; color: var(--danger);"></i>
            </div>
            <h3 style="font-size: 18px; color: var(--dark); margin-bottom: 8px;">التقارير الطارئة</h3>
            <p style="color: var(--gray); font-size: 14px;">يوجد 3 تقارير بحاجة للمراجعة العاجلة</p>
        </div>
        
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: var(--radius-sm); padding: 0; overflow: hidden;">
            <div style="padding: 12px; background: var(--gray-light); border-bottom: 1px solid #e5e7eb;">
                <div style="font-size: 12px; font-weight: 600; color: var(--dark);">قائمة التقارير:</div>
            </div>
            <div style="max-height: 200px; overflow-y: auto;">
                <div style="padding: 12px; border-bottom: 1px solid #f3f4f6;">
                    <div style="font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 4px;">تقرير حالة قلبية</div>
                    <div style="font-size: 11px; color: var(--gray);">مريض: أحمد محمد • منذ 2 ساعة</div>
                </div>
                <div style="padding: 12px; border-bottom: 1px solid #f3f4f6;">
                    <div style="font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 4px;">تقرير أشعة صدر</div>
                    <div style="font-size: 11px; color: var(--gray);">مريض: سارة خالد • منذ 4 ساعات</div>
                </div>
                <div style="padding: 12px;">
                    <div style="font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 4px;">تقرير مختبر طارئ</div>
                    <div style="font-size: 11px; color: var(--gray);">مريض: عمر علي • منذ 6 ساعات</div>
                </div>
            </div>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <button onclick="navigateTo('reports')" 
                    style="flex: 1; background: var(--danger); color: white; border: none; 
                           padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                <i class="fas fa-eye" style="margin-left: 8px;"></i>
                مراجعة الآن
            </button>
            <button onclick="closeModal()" 
                    style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb; 
                           padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                لاحقاً
            </button>
        </div>
    `, 'التقارير الطارئة');
}

// وظائف المساعدة
function showModal(content, title = '') {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.id = 'customModal';
    modal.innerHTML = `
        <div style="position: fixed; top: 0; right: 0; bottom: 0; left: 0; background: rgba(0,0,0,0.5); 
                    backdrop-filter: blur(4px); z-index: 2000; display: flex; align-items: center; 
                    justify-content: center; padding: 20px;">
            <div style="background: white; border-radius: var(--radius-lg); padding: 24px; width: 90%; 
                        max-width: 400px; max-height: 80vh; overflow-y: auto;">
                ${title ? `<div style="font-size: 18px; font-weight: 700; color: var(--dark); margin-bottom: 16px; text-align: center;">${title}</div>` : ''}
                ${content}
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function closeModal() {
    const modal = document.getElementById('customModal');
    if (modal) {
        modal.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const colors = {
        info: { bg: 'var(--primary)', color: 'white' },
        warning: { bg: 'var(--warning)', color: 'white' },
        success: { bg: 'var(--secondary)', color: 'white' }
    };
    const color = colors[type] || colors.info;
    
    toast.innerHTML = `
        <div style="position: fixed; top: 80px; right: 16px; left: 16px; background: ${color.bg}; 
                   color: white; padding: 12px 16px; border-radius: var(--radius); z-index: 1000; 
                   text-align: center; font-weight: 500; animation: slideDown 0.3s ease;">
            <i class="fas fa-info-circle" style="margin-left: 8px;"></i>
            ${message}
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// إضافة أنيميشن
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(style);

// منع الانتقال الفعلي للروابط في الأمثلة
document.addEventListener('click', function(e) {
    if (e.target.closest('[onclick*="navigateTo"]') || e.target.closest('[onclick*="viewCourseDetails"]')) {
        e.preventDefault();
    }
});
</script>
@endsection
