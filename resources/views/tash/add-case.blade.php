@extends('layouts.tash')

@section('title', 'إضافة حالة جديدة - مكتب الاستقبال')
@section('page_title', 'إضافة حالة جديدة')

@section('content')
<!-- مؤشر الخطوات -->
<div class="input-container" style="margin-bottom: 24px; padding: 20px;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 16px;">
        <div class="step-dot active" id="step1Dot">1</div>
        <div class="step-line" id="step1Line"></div>
        <div class="step-dot" id="step2Dot">2</div>
        <div class="step-line" id="step2Line"></div>
        <div class="step-dot" id="step3Dot">3</div>
    </div>
    <div style="display: flex; justify-content: space-between; padding: 0 10px;">
        <span style="font-size: 12px; color: var(--primary); font-weight: 600;" id="step1Label">بيانات المريض</span>
        <span style="font-size: 12px; color: var(--gray);" id="step2Label">تفاصيل الحالة</span>
        <span style="font-size: 12px; color: var(--gray);" id="step3Label">التأكيد</span>
    </div>
</div>

<form id="addCaseForm" onsubmit="return submitCase(event)">
    <!-- الخطوة 1: بيانات المريض -->
    <div class="form-step active" id="step1">
        <div class="input-container">
            <div class="section-title" style="margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(79, 70, 229, 0.05));
                              border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user" style="color: var(--primary); font-size: 15px;"></i>
                    </div>
                    <span style="font-weight: 700;">بيانات المريض</span>
                </div>
            </div>

            <!-- البحث عن مريض موجود -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-search" style="margin-left: 6px; color: var(--primary);"></i>
                    البحث عن مريض موجود
                </label>
                <div style="position: relative;">
                    <input type="text"
                           class="text-input"
                           id="patientSearch"
                           placeholder="ابحث برقم الملف أو الاسم أو رقم الهاتف..."
                           style="padding-left: 90px;"
                           oninput="searchPatient(this.value)">
                    <button type="button" onclick="clearSearch()"
                            style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%);
                                   background: var(--primary); color: white; border: none; padding: 8px 14px;
                                   border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-search" style="margin-left: 4px;"></i>
                        بحث
                    </button>
                </div>
                <!-- نتائج البحث -->
                <div id="searchResults" style="display: none; margin-top: 12px; background: white; border: 2px solid var(--gray-200);
                        border-radius: 12px; max-height: 200px; overflow-y: auto;">
                </div>
            </div>

            <!-- فاصل -->
            <div style="display: flex; align-items: center; gap: 16px; margin: 24px 0;">
                <div style="flex: 1; height: 1px; background: var(--gray-200);"></div>
                <span style="color: var(--gray); font-size: 13px;">أو أدخل بيانات مريض جديد</span>
                <div style="flex: 1; height: 1px; background: var(--gray-200);"></div>
            </div>

            <!-- بيانات المريض -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-user" style="margin-left: 6px; color: var(--primary);"></i>
                    الاسم الكامل
                    <span style="color: var(--danger);">*</span>
                </label>
                <input type="text" class="text-input" id="patientName" placeholder="أدخل الاسم الكامل للمريض" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        <i class="fas fa-phone" style="margin-left: 6px; color: var(--secondary);"></i>
                        رقم الهاتف
                        <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="tel" class="text-input" id="patientPhone" placeholder="09XXXXXXXX" required
                           style="direction: ltr; text-align: left;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        <i class="fas fa-calendar" style="margin-left: 6px; color: var(--accent);"></i>
                        تاريخ الميلاد
                    </label>
                    <input type="date" class="text-input" id="patientBirthdate">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        <i class="fas fa-venus-mars" style="margin-left: 6px; color: var(--warning);"></i>
                        الجنس
                    </label>
                    <select class="text-input" id="patientGender" style="cursor: pointer;">
                        <option value="">اختر الجنس</option>
                        <option value="male">ذكر</option>
                        <option value="female">أنثى</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        <i class="fas fa-tint" style="margin-left: 6px; color: var(--danger);"></i>
                        فصيلة الدم
                    </label>
                    <select class="text-input" id="patientBloodType" style="cursor: pointer;">
                        <option value="">اختر الفصيلة</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-map-marker-alt" style="margin-left: 6px; color: #8b5cf6;"></i>
                    العنوان
                </label>
                <input type="text" class="text-input" id="patientAddress" placeholder="أدخل العنوان">
            </div>
        </div>

        <!-- زر التالي -->
        <div style="margin-top: 20px;">
            <button type="button" class="modern-btn" onclick="nextStep(2)" style="width: 100%;">
                التالي
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
            </button>
        </div>
    </div>

    <!-- الخطوة 2: تفاصيل الحالة -->
    <div class="form-step" id="step2">
        <div class="input-container">
            <div class="section-title" style="margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
                              border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-medical" style="color: var(--secondary); font-size: 15px;"></i>
                    </div>
                    <span style="font-weight: 700;">تفاصيل الحالة</span>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-stethoscope" style="margin-left: 6px; color: var(--primary);"></i>
                    نوع العلاج
                    <span style="color: var(--danger);">*</span>
                </label>
                <select class="text-input" id="treatmentType" required style="cursor: pointer;">
                    <option value="">اختر نوع العلاج</option>
                    <option value="checkup">فحص دوري</option>
                    <option value="cleaning">تنظيف أسنان</option>
                    <option value="filling">حشوة</option>
                    <option value="extraction">خلع</option>
                    <option value="rootcanal">علاج عصب</option>
                    <option value="crown">تاج / تلبيسة</option>
                    <option value="braces">تقويم أسنان</option>
                    <option value="implant">زراعة</option>
                    <option value="whitening">تبييض</option>
                    <option value="surgery">جراحة</option>
                    <option value="emergency">طوارئ</option>
                    <option value="other">أخرى</option>
                </select>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-user-md" style="margin-left: 6px; color: var(--secondary);"></i>
                    الطبيب المعالج
                    <span style="color: var(--danger);">*</span>
                </label>
                <select class="text-input" id="doctorId" required style="cursor: pointer;">
                    <option value="">اختر الطبيب</option>
                    <option value="1">د. أحمد الخالد - عام</option>
                    <option value="2">د. سارة محمود - تقويم</option>
                    <option value="3">د. محمد النور - جراحة</option>
                    <option value="4">د. فاطمة علي - أطفال</option>
                    <option value="5">د. خالد عمر - تجميل</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        <i class="fas fa-hospital" style="margin-left: 6px; color: var(--accent);"></i>
                        العيادة
                        <span style="color: var(--danger);">*</span>
                    </label>
                    <select class="text-input" id="clinicId" required style="cursor: pointer;">
                        <option value="">اختر العيادة</option>
                        <option value="1">العيادة 1</option>
                        <option value="2">العيادة 2</option>
                        <option value="3">العيادة 3</option>
                        <option value="4">العيادة 4</option>
                        <option value="5">العيادة 5</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        <i class="fas fa-exclamation-triangle" style="margin-left: 6px; color: var(--warning);"></i>
                        درجة الأولوية
                    </label>
                    <select class="text-input" id="priority" style="cursor: pointer;">
                        <option value="normal">عادية</option>
                        <option value="high">عالية</option>
                        <option value="urgent">طارئة</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-notes-medical" style="margin-left: 6px; color: var(--warning);"></i>
                    الشكوى / السبب
                </label>
                <textarea class="text-input" id="complaint" placeholder="اكتب شكوى المريض أو سبب الزيارة..." rows="3"
                          style="resize: vertical; min-height: 80px;"></textarea>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-comment-medical" style="margin-left: 6px; color: #8b5cf6;"></i>
                    ملاحظات إضافية
                </label>
                <textarea class="text-input" id="notes" placeholder="أي ملاحظات إضافية..." rows="2"
                          style="resize: vertical; min-height: 60px;"></textarea>
            </div>

            <!-- خيارات إضافية -->
            <div style="background: var(--gray-light); border-radius: 12px; padding: 16px;">
                <div style="font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 12px;">
                    <i class="fas fa-cog" style="color: var(--primary); margin-left: 6px;"></i>
                    خيارات إضافية
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" id="isVIP" style="width: 20px; height: 20px; accent-color: var(--warning);">
                        <span style="flex: 1; font-size: 14px; color: var(--dark);">
                            <i class="fas fa-star" style="color: var(--warning); margin-left: 4px;"></i>
                            مريض VIP
                        </span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" id="needsFollowUp" style="width: 20px; height: 20px; accent-color: var(--primary);">
                        <span style="flex: 1; font-size: 14px; color: var(--dark);">
                            <i class="fas fa-calendar-check" style="color: var(--primary); margin-left: 4px;"></i>
                            يحتاج موعد متابعة
                        </span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" id="sendSMS" checked style="width: 20px; height: 20px; accent-color: var(--secondary);">
                        <span style="flex: 1; font-size: 14px; color: var(--dark);">
                            <i class="fas fa-sms" style="color: var(--secondary); margin-left: 4px;"></i>
                            إرسال رسالة تأكيد
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- أزرار التنقل -->
        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <button type="button" onclick="prevStep(1)"
                    style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid var(--gray-300);
                           padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer; font-size: 14px;">
                <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                السابق
            </button>
            <button type="button" class="modern-btn" onclick="nextStep(3)" style="flex: 1;">
                التالي
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
            </button>
        </div>
    </div>

    <!-- الخطوة 3: التأكيد -->
    <div class="form-step" id="step3">
        <div class="input-container">
            <div class="section-title" style="margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
                              border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle" style="color: var(--secondary); font-size: 15px;"></i>
                    </div>
                    <span style="font-weight: 700;">مراجعة وتأكيد</span>
                </div>
            </div>

            <!-- ملخص بيانات المريض -->
            <div style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(79, 70, 229, 0.05));
                        border-radius: 14px; padding: 16px; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--primary), var(--primary-light));
                                border-radius: 50%; display: flex; align-items: center; justify-content: center;
                                color: white; font-size: 22px; font-weight: 700;" id="summaryAvatar">
                        -
                    </div>
                    <div>
                        <div style="font-size: 18px; font-weight: 700; color: var(--dark);" id="summaryName">-</div>
                        <div style="font-size: 13px; color: var(--gray);" id="summaryPhone">-</div>
                    </div>
                </div>
            </div>

            <!-- ملخص تفاصيل الحالة -->
            <div style="background: white; border: 1px solid var(--gray-200); border-radius: 14px; padding: 16px;">
                <div style="font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 12px;">
                    <i class="fas fa-file-medical" style="color: var(--primary); margin-left: 6px;"></i>
                    تفاصيل الحالة
                </div>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; justify-content: space-between; padding: 10px;
                                background: var(--gray-light); border-radius: 8px;">
                        <span style="color: var(--gray); font-size: 13px;">نوع العلاج</span>
                        <span style="color: var(--dark); font-weight: 600; font-size: 13px;" id="summaryTreatment">-</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px;
                                background: var(--gray-light); border-radius: 8px;">
                        <span style="color: var(--gray); font-size: 13px;">الطبيب المعالج</span>
                        <span style="color: var(--dark); font-weight: 600; font-size: 13px;" id="summaryDoctor">-</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px;
                                background: var(--gray-light); border-radius: 8px;">
                        <span style="color: var(--gray); font-size: 13px;">العيادة</span>
                        <span style="color: var(--dark); font-weight: 600; font-size: 13px;" id="summaryClinic">-</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px;
                                background: var(--gray-light); border-radius: 8px;">
                        <span style="color: var(--gray); font-size: 13px;">الأولوية</span>
                        <span id="summaryPriority" style="font-size: 12px; padding: 4px 10px; border-radius: 8px; font-weight: 600;">-</span>
                    </div>
                </div>

                <div id="summaryComplaint" style="display: none; margin-top: 12px; padding: 12px;
                            background: rgba(245, 158, 11, 0.1); border-radius: 8px;">
                    <div style="font-size: 12px; color: var(--warning); margin-bottom: 4px; font-weight: 600;">
                        <i class="fas fa-notes-medical" style="margin-left: 4px;"></i>
                        الشكوى
                    </div>
                    <div style="font-size: 13px; color: var(--dark);" id="summaryComplaintText"></div>
                </div>
            </div>

            <!-- رقم الحالة المتوقع -->
            <div style="background: linear-gradient(135deg, var(--secondary), #34d399); border-radius: 14px;
                        padding: 20px; margin-top: 16px; text-align: center; color: white;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 4px;">رقم الحالة</div>
                <div style="font-size: 28px; font-weight: 800;">#2024-<span id="caseNumber">026</span></div>
            </div>
        </div>

        <!-- أزرار التأكيد -->
        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <button type="button" onclick="prevStep(2)"
                    style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid var(--gray-300);
                           padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer; font-size: 14px;">
                <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                السابق
            </button>
            <button type="submit" class="modern-btn" style="flex: 1; background: linear-gradient(135deg, var(--secondary), #34d399);">
                <i class="fas fa-check" style="margin-left: 8px;"></i>
                تأكيد الحالة
            </button>
        </div>
    </div>
</form>

<!-- Modal النجاح -->
<div class="modal" id="successModal" style="display: none; text-align: center;">
    <div style="width: 90px; height: 90px; background: linear-gradient(135deg, var(--secondary), #34d399);
                border-radius: 50%; display: flex; align-items: center; justify-content: center;
                margin: 0 auto 24px; box-shadow: 0 8px 30px rgba(16, 185, 129, 0.3);">
        <i class="fas fa-check" style="font-size: 40px; color: white;"></i>
    </div>
    <h3 style="font-size: 22px; font-weight: 700; color: var(--dark); margin-bottom: 8px;">
        تم تسجيل الحالة بنجاح!
    </h3>
    <p style="color: var(--gray); font-size: 14px; margin-bottom: 20px;">
        تم إضافة الحالة إلى قائمة الانتظار
    </p>
    <div style="background: var(--gray-light); border-radius: 12px; padding: 16px; margin-bottom: 24px;">
        <div style="font-size: 13px; color: var(--gray); margin-bottom: 4px;">رقم الحالة</div>
        <div style="font-size: 24px; font-weight: 800; color: var(--primary);">#2024-026</div>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ url('/tash/cases') }}"
           style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid var(--gray-300);
                  padding: 14px; border-radius: var(--radius); font-weight: 600; text-decoration: none;
                  display: flex; align-items: center; justify-content: center;">
            عرض الحالات
        </a>
        <a href="{{ url('/tash/add-case') }}" class="modern-btn" style="flex: 1; text-decoration: none;">
            حالة جديدة
        </a>
    </div>
</div>

<!-- Overlay for success modal -->
<div class="overlay" id="successOverlay" onclick="closeSuccessModal()" style="display: none;"></div>

<style>
.form-step {
    display: none;
    animation: fadeIn 0.3s ease;
}

.form-step.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.step-dot {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--gray-200);
    color: var(--gray);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    transition: all 0.3s;
}

.step-dot.active {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.step-dot.completed {
    background: var(--secondary);
    color: white;
}

.step-line {
    width: 50px;
    height: 4px;
    background: var(--gray-200);
    border-radius: 2px;
    transition: all 0.3s;
}

.step-line.active {
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
}

.search-result-item {
    padding: 12px;
    border-bottom: 1px solid var(--gray-100);
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 12px;
}

.search-result-item:hover {
    background: var(--gray-light);
}

.search-result-item:last-child {
    border-bottom: none;
}

.modern-btn {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
    border: none;
    padding: 14px 24px;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
}

#successModal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 30px;
    border-radius: 20px;
    z-index: 1001;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

#successModal.show {
    display: block !important;
}

#successOverlay.show {
    display: block !important;
}
</style>

<script>
let currentStep = 1;

function nextStep(step) {
    // التحقق من صحة البيانات
    if (step === 2) {
        const name = document.getElementById('patientName').value;
        const phone = document.getElementById('patientPhone').value;
        if (!name || !phone) {
            showToast('يرجى إدخال اسم المريض ورقم الهاتف', 'error');
            return;
        }
    }

    if (step === 3) {
        const treatment = document.getElementById('treatmentType').value;
        const doctor = document.getElementById('doctorId').value;
        const clinic = document.getElementById('clinicId').value;
        if (!treatment || !doctor || !clinic) {
            showToast('يرجى إكمال جميع الحقول المطلوبة', 'error');
            return;
        }
        updateSummary();
    }

    goToStep(step);
}

function prevStep(step) {
    goToStep(step);
}

function goToStep(step) {
    // إخفاء الخطوة الحالية
    document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
    document.getElementById('step' + step).classList.add('active');

    // تحديث المؤشرات
    for (let i = 1; i <= 3; i++) {
        const dot = document.getElementById('step' + i + 'Dot');
        const line = document.getElementById('step' + i + 'Line');

        if (i < step) {
            dot.classList.add('completed');
            dot.classList.remove('active');
            dot.innerHTML = '<i class="fas fa-check"></i>';
            if (line) line.classList.add('active');
        } else if (i === step) {
            dot.classList.add('active');
            dot.classList.remove('completed');
            dot.textContent = i;
        } else {
            dot.classList.remove('active', 'completed');
            dot.textContent = i;
            if (line) line.classList.remove('active');
        }
    }

    // تحديث النصوص
    document.getElementById('step1Label').style.color = step >= 1 ? 'var(--primary)' : 'var(--gray)';
    document.getElementById('step2Label').style.color = step >= 2 ? 'var(--primary)' : 'var(--gray)';
    document.getElementById('step3Label').style.color = step >= 3 ? 'var(--primary)' : 'var(--gray)';

    currentStep = step;
}

function updateSummary() {
    const name = document.getElementById('patientName').value;
    const phone = document.getElementById('patientPhone').value;
    const treatment = document.getElementById('treatmentType');
    const doctor = document.getElementById('doctorId');
    const clinic = document.getElementById('clinicId');
    const priority = document.getElementById('priority');
    const complaint = document.getElementById('complaint').value;

    document.getElementById('summaryAvatar').textContent = name.charAt(0);
    document.getElementById('summaryName').textContent = name;
    document.getElementById('summaryPhone').textContent = phone;
    document.getElementById('summaryTreatment').textContent = treatment.options[treatment.selectedIndex].text;
    document.getElementById('summaryDoctor').textContent = doctor.options[doctor.selectedIndex].text;
    document.getElementById('summaryClinic').textContent = clinic.options[clinic.selectedIndex].text;

    const priorityBadge = document.getElementById('summaryPriority');
    const priorityValue = priority.value;
    if (priorityValue === 'urgent') {
        priorityBadge.style.background = 'rgba(239, 68, 68, 0.1)';
        priorityBadge.style.color = 'var(--danger)';
        priorityBadge.textContent = 'طارئة';
    } else if (priorityValue === 'high') {
        priorityBadge.style.background = 'rgba(245, 158, 11, 0.1)';
        priorityBadge.style.color = 'var(--warning)';
        priorityBadge.textContent = 'عالية';
    } else {
        priorityBadge.style.background = 'rgba(16, 185, 129, 0.1)';
        priorityBadge.style.color = 'var(--secondary)';
        priorityBadge.textContent = 'عادية';
    }

    if (complaint) {
        document.getElementById('summaryComplaint').style.display = 'block';
        document.getElementById('summaryComplaintText').textContent = complaint;
    } else {
        document.getElementById('summaryComplaint').style.display = 'none';
    }
}

function searchPatient(query) {
    const resultsDiv = document.getElementById('searchResults');
    if (query.length < 2) {
        resultsDiv.style.display = 'none';
        return;
    }

    // محاكاة نتائج البحث
    const results = [
        { id: 1, name: 'أحمد محمد علي', phone: '0912345678', file: '2024001' },
        { id: 2, name: 'سارة خالد العمري', phone: '0998765432', file: '2024002' },
        { id: 3, name: 'محمد سعيد الحسن', phone: '0911223344', file: '2024003' }
    ].filter(p => p.name.includes(query) || p.phone.includes(query) || p.file.includes(query));

    if (results.length > 0) {
        resultsDiv.innerHTML = results.map(p => `
            <div class="search-result-item" onclick="selectPatient(${p.id}, '${p.name}', '${p.phone}')">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--primary-light));
                            border-radius: 10px; display: flex; align-items: center; justify-content: center;
                            color: white; font-weight: 700;">${p.name.charAt(0)}</div>
                <div style="flex: 1;">
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark);">${p.name}</div>
                    <div style="font-size: 12px; color: var(--gray);">رقم الملف: ${p.file}</div>
                </div>
                <span style="font-size: 12px; color: var(--primary);">اختيار</span>
            </div>
        `).join('');
        resultsDiv.style.display = 'block';
    } else {
        resultsDiv.innerHTML = `
            <div style="padding: 20px; text-align: center; color: var(--gray);">
                <i class="fas fa-search" style="font-size: 24px; margin-bottom: 8px; opacity: 0.5;"></i>
                <div>لا توجد نتائج</div>
            </div>
        `;
        resultsDiv.style.display = 'block';
    }
}

function selectPatient(id, name, phone) {
    document.getElementById('patientName').value = name;
    document.getElementById('patientPhone').value = phone;
    document.getElementById('searchResults').style.display = 'none';
    document.getElementById('patientSearch').value = '';
    showToast('تم اختيار المريض: ' + name, 'success');
}

function clearSearch() {
    document.getElementById('patientSearch').value = '';
    document.getElementById('searchResults').style.display = 'none';
}

function submitCase(e) {
    e.preventDefault();
    showLoading();

    setTimeout(() => {
        hideLoading();
        document.getElementById('successModal').classList.add('show');
        document.getElementById('successOverlay').classList.add('show');
    }, 2000);

    return false;
}

function closeSuccessModal() {
    document.getElementById('successModal').classList.remove('show');
    document.getElementById('successOverlay').classList.remove('show');
}

function showToast(message, type = 'info') {
    const colors = {
        info: 'var(--primary)',
        success: 'var(--secondary)',
        error: 'var(--danger)',
        warning: 'var(--warning)'
    };
    const toast = document.createElement('div');
    toast.innerHTML = `
        <div style="position: fixed; top: 80px; right: 16px; left: 16px; background: ${colors[type] || colors.info};
                   color: white; padding: 12px 16px; border-radius: var(--radius); z-index: 1000;
                   text-align: center; font-weight: 500; animation: slideDown 0.3s ease;">
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'info-circle'}" style="margin-left: 8px;"></i>
            ${message}
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

function showLoading() {
    const overlay = document.getElementById('pageLoadingOverlay');
    if (overlay) overlay.classList.add('active');
}

function hideLoading() {
    const overlay = document.getElementById('pageLoadingOverlay');
    if (overlay) overlay.classList.remove('active');
}
</script>
@endsection
