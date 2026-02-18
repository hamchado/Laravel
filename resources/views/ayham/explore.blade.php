@extends('layouts.app')

@section('title', 'لوحة تحكم المشرف - QR')
@section('page_title', 'لوحة تحكم المشرف')

@section('tabs')
<div class="tab-item active" onclick="switchTab('qr')">
    <i class="fas fa-qrcode" style="margin-left: 4px;"></i>
    QR
</div>
<div class="tab-item" onclick="switchTab('history')">
    <i class="fas fa-history" style="margin-left: 4px;"></i>
    السجل
</div>
@endsection

@section('tab_content')
<!-- تبويب QR Scanner -->
<div class="tab-content" id="qrContent" style="display: block;">
    <div class="section-title" style="margin-top: clamp(12px, 3vw, 20px); font-size: clamp(0.875rem, 2.5vw, 1.125rem);">
        <i class="fas fa-qrcode" style="color: var(--primary);"></i>
        <span>فحص QR الحالة</span>
    </div>

    <div class="input-container" style="text-align: center; padding: clamp(24px, 6vw, 48px) clamp(16px, 4vw, 24px);">
        <div style="width: clamp(72px, 18vw, 120px); height: clamp(72px, 18vw, 120px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: clamp(16px, 4vw, 24px); display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(16px, 4vw, 24px); box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);">
            <i class="fas fa-qrcode" style="font-size: clamp(32px, 8vw, 56px); color: white;"></i>
        </div>
        <h3 style="font-size: clamp(1rem, 3vw, 1.5rem); color: var(--dark); margin-bottom: 8px; font-weight: 700;">فحص رمز QR</h3>
        <p style="color: var(--gray); font-size: clamp(0.8125rem, 2.2vw, 1rem); margin-bottom: clamp(20px, 5vw, 28px); line-height: 1.6;">قم بتشغيل الكاميرا لمسح رمز QR الخاص بالحالة</p>
        
        <button onclick="startQRScanner()" id="startQRBtn" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: clamp(14px, 3.5vw, 18px) clamp(28px, 7vw, 44px); border-radius: clamp(10px, 2.5vw, 14px); font-size: clamp(0.9375rem, 2.8vw, 1.25rem); font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35); transition: all 0.3s; font-family: 'Tajawal', sans-serif;">
            <i class="fas fa-camera"></i>
            تشغيل الكاميرا
        </button>
    </div>

    <!-- مودال الكاميرا -->
    <div id="qrScannerModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.95); z-index: 99999; flex-direction: column;">
        <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: clamp(14px, 3.5vw, 18px); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; font-size: clamp(0.9375rem, 2.8vw, 1.25rem); font-weight: 700; margin: 0;">
                <i class="fas fa-camera" style="margin-left: 8px;"></i>
                وجه الكاميرا نحو QR
            </h3>
            <button onclick="stopQRScanner()" style="background: rgba(255,255,255,0.2); border: none; width: clamp(36px, 9vw, 40px); height: clamp(36px, 9vw, 40px); border-radius: 50%; color: white; cursor: pointer; font-size: clamp(16px, 4vw, 18px); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: clamp(16px, 4vw, 20px);">
            <div id="qr-reader" style="width: 100%; max-width: 480px; border-radius: clamp(12px, 3vw, 16px); overflow: hidden;"></div>
        </div>
        <div style="padding: clamp(16px, 4vw, 20px); text-align: center; color: white; background: rgba(0,0,0,0.5);">
            <p style="font-size: clamp(0.8125rem, 2.2vw, 1rem); margin: 0;">
                <i class="fas fa-info-circle" style="margin-left: 8px; color: var(--warning);"></i>
                سيتم فحص الرمز تلقائياً عندما تضع الكاميرا أمامه
            </p>
        </div>
    </div>
</div>

<!-- تبويب السجل -->
<div class="tab-content" id="historyContent" style="display: none;">
    <div class="section-title" style="margin-top: clamp(12px, 3vw, 20px); font-size: clamp(0.875rem, 2.5vw, 1.125rem);">
        <i class="fas fa-history" style="color: var(--primary);"></i>
        <span>سجل الحالات</span>
    </div>

    <div class="input-container" style="padding: 0; overflow: hidden;">
        <div style="padding: clamp(16px, 4vw, 20px); background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.05)); border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <h3 style="font-size: clamp(0.9375rem, 2.8vw, 1.125rem); color: var(--dark); margin: 0; font-weight: 700;">
                <i class="fas fa-clipboard-list" style="color: var(--primary); margin-left: 8px;"></i>
                سجل العمليات
            </h3>
            <span id="totalRecords" style="background: white; color: var(--primary); padding: 6px 14px; border-radius: 20px; font-size: clamp(0.75rem, 2vw, 0.875rem); font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">0 سجل</span>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="cases-table" style="min-width: 900px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-user" style="margin-left: 6px; color: var(--primary);"></i>
                            المريض
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-tooth" style="margin-left: 6px; color: var(--primary);"></i>
                            السن
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-tag" style="margin-left: 6px; color: var(--primary);"></i>
                            نوع الحالة
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: right; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-user-graduate" style="margin-left: 6px; color: var(--primary);"></i>
                            الطالب
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-hashtag" style="margin-left: 6px; color: var(--primary);"></i>
                            الجامعي
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-info-circle" style="margin-left: 6px; color: var(--primary);"></i>
                            الحالة
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-star" style="margin-left: 6px; color: var(--primary);"></i>
                            التقييمات
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-user-md" style="margin-left: 6px; color: var(--primary);"></i>
                            المشرف
                        </th>
                        <th style="padding: clamp(10px, 2.5vw, 14px); text-align: center; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; color: var(--dark); border-bottom: 2px solid #e5e7eb; white-space: nowrap;">
                            <i class="fas fa-clock" style="margin-left: 6px; color: var(--primary);"></i>
                            التاريخ
                        </th>
                    </tr>
                </thead>
                <tbody id="historyTableBody">
                    <!-- سيتم ملؤها بالJavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- ترقيم الصفحات -->
        <div id="historyPagination" style="display: flex; justify-content: center; align-items: center; gap: 12px; padding: clamp(16px, 4vw, 20px); border-top: 1px solid #e5e7eb;">
            <button onclick="changeHistoryPage('prev')" id="historyPrevBtn" style="background: white; border: 2px solid #e5e7eb; color: #64748b; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; font-size: clamp(0.75rem, 2vw, 0.875rem);">
                <i class="fas fa-chevron-right"></i>
                السابق
            </button>
            <span id="historyPageIndicator" style="font-weight: 700; color: var(--primary); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">صفحة 1 من 1</span>
            <button onclick="changeHistoryPage('next')" id="historyNextBtn" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; padding: clamp(10px, 2.5vw, 12px) clamp(16px, 4vw, 20px); border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); font-size: clamp(0.75rem, 2vw, 0.875rem);">
                التالي
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
@endsection

<!-- مودال تفاصيل الحالة (يظهر بعد فحص QR) -->
<div id="caseModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 99999; justify-content: center; align-items: center; padding: 16px; overflow-y: auto;">
    <div style="background: white; border-radius: clamp(16px, 4vw, 24px); width: 100%; max-width: 600px; max-height: 95vh; overflow-y: auto; animation: modalPop 0.3s ease;">
        <!-- تفاصيل الحالة -->
        <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: clamp(24px, 6vw, 32px); text-align: center; position: relative;">
            <button onclick="closeCaseModal()" style="position: absolute; top: clamp(16px, 4vw, 20px); left: clamp(16px, 4vw, 20px); background: rgba(255,255,255,0.2); border: none; width: clamp(40px, 10vw, 44px); height: clamp(40px, 10vw, 44px); border-radius: 50%; color: white; cursor: pointer; font-size: clamp(18px, 4.5vw, 20px); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
            <div style="width: clamp(80px, 20vw, 100px); height: clamp(80px, 20vw, 100px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(16px, 4vw, 20px); backdrop-filter: blur(10px);">
                <i class="fas fa-tooth" style="font-size: clamp(36px, 9vw, 48px); color: white;"></i>
            </div>
            <h2 style="color: white; font-size: clamp(1.25rem, 4vw, 1.75rem); font-weight: 800; margin-bottom: 8px;">تفاصيل الحالة</h2>
            <p style="color: rgba(255,255,255,0.9); font-size: clamp(0.9375rem, 2.8vw, 1.125rem); margin: 0;">رقم السن: <span id="modalToothNumber" style="font-weight: 700;">-</span> | نوع الحالة: <span id="modalCaseType" style="font-weight: 700;">-</span></p>
        </div>

        <div style="padding: clamp(20px, 5vw, 28px);">
            <!-- معلومات المريض والطالب -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: clamp(12px, 3vw, 16px); margin-bottom: clamp(20px, 5vw, 24px);">
                <div style="background: #f8fafc; padding: clamp(16px, 4vw, 20px); border-radius: 12px; text-align: center;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); color: var(--gray); margin-bottom: 6px;">اسم المريض</div>
                    <div id="modalPatientName" style="font-weight: 700; color: var(--dark); font-size: clamp(1rem, 3vw, 1.25rem);">-</div>
                </div>
                <div style="background: #f8fafc; padding: clamp(16px, 4vw, 20px); border-radius: 12px; text-align: center;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); color: var(--gray); margin-bottom: 6px;">الطالب</div>
                    <div id="modalStudentName" style="font-weight: 700; color: var(--dark); font-size: clamp(1rem, 3vw, 1.25rem);">-</div>
                </div>
                <div style="background: #f8fafc; padding: clamp(16px, 4vw, 20px); border-radius: 12px; text-align: center;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); color: var(--gray); margin-bottom: 6px;">رقم الجامعة</div>
                    <div id="modalStudentId" style="font-weight: 700; color: var(--primary); font-size: clamp(1.125rem, 3.5vw, 1.5rem);">-</div>
                </div>
                <div style="background: #f8fafc; padding: clamp(16px, 4vw, 20px); border-radius: 12px; text-align: center;">
                    <div style="font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); color: var(--gray); margin-bottom: 6px;">حالة الحالة</div>
                    <div id="modalCaseStatus" style="font-weight: 700; font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">-</div>
                </div>
            </div>

            <!-- أزرار الإجراء للحالة الجديدة -->
            <div id="modalNewActions" style="margin-bottom: clamp(16px, 4vw, 20px);">
                <h3 style="font-size: clamp(1rem, 3vw, 1.25rem); color: var(--dark); margin-bottom: clamp(16px, 4vw, 20px); font-weight: 700; text-align: center;">
                    <i class="fas fa-tasks" style="color: var(--primary); margin-left: 8px;"></i>
                    اختر الإجراء المناسب
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: clamp(12px, 3vw, 16px);">
                    <!-- قبول الحالة فقط -->
                    <button onclick="acceptCaseOnly()" style="background: linear-gradient(135deg, var(--secondary), #059669); color: white; border: none; padding: clamp(18px, 4.5vw, 22px); border-radius: clamp(14px, 3.5vw, 16px); font-size: clamp(1rem, 3vw, 1.25rem); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35); transition: all 0.3s; font-family: 'Tajawal', sans-serif;">
                        <i class="fas fa-check-circle" style="font-size: clamp(20px, 5vw, 24px);"></i>
                        قبول الحالة فقط
                        <span style="font-size: clamp(0.75rem, 2vw, 0.875rem); opacity: 0.9; font-weight: 500;">(إغلاق الحالة بدون تقييم)</span>
                    </button>

                    <!-- قبول وتقييم -->
                    <button onclick="acceptAndEvaluate()" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: clamp(18px, 4.5vw, 22px); border-radius: clamp(14px, 3.5vw, 16px); font-size: clamp(1rem, 3vw, 1.25rem); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35); transition: all 0.3s; font-family: 'Tajawal', sans-serif;">
                        <i class="fas fa-star" style="font-size: clamp(20px, 5vw, 24px);"></i>
                        قبول وبدء التقييم
                        <span style="font-size: clamp(0.75rem, 2vw, 0.875rem); opacity: 0.9; font-weight: 500;">(فتح نموذج التقييم)</span>
                    </button>

                    <!-- رفض وتغيير العلاج -->
                    <button onclick="showChangeTreatmentModal()" style="background: linear-gradient(135deg, var(--danger), #dc2626); color: white; border: none; padding: clamp(18px, 4.5vw, 22px); border-radius: clamp(14px, 3.5vw, 16px); font-size: clamp(1rem, 3vw, 1.25rem); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35); transition: all 0.3s; font-family: 'Tajawal', sans-serif;">
                        <i class="fas fa-exchange-alt" style="font-size: clamp(20px, 5vw, 24px);"></i>
                        رفض وتغيير العلاج
                        <span style="font-size: clamp(0.75rem, 2vw, 0.875rem); opacity: 0.9; font-weight: 500;">(اختيار علاج آخر)</span>
                    </button>
                </div>
            </div>

            <!-- قسم التقييم (يظهر فقط عند اختيار "قبول وتقييم") -->
            <div id="modalRatingSection" style="display: none;">
                <div style="background: #f8fafc; border-radius: clamp(12px, 3vw, 16px); padding: clamp(20px, 5vw, 28px); border: 2px solid #e5e7eb;">
                    <h3 style="font-size: clamp(1.125rem, 3.5vw, 1.5rem); color: var(--dark); margin-bottom: clamp(20px, 5vw, 24px); font-weight: 700; text-align: center;">
                        <i class="fas fa-star" style="color: var(--warning); margin-left: 8px;"></i>
                        التقييم التدريجي للحالة
                    </h3>

                    <!-- المرحلة 1 -->
                    <div id="modalRating1Container" style="margin-bottom: clamp(20px, 5vw, 24px);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div id="modalRating1Badge" style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(14px, 3.5vw, 16px);">1</div>
                            <span style="font-weight: 700; color: var(--dark); font-size: clamp(1rem, 3vw, 1.25rem);">التقييم الأول</span>
                            <span id="modalRating1Status" style="background: rgba(245, 158, 11, 0.15); color: var(--warning); padding: 6px 14px; border-radius: 20px; font-size: clamp(0.75rem, 2vw, 0.875rem); font-weight: 600;">متاح</span>
                        </div>
                        <div id="modalRating1Inputs" style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <button onclick="selectRating(1, 'A+')" class="modal-rating-btn" data-rating="1" data-grade="A+" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A+</button>
                            <button onclick="selectRating(1, 'A')" class="modal-rating-btn" data-rating="1" data-grade="A" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A</button>
                            <button onclick="selectRating(1, 'A-')" class="modal-rating-btn" data-rating="1" data-grade="A-" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A-</button>
                            <button onclick="selectRating(1, 'B+')" class="modal-rating-btn" data-rating="1" data-grade="B+" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">B+</button>
                            <button onclick="selectRating(1, 'percentage')" class="modal-rating-btn" data-rating="1" data-grade="percentage" style="flex: 1; min-width: 80px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">%</button>
                        </div>
                        <div id="modalPercentage1Input" style="display: none; margin-top: 14px;">
                            <input type="number" id="modalPercent1" placeholder="أدخل النسبة المئوية (0-100)" min="0" max="100" style="width: 100%; padding: clamp(14px, 3.5vw, 16px); border: 2px solid #e5e7eb; border-radius: 12px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">
                        </div>
                    </div>

                    <!-- المرحلة 2 -->
                    <div id="modalRating2Container" style="margin-bottom: clamp(20px, 5vw, 24px);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div id="modalRating2Badge" style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: var(--gray); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(14px, 3.5vw, 16px);">2</div>
                            <span style="font-weight: 700; color: var(--dark); font-size: clamp(1rem, 3vw, 1.25rem);">التقييم الثاني</span>
                            <span id="modalRating2Status" style="background: #f3f4f6; color: #9ca3af; padding: 6px 14px; border-radius: 20px; font-size: clamp(0.75rem, 2vw, 0.875rem); font-weight: 600;">معلق</span>
                        </div>
                        <div id="modalRating2Inputs" style="display: flex; gap: 10px; flex-wrap: wrap; opacity: 0.5; pointer-events: none;">
                            <button onclick="selectRating(2, 'A+')" class="modal-rating-btn" data-rating="2" data-grade="A+" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A+</button>
                            <button onclick="selectRating(2, 'A')" class="modal-rating-btn" data-rating="2" data-grade="A" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A</button>
                            <button onclick="selectRating(2, 'A-')" class="modal-rating-btn" data-rating="2" data-grade="A-" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A-</button>
                            <button onclick="selectRating(2, 'B+')" class="modal-rating-btn" data-rating="2" data-grade="B+" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">B+</button>
                            <button onclick="selectRating(2, 'percentage')" class="modal-rating-btn" data-rating="2" data-grade="percentage" style="flex: 1; min-width: 80px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">%</button>
                        </div>
                        <div id="modalPercentage2Input" style="display: none; margin-top: 14px;">
                            <input type="number" id="modalPercent2" placeholder="أدخل النسبة المئوية (0-100)" min="0" max="100" style="width: 100%; padding: clamp(14px, 3.5vw, 16px); border: 2px solid #e5e7eb; border-radius: 12px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">
                        </div>
                    </div>

                    <!-- المرحلة 3 -->
                    <div id="modalRating3Container" style="margin-bottom: clamp(20px, 5vw, 24px);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div id="modalRating3Badge" style="width: clamp(32px, 8vw, 36px); height: clamp(32px, 8vw, 36px); background: var(--gray); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(14px, 3.5vw, 16px);">3</div>
                            <span style="font-weight: 700; color: var(--dark); font-size: clamp(1rem, 3vw, 1.25rem);">التقييم الثالث (النهائي)</span>
                            <span id="modalRating3Status" style="background: #f3f4f6; color: #9ca3af; padding: 6px 14px; border-radius: 20px; font-size: clamp(0.75rem, 2vw, 0.875rem); font-weight: 600;">معلق</span>
                        </div>
                        <div id="modalRating3Inputs" style="display: flex; gap: 10px; flex-wrap: wrap; opacity: 0.5; pointer-events: none;">
                            <button onclick="selectRating(3, 'A+')" class="modal-rating-btn" data-rating="3" data-grade="A+" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A+</button>
                            <button onclick="selectRating(3, 'A')" class="modal-rating-btn" data-rating="3" data-grade="A" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A</button>
                            <button onclick="selectRating(3, 'A-')" class="modal-rating-btn" data-rating="3" data-grade="A-" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">A-</button>
                            <button onclick="selectRating(3, 'B+')" class="modal-rating-btn" data-rating="3" data-grade="B+" style="flex: 1; min-width: 60px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">B+</button>
                            <button onclick="selectRating(3, 'percentage')" class="modal-rating-btn" data-rating="3" data-grade="percentage" style="flex: 1; min-width: 80px; padding: clamp(12px, 3vw, 14px); border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(0.875rem, 2.5vw, 1rem); transition: all 0.2s;">%</button>
                        </div>
                        <div id="modalPercentage3Input" style="display: none; margin-top: 14px;">
                            <input type="number" id="modalPercent3" placeholder="أدخل النسبة المئوية (0-100)" min="0" max="100" style="width: 100%; padding: clamp(14px, 3.5vw, 16px); border: 2px solid #e5e7eb; border-radius: 12px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.9375rem, 2.8vw, 1.125rem);">
                        </div>
                    </div>

                    <!-- Dropdown العلاج المقترح (يظهر فقط عند الوصول للتقييم 3) -->
                    <div id="proposedTreatmentSection" style="display: none; margin-top: clamp(24px, 6vw, 32px); padding-top: clamp(24px, 6vw, 32px); border-top: 2px dashed #e5e7eb; background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), rgba(251, 191, 36, 0.05)); padding: clamp(20px, 5vw, 24px); border-radius: 12px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                            <i class="fas fa-exclamation-circle" style="color: var(--warning); font-size: clamp(20px, 5vw, 24px);"></i>
                            <h4 style="font-size: clamp(1rem, 3vw, 1.25rem); color: var(--dark); margin: 0; font-weight: 700;">العلاج المقترح للمريض</h4>
                        </div>
                        <p style="color: var(--gray); font-size: clamp(0.8125rem, 2.2vw, 1rem); margin-bottom: 16px; line-height: 1.6;">
                            <i class="fas fa-info-circle" style="margin-left: 6px; color: var(--primary);"></i>
                            هذا الخيار يظهر فقط عند اكتمال التقييم النهائي. اختر العلاج المناسب للمريض أو اختر "لا يوجد" إذا انتهت الحالة.
                        </p>
                        
                        <div class="custom-dropdown" id="proposedTreatmentDropdown">
                            <div class="dropdown-header" onclick="toggleDropdown('proposedTreatmentDropdown')" style="font-size: clamp(0.9375rem, 2.8vw, 1.125rem); border: 2px solid var(--warning); border-radius: 12px; padding: clamp(14px, 3.5vw, 16px); background: white; font-weight: 600;">
                                <span id="proposedTreatmentText" style="color: var(--warning);">
                                    <i class="fas fa-hand-pointer" style="margin-left: 8px;"></i>
                                    اختر العلاج المناسب...
                                </span>
                                <i class="fas fa-chevron-down dropdown-icon" style="color: var(--warning);"></i>
                            </div>
                            <div class="dropdown-options">
                                <div class="dropdown-option" onclick="selectProposedTreatment('لا يوجد - الحالة انتهت')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 32px; height: 32px; background: var(--gray); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">لا يوجد - الحالة انتهت</div>
                                            <div style="font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); color: var(--gray);">لا يحتاج علاجاً إضافياً</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-option" onclick="selectProposedTreatment('حشوة تجميلية')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                            <i class="fas fa-tooth"></i>
                                        </div>
                                        <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">حشوة تجميلية</div>
                                    </div>
                                </div>
                                <div class="dropdown-option" onclick="selectProposedTreatment('علاج عصب')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                            <i class="fas fa-procedures"></i>
                                        </div>
                                        <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">علاج عصب</div>
                                    </div>
                                </div>
                                <div class="dropdown-option" onclick="selectProposedTreatment('تقويم أسنان')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--accent), #f472b6); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                            <i class="fas fa-teeth"></i>
                                        </div>
                                        <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">تقويم أسنان</div>
                                    </div>
                                </div>
                                <div class="dropdown-option" onclick="selectProposedTreatment('خلع سن')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                            <i class="fas fa-tooth"></i>
                                        </div>
                                        <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">خلع سن</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button onclick="submitRatings()" id="modalSubmitRatingsBtn" style="width: 100%; margin-top: clamp(24px, 6vw, 32px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: clamp(18px, 4.5vw, 22px); border-radius: clamp(14px, 3.5vw, 16px); font-size: clamp(1rem, 3vw, 1.25rem); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35); font-family: 'Tajawal', sans-serif; transition: all 0.3s;">
                        <i class="fas fa-save" style="font-size: clamp(18px, 4.5vw, 22px);"></i>
                        حفظ التقييمات وإغلاق الحالة
                    </button>
                </div>
            </div>

            <!-- رسالة الإنجاز -->
            <div id="modalCompletionMessage" style="display: none; background: linear-gradient(135deg, var(--secondary), #059669); color: white; border-radius: clamp(16px, 4vw, 20px); padding: clamp(32px, 8vw, 40px); text-align: center;">
                <div style="width: clamp(90px, 22vw, 120px); height: clamp(90px, 22vw, 120px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(20px, 5vw, 24px); animation: pulse 2s infinite;">
                    <i class="fas fa-check-double" style="font-size: clamp(40px, 10vw, 56px);"></i>
                </div>
                <h3 style="font-size: clamp(1.5rem, 4.5vw, 2rem); font-weight: 800; margin-bottom: 12px;">تم إنجاز الحالة بنجاح!</h3>
                <p style="font-size: clamp(1rem, 3vw, 1.25rem); opacity: 0.95; margin-bottom: 24px;">تم تقييم جميع المراحل وحفظ البيانات</p>
                <button onclick="closeCaseModal(); switchTab('qr');" style="background: white; color: var(--secondary); border: none; padding: clamp(16px, 4vw, 20px) clamp(32px, 8vw, 48px); border-radius: 12px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(1rem, 3vw, 1.25rem); box-shadow: 0 4px 14px rgba(0,0,0,0.15);">
                    <i class="fas fa-qrcode" style="margin-left: 10px;"></i>
                    فحص حالة جديدة
                </button>
            </div>
        </div>
    </div>
</div>

<!-- مودال تغيير العلاج -->
<div id="changeTreatmentModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 100000; justify-content: center; align-items: center; padding: 16px;">
    <div style="background: white; border-radius: clamp(16px, 4vw, 24px); width: 100%; max-width: 480px; max-height: 90vh; overflow-y: auto; animation: modalPop 0.3s ease;">
        <div style="background: linear-gradient(135deg, var(--danger), #dc2626); padding: clamp(24px, 6vw, 32px); text-align: center;">
            <div style="width: clamp(70px, 17vw, 90px); height: clamp(70px, 17vw, 90px); background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto clamp(16px, 4vw, 20px);">
                <i class="fas fa-exchange-alt" style="font-size: clamp(32px, 8vw, 40px); color: white;"></i>
            </div>
            <h3 style="color: white; font-size: clamp(1.25rem, 4vw, 1.75rem); font-weight: 800; margin: 0;">تغيير نوع العلاج</h3>
        </div>
        
        <div style="padding: clamp(24px, 6vw, 32px);">
            <div style="background: #fef2f2; border: 2px solid #fecaca; border-radius: 16px; padding: clamp(18px, 4.5vw, 22px); margin-bottom: 24px;">
                <div style="font-size: clamp(0.8125rem, 2.2vw, 1rem); color: var(--danger); margin-bottom: 8px; font-weight: 700;">
                    <i class="fas fa-exclamation-triangle" style="margin-left: 8px;"></i>
                    سيتم رفض الحالة الحالية
                </div>
                <div style="font-weight: 600; color: var(--gray); font-size: clamp(0.875rem, 2.5vw, 1rem); margin-bottom: 4px;">العلاج الحالي:</div>
                <div id="currentTreatment" style="font-weight: 800; color: var(--dark); font-size: clamp(1.125rem, 3.5vw, 1.5rem);">-</div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; color: var(--dark); margin-bottom: 12px; font-size: clamp(1rem, 3vw, 1.25rem);">
                    <i class="fas fa-hand-holding-medical" style="color: var(--danger); margin-left: 8px;"></i>
                    اختر نوع العلاج الجديد
                </label>
                <div class="custom-dropdown" id="treatmentDropdown">
                    <div class="dropdown-header" onclick="toggleDropdown('treatmentDropdown')" style="font-size: clamp(0.9375rem, 2.8vw, 1.125rem); border: 2px solid #e5e7eb; border-radius: 14px; padding: clamp(14px, 3.5vw, 16px);">
                        <span id="selectedTreatmentText">اختر نوع العلاج...</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option" onclick="selectTreatment('حشوة تجميلية')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                    <i class="fas fa-tooth"></i>
                                </div>
                                <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">حشوة تجميلية</div>
                            </div>
                        </div>
                        <div class="dropdown-option" onclick="selectTreatment('علاج عصب')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                    <i class="fas fa-procedures"></i>
                                </div>
                                <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">علاج عصب</div>
                            </div>
                        </div>
                        <div class="dropdown-option" onclick="selectTreatment('تقويم أسنان')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--accent), #f472b6); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                    <i class="fas fa-teeth"></i>
                                </div>
                                <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">تقويم أسنان</div>
                            </div>
                        </div>
                        <div class="dropdown-option" onclick="selectTreatment('خلع سن')" style="font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                    <i class="fas fa-tooth"></i>
                                </div>
                                <div style="font-weight: 600; color: var(--dark); font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);">خلع سن</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 28px;">
                <label style="display: block; font-weight: 700; color: var(--dark); margin-bottom: 12px; font-size: clamp(1rem, 3vw, 1.25rem);">
                    <i class="fas fa-comment-alt" style="color: var(--danger); margin-left: 8px;"></i>
                    سبب التغيير <span style="color: var(--danger);">*</span>
                </label>
                <textarea id="changeReason" rows="4" placeholder="اكتب سبب تغيير نوع العلاج بالتفصيل..." style="width: 100%; padding: clamp(14px, 3.5vw, 16px); border: 2px solid #e5e7eb; border-radius: 14px; font-family: 'Tajawal', sans-serif; font-size: clamp(0.9375rem, 2.8vw, 1.125rem); resize: vertical; min-height: 100px;"></textarea>
            </div>

            <div style="display: flex; gap: 14px;">
                <button onclick="closeChangeTreatmentModal()" style="flex: 1; background: var(--gray-light); color: var(--gray-dark); border: none; padding: clamp(16px, 4vw, 18px); border-radius: 14px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; font-size: clamp(1rem, 3vw, 1.125rem); transition: all 0.2s;">
                    إلغاء
                </button>
                <button onclick="confirmChangeTreatment()" id="confirmChangeBtn" disabled style="flex: 1; background: #e5e7eb; color: #9ca3af; border: none; padding: clamp(16px, 4vw, 18px); border-radius: 14px; font-weight: 700; cursor: not-allowed; font-family: 'Tajawal', sans-serif; font-size: clamp(1rem, 3vw, 1.125rem); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-check"></i>
                    تأكيد التغيير
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tooltip للتاريخ - يظل ثابتاً عند التمرير -->
<div id="ratingTooltip" style="display: none; position: fixed; background: var(--dark); color: white; padding: 10px 16px; border-radius: 10px; font-size: clamp(0.75rem, 2vw, 0.875rem); z-index: 100001; box-shadow: 0 4px 16px rgba(0,0,0,0.25); white-space: nowrap; font-weight: 600; pointer-events: none; max-width: 250px; text-align: center;">
    <div style="position: absolute; bottom: -8px; right: 50%; transform: translateX(50%); width: 0; height: 0; border-left: 8px solid transparent; border-right: 8px solid transparent; border-top: 8px solid var(--dark);"></div>
</div>

<!-- مكتبة QR Scanner -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
// المتغيرات العامة
let html5QrCode = null;
let currentCase = null;
let currentRatings = { 1: null, 2: null, 3: null };
let selectedTreatment = null;
let proposedTreatment = null;
let historyCurrentPage = 1;
const historyItemsPerPage = 10;
let activeTooltip = null;

// بيانات وهمية للاختبار
const mockCases = {
    'QR001': {
        patientName: 'أحمد محمد علي',
        toothNumber: '12',
        studentName: 'محمد أحمد',
        studentId: '20214587',
        caseType: 'حشوة تجميلية',
        supervisor: 'د. أحمد النجار',
        status: 'pending',
        ratings: { 1: null, 2: null, 3: null }
    },
    'QR002': {
        patientName: 'سارة خالد',
        toothNumber: '24',
        studentName: 'سارة خالد يوسف',
        studentId: '20216732',
        caseType: 'تقويم أسنان',
        supervisor: 'د. أحمد النجار',
        status: 'accepted',
        ratings: { 1: null, 2: null, 3: null }
    }
};

const acceptedCases = {};

const historyRecords = [
    { id: 1, patient: 'أحمد محمد علي', tooth: '12', type: 'حشوة تجميلية', student: 'محمد أحمد', studentId: '20214587', status: 'completed', ratings: 3, ratingDates: ['2024-01-15 10:00', '2024-01-15 10:30', '2024-01-15 11:00'], supervisor: 'د. أحمد النجار', date: '2024-01-15 10:30' },
    { id: 2, patient: 'سارة خالد', tooth: '24', type: 'تقويم أسنان', student: 'سارة خالد', studentId: '20216732', status: 'inProgress', ratings: 1, ratingDates: ['2024-01-14 14:20', null, null], supervisor: 'د. أحمد النجار', date: '2024-01-14 14:20' },
    { id: 3, patient: 'عمر محمود', tooth: '18', type: 'علاج عصب', student: 'عمر محمود', studentId: '20219854', status: 'rejected', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. أحمد النجار', date: '2024-01-13 09:15', reason: 'خطأ في التشخيص' },
    { id: 4, patient: 'فاطمة سالم', tooth: '14', type: 'حشوة تجميلية', student: 'فاطمة سالم', studentId: '20215678', status: 'changed', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. أحمد النجار', date: '2024-01-12 11:45', reason: 'تسوس عميق', newType: 'علاج عصب' }
];

// ========== QR Scanner Functions ==========
function startQRScanner() {
    const modal = document.getElementById('qrScannerModal');
    modal.style.display = 'flex';
    
    html5QrCode = new Html5Qrcode("qr-reader");
    
    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        onScanSuccess,
        onScanFailure
    ).catch(err => {
        showToast('خطأ في تشغيل الكاميرا: ' + err, 'error');
    });
}

function stopQRScanner() {
    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            html5QrCode.clear();
            html5QrCode = null;
        });
    }
    document.getElementById('qrScannerModal').style.display = 'none';
}

function onScanSuccess(decodedText, decodedResult) {
    stopQRScanner();
    
    let caseData = mockCases[decodedText];
    
    if (!caseData) {
        caseData = {
            patientName: 'مريض ' + decodedText,
            toothNumber: '16',
            studentName: 'طالب ' + decodedText,
            studentId: '2021' + Math.floor(Math.random() * 10000),
            caseType: 'حالة أسنان',
            supervisor: 'د. أحمد النجار',
            status: 'pending',
            ratings: { 1: null, 2: null, 3: null }
        };
    }
    
    const caseKey = decodedText;
    if (acceptedCases[caseKey]) {
        caseData = { ...caseData, ...acceptedCases[caseKey] };
    }
    
    currentCase = { ...caseData, qrCode: decodedText, caseKey: caseKey };
    
    showCaseModal();
    showToast('تم فحص QR بنجاح!', 'success');
}

function onScanFailure(error) {
    console.warn(`QR scan error = ${error}`);
}

// ========== Case Modal Functions ==========
function showCaseModal() {
    const modal = document.getElementById('caseModal');
    
    // تعبئة البيانات
    document.getElementById('modalPatientName').textContent = currentCase.patientName;
    document.getElementById('modalToothNumber').textContent = currentCase.toothNumber;
    document.getElementById('modalCaseType').textContent = currentCase.caseType;
    document.getElementById('modalStudentName').textContent = currentCase.studentName;
    document.getElementById('modalStudentId').textContent = currentCase.studentId;
    
    // حساب عدد التقييمات المكتملة
    const completedRatings = currentCase.ratings ? 
        Object.values(currentCase.ratings).filter(r => r !== null).length : 0;
    
    const statusEl = document.getElementById('modalCaseStatus');
    const newActions = document.getElementById('modalNewActions');
    const ratingSection = document.getElementById('modalRatingSection');
    const completionMessage = document.getElementById('modalCompletionMessage');
    
    // إعادة تعيين العرض
    newActions.style.display = 'none';
    ratingSection.style.display = 'none';
    completionMessage.style.display = 'none';
    
    if (currentCase.status === 'pending') {
        statusEl.innerHTML = `span style="color: var(--warning);"><i class="fas fa-clock" style="margin-left: 6px;"></i>معلقة - بانتظار القرار</span>`;
        newActions.style.display = 'block';
        resetRatingUI();
    } else if (currentCase.status === 'accepted' || currentCase.status === 'inProgress') {
        if (completedRatings === 3) {
            statusEl.innerHTML = `<span style="color: var(--secondary);"><i class="fas fa-check-circle" style="margin-left: 6px;"></i>منجزة</span>`;
            completionMessage.style.display = 'block';
        } else {
            const statusText = completedRatings > 0 ? `قيد الإنجاز (${completedRatings}/3)` : 'مقبولة - بانتظار التقييم';
            statusEl.innerHTML = `<span style="color: var(--primary);"><i class="fas fa-spinner fa-spin" style="margin-left: 6px;"></i>${statusText}</span>`;
            ratingSection.style.display = 'block';
            newActions.style.display = 'none';
            
            // تحميل التقييمات المخزنة مؤقتاً
            if (currentCase.ratings) {
                currentRatings = { ...currentCase.ratings };
                updateRatingUI();
            }
        }
    } else if (currentCase.status === 'rejected') {
        statusEl.innerHTML = `<span style="color: var(--danger);"><i class="fas fa-times-circle" style="margin-left: 6px;"></i>مرفوضة</span>`;
        newActions.style.display = 'block';
    } else if (currentCase.status === 'changed') {
        statusEl.innerHTML = `<span style="color: var(--warning);"><i class="fas fa-exchange-alt" style="margin-left: 6px;"></i>تم تغيير العلاج</span>`;
        newActions.style.display = 'block';
    }
    
    modal.style.display = 'flex';
}

function closeCaseModal() {
    document.getElementById('caseModal').style.display = 'none';
    currentCase = null;
    currentRatings = { 1: null, 2: null, 3: null };
    proposedTreatment = null;
    hideTooltip();
}

function resetRatingUI() {
    currentRatings = { 1: null, 2: null, 3: null };
    proposedTreatment = null;
    document.getElementById('proposedTreatmentText').innerHTML = '<i class="fas fa-hand-pointer" style="margin-left: 8px;"></i>اختر العلاج المناسب...';
    document.getElementById('proposedTreatmentSection').style.display = 'none';
    
    for (let i = 1; i <= 3; i++) {
        const badge = document.getElementById(`modalRating${i}Badge`);
        const status = document.getElementById(`modalRating${i}Status`);
        const inputs = document.getElementById(`modalRating${i}Inputs`);
        
        badge.style.background = i === 1 ? 'linear-gradient(135deg, var(--primary), var(--primary-light))' : 'var(--gray)';
        status.textContent = i === 1 ? 'متاح' : 'معلق';
        status.style.background = i === 1 ? 'rgba(245, 158, 11, 0.15)' : '#f3f4f6';
        status.style.color = i === 1 ? 'var(--warning)' : '#9ca3af';
        
        inputs.style.opacity = i === 1 ? '1' : '0.5';
        inputs.style.pointerEvents = i === 1 ? 'auto' : 'none';
        
        document.querySelectorAll(`[data-rating="${i}"].modal-rating-btn`).forEach(btn => {
            btn.style.background = 'white';
            btn.style.borderColor = '#e5e7eb';
            btn.style.color = 'inherit';
            btn.disabled = false;
            btn.style.cursor = 'pointer';
            btn.style.opacity = '1';
            btn.classList.remove('selected');
        });
        
        document.getElementById(`modalPercentage${i}Input`).style.display = 'none';
        document.getElementById(`modalPercent${i}`).value = '';
        document.getElementById(`modalPercent${i}`).disabled = false;
    }
}

function updateRatingUI() {
    for (let i = 1; i <= 3; i++) {
        const rating = currentRatings[i];
        const badge = document.getElementById(`modalRating${i}Badge`);
        const status = document.getElementById(`modalRating${i}Status`);
        const inputs = document.getElementById(`modalRating${i}Inputs`);
        
        if (rating) {
            status.textContent = 'محدد';
            status.style.background = 'rgba(79, 70, 229, 0.15)';
            status.style.color = 'var(--primary)';
            badge.style.background = 'linear-gradient(135deg, var(--primary), var(--primary-light))';
            
            // تمييز الزر المختار
            document.querySelectorAll(`[data-rating="${i}"].modal-rating-btn`).forEach(btn => {
                btn.classList.remove('selected');
                if (btn.dataset.grade === rating.value || (rating.type === 'percentage' && btn.dataset.grade === 'percentage')) {
                    btn.classList.add('selected');
                    btn.style.background = 'linear-gradient(135deg, var(--primary), var(--primary-light))';
                    btn.style.borderColor = 'var(--primary)';
                    btn.style.color = 'white';
                } else {
                    btn.style.background = 'white';
                    btn.style.borderColor = '#e5e7eb';
                    btn.style.color = 'inherit';
                }
            });
            
            if (rating.type === 'percentage') {
                document.getElementById(`modalPercentage${i}Input`).style.display = 'block';
                document.getElementById(`modalPercent${i}`).value = rating.value.replace('%', '');
            }
            
            // تفعيل المرحلة التالية
            if (i < 3) {
                document.getElementById(`modalRating${i+1}Container`).style.opacity = '1';
                document.getElementById(`modalRating${i+1}Inputs`).style.opacity = '1';
                document.getElementById(`modalRating${i+1}Inputs`).style.pointerEvents = 'auto';
                document.getElementById(`modalRating${i+1}Status`).textContent = 'متاح';
                document.getElementById(`modalRating${i+1}Status`).style.background = 'rgba(245, 158, 11, 0.15)';
                document.getElementById(`modalRating${i+1}Status`).style.color = '#f59e0b';
                document.getElementById(`modalRating${i+1}Badge`).style.background = 'linear-gradient(135deg, var(--primary), var(--primary-light))';
            }
            
            // إظهار قسم العلاج المقترح عند الوصول للمرحلة 3
            if (i === 2) {
                document.getElementById('proposedTreatmentSection').style.display = 'block';
            }
        }
    }
}

function acceptCaseOnly() {
    currentCase.status = 'accepted';
    currentCase.acceptedAt = new Date().toISOString();
    currentCase.acceptedBy = 'د. أحمد النجار';
    
    acceptedCases[currentCase.caseKey] = {
        status: 'accepted',
        acceptedAt: currentCase.acceptedAt,
        acceptedBy: currentCase.acceptedBy,
        ratings: { 1: null, 2: null, 3: null }
    };
    
    addToHistory('قبول', currentCase);
    showToast('تم قبول الحالة وإغلاقها بنجاح', 'success');
    closeCaseModal();
}

function acceptAndEvaluate() {
    currentCase.status = 'inProgress';
    currentCase.acceptedAt = new Date().toISOString();
    currentCase.acceptedBy = 'د. أحمد النجار';
    
    acceptedCases[currentCase.caseKey] = {
        status: 'inProgress',
        acceptedAt: currentCase.acceptedAt,
        acceptedBy: currentCase.acceptedBy,
        ratings: { 1: null, 2: null, 3: null }
    };
    
    document.getElementById('modalNewActions').style.display = 'none';
    document.getElementById('modalRatingSection').style.display = 'block';
    resetRatingUI();
    
    showToast('تم قبول الحالة، يمكنك الآن البدء بالتقييم', 'success');
}

// اختيار التقييم (مؤقت حتى يتم الحفظ)
function selectRating(level, grade) {
    // التحقق من التسلسل
    for (let i = 1; i < level; i++) {
        if (!currentRatings[i]) {
            showToast(`يجب تقييم المرحلة ${i} أولاً`, 'warning');
            return;
        }
    }
    
    // السماح بتغيير التقييم المؤقت فقط إذا لم يتم حفظه بعد
    const ratingDate = new Date().toLocaleString('ar-SA');
    
    if (grade === 'percentage') {
        document.getElementById(`modalPercentage${level}Input`).style.display = 'block';
        document.getElementById(`modalPercent${level}`).focus();
        currentRatings[level] = { type: 'percentage', value: null, temp: true, date: ratingDate };
        
        // تحديث واجهة الأزرار
        document.querySelectorAll(`[data-rating="${level}"].modal-rating-btn`).forEach(btn => {
            btn.classList.remove('selected');
            btn.style.background = 'white';
            btn.style.borderColor = '#e5e7eb';
            btn.style.color = 'inherit';
        });
        event.target.classList.add('selected');
        event.target.style.background = 'linear-gradient(135deg, var(--primary), var(--primary-light))';
        event.target.style.borderColor = 'var(--primary)';
        event.target.style.color = 'white';
    } else {
        currentRatings[level] = { type: 'grade', value: grade, temp: true, date: ratingDate };
        document.getElementById(`modalPercentage${level}Input`).style.display = 'none';
        
        // تحديث واجهة الأزرار
        document.querySelectorAll(`[data-rating="${level}"].modal-rating-btn`).forEach(btn => {
            btn.classList.remove('selected');
            btn.style.background = 'white';
            btn.style.borderColor = '#e5e7eb';
            btn.style.color = 'inherit';
        });
        event.target.classList.add('selected');
        event.target.style.background = 'linear-gradient(135deg, var(--primary), var(--primary-light))';
        event.target.style.borderColor = 'var(--primary)';
        event.target.style.color = 'white';
    }
    
    document.getElementById(`modalRating${level}Status`).textContent = 'محدد';
    document.getElementById(`modalRating${level}Status`).style.background = 'rgba(79, 70, 229, 0.15)';
    document.getElementById(`modalRating${level}Status`).style.color = 'var(--primary)';
    
    // تفعيل المرحلة التالية أو إظهار العلاج المقترح
    if (level < 3) {
        document.getElementById(`modalRating${level+1}Container`).style.opacity = '1';
        document.getElementById(`modalRating${level+1}Inputs`).style.opacity = '1';
        document.getElementById(`modalRating${level+1}Inputs`).style.pointerEvents = 'auto';
        document.getElementById(`modalRating${level+1}Status`).textContent = 'متاح';
        document.getElementById(`modalRating${level+1}Status`).style.background = 'rgba(245, 158, 11, 0.15)';
        document.getElementById(`modalRating${level+1}Status`).style.color = '#f59e0b';
        document.getElementById(`modalRating${level+1}Badge`).style.background = 'linear-gradient(135deg, var(--primary), var(--primary-light))';
    }
    
    // إظهار قسم العلاج المقترح عند الوصول للمرحلة 3
    if (level === 2) {
        document.getElementById('proposedTreatmentSection').style.display = 'block';
        document.getElementById('proposedTreatmentSection').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function selectProposedTreatment(treatment) {
    proposedTreatment = treatment;
    const displayText = treatment === 'لا يوجد - الحالة انتهت' ? 
        '<i class="fas fa-check" style="margin-left: 8px;"></i>لا يوجد - الحالة انتهت' : 
        `<i class="fas fa-tooth" style="margin-left: 8px; color: var(--primary);"></i>${treatment}`;
    document.getElementById('proposedTreatmentText').innerHTML = displayText;
    document.getElementById('proposedTreatmentText').style.color = 'var(--dark)';
    closeAllDropdowns();
    
    if (treatment !== 'لا يوجد - الحالة انتهت') {
        showToast(`تم اختيار "${treatment}" كعلاج مقترح`, 'success');
    }
}

// حفظ التقييمات النهائي
function submitRatings() {
    // التحقق من وجود تقييمات
    let hasRating = false;
    for (let i = 1; i <= 3; i++) {
        if (currentRatings[i]) {
            hasRating = true;
            break;
        }
    }
    
    if (!hasRating) {
        showToast('الرجاء إدخال تقييم واحد على الأقل', 'warning');
        return;
    }
    
    // التحقق من اختيار العلاج المقترح إذا كان في المرحلة 3
    if (currentRatings[2] && !currentRatings[3] && !proposedTreatment) {
        showToast('الرجاء اختيار العلاج المقترح أولاً (اختر المناسب)', 'warning');
        document.getElementById('proposedTreatmentSection').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }
    
    // معالجة النسب المئوية
    const ratingsToSubmit = {};
    const ratingDates = [null, null, null];
    
    for (let i = 1; i <= 3; i++) {
        if (currentRatings[i]) {
            if (currentRatings[i].type === 'percentage') {
                const val = document.getElementById(`modalPercent${i}`).value;
                if (!val) {
                    showToast(`الرجاء إدخال النسبة المئوية للتقييم ${i}`, 'warning');
                    return;
                }
                ratingsToSubmit[i] = { type: 'percentage', value: val + '%', date: currentRatings[i].date };
            } else {
                ratingsToSubmit[i] = { ...currentRatings[i] };
                delete ratingsToSubmit[i].temp;
            }
            ratingDates[i-1] = currentRatings[i].date;
        }
    }
    
    // تحديث بيانات الحالة
    currentCase.ratings = { ...currentCase.ratings, ...ratingsToSubmit };
    currentCase.ratingDates = ratingDates;
    currentCase.ratedAt = new Date().toISOString();
    currentCase.ratedBy = 'د. أحمد النجار';
    currentCase.proposedTreatment = proposedTreatment;
    
    const completedCount = Object.values(currentCase.ratings).filter(r => r !== null).length;
    
    if (completedCount === 3) {
        currentCase.status = 'completed';
    } else {
        currentCase.status = 'inProgress';
    }
    
    if (acceptedCases[currentCase.caseKey]) {
        acceptedCases[currentCase.caseKey].ratings = currentCase.ratings;
        acceptedCases[currentCase.caseKey].status = currentCase.status;
    }
    
    // إضافة العلاج للمريض إذا لم يكن "لا يوجد"
    if (proposedTreatment && proposedTreatment !== 'لا يوجد - الحالة انتهت') {
        addProposedTreatmentToPatient(currentCase.patientName, currentCase.toothNumber, proposedTreatment);
    }
    
    // إضافة للسجل
    const ratedLevels = Object.keys(ratingsToSubmit).join(', ');
    addToHistory(`تقييم مراحل ${ratedLevels}`, currentCase);
    
    // إظهار رسالة النجاح
    Object.keys(ratingsToSubmit).forEach(level => {
        showToast(`تم تقييم المرحلة ${level} بنجاح`, 'success');
    });
    
    // إظهار رسالة الإنجاز أو الاستمرار
    if (completedCount === 3) {
        document.getElementById('modalRatingSection').style.display = 'none';
        document.getElementById('modalCompletionMessage').style.display = 'block';
        document.getElementById('modalCaseStatus').innerHTML = `<span style="color: var(--secondary);"><i class="fas fa-check-circle" style="margin-left: 6px;"></i>منجزة</span>`;
    } else {
        showToast('تم حفظ التقييمات بنجاح!', 'success');
        // تعطيل الأزرار بعد الحفظ
        for (let i = 1; i <= 3; i++) {
            if (currentRatings[i]) {
                document.querySelectorAll(`[data-rating="${i}"].modal-rating-btn`).forEach(btn => {
                    btn.disabled = true;
                    btn.style.cursor = 'not-allowed';
                    btn.style.opacity = '0.5';
                });
                document.getElementById(`modalRating${i}Status`).textContent = 'مكتمل';
                document.getElementById(`modalRating${i}Status`).style.background = 'rgba(16, 185, 129, 0.15)';
                document.getElementById(`modalRating${i}Status`).style.color = '#10b981';
                document.getElementById(`modalRating${i}Badge`).style.background = 'linear-gradient(135deg, var(--secondary), #059669)';
            }
        }
    }
}

function addProposedTreatmentToPatient(patientName, toothNumber, treatment) {
    console.log(`إضافة علاج "${treatment}" للمريض ${patientName} - السن ${toothNumber}`);
    showToast(`تم إضافة "${treatment}" لسجل المريض بنجاح`, 'success');
}

// ========== Change Treatment Functions ==========
function showChangeTreatmentModal() {
    document.getElementById('currentTreatment').textContent = currentCase.caseType;
    document.getElementById('changeTreatmentModal').style.display = 'flex';
}

function closeChangeTreatmentModal() {
    document.getElementById('changeTreatmentModal').style.display = 'none';
    document.getElementById('changeReason').value = '';
    selectedTreatment = null;
    document.getElementById('selectedTreatmentText').textContent = 'اختر نوع العلاج...';
    document.getElementById('confirmChangeBtn').disabled = true;
    document.getElementById('confirmChangeBtn').style.background = '#e5e7eb';
    document.getElementById('confirmChangeBtn').style.color = '#9ca3af';
    document.getElementById('confirmChangeBtn').style.cursor = 'not-allowed';
}

function selectTreatment(treatment) {
    selectedTreatment = treatment;
    document.getElementById('selectedTreatmentText').textContent = treatment;
    closeAllDropdowns();
    
    const btn = document.getElementById('confirmChangeBtn');
    btn.disabled = false;
    btn.style.background = 'linear-gradient(135deg, var(--danger), #dc2626)';
    btn.style.color = 'white';
    btn.style.cursor = 'pointer';
    btn.style.boxShadow = '0 4px 12px rgba(239, 68, 68, 0.3)';
}

function confirmChangeTreatment() {
    if (!selectedTreatment || !document.getElementById('changeReason').value.trim()) {
        showToast('الرجاء اختيار العلاج وكتابة السبب', 'warning');
        return;
    }
    
    const reason = document.getElementById('changeReason').value;
    const oldType = currentCase.caseType;
    
    currentCase.status = 'changed';
    currentCase.caseType = selectedTreatment;
    currentCase.changeReason = reason;
    currentCase.changedAt = new Date().toISOString();
    currentCase.changedBy = 'د. أحمد النجار';
    
    addToHistory('تغيير علاج', {
        ...currentCase,
        oldType: oldType,
        newType: selectedTreatment,
        reason: reason
    });
    
    showToast(`تم تغيير العلاج إلى "${selectedTreatment}"`, 'success');
    closeChangeTreatmentModal();
    closeCaseModal();
}

// ========== History Functions ==========
function loadHistory() {
    const tbody = document.getElementById('historyTableBody');
    tbody.innerHTML = '';
    
    const start = (historyCurrentPage - 1) * historyItemsPerPage;
    const end = start + historyItemsPerPage;
    const pageRecords = historyRecords.slice(start, end);
    
    pageRecords.forEach((record, index) => {
        const row = document.createElement('tr');
        row.style.cssText = 'border-bottom: 1px solid #f1f5f9; animation: fadeIn 0.3s ease forwards; animation-delay: ' + (index * 0.05) + 's; opacity: 0;';
        
        let statusHtml = '';
        let ratingsHtml = '';
        
        if (record.status === 'completed') {
            statusHtml = `<span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 6px 14px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap;"><i class="fas fa-check-circle" style="margin-left: 4px;"></i>منجزة</span>`;
        } else if (record.status === 'inProgress') {
            statusHtml = `<span style="background: rgba(79, 70, 229, 0.15); color: var(--primary); padding: 6px 14px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap;"><i class="fas fa-spinner fa-spin" style="margin-left: 4px;"></i>قيد الإنجاز</span>`;
        } else if (record.status === 'rejected') {
            statusHtml = `<span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 6px 14px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap;"><i class="fas fa-times-circle" style="margin-left: 4px;"></i>مرفوضة</span>`;
        } else if (record.status === 'changed') {
            statusHtml = `<span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 6px 14px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap;"><i class="fas fa-exchange-alt" style="margin-left: 4px;"></i>معدلة</span>`;
        } else {
            statusHtml = `<span style="background: rgba(79, 70, 229, 0.15); color: var(--primary); padding: 6px 14px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap;"><i class="fas fa-check" style="margin-left: 4px;"></i>مقبولة</span>`;
        }
        
        ratingsHtml = '<div style="display: flex; justify-content: center; gap: 6px; direction: ltr;">';
        for (let i = 1; i <= 3; i++) {
            let bg, icon, color, tooltipText;
            
            if (record.status === 'rejected') {
                bg = '#ef4444';
                icon = 'fa-times';
                color = 'white';
                tooltipText = 'الحالة مرفوضة';
            } else if (record.status === 'changed') {
                bg = '#f59e0b';
                icon = 'fa-exclamation';
                color = 'white';
                tooltipText = 'تم تغيير العلاج';
            } else if (i <= record.ratings) {
                bg = '#10b981';
                icon = 'fa-check';
                color = 'white';
                tooltipText = record.ratingDates && record.ratingDates[i-1] ? 
                    `تم التقييم: ${record.ratingDates[i-1]}` : 'تم التقييم';
            } else {
                bg = '#e5e7eb';
                icon = '';
                color = '#9ca3af';
                tooltipText = 'لم يتم التقييم';
            }
            
            ratingsHtml += `
                <div class="rating-checkbox" data-tooltip="${tooltipText}" 
                     style="width: clamp(24px, 6vw, 28px); height: clamp(24px, 6vw, 28px); border-radius: 6px; background: ${bg}; display: flex; align-items: center; justify-content: center; color: ${color}; font-size: clamp(11px, 2.8vw, 13px); font-weight: 700; cursor: pointer; position: relative;"
                     onclick="showRatingTooltip(event, '${tooltipText}', this)">
                    ${icon ? `<i class="fas ${icon}"></i>` : i}
                </div>
            `;
        }
        ratingsHtml += '</div>';
        
        row.innerHTML = `
            <td style="padding: clamp(10px, 2.5vw, 14px);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: clamp(36px, 9vw, 42px); height: clamp(36px, 9vw, 42px); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(13px, 3.3vw, 15px); flex-shrink: 0;">${record.patient.charAt(0)}</div>
                    <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">${record.patient}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: var(--primary); font-weight: 800; font-size: clamp(1rem, 3vw, 1.25rem); white-space: nowrap;">${record.tooth}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <span style="background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 6px 10px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap; display: inline-block; max-width: 110px; overflow: hidden; text-overflow: ellipsis;">${record.type}</span>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: clamp(36px, 9vw, 42px); height: clamp(36px, 9vw, 42px); background: linear-gradient(135deg, var(--secondary), #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: clamp(13px, 3.3vw, 15px); flex-shrink: 0;">${record.student.charAt(0)}</div>
                    <span style="font-weight: 700; color: #1f2937; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 90px;">${record.student}</span>
                </div>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-weight: 600; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); white-space: nowrap;">${record.studentId}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${statusHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${ratingsHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">
                <span style="background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 6px 10px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap;">${record.supervisor}</span>
            </td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #9ca3af; font-size: clamp(0.75rem, 2vw, 0.875rem); white-space: nowrap;">
                <i class="fas fa-clock" style="margin-left: 4px;"></i>${record.date}
            </td>
        `;
        tbody.appendChild(row);
    });
    
    document.getElementById('totalRecords').textContent = historyRecords.length + ' سجل';
    
    const totalPages = Math.ceil(historyRecords.length / historyItemsPerPage);
    document.getElementById('historyPageIndicator').textContent = `صفحة ${historyCurrentPage} من ${totalPages}`;
    
    document.getElementById('historyPrevBtn').disabled = historyCurrentPage === 1;
    document.getElementById('historyPrevBtn').style.opacity = historyCurrentPage === 1 ? '0.5' : '1';
    document.getElementById('historyNextBtn').disabled = historyCurrentPage === totalPages;
    document.getElementById('historyNextBtn').style.opacity = historyCurrentPage === totalPages ? '0.5' : '1';
}

function changeHistoryPage(direction) {
    const totalPages = Math.ceil(historyRecords.length / historyItemsPerPage);
    if (direction === 'next' && historyCurrentPage < totalPages) {
        historyCurrentPage++;
        loadHistory();
    } else if (direction === 'prev' && historyCurrentPage > 1) {
        historyCurrentPage--;
        loadHistory();
    }
}

function addToHistory(action, caseData) {
    let status = 'pending';
    let ratings = 0;
    let ratingDates = [null, null, null];
    
    if (action.includes('تقييم')) {
        const completedCount = Object.keys(caseData.ratings || {}).filter(k => caseData.ratings[k] !== null).length;
        status = completedCount === 3 ? 'completed' : 'inProgress';
        ratings = completedCount;
        
        for (let i = 1; i <= 3; i++) {
            if (caseData.ratings && caseData.ratings[i]) {
                ratingDates[i-1] = caseData.ratings[i].date || new Date().toLocaleString('ar-SA');
            }
        }
    } else if (action === 'تغيير علاج') {
        status = 'changed';
    } else if (action === 'رفض') {
        status = 'rejected';
    } else if (action === 'قبول') {
        status = 'accepted';
    }
    
    const newRecord = {
        id: historyRecords.length + 1,
        patient: caseData.patientName,
        tooth: caseData.toothNumber,
        type: caseData.caseType,
        student: caseData.studentName,
        studentId: caseData.studentId,
        status: status,
        ratings: ratings,
        ratingDates: ratingDates,
        supervisor: 'د. أحمد النجار',
        date: new Date().toLocaleString('ar-SA'),
        reason: caseData.changeReason || caseData.reason
    };
    historyRecords.unshift(newRecord);
    loadHistory();
}

// ========== Tooltip Functions ==========
function showRatingTooltip(event, text, element) {
    event.stopPropagation();
    const tooltip = document.getElementById('ratingTooltip');
    
    // إخفاء أي tooltip سابق
    hideTooltip();
    
    tooltip.textContent = text;
    tooltip.style.display = 'block';
    activeTooltip = element;
    
    // تحديد الموقع
    const rect = element.getBoundingClientRect();
    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
    
    // إضافة مستمع للنقر خارج الـ tooltip
    setTimeout(() => {
        document.addEventListener('click', hideTooltipOnClickOutside);
    }, 10);
}

function hideTooltip() {
    const tooltip = document.getElementById('ratingTooltip');
    if (tooltip) {
        tooltip.style.display = 'none';
    }
    activeTooltip = null;
    document.removeEventListener('click', hideTooltipOnClickOutside);
}

function hideTooltipOnClickOutside(event) {
    const tooltip = document.getElementById('ratingTooltip');
    if (tooltip && !tooltip.contains(event.target) && (!activeTooltip || !activeTooltip.contains(event.target))) {
        hideTooltip();
    }
}

// تحديث موقع الـ tooltip عند التمرير
window.addEventListener('scroll', function() {
    if (activeTooltip && document.getElementById('ratingTooltip').style.display !== 'none') {
        const tooltip = document.getElementById('ratingTooltip');
        const rect = activeTooltip.getBoundingClientRect();
        tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
    }
}, true);

// ========== General Functions ==========
function switchTab(tabName) {
    document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');
    document.getElementById(tabName + 'Content').style.display = 'block';
    
    if (tabName === 'history') loadHistory();
}

function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const isOpen = dropdown.classList.contains('dropdown-open');
    closeAllDropdowns();
    if (!isOpen) dropdown.classList.add('dropdown-open');
}

function closeAllDropdowns() {
    document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('dropdown-open'));
}

function showToast(message, type = 'info') {
    const colors = {
        info: { bg: 'linear-gradient(135deg, var(--primary), var(--primary-light))', icon: 'fa-info-circle' },
        success: { bg: 'linear-gradient(135deg, var(--secondary), #059669)', icon: 'fa-check-circle' },
        warning: { bg: 'linear-gradient(135deg, var(--warning), #fbbf24)', icon: 'fa-exclamation-triangle' },
        error: { bg: 'linear-gradient(135deg, var(--danger), #dc2626)', icon: 'fa-times-circle' }
    };
    const color = colors[type] || colors.info;
    const toast = document.createElement('div');
    toast.style.cssText = 'position: fixed; top: 100px; right: 16px; left: 16px; z-index: 100002; animation: slideDown 0.3s ease;';
    toast.innerHTML = `
        <div style="background: ${color.bg}; color: white; padding: clamp(14px, 3.5vw, 18px) clamp(18px, 4.5vw, 24px); border-radius: clamp(14px, 3.5vw, 16px); text-align: center; font-weight: 700; box-shadow: 0 10px 30px rgba(0,0,0,0.25); display: flex; align-items: center; justify-content: center; gap: 12px; font-size: clamp(0.9375rem, 2.8vw, 1.0625rem);">
            <i class="fas ${color.icon}" style="font-size: clamp(20px, 5vw, 24px);"></i>${message}
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.custom-dropdown')) closeAllDropdowns();
    if (e.target.id === 'changeTreatmentModal') closeChangeTreatmentModal();
    if (e.target.id === 'qrScannerModal') stopQRScanner();
    if (e.target.id === 'caseModal') closeCaseModal();
});

document.addEventListener('DOMContentLoaded', function() {
    loadHistory();
});
</script>

<style>
@keyframes modalPop {
    0% { opacity: 0; transform: scale(0.85) translateY(40px); }
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
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.modal-rating-btn:hover:not(:disabled):not(.selected) {
    border-color: var(--primary) !important;
    color: var(--primary) !important;
}

.modal-rating-btn.selected {
    background: linear-gradient(135deg, var(--primary), var(--primary-light)) !important;
    border-color: var(--primary) !important;
    color: white !important;
}

#qr-reader video {
    border-radius: 16px !important;
}

#qr-reader__scan_region {
    background: rgba(255,255,255,0.1) !important;
    border-radius: 16px !important;
}

#qr-reader__dashboard_section_csr span {
    color: white !important;
    font-family: 'Tajawal', sans-serif !important;
}

/* تحسينات الجدول */
.cases-table th,
.cases-table td {
    font-size: clamp(0.75rem, 2vw, 0.875rem);
    vertical-align: middle;
}

/* Tooltip للـ checkbox */
.rating-checkbox:hover {
    transform: scale(1.15);
    transition: transform 0.2s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.rating-checkbox:active {
    transform: scale(0.95);
}

/* تحسين الأزرار المعطلة */
button:disabled {
    opacity: 0.5;
    cursor: not-allowed !important;
}

/* تحسين الحقول */
input:disabled,
textarea:disabled {
    background: #f3f4f6;
    color: #6b7280;
}

/* تحسين الـ dropdowns */
.dropdown-option {
    font-size: clamp(0.8125rem, 2.2vw, 0.9375rem);
    padding: clamp(12px, 3vw, 14px);
}

/* تحسينات عامة للخطوط */
body {
    font-size: clamp(0.875rem, 2.5vw, 1rem);
}

h1, h2, h3, h4, h5, h6 {
    line-height: 1.4;
}

/* تحسين المسافات في الجدول */
.cases-table td {
    padding: clamp(10px, 2.5vw, 14px);
}

/* تحسين عرض النصوص الطويلة */
.cases-table td span {
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* تحسين التنبيهات */
.qr-floating-alert,
.upload-images-alert,
.view-images-alert {
    border: 1px solid rgba(0, 0, 0, 0.05);
}

/* تأثيرات إضافية للأزرار */
button:not(:disabled):active {
    transform: scale(0.98);
}

/* تحسين الـ checkbox في الجدول */
.rating-checkbox {
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.rating-checkbox:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* تحسين الـ dropdown options بدون أيقونات كبيرة */
.dropdown-option {
    padding: clamp(10px, 2.5vw, 12px) clamp(14px, 3.5vw, 16px);
}

.dropdown-option:hover {
    background: rgba(79, 70, 229, 0.08);
}
</style>

