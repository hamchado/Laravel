@extends('layouts.app')

@section('title', 'تسجيل الحجوزات')
@section('page_title', 'تسجيل الحجوزات')

@section('tabs')
<div class="tab-item active" onclick="switchTab('todayBookings')">
    <i class="fas fa-calendar-day" style="margin-left: 4px;"></i>
    حجوزات اليوم
</div>
<div class="tab-item" onclick="switchTab('tempBookings')">
    <i class="fas fa-clock" style="margin-left: 4px;"></i>
    الحجوزات المؤقتة
</div>
<div class="tab-item" onclick="switchTab('studentBookings')">
    <i class="fas fa-user-graduate" style="margin-left: 4px;"></i>
    حجوزات الطالب
</div>
<div class="tab-item" onclick="switchTab('trackBooking')">
    <i class="fas fa-route" style="margin-left: 4px;"></i>
    تتبع الحجز
</div>
<div class="tab-item" onclick="switchTab('cancelledBookings')">
    <i class="fas fa-calendar-times" style="margin-left: 4px;"></i>
    الحجوزات الملغاة
</div>
<div class="tab-item" onclick="switchTab('exceptions')">
    <i class="fas fa-star" style="margin-left: 4px;"></i>
    الاستثناءات
</div>
@endsection

@section('tab_content')
<!-- ============================================
     القسم الأول: الحجوزات المحجوزة اليوم
     ============================================ -->
<div class="tab-content" id="todayBookingsContent" style="display: block;">
    
    <!-- فلاتر البحث -->
    <div class="input-container">
        <div class="section-title">
            <i class="fas fa-filter"></i>
            <span>فلترة الحجوزات</span>
        </div>
        
        <div style="display: grid; gap: 16px;">
            <!-- Dropdown اختيار المقرر -->
            <div class="custom-dropdown" id="courseDropdown">
                <div class="dropdown-header" onclick="toggleDropdown('courseDropdown')">
                    <span id="selectedCourse">جميع المقررات</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </div>
                <div class="dropdown-options">
                    <div class="dropdown-option selected" data-value="all" onclick="selectCourse('all', 'جميع المقررات')">
                        جميع المقررات
                    </div>
                    <div class="dropdown-option" data-value="cardiology" onclick="selectCourse('cardiology', 'طب القلب السريري')">
                        طب القلب السريري
                    </div>
                    <div class="dropdown-option" data-value="respiratory" onclick="selectCourse('respiratory', 'أمراض الجهاز التنفسي')">
                        أمراض الجهاز التنفسي
                    </div>
                    <div class="dropdown-option" data-value="neurology" onclick="selectCourse('neurology', 'طب الأعصاب السريري')">
                        طب الأعصاب السريري
                    </div>
                    <div class="dropdown-option" data-value="clinical" onclick="selectCourse('clinical', 'الفحص السريري المتقدم')">
                        الفحص السريري المتقدم
                    </div>
                </div>
            </div>

            <!-- Dropdown نمط العلاج (يعتمد على المقرر) -->
            <div class="custom-dropdown" id="treatmentDropdown">
                <div class="dropdown-header" onclick="toggleDropdown('treatmentDropdown')">
                    <span id="selectedTreatment">اختر نمط العلاج</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </div>
                <div class="dropdown-options" id="treatmentOptions">
                    <div class="dropdown-option selected" data-value="">اختر نمط العلاج</div>
                </div>
            </div>

            <!-- زر البحث الإجباري -->
            <button onclick="performSearch()" class="modern-btn" style="background: var(--primary); color: white; margin-top: 8px;">
                <i class="fas fa-search" style="margin-left: 8px;"></i>
                بحث إجباري
            </button>
        </div>
    </div>

    <!-- نتائج البحث - جدول -->
    <div id="searchResults" style="display: none;">
        <div class="section-title" style="margin-top: 24px;">
            <i class="fas fa-list"></i>
            <span>نتائج البحث (<span id="resultsCount">0</span> حالة)</span>
        </div>
        
        <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb;">
            <table class="data-table" id="todayBookingsTable">
                <thead>
                    <tr>
                        <th>اسم المريض</th>
                        <th>رقم الموبايل</th>
                        <th>اسم الطالب</th>
                        <th>رقم الطالب</th>
                        <th>موبايل الطالب</th>
                        <th>السن</th>
                        <th>نمط العلاج</th>
                        <th>المقرر</th>
                        <th>المشرف</th>
                        <th>المشخص</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="todayBookingsTableBody">
                    <!-- سيتم ملؤها بالJavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- حالة عدم وجود نتائج -->
    <div id="noSearchYet" style="text-align: center; padding: 60px 20px;">
        <div style="width: 100px; height: 100px; background: var(--gray-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fas fa-search" style="font-size: 40px; color: var(--gray);"></i>
        </div>
        <div style="font-size: 18px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
            ابدأ بالبحث
        </div>
        <div style="font-size: 14px; color: var(--gray);">
            اختر المقرر ونمط العلاج ثم اضغط بحث لعرض الحجوزات
        </div>
    </div>
</div>

<!-- ============================================
     القسم الثاني: الحجوزات المؤقتة (مُحدث بفلاتر)
     ============================================ -->
<div class="tab-content" id="tempBookingsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-clock"></i>
        <span>الحجوزات المؤقتة (بانتظار التثبيت)</span>
    </div>

    <!-- فلاتر متقدمة -->
    <div class="input-container">
        <div class="section-title" style="margin-bottom: 16px;">
            <i class="fas fa-filter"></i>
            <span>فلترة الحجوزات المؤقتة</span>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <!-- Dropdown المقرر -->
            <div class="custom-dropdown" id="tempCourseDropdown">
                <div class="dropdown-header" onclick="toggleDropdown('tempCourseDropdown')">
                    <span id="selectedTempCourse">جميع المقررات</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </div>
                <div class="dropdown-options">
                    <div class="dropdown-option selected" onclick="selectTempCourse('all', 'جميع المقررات')">جميع المقررات</div>
                    <div class="dropdown-option" onclick="selectTempCourse('cardiology', 'طب القلب السريري')">طب القلب السريري</div>
                    <div class="dropdown-option" onclick="selectTempCourse('respiratory', 'أمراض الجهاز التنفسي')">أمراض الجهاز التنفسي</div>
                    <div class="dropdown-option" onclick="selectTempCourse('neurology', 'طب الأعصاب السريري')">طب الأعصاب السريري</div>
                    <div class="dropdown-option" onclick="selectTempCourse('clinical', 'الفحص السريري المتقدم')">الفحص السريري المتقدم</div>
                </div>
            </div>

            <!-- Dropdown نمط العلاج -->
            <div class="custom-dropdown" id="tempTreatmentDropdown">
                <div class="dropdown-header" onclick="toggleDropdown('tempTreatmentDropdown')">
                    <span id="selectedTempTreatment">جميع أنماط العلاج</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </div>
                <div class="dropdown-options" id="tempTreatmentOptions">
                    <div class="dropdown-option selected">جميع أنماط العلاج</div>
                </div>
            </div>
        </div>

        <button onclick="searchTempBookings()" class="modern-btn" style="background: var(--warning); color: white; margin-top: 16px;">
            <i class="fas fa-search" style="margin-left: 8px;"></i>
            بحث في الحجوزات المؤقتة
        </button>
    </div>

    <!-- جدول الحجوزات المؤقتة -->
    <div id="tempBookingsResults" style="margin-top: 20px;">
        <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>اسم المريض</th>
                        <th>رقم الموبايل</th>
                        <th>العمر</th>
                        <th>العنوان</th>
                        <th>الحالة الصحية</th>
                        <th>اسم الطالب</th>
                        <th>رقم الجامعي</th>
                        <th>موبايل الطالب</th>
                        <th>السن</th>
                        <th>نمط العلاج</th>
                        <th>المقرر</th>
                        <th>المشرف العملي</th>
                        <th>المشخص</th>
                        <th>مدخل البيانات</th>
                        <th>تاريخ الحجز المؤقت</th>
                        <th>توقيت الحجز</th>
                        <th>تاريخ تسجيل المريض</th>
                    </tr>
                </thead>
                <tbody id="tempBookingsTableBody">
                    <!-- سيتم ملؤها بالJavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================
     القسم الثالث: حجوزات الطالب (مُحدث بفلاتر)
     ============================================ -->
<div class="tab-content" id="studentBookingsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-user-graduate"></i>
        <span>حجوزات الطالب</span>
    </div>

    <!-- البحث بالرقم الجامعي + فلاتر -->
    <div class="input-container">
        <div style="display: grid; gap: 16px;">
            <div style="display: flex; gap: 12px;">
                <input type="text" id="studentSearchInput" class="modern-input" placeholder="أدخل الرقم الجامعي للطالب..." style="flex: 1;">
                <button onclick="searchStudentBookings()" class="modern-btn" style="background: var(--primary); color: white; width: auto; padding: 0 24px;">
                    <i class="fas fa-search"></i>
                    بحث
                </button>
            </div>
            
            <!-- فلاتر إضافية -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="custom-dropdown" id="studentCourseDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('studentCourseDropdown')">
                        <span id="selectedStudentCourse">فلترة حسب المقرر</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option selected" onclick="selectStudentCourse('all', 'جميع المقررات')">جميع المقررات</div>
                        <div class="dropdown-option" onclick="selectStudentCourse('cardiology', 'طب القلب السريري')">طب القلب السريري</div>
                        <div class="dropdown-option" onclick="selectStudentCourse('respiratory', 'أمراض الجهاز التنفسي')">أمراض الجهاز التنفسي</div>
                        <div class="dropdown-option" onclick="selectStudentCourse('neurology', 'طب الأعصاب السريري')">طب الأعصاب السريري</div>
                        <div class="dropdown-option" onclick="selectStudentCourse('clinical', 'الفحص السريري المتقدم')">الفحص السريري المتقدم</div>
                    </div>
                </div>

                <div class="custom-dropdown" id="studentTreatmentDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('studentTreatmentDropdown')">
                        <span id="selectedStudentTreatment">فلترة حسب نمط العلاج</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options" id="studentTreatmentOptions">
                        <div class="dropdown-option selected">جميع الأنماط</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نتائج البحث -->
    <div id="studentSearchResults" style="margin-top: 20px; display: none;">
        
        <!-- الحالات المثبتة -->
        <div class="section-title" style="margin-top: 24px;">
            <i class="fas fa-check-circle" style="color: var(--secondary);"></i>
            <span>الحالات المثبتة</span>
        </div>
        <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb; margin-bottom: 24px;">
            <table class="data-table" id="confirmedStudentTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المريض</th>
                        <th>السن</th>
                        <th>نمط العلاج</th>
                        <th>المقرر</th>
                        <th>تاريخ التثبيت</th>
                        <th>المشرف</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- الحالات المحجوزة مؤقتا -->
        <div class="section-title">
            <i class="fas fa-clock" style="color: var(--warning);"></i>
            <span>الحالات المحجوزة مؤقتاً</span>
        </div>
        <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb; margin-bottom: 24px;">
            <table class="data-table" id="tempStudentTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المريض</th>
                        <th>السن</th>
                        <th>نمط العلاج</th>
                        <th>المقرر</th>
                        <th>تاريخ الحجز المؤقت</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- الحالات المرفوضة -->
        <div class="section-title">
            <i class="fas fa-times-circle" style="color: var(--danger);"></i>
            <span>الحالات المرفوضة</span>
        </div>
        <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb; margin-bottom: 24px;">
            <table class="data-table" id="rejectedStudentTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المريض</th>
                        <th>السن</th>
                        <th>نمط العلاج</th>
                        <th>تاريخ الرفض</th>
                        <th>سبب الرفض</th>
                        <th>الموظف</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- الحالات الملغاة -->
        <div class="section-title">
            <i class="fas fa-ban" style="color: var(--gray-dark);"></i>
            <span>الحالات الملغاة</span>
        </div>
        <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb; margin-bottom: 24px;">
            <table class="data-table" id="cancelledStudentTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المريض</th>
                        <th>السن</th>
                        <th>نمط العلاج</th>
                        <th>تاريخ الإلغاء</th>
                        <th>سبب الإلغاء</th>
                        <th>الموظف</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- سجل التعديلات والحذف -->
    <div id="modificationsLog" style="margin-top: 32px; display: none;">
        <div class="section-title">
            <i class="fas fa-history" style="color: var(--accent);"></i>
            <span>سجل التعديلات والحذف (الأحدث أولاً)</span>
        </div>
        <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb;">
            <table class="data-table" id="modificationsTable">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الوقت</th>
                        <th>الإجراء</th>
                        <th>الحالة</th>
                        <th>الموظف</th>
                        <th>السبب</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================
     القسم الرابع: تتبع حجز الحالة (جدول مدمج)
     ============================================ -->
<div class="tab-content" id="trackBookingContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-route"></i>
        <span>تتبع تواريخ الحجز والحالات</span>
    </div>

    <!-- البحث المتقدم -->
    <div class="input-container">
        <div style="display: grid; gap: 16px;">
            
            <!-- Dropdown نوع البحث -->
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 12px; align-items: end;">
                <div class="custom-dropdown" id="trackSearchTypeDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('trackSearchTypeDropdown')">
                        <span id="selectedTrackSearchType">البحث حسب</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option selected" onclick="selectTrackSearchType('case_code', 'رمز الحالة')">
                            <i class="fas fa-barcode" style="margin-left: 6px;"></i>
                            رمز الحالة
                        </div>
                        <div class="dropdown-option" onclick="selectTrackSearchType('student_id', 'الرقم الجامعي')">
                            <i class="fas fa-id-card" style="margin-left: 6px;"></i>
                            الرقم الجامعي
                        </div>
                        <div class="dropdown-option" onclick="selectTrackSearchType('patient_name', 'اسم المريض')">
                            <i class="fas fa-user-injured" style="margin-left: 6px;"></i>
                            اسم المريض
                        </div>
                        <div class="dropdown-option" onclick="selectTrackSearchType('student_name', 'اسم الطالب')">
                            <i class="fas fa-user-graduate" style="margin-left: 6px;"></i>
                            اسم الطالب
                        </div>
                        <div class="dropdown-option" onclick="selectTrackSearchType('tooth_number', 'رقم السن')">
                            <i class="fas fa-tooth" style="margin-left: 6px;"></i>
                            رقم السن
                        </div>
                    </div>
                </div>
                
                <div style="position: relative;">
                    <input type="text" 
                           id="trackSearchInput" 
                           class="modern-input" 
                           placeholder="اختر نوع البحث أولاً..."
                           onkeyup="handleTrackInput(event)">
                    <button onclick="trackBooking()" 
                            style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); 
                                   background: var(--secondary); color: white; border: none; 
                                   width: 36px; height: 36px; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <!-- فلاتر إضافية -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="custom-dropdown" id="trackCourseDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('trackCourseDropdown')">
                        <span id="selectedTrackCourse">فلترة حسب المقرر</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option selected" onclick="selectTrackCourse('all', 'جميع المقررات')">جميع المقررات</div>
                        <div class="dropdown-option" onclick="selectTrackCourse('cardiology', 'طب القلب السريري')">طب القلب السريري</div>
                        <div class="dropdown-option" onclick="selectTrackCourse('respiratory', 'أمراض الجهاز التنفسي')">أمراض الجهاز التنفسي</div>
                        <div class="dropdown-option" onclick="selectTrackCourse('neurology', 'طب الأعصاب السريري')">طب الأعصاب السريري</div>
                        <div class="dropdown-option" onclick="selectTrackCourse('clinical', 'الفحص السريري المتقدم')">الفحص السريري المتقدم</div>
                    </div>
                </div>

                <div class="custom-dropdown" id="trackTreatmentDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('trackTreatmentDropdown')">
                        <span id="selectedTrackTreatment">فلترة حسب نمط العلاج</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options" id="trackTreatmentOptions">
                        <div class="dropdown-option selected">جميع الأنماط</div>
                    </div>
                </div>
            </div>
            
            <button onclick="trackBooking()" class="modern-btn" style="background: var(--secondary); color: white;">
                <i class="fas fa-search-location" style="margin-left: 8px;"></i>
                تتبع الحجز
            </button>
        </div>
    </div>

    <!-- نتائج التتبع - جدول مدمج -->
    <div id="trackResults" style="margin-top: 20px;">
        <!-- سيتم عرض النتائج في جدول مدمج -->
    </div>
</div>

<!-- ============================================
     القسم الخامس: الحجوزات الملغاة (مُحدث بفلاتر)
     ============================================ -->
<div class="tab-content" id="cancelledBookingsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-calendar-times"></i>
        <span>سجل الحجوزات الملغاة</span>
    </div>

    <!-- البحث المتقدم -->
    <div class="input-container">
        <div style="display: grid; gap: 16px;">
            
            <!-- Dropdown نوع البحث -->
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 12px; align-items: end;">
                <div class="custom-dropdown" id="cancelledSearchTypeDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('cancelledSearchTypeDropdown')">
                        <span id="selectedCancelledSearchType">البحث حسب</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option selected" onclick="selectCancelledSearchType('case_code', 'رمز الحالة')">
                            <i class="fas fa-barcode" style="margin-left: 6px;"></i>
                            رمز الحالة
                        </div>
                        <div class="dropdown-option" onclick="selectCancelledSearchType('student_id', 'الرقم الجامعي')">
                            <i class="fas fa-id-card" style="margin-left: 6px;"></i>
                            الرقم الجامعي
                        </div>
                        <div class="dropdown-option" onclick="selectCancelledSearchType('patient_name', 'اسم المريض')">
                            <i class="fas fa-user-injured" style="margin-left: 6px;"></i>
                            اسم المريض
                        </div>
                        <div class="dropdown-option" onclick="selectCancelledSearchType('student_name', 'اسم الطالب')">
                            <i class="fas fa-user-graduate" style="margin-left: 6px;"></i>
                            اسم الطالب
                        </div>
                    </div>
                </div>
                
                <div style="position: relative;">
                    <input type="text" 
                           id="cancelledSearchInput" 
                           class="modern-input" 
                           placeholder="اختر نوع البحث أولاً..."
                           onkeyup="handleCancelledInput(event)">
                    <button onclick="searchCancelledBookings()" 
                            style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); 
                                   background: var(--danger); color: white; border: none; 
                                   width: 36px; height: 36px; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <!-- فلاتر إضافية -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="custom-dropdown" id="cancelledCourseDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('cancelledCourseDropdown')">
                        <span id="selectedCancelledCourse">فلترة حسب المقرر</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option selected" onclick="selectCancelledCourse('all', 'جميع المقررات')">جميع المقررات</div>
                        <div class="dropdown-option" onclick="selectCancelledCourse('cardiology', 'طب القلب السريري')">طب القلب السريري</div>
                        <div class="dropdown-option" onclick="selectCancelledCourse('respiratory', 'أمراض الجهاز التنفسي')">أمراض الجهاز التنفسي</div>
                        <div class="dropdown-option" onclick="selectCancelledCourse('neurology', 'طب الأعصاب السريري')">طب الأعصاب السريري</div>
                        <div class="dropdown-option" onclick="selectCancelledCourse('clinical', 'الفحص السريري المتقدم')">الفحص السريري المتقدم</div>
                    </div>
                </div>

                <div class="custom-dropdown" id="cancelledTreatmentDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('cancelledTreatmentDropdown')">
                        <span id="selectedCancelledTreatment">فلترة حسب نمط العلاج</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options" id="cancelledTreatmentOptions">
                        <div class="dropdown-option selected">جميع الأنماط</div>
                    </div>
                </div>
            </div>
            
            <button onclick="searchCancelledBookings()" class="modern-btn" style="background: var(--danger); color: white;">
                <i class="fas fa-search" style="margin-left: 8px;"></i>
                بحث في الملغى
            </button>
        </div>
    </div>

    <!-- نتائج البحث -->
    <div id="cancelledResults" style="margin-top: 20px;">
        <!-- سيتم عرض النتائج في جدول منفصل -->
    </div>
</div>

<!-- ============================================
     القسم السادس: الاستثناءات (محدث بمنطقية ذكية)
     ============================================ -->
<div class="tab-content" id="exceptionsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-star"></i>
        <span>نظام الاستثناءات - منح الحالات مباشرة</span>
    </div>

    <!-- زر منح حالة جديدة -->
    <div class="input-container" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(236, 72, 153, 0.1)); border: 2px dashed var(--primary);">
        <div style="text-align: center;">
            <h3 style="font-size: 18px; color: var(--dark); margin-bottom: 16px;">
                <i class="fas fa-gift" style="color: var(--primary); margin-left: 8px;"></i>
                منح حالة استثنائية جديدة
            </h3>
            <button onclick="openGrantExceptionModal()" class="modern-btn" style="background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; max-width: 300px; margin: 0 auto;">
                <i class="fas fa-plus-circle" style="margin-left: 8px;"></i>
                منح حالة جديدة
            </button>
        </div>
    </div>

    <!-- عنوان الجدول مع زر التحديث -->
    <div class="section-title" style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-history"></i>
            <span>سجل الاستثناءات (الأحدث أولاً)</span>
        </div>
        <button onclick="refreshExceptionsData()" class="modern-btn" style="background: var(--secondary); color: white; width: auto; padding: 8px 16px; font-size: 13px;">
            <i class="fas fa-sync-alt" style="margin-left: 6px;"></i>
            تحديث البيانات
        </button>
    </div>
    
    <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb;">
        <table class="data-table" id="exceptionsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>تاريخ المنح</th>
                    <th>الوقت</th>
                    <th>رمز الحالة</th>
                    <th>رمز الاستثناء</th>
                    <th>اسم المريض</th>
                    <th>الطالب المستفيد</th>
                    <th>الرقم الجامعي</th>
                    <th>المقرر</th>
                    <th>نمط العلاج</th>
                    <th>السن</th>
                    <th>سبب الاستثناء</th>
                    <th>مانح الاستثناء</th>
                    <th>الموظف الموافق</th>
                    <th>تاريخ الموعد</th>
                    <th>توقيت الموعد</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="exceptionsTableBody">
                <!-- سيتم ملؤها بالJavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- أنماط CSS الإضافية -->
<style>
/* ============================================
   Responsive Typography System
   ============================================ */

/* Base responsive font sizes using clamp() for smooth scaling */
:root {
    --font-xs: clamp(10px, 1.2vw, 12px);
    --font-sm: clamp(11px, 1.4vw, 13px);
    --font-base: clamp(12px, 1.6vw, 14px);
    --font-md: clamp(13px, 1.8vw, 15px);
    --font-lg: clamp(14px, 2vw, 16px);
    --font-xl: clamp(16px, 2.5vw, 18px);
    --font-2xl: clamp(18px, 3vw, 20px);
    --font-3xl: clamp(20px, 3.5vw, 24px);
}

/* Global font scaling */
body {
    font-size: var(--font-base);
    line-height: 1.5;
}

/* Tab items responsive */
.tab-item {
    font-size: var(--font-sm);
    padding: clamp(8px, 1.5vw, 12px) clamp(12px, 2vw, 20px);
    white-space: nowrap;
}

/* Section titles responsive */
.section-title {
    font-size: var(--font-lg);
    font-weight: 600;
}

.section-title span {
    font-size: var(--font-md);
}

/* Input fields responsive */
.modern-input {
    font-size: var(--font-base);
    padding: clamp(10px, 1.5vw, 14px);
}

/* Dropdown responsive */
.dropdown-header {
    font-size: var(--font-base);
    padding: clamp(10px, 1.5vw, 14px);
}

.dropdown-option {
    font-size: var(--font-sm);
    padding: clamp(8px, 1.2vw, 12px);
}

/* Buttons responsive */
.modern-btn {
    font-size: var(--font-sm);
    padding: clamp(10px, 1.5vw, 14px) clamp(16px, 2.5vw, 24px);
}

/* Data Table Styles - Responsive */
.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: var(--font-xs);
}

.data-table thead {
    background: linear-gradient(135deg, var(--primary), #6366f1);
    color: white;
}

.data-table th {
    padding: clamp(8px, 1.2vw, 14px) clamp(6px, 1vw, 12px);
    text-align: right;
    font-weight: 600;
    white-space: nowrap;
    font-size: var(--font-xs);
}

.data-table td {
    padding: clamp(8px, 1.2vw, 12px) clamp(6px, 1vw, 12px);
    border-bottom: 1px solid #f3f4f6;
    text-align: right;
    vertical-align: middle;
    font-size: var(--font-xs);
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.data-table tbody tr:hover {
    background: rgba(79, 70, 229, 0.03);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

/* Status badges - Responsive */
.badge {
    padding: clamp(3px, 0.8vw, 6px) clamp(6px, 1.2vw, 10px);
    border-radius: 12px;
    font-size: clamp(9px, 1.1vw, 11px);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-confirmed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--secondary);
}

.badge-temp {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.badge-rejected {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.badge-cancelled {
    background: rgba(107, 114, 128, 0.1);
    color: var(--gray-dark);
}

.badge-completed {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.badge-transferred {
    background: rgba(139, 92, 246, 0.1);
    color: #8b5cf6;
}

/* Action buttons - Responsive */
.action-btns {
    display: flex;
    gap: 6px;
}

.btn-icon {
    width: clamp(28px, 3.5vw, 32px);
    height: clamp(28px, 3.5vw, 32px);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: clamp(12px, 1.5vw, 14px);
    transition: all 0.2s;
}

.btn-view {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
}

.btn-edit {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.btn-cancel {
    background: rgba(107, 114, 128, 0.1);
    color: var(--gray-dark);
}

.btn-icon:hover {
    transform: scale(1.1);
}

/* Modal Styles - Responsive */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 2000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: clamp(10px, 3vw, 20px);
}

.modal-overlay.active {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: var(--radius-lg);
    width: 100%;
    max-width: 700px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.modal-header {
    padding: clamp(16px, 2.5vw, 20px);
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    font-size: var(--font-lg);
    color: var(--dark);
}

.modal-body {
    padding: clamp(16px, 2.5vw, 20px);
}

.modal-footer {
    padding: clamp(16px, 2.5vw, 20px);
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 12px;
}

.form-group {
    margin-bottom: clamp(12px, 2vw, 16px);
}

.form-group label {
    display: block;
    font-size: var(--font-sm);
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 6px;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: clamp(10px, 1.5vw, 14px);
    border: 2px solid #e5e7eb;
    border-radius: var(--radius-sm);
    font-family: inherit;
    font-size: var(--font-base);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
}

/* Autocomplete Styles - Responsive */
.autocomplete-container {
    position: relative;
}

.autocomplete-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e5e7eb;
    border-top: none;
    border-radius: 0 0 var(--radius-sm) var(--radius-sm);
    max-height: 200px;
    overflow-y: auto;
    z-index: 100;
    display: none;
    box-shadow: var(--shadow);
}

.autocomplete-list.active {
    display: block;
}

.autocomplete-item {
    padding: clamp(8px, 1.2vw, 12px);
    cursor: pointer;
    border-bottom: 1px solid #f3f4f6;
    transition: background 0.2s;
    font-size: var(--font-sm);
}

.autocomplete-item:hover {
    background: rgba(79, 70, 229, 0.05);
}

.autocomplete-item.selected {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
}

/* Read-only fields */
.form-group input[readonly] {
    background: var(--gray-light);
    cursor: not-allowed;
}

/* Exception Code Badge - Responsive */
.exception-code-badge {
    background: linear-gradient(135deg, var(--accent), #db2777);
    color: white;
    padding: clamp(3px, 0.8vw, 6px) clamp(6px, 1.2vw, 10px);
    border-radius: 12px;
    font-size: clamp(9px, 1.1vw, 11px);
    font-weight: 700;
    font-family: monospace;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* Cancel Info Box - Responsive */
.cancel-info-box {
    background: rgba(239, 68, 68, 0.05);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: var(--radius-sm);
    padding: clamp(10px, 1.5vw, 14px);
    margin-top: 12px;
}

.cancel-info-title {
    font-size: var(--font-xs);
    font-weight: 600;
    color: var(--danger);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.cancel-info-row {
    display: flex;
    justify-content: space-between;
    font-size: var(--font-xs);
    margin-bottom: 4px;
}

.cancel-info-label {
    color: var(--gray);
}

.cancel-info-value {
    color: var(--dark);
    font-weight: 500;
}

/* Refresh button animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.fa-sync-alt.spinning {
    animation: spin 1s linear infinite;
}

/* Track Table Styles - جدول تتبع الحجز المدمج */
.track-table-container {
    margin-bottom: 20px;
    border-radius: var(--radius);
    overflow: hidden;
    border: 1px solid #e5e7eb;
    background: white;
}

.track-table-header {
    padding: clamp(12px, 2vw, 16px);
    background: linear-gradient(135deg, var(--primary), #6366f1);
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.track-header-info {
    display: flex;
    align-items: center;
    gap: clamp(12px, 2vw, 20px);
    flex-wrap: wrap;
}

.track-header-code {
    font-family: monospace;
    font-weight: 700;
    font-size: var(--font-md);
    background: rgba(255, 255, 255, 0.2);
    padding: 4px 10px;
    border-radius: 6px;
}

.track-header-patient {
    font-weight: 600;
    font-size: var(--font-md);
}

.track-header-details {
    display: flex;
    gap: clamp(12px, 2vw, 20px);
    font-size: var(--font-sm);
    opacity: 0.9;
    flex-wrap: wrap;
}

.track-status-badge-large {
    padding: clamp(6px, 1vw, 8px) clamp(12px, 2vw, 16px);
    border-radius: 20px;
    font-size: var(--font-sm);
    font-weight: 600;
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.track-table-content {
    overflow-x: auto;
}

.track-timeline-table {
    width: 100%;
    border-collapse: collapse;
    font-size: var(--font-xs);
}

.track-timeline-table th {
    background: #f9fafb;
    padding: clamp(10px, 1.5vw, 14px);
    text-align: right;
    font-weight: 600;
    color: var(--dark);
    border-bottom: 2px solid #e5e7eb;
    white-space: nowrap;
}

.track-timeline-table td {
    padding: clamp(12px, 2vw, 16px);
    border-bottom: 1px solid #f3f4f6;
    text-align: right;
    vertical-align: top;
}

.track-phase-row {
    background: rgba(79, 70, 229, 0.02);
}

.track-phase-row:hover {
    background: rgba(79, 70, 229, 0.05);
}

.track-phase-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    margin-left: 8px;
}

.track-phase-icon.temp { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
.track-phase-icon.permanent { background: linear-gradient(135deg, var(--primary), #6366f1); }
.track-phase-icon.start { background: linear-gradient(135deg, #10b981, #34d399); }
.track-phase-icon.end { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.track-phase-icon.cancel { background: linear-gradient(135deg, #ef4444, #f87171); }
.track-phase-icon.transfer { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }

.track-phase-title {
    font-weight: 600;
    color: var(--dark);
    display: flex;
    align-items: center;
}

.track-phase-date {
    font-size: var(--font-xs);
    color: var(--gray);
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 4px;
}

.track-phase-employee {
    font-size: var(--font-xs);
    color: var(--primary);
    margin-top: 4px;
}

.track-phase-notes {
    color: var(--dark);
    line-height: 1.5;
}

.track-phase-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: clamp(10px, 1.1vw, 12px);
    font-weight: 600;
}

.track-phase-status.completed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--secondary);
}

.track-phase-status.pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.track-phase-status.cancelled {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.track-info-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: clamp(12px, 2vw, 16px);
    padding: clamp(12px, 2vw, 16px);
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.track-info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.track-info-label {
    font-size: var(--font-xs);
    color: var(--gray);
    font-weight: 500;
}

.track-info-value {
    font-size: var(--font-sm);
    color: var(--dark);
    font-weight: 600;
}

/* ============================================
   NEW: Exception Modal Smart Layout
   ============================================ */
.exception-form-section {
    background: var(--gray-light);
    padding: clamp(12px, 2vw, 16px);
    border-radius: var(--radius);
    margin-bottom: 16px;
    border: 1px solid #e5e7eb;
}

.exception-form-section-title {
    font-size: var(--font-sm);
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.exception-form-section-title i {
    color: var(--primary);
}

/* Student Category Badge */
.student-category-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-right: 8px;
}

.category-morning {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.category-evening {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
}

/* Auto-assigned Time Display */
.auto-time-display {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: var(--radius-sm);
    padding: 10px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 8px;
}

.auto-time-display label {
    font-size: 11px;
    color: var(--gray);
    margin: 0;
}

.auto-time-display .time-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--secondary);
    font-family: monospace;
}

/* Available Days Chips */
.available-days-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.day-chip {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    background: var(--gray-light);
    color: var(--gray-dark);
    border: 1px solid #e5e7eb;
    cursor: not-allowed;
    transition: all 0.2s;
}

.day-chip.available {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
    border-color: var(--primary);
    cursor: pointer;
}

.day-chip.available:hover {
    background: var(--primary);
    color: white;
}

.day-chip.selected {
    background: var(--primary);
    color: white;
    box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
}

.day-chip.disabled {
    opacity: 0.4;
    text-decoration: line-through;
}

/* Course Info Box */
.course-info-box {
    background: rgba(79, 70, 229, 0.05);
    border-right: 3px solid var(--primary);
    padding: 12px;
    border-radius: var(--radius-sm);
    margin-top: 8px;
    font-size: 12px;
    color: var(--dark);
}

.course-info-box strong {
    color: var(--primary);
}

/* Locked Field Indicator */
.locked-field {
    position: relative;
}

.locked-field::after {
    content: '\f023';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    font-size: 12px;
}

/* ============================================
   Breakpoint Specific Adjustments
   ============================================ */

/* Large screens (1200px+) */
@media (min-width: 1200px) {
    .data-table {
        font-size: 13px;
    }
}

/* Tablets (768px - 1199px) */
@media (max-width: 1199px) and (min-width: 768px) {
    .tab-item {
        font-size: 12px;
    }
    
    .data-table {
        font-size: 11px;
    }
}

/* Small tablets and large phones (576px - 767px) */
@media (max-width: 767px) and (min-width: 576px) {
    .section-title {
        font-size: 14px;
    }
    
    .tab-item {
        font-size: 11px;
        padding: 8px 12px;
    }
    
    .data-table {
        font-size: 10px;
    }
    
    .data-table th,
    .data-table td {
        padding: 8px 6px;
    }
    
    .track-header-details {
        flex-direction: column;
        gap: 4px;
    }
}

/* Mobile phones (< 576px) */
@media (max-width: 575px) {
    .section-title {
        font-size: 13px;
    }
    
    .tab-item {
        font-size: 10px;
        padding: 6px 10px;
        flex: 1;
        justify-content: center;
    }
    
    .tab-item i {
        font-size: 12px;
        margin-left: 4px;
    }
    
    .modern-input,
    .dropdown-header,
    .modern-btn {
        font-size: 12px;
        padding: 10px 12px;
    }
    
    .data-table {
        font-size: 9px;
    }
    
    .data-table th,
    .data-table td {
        padding: 6px 4px;
    }
    
    .badge {
        font-size: 9px;
        padding: 2px 6px;
    }
    
    .track-table-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .track-header-details {
        font-size: 11px;
    }
    
    .track-timeline-table th,
    .track-timeline-table td {
        padding: 8px;
    }
    
    .track-phase-icon {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }
    
    .track-info-summary {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .modal-header h3 {
        font-size: 14px;
    }
    
    .form-group label {
        font-size: 11px;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        font-size: 12px;
        padding: 10px;
    }
    
    /* Horizontal scroll for tables on mobile */
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .data-table {
        min-width: 800px;
    }
    
    /* Better touch targets on mobile */
    .btn-icon {
        width: 36px;
        height: 36px;
    }
    
    .dropdown-option {
        padding: 12px;
        min-height: 44px;
        display: flex;
        align-items: center;
    }
    
    .autocomplete-item {
        padding: 12px;
        min-height: 44px;
    }
    
    /* Exception modal mobile adjustments */
    .auto-time-display {
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
    }
    
    .available-days-container {
        justify-content: center;
    }
    
    .day-chip {
        padding: 8px 14px;
        font-size: 13px;
    }
}

/* Very small screens (< 360px) */
@media (max-width: 359px) {
    .tab-item {
        font-size: 9px;
        padding: 5px 8px;
    }
    
    .section-title {
        font-size: 12px;
    }
    
    .track-info-summary {
        grid-template-columns: 1fr;
    }
}

/* Landscape mode adjustments */
@media (max-height: 500px) and (orientation: landscape) {
    .modal-content {
        max-height: 80vh;
    }
}

/* High DPI screens (Retina) */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .data-table th,
    .data-table td {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
}
</style>

<!-- Modal منح الاستثناء - النسخة الذكية -->
<div class="modal-overlay" id="grantExceptionModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-star" style="color: var(--accent); margin-left: 8px;"></i>منح حالة استثنائية</h3>
            <button onclick="closeGrantExceptionModal()" style="background: none; border: none; font-size: 20px; color: var(--gray); cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            
            <!-- القسم 1: بيانات الحالة -->
            <div class="exception-form-section">
                <div class="exception-form-section-title">
                    <i class="fas fa-folder-open"></i>
                    بيانات الحالة
                </div>
                
                <!-- البحث برمز الحالة -->
                <div class="form-group">
                    <label><i class="fas fa-barcode" style="margin-left: 6px; color: var(--primary);"></i>رمز الحالة من السجل <span style="color: var(--danger);">*</span></label>
                    <div class="autocomplete-container">
                        <input type="text" 
                               id="exceptionCaseCode" 
                               placeholder="ابدأ بالكتابة للبحث..."
                               onkeyup="searchCaseCode(this.value)"
                               onfocus="showCaseCodeSuggestions()"
                               autocomplete="off">
                        <div class="autocomplete-list" id="caseCodeSuggestions"></div>
                    </div>
                    <div style="font-size: 12px; color: var(--gray); margin-top: 4px;">
                        <i class="fas fa-info-circle"></i>
                        اكتب رمز الحالة أو جزء منه للبحث السريع - سيتم استخراج رقم السن تلقائياً
                    </div>
                </div>

                <!-- بيانات تُجلب تلقائياً -->
                <div style="background: white; padding: 12px; border-radius: var(--radius-sm); border: 1px solid #e5e7eb; margin-top: 12px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>نوع العلاج</label>
                            <input type="text" id="autoTreatmentType" readonly placeholder="يُجلب تلقائياً" class="locked-field">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>اسم المريض</label>
                            <input type="text" id="autoPatientName" readonly placeholder="يُجلب تلقائياً" class="locked-field">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>رقم موبايل المريض</label>
                            <input type="text" id="autoPatientPhone" readonly placeholder="يُجلب تلقائياً" class="locked-field">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>العمر</label>
                            <input type="text" id="autoPatientAge" readonly placeholder="يُجلب تلقائياً" class="locked-field">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>رقم السن المرتبط <i class="fas fa-link" style="color: var(--primary);"></i></label>
                            <input type="text" id="autoToothNumber" readonly placeholder="يُجلب مع رمز الحالة" style="font-weight: 600; color: var(--primary);" class="locked-field">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>رمز الاستثناء التلقائي</label>
                            <input type="text" id="autoExceptionCode" readonly placeholder="يُولد تلقائياً" style="font-family: monospace; font-weight: 600; color: var(--accent);" class="locked-field">
                        </div>
                    </div>
                </div>
            </div>

            <!-- القسم 2: بيانات الطالب (المنطقية الجديدة) -->
            <div class="exception-form-section">
                <div class="exception-form-section-title">
                    <i class="fas fa-user-graduate"></i>
                    بيانات الطالب والمقرر
                </div>
                
                <!-- البحث بالرقم الجامعي -->
                <div class="form-group">
                    <label><i class="fas fa-id-card" style="margin-left: 6px; color: var(--primary);"></i>الرقم الجامعي للطالب <span style="color: var(--danger);">*</span></label>
                    <div class="autocomplete-container">
                        <input type="text" 
                               id="exceptionStudentId" 
                               placeholder="ابدأ بالكتابة للبحث..."
                               onkeyup="searchStudentId(this.value)"
                               onfocus="showStudentSuggestions()"
                               onchange="onStudentSelected()"
                               autocomplete="off">
                        <div class="autocomplete-list" id="studentSuggestions"></div>
                    </div>
                </div>

                <!-- بيانات الطالب تُجلب تلقائياً -->
                <div style="background: white; padding: 12px; border-radius: var(--radius-sm); border: 1px solid #e5e7eb; margin-bottom: 12px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>اسم الطالب</label>
                            <input type="text" id="autoStudentName" readonly placeholder="يُجلب تلقائياً" class="locked-field">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>رقم الموبايل</label>
                            <input type="text" id="autoStudentPhone" readonly placeholder="يُجلب تلقائياً" class="locked-field">
                        </div>
                    </div>
                </div>

                <!-- فئة الطالب (تُعرض تلقائياً) -->
                <div class="form-group" id="studentCategoryGroup" style="display: none;">
                    <label>فئة الطالب</label>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <input type="text" id="studentCategoryDisplay" readonly style="flex: 1; font-weight: 600;" class="locked-field">
                        <span id="studentCategoryBadge" class="student-category-badge"></span>
                    </div>
                    <input type="hidden" id="studentCategory">
                </div>

                <!-- اختيار المقرر (يظهر بعد اختيار الطالب) -->
                <div class="form-group" id="courseSelectionGroup" style="display: none;">
                    <label><i class="fas fa-book" style="margin-left: 6px; color: var(--primary);"></i>اختيار المقرر <span style="color: var(--danger);">*</span></label>
                    <select id="exceptionCourse" onchange="onCourseSelected()">
                        <option value="">اختر المقرر المناسب...</option>
                        <option value="cardiology">طب القلب السريري</option>
                        <option value="respiratory">أمراض الجهاز التنفسي</option>
                        <option value="neurology">طب الأعصاب السريري</option>
                        <option value="clinical">الفحص السريري المتقدم</option>
                    </select>
                    
                    <!-- معلومات المقرر -->
                    <div id="courseInfoBox" class="course-info-box" style="display: none;">
                        <i class="fas fa-info-circle"></i>
                        <span id="courseScheduleInfo"></span>
                    </div>
                </div>
            </div>

            <!-- القسم 3: تحديد الموعد (يظهر بعد اختيار المقرر) -->
            <div class="exception-form-section" id="appointmentSection" style="display: none;">
                <div class="exception-form-section-title">
                    <i class="fas fa-calendar-alt"></i>
                    تحديد موعد الاستثناء
                </div>
                
                <!-- التوقيت التلقائي (حسب فئة الطالب) -->
                <div class="form-group">
                    <label><i class="fas fa-clock" style="margin-left: 6px; color: var(--primary);"></i>التوقيت المخصص <span style="color: var(--danger);">*</span></label>
                    <div class="auto-time-display">
                        <label>الفترة الزمنية المخصصة لفئة الطالب:</label>
                        <div class="time-value" id="assignedTimeSlot">--:-- - --:--</div>
                    </div>
                    <input type="hidden" id="exceptionAppointmentTime">
                    <div style="font-size: 11px; color: var(--gray); margin-top: 4px;">
                        <i class="fas fa-info-circle"></i>
                        يتم تحديد التوقيت تلقائياً حسب فئة الطالب (صباحي/مسائي)
                    </div>
                </div>

                <!-- اختيار اليوم (حسب جدول المقرر) -->
                <div class="form-group">
                    <label><i class="fas fa-calendar-day" style="margin-left: 6px; color: var(--primary);"></i>اختيار اليوم <span style="color: var(--danger);">*</span></label>
                    <div class="available-days-container" id="availableDaysContainer">
                        <!-- سيتم ملؤها بالJavaScript حسب المقرر -->
                    </div>
                    <input type="hidden" id="exceptionAppointmentDate">
                    <input type="hidden" id="selectedDayName">
                    <div id="daySelectionError" style="color: var(--danger); font-size: 12px; margin-top: 6px; display: none;">
                        <i class="fas fa-exclamation-circle"></i>
                        يرجى اختيار يوم من الأيام المتاحة أعلاه
                    </div>
                </div>
            </div>

            <!-- القسم 4: بيانات الاستثناء -->
            <div class="exception-form-section">
                <div class="exception-form-section-title">
                    <i class="fas fa-clipboard-check"></i>
                    بيانات الاستثناء
                </div>
                
                <div class="form-group">
                    <label>سبب الاستثناء <span style="color: var(--danger);">*</span></label>
                    <textarea id="exceptionReason" rows="3" placeholder="اكتب سبب منح الاستثناء..."></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label>مانح الاستثناء <span style="color: var(--danger);">*</span></label>
                        <select id="exceptionGranter">
                            <option value="">اختر المانح</option>
                            <option value="dean">العميد</option>
                            <option value="vice_dean">نائب العميد للشؤون العلمية</option>
                            <option value="head_department">رئيس الدائرة</option>
                            <option value="theory_instructor">مدرس المقرر النظري</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>الموظف الموافق <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="exceptionApprover" readonly value="محمد أحمد الخالد" class="locked-field">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="submitException()" class="modern-btn" style="flex: 1; background: var(--primary); color: white;">
                <i class="fas fa-check" style="margin-left: 8px;"></i>
                تثبيت ومنح الاستثناء
            </button>
            <button onclick="closeGrantExceptionModal()" class="modern-btn" style="flex: 1; background: var(--gray-light); color: var(--dark);">
                إلغاء
            </button>
        </div>
    </div>
</div>

<!-- Modal إلغاء الاستثناء -->
<div class="modal-overlay" id="cancelExceptionModal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3><i class="fas fa-ban" style="color: var(--danger); margin-left: 8px;"></i>إلغاء استثناء</h3>
            <button onclick="closeCancelExceptionModal()" style="background: none; border: none; font-size: 20px; color: var(--gray); cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>سبب الإلغاء <span style="color: var(--danger);">*</span></label>
                <textarea id="cancelExceptionReason" rows="3" placeholder="اكتب سبب إلغاء الاستثناء..."></textarea>
            </div>
            <div class="form-group">
                <label>الموظف المنفذ <span style="color: var(--danger);">*</span></label>
                <input type="text" id="cancelExceptionEmployee" readonly value="محمد أحمد الخالد" class="locked-field">
            </div>
            <div class="form-group">
                <label>وقت الإلغاء</label>
                <input type="text" id="cancelExceptionTime" readonly class="locked-field">
            </div>
            <input type="hidden" id="cancelExceptionId">
        </div>
        <div class="modal-footer">
            <button onclick="confirmCancelException()" class="modern-btn" style="flex: 1; background: var(--danger); color: white;">
                <i class="fas fa-check" style="margin-left: 8px;"></i>
                تأكيد الإلغاء
            </button>
            <button onclick="closeCancelExceptionModal()" class="modern-btn" style="flex: 1; background: var(--gray-light); color: var(--dark);">
                إلغاء
            </button>
        </div>
    </div>
</div>

<!-- Modal تعديل/حذف -->
<div class="modal-overlay" id="actionModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="actionModalTitle">تعديل بيانات</h3>
            <button onclick="closeActionModal()" style="background: none; border: none; font-size: 20px; color: var(--gray); cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>السبب (إجباري)</label>
                <textarea id="actionReason" rows="3" placeholder="اكتب سبب التعديل أو الحذف..."></textarea>
            </div>
            <div class="form-group">
                <label>اسم الموظف</label>
                <input type="text" id="actionEmployee" readonly value="محمد أحمد الخالد" class="locked-field">
            </div>
            <input type="hidden" id="actionType">
            <input type="hidden" id="actionBookingId">
            <input type="hidden" id="actionTableType">
        </div>
        <div class="modal-footer">
            <button onclick="confirmAction()" class="modern-btn" style="flex: 1; background: var(--danger); color: white;">
                <i class="fas fa-check" style="margin-left: 8px;"></i>
                تأكيد
            </button>
            <button onclick="closeActionModal()" class="modern-btn" style="flex: 1; background: var(--gray-light); color: var(--dark);">
                إلغاء
            </button>
        </div>
    </div>
</div>

<!-- Modal التراجع -->
<div class="modal-overlay" id="revertModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-undo" style="color: var(--secondary); margin-left: 8px;"></i>التراجع عن الإجراء</h3>
            <button onclick="closeRevertModal()" style="background: none; border: none; font-size: 20px; color: var(--gray); cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>سبب التراجع</label>
                <textarea id="revertReason" rows="3" placeholder="اكتب سبب التراجع..."></textarea>
            </div>
            <div class="form-group">
                <label>اسم الموظف المراجع</label>
                <input type="text" id="revertEmployee" readonly value="محمد أحمد الخالد" class="locked-field">
            </div>
            <input type="hidden" id="revertLogId">
        </div>
        <div class="modal-footer">
            <button onclick="confirmRevert()" class="modern-btn" style="flex: 1; background: var(--secondary); color: white;">
                <i class="fas fa-undo" style="margin-left: 8px;"></i>
                تراجع
            </button>
            <button onclick="closeRevertModal()" class="modern-btn" style="flex: 1; background: var(--gray-light); color: var(--dark);">
                إلغاء
            </button>
        </div>
    </div>
</div>

<script>
// ==========================================
// بيانات تجريبية شاملة ومفصلة
// ==========================================
const bookingsData = [
    {
        id: 1,
        patientName: "أحمد محمد علي",
        patientInitial: "أ",
        patientAge: 45,
        patientAddress: "دمشق - المزة",
        patientPhone: "0991234567",
        patientHealthStatus: "مستقر",
        
        studentName: "خالد محمود سالم",
        studentId: "202301234",
        studentPhone: "0999876543",
        
        toothNumber: "26",
        treatmentType: "حشوة تجميلية",
        course: "طب القلب السريري",
        
        supervisorDoctor: "د. سامر الحلبي",
        diagnosingDoctor: "د. لينا محمود",
        dataEntryStaff: "أحمد الخالد",
        
        // مراحل الحجز المفصلة
        tempBookingDate: "2024-01-15",
        tempBookingTime: "10:30 ص",
        tempBookingEmployee: "محمد أحمد الخالد",
        
        permanentBookingDate: "2024-01-20",
        permanentBookingTime: "09:00 ص",
        permanentBookingEmployee: "أحمد محمود",
        
        // مراحل العمل
        workStartDate: "2024-01-22",
        workStartTime: "10:15 ص",
        workStartEmployee: "د. سامر الحلبي",
        workStartNotes: "تم بدء العمل على الحشوة التجميلية للسن 26",
        
        workEndDate: "2024-01-22",
        workEndTime: "11:30 ص",
        workEndEmployee: "د. سامر الحلبي",
        workEndNotes: "تم إكمال الحشوة بنجاح، الحالة مستقرة",
        
        // حالة الحالة
        caseStatus: "completed", // active, completed, cancelled, transferred
        caseStatusLabel: "منتهية",
        
        // إذا كانت محولة أو ملغاة
        transferDate: null,
        transferReason: null,
        transferTo: null,
        
        cancellationDate: null,
        cancellationReason: null,
        cancellationEmployee: null,
        
        patientRegistrationDate: "2024-01-10",
        caseCode: "CASE-2024-001"
    },
    {
        id: 2,
        patientName: "سارة أحمد الخالد",
        patientInitial: "س",
        patientAge: 32,
        patientAddress: "دمشق - المالكي",
        patientPhone: "0992345678",
        patientHealthStatus: "جيد",
        
        studentName: "نور الدين يوسف",
        studentId: "202301567",
        studentPhone: "0998765432",
        
        toothNumber: "14",
        treatmentType: "علاج عصب",
        course: "أمراض الجهاز التنفسي",
        
        supervisorDoctor: "د. لينا محمود",
        diagnosingDoctor: "د. خالد أحمد",
        dataEntryStaff: "محمد السيد",
        
        tempBookingDate: "2024-01-16",
        tempBookingTime: "11:00 ص",
        tempBookingEmployee: "محمد أحمد الخالد",
        
        permanentBookingDate: null,
        permanentBookingTime: null,
        permanentBookingEmployee: null,
        
        workStartDate: null,
        workStartTime: null,
        workStartEmployee: null,
        workStartNotes: null,
        
        workEndDate: null,
        workEndTime: null,
        workEndEmployee: null,
        workEndNotes: null,
        
        caseStatus: "active",
        caseStatusLabel: "نشطة - بانتظار التثبيت",
        
        transferDate: null,
        transferReason: null,
        transferTo: null,
        
        cancellationDate: null,
        cancellationReason: null,
        cancellationEmployee: null,
        
        patientRegistrationDate: "2024-01-12",
        caseCode: "CASE-2024-002"
    },
    {
        id: 3,
        patientName: "محمد عمر النجار",
        patientInitial: "م",
        patientAge: 58,
        patientAddress: "دمشق - المهاجرين",
        patientPhone: "0993456789",
        patientHealthStatus: "مستقر",
        
        studentName: "خالد محمود سالم",
        studentId: "202301234",
        studentPhone: "0999876543",
        
        toothNumber: "18",
        treatmentType: "تاج",
        course: "طب الأعصاب السريري",
        
        supervisorDoctor: "د. خالد أحمد",
        diagnosingDoctor: "د. سامر الحلبي",
        dataEntryStaff: "أحمد الخالد",
        
        tempBookingDate: "2024-01-14",
        tempBookingTime: "09:00 ص",
        tempBookingEmployee: "أحمد محمود",
        
        permanentBookingDate: "2024-01-19",
        permanentBookingTime: "10:00 ص",
        permanentBookingEmployee: "محمد أحمد الخالد",
        
        workStartDate: "2024-01-21",
        workStartTime: "11:05 ص",
        workStartEmployee: "د. خالد أحمد",
        workStartNotes: "تم بدء تحضير السن للتاج",
        
        workEndDate: null,
        workEndTime: null,
        workEndEmployee: null,
        workEndNotes: null,
        
        caseStatus: "active",
        caseStatusLabel: "نشطة - قيد العلاج",
        
        transferDate: null,
        transferReason: null,
        transferTo: null,
        
        cancellationDate: null,
        cancellationReason: null,
        cancellationEmployee: null,
        
        patientRegistrationDate: "2024-01-08",
        caseCode: "CASE-2024-003"
    },
    {
        id: 4,
        patientName: "فاطمة علي حسن",
        patientInitial: "ف",
        patientAge: 28,
        patientAddress: "دمشق - الميدان",
        patientPhone: "0994567890",
        patientHealthStatus: "ممتاز",
        
        studentName: "سارة نور الدين",
        studentId: "202301890",
        studentPhone: "0997654321",
        
        toothNumber: "32",
        treatmentType: "خلع",
        course: "طب القلب السريري",
        
        supervisorDoctor: "د. سامر الحلبي",
        diagnosingDoctor: "د. لينا محمود",
        dataEntryStaff: "محمد السيد",
        
        tempBookingDate: "2024-01-18",
        tempBookingTime: "14:30 م",
        tempBookingEmployee: "محمد أحمد الخالد",
        
        permanentBookingDate: "2024-01-25",
        permanentBookingTime: "10:00 ص",
        permanentBookingEmployee: "أحمد محمود",
        
        workStartDate: "2024-01-25",
        workStartTime: "10:15 ص",
        workStartEmployee: "د. سامر الحلبي",
        workStartNotes: "تم الخلع بنجاح",
        
        workEndDate: "2024-01-25",
        workEndTime: "10:45 ص",
        workEndEmployee: "د. سامر الحلبي",
        workEndNotes: "تم إغلاق الجرح وإعطاء التعليمات اللازمة",
        
        caseStatus: "transferred",
        caseStatusLabel: "محولة لقسم التعويضات",
        
        transferDate: "2024-01-26",
        transferReason: "الحالة تحتاج لزراعة سن",
        transferTo: "قسم جراحة الفم والفكين",
        
        cancellationDate: null,
        cancellationReason: null,
        cancellationEmployee: null,
        
        patientRegistrationDate: "2024-01-15",
        caseCode: "CASE-2024-004"
    },
    {
        id: 5,
        patientName: "محمود خالد العمري",
        patientInitial: "م",
        patientAge: 52,
        patientAddress: "دمشق - المالكي",
        patientPhone: "0995678901",
        patientHealthStatus: "مستقر",
        
        studentName: "أحمد محمود سالم",
        studentId: "202302345",
        studentPhone: "0996543210",
        
        toothNumber: "12",
        treatmentType: "تنظيف",
        course: "أمراض الجهاز التنفسي",
        
        supervisorDoctor: "د. خالد أحمد",
        diagnosingDoctor: "د. سامر الحلبي",
        dataEntryStaff: "أحمد الخالد",
        
        tempBookingDate: "2024-01-20",
        tempBookingTime: "09:30 ص",
        tempBookingEmployee: "محمد أحمد الخالد",
        
        permanentBookingDate: null,
        permanentBookingTime: null,
        permanentBookingEmployee: null,
        
        workStartDate: null,
        workStartTime: null,
        workStartEmployee: null,
        workStartNotes: null,
        
        workEndDate: null,
        workEndTime: null,
        workEndEmployee: null,
        workEndNotes: null,
        
        caseStatus: "cancelled",
        caseStatusLabel: "ملغاة",
        
        transferDate: null,
        transferReason: null,
        transferTo: null,
        
        cancellationDate: "2024-01-21",
        cancellationReason: "المريض لم يحضر في الموعد المحدد",
        cancellationEmployee: "محمد أحمد الخالد",
        
        patientRegistrationDate: "2024-01-18",
        caseCode: "CASE-2024-005"
    }
];

// بيانات رموز الحالات للبحث السريع
const caseCodesData = [
    { code: "CASE-2024-001", treatment: "حشوة تجميلية", patient: "أحمد محمد علي", phone: "0991234567", age: 45, toothNumber: "26", course: "طب القلب السريري" },
    { code: "CASE-2024-002", treatment: "علاج عصب", patient: "سارة أحمد الخالد", phone: "0992345678", age: 32, toothNumber: "14", course: "أمراض الجهاز التنفسي" },
    { code: "CASE-2024-003", treatment: "تاج", patient: "محمد عمر النجار", phone: "0993456789", age: 58, toothNumber: "18", course: "طب الأعصاب السريري" },
    { code: "CASE-2024-004", treatment: "خلع", patient: "فاطمة علي حسن", phone: "0994567890", age: 28, toothNumber: "32", course: "طب القلب السريري" },
    { code: "CASE-2024-005", treatment: "تنظيف", patient: "محمود خالد العمري", phone: "0995678901", age: 52, toothNumber: "12", course: "أمراض الجهاز التنفسي" }
];

// بيانات الطلاب المحدثة مع الفئات
const studentsData = [
    { id: "202301234", name: "خالد محمود سالم", phone: "0999876543", category: "morning", categoryName: "صباحي" },
    { id: "202301567", name: "نور الدين يوسف", phone: "0998765432", category: "evening", categoryName: "مسائي" },
    { id: "202301890", name: "سارة نور الدين", phone: "0997654321", category: "morning", categoryName: "صباحي" },
    { id: "202302345", name: "أحمد محمود سالم", phone: "0996543210", category: "evening", categoryName: "مسائي" }
];

// جداول المقررات والأيام المتاحة
const courseSchedules = {
    'cardiology': {
        name: 'طب القلب السريري',
        availableDays: ['sunday', 'tuesday'], // الأحد والثلاثاء
        dayNames: { 'sunday': 'الأحد', 'tuesday': 'الثلاثاء' }
    },
    'respiratory': {
        name: 'أمراض الجهاز التنفسي',
        availableDays: ['monday', 'wednesday'], // الاثنين والأربعاء
        dayNames: { 'monday': 'الاثنين', 'wednesday': 'الأربعاء' }
    },
    'neurology': {
        name: 'طب الأعصاب السريري',
        availableDays: ['sunday', 'thursday'], // الأحد والخميس
        dayNames: { 'sunday': 'الأحد', 'thursday': 'الخميس' }
    },
    'clinical': {
        name: 'الفحص السريري المتقدم',
        availableDays: ['tuesday', 'thursday'], // الثلاثاء والخميس
        dayNames: { 'tuesday': 'الثلاثاء', 'thursday': 'الخميس' }
    }
};

// فترات العمل حسب الفئة
const timeSlots = {
    'morning': { start: '08:00', end: '12:00', label: '08:00 ص - 12:00 م' },
    'evening': { start: '14:00', end: '18:00', label: '02:00 م - 06:00 م' }
};

// بيانات الاستثناءات
let exceptionsData = [
    {
        id: 1,
        exceptionCode: "EXC-2024-001",
        caseCode: "CASE-2024-001",
        patientName: "ليلى محمود عبدالله",
        patientPhone: "0996789012",
        studentName: "نور الدين يوسف",
        studentId: "202301567",
        studentCategory: "evening",
        course: "neurology",
        courseName: "طب الأعصاب السريري",
        treatmentType: "تاج",
        toothNumber: "16",
        grantDate: "2024-01-18",
        grantTime: "09:45 ص",
        reason: "حالة طارئة - الطالب بحاجة لإكمال متطلبات المقرر",
        granter: "dean",
        granterName: "العميد",
        approver: "محمد أحمد الخالد",
        appointmentDate: "2024-01-25",
        appointmentDay: "الخميس",
        appointmentTime: "14:00 - 18:00",
        status: "active",
        cancelDate: null,
        cancelTime: null,
        cancelEmployee: null,
        cancelReason: null
    }
];

// بيانات الحجوزات الملغاة
const cancelledBookingsData = [
    {
        id: 101,
        patientName: "محمود خالد العمري",
        patientInitial: "م",
        patientAge: 52,
        patientPhone: "0995678901",
        studentName: "أحمد محمود سالم",
        studentId: "202302345",
        studentPhone: "0996543210",
        toothNumber: "12",
        treatmentType: "تنظيف",
        course: "أمراض الجهاز التنفسي",
        supervisorDoctor: "د. خالد أحمد",
        tempBookingDate: "2024-01-20",
        tempBookingTime: "09:30 ص",
        cancellationDate: "2024-01-21",
        cancellationTime: "10:00 ص",
        cancellationEmployee: "محمد أحمد الخالد",
        cancellationReason: "المريض لم يحضر في الموعد المحدد",
        caseCode: "CASE-2024-005"
    }
];

// سجل التعديلات والحذف
let modificationsLog = [
    {
        id: 1,
        timestamp: new Date('2024-01-20T14:30:00'),
        action: "حذف",
        target: "حجز مؤقت - أحمد محمد علي",
        employee: "محمد أحمد الخالد",
        reason: "خطأ في إدخال البيانات",
        reverted: false
    }
];

// أنماط العلاج حسب المقرر
const treatmentTypes = {
    'cardiology': ['قسطرة قلبية', 'تخطيط القلب', 'فحص إجهاد', 'موجات صوتية'],
    'respiratory': ['منظار قصبات', 'وظائف رئوية', 'أشعة صدر', 'تحليل غازات'],
    'neurology': ['تخطيط أعصاب', 'رنين مغناطيسي', 'فحص ذهني', 'موجات دماغية'],
    'clinical': ['فحص سريري شامل', 'فحص عضلات', 'فحص مفاصل', 'تخطيط عضلات'],
    'all': ['جميع الأنماط']
};

// متغيرات الفلترة
let currentStudentCourse = 'all';
let currentStudentTreatment = 'all';
let currentTrackCourse = 'all';
let currentTrackTreatment = 'all';
let currentCancelledCourse = 'all';
let currentCancelledTreatment = 'all';
let currentSelectedStudent = null;
let currentSelectedCourse = null;
let selectedDayValue = null;

// ==========================================
// دوال التحكم في الـ Tabs
// ==========================================
function switchTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });
    
    document.querySelectorAll('.tab-item').forEach(item => {
        item.classList.remove('active');
    });
    
    const selectedContent = document.getElementById(tabName + 'Content');
    if (selectedContent) {
        selectedContent.style.display = 'block';
    }
    
    const clickedTab = event.currentTarget;
    clickedTab.classList.add('active');

    // تحميل البيانات عند التبديل للتاب
    if (tabName === 'exceptions') {
        loadExceptionsTable();
    } else if (tabName === 'cancelledBookings') {
        displayAllCancelledBookings();
    }
}

// ==========================================
// دوال الـ Dropdowns
// ==========================================
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const isOpen = dropdown.classList.contains('dropdown-open');
    
    document.querySelectorAll('.custom-dropdown').forEach(d => {
        d.classList.remove('dropdown-open');
    });
    
    if (!isOpen) {
        dropdown.classList.add('dropdown-open');
    }
}

function closeAllDropdowns() {
    document.querySelectorAll('.custom-dropdown').forEach(d => {
        d.classList.remove('dropdown-open');
    });
}

function selectCourse(value, label) {
    document.getElementById('selectedCourse').textContent = label;
    updateTreatmentDropdown(value);
    closeAllDropdowns();
}

function updateTreatmentDropdown(course, targetId = 'treatmentOptions', selectedId = 'selectedTreatment') {
    const optionsContainer = document.getElementById(targetId);
    const treatments = treatmentTypes[course] || treatmentTypes['all'];
    
    optionsContainer.innerHTML = treatments.map(type => `
        <div class="dropdown-option" onclick="selectTreatment('${type}', '${selectedId}')">${type}</div>
    `).join('');
    
    document.getElementById(selectedId).textContent = 'اختر نمط العلاج';
}

function selectTreatment(type, selectedId = 'selectedTreatment') {
    document.getElementById(selectedId).textContent = type;
    closeAllDropdowns();
}

function selectTempCourse(value, label) {
    document.getElementById('selectedTempCourse').textContent = label;
    updateTreatmentDropdown(value, 'tempTreatmentOptions', 'selectedTempTreatment');
    closeAllDropdowns();
}

// ==========================================
// القسم الأول: حجوزات اليوم
// ==========================================
function performSearch() {
    const course = document.getElementById('selectedCourse').textContent;
    const treatment = document.getElementById('selectedTreatment').textContent;
    
    if (treatment === 'اختر نمط العلاج') {
        showToast('يرجى اختيار نمط العلاج أولاً', 'warning');
        return;
    }
    
    const filtered = bookingsData.filter(b => {
        const matchCourse = course === 'جميع المقررات' || b.course === course;
        const matchTreatment = treatment === 'جميع الأنماط' || b.treatmentType === treatment;
        return matchCourse && matchTreatment;
    });
    
    displayTodayBookings(filtered);
}

function displayTodayBookings(bookings) {
    const container = document.getElementById('todayBookingsTableBody');
    const resultsDiv = document.getElementById('searchResults');
    const noSearchDiv = document.getElementById('noSearchYet');
    const countSpan = document.getElementById('resultsCount');
    
    noSearchDiv.style.display = 'none';
    resultsDiv.style.display = 'block';
    countSpan.textContent = bookings.length;
    
    if (bookings.length === 0) {
        container.innerHTML = '<tr><td colspan="12" style="text-align: center; padding: 40px;">لا توجد نتائج مطابقة</td></tr>';
        return;
    }
    
    container.innerHTML = bookings.map(booking => `
        <tr>
            <td>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                        ${booking.patientInitial}
                    </div>
                    <span style="font-weight: 600;">${booking.patientName}</span>
                </div>
            </td>
            <td style="direction: ltr; text-align: right;">${booking.patientPhone}</td>
            <td>${booking.studentName}</td>
            <td style="font-family: monospace;">${booking.studentId}</td>
            <td style="direction: ltr; text-align: right;">${booking.studentPhone}</td>
            <td>${booking.toothNumber}</td>
            <td>${booking.treatmentType}</td>
            <td>${booking.course}</td>
            <td>${booking.supervisorDoctor}</td>
            <td>${booking.diagnosingDoctor}</td>
            <td>
                <span class="badge ${getStatusBadgeClass(booking.caseStatus)}">
                    <i class="fas fa-${getStatusIcon(booking.caseStatus)}"></i>
                    ${booking.caseStatusLabel}
                </span>
            </td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon btn-view" onclick="viewBookingDetails(${booking.id})" title="عرض">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function getStatusBadgeClass(status) {
    const classes = {
        'active': 'badge-temp',
        'completed': 'badge-completed',
        'cancelled': 'badge-cancelled',
        'transferred': 'badge-transferred'
    };
    return classes[status] || 'badge-temp';
}

function getStatusIcon(status) {
    const icons = {
        'active': 'clock',
        'completed': 'check-circle',
        'cancelled': 'ban',
        'transferred': 'exchange-alt'
    };
    return icons[status] || 'clock';
}

// ==========================================
// القسم الثاني: الحجوزات المؤقتة (مُحدث بفلاتر)
// ==========================================
function searchTempBookings() {
    const course = document.getElementById('selectedTempCourse').textContent;
    const treatment = document.getElementById('selectedTempTreatment').textContent;
    
    let tempBookings = bookingsData.filter(b => b.caseStatus === 'active' && !b.permanentBookingDate);
    
    // تطبيق الفلاتر
    if (course !== 'جميع المقررات') {
        tempBookings = tempBookings.filter(b => b.course === course);
    }
    if (treatment !== 'جميع أنماط العلاج' && treatment !== 'اختر نمط العلاج') {
        tempBookings = tempBookings.filter(b => b.treatmentType === treatment);
    }
    
    const container = document.getElementById('tempBookingsTableBody');
    
    if (tempBookings.length === 0) {
        container.innerHTML = '<tr><td colspan="17" style="text-align: center; padding: 40px;">لا توجد حجوزات مؤقتة مطابقة</td></tr>';
        return;
    }
    
    container.innerHTML = tempBookings.map(booking => `
        <tr>
            <td>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                        ${booking.patientInitial}
                    </div>
                    <span style="font-weight: 600;">${booking.patientName}</span>
                </div>
            </td>
            <td style="direction: ltr; text-align: right;">${booking.patientPhone}</td>
            <td>${booking.patientAge} سنة</td>
            <td>${booking.patientAddress}</td>
            <td>${booking.patientHealthStatus}</td>
            <td>${booking.studentName}</td>
            <td style="font-family: monospace;">${booking.studentId}</td>
            <td style="direction: ltr; text-align: right;">${booking.studentPhone}</td>
            <td>${booking.toothNumber}</td>
            <td>${booking.treatmentType}</td>
            <td>${booking.course}</td>
            <td>${booking.supervisorDoctor}</td>
            <td>${booking.diagnosingDoctor}</td>
            <td>${booking.dataEntryStaff}</td>
            <td>${booking.tempBookingDate}</td>
            <td>${booking.tempBookingTime}</td>
            <td>${booking.patientRegistrationDate}</td>
        </tr>
    `).join('');
}

// ==========================================
// القسم الثالث: حجوزات الطالب (مُحدث بفلاتر)
// ==========================================
function selectStudentCourse(value, label) {
    currentStudentCourse = value;
    document.getElementById('selectedStudentCourse').textContent = label;
    updateTreatmentDropdown(value, 'studentTreatmentOptions', 'selectedStudentTreatment');
    closeAllDropdowns();
}

function selectStudentTreatment(value, label) {
    currentStudentTreatment = value;
    document.getElementById('selectedStudentTreatment').textContent = label;
    closeAllDropdowns();
}

function searchStudentBookings() {
    const studentId = document.getElementById('studentSearchInput').value.trim();
    
    if (!studentId) {
        showToast('يرجى إدخال الرقم الجامعي', 'warning');
        return;
    }
    
    let studentBookings = bookingsData.filter(b => b.studentId === studentId);
    
    // تطبيق الفلاتر
    const course = document.getElementById('selectedStudentCourse').textContent;
    const treatment = document.getElementById('selectedStudentTreatment').textContent;
    
    if (course !== 'جميع المقررات' && course !== 'فلترة حسب المقرر') {
        studentBookings = studentBookings.filter(b => b.course === course);
    }
    if (treatment !== 'جميع الأنماط' && treatment !== 'فلترة حسب نمط العلاج' && treatment !== 'اختر نمط العلاج') {
        studentBookings = studentBookings.filter(b => b.treatmentType === treatment);
    }
    
    if (studentBookings.length === 0) {
        showToast('لا توجد حجوزات مطابقة لهذا الطالب', 'warning');
        return;
    }
    
    document.getElementById('studentSearchResults').style.display = 'block';
    document.getElementById('modificationsLog').style.display = 'block';
    
    // تصنيف الحالات
    const confirmed = studentBookings.filter(b => b.permanentBookingDate && b.caseStatus !== 'cancelled');
    const temp = studentBookings.filter(b => !b.permanentBookingDate && b.caseStatus === 'active');
    const rejected = studentBookings.filter(b => b.caseStatus === 'rejected');
    const cancelled = studentBookings.filter(b => b.caseStatus === 'cancelled');
    
    // عرض الجداول
    document.querySelector('#confirmedStudentTable tbody').innerHTML = confirmed.map((b, i) => `
        <tr>
            <td>${i + 1}</td>
            <td>${b.patientName}</td>
            <td>${b.toothNumber}</td>
            <td>${b.treatmentType}</td>
            <td>${b.course}</td>
            <td>${b.permanentBookingDate}</td>
            <td>${b.supervisorDoctor}</td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon btn-view" onclick="viewBookingDetails(${b.id})"><i class="fas fa-eye"></i></button>
                    <button class="btn-icon btn-edit" onclick="openEditModal(${b.id}, 'confirmed')"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon btn-delete" onclick="openDeleteModal(${b.id}, 'confirmed')"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>
    `).join('') || '<tr><td colspan="8" style="text-align: center;">لا توجد حالات مثبتة</td></tr>';
    
    document.querySelector('#tempStudentTable tbody').innerHTML = temp.map((b, i) => `
        <tr>
            <td>${i + 1}</td>
            <td>${b.patientName}</td>
            <td>${b.toothNumber}</td>
            <td>${b.treatmentType}</td>
            <td>${b.course}</td>
            <td>${b.tempBookingDate}</td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon btn-view" onclick="viewBookingDetails(${b.id})"><i class="fas fa-eye"></i></button>
                    <button class="btn-icon btn-edit" onclick="openEditModal(${b.id}, 'temp')"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon btn-delete" onclick="openDeleteModal(${b.id}, 'temp')"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>
    `).join('') || '<tr><td colspan="7" style="text-align: center;">لا توجد حالات مؤقتة</td></tr>';
    
    document.querySelector('#rejectedStudentTable tbody').innerHTML = rejected.map((b, i) => `
        <tr>
            <td>${i + 1}</td>
            <td>${b.patientName}</td>
            <td>${b.toothNumber}</td>
            <td>${b.treatmentType}</td>
            <td>${b.rejectionDate || '-'}</td>
            <td>${b.rejectionReason || '-'}</td>
            <td>${b.rejectionEmployee || '-'}</td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon btn-view" onclick="viewBookingDetails(${b.id})"><i class="fas fa-eye"></i></button>
                </div>
            </td>
        </tr>
    `).join('') || '<tr><td colspan="8" style="text-align: center;">لا توجد حالات مرفوضة</td></tr>';
    
    document.querySelector('#cancelledStudentTable tbody').innerHTML = cancelled.map((b, i) => `
        <tr>
            <td>${i + 1}</td>
            <td>${b.patientName}</td>
            <td>${b.toothNumber}</td>
            <td>${b.treatmentType}</td>
            <td>${b.cancellationDate}</td>
            <td>${b.cancellationReason}</td>
            <td>${b.cancellationEmployee}</td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon btn-view" onclick="viewBookingDetails(${b.id})"><i class="fas fa-eye"></i></button>
                </div>
            </td>
        </tr>
    `).join('') || '<tr><td colspan="8" style="text-align: center;">لا توجد حالات ملغاة</td></tr>';
    
    loadModificationsLog();
}

// ==========================================
// سجل التعديلات والتراجع
// ==========================================
function loadModificationsLog() {
    const sortedLog = [...modificationsLog].sort((a, b) => b.timestamp - a.timestamp);
    
    document.querySelector('#modificationsTable tbody').innerHTML = sortedLog.map(log => `
        <tr style="${log.reverted ? 'opacity: 0.6; text-decoration: line-through;' : ''}">
            <td>${log.timestamp.toLocaleDateString('ar-SA')}</td>
            <td>${log.timestamp.toLocaleTimeString('ar-SA', {hour: '2-digit', minute: '2-digit'})}</td>
            <td>
                <span class="badge ${log.action === 'حذف' ? 'badge-rejected' : 'badge-temp'}">
                    ${log.action}
                </span>
            </td>
            <td>${log.target}</td>
            <td>${log.employee}</td>
            <td>${log.reason}</td>
            <td>
                ${!log.reverted ? `
                    <button class="btn-icon btn-view" onclick="openRevertModal(${log.id})" title="تراجع">
                        <i class="fas fa-undo"></i>
                    </button>
                ` : `
                    <span style="font-size: 11px; color: var(--gray);">
                        تم التراجع (${log.revertEmployee})
                    </span>
                `}
            </td>
        </tr>
    `).join('');
}

function openEditModal(id, tableType) {
    document.getElementById('actionModalTitle').textContent = 'تعديل بيانات';
    document.getElementById('actionType').value = 'edit';
    document.getElementById('actionBookingId').value = id;
    document.getElementById('actionTableType').value = tableType;
    document.getElementById('actionReason').value = '';
    document.getElementById('actionModal').classList.add('active');
}

function openDeleteModal(id, tableType) {
    document.getElementById('actionModalTitle').textContent = 'حذف حجز';
    document.getElementById('actionType').value = 'delete';
    document.getElementById('actionBookingId').value = id;
    document.getElementById('actionTableType').value = tableType;
    document.getElementById('actionReason').value = '';
    document.getElementById('actionModal').classList.add('active');
}

function closeActionModal() {
    document.getElementById('actionModal').classList.remove('active');
}

function confirmAction() {
    const type = document.getElementById('actionType').value;
    const bookingId = document.getElementById('actionBookingId').value;
    const reason = document.getElementById('actionReason').value;
    
    if (!reason) {
        showToast('يرجى كتابة السبب', 'warning');
        return;
    }
    
    const booking = bookingsData.find(b => b.id == bookingId);
    modificationsLog.push({
        id: Date.now(),
        timestamp: new Date(),
        action: type === 'delete' ? 'حذف' : 'تعديل',
        target: `${booking.patientName} - ${booking.treatmentType}`,
        employee: "محمد أحمد الخالد",
        reason: reason,
        reverted: false
    });
    
    showToast(`تم ${type === 'delete' ? 'الحذف' : 'التعديل'} بنجاح`, 'success');
    closeActionModal();
    searchStudentBookings();
}

function openRevertModal(logId) {
    document.getElementById('revertLogId').value = logId;
    document.getElementById('revertReason').value = '';
    document.getElementById('revertModal').classList.add('active');
}

function closeRevertModal() {
    document.getElementById('revertModal').classList.remove('active');
}

function confirmRevert() {
    const logId = document.getElementById('revertLogId').value;
    const reason = document.getElementById('revertReason').value;
    
    if (!reason) {
        showToast('يرجى كتابة سبب التراجع', 'warning');
        return;
    }
    
    const log = modificationsLog.find(l => l.id == logId);
    if (log) {
        log.reverted = true;
        log.revertReason = reason;
        log.revertEmployee = "محمد أحمد الخالد";
        log.revertTimestamp = new Date();
    }
    
    showToast('تم التراجع عن الإجراء بنجاح', 'success');
    closeRevertModal();
    loadModificationsLog();
}

// ==========================================
// القسم الرابع: تتبع حجز الحالة (جدول مدمج)
// ==========================================
let currentTrackSearchType = 'case_code';

function selectTrackSearchType(value, label) {
    currentTrackSearchType = value;
    document.getElementById('selectedTrackSearchType').textContent = label;
    
    const input = document.getElementById('trackSearchInput');
    const placeholders = {
        'case_code': 'أدخل رمز الحالة (مثال: CASE-2024-001)',
        'student_id': 'أدخل الرقم الجامعي',
        'patient_name': 'أدخل اسم المريض الثلاثي',
        'student_name': 'أدخل اسم الطالب',
        'tooth_number': 'أدخل رقم السن'
    };
    input.placeholder = placeholders[value] || 'أدخل قيمة البحث...';
    
    closeAllDropdowns();
}

function selectTrackCourse(value, label) {
    currentTrackCourse = value;
    document.getElementById('selectedTrackCourse').textContent = label;
    updateTreatmentDropdown(value, 'trackTreatmentOptions', 'selectedTrackTreatment');
    closeAllDropdowns();
}

function handleTrackInput(event) {
    if (event.key === 'Enter') {
        trackBooking();
    }
}

function trackBooking() {
    const searchValue = document.getElementById('trackSearchInput').value.trim();
    const course = document.getElementById('selectedTrackCourse').textContent;
    const treatment = document.getElementById('selectedTrackTreatment').textContent;
    
    let filtered = bookingsData;
    
    // تطبيق البحث
    if (searchValue) {
        if (currentTrackSearchType === 'case_code') {
            filtered = filtered.filter(b => b.caseCode && b.caseCode.toUpperCase().includes(searchValue.toUpperCase()));
        } else if (currentTrackSearchType === 'student_id') {
            filtered = filtered.filter(b => b.studentId.includes(searchValue));
        } else if (currentTrackSearchType === 'patient_name') {
            filtered = filtered.filter(b => b.patientName.includes(searchValue));
        } else if (currentTrackSearchType === 'student_name') {
            filtered = filtered.filter(b => b.studentName.includes(searchValue));
        } else if (currentTrackSearchType === 'tooth_number') {
            filtered = filtered.filter(b => b.toothNumber === searchValue);
        }
    }
    
    // تطبيق الفلاتر
    if (course !== 'جميع المقررات' && course !== 'فلترة حسب المقرر') {
        filtered = filtered.filter(b => b.course === course);
    }
    if (treatment !== 'جميع الأنماط' && treatment !== 'فلترة حسب نمط العلاج' && treatment !== 'اختر نمط العلاج') {
        filtered = filtered.filter(b => b.treatmentType === treatment);
    }
    
    if (filtered.length === 0) {
        showToast('لم يتم العثور على نتائج مطابقة', 'warning');
        return;
    }
    
    displayTrackTables(filtered);
}

function displayTrackTables(bookings) {
    const container = document.getElementById('trackResults');
    
    container.innerHTML = bookings.map(booking => `
        <div class="track-table-container">
            <!-- Header معلومات أساسية -->
            <div class="track-table-header">
                <div class="track-header-info">
                    <div class="track-header-code">${booking.caseCode}</div>
                    <div class="track-header-patient">
                        <i class="fas fa-user-injured"></i> ${booking.patientName}
                    </div>
                    <div class="track-header-details">
                        <span><i class="fas fa-tooth"></i> سن ${booking.toothNumber}</span>
                        <span><i class="fas fa-user-graduate"></i> ${booking.studentName}</span>
                        <span><i class="fas fa-book"></i> ${booking.course}</span>
                        <span><i class="fas fa-stethoscope"></i> ${booking.treatmentType}</span>
                    </div>
                </div>
                <div class="track-status-badge-large">
                    ${booking.caseStatusLabel}
                </div>
            </div>
            
            <!-- ملخص المعلومات -->
            <div class="track-info-summary">
                <div class="track-info-item">
                    <div class="track-info-label">المشرف العملي</div>
                    <div class="track-info-value">${booking.supervisorDoctor}</div>
                </div>
                <div class="track-info-item">
                    <div class="track-info-label">المشخص</div>
                    <div class="track-info-value">${booking.diagnosingDoctor}</div>
                </div>
                <div class="track-info-item">
                    <div class="track-info-label">رقم المريض</div>
                    <div class="track-info-value" style="direction: ltr;">${booking.patientPhone}</div>
                </div>
                <div class="track-info-item">
                    <div class="track-info-label">تاريخ التسجيل</div>
                    <div class="track-info-value">${booking.patientRegistrationDate}</div>
                </div>
            </div>
            
            <!-- جدول التايم لاين -->
            <div class="track-table-content">
                <table class="track-timeline-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">المرحلة</th>
                            <th style="width: 20%;">التاريخ والوقت</th>
                            <th style="width: 25%;">الموظف/المشرف</th>
                            <th style="width: 25%;">الحالة/الملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${generateTrackTableRows(booking)}
                    </tbody>
                </table>
            </div>
        </div>
    `).join('');
}

function generateTrackTableRows(booking) {
    let rows = '';
    
    // 1. الحجز المؤقت
    rows += `
        <tr class="track-phase-row">
            <td>
                <div class="track-phase-title">
                    <span class="track-phase-icon temp"><i class="fas fa-clock"></i></span>
                    الحجز المؤقت
                </div>
            </td>
            <td>
                ${booking.tempBookingDate ? `
                    <div class="track-phase-date">
                        <i class="fas fa-calendar"></i> ${booking.tempBookingDate}
                    </div>
                    <div class="track-phase-date">
                        <i class="fas fa-clock"></i> ${booking.tempBookingTime}
                    </div>
                ` : '<span style="color: #9ca3af;">--</span>'}
            </td>
            <td>
                ${booking.tempBookingDate ? `
                    <div class="track-phase-employee">
                        <i class="fas fa-user"></i> ${booking.tempBookingEmployee}
                    </div>
                ` : '--'}
            </td>
            <td>
                ${booking.tempBookingDate ? `
                    <span class="track-phase-status completed">
                        <i class="fas fa-check-circle"></i> تم الإنشاء
                    </span>
                ` : `
                    <span class="track-phase-status pending">
                        <i class="fas fa-hourglass-half"></i> قيد الانتظار
                    </span>
                `}
            </td>
        </tr>
    `;
    
    // 2. الحجز الدائم
    rows += `
        <tr class="track-phase-row">
            <td>
                <div class="track-phase-title">
                    <span class="track-phase-icon permanent"><i class="fas fa-calendar-check"></i></span>
                    الحجز الدائم (التثبيت)
                </div>
            </td>
            <td>
                ${booking.permanentBookingDate ? `
                    <div class="track-phase-date">
                        <i class="fas fa-calendar"></i> ${booking.permanentBookingDate}
                    </div>
                    <div class="track-phase-date">
                        <i class="fas fa-clock"></i> ${booking.permanentBookingTime}
                    </div>
                ` : '<span style="color: #9ca3af;">--</span>'}
            </td>
            <td>
                ${booking.permanentBookingDate ? `
                    <div class="track-phase-employee">
                        <i class="fas fa-user"></i> ${booking.permanentBookingEmployee}
                    </div>
                ` : '--'}
            </td>
            <td>
                ${booking.permanentBookingDate ? `
                    <span class="track-phase-status completed">
                        <i class="fas fa-check-circle"></i> تم التثبيت
                    </span>
                ` : booking.tempBookingDate ? `
                    <span class="track-phase-status pending">
                        <i class="fas fa-hourglass-half"></i> بانتظار التثبيت
                    </span>
                ` : `
                    <span class="track-phase-status pending">
                        <i class="fas fa-minus"></i> لم يبدأ
                    </span>
                `}
            </td>
        </tr>
    `;
    
    // 3. بدء العمل
    rows += `
        <tr class="track-phase-row">
            <td>
                <div class="track-phase-title">
                    <span class="track-phase-icon start"><i class="fas fa-play"></i></span>
                    بدء العمل (أول توقيع)
                </div>
            </td>
            <td>
                ${booking.workStartDate ? `
                    <div class="track-phase-date">
                        <i class="fas fa-calendar"></i> ${booking.workStartDate}
                    </div>
                    <div class="track-phase-date">
                        <i class="fas fa-clock"></i> ${booking.workStartTime}
                    </div>
                ` : '<span style="color: #9ca3af;">--</span>'}
            </td>
            <td>
                ${booking.workStartDate ? `
                    <div class="track-phase-employee">
                        <i class="fas fa-user-md"></i> ${booking.workStartEmployee}
                    </div>
                ` : '--'}
            </td>
            <td>
                ${booking.workStartDate ? `
                    <div class="track-phase-notes">${booking.workStartNotes || 'تم بدء العمل'}</div>
                    <span class="track-phase-status completed" style="margin-top: 6px;">
                        <i class="fas fa-check-circle"></i> تم البدء
                    </span>
                ` : booking.permanentBookingDate ? `
                    <span class="track-phase-status pending">
                        <i class="fas fa-hourglass-half"></i> بانتظار البدء
                    </span>
                ` : `
                    <span class="track-phase-status pending">
                        <i class="fas fa-minus"></i> لم يبدأ
                    </span>
                `}
            </td>
        </tr>
    `;
    
    // 4. انتهاء العمل
    rows += `
        <tr class="track-phase-row">
            <td>
                <div class="track-phase-title">
                    <span class="track-phase-icon end"><i class="fas fa-flag-checkered"></i></span>
                    انتهاء العمل (آخر توقيع)
                </div>
            </td>
            <td>
                ${booking.workEndDate ? `
                    <div class="track-phase-date">
                        <i class="fas fa-calendar"></i> ${booking.workEndDate}
                    </div>
                    <div class="track-phase-date">
                        <i class="fas fa-clock"></i> ${booking.workEndTime}
                    </div>
                ` : '<span style="color: #9ca3af;">--</span>'}
            </td>
            <td>
                ${booking.workEndDate ? `
                    <div class="track-phase-employee">
                        <i class="fas fa-user-md"></i> ${booking.workEndEmployee}
                    </div>
                ` : '--'}
            </td>
            <td>
                ${booking.workEndDate ? `
                    <div class="track-phase-notes">${booking.workEndNotes || 'تم إكمال العمل'}</div>
                    <span class="track-phase-status completed" style="margin-top: 6px;">
                        <i class="fas fa-check-circle"></i> مكتمل
                    </span>
                ` : booking.workStartDate ? `
                    <span class="track-phase-status pending">
                        <i class="fas fa-hourglass-half"></i> قيد التنفيذ
                    </span>
                ` : `
                    <span class="track-phase-status pending">
                        <i class="fas fa-minus"></i> لم يبدأ
                    </span>
                `}
            </td>
        </tr>
    `;
    
    // 5. إلغاء الحالة إن وجد
    if (booking.caseStatus === 'cancelled') {
        rows += `
            <tr class="track-phase-row" style="background: rgba(239, 68, 68, 0.05);">
                <td>
                    <div class="track-phase-title">
                        <span class="track-phase-icon cancel"><i class="fas fa-ban"></i></span>
                        إلغاء الحالة
                    </div>
                </td>
                <td>
                    ${booking.cancellationDate ? `
                        <div class="track-phase-date">
                            <i class="fas fa-calendar"></i> ${booking.cancellationDate}
                        </div>
                        <div class="track-phase-date">
                            <i class="fas fa-clock"></i> ${booking.cancellationTime || '--:--'}
                        </div>
                    ` : '--'}
                </td>
                <td>
                    ${booking.cancellationEmployee ? `
                        <div class="track-phase-employee">
                            <i class="fas fa-user"></i> ${booking.cancellationEmployee}
                        </div>
                    ` : '--'}
                </td>
                <td>
                    <div class="track-phase-notes" style="color: var(--danger);">
                        <strong>السبب:</strong> ${booking.cancellationReason || 'غير محدد'}
                    </div>
                    <span class="track-phase-status cancelled" style="margin-top: 6px;">
                        <i class="fas fa-ban"></i> ملغاة
                    </span>
                </td>
            </tr>
        `;
    }
    
    // 6. تحويل الحالة إن وجد
    if (booking.caseStatus === 'transferred') {
        rows += `
            <tr class="track-phase-row" style="background: rgba(139, 92, 246, 0.05);">
                <td>
                    <div class="track-phase-title">
                        <span class="track-phase-icon transfer"><i class="fas fa-exchange-alt"></i></span>
                        تحويل الحالة
                    </div>
                </td>
                <td>
                    ${booking.transferDate ? `
                        <div class="track-phase-date">
                            <i class="fas fa-calendar"></i> ${booking.transferDate}
                        </div>
                    ` : '--'}
                </td>
                <td>--</td>
                <td>
                    <div class="track-phase-notes" style="color: #8b5cf6;">
                        <strong>محولة إلى:</strong> ${booking.transferTo || 'غير محدد'}<br>
                        <strong>السبب:</strong> ${booking.transferReason || 'غير محدد'}
                    </div>
                    <span class="track-phase-status" style="margin-top: 6px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                        <i class="fas fa-exchange-alt"></i> محولة
                    </span>
                </td>
            </tr>
        `;
    }
    
    return rows;
}

// ==========================================
// القسم الخامس: الحجوزات الملغاة (مُحدث بفلاتر)
// ==========================================
function selectCancelledCourse(value, label) {
    currentCancelledCourse = value;
    document.getElementById('selectedCancelledCourse').textContent = label;
    updateTreatmentDropdown(value, 'cancelledTreatmentOptions', 'selectedCancelledTreatment');
    closeAllDropdowns();
}

function handleCancelledInput(event) {
    if (event.key === 'Enter') {
        searchCancelledBookings();
    }
}

function searchCancelledBookings() {
    const searchValue = document.getElementById('cancelledSearchInput').value.trim();
    const course = document.getElementById('selectedCancelledCourse').textContent;
    const treatment = document.getElementById('selectedCancelledTreatment').textContent;
    
    let filtered = cancelledBookingsData;
    
    // تطبيق البحث
    if (searchValue) {
        if (currentCancelledSearchType === 'case_code') {
            filtered = filtered.filter(b => b.caseCode && b.caseCode.toUpperCase().includes(searchValue.toUpperCase()));
        } else if (currentCancelledSearchType === 'student_id') {
            filtered = filtered.filter(b => b.studentId.includes(searchValue));
        } else if (currentCancelledSearchType === 'patient_name') {
            filtered = filtered.filter(b => b.patientName.includes(searchValue));
        } else if (currentCancelledSearchType === 'student_name') {
            filtered = filtered.filter(b => b.studentName.includes(searchValue));
        }
    }
    
    // تطبيق الفلاتر
    if (course !== 'جميع المقررات' && course !== 'فلترة حسب المقرر') {
        filtered = filtered.filter(b => b.course === course);
    }
    if (treatment !== 'جميع الأنماط' && treatment !== 'فلترة حسب نمط العلاج' && treatment !== 'اختر نمط العلاج') {
        filtered = filtered.filter(b => b.treatmentType === treatment);
    }
    
    displayCancelledBookings(filtered);
}

function displayAllCancelledBookings() {
    displayCancelledBookings(cancelledBookingsData);
}

function displayCancelledBookings(bookings) {
    const container = document.getElementById('cancelledResults');
    
    if (bookings.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 40px; color: var(--gray);">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px;"></i>
                <p>لا توجد حجوزات ملغاة مطابقة للبحث</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <div class="table-container" style="overflow-x: auto; background: white; border-radius: var(--radius); border: 1px solid #e5e7eb;">
            <table class="data-table">
                <thead style="background: linear-gradient(135deg, var(--danger), #f87171);">
                    <tr>
                        <th>رمز الحالة</th>
                        <th>اسم المريض</th>
                        <th>الطالب</th>
                        <th>الرقم الجامعي</th>
                        <th>السن</th>
                        <th>نمط العلاج</th>
                        <th>المقرر</th>
                        <th>تاريخ الحجز</th>
                        <th>تاريخ الإلغاء</th>
                        <th>وقت الإلغاء</th>
                        <th>الموظف</th>
                        <th>سبب الإلغاء</th>
                    </tr>
                </thead>
                <tbody>
                    ${bookings.map(booking => `
                        <tr style="background: rgba(239, 68, 68, 0.02);">
                            <td style="font-family: monospace; font-weight: 600; color: var(--primary);">${booking.caseCode}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 28px; height: 28px; background: linear-gradient(135deg, var(--danger), #f87171); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 11px;">
                                        ${booking.patientInitial}
                                    </div>
                                    <span>${booking.patientName}</span>
                                </div>
                            </td>
                            <td>${booking.studentName}</td>
                            <td style="font-family: monospace;">${booking.studentId}</td>
                            <td style="font-weight: 600; color: var(--primary);">${booking.toothNumber}</td>
                            <td>${booking.treatmentType}</td>
                            <td>${booking.course}</td>
                            <td>${booking.tempBookingDate}</td>
                            <td style="color: var(--danger); font-weight: 600;">${booking.cancellationDate}</td>
                            <td>${booking.cancellationTime}</td>
                            <td>${booking.cancellationEmployee}</td>
                            <td style="max-width: 200px; font-size: 12px; color: var(--gray-dark);">${booking.cancellationReason}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

// ==========================================
// القسم السادس: الاستثناءات (المنطقية الذكية الجديدة)
// ==========================================
function loadExceptionsTable() {
    const sortedExceptions = [...exceptionsData].sort((a, b) => new Date(b.grantDate) - new Date(a.grantDate));
    
    const container = document.getElementById('exceptionsTableBody');
    
    if (sortedExceptions.length === 0) {
        container.innerHTML = '<tr><td colspan="18" style="text-align: center; padding: 40px;">لا توجد استثناءات مسجلة</td></tr>';
        return;
    }
    
    container.innerHTML = sortedExceptions.map((ex, index) => `
        <tr>
            <td>${index + 1}</td>
            <td>${ex.grantDate}</td>
            <td>${ex.grantTime}</td>
            <td style="font-family: monospace; font-weight: 600; color: var(--primary);">${ex.caseCode}</td>
            <td><span class="exception-code-badge"><i class="fas fa-star"></i> ${ex.exceptionCode}</span></td>
            <td>${ex.patientName}</td>
            <td>${ex.studentName}</td>
            <td style="font-family: monospace;">${ex.studentId}</td>
            <td>${getCourseName(ex.course)}</td>
            <td>${ex.treatmentType}</td>
            <td style="font-weight: 600; color: var(--primary);">${ex.toothNumber}</td>
            <td style="max-width: 200px; font-size: 12px;">${ex.reason}</td>
            <td>
                <span class="badge badge-temp">
                    <i class="fas fa-user-tie"></i>
                    ${ex.granterName}
                </span>
            </td>
            <td>${ex.approver}</td>
            <td>${ex.appointmentDate}</td>
            <td>${ex.appointmentTime}</td>
            <td>
                <span class="badge ${ex.status === 'active' ? 'badge-confirmed' : 'badge-cancelled'}">
                    ${ex.status === 'active' ? 'نشط' : 'ملغى'}
                </span>
            </td>
            <td>
                ${ex.status === 'active' ? `
                    <button class="btn-icon btn-cancel" onclick="openCancelExceptionModal(${ex.id})" title="إلغاء الاستثناء">
                        <i class="fas fa-ban"></i>
                    </button>
                ` : `
                    <button class="btn-icon btn-view" onclick="viewCancelDetails(${ex.id})" title="عرض تفاصيل الإلغاء">
                        <i class="fas fa-info-circle"></i>
                    </button>
                `}
            </td>
        </tr>
    `).join('');
}

function refreshExceptionsData() {
    const btn = document.querySelector('button[onclick="refreshExceptionsData()"] i');
    btn.classList.add('spinning');
    
    setTimeout(() => {
        loadExceptionsTable();
        btn.classList.remove('spinning');
        showToast('تم تحديث البيانات بنجاح', 'success');
    }, 800);
}

function getCourseName(course) {
    const names = {
        'cardiology': 'طب القلب',
        'respiratory': 'أمراض التنفس',
        'neurology': 'طب الأعصاب',
        'clinical': 'فحص سريري'
    };
    return names[course] || course;
}

// ==========================================
// دوال البحث التلقائي في الاستثناءات
// ==========================================
function searchCaseCode(query) {
    const suggestionsDiv = document.getElementById('caseCodeSuggestions');
    
    if (!query || query.length < 2) {
        suggestionsDiv.classList.remove('active');
        return;
    }
    
    const filtered = caseCodesData.filter(c => 
        c.code.toLowerCase().includes(query.toLowerCase()) ||
        c.patient.includes(query)
    );
    
    if (filtered.length === 0) {
        suggestionsDiv.classList.remove('active');
        return;
    }
    
    suggestionsDiv.innerHTML = filtered.map(item => `
        <div class="autocomplete-item" onclick="selectCaseCode('${item.code}')">
            <div style="font-weight: 600; color: var(--dark);">${item.code}</div>
            <div style="font-size: 12px; color: var(--gray);">${item.patient} - ${item.treatment} (سن: ${item.toothNumber})</div>
        </div>
    `).join('');
    
    suggestionsDiv.classList.add('active');
}

function showCaseCodeSuggestions() {
    const suggestionsDiv = document.getElementById('caseCodeSuggestions');
    suggestionsDiv.innerHTML = caseCodesData.map(item => `
        <div class="autocomplete-item" onclick="selectCaseCode('${item.code}')">
            <div style="font-weight: 600; color: var(--dark);">${item.code}</div>
            <div style="font-size: 12px; color: var(--gray);">${item.patient} - ${item.treatment} (سن: ${item.toothNumber})</div>
        </div>
    `).join('');
    suggestionsDiv.classList.add('active');
}

function selectCaseCode(code) {
    const caseData = caseCodesData.find(c => c.code === code);
    if (caseData) {
        document.getElementById('exceptionCaseCode').value = caseData.code;
        document.getElementById('autoTreatmentType').value = caseData.treatment;
        document.getElementById('autoPatientName').value = caseData.patient;
        document.getElementById('autoPatientPhone').value = caseData.phone;
        document.getElementById('autoPatientAge').value = caseData.age + ' سنة';
        document.getElementById('autoToothNumber').value = caseData.toothNumber;
        const newExceptionCode = generateExceptionCode();
        document.getElementById('autoExceptionCode').value = newExceptionCode;
    }
    document.getElementById('caseCodeSuggestions').classList.remove('active');
}

function generateExceptionCode() {
    const year = new Date().getFullYear();
    const random = Math.floor(Math.random() * 900) + 100;
    return `EXC-${year}-${random}`;
}

// ==========================================
// المنطقية الجديدة: اختيار الطالب والمقرر والموعد
// ==========================================
function searchStudentId(query) {
    const suggestionsDiv = document.getElementById('studentSuggestions');
    
    if (!query || query.length < 2) {
        suggestionsDiv.classList.remove('active');
        return;
    }
    
    const filtered = studentsData.filter(s => 
        s.id.includes(query) ||
        s.name.includes(query)
    );
    
    if (filtered.length === 0) {
        suggestionsDiv.classList.remove('active');
        return;
    }
    
    suggestionsDiv.innerHTML = filtered.map(item => `
        <div class="autocomplete-item" onclick="selectStudentId('${item.id}')">
            <div style="font-weight: 600; color: var(--dark);">${item.id}</div>
            <div style="font-size: 12px; color: var(--gray);">${item.name} - ${item.categoryName}</div>
        </div>
    `).join('');
    
    suggestionsDiv.classList.add('active');
}

function showStudentSuggestions() {
    const suggestionsDiv = document.getElementById('studentSuggestions');
    suggestionsDiv.innerHTML = studentsData.map(item => `
        <div class="autocomplete-item" onclick="selectStudentId('${item.id}')">
            <div style="font-weight: 600; color: var(--dark);">${item.id}</div>
            <div style="font-size: 12px; color: var(--gray);">${item.name} - ${item.categoryName}</div>
        </div>
    `).join('');
    suggestionsDiv.classList.add('active');
}

function selectStudentId(id) {
    const student = studentsData.find(s => s.id === id);
    if (student) {
        document.getElementById('exceptionStudentId').value = student.id;
        document.getElementById('autoStudentName').value = student.name;
        document.getElementById('autoStudentPhone').value = student.phone;
        
        // حفظ الطالب المختار
        currentSelectedStudent = student;
        
        // إظهار فئة الطالب
        document.getElementById('studentCategory').value = student.category;
        document.getElementById('studentCategoryDisplay').value = student.categoryName;
        
        const badge = document.getElementById('studentCategoryBadge');
        badge.textContent = student.categoryName;
        badge.className = 'student-category-badge ' + (student.category === 'morning' ? 'category-morning' : 'category-evening');
        
        document.getElementById('studentCategoryGroup').style.display = 'block';
        
        // إظهار اختيار المقرر
        document.getElementById('courseSelectionGroup').style.display = 'block';
        
        // إخفاء قسم الموعد حتى يتم اختيار المقرر
        document.getElementById('appointmentSection').style.display = 'none';
        
        // تعيين التوقيت التلقائي
        updateTimeSlot(student.category);
    }
    document.getElementById('studentSuggestions').classList.remove('active');
}

function onStudentSelected() {
    // تُستخدم عند تغيير الطالب يدوياً
    const id = document.getElementById('exceptionStudentId').value;
    if (id.length >= 9) {
        const student = studentsData.find(s => s.id === id);
        if (student) {
            selectStudentId(student.id);
        }
    }
}

function updateTimeSlot(category) {
    const slot = timeSlots[category];
    if (slot) {
        document.getElementById('assignedTimeSlot').textContent = slot.label;
        document.getElementById('exceptionAppointmentTime').value = slot.start + ' - ' + slot.end;
    }
}

function onCourseSelected() {
    const courseValue = document.getElementById('exceptionCourse').value;
    
    if (!courseValue) {
        document.getElementById('appointmentSection').style.display = 'none';
        document.getElementById('courseInfoBox').style.display = 'none';
        return;
    }
    
    currentSelectedCourse = courseValue;
    const schedule = courseSchedules[courseValue];
    
    if (schedule) {
        // إظهار معلومات المقرر
        const infoBox = document.getElementById('courseInfoBox');
        const daysText = schedule.availableDays.map(d => schedule.dayNames[d]).join(' و ');
        document.getElementById('courseScheduleInfo').innerHTML = `
            <strong>${schedule.name}</strong><br>
            الأيام المتاحة: <strong>${daysText}</strong> من كل أسبوع
        `;
        infoBox.style.display = 'block';
        
        // إنشاء أزرار الأيام المتاحة
        generateAvailableDays(schedule);
        
        // إظهار قسم الموعد
        document.getElementById('appointmentSection').style.display = 'block';
    }
}

function generateAvailableDays(schedule) {
    const container = document.getElementById('availableDaysContainer');
    const allDays = [
        { key: 'saturday', label: 'السبت' },
        { key: 'sunday', label: 'الأحد' },
        { key: 'monday', label: 'الاثنين' },
        { key: 'tuesday', label: 'الثلاثاء' },
        { key: 'wednesday', label: 'الأربعاء' },
        { key: 'thursday', label: 'الخميس' }
    ];
    
    container.innerHTML = allDays.map(day => {
        const isAvailable = schedule.availableDays.includes(day.key);
        const className = isAvailable ? 'day-chip available' : 'day-chip disabled';
        const onclick = isAvailable ? `onclick="selectDay('${day.key}', '${day.label}', this)"` : '';
        
        return `<div class="${className}" ${onclick} data-day="${day.key}">${day.label}</div>`;
    }).join('');
    
    // إعادة تعيين اليوم المختار
    selectedDayValue = null;
    document.getElementById('exceptionAppointmentDate').value = '';
    document.getElementById('selectedDayName').value = '';
    document.getElementById('daySelectionError').style.display = 'none';
}

function selectDay(dayKey, dayLabel, element) {
    // إزالة التحديد السابق
    document.querySelectorAll('.day-chip').forEach(chip => {
        chip.classList.remove('selected');
    });
    
    // تحديد اليوم الجديد
    element.classList.add('selected');
    selectedDayValue = dayKey;
    document.getElementById('selectedDayName').value = dayLabel;
    
    // حساب تاريخ أقرب يوم مطابق (اليوم أو الأسبوع القادم)
    const nextDate = getNextDayDate(dayKey);
    document.getElementById('exceptionAppointmentDate').value = nextDate;
    
    document.getElementById('daySelectionError').style.display = 'none';
}

function getNextDayDate(dayName) {
    const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    const today = new Date();
    const currentDay = today.getDay(); // 0 = الأحد
    
    const targetDay = days.indexOf(dayName);
    let daysUntil = targetDay - currentDay;
    
    if (daysUntil <= 0) {
        daysUntil += 7; // الذهاب للأسبوع القادم
    }
    
    const nextDate = new Date(today);
    nextDate.setDate(today.getDate() + daysUntil);
    
    return nextDate.toISOString().split('T')[0];
}

// ==========================================
// فتح وإغلاق مودال الاستثناء
// ==========================================
function openGrantExceptionModal() {
    // إعادة تعيين جميع الحقول
    document.getElementById('exceptionCaseCode').value = '';
    document.getElementById('autoTreatmentType').value = '';
    document.getElementById('autoPatientName').value = '';
    document.getElementById('autoPatientPhone').value = '';
    document.getElementById('autoPatientAge').value = '';
    document.getElementById('autoToothNumber').value = '';
    document.getElementById('autoExceptionCode').value = '';
    
    document.getElementById('exceptionStudentId').value = '';
    document.getElementById('autoStudentName').value = '';
    document.getElementById('autoStudentPhone').value = '';
    document.getElementById('studentCategory').value = '';
    document.getElementById('studentCategoryDisplay').value = '';
    document.getElementById('studentCategoryBadge').textContent = '';
    document.getElementById('studentCategoryBadge').className = 'student-category-badge';
    
    document.getElementById('exceptionCourse').value = '';
    document.getElementById('courseInfoBox').style.display = 'none';
    
    document.getElementById('assignedTimeSlot').textContent = '--:-- - --:--';
    document.getElementById('exceptionAppointmentTime').value = '';
    document.getElementById('availableDaysContainer').innerHTML = '';
    document.getElementById('exceptionAppointmentDate').value = '';
    document.getElementById('selectedDayName').value = '';
    document.getElementById('daySelectionError').style.display = 'none';
    
    document.getElementById('exceptionReason').value = '';
    document.getElementById('exceptionGranter').value = '';
    
    // إخفاء الأقسام المشروطة
    document.getElementById('studentCategoryGroup').style.display = 'none';
    document.getElementById('courseSelectionGroup').style.display = 'none';
    document.getElementById('appointmentSection').style.display = 'none';
    
    // إعادة تعيين المتغيرات
    currentSelectedStudent = null;
    currentSelectedCourse = null;
    selectedDayValue = null;
    
    document.getElementById('grantExceptionModal').classList.add('active');
}

function closeGrantExceptionModal() {
    document.getElementById('grantExceptionModal').classList.remove('active');
}

function submitException() {
    const caseCode = document.getElementById('exceptionCaseCode').value;
    const patientName = document.getElementById('autoPatientName').value;
    const patientPhone = document.getElementById('autoPatientPhone').value;
    const studentName = document.getElementById('autoStudentName').value;
    const studentId = document.getElementById('exceptionStudentId').value;
    const studentCategory = document.getElementById('studentCategory').value;
    const course = document.getElementById('exceptionCourse').value;
    const treatmentType = document.getElementById('autoTreatmentType').value;
    const toothNumber = document.getElementById('autoToothNumber').value;
    const appointmentDate = document.getElementById('exceptionAppointmentDate').value;
    const appointmentDay = document.getElementById('selectedDayName').value;
    const appointmentTime = document.getElementById('exceptionAppointmentTime').value;
    const reason = document.getElementById('exceptionReason').value;
    const granter = document.getElementById('exceptionGranter').value;
    const approver = document.getElementById('exceptionApprover').value;
    const exceptionCode = document.getElementById('autoExceptionCode').value || generateExceptionCode();
    
    // التحقق من الحقول الإجبارية
    if (!caseCode) {
        showToast('يرجى اختيار رمز الحالة', 'warning');
        return;
    }
    if (!studentId) {
        showToast('يرجى إدخال الرقم الجامعي للطالب', 'warning');
        return;
    }
    if (!course) {
        showToast('يرجى اختيار المقرر', 'warning');
        return;
    }
    if (!appointmentDate) {
        showToast('يرجى اختيار يوم الموعد', 'warning');
        document.getElementById('daySelectionError').style.display = 'block';
        return;
    }
    if (!reason) {
        showToast('يرجى كتابة سبب الاستثناء', 'warning');
        return;
    }
    if (!granter) {
        showToast('يرجى اختيار مانح الاستثناء', 'warning');
        return;
    }
    
    const granterNames = {
        'dean': 'العميد',
        'vice_dean': 'نائب العميد للشؤون العلمية',
        'head_department': 'رئيس الدائرة',
        'theory_instructor': 'مدرس المقرر النظري'
    };
    
    const courseNames = {
        'cardiology': 'طب القلب السريري',
        'respiratory': 'أمراض الجهاز التنفسي',
        'neurology': 'طب الأعصاب السريري',
        'clinical': 'الفحص السريري المتقدم'
    };
    
    const now = new Date();
    const newException = {
        id: Date.now(),
        exceptionCode: exceptionCode,
        caseCode: caseCode,
        patientName: patientName || 'غير محدد',
        patientPhone: patientPhone || 'غير محدد',
        studentName: studentName || 'غير محدد',
        studentId: studentId,
        studentCategory: studentCategory,
        course: course,
        courseName: courseNames[course],
        treatmentType: treatmentType || 'غير محدد',
        toothNumber: toothNumber || 'غير محدد',
        grantDate: now.toISOString().split('T')[0],
        grantTime: now.toLocaleTimeString('ar-SA', {hour: '2-digit', minute: '2-digit'}),
        reason: reason,
        granter: granter,
        granterName: granterNames[granter],
        approver: approver,
        appointmentDate: appointmentDate,
        appointmentDay: appointmentDay,
        appointmentTime: appointmentTime,
        status: 'active',
        cancelDate: null,
        cancelTime: null,
        cancelEmployee: null,
        cancelReason: null
    };
    
    exceptionsData.push(newException);
    
    showToast('تم منح الاستثناء وتثبيت الموعد بنجاح', 'success');
    closeGrantExceptionModal();
    loadExceptionsTable();
}

// ==========================================
// إلغاء الاستثناء
// ==========================================
function openCancelExceptionModal(id) {
    const exception = exceptionsData.find(e => e.id === id);
    if (!exception) return;
    
    document.getElementById('cancelExceptionId').value = id;
    document.getElementById('cancelExceptionReason').value = '';
    document.getElementById('cancelExceptionEmployee').value = 'محمد أحمد الخالد';
    const now = new Date();
    document.getElementById('cancelExceptionTime').value = now.toLocaleString('ar-SA');
    
    document.getElementById('cancelExceptionModal').classList.add('active');
}

function closeCancelExceptionModal() {
    document.getElementById('cancelExceptionModal').classList.remove('active');
}

function confirmCancelException() {
    const id = document.getElementById('cancelExceptionId').value;
    const reason = document.getElementById('cancelExceptionReason').value;
    
    if (!reason) {
        showToast('يرجى كتابة سبب الإلغاء', 'warning');
        return;
    }
    
    const now = new Date();
    const exception = exceptionsData.find(e => e.id == id);
    if (exception) {
        exception.status = 'cancelled';
        exception.cancelReason = reason;
        exception.cancelEmployee = "محمد أحمد الخالد";
        exception.cancelDate = now.toISOString().split('T')[0];
        exception.cancelTime = now.toLocaleTimeString('ar-SA', {hour: '2-digit', minute: '2-digit'});
    }
    
    showToast('تم إلغاء الاستثناء بنجاح', 'success');
    closeCancelExceptionModal();
    loadExceptionsTable();
}

function viewCancelDetails(id) {
    const exception = exceptionsData.find(e => e.id === id);
    if (!exception || exception.status !== 'cancelled') return;
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay active';
    modal.innerHTML = `
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3><i class="fas fa-info-circle" style="color: var(--primary); margin-left: 8px;"></i>تفاصيل إلغاء الاستثناء</h3>
                <button onclick="this.closest('.modal-overlay').remove()" style="background: none; border: none; font-size: 20px; color: var(--gray); cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="cancel-info-box">
                    <div class="cancel-info-title">
                        <i class="fas fa-ban"></i>
                        معلومات الإلغاء
                    </div>
                    <div class="cancel-info-row">
                        <span class="cancel-info-label">تم الإلغاء بواسطة:</span>
                        <span class="cancel-info-value">${exception.cancelEmployee}</span>
                    </div>
                    <div class="cancel-info-row">
                        <span class="cancel-info-label">تاريخ الإلغاء:</span>
                        <span class="cancel-info-value">${exception.cancelDate}</span>
                    </div>
                    <div class="cancel-info-row">
                        <span class="cancel-info-label">وقت الإلغاء:</span>
                        <span class="cancel-info-value">${exception.cancelTime}</span>
                    </div>
                    <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid rgba(239, 68, 68, 0.2);">
                        <span class="cancel-info-label">سبب الإلغاء:</span>
                        <p style="margin-top: 4px; color: var(--dark); font-size: 13px; line-height: 1.5;">${exception.cancelReason}</p>
                    </div>
                </div>
                
                <div style="margin-top: 16px; background: var(--gray-light); padding: 12px; border-radius: var(--radius-sm);">
                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 8px;">بيانات الاستثناء الأصلية</div>
                    <div style="font-size: 13px; color: var(--dark);">
                        <strong>${exception.exceptionCode}</strong> - ${exception.patientName}<br>
                        الطالب: ${exception.studentName} (${exception.studentId})<br>
                        المقرر: ${exception.courseName}<br>
                        الموعد: ${exception.appointmentDay} ${exception.appointmentDate}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="this.closest('.modal-overlay').remove()" class="modern-btn" style="flex: 1; background: var(--gray-light); color: var(--dark);">
                    إغلاق
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// ==========================================
// دوال مساعدة
// ==========================================
function viewBookingDetails(id) {
    showToast('جاري عرض تفاصيل الحجز رقم ' + id, 'info');
}

function showToast(message, type = 'info') {
    const colors = {
        info: 'var(--primary)',
        success: 'var(--secondary)',
        warning: 'var(--warning)',
        danger: 'var(--danger)'
    };
    
    const toast = document.createElement('div');
    toast.innerHTML = `
        <div style="position: fixed; top: 80px; left: 16px; right: 16px; background: ${colors[type] || colors.info}; 
                   color: white; padding: 12px 16px; border-radius: var(--radius); z-index: 10000; 
                   text-align: center; font-weight: 500; animation: slideDown 0.3s ease;">
            ${message}
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// إغلاق القوائم المنسدلة عند النقر خارجها
document.addEventListener('click', function(e) {
    if (!e.target.closest('.custom-dropdown') && !e.target.closest('.autocomplete-container')) {
        closeAllDropdowns();
        document.querySelectorAll('.autocomplete-list').forEach(list => {
            list.classList.remove('active');
        });
    }
});
</script>
@endsection

