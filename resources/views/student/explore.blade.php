@extends('layouts.app')

@section('title', 'الأعمال')
@section('page_title', 'الأعمال')

@section('content')

<link rel="stylesheet" href="{{ asset('css/student/explore.css') }}">

<!-- الشريط العلوي الجديد (4 تبويبات) -->
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
            <table class="cases-table" style="min-width: 1200px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-user" style="margin-left: 6px; color: var(--primary);"></i>المريض</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-tag" style="margin-left: 6px; color: var(--primary);"></i>نوع الحالة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-tooth" style="margin-left: 6px; color: var(--primary);"></i>رقم السن</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-book" style="margin-left: 6px; color: var(--primary);"></i>المقرر</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-info-circle" style="margin-left: 6px; color: var(--primary);"></i>الحالة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-star" style="margin-left: 6px; color: var(--primary);"></i>التقييمات</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-images" style="margin-left: 6px; color: var(--primary);"></i>صور الحالة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;"><i class="fas fa-qrcode" style="margin-left: 6px; color: var(--primary);"></i>QR</th>
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
                <i class="fas fa-info-circle" style="color: #10b981; margin-left: 8px;"></i>
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

<!-- قسم حالة جديدة (التبويب الرابع) -->
<div id="new-case-section" class="tab-content-section" style="display: none;">
    @include('student.add-hala-explore')
</div>


<div id="manh-hala-section" class="tab-content-section" style="display: none;">
    @include('student.manh-tables')
</div>

<!-- ==================== المودالات ==================== -->

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
                <div id="uploadProgressContainer" style="display: none; margin-bottom: 16px; background: #f3f4f6; border-radius: 8px; padding: 12px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12px; color: var(--dark);">
                        <span>جاري رفع الصور...</span>
                        <span id="uploadProgressText">0%</span>
                    </div>
                    <div style="width: 100%; height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden;">
                        <div id="uploadProgressBar" style="width: 0%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--primary-light)); transition: width 0.3s ease;"></div>
                    </div>
                </div>

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

<!-- Modal خيارات الصورة -->
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
            <button onclick="closeImageOptions()" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; background: white; color: #6b7280; border-radius: 12px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 14px; margin-top: 6px;">
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

<!-- Modal تسمية الصور -->
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

<!-- Tooltip موحد -->
<div id="unifiedTooltip" style="display: none; position: fixed; background: var(--dark); color: white; padding: 10px 16px; border-radius: 10px; font-size: clamp(0.75rem, 2vw, 0.875rem); z-index: 100001; box-shadow: 0 4px 16px rgba(0,0,0,0.25); white-space: nowrap; font-weight: 600; pointer-events: none; max-width: 280px; text-align: center;">
    <div style="position: absolute; bottom: -8px; right: 50%; transform: translateX(50%); width: 0; height: 0; border-left: 8px solid transparent; border-right: 8px solid transparent; border-top: 8px solid var(--dark);"></div>
</div>

<!-- QR Code Modal -->
<div id="qrCodeModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); z-index: 6000; backdrop-filter: blur(4px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 20px; padding: 24px; width: 90%; max-width: 360px; box-shadow: 0 25px 70px rgba(0,0,0,0.3); text-align: center;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 16px; font-weight: 700; color: var(--dark); margin: 0;">
                <i class="fas fa-qrcode" style="color: var(--primary); margin-left: 6px;"></i>
                رمز QR للتقييم
            </h3>
            <button onclick="closeQrModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="qrCodeContainer" style="display: flex; justify-content: center; padding: 20px; background: #f9fafb; border-radius: 12px; margin-bottom: 16px;">
            <div id="qrCodeCanvas"></div>
        </div>
        <p id="qrCaseInfo" style="font-size: 13px; color: #6b7280; margin-bottom: 12px;"></p>
        <p style="font-size: 11px; color: #9ca3af;">يظهر QR فقط أثناء وقت جلسة المقرر. اعرض هذا الرمز للمشرف للتقييم.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script src="{{ asset('js/student/explore/ui.js') }}"></script>
<script src="{{ asset('js/student/explore/case-data.js') }}"></script>


<script>

// ========== التنقل بين الأقسام الرئيسية (الشريط العلوي الجديد) ==========
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

</script>


@endsection

