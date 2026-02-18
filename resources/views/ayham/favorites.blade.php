@extends('layouts.app')

@section('title', 'إدارة استثناءات البانوراما')
@section('page_title', 'استثناءات البانوراما')

@section('tabs')
<div class="tab-item active" onclick="switchTab('students')">
    <i class="fas fa-user-graduate" style="margin-left: 4px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
    الطلاب
</div>
<div class="tab-item" onclick="switchTab('exceptions')">
    <i class="fas fa-x-ray" style="margin-left: 4px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
    الاستثناءات
</div>
<div class="tab-item" onclick="switchTab('log')">
    <i class="fas fa-history" style="margin-left: 4px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
    السجل
</div>
@endsection

@section('tab_content')
<!-- تبويب الطلاب -->
<div class="tab-content" id="studentsContent" style="display: block;">
    <div class="section-title" style="margin-top: clamp(8px, 2vw, 12px); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
        <i class="fas fa-search" style="color: var(--primary); font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
        <span>البحث عن طالب</span>
    </div>

    <!-- البحث -->
    <div class="input-container" style="text-align: center; padding: clamp(16px, 4vw, 20px);">
        <div style="width: clamp(48px, 12vw, 64px); height: clamp(48px, 12vw, 64px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);">
            <i class="fas fa-id-card" style="font-size: clamp(20px, 5vw, 24px); color: white;"></i>
        </div>
        <h3 style="font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); color: var(--dark); margin-bottom: 6px; font-weight: 700;">إدخال الرقم الجامعي</h3>
        <p style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.875rem); margin-bottom: clamp(16px, 4vw, 20px);">تحقق من حالة استثناء الطالب</p>
        
        <div style="display: flex; gap: 8px; max-width: 320px; margin: 0 auto;">
            <input type="text" id="studentIdInput" placeholder="مثال: 20214587" style="flex: 1; padding: clamp(10px, 2.5vw, 12px); border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); text-align: center; font-weight: 600; letter-spacing: 1px;">
            <button onclick="checkStudentException()" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25); transition: all 0.2s; white-space: nowrap;">
                <i class="fas fa-search" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                بحث
            </button>
        </div>
    </div>

    <!-- نتيجة البحث -->
    <div id="studentResult" style="display: none;">
        <div class="section-title" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
            <i class="fas fa-user-check" style="color: var(--primary); font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
            <span>بيانات الطالب</span>
        </div>

        <div class="input-container" style="padding: clamp(12px, 3vw, 16px);">
            <div id="studentCard" style="background: #f8fafc; border-radius: 10px; padding: clamp(12px, 3vw, 16px); margin-bottom: clamp(12px, 3vw, 16px);">
                <div style="display: flex; align-items: center; gap: clamp(10px, 2.5vw, 12px); margin-bottom: clamp(12px, 3vw, 16px);">
                    <div style="width: clamp(40px, 10vw, 48px); height: clamp(40px, 10vw, 48px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(1rem, 3vw, 1.125rem); flex-shrink: 0;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div style="min-width: 0; flex: 1;">
                        <div id="resultStudentName" style="font-weight: 700; color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>
                        <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">الرقم: <span id="resultStudentId" style="color: var(--primary); font-weight: 600;">-</span></div>
                    </div>
                </div>
                
                <div style="background: white; padding: clamp(10px, 2.5vw, 12px); border-radius: 8px; text-align: center; border: 1px solid #e5e7eb;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">الفئة</div>
                    <div id="resultCategory" style="font-weight: 700; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">-</div>
                </div>
            </div>

            <!-- حالة الاستثناء -->
            <div id="exceptionStatusCard">
                <!-- سيتم ملؤها بالJavaScript -->
            </div>

            <!-- أزرار الإجراء -->
            <div id="actionButtons" style="display: flex; gap: 8px; margin-top: clamp(12px, 3vw, 16px);">
                <!-- سيتم ملؤها بالJavaScript -->
            </div>
        </div>
    </div>

    <!-- لا يوجد نتائج -->
    <div id="noStudentFound" style="display: none; text-align: center; padding: clamp(32px, 8vw, 40px) clamp(16px, 4vw, 20px);">
        <div style="width: clamp(64px, 16vw, 80px); height: clamp(64px, 16vw, 80px); background: var(--gray-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px);">
            <i class="fas fa-user-slash" style="font-size: clamp(24px, 6vw, 28px); color: var(--gray);"></i>
        </div>
        <h3 style="color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); margin-bottom: 6px; font-weight: 700;">لا يوجد طالب بهذا الرقم</h3>
        <p style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.875rem);">تأكد من صحة الرقم أو أنه ينتمي لفئتك</p>
    </div>
</div>

<!-- تبويب الاستثناءات النشطة -->
<div class="tab-content" id="exceptionsContent" style="display: none;">
    <div class="section-title" style="margin-top: clamp(8px, 2vw, 12px); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
        <i class="fas fa-list" style="color: var(--primary); font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
        <span>الاستثناءات</span>
    </div>

    <div class="input-container" style="padding: 0; overflow: hidden;">
        <div style="padding: clamp(12px, 3vw, 16px); background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(124, 58, 237, 0.04)); border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
            <h3 style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); color: var(--dark); margin: 0; font-weight: 700;">
                <i class="fas fa-clipboard-list" style="color: var(--primary); margin-left: 6px; font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
                قائمة الاستثناءات
            </h3>
            <div style="display: flex; gap: 6px;">
                <span id="pendingCountBadge" style="background: var(--warning); color: white; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;">0 قيد الانتظار</span>
                <span id="completedCountBadge" style="background: var(--secondary); color: white; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;">0 تم</span>
            </div>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="cases-table" style="min-width: 900px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-barcode" style="margin-left: 4px; color: var(--primary);"></i>
                            رمز الطلب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-user" style="margin-left: 4px; color: var(--primary);"></i>
                            الطالب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-hashtag" style="margin-left: 4px; color: var(--primary);"></i>
                            الجامعي
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-info-circle" style="margin-left: 4px; color: var(--primary);"></i>
                            الحالة
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-calendar-plus" style="margin-left: 4px; color: var(--primary);"></i>
                            تاريخ المنح
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-image" style="margin-left: 4px; color: var(--primary);"></i>
                            الصورة
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            إجراء
                        </th>
                    </tr>
                </thead>
                <tbody id="exceptionsTableBody">
                    <!-- سيتم ملؤها بالJavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- ترقيم الصفحات -->
        <div id="exceptionsPagination" style="display: flex; justify-content: center; align-items: center; gap: 12px; padding: clamp(16px, 4vw, 20px); border-top: 1px solid #e5e7eb; background: #f8fafc;">
            <button onclick="changeExceptionsPage('prev')" id="exceptionsPrevBtn" style="background: white; border: 2px solid #e5e7eb; color: #64748b; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                <i class="fas fa-chevron-right"></i>
                السابق
            </button>
            <span id="exceptionsPageIndicator" style="font-weight: 700; color: var(--primary); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">صفحة 1 من 1</span>
            <button onclick="changeExceptionsPage('next')" id="exceptionsNextBtn" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); font-size: clamp(0.75rem, 2vw, 0.875rem);">
                التالي
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
    </div>
</div>

<!-- تبويب السجل -->
<div class="tab-content" id="logContent" style="display: none;">
    <div class="section-title" style="margin-top: clamp(8px, 2vw, 12px); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
        <i class="fas fa-history" style="color: var(--primary); font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
        <span>سجل العمليات</span>
    </div>

    <div class="input-container" style="padding: 0; overflow: hidden;">
        <div style="padding: clamp(12px, 3vw, 16px); background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(124, 58, 237, 0.04)); border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); color: var(--dark); margin: 0; font-weight: 700;">
                <i class="fas fa-archive" style="color: var(--primary); margin-left: 6px; font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
                جميع العمليات والإلغاءات
            </h3>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="cases-table" style="min-width: 1000px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-barcode" style="margin-left: 4px; color: var(--primary);"></i>
                            رمز الطلب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الطالب</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الجامعي</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">العملية</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الحالة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">بواسطة</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">التاريخ</th>
                    </tr>
                </thead>
                <tbody id="logTableBody">
                    <!-- سيتم ملؤها بالJavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- ترقيم صفحات السجل -->
        <div id="logPagination" style="display: flex; justify-content: center; align-items: center; gap: 12px; padding: clamp(16px, 4vw, 20px); border-top: 1px solid #e5e7eb; background: #f8fafc;">
            <button onclick="changeLogPage('prev')" id="logPrevBtn" style="background: white; border: 2px solid #e5e7eb; color: #64748b; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                <i class="fas fa-chevron-right"></i>
                السابق
            </button>
            <span id="logPageIndicator" style="font-weight: 700; color: var(--primary); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">صفحة 1 من 1</span>
            <button onclick="changeLogPage('next')" id="logNextBtn" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); font-size: clamp(0.75rem, 2vw, 0.875rem);">
                التالي
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
@endsection

<!-- مودال منح الاستثناء -->
<div id="grantModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 99999; justify-content: center; align-items: center; padding: 12px;">
    <div style="background: white; border-radius: clamp(12px, 3vw, 16px); width: 100%; max-width: 380px; max-height: 85vh; overflow-y: auto; animation: modalPop 0.25s ease;">
        <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: clamp(20px, 5vw, 24px); text-align: center;">
            <div style="width: clamp(56px, 14vw, 64px); height: clamp(56px, 14vw, 64px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px);">
                <i class="fas fa-plus-circle" style="font-size: clamp(24px, 6vw, 28px); color: white;"></i>
            </div>
            <h3 style="color: white; font-size: clamp(1rem, 3vw, 1.125rem); font-weight: 700; margin: 0;">منح استثناء بانوراما</h3>
        </div>
        
        <div style="padding: clamp(20px, 5vw, 24px);">
            <div style="background: #f8fafc; border-radius: 10px; padding: clamp(12px, 3vw, 16px); margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1rem);">الطالب: <span id="grantStudentName">-</span></div>
                        <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">الرقم: <span id="grantStudentId" style="color: var(--primary); font-weight: 600;">-</span></div>
                    </div>
                </div>
                
                <div style="border-top: 1px solid #e5e7eb; padding-top: 12px;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">الفئة:</div>
                    <div id="grantCategory" style="font-weight: 700; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">-</div>
                </div>
            </div>

            <div style="background: rgba(245, 158, 11, 0.08); border: 1.5px solid rgba(245, 158, 11, 0.25); border-radius: 8px; padding: clamp(12px, 3vw, 14px); margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="display: flex; align-items: start; gap: 8px;">
                    <i class="fas fa-info-circle" style="color: var(--warning); font-size: 16px; margin-top: 2px;"></i>
                    <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem); line-height: 1.5;">
                        سيتم إنشاء رمز فريد للطلب يربط تلقائياً بصور المخبر
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button onclick="closeGrantModal()" style="flex: 1; background: var(--gray-light); color: var(--gray-dark); border: none; padding: clamp(12px, 3vw, 14px); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">
                    إلغاء
                </button>
                <button onclick="confirmGrantException()" style="flex: 1; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: clamp(12px, 3vw, 14px); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-check" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    تأكيد المنح
                </button>
            </div>
        </div>
    </div>
</div>

<!-- مودال الإلغاء -->
<div id="revokeModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 100000; justify-content: center; align-items: center; padding: 12px;">
    <div style="background: white; border-radius: clamp(12px, 3vw, 16px); width: 100%; max-width: 380px; max-height: 85vh; overflow-y: auto; animation: modalPop 0.25s ease;">
        <div style="background: linear-gradient(135deg, var(--danger), #dc2626); padding: clamp(20px, 5vw, 24px); text-align: center;">
            <div style="width: clamp(56px, 14vw, 64px); height: clamp(56px, 14vw, 64px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px);">
                <i class="fas fa-undo-alt" style="font-size: clamp(24px, 6vw, 28px); color: white;"></i>
            </div>
            <h3 style="color: white; font-size: clamp(1rem, 3vw, 1.125rem); font-weight: 700; margin: 0;">إلغاء الاستثناء</h3>
        </div>
        
        <div style="padding: clamp(20px, 5vw, 24px);">
            <div style="background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 10px; padding: clamp(12px, 3vw, 16px); margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <i class="fas fa-exclamation-triangle" style="color: var(--danger); font-size: 18px;"></i>
                    <div style="font-weight: 700; color: var(--danger); font-size: clamp(0.875rem, 2.5vw, 1rem);">تنبيه!</div>
                </div>
                <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem); line-height: 1.5;">
                    سيتم إلغاء استثناء البانوراما لهذا الطالب. لن يتمكن من العمل بدون صورة بانوراما.
                </div>
            </div>

            <div style="background: #f8fafc; border-radius: 10px; padding: clamp(12px, 3vw, 16px); margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="margin-bottom: 8px;">
                    <span style="color: var(--gray); font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">الطالب: </span>
                    <span id="revokeStudentName" style="font-weight: 700; color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1rem);">-</span>
                </div>
                <div>
                    <span style="color: var(--gray); font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">الرقم الجامعي: </span>
                    <span id="revokeStudentId" style="font-weight: 700; color: var(--primary); font-size: clamp(0.9375rem, 2.8vw, 1rem);">-</span>
                </div>
            </div>

            <div style="margin-bottom: clamp(16px, 4vw, 20px);">
                <label style="display: block; font-weight: 700; color: var(--dark); margin-bottom: 8px; font-size: clamp(0.875rem, 2.5vw, 1rem);">
                    <i class="fas fa-comment-alt" style="color: var(--danger); margin-left: 6px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    سبب الإلغاء <span style="color: var(--danger);">*</span>
                </label>
                <textarea id="revokeReason" rows="3" placeholder="اكتب سبب إلغاء الاستثناء..." style="width: 100%; padding: clamp(10px, 2.5vw, 12px); border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); resize: vertical; min-height: 80px;"></textarea>
                <div style="margin-top: 6px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray);">
                    <i class="fas fa-info-circle" style="margin-left: 4px; font-size: clamp(0.625rem, 1.6vw, 0.75rem);"></i>
                    سيتم تسجيل هذا السبب في السجل مع التاريخ والوقت
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button onclick="closeRevokeModal()" style="flex: 1; background: var(--gray-light); color: var(--gray-dark); border: none; padding: clamp(12px, 3vw, 14px); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">
                    تراجع
                </button>
                <button onclick="confirmRevokeException()" style="flex: 1; background: linear-gradient(135deg, var(--danger), #dc2626); color: white; border: none; padding: clamp(12px, 3vw, 14px); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-trash-alt" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    تأكيد الإلغاء
                </button>
            </div>
        </div>
    </div>
</div>

<!-- مودال عرض تفاصيل الطلب (مع الربط بالصور) -->
<div id="requestCodeModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 100001; justify-content: center; align-items: center; padding: 12px;">
    <div style="background: white; border-radius: clamp(12px, 3vw, 16px); width: 100%; max-width: 420px; max-height: 85vh; overflow-y: auto; animation: modalPop 0.25s ease;">
        <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: clamp(20px, 5vw, 24px); text-align: center; position: relative;">
            <button onclick="closeRequestCodeModal()" style="position: absolute; top: clamp(12px, 3vw, 16px); left: clamp(12px, 3vw, 16px); background: rgba(255,255,255,0.2); border: none; width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); border-radius: 50%; color: white; cursor: pointer; font-size: clamp(14px, 3.5vw, 16px); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
            <div style="width: clamp(56px, 14vw, 64px); height: clamp(56px, 14vw, 64px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px);">
                <i class="fas fa-barcode" style="font-size: clamp(24px, 6vw, 28px); color: white;"></i>
            </div>
            <h3 style="color: white; font-size: clamp(1rem, 3vw, 1.125rem); font-weight: 700; margin: 0;">رمز الطلب</h3>
        </div>
        
        <div style="padding: clamp(20px, 5vw, 24px);">
            <div id="requestCodeContent" style="display: flex; flex-direction: column; gap: clamp(12px, 3vw, 16px);">
                <!-- سيتم ملؤها بالJavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Toast صغير -->
<div id="smallToast" style="display: none; position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 100002; animation: toastSlide 0.2s ease;">
    <div id="smallToastContent" style="padding: 10px 20px; border-radius: 20px; font-weight: 600; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 8px; white-space: nowrap;">
        <!-- سيتم ملؤها بالJavaScript -->
    </div>
</div>

<script>
// بيانات المشرف الحالي
const currentSupervisor = {
    name: 'د. أحمد النجار',
    category: 'الفئة الثالثة'
};

// بيانات الطلاب
const studentsData = {
    '20214587': { name: 'محمد أحمد', category: 'الفئة الثالثة' },
    '20216732': { name: 'سارة خالد يوسف', category: 'الفئة الثالثة' },
    '20219854': { name: 'عمر محمود', category: 'الفئة الثالثة' },
    '20210001': { name: 'أحمد محمد علي', category: 'الفئة الأولى' },
    '20220015': { name: 'عمر محمود', category: 'الفئة الثانية' }
};

// دالة توليد رمز فريد للطلب
function generateRequestCode() {
    const timestamp = Date.now().toString(36).toUpperCase();
    const random = Math.random().toString(36).substring(2, 5).toUpperCase();
    return `PANO-${timestamp}${random}`;
}

// الاستثناءات - كل استثناء لحالة واحدة مع رمز فريد
let activeExceptions = [
    {
        id: 1,
        requestCode: 'PANO-LX9K2P4M',
        studentId: '20214587',
        studentName: 'محمد أحمد',
        category: 'الفئة الثالثة',
        status: 'pending',
        grantedAt: '2024-01-15 09:30:45',
        grantedBy: 'د. أحمد النجار',
        completedAt: null,
        imageLinked: false,
        revokedAt: null,
        revokeReason: null,
        revokedBy: null
    },
    {
        id: 2,
        requestCode: 'PANO-MN3Q7R8T',
        studentId: '20216732',
        studentName: 'سارة خالد يوسف',
        category: 'الفئة الثالثة',
        status: 'completed',
        grantedAt: '2024-01-14 14:20:15',
        grantedBy: 'د. أحمد النجار',
        completedAt: '2024-01-14 16:45:30',
        imageLinked: true,
        revokedAt: null,
        revokeReason: null,
        revokedBy: null
    },
    {
        id: 3,
        requestCode: 'PANO-XY5V9W2A',
        studentId: '20219854',
        studentName: 'عمر محمود',
        category: 'الفئة الثالثة',
        status: 'revoked',
        grantedAt: '2024-01-13 11:15:00',
        grantedBy: 'د. أحمد النجار',
        completedAt: null,
        imageLinked: false,
        revokedAt: '2024-01-13 13:40:22',
        revokeReason: 'عدم الحاجة للاستثناء بعد مراجعة الحالة',
        revokedBy: 'د. أحمد النجار'
    },
    {
        id: 4,
        requestCode: 'PANO-AB12CD34',
        studentId: '20214587',
        studentName: 'محمد أحمد',
        category: 'الفئة الثالثة',
        status: 'pending',
        grantedAt: '2024-01-16 10:00:00',
        grantedBy: 'د. أحمد النجار',
        completedAt: null,
        imageLinked: false,
        revokedAt: null,
        revokeReason: null,
        revokedBy: null
    },
    {
        id: 5,
        requestCode: 'PANO-EF56GH78',
        studentId: '20216732',
        studentName: 'سارة خالد يوسف',
        category: 'الفئة الثالثة',
        status: 'completed',
        grantedAt: '2024-01-12 09:00:00',
        grantedBy: 'د. أحمد النجار',
        completedAt: '2024-01-12 11:30:00',
        imageLinked: true,
        revokedAt: null,
        revokeReason: null,
        revokedBy: null
    },
    {
        id: 6,
        requestCode: 'PANO-IJ90KL12',
        studentId: '20219854',
        studentName: 'عمر محمود',
        category: 'الفئة الثالثة',
        status: 'pending',
        grantedAt: '2024-01-17 08:30:00',
        grantedBy: 'د. أحمد النجار',
        completedAt: null,
        imageLinked: false,
        revokedAt: null,
        revokeReason: null,
        revokedBy: null
    },
    {
        id: 7,
        requestCode: 'PANO-MN34OP56',
        studentId: '20214587',
        studentName: 'محمد أحمد',
        category: 'الفئة الثالثة',
        status: 'completed',
        grantedAt: '2024-01-11 14:00:00',
        grantedBy: 'د. أحمد النجار',
        completedAt: '2024-01-11 16:15:00',
        imageLinked: true,
        revokedAt: null,
        revokeReason: null,
        revokedBy: null
    },
    {
        id: 8,
        requestCode: 'PANO-QR78ST90',
        studentId: '20216732',
        studentName: 'سارة خالد يوسف',
        category: 'الفئة الثالثة',
        status: 'pending',
        grantedAt: '2024-01-18 11:20:00',
        grantedBy: 'د. أحمد النجار',
        completedAt: null,
        imageLinked: false,
        revokedAt: null,
        revokeReason: null,
        revokedBy: null
    }
];

// سجل العمليات
let operationsLog = [
    {
        id: 1,
        requestCode: 'PANO-LX9K2P4M',
        operation: 'منح استثناء',
        studentId: '20214587',
        studentName: 'محمد أحمد',
        status: 'pending',
        performedBy: 'د. أحمد النجار',
        date: '2024-01-15 09:30:45',
        details: 'منح استثناء بانوراما'
    },
    {
        id: 2,
        requestCode: 'PANO-MN3Q7R8T',
        operation: 'إكمال تصوير',
        studentId: '20216732',
        studentName: 'سارة خالد يوسف',
        status: 'completed',
        performedBy: 'مكتب الأشعة',
        date: '2024-01-14 16:45:30',
        details: 'تم تصوير البانوراما وربطها بالرمز'
    },
    {
        id: 3,
        requestCode: 'PANO-XY5V9W2A',
        operation: 'إلغاء استثناء',
        studentId: '20219854',
        studentName: 'عمر محمود',
        status: 'revoked',
        performedBy: 'د. أحمد النجار',
        date: '2024-01-13 13:40:22',
        details: 'سبب الإلغاء: عدم الحاجة للاستثناء بعد مراجعة الحالة'
    }
];

let currentStudentId = null;
let currentExceptionId = null;

// إعدادات الترقيم - 7 صفوف لكل صفحة
const ITEMS_PER_PAGE = 7;
let exceptionsCurrentPage = 1;
let logCurrentPage = 1;

// ========== دوال البحث ==========
function checkStudentException() {
    const studentId = document.getElementById('studentIdInput').value.trim();
    
    if (!studentId) {
        showSmallToast('أدخل الرقم الجامعي', 'warning');
        return;
    }
    
    const student = studentsData[studentId];
    
    if (!student) {
        document.getElementById('studentResult').style.display = 'none';
        document.getElementById('noStudentFound').style.display = 'block';
        return;
    }
    
    if (student.category !== currentSupervisor.category) {
        document.getElementById('studentResult').style.display = 'none';
        document.getElementById('noStudentFound').style.display = 'block';
        showSmallToast('الطالب لا ينتمي لفئتك', 'error');
        return;
    }
    
    currentStudentId = studentId;
    
    document.getElementById('resultStudentName').textContent = student.name;
    document.getElementById('resultStudentId').textContent = studentId;
    document.getElementById('resultCategory').textContent = student.category;
    
    const existingException = activeExceptions.find(ex => 
        ex.studentId === studentId && ex.status === 'pending'
    );
    
    const statusCard = document.getElementById('exceptionStatusCard');
    const actionButtons = document.getElementById('actionButtons');
    
    if (existingException) {
        statusCard.innerHTML = `
            <div style="background: rgba(245, 158, 11, 0.08); border: 1.5px solid rgba(245, 158, 11, 0.25); border-radius: 10px; padding: clamp(12px, 3vw, 16px);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <div style="width: 40px; height: 40px; background: var(--warning); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--warning); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem);">يوجد استثناء قيد الانتظار</div>
                        <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">بانتظار التصوير</div>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.05)); padding: 10px; border-radius: 8px; text-align: center; border: 1.5px dashed var(--primary); cursor: pointer;" onclick="showRequestCodeModal(${existingException.id})">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">
                        <i class="fas fa-barcode" style="margin-left: 4px; color: var(--primary);"></i>
                        رمز الطلب (انقر للعرض)
                    </div>
                    <div style="font-weight: 800; color: var(--primary); font-size: clamp(1.125rem, 3vw, 1.25rem); letter-spacing: 1px; font-family: monospace;">${existingException.requestCode}</div>
                </div>
            </div>
        `;
        
        actionButtons.innerHTML = `
            <button onclick="openRevokeModal(${existingException.id})" style="flex: 1; background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1.5px solid rgba(239, 68, 68, 0.3); padding: clamp(10px, 2.5vw, 12px); border-radius: 8px; font-weight: 600; cursor: pointer; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s;">
                <i class="fas fa-undo-alt" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                إلغاء الاستثناء
            </button>
        `;
    } else {
        const completedException = activeExceptions.find(ex => 
            ex.studentId === studentId && ex.status === 'completed'
        );
        
        if (completedException) {
            statusCard.innerHTML = `
                <div style="background: rgba(16, 185, 129, 0.08); border: 1.5px solid rgba(16, 185, 129, 0.25); border-radius: 10px; padding: clamp(12px, 3vw, 16px);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <div style="width: 40px; height: 40px; background: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--secondary); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem);">آخر استثناء منتهي</div>
                            <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">تم التصوير بنجاح</div>
                        </div>
                    </div>
                    
                    <div style="background: white; padding: 10px; border-radius: 8px; text-align: center; cursor: pointer; margin-bottom: 8px;" onclick="showRequestCodeModal(${completedException.id})">
                        <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">
                            <i class="fas fa-barcode" style="margin-left: 4px; color: var(--secondary);"></i>
                            رمز الطلب
                        </div>
                        <div style="font-weight: 800; color: var(--secondary); font-size: clamp(1rem, 3vw, 1.125rem); letter-spacing: 1px; font-family: monospace;">${completedException.requestCode}</div>
                    </div>
                </div>
            `;
        } else {
            statusCard.innerHTML = `
                <div style="background: rgba(156, 163, 175, 0.08); border: 1.5px solid rgba(156, 163, 175, 0.25); border-radius: 10px; padding: clamp(12px, 3vw, 16px); text-align: center;">
                    <div style="width: 48px; height: 48px; background: var(--gray-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                        <i class="fas fa-ban" style="font-size: 20px; color: var(--gray);"></i>
                    </div>
                    <div style="font-weight: 700; color: var(--gray); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); margin-bottom: 6px;">لا يوجد استثناء نشط</div>
                    <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">الطالب بحاجة لصورة بانوراما</div>
                </div>
            `;
        }
        
        actionButtons.innerHTML = `
            <button onclick="openGrantModal()" style="flex: 1; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: clamp(10px, 2.5vw, 12px); border-radius: 8px; font-weight: 600; cursor: pointer; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25); transition: all 0.2s;">
                <i class="fas fa-plus-circle" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                منح استثناء
            </button>
        `;
    }
    
    document.getElementById('noStudentFound').style.display = 'none';
    document.getElementById('studentResult').style.display = 'block';
    
    showSmallToast('تم العثور على الطالب', 'success');
}

// ========== دوال منح الاستثناء ==========
function openGrantModal() {
    const student = studentsData[currentStudentId];
    if (!student) return;
    
    document.getElementById('grantStudentName').textContent = student.name;
    document.getElementById('grantStudentId').textContent = currentStudentId;
    document.getElementById('grantCategory').textContent = student.category;
    
    document.getElementById('grantModal').style.display = 'flex';
}

function closeGrantModal() {
    document.getElementById('grantModal').style.display = 'none';
}

function confirmGrantException() {
    const student = studentsData[currentStudentId];
    if (!student) return;
    
    const now = new Date();
    const dateStr = now.toLocaleString('ar-SA');
    const requestCode = generateRequestCode();
    
    const newException = {
        id: activeExceptions.length + 1,
        requestCode: requestCode,
        studentId: currentStudentId,
        studentName: student.name,
        category: student.category,
        status: 'pending',
        grantedAt: dateStr,
        grantedBy: currentSupervisor.name,
        completedAt: null,
        imageLinked: false,
        revokedAt: null,
        revokeReason: null,
        revokedBy: null
    };
    
    activeExceptions.unshift(newException);
    
    addToLog({
        requestCode: requestCode,
        operation: 'منح استثناء',
        studentId: currentStudentId,
        studentName: student.name,
        status: 'pending',
        performedBy: currentSupervisor.name,
        date: dateStr,
        details: 'منح استثناء بانوراما جديد برمز: ' + requestCode
    });
    
    loadExceptionsTable();
    checkStudentException();
    
    showSmallToast('تم منح الاستثناء - الرمز: ' + requestCode, 'success');
    closeGrantModal();
}

// ========== دوال إلغاء الاستثناء ==========
function openRevokeModal(exceptionId) {
    const exception = activeExceptions.find(ex => ex.id === exceptionId);
    if (!exception) return;
    
    currentExceptionId = exceptionId;
    
    document.getElementById('revokeStudentName').textContent = exception.studentName;
    document.getElementById('revokeStudentId').textContent = exception.studentId;
    document.getElementById('revokeReason').value = '';
    
    document.getElementById('revokeModal').style.display = 'flex';
}

function closeRevokeModal() {
    document.getElementById('revokeModal').style.display = 'none';
    currentExceptionId = null;
}

function confirmRevokeException() {
    const reason = document.getElementById('revokeReason').value.trim();
    
    if (!reason) {
        showSmallToast('اكتب سبب الإلغاء', 'warning');
        return;
    }
    
    const exceptionIndex = activeExceptions.findIndex(ex => ex.id === currentExceptionId);
    if (exceptionIndex === -1) return;
    
    const now = new Date();
    const dateStr = now.toLocaleString('ar-SA');
    
    const exception = activeExceptions[exceptionIndex];
    
    activeExceptions[exceptionIndex].status = 'revoked';
    activeExceptions[exceptionIndex].revokedAt = dateStr;
    activeExceptions[exceptionIndex].revokeReason = reason;
    activeExceptions[exceptionIndex].revokedBy = currentSupervisor.name;
    
    addToLog({
        requestCode: exception.requestCode,
        operation: 'إلغاء استثناء',
        studentId: exception.studentId,
        studentName: exception.studentName,
        status: 'revoked',
        performedBy: currentSupervisor.name,
        date: dateStr,
        details: `سبب الإلغاء: ${reason}`
    });
    
    loadExceptionsTable();
    loadLogTable();
    checkStudentException();
    
    showSmallToast('تم الإلغاء بتاريخ: ' + dateStr, 'success');
    closeRevokeModal();
}

// ========== دوال عرض رمز الطلب ==========
function showRequestCodeModal(exceptionId) {
    const exception = activeExceptions.find(ex => ex.id === exceptionId);
    if (!exception) return;
    
    const content = document.getElementById('requestCodeContent');
    
    let imageSection = '';
    if (exception.status === 'completed' && exception.imageLinked) {
        imageSection = `
            <div style="background: rgba(16, 185, 129, 0.08); border: 2px solid rgba(16, 185, 129, 0.3); border-radius: 12px; padding: clamp(16px, 4vw, 20px);">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div style="width: 48px; height: 48px; background: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                        <i class="fas fa-image"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--secondary); font-size: clamp(1rem, 3vw, 1.125rem);">تم ربط الصورة</div>
                        <div style="color: var(--gray); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">تم استلام الصورة من المخبر</div>
                    </div>
                </div>
                <div style="background: white; padding: 12px; border-radius: 8px; text-align: center;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">تاريخ استلام الصورة:</div>
                    <div style="font-weight: 700; color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem);">${exception.completedAt}</div>
                </div>
            </div>
        `;
    } else if (exception.status === 'pending') {
        imageSection = `
            <div style="background: rgba(245, 158, 11, 0.08); border: 2px solid rgba(245, 158, 11, 0.3); border-radius: 12px; padding: clamp(16px, 4vw, 20px);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 48px; height: 48px; background: var(--warning); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--warning); font-size: clamp(1rem, 3vw, 1.125rem);">بانتظار الصورة</div>
                        <div style="color: var(--gray); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">لم يتم استلام الصورة من المخبر بعد</div>
                    </div>
                </div>
            </div>
        `;
    }
    
    content.innerHTML = `
        <div style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.05)); border: 2px dashed var(--primary); border-radius: 12px; padding: clamp(20px, 5vw, 24px); text-align: center;">
            <div style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); color: var(--gray); margin-bottom: 8px;">
                <i class="fas fa-barcode" style="margin-left: 6px; color: var(--primary);"></i>
                رمز الطلب الفريد
            </div>
            <div style="font-weight: 800; color: var(--primary); font-size: clamp(1.5rem, 4vw, 2rem); letter-spacing: 2px; font-family: monospace; margin-bottom: 12px;" id="codeDisplay">${exception.requestCode}</div>
            <button onclick="copyRequestCode('${exception.requestCode}')" style="background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                <i class="fas fa-copy"></i>
                نسخ الرمز
            </button>
        </div>
        
        <div style="background: #f8fafc; border-radius: 12px; padding: clamp(16px, 4vw, 20px);">
            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 6px;">الطالب</div>
            <div style="font-weight: 700; color: var(--dark); font-size: clamp(1rem, 3vw, 1.125rem); margin-bottom: 12px;">${exception.studentName}</div>
            
            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 6px;">الرقم الجامعي</div>
            <div style="font-weight: 700; color: var(--primary); font-size: clamp(1.125rem, 3.5vw, 1.5rem);">${exception.studentId}</div>
        </div>
        
        ${imageSection}
        
        <div style="background: rgba(79, 70, 229, 0.05); border-radius: 10px; padding: clamp(12px, 3vw, 16px);">
            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 8px; text-align: center;">
                <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                كيفية الاستخدام في المخبر
            </div>
            <div style="color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); line-height: 1.6; text-align: center;">
                عند تصوير البانوراما، يقوم فني الأشعة بإدخال هذا الرمز في النظام لربط الصورة تلقائياً بهذا الطلب
            </div>
        </div>
    `;
    
    document.getElementById('requestCodeModal').style.display = 'flex';
}

function closeRequestCodeModal() {
    document.getElementById('requestCodeModal').style.display = 'none';
}

function copyRequestCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        showSmallToast('تم نسخ الرمز: ' + code, 'success');
    }).catch(() => {
        showSmallToast('تم نسخ الرمز', 'success');
    });
}

// ========== دوال الجداول مع الترقيم ==========
function loadExceptionsTable() {
    const tbody = document.getElementById('exceptionsTableBody');
    tbody.innerHTML = '';
    
    const categoryExceptions = activeExceptions.filter(ex => 
        ex.category === currentSupervisor.category
    );
    
    // الترقيم - 7 صفوف لكل صفحة
    const start = (exceptionsCurrentPage - 1) * ITEMS_PER_PAGE;
    const end = start + ITEMS_PER_PAGE;
    const pageRecords = categoryExceptions.slice(start, end);
    
    pageRecords.forEach((ex, index) => {
        const row = document.createElement('tr');
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.25s ease forwards; animation-delay: ' + (index * 0.04) + 's; opacity: 0;';
        
        let statusHtml = '';
        let actionHtml = '';
        let imageHtml = '';
        
        if (ex.status === 'pending') {
            statusHtml = `<span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;"><i class="fas fa-clock" style="margin-left: 4px; font-size: clamp(0.625rem, 1.6vw, 0.75rem);"></i>قيد الانتظار</span>`;
            actionHtml = `
                <button onclick="openRevokeModal(${ex.id})" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); display: flex; align-items: center; gap: 4px; margin: 0 auto; transition: all 0.2s;">
                    <i class="fas fa-undo-alt" style="font-size: clamp(0.625rem, 1.6vw, 0.75rem);"></i>
                    إلغاء
                </button>
            `;
            imageHtml = `<span style="color: var(--gray); font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">-</span>`;
        } else if (ex.status === 'completed') {
            statusHtml = `<span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;"><i class="fas fa-check-circle" style="margin-left: 4px; font-size: clamp(0.625rem, 1.6vw, 0.75rem);"></i>تم</span>`;
            actionHtml = `<span style="color: var(--gray); font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">-</span>`;
            imageHtml = ex.imageLinked ? 
                `<span style="color: var(--secondary); font-weight: 700; font-size: clamp(0.6875rem, 1.8vw, 0.75rem);"><i class="fas fa-image" style="margin-left: 4px;"></i>مرفقة</span>` :
                `<span style="color: var(--gray); font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">-</span>`;
        } else if (ex.status === 'revoked') {
            statusHtml = `<span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;"><i class="fas fa-times-circle" style="margin-left: 4px; font-size: clamp(0.625rem, 1.6vw, 0.75rem);"></i>ملغى</span>`;
            actionHtml = `<span style="color: var(--gray); font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">-</span>`;
            imageHtml = `<span style="color: var(--gray); font-size: clamp(0.6875rem, 1.8vw, 0.75rem);">-</span>`;
        }
        
        row.innerHTML = `
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <div style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.05)); border: 1.5px dashed var(--primary); border-radius: 8px; padding: 8px; cursor: pointer;" onclick="showRequestCodeModal(${ex.id})">
                    <div style="font-weight: 800; color: var(--primary); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); letter-spacing: 1px; font-family: monospace;">${ex.requestCode}</div>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: clamp(36px, 9vw, 42px); height: clamp(36px, 9vw, 42px); background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(13px, 3.3vw, 15px); flex-shrink: 0;">${ex.studentName.charAt(0)}</div>
                    <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 90px;">${ex.studentName}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-weight: 600; font-size: clamp(0.75rem, 2vw, 0.8125rem); white-space: nowrap;">${ex.studentId}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${statusHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.75rem, 2vw, 0.8125rem);">
                <span style="color: var(--primary); font-weight: 600; cursor: pointer;" onclick="showExceptionDates(${ex.id})">
                    <i class="fas fa-calendar-plus" style="margin-left: 4px;"></i>${ex.grantedAt}
                </span>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${imageHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${actionHtml}</td>
        `;
        tbody.appendChild(row);
    });
    
    // تحديث العدادات
    const pendingCount = categoryExceptions.filter(ex => ex.status === 'pending').length;
    const completedCount = categoryExceptions.filter(ex => ex.status === 'completed').length;
    document.getElementById('pendingCountBadge').textContent = pendingCount + ' قيد الانتظار';
    document.getElementById('completedCountBadge').textContent = completedCount + ' تم';
    
    // تحديث أزرار الترقيم
    updatePagination('exceptions', categoryExceptions.length, exceptionsCurrentPage);
}

function loadLogTable() {
    const tbody = document.getElementById('logTableBody');
    tbody.innerHTML = '';
    
    const categoryLog = operationsLog.filter(log => {
        const student = studentsData[log.studentId];
        return student && student.category === currentSupervisor.category;
    });
    
    // الترقيم - 7 صفوف لكل صفحة
    const start = (logCurrentPage - 1) * ITEMS_PER_PAGE;
    const end = start + ITEMS_PER_PAGE;
    const pageRecords = categoryLog.slice(start, end);
    
    pageRecords.forEach((log, index) => {
        const row = document.createElement('tr');
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.25s ease forwards; animation-delay: ' + (index * 0.04) + 's; opacity: 0;';
        
        let statusColor = '';
        let statusBg = '';
        
        switch(log.status) {
            case 'pending':
                statusColor = '#f59e0b';
                statusBg = 'rgba(245, 158, 11, 0.1)';
                break;
            case 'completed':
                statusColor = '#10b981';
                statusBg = 'rgba(16, 185, 129, 0.1)';
                break;
            case 'revoked':
                statusColor = '#ef4444';
                statusBg = 'rgba(239, 68, 68, 0.1)';
                break;
            default:
                statusColor = '#4f46e5';
                statusBg = 'rgba(79, 70, 229, 0.1)';
        }
        
        row.innerHTML = `
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <div style="background: rgba(79, 70, 229, 0.08); border-radius: 6px; padding: 6px;">
                    <span style="font-weight: 700; color: var(--primary); font-size: clamp(0.75rem, 2vw, 0.8125rem); font-family: monospace;">${log.requestCode || '-'}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(11px, 2.8vw, 13px); flex-shrink: 0;">${log.studentName.charAt(0)}</div>
                    <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.75rem, 2vw, 0.8125rem);">${log.studentName}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-weight: 600; font-size: clamp(0.75rem, 2vw, 0.8125rem);">${log.studentId}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <span style="background: ${log.operation === 'إلغاء استثناء' ? 'rgba(239, 68, 68, 0.1)' : log.operation === 'إكمال تصوير' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(79, 70, 229, 0.1)'}; color: ${log.operation === 'إلغاء استثناء' ? '#ef4444' : log.operation === 'إكمال تصوير' ? '#10b981' : 'var(--primary)'}; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700; white-space: nowrap;">
                    ${log.operation}
                </span>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <span style="background: ${statusBg}; color: ${statusColor}; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700; white-space: nowrap;">
                    ${log.status === 'pending' ? 'معلق' : log.status === 'completed' ? 'مكتمل' : 'ملغى'}
                </span>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <span style="background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 4px 8px; border-radius: 10px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700; white-space: nowrap;">${log.performedBy}</span>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #9ca3af; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); white-space: nowrap;">
                <i class="fas fa-clock" style="margin-left: 4px; font-size: clamp(0.625rem, 1.6vw, 0.75rem);"></i>${log.date}
            </td>
        `;
        tbody.appendChild(row);
    });
    
    // تحديث أزرار الترقيم
    updatePagination('log', categoryLog.length, logCurrentPage);
}

// تحديث أزرار الترقيم
function updatePagination(type, totalItems, currentPage) {
    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE) || 1;
    const indicator = document.getElementById(type + 'PageIndicator');
    const prevBtn = document.getElementById(type + 'PrevBtn');
    const nextBtn = document.getElementById(type + 'NextBtn');
    
    indicator.textContent = `صفحة ${currentPage} من ${totalPages}`;
    
    // زر السابق
    prevBtn.disabled = currentPage === 1;
    prevBtn.style.opacity = currentPage === 1 ? '0.5' : '1';
    prevBtn.style.cursor = currentPage === 1 ? 'not-allowed' : 'pointer';
    
    // زر التالي - تجميده في الصفحة الأخيرة
    nextBtn.disabled = currentPage >= totalPages;
    nextBtn.style.opacity = currentPage >= totalPages ? '0.5' : '1';
    nextBtn.style.cursor = currentPage >= totalPages ? 'not-allowed' : 'pointer';
    nextBtn.style.background = currentPage >= totalPages ? '#e5e7eb' : 'linear-gradient(135deg, var(--primary), var(--primary-light))';
}

// تغيير صفحة الاستثناءات
function changeExceptionsPage(direction) {
    const categoryExceptions = activeExceptions.filter(ex => 
        ex.category === currentSupervisor.category
    );
    const totalPages = Math.ceil(categoryExceptions.length / ITEMS_PER_PAGE) || 1;
    
    if (direction === 'next' && exceptionsCurrentPage < totalPages) {
        exceptionsCurrentPage++;
        loadExceptionsTable();
    } else if (direction === 'prev' && exceptionsCurrentPage > 1) {
        exceptionsCurrentPage--;
        loadExceptionsTable();
    }
}

// تغيير صفحة السجل
function changeLogPage(direction) {
    const categoryLog = operationsLog.filter(log => {
        const student = studentsData[log.studentId];
        return student && student.category === currentSupervisor.category;
    });
    const totalPages = Math.ceil(categoryLog.length / ITEMS_PER_PAGE) || 1;
    
    if (direction === 'next' && logCurrentPage < totalPages) {
        logCurrentPage++;
        loadLogTable();
    } else if (direction === 'prev' && logCurrentPage > 1) {
        logCurrentPage--;
        loadLogTable();
    }
}

function addToLog(record) {
    operationsLog.unshift({
        id: operationsLog.length + 1,
        ...record
    });
    loadLogTable();
}

// ========== دوال عامة ==========
function switchTab(tabName) {
    document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');
    document.getElementById(tabName + 'Content').style.display = 'block';
    
    if (tabName === 'exceptions') {
        exceptionsCurrentPage = 1;
        loadExceptionsTable();
    }
    if (tabName === 'log') {
        logCurrentPage = 1;
        loadLogTable();
    }
}

function showSmallToast(message, type = 'info') {
    const colors = {
        info: { bg: 'linear-gradient(135deg, var(--primary), var(--primary-light))', icon: 'fa-info-circle' },
        success: { bg: 'linear-gradient(135deg, var(--secondary), #059669)', icon: 'fa-check-circle' },
        warning: { bg: 'linear-gradient(135deg, var(--warning), #fbbf24)', icon: 'fa-exclamation-triangle' },
        error: { bg: 'linear-gradient(135deg, var(--danger), #dc2626)', icon: 'fa-times-circle' }
    };
    const color = colors[type] || colors.info;
    
    const toast = document.getElementById('smallToast');
    const content = document.getElementById('smallToastContent');
    
    content.style.background = color.bg;
    content.style.color = 'white';
    content.innerHTML = `<i class="fas ${color.icon}" style="font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>${message}`;
    
    toast.style.display = 'block';
    
    setTimeout(() => {
        toast.style.animation = 'toastFade 0.2s ease';
        setTimeout(() => {
            toast.style.display = 'none';
            toast.style.animation = '';
        }, 200);
    }, 2500);
}

// إغلاق المودالات
document.addEventListener('click', function(e) {
    if (e.target.id === 'grantModal') closeGrantModal();
    if (e.target.id === 'revokeModal') closeRevokeModal();
    if (e.target.id === 'requestCodeModal') closeRequestCodeModal();
});

// تحميل البيانات
document.addEventListener('DOMContentLoaded', function() {
    loadExceptionsTable();
    loadLogTable();
});
</script>

<style>
@keyframes modalPop {
    0% { opacity: 0; transform: scale(0.9) translateY(20px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes toastSlide {
    from { opacity: 0; transform: translateX(-50%) translateY(-20px); }
    to { opacity: 1; transform: translateX(-50%) translateY(0); }
}
@keyframes toastFade {
    from { opacity: 1; transform: translateX(-50%) translateY(0); }
    to { opacity: 0; transform: translateX(-50%) translateY(-20px); }
}

/* تصغير عناصر الجدول */
.cases-table th,
.cases-table td {
    font-size: clamp(0.75rem, 2vw, 0.875rem);
    vertical-align: middle;
}

/* تصغير الأيقونات في الجدول */
.cases-table th i {
    font-size: clamp(0.75rem, 2vw, 0.875rem);
}

/* تحسين الأزرار */
button:not(:disabled):active {
    transform: scale(0.97);
}

button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* تحسين الحقول */
input:focus,
textarea:focus {
    outline: none;
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

/* تصغير المسافات */
.input-container {
    margin-bottom: clamp(12px, 3vw, 16px);
}

/* تحسين التبويبات */
.tab-item {
    font-size: clamp(0.75rem, 2vw, 0.875rem);
    padding: clamp(8px, 2vw, 10px) clamp(12px, 3vw, 16px);
}

/* تصغير العناوين */
.section-title {
    margin-bottom: clamp(10px, 2.5vw, 14px);
}

/* تأثير hover على رمز الطلب */
td div[style*="cursor: pointer"]:hover {
    transform: scale(1.02);
    box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);
}

/* تحسين عرض رمز الطلب */
td div[style*="font-family: monospace"] {
    user-select: all;
}

/* تحسين أزرار الترقيم */
#exceptionsPagination button,
#logPagination button {
    transition: all 0.2s ease;
}

#exceptionsPagination button:not(:disabled):hover,
#logPagination button:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>

