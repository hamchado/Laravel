@extends('layouts.app')

@section('title', 'الأعمال')
@section('page_title', 'الأعمال')

@section('content')

<style>
:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --primary-light: #818cf8;
    --dark: #1f2937;
    --gray: #6b7280;
    --gray-light: #f3f4f6;
    --font-sm: clamp(11px, 1.4vw, 13px);
    --font-base: clamp(12px, 1.6vw, 14px);
    --font-lg: clamp(14px, 2vw, 16px);
}

/* ===== الشريط العلوي الجديد من الكود 2 ===== */
.tabs-container {
    display: flex;
    background: white;
    border-bottom: 1px solid #e5e7eb;
    overflow-x: auto;
    overflow-y: hidden;
    scrollbar-width: none;
    -ms-overflow-style: none;
    -webkit-overflow-scrolling: touch;
    width: 100%;
    margin: 0;
    border-radius: 16px;
    padding: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    gap: 4px;
}

.tabs-container::-webkit-scrollbar {
    display: none;
}

.tab-item {
    flex: 1;
    min-width: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 10px;
    font-size: 13px;
    font-weight: 600;
    color: #9ca3af;
    cursor: pointer;
    position: relative;
    white-space: nowrap;
    transition: all 0.3s ease;
    background: transparent;
    border: none;
    font-family: inherit;
    border-radius: 12px;
}

.tab-item i {
    font-size: 15px;
    color: inherit;
    transition: all 0.3s ease;
}

.tab-item.active {
    color: var(--primary);
    background: rgba(99, 102, 241, 0.08);
}

.tab-item.active::after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    border-radius: 3px;
    box-shadow: 0 -2px 8px rgba(99, 102, 241, 0.4);
    animation: expandLine 0.3s ease;
}

@keyframes expandLine {
    from { width: 0; opacity: 0; }
    to { width: 60%; opacity: 1; }
}

.tab-item:active {
    opacity: 0.8;
    transform: scale(0.98);
}

.tab-item:hover:not(.active) {
    color: var(--gray);
    background: rgba(0,0,0,0.02);
}

@media (max-width: 640px) {
    .tab-item {
        padding: 12px 8px;
        font-size: 12px;
        min-width: 90px;
    }
    .tab-item i {
        font-size: 14px;
    }
    .tab-item.active::after {
        height: 2.5px;
        bottom: 4px;
        width: 70%;
    }
}

@media (max-width: 380px) {
    .tab-item {
        font-size: 11px;
        gap: 4px;
        min-width: 80px;
        padding: 10px 6px;
    }
    .tab-item i {
        font-size: 12px;
    }
    .tab-item.active::after {
        width: 80%;
    }
}

/* ===== باقي CSS من الكود 1 ===== */
.management-section {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 16px;
    padding: 20px;
    margin: 20px 0;
    border: 1px solid rgba(229, 231, 235, 0.6);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    position: relative;
    z-index: 1;
}

.section-title {
    font-size: var(--font-lg);
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: var(--primary);
    font-size: 18px;
}

.custom-dropdown-simple {
    position: relative;
    width: 100%;
    z-index: 100;
}

.custom-dropdown-simple.dropdown-open {
    z-index: 200;
}

.dropdown-header-simple {
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    font-size: var(--font-base);
    font-weight: 600;
    color: var(--dark);
    transition: all 0.3s ease;
}

.custom-dropdown-simple.dropdown-open .dropdown-header-simple {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.dropdown-icon-simple {
    transition: transform 0.3s ease;
    color: var(--gray);
    font-size: 12px;
}

.custom-dropdown-simple.dropdown-open .dropdown-icon-simple {
    transform: rotate(180deg);
    color: var(--primary);
}

.dropdown-options-simple {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    animation: dropdownSlide 0.2s ease;
    max-height: 250px;
}

@keyframes dropdownSlide {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.custom-dropdown-simple.dropdown-open .dropdown-options-simple {
    display: block;
}

.dropdown-option-simple {
    padding: 14px 18px;
    cursor: pointer;
    font-size: var(--font-base);
    transition: all 0.2s;
    color: #4b5563;
    border-bottom: 1px solid #f3f4f6;
    font-weight: 500;
}

.dropdown-option-simple:last-child {
    border-bottom: none;
}

.dropdown-option-simple:hover {
    background: rgba(99, 102, 241, 0.05);
    color: var(--primary);
    padding-right: 24px;
}

.dropdown-option-simple.selected {
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary);
    font-weight: 700;
}

.cases-table tbody tr { cursor: default; transition: background 0.2s; border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.3s ease forwards; }
.cases-table tbody tr:hover { background: rgba(99, 102, 241, 0.04); }
.status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap; }
.status-badge.completed { background: rgba(16, 185, 129, 0.15); color: #10b981; }
.status-badge.inProgress { background: rgba(99, 102, 241, 0.15); color: var(--primary); }
.status-badge.waitingEvaluation { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
.status-badge.waitingAcceptance { background: rgba(107, 114, 128, 0.15); color: #6b7280; }
.status-badge.rejected { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
.status-badge.transferred { background: rgba(139, 92, 246, 0.15); color: #8b5cf6; }
.rating-checkbox { width: clamp(24px, 6vw, 28px); height: clamp(24px, 6vw, 28px); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: clamp(11px, 2.8vw, 13px); font-weight: 700; cursor: pointer; position: relative; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
.rating-checkbox:hover { transform: scale(1.15); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.rating-checkbox:active { transform: scale(0.95); }

.images-icon { 
    width: clamp(28px, 7vw, 32px); 
    height: clamp(28px, 7vw, 32px); 
    border-radius: 8px; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 16px; 
    cursor: pointer; 
    transition: all 0.2s ease; 
    margin: 0 auto; 
    user-select: none; 
    font-weight: 700;
}
.images-icon.required { 
    background: linear-gradient(135deg, var(--primary), var(--primary-light)); 
    color: white; 
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3); 
}
.images-icon.required:hover { 
    transform: scale(1.1); 
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4); 
}
.images-icon.not-required { 
    background: #f3f4f6; 
    color: #9ca3af; 
    cursor: pointer;
    font-size: 14px;
    border: 2px solid #e5e7eb;
    transition: all 0.2s ease;
}
.images-icon.not-required:hover {
    background: #fee2e2;
    color: #ef4444;
    border-color: #fecaca;
    transform: scale(1.05);
}

.studio-image-item { 
    position: relative; 
    transition: all 0.2s ease; 
    border-radius: 12px; 
    overflow: hidden; 
    aspect-ratio: 1; 
    background: #f9fafb;
    border: 2px solid transparent;
    cursor: pointer;
}
.studio-image-item:active { transform: scale(0.96); }
.studio-image-item.panorama { aspect-ratio: 16/9; border-color: #f59e0b; }
.studio-image-item.panorama.in-use { border-color: #10b981; }
.studio-image-item.in-use { opacity: 0.4; cursor: not-allowed; filter: grayscale(0.8); position: relative; }
.studio-image-item.in-use::after {
    content: 'مستخدمة';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
}
.image-label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 20px 8px 8px;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.date-header { 
    display: flex; 
    align-items: center; 
    gap: 12px; 
    margin-bottom: 12px; 
    color: #6b7280; 
    font-weight: 600; 
    font-size: 13px; 
}
.date-header::before, .date-header::after { 
    content: ''; 
    flex: 1; 
    height: 1px; 
    background: #e5e7eb; 
}
.deleted-item { position: relative; opacity: 0.8; }
.deleted-item .restore-btn { 
    position: absolute; 
    bottom: 8px; 
    left: 50%; 
    transform: translateX(-50%); 
    background: var(--primary); 
    color: white; 
    border: none; 
    padding: 6px 12px; 
    border-radius: 20px; 
    font-size: 11px; 
    font-weight: 600; 
    cursor: pointer; 
    opacity: 0; 
    transition: all 0.2s; 
    white-space: nowrap; 
    z-index: 10; 
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.deleted-item:hover .restore-btn { opacity: 1; }
.deleted-item .time-left { 
    position: absolute; 
    top: 8px; 
    right: 8px; 
    background: rgba(239, 68, 68, 0.9); 
    color: white; 
    padding: 4px 8px; 
    border-radius: 12px; 
    font-size: 10px; 
    font-weight: 700; 
    z-index: 10; 
}

@keyframes modalSlideUp { 
    from { opacity: 0; transform: translate(-50%, -40%); } 
    to { opacity: 1; transform: translate(-50%, -50%); } 
}
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
@keyframes slideDown { from { opacity: 0; transform: translate(-50%, -20px); } to { opacity: 1; transform: translate(-50%, 0); } }
@keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }

@media (max-width: 480px) {
    .management-section {
        padding: 16px;
        margin: 16px 0;
        border-radius: 12px;
    }
}
</style>

<!-- الشريط العلوي الجديد -->
<div class="management-section" style="padding: 6px; margin-bottom: 20px;">
    <div class="tabs-container" style="margin: 0; border-radius: 12px; box-shadow: none; border: none;">
        <button class="tab-item active" onclick="switchMainTab(this, 'works')">
            <i class="fas fa-clipboard-list"></i>
            <span>الأعمال والحالات</span>
        </button>
        <button class="tab-item" onclick="switchMainTab(this, 'add-case')">
            <i class="fas fa-plus-circle"></i>
            <span>إضافة حالة جديدة</span>
        </button>
        <button class="tab-item" onclick="switchMainTab(this, 'manh-hala')">
            <i class="fas fa-gift"></i>
            <span>منح حالة</span>
        </button>
    </div>
</div>

<!-- قسم الأعمال والحالات -->
<div id="works-section" class="tab-content-section" style="display: block;">
    <!-- قسم إدارة المقررات -->
    <div class="management-section">
        <div class="section-title">
            <i class="fas fa-th-large"></i>
            <span>إدارة المقررات والأعمال المطلوبة</span>
        </div>
        
        <div style="display: grid; gap: 16px;">
            <!-- Dropdown المقررات -->
            <div class="custom-dropdown-simple" id="courseDropdown">
                <div class="section-title" style="margin-bottom: 12px; font-size: var(--font-sm);">
                    <i class="fas fa-book"></i>
                    <span>اختر المقرر</span>
                </div>
                <div class="dropdown-header-simple" onclick="toggleDropdownSimple('courseDropdown')">
                    <span id="courseHeaderText">جميع المقررات</span>
                    <i class="fas fa-chevron-down dropdown-icon-simple"></i>
                </div>
                <div class="dropdown-options-simple" id="courseOptions">
                    <div class="dropdown-option-simple selected" onclick="selectCourseSimple('all', 'جميع المقررات')">جميع المقررات</div>
                    <div class="dropdown-option-simple" onclick="selectCourseSimple('restorative', 'مداواة الأسنان الترميمية 4')">مداواة الأسنان الترميمية 4</div>
                    <div class="dropdown-option-simple" onclick="selectCourseSimple('exodontia', 'تخدير و قلع الأسنان 4')">تخدير و قلع الأسنان 4</div>
                    <div class="dropdown-option-simple" onclick="selectCourseSimple('periodontics', 'النسج حول سنية 2')">النسج حول سنية 2</div>
                    <div class="dropdown-option-simple" onclick="selectCourseSimple('endodontics', 'مداواة الأسنان اللبية 4')">مداواة الأسنان اللبية 4</div>
                </div>
            </div>

            <!-- Dropdown نمط العرض -->
            <div class="custom-dropdown-simple" id="statusDropdown">
                <div class="section-title" style="margin-bottom: 12px; font-size: var(--font-sm);">
                    <i class="fas fa-filter"></i>
                    <span>نمط العرض</span>
                </div>
                <div class="dropdown-header-simple" onclick="toggleDropdownSimple('statusDropdown')">
                    <span id="statusHeaderText">جميع الحالات</span>
                    <i class="fas fa-chevron-down dropdown-icon-simple"></i>
                </div>
                <div class="dropdown-options-simple" id="statusOptions">
                    <div class="dropdown-option-simple selected" onclick="selectStatusSimple('all', 'جميع الحالات')">جميع الحالات</div>
                    <div class="dropdown-option-simple" onclick="selectStatusSimple('completed', 'مكتمل')">مكتمل</div>
                    <div class="dropdown-option-simple" onclick="selectStatusSimple('inProgress', 'قيد الإنجاز')">قيد الإنجاز</div>
                    <div class="dropdown-option-simple" onclick="selectStatusSimple('waitingEvaluation', 'بانتظار التقييم')">بانتظار التقييم</div>
                    <div class="dropdown-option-simple" onclick="selectStatusSimple('waitingAcceptance', 'بانتظار القبول')">بانتظار القبول</div>
                    <div class="dropdown-option-simple" onclick="selectStatusSimple('rejected', 'مرفوض')">مرفوض</div>
                    <div class="dropdown-option-simple" onclick="selectStatusSimple('transferred', 'محولة')">محولة</div>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول الحالات -->
    <div class="input-container" style="padding: 0; overflow: hidden; margin-top: 20px;">
        <div style="padding: clamp(16px, 4vw, 20px); background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(129, 140, 248, 0.05)); border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: clamp(0.9375rem, 2.8vw, 1.125rem); color: var(--dark); margin: 0; font-weight: 700;">
                <i class="fas fa-clipboard-list" style="color: var(--primary); margin-left: 8px;"></i>
                سجل الأعمال والحالات
            </h3>
        </div>
        
        <!-- شريط البحث -->
        <div style="padding: 16px 20px; border-bottom: 1px solid #f3f4f6;">
            <div style="position: relative;">
                <input type="text" id="casesSearch" class="text-input" placeholder="ابحث عن حالة، مريض، أو مقرر..." style="padding-right: 40px; width: 100%; border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 14px;">
                <button onclick="searchCases()" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); background: var(--primary); color: white; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <!-- الجدول -->
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="cases-table" style="min-width: 1000px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-user" style="margin-left: 6px; color: var(--primary);"></i>المريض</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-tag" style="margin-left: 6px; color: var(--primary);"></i>نوع الحالة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-book" style="margin-left: 6px; color: var(--primary);"></i>المقرر</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-info-circle" style="margin-left: 6px; color: var(--primary);"></i>الحالة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-star" style="margin-left: 6px; color: var(--primary);"></i>التقييمات</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-images" style="margin-left: 6px; color: var(--primary);"></i>صور الحالة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-user-md" style="margin-left: 6px; color: var(--primary);"></i>المشرف</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-calendar-plus" style="margin-left: 6px; color: var(--primary);"></i>تاريخ الإضافة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-calendar-check" style="margin-left: 6px; color: var(--primary);"></i>تاريخ القبول</th>
                    </tr>
                </thead>
                <tbody id="casesTableBody"></tbody>
            </table>
        </div>
        
        <!-- ترقيم الصفحات -->
        <div id="casesPagination" style="display: none; justify-content: center; align-items: center; gap: 12px; padding: clamp(16px, 4vw, 20px); border-top: 1px solid #e5e7eb;">
            <button onclick="changeCasesPage('prev')" id="casesPrevBtn" style="background: white; border: 2px solid #e5e7eb; color: #64748b; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; font-size: clamp(0.75rem, 2vw, 0.875rem); opacity: 0.5;" disabled>
                السابق
            </button>
            <span id="casesPageIndicator" style="font-weight: 700; color: var(--primary); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">صفحة 1 من 1</span>
            <button onclick="changeCasesPage('next')" id="casesNextBtn" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); font-size: clamp(0.75rem, 2vw, 0.875rem); opacity: 0.5;" disabled>
                التالي
            </button>
        </div>
    </div>

    <!-- دليل حالات العمل -->
    <div class="input-container" style="margin-top: 20px; padding: 0; overflow: hidden;">
        <div style="padding: clamp(16px, 4vw, 20px); background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.05)); border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: clamp(0.9375rem, 2.8vw, 1.125rem); color: var(--dark); margin: 0; font-weight: 700;">
                <i class="fas fa-info-circle" style="color: var(--secondary); margin-left: 8px;"></i>
                دليل حالات العمل
            </h3>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; width: 150px;">الحالة</th>
                        <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الوصف</th>
                        <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; width: 100px;">اللون</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 12px; text-align: center;"><span class="status-badge waitingAcceptance" style="font-size: 12px;">بانتظار القبول</span></td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; color: #4b5563;">الحالة قيد الانتظار لموافقة المشرف، لا يوجد تاريخ قبول ولا يمكن رفع صور أو تقييمات.</td>
                        <td style="padding: 12px; text-align: center;"><div style="width: 20px; height: 20px; background: #6b7280; border-radius: 4px; margin: 0 auto;"></div></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f3f4f6; background: rgba(249, 250, 251, 0.5);">
                        <td style="padding: 12px; text-align: center;"><span class="status-badge waitingEvaluation" style="font-size: 12px;">بانتظار التقييم</span></td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; color: #4b5563;">يتم بدء رفع صور الحالة بعد اول تقييم للحالة.</td>
                        <td style="padding: 12px; text-align: center;"><div style="width: 20px; height: 20px; background: #f59e0b; border-radius: 4px; margin: 0 auto;"></div></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 12px; text-align: center;"><span class="status-badge inProgress" style="font-size: 12px;">قيد الإنجاز</span></td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; color: #4b5563;">الحالة مقبولة وجاري العمل عليها، تم تسجيل تقييم واحد على الأقل.</td>
                        <td style="padding: 12px; text-align: center;"><div style="width: 20px; height: 20px; background: var(--primary); border-radius: 4px; margin: 0 auto;"></div></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f3f4f6; background: rgba(249, 250, 251, 0.5);">
                        <td style="padding: 12px; text-align: center;"><span class="status-badge completed" style="font-size: 12px;">مكتمل</span></td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; color: #4b5563;">تم إنجاز الحالة بنجاح واستكمال جميع مراحل التقييم (3 مراحل).</td>
                        <td style="padding: 12px; text-align: center;"><div style="width: 20px; height: 20px; background: #10b981; border-radius: 4px; margin: 0 auto;"></div></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 12px; text-align: center;"><span class="status-badge rejected" style="font-size: 12px;">مرفوض</span></td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; color: #4b5563;">تم رفض الحالة من المشرف، لا يوجد تاريخ قبول ولا يمكن إضافة تقييمات أو صور.</td>
                        <td style="padding: 12px; text-align: center;"><div style="width: 20px; height: 20px; background: #ef4444; border-radius: 4px; margin: 0 auto;"></div></td>
                    </tr>
                    <tr style="background: rgba(249, 250, 251, 0.5);">
                        <td style="padding: 12px; text-align: center;"><span class="status-badge transferred" style="font-size: 12px;">محولة</span></td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; color: #4b5563;">تم تحويل الحالة إلى نوع معالجة آخر، لا يمكن رفع صور.</td>
                        <td style="padding: 12px; text-align: center;"><div style="width: 20px; height: 20px; background: #8b5cf6; border-radius: 4px; margin: 0 auto;"></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- قسم إضافة حالة جديدة -->
<div id="add-case-section" class="tab-content-section" style="display: none;">
    @include('student.add-hala-explore')
</div>

<!-- قسم منح حالة -->
<div id="manh-hala-section" class="tab-content-section" style="display: none;">
    @include('student.manh-hala-explore')
</div>

<!-- Modal صور الحالة -->
<div id="caseImagesModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 2000; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 16px; width: 94%; max-width: 480px; max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2); padding: clamp(16px, 4vw, 20px);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid rgba(99, 102, 241, 0.1); padding-bottom: 12px;">
            <h3 style="font-size: clamp(14px, 4vw, 16px); color: var(--dark); font-weight: 700; margin: 0; line-height: 1.4; text-align: right; flex: 1;">
                <i class="fas fa-images" style="color: var(--primary); margin-left: 6px; font-size: 0.85em;"></i>
                صور الحالة<br>
                <span id="modalCaseName" style="color: var(--primary); font-size: clamp(12px, 3.5vw, 14px); display: inline-block; margin-top: 4px;"></span>
            </h3>
            <button onclick="closeCaseImagesModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 16px; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; margin-right: 8px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div id="caseImagesGrid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 16px;"></div>
        
        <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
            <button onclick="openStudioModal()" style="width: 100%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 14px; font-family: inherit;">
                <i class="fas fa-cloud-upload-alt"></i>
                اختيار صور من الاستديو
            </button>
        </div>
    </div>
</div>

<!-- Modal استديو الصور -->
<div id="studioModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 3000; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 16px; width: 94%; max-width: 480px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <div style="padding: clamp(16px, 4vw, 20px);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid rgba(99, 102, 241, 0.1); padding-bottom: 12px;">
                <h3 style="font-size: clamp(14px, 4vw, 16px); color: var(--dark); font-weight: 700; margin: 0; line-height: 1.4; text-align: right; flex: 1;">
                    <i class="fas fa-camera-retro" style="color: var(--primary); margin-left: 6px; font-size: 0.85em;"></i>
                    <span id="studioTitle">استديو الصور</span><br>
                    <span id="studioCourseName" style="color: var(--gray); font-size: clamp(11px, 3vw, 12px); display: inline-block; margin-top: 4px;"></span>
                </h3>
                <button onclick="closeStudioModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 16px; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; margin-right: 8px;">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            
            <!-- Tabs -->
            <div style="display: flex; border-bottom: 1px solid #e5e7eb; margin-bottom: 16px;">
                <button onclick="switchStudioTab('regular')" id="tab-regular" style="flex: 1; padding: 12px; background: white; border: none; border-bottom: 2px solid var(--primary); color: var(--primary); font-weight: 700; cursor: pointer; font-family: inherit; font-size: 13px;">
                    <i class="fas fa-images" style="margin-left: 4px;"></i>الصور العادية
                </button>
                <button onclick="switchStudioTab('panorama')" id="tab-panorama" style="flex: 1; padding: 12px; background: transparent; border: none; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 13px;">
                    <i class="fas fa-x-ray" style="margin-left: 4px;"></i>الصور الشعاعية
                </button>
                <button onclick="switchStudioTab('deleted')" id="tab-deleted" style="flex: 1; padding: 12px; background: transparent; border: none; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 13px; position: relative;">
                    <i class="fas fa-trash-alt" style="margin-left: 4px;"></i>المحذوفات
                    <span id="deletedCount" style="position: absolute; top: 4px; right: 4px; background: #ef4444; color: white; min-width: 18px; height: 18px; border-radius: 50%; font-size: 10px; display: none; align-items: center; justify-content: center; padding: 0 5px;">0</span>
                </button>
            </div>
            
            <!-- قسم الصور العادية -->
            <div id="studio-regular-section">
                <!-- مؤشر التحميل -->
                <div id="uploadProgressContainer" style="display: none; margin-bottom: 16px; background: #f3f4f6; border-radius: 8px; padding: 12px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12px; color: var(--dark);">
                        <span>جاري رفع الصور...</span>
                        <span id="uploadProgressText">0%</span>
                    </div>
                    <div style="width: 100%; height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden;">
                        <div id="uploadProgressBar" style="width: 0%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--primary-light)); transition: width 0.3s ease;"></div>
                    </div>
                </div>

                <!-- زر رفع من الموبايل -->
                <div style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(236, 72, 153, 0.05)); border: 2px dashed rgba(99, 102, 241, 0.3); border-radius: 12px; padding: 16px; margin-bottom: 20px; text-align: center; cursor: pointer; transition: all 0.2s;" onclick="checkMobileUploadAllowed()" onmouseover="this.style.borderColor='var(--primary)'; this.style.background='rgba(99,102,241,0.08)'" onmouseout="this.style.borderColor='rgba(99, 102, 241, 0.3)'; this.style.background='linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(236, 72, 153, 0.05))'">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; color: white; font-size: 20px;">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div style="color: var(--dark); font-weight: 600; font-size: 14px; margin-bottom: 4px;">رفع صور من الموبايل</div>
                    <div style="color: var(--gray); font-size: 12px;">اضغط لاختيار صور من معرض الهاتف</div>
                    <input type="file" id="mobileUploadInput" accept="image/*" multiple style="display: none;" onchange="handleMobileUpload(event)">
                </div>
                
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                            <i class="fas fa-images"></i>
                        </div>
                        <div>
                            <div style="font-size: 14px; font-weight: 700; color: var(--dark);">الصور العادية</div>
                            <div style="font-size: 11px; color: var(--gray);">اضغط مطولاً للاختيار أو الحذف</div>
                        </div>
                    </div>
                    <div id="studioRegularGrid" style="display: flex; flex-direction: column; gap: 20px;"></div>
                </div>
            </div>
            
            <!-- قسم الصور الشعاعية -->
            <div id="studio-panorama-section" style="display: none;">
                <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 10px; padding: 12px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-info-circle" style="color: #d97706; font-size: 16px;"></i>
                    <span style="color: #92400e; font-size: 12px; font-weight: 500;">الصور الشعاعية مخصصة للحالات التي تتطلب أشعة شاملة فقط (لا يمكن حذفها)</span>
                </div>
                <div id="studioPanoramaGrid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;"></div>
            </div>
            
            <!-- قسم المحذوفات -->
            <div id="studio-deleted-section" style="display: none;">
                <div style="background: #fee2e2; border: 1px solid #ef4444; border-radius: 10px; padding: 12px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-trash-alt" style="color: #dc2626; font-size: 16px;"></i>
                    <span style="color: #991b1b; font-size: 12px; font-weight: 500;">الصور المحذوفة تُحذف نهائياً بعد 48 ساعة</span>
                </div>
                <div id="deletedImagesGrid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal عرض الصورة -->
<div id="imageViewerModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.95); z-index: 4000; align-items: center; justify-content: center; padding: 20px;">
    <button onclick="closeImageViewer()" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; z-index: 10; transition: all 0.2s;">
        <i class="fas fa-times"></i>
    </button>
    <img id="viewerImage" src="" style="max-width: 100%; max-height: 90vh; border-radius: 12px; object-fit: contain; box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
    <div id="viewerLabel" style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.7); color: white; padding: 10px 20px; border-radius: 20px; font-size: 14px; font-weight: 600; max-width: 90%; text-align: center;"></div>
</div>

<!-- Modal خيارات الصورة (النقر الطويل) -->
<div id="imageOptionsModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); z-index: 5000; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 20px; padding: 24px; width: 90%; max-width: 340px; box-shadow: 0 25px 70px rgba(0,0,0,0.3); text-align: center; animation: modalSlideUp 0.3s ease;">
        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(236, 72, 153, 0.1)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: var(--primary); font-size: 28px;">
            <i class="fas fa-image"></i>
        </div>
        <h3 style="font-size: 17px; font-weight: 700; color: var(--dark); margin-bottom: 8px;">خيارات الصورة</h3>
        <p id="optionsImageLabel" style="font-size: 13px; color: var(--gray); margin-bottom: 20px; font-weight: 500;"></p>
        
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button onclick="selectImageForCase()" style="width: 100%; padding: 14px; border: none; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border-radius: 12px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-check-circle"></i>
                اختيار للحالة الحالية
            </button>
            <button id="viewImageBtn" onclick="viewSelectedImage()" style="width: 100%; padding: 14px; border: 1px solid #e5e7eb; background: white; color: var(--dark); border-radius: 12px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-eye"></i>
                عرض الصورة
            </button>
            <button id="deleteImageBtn" onclick="moveToTrashFromOptions()" style="width: 100%; padding: 14px; border: 1px solid #fecaca; background: #fef2f2; color: #ef4444; border-radius: 12px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-trash-alt"></i>
                حذف من الاستديو
            </button>
            <button onclick="closeImageOptions()" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; background: white; color: var(--gray-dark); border-radius: 12px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 14px; margin-top: 6px;">
                إلغاء
            </button>
        </div>
    </div>
</div>

<!-- Modal تأكيد الاختيار -->
<div id="selectConfirmModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); z-index: 5500; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 20px; padding: 24px; width: 90%; max-width: 360px; box-shadow: 0 25px 70px rgba(0,0,0,0.3); text-align: center; animation: modalSlideUp 0.3s ease;">
        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #10b981; font-size: 28px;">
            <i class="fas fa-check"></i>
        </div>
        <h3 style="font-size: 17px; font-weight: 700; color: var(--dark); margin-bottom: 12px;">تأكيد الاختيار</h3>
        
        <div style="background: #f9fafb; border-radius: 12px; padding: 16px; margin-bottom: 20px; text-align: right;">
            <div style="margin-bottom: 10px;">
                <span style="color: var(--gray); font-size: 12px;">الحالة:</span>
                <div id="confirmCaseType" style="color: var(--dark); font-weight: 700; font-size: 14px; margin-top: 2px;"></div>
            </div>
            <div>
                <span style="color: var(--gray); font-size: 12px;">المريض:</span>
                <div id="confirmPatientName" style="color: var(--primary); font-weight: 700; font-size: 14px; margin-top: 2px;"></div>
            </div>
        </div>
        
        <p style="font-size: 13px; color: var(--gray); margin-bottom: 20px;">هل تريد اختيار هذه الصورة للحالة المحددة؟</p>
        
        <div style="display: flex; gap: 10px;">
            <button onclick="cancelSelectConfirm()" style="flex: 1; padding: 12px; border: 1px solid #e5e7eb; background: white; color: var(--dark); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 14px;">إلغاء</button>
            <button onclick="confirmSelectImage()" style="flex: 1; padding: 12px; border: none; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 10px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 14px;">نعم، اختر الصورة</button>
        </div>
    </div>
</div>

<!-- Modal تسمية الصور (وصف الصورة) -->
<div id="uploadLabelsModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 3500; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 16px; padding: 20px; width: 94%; max-width: 400px; max-height: 80vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--dark); margin-bottom: 16px; text-align: center;">
            <i class="fas fa-tags" style="color: var(--primary); margin-left: 6px;"></i>
            تسمية الصور المرفوعة
        </h3>
        <div id="uploadLabelsContainer" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;"></div>
        <button onclick="saveUploadLabels()" style="width: 100%; padding: 14px; border: none; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border-radius: 10px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 14px;">
            حفظ الصور في الاستديو
        </button>
    </div>
</div>

<!-- Tooltip موحد للجميع -->
<div id="unifiedTooltip" style="display: none; position: fixed; background: var(--dark); color: white; padding: 10px 16px; border-radius: 10px; font-size: clamp(0.75rem, 2vw, 0.875rem); z-index: 100001; box-shadow: 0 4px 16px rgba(0,0,0,0.25); white-space: nowrap; font-weight: 600; pointer-events: none; max-width: 280px; text-align: center;">
    <div style="position: absolute; bottom: -8px; right: 50%; transform: translateX(50%); width: 0; height: 0; border-left: 8px solid transparent; border-right: 8px solid transparent; border-top: 8px solid var(--dark);"></div>
</div>

<script>
// ========== التنقل بين الأقسام الرئيسية ==========
function switchMainTab(element, tabName) {
    // إزالة النشاط من جميع التبويبات
    document.querySelectorAll('.tabs-container .tab-item').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // تفعيل التبويب المختار
    element.classList.add('active');
    
    // إخفاء جميع الأقسام
    document.querySelectorAll('.tab-content-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // إظهار القسم المطلوب
    const targetSection = document.getElementById(tabName + '-section');
    if (targetSection) {
        targetSection.style.display = 'block';
    }
    
    // تمرير للأعلى
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ========== Dropdown Functions ==========
function toggleDropdownSimple(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const isOpen = dropdown.classList.contains('dropdown-open');
    
    document.querySelectorAll('.custom-dropdown-simple').forEach(d => {
        d.classList.remove('dropdown-open');
    });
    
    if (!isOpen) {
        dropdown.classList.add('dropdown-open');
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.custom-dropdown-simple')) {
        document.querySelectorAll('.custom-dropdown-simple').forEach(d => {
            d.classList.remove('dropdown-open');
        });
    }
});

function selectCourseSimple(value, label) {
    document.getElementById('courseHeaderText').textContent = label;
    const dropdown = document.getElementById('courseDropdown');
    
    dropdown.querySelectorAll('.dropdown-option-simple').forEach(opt => {
        opt.classList.toggle('selected', opt.textContent.trim() === label);
    });
    
    dropdown.classList.remove('dropdown-open');
    currentCourseFilter = value;
    currentPage = 1;
    loadCasesTable();
}

function selectStatusSimple(value, label) {
    document.getElementById('statusHeaderText').textContent = label;
    const dropdown = document.getElementById('statusDropdown');
    
    dropdown.querySelectorAll('.dropdown-option-simple').forEach(opt => {
        opt.classList.toggle('selected', opt.textContent.trim() === label);
    });
    
    dropdown.classList.remove('dropdown-open');
    currentStatusFilter = value;
    currentPage = 1;
    loadCasesTable();
}

// ========== Tooltip Functions ==========
function showUnifiedTooltip(event, text, element) {
    event.stopPropagation();
    const tooltip = document.getElementById('unifiedTooltip');
    
    hideUnifiedTooltip();
    
    tooltip.textContent = text;
    tooltip.style.display = 'block';
    activeTooltipElement = element;
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
    
    setTimeout(() => {
        document.addEventListener('click', hideTooltipOnClickOutside);
    }, 10);
}

function hideUnifiedTooltip() {
    const tooltip = document.getElementById('unifiedTooltip');
    if (tooltip) {
        tooltip.style.display = 'none';
    }
    activeTooltipElement = null;
    document.removeEventListener('click', hideTooltipOnClickOutside);
}

function hideTooltipOnClickOutside(event) {
    const tooltip = document.getElementById('unifiedTooltip');
    if (tooltip && !tooltip.contains(event.target) && (!activeTooltipElement || !activeTooltipElement.contains(event.target))) {
        hideUnifiedTooltip();
    }
}

// ========== بيانات الحالات ==========
const casesData = [
    { id: 1, patientName: 'أحمد محمد علي', caseType: 'حشوة تجميلية', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative', status: 'completed', ratings: 3, ratingDates: ['2024-01-15 10:00', '2024-01-15 10:30', '2024-01-15 11:00'], supervisor: 'د. أحمد النجار', addedDate: '2024-01-08', acceptedDate: '2024-01-10', requiresImages: true, requiresPanorama: true },
    { id: 2, patientName: 'سارة خالد حسن', caseType: 'خلع جراحي', course: 'تخدير و قلع الأسنان 4', courseId: 'exodontia', status: 'inProgress', ratings: 1, ratingDates: ['2024-01-14 14:20', null, null], supervisor: 'د. خالد محمود', addedDate: '2024-01-09', acceptedDate: '2024-01-12', requiresImages: true, requiresPanorama: false },
    { id: 3, patientName: 'محمد عمر النجار', caseType: 'تنظيف جيب', course: 'النسج حول سنية 2', courseId: 'periodontics', status: 'waitingEvaluation', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. سارة عبدالله', addedDate: '2024-01-10', acceptedDate: '2024-01-13', requiresImages: false, requiresPanorama: false },
    { id: 4, patientName: 'لينا أحمد محمود', caseType: 'علاج عصب', course: 'مداواة الأسنان اللبية 4', courseId: 'endodontics', status: 'rejected', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. لينا حسن', addedDate: '2024-01-11', acceptedDate: null, requiresImages: false, requiresPanorama: false },
    { id: 5, patientName: 'خالد سعيد رضوان', caseType: 'تاج دائم', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative', status: 'waitingAcceptance', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. أنس أحمد', addedDate: '2024-01-12', acceptedDate: null, requiresImages: false, requiresPanorama: false },
    { id: 6, patientName: 'فاطمة سالم', caseType: 'حشوة تجميلية', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative', status: 'transferred', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. أحمد النجار', addedDate: '2024-01-13', acceptedDate: null, requiresImages: false, requiresPanorama: false }
];

const imageTypes = [
    { key: 'diagnostic', label: 'أشعة تشخيصية (شعاعية)', icon: 'fa-x-ray', isPanorama: true },
    { key: 'cones', label: 'صورة تجربة أقمار', icon: 'fa-tooth', isPanorama: false },
    { key: 'final', label: 'صورة نهائية', icon: 'fa-check-circle', isPanorama: false },
    { key: 'followup', label: 'صورة متابعة', icon: 'fa-calendar-check', isPanorama: false }
];

// تهيئة البيانات - استديو منفصل لكل مقرر
let studioData = {
    restorative: { panorama: [], regular: [], deleted: [] },
    exodontia: { panorama: [], regular: [], deleted: [] },
    periodontics: { panorama: [], regular: [], deleted: [] },
    endodontics: { panorama: [], regular: [], deleted: [] }
};

// بيانات وهمية للصور الشعاعية لكل مقرر
const initialPanoramaData = {
    restorative: [
        { id: 'p1_rest', url: 'https://placehold.co/400x225/f59e0b/ffffff?text=شعاعية+ترميمية+1', date: '2024-01-10', status: 'available', usedBy: null, label: 'أشعة أولية' },
        { id: 'p2_rest', url: 'https://placehold.co/400x225/d97706/ffffff?text=شعاعية+ترميمية+2', date: '2024-01-15', status: 'available', usedBy: null, label: 'أشعة نهائية' }
    ],
    exodontia: [
        { id: 'p1_exo', url: 'https://placehold.co/400x225/f59e0b/ffffff?text=شعاعية+قلع+1', date: '2024-01-12', status: 'available', usedBy: null, label: 'بانوراما قبل القلع' }
    ],
    periodontics: [
        { id: 'p1_per', url: 'https://placehold.co/400x225/f59e0b/ffffff?text=شعاعية+نسجية+1', date: '2024-01-14', status: 'available', usedBy: null, label: 'أشعة تشخيصية' }
    ],
    endodontics: [
        { id: 'p1_end', url: 'https://placehold.co/400x225/f59e0b/ffffff?text=شعاعية+لبية+1', date: '2024-01-11', status: 'available', usedBy: null, label: 'أشعة قبل العلاج' },
        { id: 'p2_end', url: 'https://placehold.co/400x225/d97706/ffffff?text=شعاعية+لبية+2', date: '2024-01-16', status: 'available', usedBy: null, label: 'أشعة أثناء العلاج' }
    ]
};

const caseImages = {};
let currentStatusFilter = 'all';
let currentCourseFilter = 'all';
let currentPage = 1;
const casesPerPage = 5;
let currentOpenCaseId = null;
let currentImageSlot = null;
let currentStudioTab = 'regular';
let selectedStudioImageId = null;
let selectedStudioImageType = null;
let tempUploadFiles = [];
let longPressTimer = null;
const LONG_PRESS_DURATION = 600;
let currentSelectingIsPanorama = false;
let selectedImageUrl = null;
let selectedImageLabel = null;
let currentStudioCourse = null;
let activeTooltipElement = null;

// ========== LocalStorage Functions ==========
function loadFromLocalStorage() {
    try {
        const saved = localStorage.getItem('dentalStudioData_v2');
        if (saved) {
            const parsed = JSON.parse(saved);
            Object.keys(parsed).forEach(courseId => {
                if (studioData[courseId]) {
                    if (parsed[courseId].regular) studioData[courseId].regular = parsed[courseId].regular;
                    if (parsed[courseId].deleted) studioData[courseId].deleted = parsed[courseId].deleted;
                }
            });
            cleanDeletedImages();
        } else {
            Object.keys(initialPanoramaData).forEach(courseId => {
                studioData[courseId].panorama = [...initialPanoramaData[courseId]];
            });
        }
    } catch (e) {
        console.error('Error loading from localStorage:', e);
        Object.keys(initialPanoramaData).forEach(courseId => {
            studioData[courseId].panorama = [...initialPanoramaData[courseId]];
        });
    }
}

function saveToLocalStorage() {
    try {
        const dataToSave = {};
        Object.keys(studioData).forEach(courseId => {
            dataToSave[courseId] = {
                regular: studioData[courseId].regular,
                deleted: studioData[courseId].deleted,
                lastUpdated: new Date().toISOString()
            };
        });
        localStorage.setItem('dentalStudioData_v2', JSON.stringify(dataToSave));
    } catch (e) {
        console.error('Error saving to localStorage:', e);
    }
}

function cleanDeletedImages() {
    const now = new Date();
    Object.keys(studioData).forEach(courseId => {
        studioData[courseId].deleted = studioData[courseId].deleted.filter(img => {
            if (!img.deletedAt) return false;
            const deleteTime = new Date(img.deletedAt);
            const hoursPassed = (now - deleteTime) / (1000 * 60 * 60);
            return hoursPassed < 48;
        });
    });
}

// ========== Table Functions ==========
function getFilteredCases() {
    let filtered = [...casesData];
    
    if (currentStatusFilter !== 'all') {
        filtered = filtered.filter(c => c.status === currentStatusFilter);
    }
    
    if (currentCourseFilter !== 'all') {
        filtered = filtered.filter(c => c.courseId === currentCourseFilter);
    }
    
    const searchInput = document.getElementById('casesSearch');
    if (searchInput && searchInput.value.trim() !== '') {
        const term = searchInput.value.trim().toLowerCase();
        filtered = filtered.filter(c => 
            c.patientName.toLowerCase().includes(term) ||
            c.course.toLowerCase().includes(term) ||
            c.caseType.toLowerCase().includes(term)
        );
    }
    
    return filtered;
}

function showNoImageHint(event, status) {
    event.stopPropagation();
    let message = '';
    
    switch(status) {
        case 'waitingAcceptance':
            message = 'لا حاجة لرفع الصور: الحالة بانتظار قبول المشرف';
            break;
        case 'rejected':
            message = 'لا حاجة لرفع الصور: الحالة مرفوضة';
            break;
        case 'transferred':
            message = 'لا حاجة لرفع الصور: الحالة محولة لنوع آخر';
            break;
        case 'waitingEvaluation':
            message = 'يتم بدء رفع صور الحالة بعد أول تقييم';
            break;
        default:
            message = 'لا حاجة لرفع صور لهذه الحالة';
    }
    
    showUnifiedTooltip(event, message, event.currentTarget);
}

function loadCasesTable() {
    const tableBody = document.getElementById('casesTableBody');
    if (!tableBody) return;
    
    let filteredCases = getFilteredCases();
    const totalPages = Math.ceil(filteredCases.length / casesPerPage);
    const startIndex = (currentPage - 1) * casesPerPage;
    const endIndex = startIndex + casesPerPage;
    const paginatedCases = filteredCases.slice(startIndex, endIndex);
    
    tableBody.innerHTML = '';
    
    if (paginatedCases.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 40px 20px;"><div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;"><i class="fas fa-search" style="font-size: 24px; color: #9ca3af;"></i></div><div style="font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px;">لا توجد حالات</div></td></tr>`;
        updatePagination(totalPages, filteredCases.length);
        return;
    }
    
    paginatedCases.forEach((caseItem, index) => {
        const row = document.createElement('tr');
        row.style.animationDelay = (index * 0.05) + 's';
        
        let statusHtml = '';
        let statusText = '';
        let statusClass = '';
        let statusIcon = '';
        
        switch(caseItem.status) {
            case 'completed': 
                statusText = 'مكتمل'; 
                statusClass = 'completed';
                statusIcon = 'fa-check-circle';
                break;
            case 'inProgress': 
                statusText = 'قيد الإنجاز'; 
                statusClass = 'inProgress';
                statusIcon = 'fa-spinner';
                break;
            case 'waitingEvaluation': 
                statusText = 'بانتظار التقييم'; 
                statusClass = 'waitingEvaluation';
                statusIcon = 'fa-clock';
                break;
            case 'waitingAcceptance': 
                statusText = 'بانتظار القبول'; 
                statusClass = 'waitingAcceptance';
                statusIcon = 'fa-hourglass-start';
                break;
            case 'rejected': 
                statusText = 'مرفوض'; 
                statusClass = 'rejected';
                statusIcon = 'fa-times-circle';
                break;
            case 'transferred': 
                statusText = 'محولة'; 
                statusClass = 'transferred';
                statusIcon = 'fa-exchange-alt';
                break;
        }
        
        statusHtml = `<span class="status-badge ${statusClass}"><i class="fas ${statusIcon}" style="font-size: 10px; margin-left: 4px;"></i>${statusText}</span>`;
        
        let ratingsHtml = '';
        if (caseItem.status === 'waitingAcceptance') {
            ratingsHtml = '<span style="color: #9ca3af; font-size: 12px;">-</span>';
        } else if (caseItem.status === 'rejected' || caseItem.status === 'transferred') {
            const isTransferred = caseItem.status === 'transferred';
            const bg = isTransferred ? '#8b5cf6' : '#ef4444';
            const icon = isTransferred ? 'fa-exchange-alt' : 'fa-times';
            const text = isTransferred ? 'محولة' : 'مرفوض';
            const tooltipText = isTransferred ? 'تم تحويل الحالة إلى نوع آخر' : 'تم رفض الحالة من المشرف';
            
            ratingsHtml = `<div style="display: flex; justify-content: center; gap: 6px; direction: ltr;">
                <div class="rating-checkbox" 
                     style="background: ${bg}; color: white; width: 80px; border-radius: 12px; font-size: 11px;"
                     onclick="showUnifiedTooltip(event, '${tooltipText}', this)">
                    <i class="fas ${icon}"></i> ${text}
                </div>
            </div>`;
        } else {
            ratingsHtml = '<div style="display: flex; justify-content: center; gap: 6px; direction: ltr;">';
            for (let i = 1; i <= 3; i++) {
                let bg, icon, color, tooltipText;
                
                if (i <= caseItem.ratings) {
                    bg = '#10b981';
                    icon = 'fa-check';
                    color = 'white';
                    tooltipText = caseItem.ratingDates && caseItem.ratingDates[i-1] ? 
                        `تم التقييم: ${caseItem.ratingDates[i-1]}` : 'تم التقييم';
                } else {
                    bg = '#e5e7eb';
                    icon = '';
                    color = '#9ca3af';
                    tooltipText = 'لم يتم التقييم';
                }
                
                ratingsHtml += `
                    <div class="rating-checkbox" 
                         style="background: ${bg}; color: ${color};"
                         onclick="showUnifiedTooltip(event, '${tooltipText}', this)">
                        ${icon ? `<i class="fas ${icon}"></i>` : i}
                    </div>
                `;
            }
            ratingsHtml += '</div>';
        }
        
        let imagesHtml = '';
        if (caseItem.status === 'rejected' || caseItem.status === 'transferred' || caseItem.status === 'waitingAcceptance' || caseItem.status === 'waitingEvaluation') {
            imagesHtml = `<div class="images-icon not-required" onclick="showNoImageHint(event, '${caseItem.status}')">-</div>`;
        } else if (caseItem.requiresImages) {
            imagesHtml = `<div class="images-icon required" onclick="event.stopPropagation(); openCaseImagesModal(${caseItem.id});"><i class="fas fa-images"></i></div>`;
        } else {
            imagesHtml = `<div class="images-icon not-required" onclick="showNoImageHint(event, 'none')">-</div>`;
        }
        
        const addedDateHtml = caseItem.addedDate ? `<span style="direction: ltr; display: inline-block;">${caseItem.addedDate}</span>` : '<span style="color: #9ca3af;">-</span>';
        const acceptedDateHtml = caseItem.acceptedDate ? `<span style="direction: ltr; display: inline-block;">${caseItem.acceptedDate}</span>` : '<span style="color: #9ca3af;">-</span>';
        
        row.innerHTML = `
            <td style="padding: clamp(10px, 2.5vw, 14px);"><span style="font-weight: 700; color: #1f2937; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 150px;">${caseItem.patientName}</span></td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;"><span style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 6px 10px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap; display: inline-block; max-width: 120px; overflow: hidden; text-overflow: ellipsis;">${caseItem.caseType}</span></td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;"><span style="font-size: 13px; font-weight: 600; color: var(--dark); white-space: nowrap;">${caseItem.course}</span></td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${statusHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${ratingsHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${imagesHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;"><span style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 6px 10px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap;">${caseItem.supervisor}</span></td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-size: clamp(0.75rem, 2vw, 0.875rem); white-space: nowrap;">${addedDateHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-size: clamp(0.75rem, 2vw, 0.875rem); white-space: nowrap;">${acceptedDateHtml}</td>
        `;
        tableBody.appendChild(row);
    });
    
    updatePagination(totalPages, filteredCases.length);
}

function updatePagination(totalPages, totalItems) {
    const paginationDiv = document.getElementById('casesPagination');
    const prevBtn = document.getElementById('casesPrevBtn');
    const nextBtn = document.getElementById('casesNextBtn');
    const indicator = document.getElementById('casesPageIndicator');
    
    if (totalPages <= 1) {
        paginationDiv.style.display = 'none';
        return;
    } else {
        paginationDiv.style.display = 'flex';
    }
    
    indicator.textContent = `صفحة ${currentPage} من ${totalPages}`;
    
    if (currentPage === 1) {
        prevBtn.disabled = true;
        prevBtn.style.opacity = '0.5';
        prevBtn.style.cursor = 'not-allowed';
    } else {
        prevBtn.disabled = false;
        prevBtn.style.opacity = '1';
        prevBtn.style.cursor = 'pointer';
    }
    
    if (currentPage === totalPages) {
        nextBtn.disabled = true;
        nextBtn.style.opacity = '0.5';
        nextBtn.style.cursor = 'not-allowed';
    } else {
        nextBtn.disabled = false;
        nextBtn.style.opacity = '1';
        nextBtn.style.cursor = 'pointer';
    }
}

function changeCasesPage(direction) {
    if (direction === 'prev' && currentPage > 1) {
        currentPage--;
        loadCasesTable();
    } else if (direction === 'next') {
        const filtered = getFilteredCases();
        const totalPages = Math.ceil(filtered.length / casesPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            loadCasesTable();
        }
    }
}

function searchCases() {
    currentPage = 1;
    loadCasesTable();
}

// ========== Image Modal Functions ==========
function openCaseImagesModal(caseId) {
    currentOpenCaseId = caseId;
    const caseItem = casesData.find(c => c.id === caseId);
    if (!caseItem) return;
    
    currentStudioCourse = caseItem.courseId;
    
    document.getElementById('modalCaseName').textContent = `المريض: ${caseItem.patientName} | ${caseItem.caseType}`;
    document.getElementById('caseImagesModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    renderCaseImages();
}

function closeCaseImagesModal() {
    document.getElementById('caseImagesModal').style.display = 'none';
    document.body.style.overflow = '';
    currentOpenCaseId = null;
}

function renderCaseImages() {
    const grid = document.getElementById('caseImagesGrid');
    grid.innerHTML = '';
    
    if (!caseImages[currentOpenCaseId]) caseImages[currentOpenCaseId] = {};
    const caseItem = casesData.find(c => c.id === currentOpenCaseId);
    if (!caseItem) return;
    
    imageTypes.forEach((type) => {
        if (type.isPanorama && !caseItem.requiresPanorama) return;
        
        const existingImage = caseImages[currentOpenCaseId][type.key];
        const slot = document.createElement('div');
        
        if (existingImage) {
            slot.innerHTML = `
                <div style="position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <img src="${existingImage.url}" onerror="this.src='https://placehold.co/400x300/ef4444/ffffff?text=خطأ+في+الصورة'" onclick="openImageViewer('${existingImage.url}', '${existingImage.label}')" style="width: 100%; aspect-ratio: ${type.isPanorama ? '16/9' : '1'}; object-fit: cover; display: block; cursor: pointer;">
                    <div style="position: absolute; top: 8px; left: 8px; display: flex; gap: 8px;">
                        <button onclick="event.stopPropagation(); removeCaseImage('${type.key}')" style="background: #ef4444; color: white; border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 20px 8px 8px;">
                        <div style="color: white; font-size: 12px; font-weight: 600; text-align: center;">${type.label}</div>
                    </div>
                </div>
            `;
        } else {
            slot.innerHTML = `
                <div onclick="openStudioForSlot('${type.key}', ${type.isPanorama})" style="border: 2px dashed #d1d5db; border-radius: 16px; padding: 30px 15px; text-align: center; cursor: pointer; transition: all 0.2s; background: #f9fafb; aspect-ratio: ${type.isPanorama ? '16/9' : '1'}; display: flex; flex-direction: column; align-items: center; justify-content: center;" onmouseover="this.style.borderColor='var(--primary)'; this.style.background='rgba(99,102,241,0.03)'" onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f9fafb'">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; color: white; font-size: 20px;">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div style="color: var(--dark); font-weight: 600; font-size: 13px; margin-bottom: 4px;">اختر من الاستديو</div>
                    <div style="color: var(--gray); font-size: 11px;">${type.label}</div>
                </div>
            `;
        }
        grid.appendChild(slot);
    });
}

function openImageViewer(url, label) {
    document.getElementById('viewerImage').src = url;
    document.getElementById('viewerLabel').textContent = label || '';
    document.getElementById('imageViewerModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeImageViewer() {
    document.getElementById('imageViewerModal').style.display = 'none';
    document.getElementById('viewerImage').src = '';
    if (document.getElementById('caseImagesModal').style.display === 'none') {
        document.body.style.overflow = '';
    }
}

// ========== Studio Functions ==========
function openStudioForSlot(imageType, isPanorama) {
    currentImageSlot = imageType;
    currentSelectingIsPanorama = isPanorama;
    openStudioModal();
}

function openStudioModal() {
    if (!currentStudioCourse) {
        showToast('يجب تحديد المقرر أولاً', 'error');
        return;
    }
    
    const caseItem = casesData.find(c => c.id === currentOpenCaseId);
    const courseName = caseItem ? caseItem.course : 'المقرر الحالي';
    
    document.getElementById('studioCourseName').textContent = `استديو خاص بمقرر: ${courseName}`;
    document.getElementById('studioModal').style.display = 'block';
    
    if (currentSelectingIsPanorama) {
        switchStudioTab('panorama');
    } else {
        switchStudioTab('regular');
    }
    
    updateDeletedCount();
}

function closeStudioModal() {
    document.getElementById('studioModal').style.display = 'none';
    currentImageSlot = null;
    currentSelectingIsPanorama = false;
    selectedStudioImageId = null;
    selectedStudioImageType = null;
    selectedImageUrl = null;
    selectedImageLabel = null;
}

function switchStudioTab(tab) {
    currentStudioTab = tab;
    
    document.getElementById('studio-regular-section').style.display = 'none';
    document.getElementById('studio-panorama-section').style.display = 'none';
    document.getElementById('studio-deleted-section').style.display = 'none';
    
    document.getElementById('tab-regular').style.cssText = 'flex: 1; padding: 12px; background: transparent; border: none; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 13px;';
    document.getElementById('tab-panorama').style.cssText = 'flex: 1; padding: 12px; background: transparent; border: none; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 13px;';
    document.getElementById('tab-deleted').style.cssText = 'flex: 1; padding: 12px; background: transparent; border: none; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 13px; position: relative;';
    
    if (tab === 'regular') {
        document.getElementById('studio-regular-section').style.display = 'block';
        document.getElementById('tab-regular').style.cssText = 'flex: 1; padding: 12px; background: white; border: none; border-bottom: 2px solid var(--primary); color: var(--primary); font-weight: 700; cursor: pointer; font-family: inherit; font-size: 13px;';
        renderRegularImages();
    } else if (tab === 'panorama') {
        document.getElementById('studio-panorama-section').style.display = 'block';
        document.getElementById('tab-panorama').style.cssText = 'flex: 1; padding: 12px; background: white; border: none; border-bottom: 2px solid #f59e0b; color: #f59e0b; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 13px;';
        renderPanoramaImages();
    } else if (tab === 'deleted') {
        document.getElementById('studio-deleted-section').style.display = 'block';
        document.getElementById('tab-deleted').style.cssText = 'flex: 1; padding: 12px; background: white; border: none; border-bottom: 2px solid var(--primary); color: var(--primary); font-weight: 700; cursor: pointer; font-family: inherit; font-size: 13px; position: relative;';
        renderDeletedImages();
    }
}

function renderPanoramaImages() {
    const grid = document.getElementById('studioPanoramaGrid');
    grid.innerHTML = '';
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-x-ray" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>لا توجد صور شعاعية</div></div>';
        return;
    }
    
    const panoramaImages = studioData[currentStudioCourse].panorama;
    
    if (panoramaImages.length === 0) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-x-ray" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>لا توجد صور شعاعية</div></div>';
        return;
    }
    
    panoramaImages.forEach(img => {
        const div = document.createElement('div');
        div.className = `studio-image-item panorama ${img.status === 'in-use' ? 'in-use' : ''}`;
        
        if (img.status !== 'in-use') {
            div.onclick = function(e) {
                e.stopPropagation();
                handleImageSelect(img.id, 'panorama', img.url, img.label);
            };
        }
        
        div.innerHTML = `
            <img src="${img.url}" onerror="this.src='https://placehold.co/400x225/ef4444/ffffff?text=صورة+غير+متوفرة'" style="width: 100%; height: 100%; object-fit: cover;">
            ${img.label ? `<div class="image-label">${img.label}</div>` : ''}
        `;
        grid.appendChild(div);
    });
}

function groupImagesByDate(images) {
    const grouped = {};
    images.forEach(img => {
        if (!grouped[img.date]) grouped[img.date] = [];
        grouped[img.date].push(img);
    });
    return grouped;
}

function handleImageSelect(imageId, imageType, url, label) {
    if (currentSelectingIsPanorama && imageType !== 'panorama') {
        showToast('هذه الحالة تتطلب صورة شعاعية فقط', 'error');
        return;
    }
    if (!currentSelectingIsPanorama && imageType === 'panorama') {
        showToast('لا يمكن اختيار صورة شعاعية لهذا النوع', 'error');
        return;
    }
    
    selectedStudioImageId = imageId;
    selectedStudioImageType = imageType;
    selectedImageUrl = url;
    selectedImageLabel = label;
    
    document.getElementById('optionsImageLabel').textContent = label || 'صورة بدون تسمية';
    
    const deleteBtn = document.getElementById('deleteImageBtn');
    if (imageType === 'panorama') {
        deleteBtn.style.display = 'none';
    } else {
        deleteBtn.style.display = 'flex';
    }
    
    document.getElementById('imageOptionsModal').style.display = 'block';
}

function renderRegularImages() {
    const regularGrid = document.getElementById('studioRegularGrid');
    regularGrid.innerHTML = '';
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        regularGrid.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-images" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>لا توجد صور متاحة</div></div>';
        return;
    }
    
    const availableRegular = studioData[currentStudioCourse].regular.filter(img => img.status === 'available');
    const grouped = groupImagesByDate(availableRegular);
    const sortedDates = Object.keys(grouped).sort((a, b) => new Date(b) - new Date(a));
    
    if (sortedDates.length === 0) {
        regularGrid.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-images" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>لا توجد صور متاحة</div><div style="font-size: 12px; margin-top: 8px;">ارفع صوراً من الموبايل</div></div>';
    } else {
        sortedDates.forEach(date => {
            const dateGroup = document.createElement('div');
            const dateHeader = document.createElement('div');
            dateHeader.className = 'date-header';
            dateHeader.innerHTML = `<i class="fas fa-calendar-alt"></i>${formatDate(date)}`;
            dateGroup.appendChild(dateHeader);
            
            const grid = document.createElement('div');
            grid.style.cssText = 'display: grid; grid-template-columns: 1fr 1fr; gap: 12px;';
            
            grouped[date].forEach(img => {
                const div = document.createElement('div');
                div.className = 'studio-image-item';
                div.style.cursor = 'pointer';
                
                div.setAttribute('data-id', img.id);
                div.setAttribute('data-type', 'regular');
                div.setAttribute('data-url', img.url);
                div.setAttribute('data-label', img.label || '');
                
                div.onclick = function(e) {
                    e.stopPropagation();
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    const url = this.getAttribute('data-url');
                    const label = this.getAttribute('data-label');
                    handleImageSelect(id, type, url, label);
                };
                
                div.innerHTML = `
                    <img src="${img.url}" onerror="this.src='https://placehold.co/200x200/ef4444/ffffff?text=خطأ'" style="width: 100%; height: 100%; object-fit: cover;">
                    ${img.label ? `<div class="image-label">${img.label}</div>` : ''}
                `;
                grid.appendChild(div);
            });
            
            dateGroup.appendChild(grid);
            regularGrid.appendChild(dateGroup);
        });
    }
}

function closeImageOptions() {
    document.getElementById('imageOptionsModal').style.display = 'none';
}

function viewSelectedImage() {
    if (selectedImageUrl) {
        closeImageOptions();
        openImageViewer(selectedImageUrl, selectedImageLabel);
    }
}

function selectImageForCase() {
    if (!selectedStudioImageId || !selectedStudioImageType) {
        showToast('خطأ: لم يتم تحديد الصورة بشكل صحيح', 'error');
        return;
    }
    
    if (!currentOpenCaseId) {
        showToast('خطأ: لم يتم تحديد الحالة', 'error');
        return;
    }
    
    const caseItem = casesData.find(c => c.id === currentOpenCaseId);
    if (!caseItem) return;
    
    closeImageOptions();
    
    document.getElementById('confirmCaseType').textContent = caseItem.caseType;
    document.getElementById('confirmPatientName').textContent = caseItem.patientName;
    document.getElementById('selectConfirmModal').style.display = 'block';
}

function cancelSelectConfirm() {
    document.getElementById('selectConfirmModal').style.display = 'none';
    selectedStudioImageId = null;
    selectedStudioImageType = null;
    selectedImageUrl = null;
    selectedImageLabel = null;
}

function confirmSelectImage() {
    document.getElementById('selectConfirmModal').style.display = 'none';
    
    if (!selectedStudioImageId || !selectedStudioImageType) {
        showToast('خطأ: لم يتم تحديد الصورة', 'error');
        return;
    }
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        showToast('خطأ: لم يتم تحديد المقرر', 'error');
        return;
    }
    
    const imageArray = selectedStudioImageType === 'panorama' ? 
        studioData[currentStudioCourse].panorama : 
        studioData[currentStudioCourse].regular;
    
    const image = imageArray.find(img => img.id === selectedStudioImageId);
    
    if (!image) {
        showToast('الصورة غير موجودة في الاستديو', 'error');
        return;
    }
    
    if (image.status !== 'available') {
        showToast('هذه الصورة غير متاحة (قد تكون مستخدمة)', 'error');
        return;
    }
    
    image.status = 'in-use';
    image.usedBy = currentOpenCaseId;
    saveToLocalStorage();
    
    if (!caseImages[currentOpenCaseId]) caseImages[currentOpenCaseId] = {};
    
    const imageTypeObj = imageTypes.find(t => t.key === currentImageSlot);
    caseImages[currentOpenCaseId][currentImageSlot] = {
        url: image.url,
        label: image.label,
        typeLabel: imageTypeObj ? imageTypeObj.label : '',
        studioId: selectedStudioImageId,
        studioType: selectedStudioImageType
    };
    
    closeStudioModal();
    renderCaseImages();
    showToast('تمت إضافة الصورة بنجاح', 'success');
    
    selectedStudioImageId = null;
    selectedStudioImageType = null;
    selectedImageUrl = null;
    selectedImageLabel = null;
}

function moveToTrashFromOptions() {
    if (!selectedStudioImageId) {
        showToast('خطأ: لم يتم تحديد الصورة', 'error');
        return;
    }
    
    if (selectedStudioImageType === 'panorama') {
        showToast('لا يمكن حذف الصور الشعاعية', 'error');
        closeImageOptions();
        return;
    }
    
    closeImageOptions();
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) return;
    
    const index = studioData[currentStudioCourse].regular.findIndex(img => img.id === selectedStudioImageId);
    if (index === -1) {
        showToast('الصورة غير موجودة', 'error');
        return;
    }
    
    const image = studioData[currentStudioCourse].regular[index];
    
    if (image.status === 'in-use') {
        showToast('لا يمكن حذف صورة مستخدمة في حالة', 'error');
        return;
    }
    
    const deletedImage = {
        ...image,
        status: 'deleted',
        deletedAt: new Date().toISOString()
    };
    
    studioData[currentStudioCourse].deleted.push(deletedImage);
    studioData[currentStudioCourse].regular.splice(index, 1);
    saveToLocalStorage();
    
    renderRegularImages();
    updateDeletedCount();
    showToast('تم نقل الصورة لسلة المحذوفات', 'info');
    
    selectedStudioImageId = null;
    selectedStudioImageType = null;
    selectedImageUrl = null;
    selectedImageLabel = null;
}

function renderDeletedImages() {
    const grid = document.getElementById('deletedImagesGrid');
    grid.innerHTML = '';
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;">لا توجد صور محذوفة</div>';
        updateDeletedCount();
        return;
    }
    
    cleanDeletedImages();
    
    const deletedImages = studioData[currentStudioCourse].deleted;
    
    if (deletedImages.length === 0) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-trash-alt" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>سلة المحذوفات فارغة</div></div>';
        updateDeletedCount();
        return;
    }
    
    const now = new Date();
    deletedImages.forEach(img => {
        const deleteTime = new Date(img.deletedAt);
        const hoursLeft = Math.max(0, 48 - ((now - deleteTime) / (1000 * 60 * 60)));
        const hours = Math.floor(hoursLeft);
        const minutes = Math.floor((hoursLeft - hours) * 60);
        
        const div = document.createElement('div');
        div.className = 'deleted-item studio-image-item';
        div.style.cssText = 'border: 2px solid #fecaca;';
        div.innerHTML = `
            <img src="${img.url}" onerror="this.src='https://placehold.co/200x200/9ca3af/ffffff?text=محذوف'" style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(0.5);">
            ${img.label ? `<div class="image-label">${img.label}</div>` : ''}
            <div class="time-left">${hours}س ${minutes}د</div>
            <button class="restore-btn" onclick="restoreImage('${img.id}')">
                <i class="fas fa-undo" style="margin-left: 4px;"></i>استرداد
            </button>
        `;
        grid.appendChild(div);
    });
    
    updateDeletedCount();
}

function updateDeletedCount() {
    if (!currentStudioCourse || !studioData[currentStudioCourse]) return;
    
    const count = studioData[currentStudioCourse].deleted.length;
    const badge = document.getElementById('deletedCount');
    if (count > 0) {
        badge.textContent = count;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }
}

function restoreImage(imageId) {
    if (!currentStudioCourse || !studioData[currentStudioCourse]) return;
    
    const index = studioData[currentStudioCourse].deleted.findIndex(img => img.id === imageId);
    if (index > -1) {
        const image = studioData[currentStudioCourse].deleted[index];
        const restoredImage = {...image};
        delete restoredImage.deletedAt;
        restoredImage.status = 'available';
        studioData[currentStudioCourse].regular.push(restoredImage);
        studioData[currentStudioCourse].deleted.splice(index, 1);
        
        saveToLocalStorage();
        
        renderDeletedImages();
        renderRegularImages();
        updateDeletedCount();
        showToast('تم استرداد الصورة بنجاح', 'success');
    }
}

function removeCaseImage(imageType) {
    if (!currentOpenCaseId) {
        showToast('خطأ: لم يتم تحديد الحالة', 'error');
        return;
    }
    
    if (!caseImages[currentOpenCaseId] || !caseImages[currentOpenCaseId][imageType]) {
        showToast('الصورة غير موجودة في الحالة', 'error');
        return;
    }
    
    const image = caseImages[currentOpenCaseId][imageType];
    
    if (!image.studioId || !image.studioType) {
        showToast('خطأ: معلومات الصورة غير مكتملة', 'error');
        delete caseImages[currentOpenCaseId][imageType];
        renderCaseImages();
        return;
    }
    
    const caseItem = casesData.find(c => c.id === currentOpenCaseId);
    const courseId = caseItem ? caseItem.courseId : currentStudioCourse;
    
    if (courseId && studioData[courseId]) {
        let studioImg = null;
        if (image.studioType === 'panorama') {
            studioImg = studioData[courseId].panorama.find(img => img.id === image.studioId);
        } else {
            studioImg = studioData[courseId].regular.find(img => img.id === image.studioId);
        }
        
        if (studioImg) {
            studioImg.status = 'available';
            studioImg.usedBy = null;
        }
        
        saveToLocalStorage();
    }
    
    delete caseImages[currentOpenCaseId][imageType];
    renderCaseImages();
    showToast('تم إزالة الصورة وإرجاعها للاستديو', 'success');
}

// ========== Upload Functions ==========
function checkMobileUploadAllowed() {
    if (currentSelectingIsPanorama) {
        showToast('الصور الشعاعية يجب اختيارها من الاستديو فقط', 'error');
        return;
    }
    document.getElementById('mobileUploadInput').click();
}

function handleMobileUpload(event) {
    const files = Array.from(event.target.files);
    if (!files || files.length === 0) return;
    
    const allowedExtensions = ['jpg', 'jpeg', 'png', 'heic', 'heif'];
    const validFiles = [];
    
    files.forEach(file => {
        const ext = file.name.split('.').pop().toLowerCase();
        if (allowedExtensions.includes(ext)) {
            validFiles.push(file);
        } else {
            showToast(`صيغة ${ext} غير مدعومة`, 'error');
        }
    });
    
    if (validFiles.length === 0) return;
    
    tempUploadFiles = [];
    let processedCount = 0;
    
    const progressContainer = document.getElementById('uploadProgressContainer');
    const progressBar = document.getElementById('uploadProgressBar');
    const progressText = document.getElementById('uploadProgressText');
    
    progressContainer.style.display = 'block';
    
    validFiles.forEach((file) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            tempUploadFiles.push({
                file: file,
                url: e.target.result
            });
            
            processedCount++;
            const progress = Math.round((processedCount / validFiles.length) * 100);
            progressBar.style.width = progress + '%';
            progressText.textContent = progress + '%';
            
            if (processedCount === validFiles.length) {
                setTimeout(() => {
                    progressContainer.style.display = 'none';
                    progressBar.style.width = '0%';
                    showUploadLabelsModal();
                }, 500);
            }
        };
        reader.readAsDataURL(file);
    });
    
    event.target.value = '';
}

function showUploadLabelsModal() {
    const container = document.getElementById('uploadLabelsContainer');
    container.innerHTML = '';
    
    tempUploadFiles.forEach((item, index) => {
        const div = document.createElement('div');
        div.style.cssText = 'background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px;';
        div.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <img src="${item.url}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" onerror="this.style.display='none'">
                <div style="flex: 1; font-size: 12px; color: #6b7280; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${item.file.name}</div>
            </div>
            <input type="text" id="label-${index}" placeholder="وصف الصورة (اختياري)" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-family: inherit; font-size: 13px; box-sizing: border-box;">
        `;
        container.appendChild(div);
    });
    
    document.getElementById('uploadLabelsModal').style.display = 'block';
}

function saveUploadLabels() {
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        showToast('خطأ: لم يتم تحديد المقرر', 'error');
        return;
    }
    
    const today = new Date().toISOString().split('T')[0];
    let savedCount = 0;
    
    if (tempUploadFiles.length === 0) {
        document.getElementById('uploadLabelsModal').style.display = 'none';
        return;
    }
    
    tempUploadFiles.forEach((item, index) => {
        const labelInput = document.getElementById(`label-${index}`);
        const label = labelInput ? labelInput.value.trim() : '';
        
        const newId = 'img_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        const newImage = {
            id: newId,
            url: item.url,
            date: today,
            status: 'available',
            usedBy: null,
            label: label || 'صورة مرفوعة',
            isDataUrl: true
        };
        
        studioData[currentStudioCourse].regular.push(newImage);
        savedCount++;
        
        if (savedCount === tempUploadFiles.length) {
            saveToLocalStorage();
            document.getElementById('uploadLabelsModal').style.display = 'none';
            tempUploadFiles = [];
            renderRegularImages();
            showToast(`تم رفع ${savedCount} صورة بنجاح`, 'success');
        }
    });
}

// ========== Utility Functions ==========
function formatDate(dateStr) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateStr).toLocaleDateString('ar-SA', options);
}

function showToast(message, type = 'info') {
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `
        position: fixed;
        top: 100px;
        left: 50%;
        transform: translateX(-50%);
        padding: 16px 28px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        z-index: 100000;
        animation: slideDown 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        font-family: inherit;
        min-width: 250px;
        text-align: center;
    `;
    
    const colors = {
        success: 'linear-gradient(135deg, #10b981, #059669)',
        error: 'linear-gradient(135deg, #ef4444, #dc2626)',
        info: 'linear-gradient(135deg, var(--primary), var(--primary-light))',
        warning: 'linear-gradient(135deg, #f59e0b, #fbbf24)'
    };
    
    toast.style.background = colors[type] || colors.info;
    toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}" style="margin-left: 8px;"></i>${message}`;
    
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ========== Event Listeners ==========
document.addEventListener('DOMContentLoaded', function() {
    loadFromLocalStorage();
    loadCasesTable();
    
    const searchInput = document.getElementById('casesSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => { searchCases(); }, 300);
        });
    }
    
    // تنظيف الصور المحذوفة كل دقيقة
    setInterval(() => {
        let updated = false;
        Object.keys(studioData).forEach(courseId => {
            if (studioData[courseId].deleted.length > 0) {
                const beforeCount = studioData[courseId].deleted.length;
                cleanDeletedImages();
                if (studioData[courseId].deleted.length !== beforeCount) {
                    updated = true;
                }
            }
        });
        
        if (updated) {
            saveToLocalStorage();
            if (currentStudioTab === 'deleted') {
                renderDeletedImages();
            }
            updateDeletedCount();
        }
    }, 60000);
});

window.addEventListener('scroll', function() {
    if (activeTooltipElement && document.getElementById('unifiedTooltip').style.display !== 'none') {
        const tooltip = document.getElementById('unifiedTooltip');
        const rect = activeTooltipElement.getBoundingClientRect();
        tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
    }
}, true);

window.onclick = function(event ‌‍

