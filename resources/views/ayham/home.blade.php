@extends('layouts.app')

@section('title', 'لوحة تحكم المشرف')
@section('page_title', 'لوحة تحكم المشرف')

@section('tabs')
<div class="tab-item active" onclick="switchTab('overview')">
    <i class="fas fa-home" style="margin-left: 4px;"></i>
    نظرة عامة
</div>
<div class="tab-item" onclick="switchTab('students')">
    <i class="fas fa-user-graduate" style="margin-left: 4px;"></i>
    الطلاب
</div>
<div class="tab-item" onclick="switchTab('exceptions')">
    <i class="fas fa-exclamation-triangle" style="margin-left: 4px;"></i>
    الاستثناءات
</div>
@endsection

@section('tab_content')
<!-- تبويب النظرة العامة -->
<div class="tab-content" id="overviewContent" style="display: block;">
    <!-- ترحيب -->
    <div class="welcome-header" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--accent) 100%); color: white; padding: clamp(20px, 5vw, 36px); border-radius: clamp(16px, 4vw, 24px); margin-bottom: clamp(16px, 4vw, 24px); text-align: center; box-shadow: 0 20px 50px rgba(79, 70, 229, 0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -30%; right: -10%; width: clamp(150px, 30vw, 250px); height: clamp(150px, 30vw, 250px); background: rgba(255,255,255,0.08); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40%; left: -15%; width: clamp(120px, 25vw, 200px); height: clamp(120px, 25vw, 200px); background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 1;">
            <div style="width: clamp(60px, 15vw, 80px); height: clamp(60px, 15vw, 80px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 20px); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.2);">
                <i class="fas fa-user-md" style="font-size: clamp(24px, 6vw, 32px);"></i>
            </div>
            <h1 style="font-size: clamp(1.25rem, 4vw, 2rem); font-weight: 800; margin-bottom: 8px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">مرحباً د. المشرف</h1>
            <div style="display: inline-flex; align-items: center; gap: clamp(8px, 2vw, 20px); background: rgba(255,255,255,0.15); padding: clamp(10px, 2.5vw, 14px) clamp(16px, 4vw, 28px); border-radius: 50px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); flex-wrap: wrap; justify-content: center;">
                <span style="font-size: clamp(0.8125rem, 2.2vw, 1.0625rem); display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-book-medical"></i>
                    <strong>طب أسنان الأطفال</strong>
                </span>
                <span style="width: 1px; height: clamp(16px, 4vw, 24px); background: rgba(255,255,255,0.3);"></span>
                <span style="font-size: clamp(0.8125rem, 2.2vw, 1.0625rem); display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-graduation-cap"></i>
                    <strong>السنة الرابعة / المجموعة B</strong>
                </span>
            </div>
        </div>
    </div>

    <!-- شريط الحالات -->
    <div class="stats-section" style="margin-bottom: clamp(16px, 4vw, 24px);">
        <div class="section-title" style="margin-top: clamp(12px, 3vw, 20px); font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">
            <i class="fas fa-clipboard-check" style="color: var(--primary);"></i>
            <span>حالات الطلاب</span>
        </div>

        <div class="horizontal-scroll-container">
            <div class="horizontal-cards">
                <div class="horizontal-card" style="border-top: 4px solid var(--secondary); min-width: clamp(120px, 30vw, 160px);">
                    <div class="card-icon" style="background: linear-gradient(135deg, var(--secondary), #059669); width: clamp(36px, 9vw, 48px); height: clamp(36px, 9vw, 48px); font-size: clamp(14px, 3.5vw, 18px);">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h3 style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">للموافقة اليوم</h3>
                    <p class="stats-number" style="color: var(--secondary); font-size: clamp(1.25rem, 3.5vw, 1.75rem); font-weight: 800; margin-top: 6px;">12</p>
                </div>

                <div class="horizontal-card" style="border-top: 4px solid var(--warning); min-width: clamp(120px, 30vw, 160px);">
                    <div class="card-icon" style="background: linear-gradient(135deg, var(--warning), #fbbf24); width: clamp(36px, 9vw, 48px); height: clamp(36px, 9vw, 48px); font-size: clamp(14px, 3.5vw, 18px);">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <h3 style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">منتظرة للموافقة</h3>
                    <p class="stats-number" style="color: var(--warning); font-size: clamp(1.25rem, 3.5vw, 1.75rem); font-weight: 800; margin-top: 6px;">8</p>
                </div>

                <div class="horizontal-card" style="border-top: 4px solid var(--danger); min-width: clamp(120px, 30vw, 160px);">
                    <div class="card-icon" style="background: linear-gradient(135deg, var(--danger), #f87171); width: clamp(36px, 9vw, 48px); height: clamp(36px, 9vw, 48px); font-size: clamp(14px, 3.5vw, 18px);">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h3 style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">مرفوضة</h3>
                    <p class="stats-number" style="color: var(--danger); font-size: clamp(1.25rem, 3.5vw, 1.75rem); font-weight: 800; margin-top: 6px;">3</p>
                </div>

                <div class="horizontal-card" style="border-top: 4px solid var(--accent); min-width: clamp(120px, 30vw, 160px);">
                    <div class="card-icon" style="background: linear-gradient(135deg, var(--accent), #f472b6); width: clamp(36px, 9vw, 48px); height: clamp(36px, 9vw, 48px); font-size: clamp(14px, 3.5vw, 18px);">
                        <i class="fas fa-random"></i>
                    </div>
                    <h3 style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">محولة</h3>
                    <p class="stats-number" style="color: var(--accent); font-size: clamp(1.25rem, 3.5vw, 1.75rem); font-weight: 800; margin-top: 6px;">5</p>
                </div>
            </div>
        </div>
        
        <div class="scroll-hint" style="font-size: clamp(0.6875rem, 1.8vw, 0.8125rem);">
            <i class="fas fa-hand-point-left"></i>
            <span>اسحب لمشاهدة المزيد</span>
        </div>
    </div>

    <!-- آخر النشاطات -->
    <div class="section-title" style="margin-top: clamp(12px, 3vw, 20px); font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">
        <i class="fas fa-history" style="color: var(--primary);"></i>
        <span>آخر النشاطات</span>
    </div>

    <div class="input-container" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="cases-table" style="min-width: 600px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.05));">
                        <th style="padding: clamp(10px, 2.5vw, 16px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 600; color: var(--primary); border-bottom: 2px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-user" style="margin-left: 6px;"></i>
                            الطالب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 16px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 600; color: var(--primary); border-bottom: 2px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-tag" style="margin-left: 6px;"></i>
                            النشاط
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 16px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 600; color: var(--primary); border-bottom: 2px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
                            التفاصيل
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 16px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 600; color: var(--primary); border-bottom: 2px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-clock" style="margin-left: 6px;"></i>
                            الوقت
                        </th>
                    </tr>
                </thead>
                <tbody id="activityTableBody">
                </tbody>
            </table>
        </div>
        
        <!-- ترقيم الصفحات -->
        <div id="paginationContainer" style="display: flex; justify-content: center; align-items: center; gap: 12px; padding: clamp(12px, 3vw, 20px); border-top: 1px solid #e5e7eb;">
            <button onclick="changePage('prev')" id="prevBtn" style="background: white; border: 2px solid #e5e7eb; color: #64748b; padding: clamp(8px, 2vw, 10px) clamp(14px, 3vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                <i class="fas fa-chevron-right"></i>
                السابق
            </button>
            <span id="pageIndicator" style="font-weight: 700; color: var(--primary); font-size: clamp(0.75rem, 2vw, 0.875rem);">صفحة 1 من 2</span>
            <button onclick="changePage('next')" id="nextBtn" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; padding: clamp(8px, 2vw, 10px) clamp(14px, 3vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); font-size: clamp(0.75rem, 2vw, 0.875rem);">
                التالي
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
    </div>
</div>

<!-- تبويب الطلاب -->
<div class="tab-content" id="studentsContent" style="display: none;">
    <div class="section-title" style="margin-top: clamp(12px, 3vw, 20px); font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">
        <i class="fas fa-user-graduate" style="color: var(--primary);"></i>
        <span>اختيار الطالب</span>
    </div>

    <div class="input-container">
        <div class="custom-dropdown" id="studentDropdown">
            <div class="dropdown-header" onclick="toggleDropdown('studentDropdown')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); border: 2px solid #e5e7eb; border-radius: 12px; padding: clamp(12px, 3vw, 16px);">
                <span id="selectedStudentText">اختر الطالب لعرض سجله</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>
            <div class="dropdown-options">
                <div class="dropdown-option" onclick="selectStudent(1)">
                    <div style="display: flex; align-items: center; gap: 12px; padding: clamp(10px, 2.5vw, 12px);">
                        <div style="width: clamp(36px, 9vw, 40px); height: clamp(36px, 9vw, 40px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(14px, 3.5vw, 16px);">م</div>
                        <div>
                            <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">محمد أحمد علي</div>
                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray);">20214587 • 5 حالات</div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-option" onclick="selectStudent(2)">
                    <div style="display: flex; align-items: center; gap: 12px; padding: clamp(10px, 2.5vw, 12px);">
                        <div style="width: clamp(36px, 9vw, 40px); height: clamp(36px, 9vw, 40px); background: linear-gradient(135deg, var(--accent), #f472b6); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(14px, 3.5vw, 16px);">س</div>
                        <div>
                            <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">سارة خالد يوسف</div>
                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray);">20216732 • 3 حالات</div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-option" onclick="selectStudent(3)">
                    <div style="display: flex; align-items: center; gap: 12px; padding: clamp(10px, 2.5vw, 12px);">
                        <div style="width: clamp(36px, 9vw, 40px); height: clamp(36px, 9vw, 40px); background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(14px, 3.5vw, 16px);">ع</div>
                        <div>
                            <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">عمر محمود حسن</div>
                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray);">20219854 • 2 حالة</div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-option" onclick="selectStudent(4)">
                    <div style="display: flex; align-items: center; gap: 12px; padding: clamp(10px, 2.5vw, 12px);">
                        <div style="width: clamp(36px, 9vw, 40px); height: clamp(36px, 9vw, 40px); background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(14px, 3.5vw, 16px);">ف</div>
                        <div>
                            <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">فاطمة أحمد سالم</div>
                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray);">20215678 • 4 حالات</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="view-record-btn" id="viewRecordBtn" onclick="openSelectedStudentRecord()" disabled 
                style="width: 100%; margin-top: 16px; padding: clamp(14px, 3.5vw, 16px); border: none; border-radius: 12px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); font-weight: 700; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; background: #e5e7eb; color: #9ca3af;">
            <i class="fas fa-eye"></i>
            عرض السجل
        </button>
    </div>

    <!-- جدول الطلاب -->
    <div class="section-title" style="margin-top: clamp(20px, 5vw, 24px); font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">
        <i class="fas fa-users" style="color: var(--primary);"></i>
        <span>قائمة الطلاب</span>
    </div>

    <div class="input-container" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="cases-table" style="min-width: 600px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.05));">
                        <th style="padding: clamp(12px, 3vw, 16px); text-align: right; font-size: clamp(0.75rem, 2vw, 0.875rem); font-weight: 600; color: var(--primary); border-bottom: 2px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-user" style="margin-left: 6px;"></i>الطالب
                        </th>
                        <th style="padding: clamp(12px, 3vw, 16px); text-align: center; font-size: clamp(0.75rem, 2vw, 0.875rem); font-weight: 600; color: var(--primary); border-bottom: 2px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-hashtag" style="margin-left: 6px;"></i>الرقم الجامعي
                        </th>
                        <th style="padding: clamp(12px, 3vw, 16px); text-align: center; font-size: clamp(0.75rem, 2vw, 0.875rem); font-weight: 600; color: var(--primary); border-bottom: 2px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-layer-group" style="margin-left: 6px;"></i>الفئة
                        </th>
                        <th style="padding: clamp(12px, 3vw, 16px); text-align: center; font-size: clamp(0.75rem, 2vw, 0.875rem); font-weight: 600; color: var(--primary); border-bottom: 2px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-clipboard-list" style="margin-left: 6px;"></i>الحالات
                        </th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- تبويب الاستثناءات - تصميم مدمج وصغير -->
<div class="tab-content" id="exceptionsContent" style="display: none;">
    <div class="section-title" style="margin-top: clamp(12px, 3vw, 20px); font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">
        <i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i>
        <span>الاستثناءات</span>
    </div>

    <div style="display: flex; flex-direction: column; gap: clamp(10px, 2.5vw, 14px);">
        <!-- استثناء 1 -->
        <div onclick="showExceptionDetails(1)" style="background: white; border-radius: clamp(12px, 3vw, 16px); padding: clamp(14px, 3.5vw, 18px); border: 1px solid #e5e7eb; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: clamp(10px, 2.5vw, 14px); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div style="width: clamp(40px, 10vw, 52px); height: clamp(40px, 10vw, 52px); background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: clamp(10px, 2.5vw, 14px); display: flex; align-items: center; justify-content: center; color: white; font-size: clamp(16px, 4vw, 20px); flex-shrink: 0;">
                <i class="fas fa-exclamation"></i>
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                    <h3 style="font-size: clamp(0.875rem, 2.3vw, 1rem); font-weight: 700; color: var(--dark);">محمد أحمد علي</h3>
                    <span style="background: rgba(236, 72, 153, 0.1); color: var(--accent); padding: 4px 10px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;">2 حالة</span>
                </div>
                <p style="font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); color: var(--gray);">د. أحمد النجار • ظروف صحية</p>
            </div>
            <i class="fas fa-chevron-left" style="color: var(--gray); font-size: clamp(12px, 3vw, 14px);"></i>
        </div>

        <!-- استثناء 2 -->
        <div onclick="showExceptionDetails(2)" style="background: white; border-radius: clamp(12px, 3vw, 16px); padding: clamp(14px, 3.5vw, 18px); border: 1px solid #e5e7eb; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: clamp(10px, 2.5vw, 14px); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div style="width: clamp(40px, 10vw, 52px); height: clamp(40px, 10vw, 52px); background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: clamp(10px, 2.5vw, 14px); display: flex; align-items: center; justify-content: center; color: white; font-size: clamp(16px, 4vw, 20px); flex-shrink: 0;">
                <i class="fas fa-exclamation"></i>
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                    <h3 style="font-size: clamp(0.875rem, 2.3vw, 1rem); font-weight: 700; color: var(--dark);">عمر محمود حسن</h3>
                    <span style="background: rgba(236, 72, 153, 0.1); color: var(--accent); padding: 4px 10px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;">1 حالة</span>
                </div>
                <p style="font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); color: var(--gray);">رئيس القسم • ظروف شخصية</p>
            </div>
            <i class="fas fa-chevron-left" style="color: var(--gray); font-size: clamp(12px, 3vw, 14px);"></i>
        </div>
    </div>
</div>
@endsection

@section('content')
@endsection

<!-- مودال سجل الطالب -->
<div id="studentModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 99999; justify-content: center; align-items: center; padding: 16px; overflow-y: auto;">
    <div id="modalBody" style="background: white; border-radius: clamp(16px, 4vw, 24px); width: 100%; max-width: 800px; margin: auto; position: relative; animation: modalPop 0.4s ease; max-height: 95vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
    </div>
</div>

<!-- مودال تفاصيل الاستثناء - تصميم مدمج -->
<div id="exceptionModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 99999; justify-content: center; align-items: center; padding: 16px;">
    <div id="exceptionModalBody" style="background: white; border-radius: clamp(16px, 4vw, 24px); padding: clamp(20px, 5vw, 32px); width: 100%; max-width: 420px; margin: auto; position: relative; animation: modalPop 0.4s ease; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
    </div>
</div>

<style>
@keyframes modalPop {
    0% { opacity: 0; transform: scale(0.8) translateY(30px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideUp {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-30px); }
}

.view-record-btn:not(:disabled) {
    background: linear-gradient(135deg, var(--primary), var(--primary-light)) !important;
    color: white !important;
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
}
.view-record-btn:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
}

.category-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: clamp(32px, 8vw, 36px);
    height: clamp(32px, 8vw, 36px);
    border-radius: 10px;
    font-weight: 700;
    font-size: clamp(12px, 3vw, 14px);
}
.category-same {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
}
.category-different {
    background: linear-gradient(135deg, var(--danger), #f87171);
    color: white;
    box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
}

/* تجميد الزر عند الاكتمال */
.btn-disabled {
    opacity: 0.5 !important;
    cursor: not-allowed !important;
    pointer-events: none !important;
    filter: grayscale(100%);
}

/* Checkbox style for ratings */
.rating-checkbox {
    width: clamp(20px, 5vw, 24px);
    height: clamp(20px, 5vw, 24px);
    border: 2px solid #e5e7eb;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    background: white;
}
.rating-checkbox.checked {
    background: var(--secondary);
    border-color: var(--secondary);
}
.rating-checkbox i {
    color: white;
    font-size: clamp(12px, 3vw, 14px);
    opacity: 0;
}
.rating-checkbox.checked i {
    opacity: 1;
}

/* Student row selection highlight */
.student-row {
    transition: all 0.2s;
}
.student-row:hover {
    background: rgba(79, 70, 229, 0.05);
}
.student-row.selected {
    background: rgba(79, 70, 229, 0.1);
    border-right: 3px solid var(--primary);
}

/* Exception badge in student list */
.exception-badge {
    background: linear-gradient(135deg, var(--warning), #fbbf24);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: clamp(0.625rem, 1.6vw, 0.75rem);
    font-weight: 700;
    margin-right: 8px;
}
</style>

<script>
// المتغيرات العامة
let selectedStudentId = null;
let currentPage = 1;
const itemsPerPage = 5;
const supervisorCategory = 'B';

// بيانات الاستثناءات للتحقق
const studentsWithExceptions = {
    1: { count: 2, active: true }, // محمد أحمد علي - عنده استثناء
    2: { count: 0, active: false }, // سارة - ما عنده
    3: { count: 1, active: true }, // عمر محمود حسن - عنده استثناء
    4: { count: 0, active: false }  // فاطمة - ما عنده
};

// البيانات
const studentsData = {
    1: { name: 'محمد أحمد علي', id: '20214587', cases: 5, phone: '0599123456', specialty: 'طب أسنان الأطفال', avatar: 'م', category: 'B' },
    2: { name: 'سارة خالد يوسف', id: '20216732', cases: 3, phone: '0599234567', specialty: 'تقويم الأسنان', avatar: 'س', category: 'A' },
    3: { name: 'عمر محمود حسن', id: '20219854', cases: 2, phone: '0599345678', specialty: 'جراحة الفم', avatar: 'ع', category: 'B' },
    4: { name: 'فاطمة أحمد سالم', id: '20215678', cases: 4, phone: '0599456789', specialty: 'طب أسنان الأطفال', avatar: 'ف', category: 'C' }
};

const supervisorActivities = [
    { id: 1, student: 'محمد أحمد علي', activity: 'قبول حالة', details: 'طب أسنان الأطفال - السن 12', time: 'منذ 5 دقائق', type: 'approve', avatar: 'م' },
    { id: 2, student: 'سارة خالد يوسف', activity: 'رفض حالة', details: 'تقويم الأسنان - السن 24', time: 'منذ 15 دقيقة', type: 'reject', avatar: 'س' },
    { id: 3, student: 'عمر محمود حسن', activity: 'تحويل حالة', details: 'جراحة الفم - السن 18', time: 'منذ 30 دقيقة', type: 'transfer', avatar: 'ع' },
    { id: 4, student: 'فاطمة أحمد سالم', activity: 'تقييم حالة', details: 'تقييم 3 - طب أسنان الأطفال', time: 'منذ ساعة', type: 'rate', avatar: 'ف' },
    { id: 5, student: 'محمد أحمد علي', activity: 'تقييم حالة', details: 'تقييم 2 - طب أسنان الأطفال', time: 'منذ ساعتين', type: 'rate', avatar: 'م' },
    { id: 6, student: 'سارة خالد يوسف', activity: 'قبول حالة', details: 'تقويم الأسنان - السن 26', time: 'منذ 3 ساعات', type: 'approve', avatar: 'س' },
    { id: 7, student: 'عمر محمود حسن', activity: 'رفض حالة', details: 'جراحة الفم - السن 20', time: 'منذ 4 ساعات', type: 'reject', avatar: 'ع' },
    { id: 8, student: 'فاطمة أحمد سالم', activity: 'تحويل حالة', details: 'طب أسنان الأطفال - السن 14', time: 'منذ 5 ساعات', type: 'transfer', avatar: 'ف' },
    { id: 9, student: 'محمد أحمد علي', activity: 'تقييم حالة', details: 'تقييم 1 - طب أسنان الأطفال', time: 'منذ 6 ساعات', type: 'rate', avatar: 'م' },
    { id: 10, student: 'سارة خالد يوسف', activity: 'قبول حالة', details: 'تقويم الأسنان - السن 28', time: 'منذ 7 ساعات', type: 'approve', avatar: 'س' }
];

const exceptionsData = {
    1: { student: 'محمد أحمد علي', grantor: 'د. أحمد النجار', count: 2, reason: 'ظروف صحية', date: '10/01/2024' },
    2: { student: 'عمر محمود حسن', grantor: 'رئيس القسم', count: 1, reason: 'ظروف شخصية', date: '15/01/2024' }
};

// تعبئة جدول الطلاب مع التمييز
function populateStudentsTable() {
    const tbody = document.getElementById('studentsTableBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    const sortedStudents = Object.entries(studentsData).sort((a, b) => a[1].name.localeCompare(b[1].name, 'ar'));
    
    sortedStudents.forEach(([id, student]) => {
        const isSameCategory = student.category === supervisorCategory;
        const categoryClass = isSameCategory ? 'category-same' : 'category-different';
        const hasException = studentsWithExceptions[id] && studentsWithExceptions[id].active;
        
        const row = document.createElement('tr');
        row.className = 'student-row';
        row.dataset.studentId = id;
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; cursor: pointer;';
        
        // تحديد الصف المختار
        if (selectedStudentId == id) {
            row.classList.add('selected');
        }
        
        row.onclick = function() { 
            // إزالة التحديد من جميع الصفوف
            document.querySelectorAll('.student-row').forEach(r => r.classList.remove('selected'));
            // إضافة التحديد للصف الحالي
            this.classList.add('selected');
            // تحديث الطالب المختار
            selectStudent(id);
        };
        
        row.innerHTML = `
            <td style="padding: clamp(12px, 3vw, 16px);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: clamp(36px, 9vw, 44px); height: clamp(36px, 9vw, 44px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(14px, 3.5vw, 16px);">${student.avatar}</div>
                    <div style="display: flex; align-items: center;">
                        <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">${student.name}</span>
                        ${hasException ? `<span class="exception-badge"><i class="fas fa-exclamation" style="margin-left: 4px;"></i>${studentsWithExceptions[id].count}</span>` : ''}
                    </div>
                </div>
            </td>
            <td style="padding: clamp(12px, 3vw, 16px); text-align: center; color: #64748b; font-weight: 600; font-size: clamp(0.75rem, 2vw, 0.875rem);">${student.id}</td>
            <td style="padding: clamp(12px, 3vw, 16px); text-align: center;">
                <span class="category-badge ${categoryClass}">${student.category}</span>
            </td>
            <td style="padding: clamp(12px, 3vw, 16px); text-align: center; color: var(--primary); font-size: clamp(16px, 4vw, 18px); font-weight: 800;">${student.cases}</td>
        `;
        tbody.appendChild(row);
    });
}

function populateActivitiesTable() {
    const tbody = document.getElementById('activityTableBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageActivities = supervisorActivities.slice(start, end);
    
    const activityStyles = {
        approve: { bg: 'rgba(16, 185, 129, 0.1)', color: '#10b981', icon: 'fa-check-circle' },
        reject: { bg: 'rgba(239, 68, 68, 0.1)', color: '#ef4444', icon: 'fa-times-circle' },
        transfer: { bg: 'rgba(245, 158, 11, 0.1)', color: '#f59e0b', icon: 'fa-random' },
        rate: { bg: 'rgba(79, 70, 229, 0.1)', color: '#4f46e5', icon: 'fa-star' }
    };
    
    pageActivities.forEach((activity, index) => {
        const style = activityStyles[activity.type];
        const row = document.createElement('tr');
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.3s ease forwards; animation-delay: ' + (index * 0.05) + 's; opacity: 0;';
        
        row.innerHTML = `
            <td style="padding: clamp(12px, 3vw, 16px);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: clamp(32px, 8vw, 40px); height: clamp(32px, 8vw, 40px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(12px, 3vw, 14px);">${activity.avatar}</div>
                    <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.75rem, 2vw, 0.875rem);">${activity.student}</span>
                </div>
            </td>
            <td style="padding: clamp(12px, 3vw, 16px);">
                <span style="background: ${style.bg}; color: ${style.color}; padding: 6px 12px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas ${style.icon}"></i>
                    ${activity.activity}
                </span>
            </td>
            <td style="padding: clamp(12px, 3vw, 16px); text-align: center; color: #4b5563; font-size: clamp(0.75rem, 2vw, 0.875rem);">${activity.details}</td>
            <td style="padding: clamp(12px, 3vw, 16px); text-align: center; color: #9ca3af; font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">
                <i class="fas fa-clock" style="margin-left: 4px;"></i>${activity.time}
            </td>
        `;
        tbody.appendChild(row);
    });
    
    const totalPages = Math.ceil(supervisorActivities.length / itemsPerPage);
    const pageIndicator = document.getElementById('pageIndicator');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (pageIndicator) pageIndicator.textContent = `صفحة ${currentPage} من ${totalPages}`;
    
    // تجميد زر السابق في الصفحة الأولى
    if (prevBtn) {
        if (currentPage === 1) {
            prevBtn.disabled = true;
            prevBtn.classList.add('btn-disabled');
            prevBtn.style.opacity = '0.5';
            prevBtn.style.cursor = 'not-allowed';
            prevBtn.style.pointerEvents = 'none';
        } else {
            prevBtn.disabled = false;
            prevBtn.classList.remove('btn-disabled');
            prevBtn.style.opacity = '1';
            prevBtn.style.cursor = 'pointer';
            prevBtn.style.pointerEvents = 'auto';
        }
    }
    
    // تجميد زر التالي في الصفحة الأخيرة
    if (nextBtn) {
        if (currentPage === totalPages) {
            nextBtn.disabled = true;
            nextBtn.classList.add('btn-disabled');
            nextBtn.style.opacity = '0.5';
            nextBtn.style.cursor = 'not-allowed';
            nextBtn.style.pointerEvents = 'none';
            nextBtn.style.background = '#e5e7eb';
            nextBtn.style.boxShadow = 'none';
        } else {
            nextBtn.disabled = false;
            nextBtn.classList.remove('btn-disabled');
            nextBtn.style.opacity = '1';
            nextBtn.style.cursor = 'pointer';
            nextBtn.style.pointerEvents = 'auto';
            nextBtn.style.background = 'linear-gradient(135deg, var(--primary), var(--primary-light))';
            nextBtn.style.boxShadow = '0 4px 12px rgba(79, 70, 229, 0.3)';
        }
    }
}

// الدوال المساعدة
function changePage(direction) {
    const totalPages = Math.ceil(supervisorActivities.length / itemsPerPage);
    
    if (direction === 'next' && currentPage >= totalPages) return;
    if (direction === 'prev' && currentPage <= 1) return;
    
    if (direction === 'next' && currentPage < totalPages) {
        currentPage++;
        populateActivitiesTable();
    } else if (direction === 'prev' && currentPage > 1) {
        currentPage--;
        populateActivitiesTable();
    }
}

function switchTab(tabName) {
    document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');
    const selectedContent = document.getElementById(tabName + 'Content');
    if (selectedContent) {
        selectedContent.style.display = 'block';
        selectedContent.style.animation = 'fadeIn 0.3s ease';
    }
}

function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    if (!dropdown) return;
    const isOpen = dropdown.classList.contains('dropdown-open');
    closeAllDropdowns();
    if (!isOpen) dropdown.classList.add('dropdown-open');
}

function closeAllDropdowns() {
    document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('dropdown-open'));
}

function selectStudent(studentId) {
    selectedStudentId = studentId;
    const student = studentsData[studentId];
    if (student) {
        document.getElementById('selectedStudentText').textContent = `${student.name} (${student.id})`;
        document.getElementById('selectedStudentText').style.color = '#1f2937';
        document.getElementById('viewRecordBtn').disabled = false;
    }
    closeAllDropdowns();
    // تحديث الجدول لإظهار التحديد
    populateStudentsTable();
}

function openSelectedStudentRecord() {
    if (!selectedStudentId) {
        showToast('يرجى اختيار طالب أولاً', 'warning');
        return;
    }
    openStudentRecordDirect(selectedStudentId);
}

function openStudentRecordDirect(studentId) {
    const student = studentsData[studentId];
    if (!student) return;
    
    const modal = document.getElementById('studentModal');
    const modalBody = document.getElementById('modalBody');
    
    if (!modal || !modalBody) return;
    
    const studentRecords = [
        { type: 'طب أسنان الأطفال', tooth: '12', status: 'مقبولة', rating: 3, date: '2024-01-15' },
        { type: 'طب أسنان الأطفال', tooth: '14', status: 'مقبولة', rating: 2, date: '2024-01-10' },
        { type: 'تقويم الأسنان', tooth: '24', status: 'مرفوضة', rating: null, date: '2024-01-08' },
        { type: 'جراحة الفم', tooth: '18', status: 'مقبولة', rating: 1, date: '2024-01-05' }
    ];
    
    modalBody.innerHTML = `
        <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); padding: clamp(24px, 6vw, 40px); text-align: center; position: relative;">
            <button onclick="closeStudentModal()" style="position: absolute; top: clamp(12px, 3vw, 20px); left: clamp(12px, 3vw, 20px); background: rgba(255,255,255,0.2); border: none; width: clamp(36px, 9vw, 44px); height: clamp(36px, 9vw, 44px); border-radius: 50%; color: white; cursor: pointer; font-size: clamp(16px, 4vw, 20px);">
                <i class="fas fa-times"></i>
            </button>
            <div style="width: clamp(80px, 20vw, 100px); height: clamp(80px, 20vw, 100px); background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 20px);">
                <span style="font-size: clamp(36px, 9vw, 48px); font-weight: 800; background: linear-gradient(135deg, var(--primary), var(--primary-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">${student.avatar}</span>
            </div>
            <h2 style="color: white; font-size: clamp(1.25rem, 4vw, 1.75rem); font-weight: 800; margin-bottom: 8px;">${student.name}</h2>
            <p style="color: rgba(255,255,255,0.9); font-size: clamp(0.875rem, 2.5vw, 1.125rem);">
                <i class="fas fa-id-card" style="margin-left: 8px;"></i>${student.id} | ${student.specialty}
            </p>
        </div>
        <div style="padding: clamp(20px, 5vw, 32px);">
            <!-- معلومات الاتصال فقط -->
            <div style="background: #f8fafc; border-radius: clamp(12px, 3vw, 16px); padding: clamp(16px, 4vw, 20px); margin-bottom: clamp(20px, 5vw, 28px);">
                <h3 style="font-size: clamp(1rem, 2.8vw, 1.125rem); color: #1f2937; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-address-card" style="color: var(--primary);"></i>معلومات الاتصال
                </h3>
                <div style="display: flex; align-items: center; gap: 12px; padding: clamp(12px, 3vw, 14px); background: white; border-radius: 12px;">
                    <div style="width: clamp(40px, 10vw, 48px); height: clamp(40px, 10vw, 48px); background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: clamp(16px, 4vw, 18px);">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: #64748b;">رقم الموبايل</div>
                        <div style="font-weight: 700; color: #1f2937; font-size: clamp(0.9375rem, 2.5vw, 1.125rem);">${student.phone}</div>
                    </div>
                </div>
            </div>
            
            <!-- سجل الأعمال مع Checkbox للتقييم -->
            <div>
                <h3 style="font-size: clamp(1rem, 2.8vw, 1.125rem); color: #1f2937; margin-bottom: 16px;">
                    <i class="fas fa-clipboard-list" style="color: var(--primary); margin-left: 8px;"></i>سجل الأعمال
                </h3>
                <div style="overflow-x: auto; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white;">
                                <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem);">نوع الحالة</th>
                                <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem);">رقم السن</th>
                                <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem);">الحالة</th>
                                <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem);">التقييم</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${studentRecords.map((record, idx) => `
                                <tr style="background: ${idx % 2 === 0 ? 'white' : '#f8fafc'};">
                                    <td style="padding: clamp(10px, 2.5vw, 14px); font-weight: 600; font-size: clamp(0.75rem, 2vw, 0.875rem);">${record.type}</td>
                                    <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: var(--primary); font-weight: 700; font-size: clamp(0.75rem, 2vw, 0.875rem);">${record.tooth}</td>
                                    <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                                        <span style="background: ${record.status === 'مقبولة' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)'}; color: ${record.status === 'مقبولة' ? '#16a34a' : '#ef4444'}; padding: 4px 12px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;">
                                            ${record.status}
                                        </span>
                                    </td>
                                    <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                                        ${record.rating ? `
                                            <div style="display: flex; justify-content: center; gap: 6px; direction: ltr;">
                                                ${[1,2,3].map(star => `
                                                    <div class="rating-checkbox ${star <= record.rating ? 'checked' : ''}">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        ` : '<span style="color: #9ca3af; font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">بدون تقييم</span>'}
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeStudentModal() {
    const modal = document.getElementById('studentModal');
    if (modal) modal.style.display = 'none';
    document.body.style.overflow = '';
    document.getElementById('viewRecordBtn').disabled = true;
    document.getElementById('selectedStudentText').textContent = 'اختر الطالب لعرض سجله';
    document.getElementById('selectedStudentText').style.color = '#64748b';
    selectedStudentId = null;
    // إزالة التحديد من الجدول
    document.querySelectorAll('.student-row').forEach(r => r.classList.remove('selected'));
    populateStudentsTable();
}

function showExceptionDetails(exceptionId) {
    const modal = document.getElementById('exceptionModal');
    const modalBody = document.getElementById('exceptionModalBody');
    
    if (!modal || !modalBody) return;
    
    const exc = exceptionsData[exceptionId];
    
    modalBody.innerHTML = `
        <div style="text-align: center; margin-bottom: clamp(20px, 5vw, 28px);">
            <div style="width: clamp(60px, 15vw, 80px); height: clamp(60px, 15vw, 80px); background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: clamp(16px, 4vw, 24px); display: flex; align-items: center; justify-content: center; color: white; font-size: clamp(28px, 7vw, 36px); margin: 0 auto clamp(12px, 3vw, 20px);">
                <i class="fas fa-exclamation"></i>
            </div>
            <h2 style="font-size: clamp(1.125rem, 3.5vw, 1.5rem); color: #1f2937; font-weight: 800;">تفاصيل الاستثناء</h2>
        </div>
        <div style="background: #f8fafc; border-radius: clamp(16px, 4vw, 20px); padding: clamp(16px, 4vw, 24px); margin-bottom: clamp(16px, 4vw, 24px);">
            <div style="margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: #64748b; margin-bottom: 6px; font-weight: 600;">الطالب</div>
                <div style="font-size: clamp(1rem, 3vw, 1.25rem); font-weight: 800; color: #1f2937; display: flex; align-items: center; gap: 12px;">
                    <div style="width: clamp(40px, 10vw, 48px); height: clamp(40px, 10vw, 48px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(16px, 4vw, 18px);">${exc.student.charAt(0)}</div>
                    ${exc.student}
                </div>
            </div>
            <div style="margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: #64748b; margin-bottom: 6px;">مانح الاستثناء</div>
                <div style="font-size: clamp(0.9375rem, 2.5vw, 1.125rem); font-weight: 700; color: #1f2937;">
                    <i class="fas fa-user-md" style="color: var(--warning); margin-left: 8px;"></i>${exc.grantor}
                </div>
            </div>
            <div style="margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: #64748b; margin-bottom: 6px;">عدد الحالات المستثناة</div>
                <div style="font-size: clamp(2rem, 6vw, 3rem); font-weight: 800; color: var(--accent);">${exc.count}</div>
            </div>
            <div style="margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: #64748b; margin-bottom: 6px;">السبب</div>
                <div style="background: white; padding: clamp(12px, 3vw, 16px); border-radius: 12px; border: 1px solid #e2e8f0; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">${exc.reason}</div>
            </div>
            <div>
                <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: #64748b; margin-bottom: 6px;">تاريخ الاستثناء</div>
                <div style="font-size: clamp(0.9375rem, 2.5vw, 1.125rem); font-weight: 700;">
                    <i class="fas fa-calendar-alt" style="color: var(--primary); margin-left: 8px;"></i>${exc.date}
                </div>
            </div>
        </div>
        <button onclick="closeExceptionModal()" style="width: 100%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: clamp(14px, 3.5vw, 18px); border-radius: 14px; font-weight: 700; cursor: pointer; font-size: clamp(0.875rem, 2.5vw, 1rem);">
            إغلاق
        </button>
    `;
    
    modal.style.display = 'flex';
}

function closeExceptionModal() {
    const modal = document.getElementById('exceptionModal');
    if (modal) modal.style.display = 'none';
}

function showToast(message, type = 'info') {
    const colors = {
        info: { bg: 'linear-gradient(135deg, var(--primary), var(--primary-light))', icon: 'fa-info-circle' },
        success: { bg: 'linear-gradient(135deg, var(--secondary), #059669)', icon: 'fa-check-circle' },
        warning: { bg: 'linear-gradient(135deg, var(--warning), #fbbf24)', icon: 'fa-exclamation-triangle' }
    };
    const color = colors[type] || colors.info;
    const toast = document.createElement('div');
    toast.style.cssText = 'position: fixed; top: 100px; right: 16px; left: 16px; z-index: 100000; animation: slideDown 0.3s ease;';
    toast.innerHTML = `
        <div style="background: ${color.bg}; color: white; padding: clamp(12px, 3vw, 16px) clamp(16px, 4vw, 24px); border-radius: clamp(12px, 3vw, 16px); text-align: center; font-weight: 700; box-shadow: 0 10px 30px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; gap: 12px; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
            <i class="fas ${color.icon}" style="font-size: clamp(18px, 4.5vw, 24px);"></i>${message}
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.custom-dropdown')) closeAllDropdowns();
});

document.addEventListener('DOMContentLoaded', function() {
    const studentModal = document.getElementById('studentModal');
    const exceptionModal = document.getElementById('exceptionModal');
    
    if (studentModal) {
        studentModal.addEventListener('click', function(e) {
            if (e.target === this) closeStudentModal();
        });
    }
    
    if (exceptionModal) {
        exceptionModal.addEventListener('click', function(e) {
            if (e.target === this) closeExceptionModal();
        });
    }
    
    populateStudentsTable();
    populateActivitiesTable();
});
</script>
