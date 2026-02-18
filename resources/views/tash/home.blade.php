@extends('layouts.app')

@section('title', 'إدارة استثناءات البانوراما')
@section('page_title', 'استثناءات البانوراما')

@section('tabs')
<div class="tab-item active" onclick="switchTab('requests')">
    <i class="fas fa-clipboard-list" style="margin-left: 4px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
    طلبات التصوير
</div>
<div class="tab-item" onclick="switchTab('accepted')">
    <i class="fas fa-check-circle" style="margin-left: 4px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
    مقبولة
</div>
<div class="tab-item" onclick="switchTab('completed')">
    <i class="fas fa-image" style="margin-left: 4px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
    منجزة
</div>
<div class="tab-item" onclick="switchTab('rejected')">
    <i class="fas fa-times-circle" style="margin-left: 4px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
    مرفوضة
</div>
<div class="tab-item" onclick="switchTab('log')">
    <i class="fas fa-history" style="margin-left: 4px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
    السجل
</div>
@endsection

@section('tab_content')
<!-- تبويب طلبات التصوير -->
<div class="tab-content" id="requestsContent" style="display: block;">
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
        <p style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.875rem); margin-bottom: clamp(16px, 4vw, 20px);">ابحث عن الطالب لمنح استثناء التصوير</p>
        
        <div style="display: flex; gap: 8px; max-width: 320px; margin: 0 auto;">
            <input type="text" id="studentIdInput" placeholder="مثال: 20214587" style="flex: 1; padding: clamp(10px, 2.5vw, 12px); border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); text-align: center; font-weight: 600; letter-spacing: 1px;">
            <button onclick="searchStudent()" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25); transition: all 0.2s; white-space: nowrap;">
                <i class="fas fa-search" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                بحث
            </button>
        </div>
    </div>

    <!-- نتائج البحث -->
    <div id="searchResults" style="display: none;">
        <div class="section-title" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
            <i class="fas fa-users" style="color: var(--primary); font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
            <span>نتائج البحث</span>
        </div>
        
        <div id="studentsList" style="display: flex; flex-direction: column; gap: clamp(10px, 2.5vw, 12px);">
            <!-- سيتم ملؤها بالJavaScript -->
        </div>
    </div>

    <!-- لا يوجد نتائج -->
    <div id="noResults" style="display: none; text-align: center; padding: clamp(32px, 8vw, 40px) clamp(16px, 4vw, 20px);">
        <div style="width: clamp(64px, 16vw, 80px); height: clamp(64px, 16vw, 80px); background: var(--gray-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px);">
            <i class="fas fa-user-slash" style="font-size: clamp(24px, 6vw, 28px); color: var(--gray);"></i>
        </div>
        <h3 style="color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); margin-bottom: 6px; font-weight: 700;">لا يوجد طالب بهذا الرقم</h3>
        <p style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.875rem);">تأكد من صحة الرقم الجامعي</p>
    </div>
</div>

<!-- تبويب الطلبات المقبولة - TABLE -->
<div class="tab-content" id="acceptedContent" style="display: none;">
    <div class="section-title" style="margin-top: clamp(8px, 2vw, 12px); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
        <i class="fas fa-check-circle" style="color: var(--secondary); font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
        <span>الطلبات المقبولة (قيد التصوير)</span>
        <span id="acceptedCount" style="background: var(--secondary); color: white; padding: 2px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); margin-right: 8px;">0</span>
    </div>

    <div class="input-container" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="cases-table" style="min-width: 700px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الطالب</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الجامعي</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-barcode" style="margin-left: 4px; color: var(--primary);"></i>
                            رمز الطلب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-calendar-check" style="margin-left: 4px; color: var(--secondary);"></i>
                            تاريخ القبول
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الإجراء</th>
                    </tr>
                </thead>
                <tbody id="acceptedTableBody">
                    <!-- سيتم ملؤها بالJavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <div id="noAccepted" style="display: none; text-align: center; padding: clamp(40px, 10vw, 48px) clamp(16px, 4vw, 20px);">
        <div style="width: clamp(72px, 18vw, 88px); height: clamp(72px, 18vw, 88px); background: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(16px, 4vw, 20px);">
            <i class="fas fa-check-double" style="font-size: clamp(28px, 7vw, 32px); color: var(--secondary);"></i>
        </div>
        <h3 style="color: var(--dark); font-size: clamp(1rem, 3vw, 1.125rem); margin-bottom: 8px; font-weight: 700;">لا توجد طلبات مقبولة</h3>
        <p style="color: var(--gray); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">الطلبات المقبولة ستظهر هنا بانتظار رفع الصور</p>
    </div>
</div>

<!-- تبويب الصور المنجزة - TABLE -->
<div class="tab-content" id="completedContent" style="display: none;">
    <div class="section-title" style="margin-top: clamp(8px, 2vw, 12px); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
        <i class="fas fa-image" style="color: var(--primary); font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
        <span>الصور المنجزة</span>
        <span id="completedCount" style="background: var(--primary); color: white; padding: 2px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); margin-right: 8px;">0</span>
    </div>

    <div class="input-container" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="cases-table" style="min-width: 900px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الطالب</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الجامعي</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-calendar-plus" style="margin-left: 4px; color: var(--warning);"></i>
                            تاريخ الطلب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-user-tie" style="margin-left: 4px; color: var(--primary);"></i>
                            الجهة المانحة
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-barcode" style="margin-left: 4px; color: var(--primary);"></i>
                            رمز الطلب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-calendar-check" style="margin-left: 4px; color: var(--secondary);"></i>
                            تاريخ الإتمام
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الحالة</th>
                    </tr>
                </thead>
                <tbody id="completedTableBody">
                    <!-- سيتم ملؤها بالJavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <div id="noCompleted" style="display: none; text-align: center; padding: clamp(40px, 10vw, 48px) clamp(16px, 4vw, 20px);">
        <div style="width: clamp(72px, 18vw, 88px); height: clamp(72px, 18vw, 88px); background: rgba(79, 70, 229, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(16px, 4vw, 20px);">
            <i class="fas fa-images" style="font-size: clamp(28px, 7vw, 32px); color: var(--primary);"></i>
        </div>
        <h3 style="color: var(--dark); font-size: clamp(1rem, 3vw, 1.125rem); margin-bottom: 8px; font-weight: 700;">لا توجد صور منجزة</h3>
        <p style="color: var(--gray); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">الصور المرفوعة ستظهر هنا مع جميع التفاصيل</p>
    </div>
</div>

<!-- تبويب الطلبات المرفوضة - TABLE -->
<div class="tab-content" id="rejectedContent" style="display: none;">
    <div class="section-title" style="margin-top: clamp(8px, 2vw, 12px); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
        <i class="fas fa-times-circle" style="color: var(--danger); font-size: clamp(0.875rem, 2.5vw, 1rem);"></i>
        <span>الطلبات المرفوضة</span>
        <span id="rejectedCount" style="background: var(--danger); color: white; padding: 2px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); margin-right: 8px;">0</span>
    </div>

    <div class="input-container" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="cases-table" style="min-width: 800px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الطالب</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">الجامعي</th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-barcode" style="margin-left: 4px; color: var(--primary);"></i>
                            رمز الطلب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-calendar-times" style="margin-left: 4px; color: var(--danger);"></i>
                            تاريخ الرفض
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-comment-alt" style="margin-left: 4px; color: var(--danger);"></i>
                            سبب الرفض
                        </th>
                    </tr>
                </thead>
                <tbody id="rejectedTableBody">
                    <!-- سيتم ملؤها بالJavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <div id="noRejected" style="display: none; text-align: center; padding: clamp(40px, 10vw, 48px) clamp(16px, 4vw, 20px);">
        <div style="width: clamp(72px, 18vw, 88px); height: clamp(72px, 18vw, 88px); background: rgba(239, 68, 68, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(16px, 4vw, 20px);">
            <i class="fas fa-ban" style="font-size: clamp(28px, 7vw, 32px); color: var(--danger);"></i>
        </div>
        <h3 style="color: var(--dark); font-size: clamp(1rem, 3vw, 1.125rem); margin-bottom: 8px; font-weight: 700;">لا توجد طلبات مرفوضة</h3>
        <p style="color: var(--gray); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">الطلبات المرفوضة مع الأسباب ستظهر هنا</p>
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
                جميع العمليات
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

<!-- مودال رفض الطلب -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 100000; justify-content: center; align-items: center; padding: 12px;">
    <div style="background: white; border-radius: clamp(12px, 3vw, 16px); width: 100%; max-width: 380px; max-height: 85vh; overflow-y: auto; animation: modalPop 0.25s ease;">
        <div style="background: linear-gradient(135deg, var(--danger), #dc2626); padding: clamp(20px, 5vw, 24px); text-align: center;">
            <div style="width: clamp(56px, 14vw, 64px); height: clamp(56px, 14vw, 64px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px);">
                <i class="fas fa-times-circle" style="font-size: clamp(24px, 6vw, 28px); color: white;"></i>
            </div>
            <h3 style="color: white; font-size: clamp(1rem, 3vw, 1.125rem); font-weight: 700; margin: 0;">رفض الطلب</h3>
        </div>
        
        <div style="padding: clamp(20px, 5vw, 24px);">
            <div style="background: #f8fafc; border-radius: 10px; padding: clamp(12px, 3vw, 16px); margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--danger), #dc2626); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1rem);">الطالب: <span id="rejectStudentName">-</span></div>
                        <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">الرقم: <span id="rejectStudentId" style="color: var(--danger); font-weight: 600;">-</span></div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: clamp(16px, 4vw, 20px);">
                <label style="display: block; font-weight: 700; color: var(--dark); margin-bottom: 8px; font-size: clamp(0.875rem, 2.5vw, 1rem);">
                    <i class="fas fa-comment-alt" style="color: var(--danger); margin-left: 6px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    سبب الرفض <span style="color: var(--danger);">*</span>
                </label>
                <textarea id="rejectReason" rows="3" placeholder="اكتب سبب رفض الطلب..." style="width: 100%; padding: clamp(10px, 2.5vw, 12px); border: 1.5px solid #e5e7eb; border-radius: 8px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); resize: vertical; min-height: 80px;"></textarea>
                <div style="margin-top: 6px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray);">
                    <i class="fas fa-info-circle" style="margin-left: 4px; font-size: clamp(0.625rem, 1.6vw, 0.75rem);"></i>
                    سيتم تسجيل هذا السبب في السجل مع التاريخ والوقت
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button onclick="closeRejectModal()" style="flex: 1; background: var(--gray-light); color: var(--gray-dark); border: none; padding: clamp(12px, 3vw, 14px); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">
                    إلغاء
                </button>
                <button onclick="confirmRejectRequest()" style="flex: 1; background: linear-gradient(135deg, var(--danger), #dc2626); color: white; border: none; padding: clamp(12px, 3vw, 14px); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-times" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    تأكيد الرفض
                </button>
            </div>
        </div>
    </div>
</div>

<!-- مودال رفع الصورة -->
<div id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 100001; justify-content: center; align-items: center; padding: 12px;">
    <div style="background: white; border-radius: clamp(12px, 3vw, 16px); width: 100%; max-width: 400px; max-height: 85vh; overflow-y: auto; animation: modalPop 0.25s ease;">
        <div style="background: linear-gradient(135deg, var(--secondary), #059669); padding: clamp(20px, 5vw, 24px); text-align: center;">
            <div style="width: clamp(56px, 14vw, 64px); height: clamp(56px, 14vw, 64px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px);">
                <i class="fas fa-cloud-upload-alt" style="font-size: clamp(24px, 6vw, 28px); color: white;"></i>
            </div>
            <h3 style="color: white; font-size: clamp(1rem, 3vw, 1.125rem); font-weight: 700; margin: 0;">رفع صورة البانوراما</h3>
        </div>
        
        <div style="padding: clamp(20px, 5vw, 24px);">
            <div style="background: #f8fafc; border-radius: 10px; padding: clamp(12px, 3vw, 16px); margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1rem);">الطالب: <span id="uploadStudentName">-</span></div>
                        <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">الرقم: <span id="uploadStudentId" style="color: var(--secondary); font-weight: 600;">-</span></div>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.05)); border: 1.5px dashed var(--primary); border-radius: 8px; padding: 10px; text-align: center; margin-top: 10px;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">
                        <i class="fas fa-barcode" style="margin-left: 4px; color: var(--primary);"></i>
                        رمز الطلب
                    </div>
                    <div style="font-weight: 800; color: var(--primary); font-size: clamp(1rem, 3vw, 1.125rem); letter-spacing: 1px; font-family: monospace;" id="uploadRequestCode">-</div>
                </div>
            </div>

            <!-- منطقة رفع الملف -->
            <div style="margin-bottom: clamp(16px, 4vw, 20px);">
                <label style="display: block; font-weight: 700; color: var(--dark); margin-bottom: 12px; font-size: clamp(0.875rem, 2.5vw, 1rem);">
                    <i class="fas fa-image" style="color: var(--secondary); margin-left: 6px; font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    اختيار الصورة
                </label>
                
                <div id="dropZone" style="border: 2px dashed #d1d5db; border-radius: 12px; padding: clamp(24px, 6vw, 32px); text-align: center; background: #f9fafb; cursor: pointer; transition: all 0.2s;">
                    <input type="file" id="imageInput" accept="image/*" style="display: none;" onchange="handleImageSelect(event)">
                    <div style="width: clamp(56px, 14vw, 64px); height: clamp(56px, 14vw, 64px); background: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(12px, 3vw, 16px);">
                        <i class="fas fa-cloud-upload-alt" style="font-size: clamp(24px, 6vw, 28px); color: var(--secondary);"></i>
                    </div>
                    <div style="font-weight: 700; color: var(--dark); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); margin-bottom: 6px;">اسحب الصورة هنا أو انقر للاختيار</div>
                    <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">PNG, JPG حتى 10 ميجابايت</div>
                </div>
                
                <!-- معاينة الصورة -->
                <div id="imagePreview" style="display: none; margin-top: 16px;">
                    <div style="position: relative; border-radius: 12px; overflow: hidden; border: 2px solid var(--secondary);">
                        <img id="previewImg" style="width: 100%; height: auto; display: block;" />
                        <button onclick="clearImage()" style="position: absolute; top: 8px; left: 8px; background: rgba(239, 68, 68, 0.9); color: white; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div style="text-align: center; margin-top: 8px; color: var(--secondary); font-size: clamp(0.75rem, 2vw, 0.8125rem); font-weight: 600;">
                        <i class="fas fa-check-circle" style="margin-left: 4px;"></i>
                        تم اختيار الصورة
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button onclick="closeUploadModal()" style="flex: 1; background: var(--gray-light); color: var(--gray-dark); border: none; padding: clamp(12px, 3vw, 14px); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">
                    إلغاء
                </button>
                <button onclick="confirmUploadImage()" id="confirmUploadBtn" style="flex: 1; background: linear-gradient(135deg, var(--secondary), #059669); color: white; border: none; padding: clamp(12px, 3vw, 14px); border-radius: 10px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px;" disabled>
                    <i class="fas fa-check" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    تأكيد الرفع
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast صغير -->
<div id="smallToast" style="display: none; position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 100003; animation: toastSlide 0.2s ease;">
    <div id="smallToastContent" style="padding: 10px 20px; border-radius: 20px; font-weight: 600; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 8px; white-space: nowrap;">
        <!-- سيتم ملؤها بالJavaScript -->
    </div>
</div>

<script>
// بيانات المشرف الحالي
const currentSupervisor = {
    name: 'د. أحمد النجار',
    category: 'الفئة الثالثة',
    categoryCode: 'CAT-003',
    courseName: 'طب الأسنان العملي'
};

// بيانات الطلاب
const studentsData = {
    '20214587': { name: 'محمد أحمد علي', category: 'الفئة الثالثة' },
    '20216732': { name: 'سارة خالد يوسف', category: 'الفئة الثالثة' },
    '20219854': { name: 'عمر محمود حسن', category: 'الفئة الثالثة' },
    '20210001': { name: 'أحمد محمد علي', category: 'الفئة الأولى' },
    '20220015': { name: 'فاطمة أحمد سعيد', category: 'الفئة الثالثة' },
    '20223456': { name: 'خالد عمر محمود', category: 'الفئة الثالثة' },
    '20227890': { name: 'نورا سامي عبدالله', category: 'الفئة الثالثة' }
};

// حالات الطلبات
let requests = [
    {
        id: 1,
        requestCode: 'PANO-X7K9M2P4',
        studentId: '20214587',
        studentName: 'محمد أحمد علي',
        category: 'الفئة الثالثة',
        status: 'pending',
        requestDate: '2024-01-15 09:30:45',
        acceptedAt: null,
        completedAt: null,
        rejectedAt: null,
        rejectReason: null,
        imageUploaded: false,
        imageUrl: null,
        grantedBy: null
    },
    {
        id: 2,
        requestCode: 'PANO-N3Q7R8T5',
        studentId: '20216732',
        studentName: 'سارة خالد يوسف',
        category: 'الفئة الثالثة',
        status: 'accepted',
        requestDate: '2024-01-14 14:20:15',
        acceptedAt: '2024-01-14 14:25:30',
        completedAt: null,
        rejectedAt: null,
        rejectReason: null,
        imageUploaded: false,
        imageUrl: null,
        grantedBy: 'د. أحمد النجار'
    },
    {
        id: 3,
        requestCode: 'PANO-Y5V9W2A8',
        studentId: '20223456',
        studentName: 'خالد عمر محمود',
        category: 'الفئة الثالثة',
        status: 'completed',
        requestDate: '2024-01-13 11:15:00',
        acceptedAt: '2024-01-13 11:20:00',
        completedAt: '2024-01-13 16:45:30',
        rejectedAt: null,
        rejectReason: null,
        imageUploaded: true,
        imageUrl: 'https://via.placeholder.com/400x300/10b981/ffffff?text=Panorama+Image',
        grantedBy: 'د. أحمد النجار'
    },
    {
        id: 4,
        requestCode: 'PANO-B12CD34E',
        studentId: '20227890',
        studentName: 'نورا سامي عبدالله',
        category: 'الفئة الثالثة',
        status: 'rejected',
        requestDate: '2024-01-12 10:00:00',
        acceptedAt: null,
        completedAt: null,
        rejectedAt: '2024-01-12 10:30:00',
        rejectReason: 'عدم استكمال الملف الطبي المطلوب',
        imageUploaded: false,
        imageUrl: null,
        grantedBy: null
    }
];

let operationsLog = [];
let currentStudentId = null;
let currentRequestId = null;
let selectedImageFile = null;
let lastSearchedStudentId = null; // لتتبع آخر بحث

const ITEMS_PER_PAGE = 7;
let logCurrentPage = 1;

// توليد رمز فريد
function generateRequestCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = 'PANO-';
    for (let i = 0; i < 8; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return code;
}

// الحصول على حالة الطلب الحالية للطالب
function getStudentRequestStatus(studentId) {
    // البحث عن آخر طلب للطالب (بغض النظر عن الحالة)
    const studentRequests = requests.filter(r => r.studentId === studentId);
    if (studentRequests.length === 0) return null;
    
    // إرجاع آخر طلب (الأحدث)
    return studentRequests.sort((a, b) => b.id - a.id)[0];
}

// البحث عن طالب
function searchStudent() {
    const studentId = document.getElementById('studentIdInput').value.trim();
    
    if (!studentId) {
        showSmallToast('أدخل الرقم الجامعي', 'warning');
        return;
    }
    
    const student = studentsData[studentId];
    
    if (!student) {
        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('noResults').style.display = 'block';
        return;
    }
    
    if (student.category !== currentSupervisor.category) {
        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('noResults').style.display = 'block';
        showSmallToast('الطالب لا ينتمي لفئتك', 'error');
        return;
    }
    
    currentStudentId = studentId;
    lastSearchedStudentId = studentId;
    
    // عرض نتيجة البحث
    const listContainer = document.getElementById('studentsList');
    listContainer.innerHTML = '';
    
    const card = createStudentCard(studentId, student);
    listContainer.appendChild(card);
    
    document.getElementById('noResults').style.display = 'none';
    document.getElementById('searchResults').style.display = 'block';
    
    // ما نظهرش Toast إلا إذا كان بحث جديد (مش بعد قبول/رفض)
    if (!window.justProcessed) {
        showSmallToast('تم العثور على الطالب', 'success');
    }
    window.justProcessed = false;
}

// إنشاء كارت الطالب (للبحث) - منطق محسّن
function createStudentCard(studentId, student) {
    const existingRequest = getStudentRequestStatus(studentId);
    
    const card = document.createElement('div');
    card.style.cssText = 'background: white; border-radius: 12px; border: 1.5px solid #e5e7eb; overflow: hidden; transition: all 0.2s ease;';
    
    let actionSection = '';
    
    if (!existingRequest) {
        // ما في طلب سابق - إنشاء طلب جديد
        const newRequest = {
            id: requests.length + 1,
            requestCode: generateRequestCode(),
            studentId: studentId,
            studentName: student.name,
            category: student.category,
            status: 'pending',
            requestDate: new Date().toLocaleString('ar-SA'),
            acceptedAt: null,
            completedAt: null,
            rejectedAt: null,
            rejectReason: null,
            imageUploaded: false,
            imageUrl: null,
            grantedBy: null
        };
        requests.push(newRequest);
        
        actionSection = `
            <div style="background: rgba(79, 70, 229, 0.05); border-top: 1px solid #e5e7eb; padding: clamp(12px, 3vw, 16px); display: flex; gap: 8px;">
                <div style="flex: 1; background: white; border: 1.5px dashed var(--primary); border-radius: 8px; padding: 10px; text-align: center;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">رمز الطلب</div>
                    <div style="font-weight: 800; color: var(--primary); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); letter-spacing: 1px; font-family: monospace;">${newRequest.requestCode}</div>
                </div>
            </div>
            <div style="background: rgba(79, 70, 229, 0.05); border-top: 1px solid #e5e7eb; padding: clamp(12px, 3vw, 16px); display: flex; gap: 8px;">
                <button onclick="openRejectModal(${newRequest.id})" style="flex: 1; background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1.5px solid rgba(239, 68, 68, 0.3); padding: clamp(10px, 2.5vw, 12px); border-radius: 8px; font-weight: 600; cursor: pointer; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-times" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    رفض
                </button>
                <button onclick="acceptRequest(${newRequest.id})" style="flex: 1; background: linear-gradient(135deg, var(--secondary), #059669); color: white; border: none; padding: clamp(10px, 2.5vw, 12px); border-radius: 8px; font-weight: 600; cursor: pointer; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);">
                    <i class="fas fa-check" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                    قبول الطلب
                </button>
            </div>
        `;
    } else {
        // في طلب سابق - نتحقق من حالته
        switch(existingRequest.status) {
            case 'pending':
                // طلب معلق - نظهر أزرار القبول والرفض
                actionSection = `
                    <div style="background: rgba(245, 158, 11, 0.08); border-top: 1px solid #e5e7eb; padding: clamp(12px, 3vw, 16px); display: flex; gap: 8px;">
                        <div style="flex: 1; background: white; border: 1.5px solid rgba(245, 158, 11, 0.3); border-radius: 8px; padding: 10px; text-align: center;">
                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">رمز الطلب</div>
                            <div style="font-weight: 800; color: var(--warning); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); letter-spacing: 1px; font-family: monospace;">${existingRequest.requestCode}</div>
                        </div>
                    </div>
                    <div style="background: rgba(245, 158, 11, 0.08); border-top: 1px solid #e5e7eb; padding: clamp(12px, 3vw, 16px); display: flex; gap: 8px;">
                        <button onclick="openRejectModal(${existingRequest.id})" style="flex: 1; background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1.5px solid rgba(239, 68, 68, 0.3); padding: clamp(10px, 2.5vw, 12px); border-radius: 8px; font-weight: 600; cursor: pointer; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <i class="fas fa-times" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                            رفض
                        </button>
                        <button onclick="acceptRequest(${existingRequest.id})" style="flex: 1; background: linear-gradient(135deg, var(--secondary), #059669); color: white; border: none; padding: clamp(10px, 2.5vw, 12px); border-radius: 8px; font-weight: 600; cursor: pointer; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);">
                            <i class="fas fa-check" style="font-size: clamp(0.75rem, 2vw, 0.875rem);"></i>
                            قبول الطلب
                        </button>
                    </div>
                `;
                break;
                
            case 'accepted':
                // طلب مقبول - نظهر حالة "قيد الإنجاز"
                actionSection = `
                    <div style="background: rgba(16, 185, 129, 0.08); border-top: 1px solid #e5e7eb; padding: clamp(16px, 4vw, 20px); text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-spinner fa-spin" style="color: white; font-size: 20px;"></i>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; color: var(--secondary); font-size: clamp(1rem, 3vw, 1.125rem);">طلب قيد الإنجاز</div>
                                <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">تم قبول الطلب بتاريخ: ${existingRequest.acceptedAt}</div>
                            </div>
                        </div>
                        <div style="background: white; border: 1.5px dashed var(--secondary); border-radius: 8px; padding: 10px; display: inline-block;">
                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">رمز الطلب</div>
                            <div style="font-weight: 800; color: var(--secondary); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); letter-spacing: 1px; font-family: monospace;">${existingRequest.requestCode}</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'completed':
                // طلب منجز - نظهر حالة "تم الإنجاز"
                actionSection = `
                    <div style="background: rgba(79, 70, 229, 0.08); border-top: 1px solid #e5e7eb; padding: clamp(16px, 4vw, 20px); text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-double" style="color: white; font-size: 20px;"></i>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; color: var(--primary); font-size: clamp(1rem, 3vw, 1.125rem);">تم إنجاز الطلب</div>
                                <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">تاريخ الإنجاز: ${existingRequest.completedAt}</div>
                            </div>
                        </div>
                        <div style="background: white; border: 1.5px dashed var(--primary); border-radius: 8px; padding: 10px; display: inline-block;">
                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">رمز الطلب</div>
                            <div style="font-weight: 800; color: var(--primary); font-size: clamp(0.9375rem, 2.8vw, 1.0625rem); letter-spacing: 1px; font-family: monospace;">${existingRequest.requestCode}</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'rejected':
                // طلب مرفوض - نظهر رسالة "لا يوجد طلبات جديدة"
                actionSection = `
                    <div style="background: rgba(239, 68, 68, 0.08); border-top: 1px solid #e5e7eb; padding: clamp(16px, 4vw, 20px); text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--danger), #dc2626); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-ban" style="color: white; font-size: 20px;"></i>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; color: var(--danger); font-size: clamp(1rem, 3vw, 1.125rem);">لا يوجد طلبات جديدة</div>
                                <div style="color: var(--gray); font-size: clamp(0.75rem, 2vw, 0.8125rem);">تم رفض آخر طلب بتاريخ: ${existingRequest.rejectedAt}</div>
                            </div>
                        </div>
                        <div style="background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 8px; padding: 10px; margin-top: 10px;">
                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">سبب الرفض</div>
                            <div style="font-weight: 700; color: var(--danger); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">${existingRequest.rejectReason}</div>
                        </div>
                    </div>
                `;
                break;
        }
    }
    
    card.innerHTML = `
        <div style="padding: clamp(16px, 4vw, 20px);">
            <div style="display: flex; align-items: center; gap: clamp(12px, 3vw, 16px); margin-bottom: clamp(16px, 4vw, 20px);">
                <div style="width: clamp(56px, 14vw, 64px); height: clamp(56px, 14vw, 64px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(1.25rem, 4vw, 1.5rem); flex-shrink: 0;">
                    ${student.name.charAt(0)}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 800; color: var(--dark); font-size: clamp(1rem, 3vw, 1.125rem); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${student.name}</div>
                    <div style="color: var(--gray); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">الرقم الجامعي: <span style="color: var(--primary); font-weight: 700;">${studentId}</span></div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: clamp(10px, 2.5vw, 12px);">
                <div style="background: #f8fafc; border-radius: 8px; padding: clamp(10px, 2.5vw, 12px); text-align: center;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">
                        <i class="fas fa-user-tie" style="margin-left: 4px; color: var(--primary);"></i>
                        المشرف
                    </div>
                    <div style="font-weight: 700; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${currentSupervisor.name}</div>
                </div>
                
                <div style="background: #f8fafc; border-radius: 8px; padding: clamp(10px, 2.5vw, 12px); text-align: center;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">
                        <i class="fas fa-tag" style="margin-left: 4px; color: var(--primary);"></i>
                        رمز الفئة
                    </div>
                    <div style="font-weight: 700; color: var(--primary); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">${currentSupervisor.categoryCode}</div>
                </div>
                
                <div style="background: #f8fafc; border-radius: 8px; padding: clamp(10px, 2.5vw, 12px); text-align: center; grid-column: span 2;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.75rem); color: var(--gray); margin-bottom: 4px;">
                        <i class="fas fa-book" style="margin-left: 4px; color: var(--primary);"></i>
                        المقرر
                    </div>
                    <div style="font-weight: 700; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">${currentSupervisor.courseName}</div>
                </div>
            </div>
        </div>
        ${actionSection}
    `;
    
    return card;
}

// قبول الطلب
function acceptRequest(requestId) {
    const request = requests.find(r => r.id === requestId);
    if (!request) return;
    
    const now = new Date().toLocaleString('ar-SA');
    request.status = 'accepted';
    request.acceptedAt = now;
    request.grantedBy = currentSupervisor.name;
    
    addToLog({
        requestCode: request.requestCode,
        operation: 'قبول طلب',
        studentId: request.studentId,
        studentName: request.studentName,
        status: 'accepted',
        performedBy: currentSupervisor.name,
        date: now,
        details: `قبول طلب تصوير بانوراما - الرمز: ${request.requestCode}`
    });
    
    // تحديث الجداول
    loadAcceptedTable();
    
    // تحديث عرض البحث مباشرة بدون Toast
    window.justProcessed = true;
    if (document.getElementById('searchResults').style.display === 'block') {
        searchStudent();
    }
    
    showSmallToast('تم قبول الطلب بنجاح', 'success');
}

// فتح مودال الرفض
function openRejectModal(requestId) {
    const request = requests.find(r => r.id === requestId);
    if (!request) return;
    
    currentRequestId = requestId;
    document.getElementById('rejectStudentName').textContent = request.studentName;
    document.getElementById('rejectStudentId').textContent = request.studentId;
    document.getElementById('rejectReason').value = '';
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
    currentRequestId = null;
}

// تأكيد الرفض
function confirmRejectRequest() {
    const reason = document.getElementById('rejectReason').value.trim();
    
    if (!reason) {
        showSmallToast('اكتب سبب الرفض', 'warning');
        return;
    }
    
    const request = requests.find(r => r.id === currentRequestId);
    if (!request) return;
    
    const now = new Date().toLocaleString('ar-SA');
    request.status = 'rejected';
    request.rejectedAt = now;
    request.rejectReason = reason;
    
    addToLog({
        requestCode: request.requestCode,
        operation: 'رفض طلب',
        studentId: request.studentId,
        studentName: request.studentName,
        status: 'rejected',
        performedBy: currentSupervisor.name,
        date: now,
        details: `سبب الرفض: ${reason}`
    });
    
    // تحديث الجداول
    loadRejectedTable();
    
    closeRejectModal();
    
    // تحديث عرض البحث مباشرة بدون Toast
    window.justProcessed = true;
    if (document.getElementById('searchResults').style.display === 'block') {
        searchStudent();
    }
    
    showSmallToast('تم رفض الطلب بنجاح', 'success');
}

// تحميل جدول الطلبات المقبولة
function loadAcceptedTable() {
    const tbody = document.getElementById('acceptedTableBody');
    const acceptedRequests = requests.filter(r => r.status === 'accepted' && r.category === currentSupervisor.category);
    
    document.getElementById('acceptedCount').textContent = acceptedRequests.length;
    
    if (acceptedRequests.length === 0) {
        tbody.innerHTML = '';
        document.getElementById('noAccepted').style.display = 'block';
        document.querySelector('#acceptedContent .input-container').style.display = 'none';
        return;
    }
    
    document.getElementById('noAccepted').style.display = 'none';
    document.querySelector('#acceptedContent .input-container').style.display = 'block';
    tbody.innerHTML = '';
    
    acceptedRequests.forEach((request, index) => {
        const row = document.createElement('tr');
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.25s ease forwards; animation-delay: ' + (index * 0.05) + 's; opacity: 0;';
        
        row.innerHTML = `
            <td style="padding: clamp(10px, 2.5vw, 14px);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(11px, 2.8vw, 13px); flex-shrink: 0;">${request.studentName.charAt(0)}</div>
                    <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.75rem, 2vw, 0.8125rem);">${request.studentName}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-weight: 600; font-size: clamp(0.75rem, 2vw, 0.8125rem);">${request.studentId}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <div style="background: rgba(79, 70, 229, 0.08); border-radius: 6px; padding: 6px;">
                    <span style="font-weight: 700; color: var(--primary); font-size: clamp(0.75rem, 2vw, 0.8125rem); font-family: monospace;">${request.requestCode}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-size: clamp(0.75rem, 2vw, 0.8125rem); white-space: nowrap;">
                <i class="fas fa-clock" style="margin-left: 4px; color: var(--secondary);"></i>
                ${request.acceptedAt}
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <button onclick="openUploadModal(${request.id})" style="background: linear-gradient(135deg, var(--secondary), #059669); color: white; border: none; padding: clamp(8px, 2vw, 10px) clamp(16px, 4vw, 20px); border-radius: 8px; font-weight: 600; cursor: pointer; font-size: clamp(0.75rem, 2vw, 0.8125rem); display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25); transition: all 0.2s;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: clamp(0.75rem, 2vw, 0.8125rem);"></i>
                    رفع الصورة
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// تحميل جدول الصور المنجزة
function loadCompletedTable() {
    const tbody = document.getElementById('completedTableBody');
    const completedRequests = requests.filter(r => r.status === 'completed' && r.category === currentSupervisor.category);
    
    document.getElementById('completedCount').textContent = completedRequests.length;
    
    if (completedRequests.length === 0) {
        tbody.innerHTML = '';
        document.getElementById('noCompleted').style.display = 'block';
        document.querySelector('#completedContent .input-container').style.display = 'none';
        return;
    }
    
    document.getElementById('noCompleted').style.display = 'none';
    document.querySelector('#completedContent .input-container').style.display = 'block';
    tbody.innerHTML = '';
    
    completedRequests.forEach((request, index) => {
        const row = document.createElement('tr');
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.25s ease forwards; animation-delay: ' + (index * 0.05) + 's; opacity: 0;';
        
        row.innerHTML = `
            <td style="padding: clamp(10px, 2.5vw, 14px);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(11px, 2.8vw, 13px); flex-shrink: 0;">${request.studentName.charAt(0)}</div>
                    <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.75rem, 2vw, 0.8125rem);">${request.studentName}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-weight: 600; font-size: clamp(0.75rem, 2vw, 0.8125rem);">${request.studentId}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-size: clamp(0.75rem, 2vw, 0.8125rem); white-space: nowrap;">
                <i class="fas fa-calendar" style="margin-left: 4px; color: var(--warning);"></i>
                ${request.requestDate}
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <span style="background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 4px 10px; border-radius: 10px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700; white-space: nowrap;">${request.grantedBy}</span>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <div style="background: rgba(79, 70, 229, 0.08); border-radius: 6px; padding: 6px;">
                    <span style="font-weight: 700; color: var(--primary); font-size: clamp(0.75rem, 2vw, 0.8125rem); font-family: monospace;">${request.requestCode}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: var(--secondary); font-weight: 700; font-size: clamp(0.75rem, 2vw, 0.8125rem); white-space: nowrap;">
                <i class="fas fa-check-circle" style="margin-left: 4px;"></i>
                ${request.completedAt}
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <span style="background: rgba(16, 185, 129, 0.1); color: var(--secondary); padding: 4px 10px; border-radius: 10px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700;">
                    <i class="fas fa-check" style="margin-left: 4px;"></i>
                    تم الرفع
                </span>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// تحميل جدول الطلبات المرفوضة
function loadRejectedTable() {
    const tbody = document.getElementById('rejectedTableBody');
    const rejectedRequests = requests.filter(r => r.status === 'rejected' && r.category === currentSupervisor.category);
    
    document.getElementById('rejectedCount').textContent = rejectedRequests.length;
    
    if (rejectedRequests.length === 0) {
        tbody.innerHTML = '';
        document.getElementById('noRejected').style.display = 'block';
        document.querySelector('#rejectedContent .input-container').style.display = 'none';
        return;
    }
    
    document.getElementById('noRejected').style.display = 'none';
    document.querySelector('#rejectedContent .input-container').style.display = 'block';
    tbody.innerHTML = '';
    
    rejectedRequests.forEach((request, index) => {
        const row = document.createElement('tr');
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.25s ease forwards; animation-delay: ' + (index * 0.05) + 's; opacity: 0;';
        
        row.innerHTML = `
            <td style="padding: clamp(10px, 2.5vw, 14px);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: linear-gradient(135deg, var(--danger), #dc2626); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(11px, 2.8vw, 13px); flex-shrink: 0;">${request.studentName.charAt(0)}</div>
                    <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.75rem, 2vw, 0.8125rem);">${request.studentName}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-weight: 600; font-size: clamp(0.75rem, 2vw, 0.8125rem);">${request.studentId}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <div style="background: rgba(79, 70, 229, 0.08); border-radius: 6px; padding: 6px;">
                    <span style="font-weight: 700; color: var(--primary); font-size: clamp(0.75rem, 2vw, 0.8125rem); font-family: monospace;">${request.requestCode}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: var(--danger); font-weight: 700; font-size: clamp(0.75rem, 2vw, 0.8125rem); white-space: nowrap;">
                <i class="fas fa-calendar-times" style="margin-left: 4px;"></i>
                ${request.rejectedAt}
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px);">
                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 8px; color: var(--danger); font-size: clamp(0.75rem, 2vw, 0.8125rem); line-height: 1.4;">
                    <i class="fas fa-exclamation-triangle" style="margin-left: 4px;"></i>
                    ${request.rejectReason}
                </div>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// مودال رفع الصورة
function openUploadModal(requestId) {
    const request = requests.find(r => r.id === requestId);
    if (!request) return;
    
    currentRequestId = requestId;
    document.getElementById('uploadStudentName').textContent = request.studentName;
    document.getElementById('uploadStudentId').textContent = request.studentId;
    document.getElementById('uploadRequestCode').textContent = request.requestCode;
    
    // إعادة تعيين حالة الرفع
    selectedImageFile = null;
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('dropZone').style.display = 'block';
    document.getElementById('confirmUploadBtn').disabled = true;
    
    document.getElementById('uploadModal').style.display = 'flex';
}

function closeUploadModal() {
    document.getElementById('uploadModal').style.display = 'none';
    currentRequestId = null;
    selectedImageFile = null;
}

// معالجة اختيار الصورة
function handleImageSelect(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    processImageFile(file);
}

// معالجة ملف الصورة
function processImageFile(file) {
    if (!file.type.startsWith('image/')) {
        showSmallToast('الرجاء اختيار ملف صورة', 'error');
        return;
    }
    
    if (file.size > 10 * 1024 * 1024) {
        showSmallToast('حجم الصورة يجب أن يكون أقل من 10 ميجابايت', 'error');
        return;
    }
    
    selectedImageFile = file;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('dropZone').style.display = 'none';
        document.getElementById('imagePreview').style.display = 'block';
        document.getElementById('confirmUploadBtn').disabled = false;
    };
    reader.readAsDataURL(file);
}

// مسح الصورة المختارة
function clearImage() {
    selectedImageFile = null;
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('dropZone').style.display = 'block';
    document.getElementById('confirmUploadBtn').disabled = true;
}

// تأكيد رفع الصورة
function confirmUploadImage() {
    if (!selectedImageFile || !currentRequestId) return;
    
    const request = requests.find(r => r.id === currentRequestId);
    if (!request) return;
    
    const now = new Date().toLocaleString('ar-SA');
    
    // تحديث حالة الطلب
    request.status = 'completed';
    request.completedAt = now;
    request.imageUploaded = true;
    request.imageUrl = document.getElementById('previewImg').src;
    
    // إضافة الصورة لاستديو الطالب (محاكاة)
    addImageToStudentStudio(request);
    
    addToLog({
        requestCode: request.requestCode,
        operation: 'رفع صورة',
        studentId: request.studentId,
        studentName: request.studentName,
        status: 'completed',
        performedBy: 'مكتب الأشعة',
        date: now,
        details: 'تم رفع صورة البانوراما وربطها بالطلب'
    });
    
    loadCompletedTable();
    loadAcceptedTable();
    closeUploadModal();
    showSmallToast('تم رفع الصورة بنجاح!', 'success');
}

// إضافة صورة لاستديو الطالب
function addImageToStudentStudio(request) {
    console.log(`تمت إضافة صورة بانوراما للطالب ${request.studentName} في الاستديو`);
}

// تحميل سجل العمليات
function loadLogTable() {
    const tbody = document.getElementById('logTableBody');
    tbody.innerHTML = '';
    
    const start = (logCurrentPage - 1) * ITEMS_PER_PAGE;
    const end = start + ITEMS_PER_PAGE;
    const pageRecords = operationsLog.slice(start, end);
    
    pageRecords.forEach((log, index) => {
        const row = document.createElement('tr');
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.25s ease forwards; animation-delay: ' + (index * 0.04) + 's; opacity: 0;';
        
        let statusColor = '';
        let statusBg = '';
        let statusText = '';
        
        switch(log.status) {
            case 'accepted':
                statusColor = '#10b981';
                statusBg = 'rgba(16, 185, 129, 0.1)';
                statusText = 'مقبول';
                break;
            case 'completed':
                statusColor = '#4f46e5';
                statusBg = 'rgba(79, 70, 229, 0.1)';
                statusText = 'منجز';
                break;
            case 'rejected':
                statusColor = '#ef4444';
                statusBg = 'rgba(239, 68, 68, 0.1)';
                statusText = 'مرفوض';
                break;
            default:
                statusColor = '#f59e0b';
                statusBg = 'rgba(245, 158, 11, 0.1)';
                statusText = 'معلق';
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
                <span style="background: ${log.operation === 'رفض طلب' ? 'rgba(239, 68, 68, 0.1)' : log.operation === 'رفع صورة' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(79, 70, 229, 0.1)'}; color: ${log.operation === 'رفض طلب' ? '#ef4444' : log.operation === 'رفع صورة' ? '#10b981' : 'var(--primary)'}; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700; white-space: nowrap;">
                    ${log.operation}
                </span>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <span style="background: ${statusBg}; color: ${statusColor}; padding: 4px 10px; border-radius: 12px; font-size: clamp(0.6875rem, 1.8vw, 0.75rem); font-weight: 700; white-space: nowrap;">
                    ${statusText}
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
    
    updatePagination('log', operationsLog.length, logCurrentPage);
}

// تحديث أزرار الترقيم
function updatePagination(type, totalItems, currentPage) {
    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE) || 1;
    const indicator = document.getElementById(type + 'PageIndicator');
    const prevBtn = document.getElementById(type + 'PrevBtn');
    const nextBtn = document.getElementById(type + 'NextBtn');
    
    indicator.textContent = `صفحة ${currentPage} من ${totalPages}`;
    
    prevBtn.disabled = currentPage === 1;
    prevBtn.style.opacity = currentPage === 1 ? '0.5' : '1';
    prevBtn.style.cursor = currentPage === 1 ? 'not-allowed' : 'pointer';
    
    nextBtn.disabled = currentPage >= totalPages;
    nextBtn.style.opacity = currentPage >= totalPages ? '0.5' : '1';
    nextBtn.style.cursor = currentPage >= totalPages ? 'not-allowed' : 'pointer';
    nextBtn.style.background = currentPage >= totalPages ? '#e5e7eb' : 'linear-gradient(135deg, var(--primary), var(--primary-light))';
}

// تغيير صفحة السجل
function changeLogPage(direction) {
    const totalPages = Math.ceil(operationsLog.length / ITEMS_PER_PAGE) || 1;
    
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

// التنقل بين التبويبات
function switchTab(tabName) {
    document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');
    document.getElementById(tabName + 'Content').style.display = 'block';
    
    if (tabName === 'accepted') {
        loadAcceptedTable();
    } else if (tabName === 'completed') {
        loadCompletedTable();
    } else if (tabName === 'rejected') {
        loadRejectedTable();
    } else if (tabName === 'log') {
        logCurrentPage = 1;
        loadLogTable();
    }
}

// Toast
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

// إغلاق المودالات بالنقر خارجها
document.addEventListener('click', function(e) {
    if (e.target.id === 'rejectModal') closeRejectModal();
    if (e.target.id === 'uploadModal') closeUploadModal();
});

// السحب والإفلات
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    
    if (dropZone) {
        dropZone.addEventListener('click', () => document.getElementById('imageInput').click());
        
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--secondary)';
            dropZone.style.background = 'rgba(16, 185, 129, 0.05)';
        });
        
        dropZone.addEventListener('dragleave', () => {
            dropZone.style.borderColor = '#d1d5db';
            dropZone.style.background = '#f9fafb';
        });
        
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#d1d5db';
            dropZone.style.background = '#f9fafb';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                processImageFile(files[0]);
            }
        });
    }
    
    // تحميل البيانات الأولية
    loadAcceptedTable();
    loadCompletedTable();
    loadRejectedTable();
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

/* تحسين منطقة السحب والإفلات */
#dropZone:hover {
    border-color: var(--secondary);
    background: rgba(16, 185, 129, 0.05);
}

/* تحسين معاينة الصورة */
#previewImg {
    max-height: 200px;
    object-fit: contain;
}

/* تحسين التبويبات */
.tab-item {
    font-size: clamp(0.75rem, 2vw, 0.875rem);
    padding: clamp(8px, 2vw, 10px) clamp(12px, 3vw, 16px);
}

/* تحسين العناوين */
.section-title {
    margin-bottom: clamp(10px, 2.5vw, 14px);
}

/* تأثير hover على صفوف الجدول */
.cases-table tbody tr:hover {
    background: rgba(79, 70, 229, 0.03);
    transform: scale(1.01);
    transition: all 0.2s ease;
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

/* تحسين الجداول */
.cases-table th,
.cases-table td {
    font-size: clamp(0.75rem, 2vw, 0.875rem);
    vertical-align: middle;
}

/* تحسين أزرار الترقيم */
#logPagination button {
    transition: all 0.2s ease;
}

#logPagination button:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* تحسين عرض الجداول على الموبايل */
@media (max-width: 768px) {
    .cases-table {
        font-size: clamp(0.6875rem, 1.8vw, 0.8125rem);
    }
    
    .cases-table th,
    .cases-table td {
        padding: clamp(8px, 2vw, 10px) clamp(6px, 1.5vw, 8px);
    }
}

/* تأثيرات حالات الطلب */
.status-pending { color: var(--warning); }
.status-accepted { color: var(--secondary); }
.status-completed { color: var(--primary); }
.status-rejected { color: var(--danger); }
</style>

