@extends('layouts.app')

@section('title', 'سجل المرضى')
@section('page_title', 'سجل المرضى')

@section('tabs')
<div class="tab-item active" onclick="switchTab('newpatient')">
    <i class="fas fa-user-plus" style="margin-left: 4px;"></i>
    إضافة مريض جديد
</div>
<div class="tab-item" onclick="switchTab('editpatient')">
    <i class="fas fa-user-edit" style="margin-left: 4px;"></i>
    تعديل بيانات مريض
</div>
<div class="tab-item" onclick="switchTab('accesspermissions')">
    <i class="fas fa-user-shield" style="margin-left: 4px;"></i>
    صلاحيات الوصول
</div>
<div class="tab-item" onclick="switchTab('searchcases')">
    <i class="fas fa-search" style="margin-left: 4px;"></i>
    البحث عن الحالة
</div>
<div class="tab-item" onclick="switchTab('transferpatients')">
    <i class="fas fa-exchange-alt" style="margin-left: 4px;"></i>
    تحويل المرضى
</div><div class="tab-item" onclick="switchTab('auditlog')">
    <i class="fas fa-history" style="margin-left: 4px;"></i>
    سجل العمليات
</div>
<div class="tab-item" onclick="switchTab('patientcases')">
    <i class="fas fa-clipboard-list" style="margin-left: 4px;"></i>
    حالات مريض معين
</div>

@endsection

@section('tab_content')



<!-- تبويب حالات مريض معين -->
<div class="tab-content" id="patientcasesContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-clipboard-list"></i>
        <span>حالات مريض معين</span>
    </div>

    <!-- البحث بالاسم الثلاثي -->
    <div class="input-container" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));">
        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark); margin-bottom: 14px;">
            <i class="fas fa-search" style="margin-left: 6px; color: var(--primary);"></i>
            البحث عن مريض
        </div>
        
        <div class="form-group" style="margin-bottom: 14px;">
            <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                <i class="fas fa-user" style="margin-left: 4px; color: var(--primary);"></i>
                الاسم الثلاثي للمريض
            </label>
            <div style="position: relative;">
                <input type="text" id="patientCasesSearchName" class="text-input" placeholder="أدخل الاسم الثلاثي للمريض..." style="padding-right: 40px; font-size: clamp(13px, 3.8vw, 15px);" onkeyup="if(event.key === 'Enter') searchPatientCases()">
                <i class="fas fa-user" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
            </div>
        </div>
        
        <button onclick="searchPatientCases()" style="width: 100%; background: linear-gradient(135deg, var(--primary), #6366f1); color: white; border: none; padding: 14px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fas fa-search"></i>
            بحث
        </button>
    </div>

    <!-- نتائج البحث -->
    <div id="patientCasesResults" style="margin-top: 16px;"></div>

    <!-- جدول أسنان المريض المتاحة -->
    <div id="patientTeethTableSection" style="display: none; margin-top: 16px;">
        <div class="input-container">
            <div style="margin-bottom: 16px;">
                <div style="font-size: clamp(16px, 4.5vw, 18px); font-weight: 700; color: var(--dark);">
                    <i class="fas fa-tooth" style="margin-left: 6px; color: var(--secondary);"></i>
                    <span id="patientCasesName"></span>
                </div>
                <div style="font-size: clamp(12px, 3.5vw, 14px); color: var(--gray); margin-top: 4px;">
                    <i class="fas fa-hashtag" style="margin-left: 4px;"></i>
                    <span id="patientCasesRecord"></span>
                </div>
            </div>

            <!-- ملخص الحالات -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 16px;">
                <div style="text-align: center; padding: 12px; background: rgba(79, 70, 229, 0.1); border-radius: 10px;">
                    <div style="font-size: clamp(20px, 5vw, 24px); font-weight: 800; color: var(--primary);" id="totalTeethCount">0</div>
                    <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray);">إجمالي الحالات</div>
                </div>
                <div style="text-align: center; padding: 12px; background: rgba(16, 185, 129, 0.1); border-radius: 10px;">
                    <div style="font-size: clamp(20px, 5vw, 24px); font-weight: 800; color: var(--secondary);" id="availableTeethCount">0</div>
                    <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray);">المتاحة للحجز</div>
                </div>
            </div>

            <!-- الجدول -->
            <div style="overflow-x: auto; border-radius: 12px; border: 1px solid #e5e7eb;">
                <table style="width: 100%; border-collapse: collapse; font-size: clamp(12px, 3.5vw, 14px);">
                    <thead>
                        <tr style="background: linear-gradient(135deg, var(--primary), #6366f1); color: white;">
                            <th style="padding: 14px; text-align: center; font-weight: 600;">رقم السن</th>
                            <th style="padding: 14px; text-align: center; font-weight: 600;">نوع الحالة</th>
                            <th style="padding: 14px; text-align: center; font-weight: 600;">التفاصيل</th>
                            <th style="padding: 14px; text-align: center; font-weight: 600;">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody id="patientTeethTableBody">
                        <!-- يتم ملؤه بالـ JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- ملاحظة -->
            <div style="margin-top: 16px; padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 10px; font-size: clamp(11px, 3.2vw, 13px); color: var(--warning);">
                <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
                <strong>ملاحظة:</strong> يتم عرض الأسنان غير المحجوزة وغير المنجزة فقط. اضغط على "نسخ الرمز" لنسخ رمز الحالة الخاص بكل سن.
            </div>
        </div>
    </div>
</div>





<!-- تبويب إضافة مريض جديد -->
<div class="tab-content" id="newpatientContent" style="display: block;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-user-plus"></i>
        <span>إضافة مريض جديد</span>
    </div>

    <div class="input-container" style="margin-top: 16px;">
        <!-- المعلومات الأساسية -->
        <div style="background: rgba(79, 70, 229, 0.05); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
            <div style="font-size: clamp(14px, 4vw, 16px); font-weight: 700; color: var(--primary); margin-bottom: 16px;">
                <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
                المعلومات الأساسية
            </div>

            <!-- الاسم -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-user" style="margin-left: 4px; color: var(--primary);"></i>
                    اسم المريض (الثلاثي)
                </label>
                <input type="text" id="patientName" class="text-input" placeholder="أدخل الاسم الثلاثي للمريض" style="font-size: clamp(13px, 3.8vw, 15px);">
            </div>

            <!-- الجنس -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-venus-mars" style="margin-left: 4px; color: var(--accent);"></i>
                    الجنس
                </label>
                <div style="display: flex; gap: 10px;">
                    <label class="gender-option selected" onclick="selectGender('male')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 12px; border: 2px solid var(--primary); border-radius: 10px; cursor: pointer; background: rgba(79, 70, 229, 0.05); font-size: clamp(13px, 3.8vw, 15px); font-weight: 600;">
                        <input type="radio" name="patientGender" value="male" checked style="display: none;">
                        <i class="fas fa-mars" style="color: var(--primary);"></i>
                        ذكر
                    </label>
                    <label class="gender-option" onclick="selectGender('female')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600;">
                        <input type="radio" name="patientGender" value="female" style="display: none;">
                        <i class="fas fa-venus" style="color: var(--accent);"></i>
                        أنثى
                    </label>
                </div>
            </div>

            <!-- تصنيف العمر -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-baby" style="margin-left: 4px; color: var(--warning);"></i>
                    تصنيف العمر
                </label>
                <div style="display: flex; gap: 10px;">
                    <label class="age-type-option selected" onclick="selectAgeType('child')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 12px; border: 2px solid var(--warning); border-radius: 10px; cursor: pointer; background: rgba(245, 158, 11, 0.05); font-size: clamp(13px, 3.8vw, 15px); font-weight: 600;">
                        <input type="radio" name="ageType" value="child" checked style="display: none;">
                        <i class="fas fa-child" style="color: var(--warning);"></i>
                        طفل
                    </label>
                    <label class="age-type-option" onclick="selectAgeType('adult')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600;">
                        <input type="radio" name="ageType" value="adult" style="display: none;">
                        <i class="fas fa-user" style="color: var(--secondary);"></i>
                        بالغ
                    </label>
                </div>
            </div>

            <!-- سنة الميلاد -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-calendar-alt" style="margin-left: 4px; color: var(--accent);"></i>
                    سنة الميلاد
                </label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="number" id="patientBirthYear" class="text-input" placeholder="مثال: 2015" min="1900" max="2025" style="font-size: clamp(13px, 3.8vw, 15px); flex: 1;" onchange="calculateAge()">
                    <div id="calculatedAge" style="background: linear-gradient(135deg, var(--primary), #6366f1); color: white; padding: 12px 18px; border-radius: 10px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; min-width: 100px; text-align: center; display: none;">
                        <span id="ageValue">--</span> سنة
                    </div>
                </div>
            </div>

            <!-- معلومات ولي الأمر (تظهر فقط للأطفال) -->
            <div id="parentInfoSection" style="background: rgba(245, 158, 11, 0.08); padding: 16px; border-radius: 10px; margin-top: 14px; border: 1px solid rgba(245, 158, 11, 0.2);">
                <div style="font-size: clamp(12px, 3.5vw, 14px); font-weight: 700; color: var(--warning); margin-bottom: 12px;">
                    <i class="fas fa-user-friends" style="margin-left: 6px;"></i>
                    معلومات ولي الأمر (إجباري للأطفال)
                </div>
                
                <div class="form-group" style="margin-bottom: 10px;">
                    <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 4px;">
                        اسم الأم أو ولي الأمر
                    </label>
                    <input type="text" id="parentName" class="text-input" placeholder="أدخل اسم الأم أو ولي الأمر" style="font-size: clamp(12px, 3.5vw, 14px);">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 4px;">
                            رقم موبايل ولي الأمر
                        </label>
                        <div style="display: flex; direction: ltr;">
                            <span style="background: var(--gray-light); border: 1px solid #e5e7eb; border-left: none; padding: 10px; border-radius: 8px 0 0 8px; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600;">09</span>
                            <input type="tel" id="parentPhone" class="text-input" placeholder="12345678" maxlength="8" style="border-radius: 0 8px 8px 0; font-size: clamp(12px, 3.5vw, 14px); direction: ltr; text-align: left;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 4px;">
                            سنة ميلاد ولي الأمر
                        </label>
                        <input type="number" id="parentBirthYear" class="text-input" placeholder="مثال: 1980" min="1950" max="2005" style="font-size: clamp(12px, 3.5vw, 14px);">
                    </div>
                </div>
            </div>

            <!-- رقم الموبايل -->
            <div class="form-group" style="margin-top: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-phone" style="margin-left: 4px; color: var(--secondary);"></i>
                    رقم موبايل المريض (إن وجد)
                </label>
                <div style="display: flex; direction: ltr;">
                    <span style="background: var(--gray-light); border: 1px solid #e5e7eb; border-left: none; padding: 12px; border-radius: 8px 0 0 8px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600;">09</span>
                    <input type="tel" id="patientPhone" class="text-input" placeholder="12345678" maxlength="8" style="border-radius: 0 8px 8px 0; font-size: clamp(13px, 3.8vw, 15px); direction: ltr; text-align: left;">
                </div>
            </div>

            <!-- المحافظة والعنوان -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 14px;">
                <div class="form-group">
                    <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                        <i class="fas fa-map-marker-alt" style="margin-left: 4px; color: var(--danger);"></i>
                        المحافظة
                    </label>
                    <select id="patientGovernorate" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                        <option value="">اختر المحافظة</option>
                        <option value="damascus">دمشق</option>
                        <option value="rif_damascus">ريف دمشق</option>
                        <option value="aleppo">حلب</option>
                        <option value="homs">حمص</option>
                        <option value="hama">حماة</option>
                        <option value="latakia">اللاذقية</option>
                        <option value="tartous">طرطوس</option>
                        <option value="idlib">إدلب</option>
                        <option value="deir_ezzor">دير الزور</option>
                        <option value="hasakah">الحسكة</option>
                        <option value="raqqa">الرقة</option>
                        <option value="daraa">درعا</option>
                        <option value="suwayda">السويداء</option>
                        <option value="quneitra">القنيطرة</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                        <i class="fas fa-home" style="margin-left: 4px; color: var(--warning);"></i>
                        مكان السكن
                    </label>
                    <input type="text" id="patientAddress" class="text-input" placeholder="الحي / المنطقة" style="font-size: clamp(12px, 3.5vw, 14px);">
                </div>
            </div>
        </div>

        <!-- الحالة الصحية -->
        <div style="background: rgba(239, 68, 68, 0.05); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
            <div style="font-size: clamp(14px, 4vw, 16px); font-weight: 700; color: var(--danger); margin-bottom: 14px;">
                <i class="fas fa-heartbeat" style="margin-left: 6px;"></i>
                الحالة الصحية
            </div>

            <!-- الأمراض المزمنة -->
            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    الأمراض المزمنة (اختر ما ينطبق)
                </label>
                <div id="diseasesContainer" style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <label class="health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px);" onclick="toggleHealthOption(this)">
                        <input type="checkbox" name="diseases" value="diabetes" style="display: none;">
                        <i class="fas fa-tint" style="color: var(--warning);"></i>
                        السكري
                    </label>
                    <label class="health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px);" onclick="toggleHealthOption(this)">
                        <input type="checkbox" name="diseases" value="hypertension" style="display: none;">
                        <i class="fas fa-heart" style="color: var(--danger);"></i>
                        الضغط
                    </label>
                    <label class="health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px);" onclick="toggleHealthOption(this)">
                        <input type="checkbox" name="diseases" value="rheumatoid" style="display: none;">
                        <i class="fas fa-bone" style="color: var(--primary);"></i>
                        التهاب رثوي
                    </label>
                    <label class="health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px);" onclick="toggleHealthOption(this)">
                        <input type="checkbox" name="diseases" value="heart_disease" style="display: none;">
                        <i class="fas fa-heartbeat" style="color: var(--danger);"></i>
                        أمراض القلب
                    </label>
                    <button type="button" onclick="showAddDiseaseModal()" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px dashed var(--secondary); border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px); background: rgba(16, 185, 129, 0.05); color: var(--secondary);">
                        <i class="fas fa-plus"></i>
                        إضافة مرض
                    </button>
                </div>
                <div id="addedDiseasesList" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px;"></div>
            </div>

            <!-- حالة السكري -->
            <div id="diabetesControl" style="display: none; margin-bottom: 12px; padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 8px;">
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--warning); margin-bottom: 6px;">
                    <i class="fas fa-tint" style="margin-left: 4px;"></i>
                    هل السكر مضبوط؟
                </label>
                <div style="display: flex; gap: 10px;">
                    <label class="control-option" onclick="selectControl('diabetes', 'yes')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(11px, 3.2vw, 13px);">
                        <input type="radio" name="diabetesControlled" value="yes" style="display: none;">
                        <i class="fas fa-check" style="color: var(--secondary);"></i>
                        مضبوط
                    </label>
                    <label class="control-option" onclick="selectControl('diabetes', 'no')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(11px, 3.2vw, 13px);">
                        <input type="radio" name="diabetesControlled" value="no" style="display: none;">
                        <i class="fas fa-times" style="color: var(--danger);"></i>
                        غير مضبوط
                    </label>
                </div>
            </div>

            <!-- حالة الضغط -->
            <div id="hypertensionControl" style="display: none; margin-bottom: 12px; padding: 12px; background: rgba(239, 68, 68, 0.1); border-radius: 8px;">
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--danger); margin-bottom: 6px;">
                    <i class="fas fa-heart" style="margin-left: 4px;"></i>
                    هل الضغط مضبوط؟
                </label>
                <div style="display: flex; gap: 10px;">
                    <label class="control-option" onclick="selectControl('bp', 'yes')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(11px, 3.2vw, 13px);">
                        <input type="radio" name="bpControlled" value="yes" style="display: none;">
                        <i class="fas fa-check" style="color: var(--secondary);"></i>
                        مضبوط
                    </label>
                    <label class="control-option" onclick="selectControl('bp', 'no')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(11px, 3.2vw, 13px);">
                        <input type="radio" name="bpControlled" value="no" style="display: none;">
                        <i class="fas fa-times" style="color: var(--danger);"></i>
                        غير مضبوط
                    </label>
                </div>
            </div>
        </div>

        <!-- مخطط الأسنان FDI المحسّن -->
        <div style="background: rgba(16, 185, 129, 0.05); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
            <div style="font-size: clamp(14px, 4vw, 16px); font-weight: 700; color: var(--secondary); margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center;">
                <span>
                    <i class="fas fa-tooth" style="margin-left: 6px;"></i>
                    مخطط الأسنان (FDI)
                </span>
                <span style="font-size: clamp(10px, 3vw, 12px); color: var(--gray); font-weight: 500; background: white; padding: 4px 10px; border-radius: 20px;">
                    اضغط على السن لتحديد الحالة
                </span>
            </div>

            <!-- الأسنان الدائمة (الفك العلوي) -->
            <div style="margin-bottom: 16px;">
                <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray); text-align: center; margin-bottom: 8px; font-weight: 600;">
                    <i class="fas fa-tooth" style="margin-left: 4px; color: var(--primary);"></i>
                    الأسنان الدائمة - الفك العلوي
                </div>
                <div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap; margin-bottom: 8px;">
                    <!-- الربع الأول (يمين علوي) 18-11 -->
                    <div style="display: flex; gap: 3px;">
                        <button class="tooth-btn permanent" data-tooth="18" onclick="selectTooth(18)" title="ضرس العقل العلوي الأيمن">18</button>
                        <button class="tooth-btn permanent" data-tooth="17" onclick="selectTooth(17)" title="الضرس الثاني العلوي الأيمن">17</button>
                        <button class="tooth-btn permanent" data-tooth="16" onclick="selectTooth(16)" title="الضرس الأول العلوي الأيمن">16</button>
                        <button class="tooth-btn permanent" data-tooth="15" onclick="selectTooth(15)" title="الرحى الثانية العلوية اليمنى">15</button>
                        <button class="tooth-btn permanent" data-tooth="14" onclick="selectTooth(14)" title="الرحى الأولى العلوية اليمنى">14</button>
                        <button class="tooth-btn permanent" data-tooth="13" onclick="selectTooth(13)" title="النياب العلوية اليمنى">13</button>
                        <button class="tooth-btn permanent" data-tooth="12" onclick="selectTooth(12)" title="الرباعية العلوية اليمنى">12</button>
                        <button class="tooth-btn permanent" data-tooth="11" onclick="selectTooth(11)" title="القطعية المركزية العلوية اليمنى">11</button>
                    </div>
                    <div style="width: 12px;"></div>
                    <!-- الربع الثاني (يسار علوي) 21-28 -->
                    <div style="display: flex; gap: 3px;">
                        <button class="tooth-btn permanent" data-tooth="21" onclick="selectTooth(21)" title="القطعية المركزية العلوية اليسرى">21</button>
                        <button class="tooth-btn permanent" data-tooth="22" onclick="selectTooth(22)" title="الرباعية العلوية اليسرى">22</button>
                        <button class="tooth-btn permanent" data-tooth="23" onclick="selectTooth(23)" title="النياب العلوية اليسرى">23</button>
                        <button class="tooth-btn permanent" data-tooth="24" onclick="selectTooth(24)" title="الرحى الأولى العلوية اليسرى">24</button>
                        <button class="tooth-btn permanent" data-tooth="25" onclick="selectTooth(25)" title="الرحى الثانية العلوية اليسرى">25</button>
                        <button class="tooth-btn permanent" data-tooth="26" onclick="selectTooth(26)" title="الضرس الأول العلوي الأيسر">26</button>
                        <button class="tooth-btn permanent" data-tooth="27" onclick="selectTooth(27)" title="الضرس الثاني العلوي الأيسر">27</button>
                        <button class="tooth-btn permanent" data-tooth="28" onclick="selectTooth(28)" title="ضرس العقل العلوي الأيسر">28</button>
                    </div>
                </div>
            </div>

            <!-- الأسنان الدائمة (الفك السفلي) -->
            <div style="margin-bottom: 16px;">
                <div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap; margin-bottom: 8px;">
                    <!-- الربع الرابع (يمين سفلي) 48-41 -->
                    <div style="display: flex; gap: 3px;">
                        <button class="tooth-btn permanent" data-tooth="48" onclick="selectTooth(48)" title="ضرس العقل السفلي الأيمن">48</button>
                        <button class="tooth-btn permanent" data-tooth="47" onclick="selectTooth(47)" title="الضرس الثاني السفلي الأيمن">47</button>
                        <button class="tooth-btn permanent" data-tooth="46" onclick="selectTooth(46)" title="الضرس الأول السفلي الأيمن">46</button>
                        <button class="tooth-btn permanent" data-tooth="45" onclick="selectTooth(45)" title="الرحى الثانية السفلية اليمنى">45</button>
                        <button class="tooth-btn permanent" data-tooth="44" onclick="selectTooth(44)" title="الرحى الأولى السفلية اليمنى">44</button>
                        <button class="tooth-btn permanent" data-tooth="43" onclick="selectTooth(43)" title="النياب السفلية اليمنى">43</button>
                        <button class="tooth-btn permanent" data-tooth="42" onclick="selectTooth(42)" title="الرباعية السفلية اليمنى">42</button>
                        <button class="tooth-btn permanent" data-tooth="41" onclick="selectTooth(41)" title="القطعية المركزية السفلية اليمنى">41</button>
                    </div>
                    <div style="width: 12px;"></div>
                    <!-- الربع الثالث (يسار سفلي) 31-38 -->
                    <div style="display: flex; gap: 3px;">
                        <button class="tooth-btn permanent" data-tooth="31" onclick="selectTooth(31)" title="القطعية المركزية السفلية اليسرى">31</button>
                        <button class="tooth-btn permanent" data-tooth="32" onclick="selectTooth(32)" title="الرباعية السفلية اليسرى">32</button>
                        <button class="tooth-btn permanent" data-tooth="33" onclick="selectTooth(33)" title="النياب السفلية اليسرى">33</button>
                        <button class="tooth-btn permanent" data-tooth="34" onclick="selectTooth(34)" title="الرحى الأولى السفلية اليسرى">34</button>
                        <button class="tooth-btn permanent" data-tooth="35" onclick="selectTooth(35)" title="الرحى الثانية السفلية اليسرى">35</button>
                        <button class="tooth-btn permanent" data-tooth="36" onclick="selectTooth(36)" title="الضرس الأول السفلي الأيسر">36</button>
                        <button class="tooth-btn permanent" data-tooth="37" onclick="selectTooth(37)" title="الضرس الثاني السفلي الأيسر">37</button>
                        <button class="tooth-btn permanent" data-tooth="38" onclick="selectTooth(38)" title="ضرس العقل السفلي الأيسر">38</button>
                    </div>
                </div>
                <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray); text-align: center; font-weight: 600;">
                    <i class="fas fa-tooth" style="margin-left: 4px; color: var(--primary);"></i>
                    الأسنان الدائمة - الفك السفلي
                </div>
            </div>

            <!-- الأسنان المؤقتة (للأطفال) -->
            <div id="primaryTeethSection" style="margin-top: 20px; padding-top: 20px; border-top: 2px dashed #e5e7eb;">
                <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--warning); text-align: center; margin-bottom: 12px; font-weight: 600;">
                    <i class="fas fa-baby" style="margin-left: 4px;"></i>
                    الأسنان المؤقتة (اللبنية) - للأطفال
                </div>
                
                <!-- الأسنان المؤقتة العلوية -->
                <div style="margin-bottom: 12px;">
                    <div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap; margin-bottom: 6px;">
                        <!-- الربع الخامس (يمين علوي) 55-51 -->
                        <div style="display: flex; gap: 3px;">
                            <button class="tooth-btn primary" data-tooth="55" onclick="selectTooth(55)" title="الضرس الثاني اللبني العلوي الأيمن">55</button>
                            <button class="tooth-btn primary" data-tooth="54" onclick="selectTooth(54)" title="الضرس الأول اللبني العلوي الأيمن">54</button>
                            <button class="tooth-btn primary" data-tooth="53" onclick="selectTooth(53)" title="النياب اللبنية العلوية اليمنى">53</button>
                            <button class="tooth-btn primary" data-tooth="52" onclick="selectTooth(52)" title="الرباعية اللبنية العلوية اليمنى">52</button>
                            <button class="tooth-btn primary" data-tooth="51" onclick="selectTooth(51)" title="القطعية اللبنية العلوية اليمنى">51</button>
                        </div>
                        <div style="width: 12px;"></div>
                        <!-- الربع السادس (يسار علوي) 61-65 -->
                        <div style="display: flex; gap: 3px;">
                            <button class="tooth-btn primary" data-tooth="61" onclick="selectTooth(61)" title="القطعية اللبنية العلوية اليسرى">61</button>
                            <button class="tooth-btn primary" data-tooth="62" onclick="selectTooth(62)" title="الرباعية اللبنية العلوية اليسرى">62</button>
                            <button class="tooth-btn primary" data-tooth="63" onclick="selectTooth(63)" title="النياب اللبنية العلوية اليسرى">63</button>
                            <button class="tooth-btn primary" data-tooth="64" onclick="selectTooth(64)" title="الضرس الأول اللبني العلوي الأيسر">64</button>
                            <button class="tooth-btn primary" data-tooth="65" onclick="selectTooth(65)" title="الضرس الثاني اللبني العلوي الأيسر">65</button>
                        </div>
                    </div>
                </div>

                <!-- الأسنان المؤقتة السفلية -->
                <div>
                    <div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap; margin-bottom: 6px;">
                        <!-- الربع الثامن (يمين سفلي) 85-81 -->
                        <div style="display: flex; gap: 3px;">
                            <button class="tooth-btn primary" data-tooth="85" onclick="selectTooth(85)" title="الضرس الثاني اللبني السفلي الأيمن">85</button>
                            <button class="tooth-btn primary" data-tooth="84" onclick="selectTooth(84)" title="الضرس الأول اللبني السفلي الأيمن">84</button>
                            <button class="tooth-btn primary" data-tooth="83" onclick="selectTooth(83)" title="النياب اللبنية السفلية اليمنى">83</button>
                            <button class="tooth-btn primary" data-tooth="82" onclick="selectTooth(82)" title="الرباعية اللبنية السفلية اليمنى">82</button>
                            <button class="tooth-btn primary" data-tooth="81" onclick="selectTooth(81)" title="القطعية اللبنية السفلية اليمنى">81</button>
                        </div>
                        <div style="width: 12px;"></div>
                        <!-- الربع السابع (يسار سفلي) 71-75 -->
                        <div style="display: flex; gap: 3px;">
                            <button class="tooth-btn primary" data-tooth="71" onclick="selectTooth(71)" title="القطعية اللبنية السفلية اليسرى">71</button>
                            <button class="tooth-btn primary" data-tooth="72" onclick="selectTooth(72)" title="الرباعية اللبنية السفلية اليسرى">72</button>
                            <button class="tooth-btn primary" data-tooth="73" onclick="selectTooth(73)" title="النياب اللبنية السفلية اليسرى">73</button>
                            <button class="tooth-btn primary" data-tooth="74" onclick="selectTooth(74)" title="الضرس الأول اللبني السفلي الأيسر">74</button>
                            <button class="tooth-btn primary" data-tooth="75" onclick="selectTooth(75)" title="الضرس الثاني اللبني السفلي الأيسر">75</button>
                        </div>
                    </div>
                    <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--warning); text-align: center; font-weight: 600;">
                        <i class="fas fa-baby" style="margin-left: 4px;"></i>
                        الأسنان المؤقتة - الفك السفلي
                    </div>
                </div>
            </div>

            <!-- دليل الألوان والتموينات -->
            <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                <div style="font-size: clamp(11px, 3.2vw, 13px); font-weight: 700; color: var(--dark); margin-bottom: 10px;">
                    <i class="fas fa-palette" style="margin-left: 4px; color: var(--primary);"></i>
                    دليل الألوان والحالات:
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <span class="tooltip" style="font-size: clamp(10px, 3vw, 12px); display: flex; align-items: center; gap: 4px; padding: 6px 10px; background: rgba(79, 70, 229, 0.1); border-radius: 8px; font-weight: 500;">
                        <span style="width: 14px; height: 14px; background: var(--primary); border-radius: 4px;"></span>
                        ترميمية (حشوة)
                        <span class="tooltip-text">حشوات تجميلية ووظيفية</span>
                    </span>
                    <span class="tooltip" style="font-size: clamp(10px, 3vw, 12px); display: flex; align-items: center; gap: 4px; padding: 6px 10px; background: rgba(245, 158, 11, 0.1); border-radius: 8px; font-weight: 500;">
                        <span style="width: 14px; height: 14px; background: var(--warning); border-radius: 4px;"></span>
                        لبية (عصب)
                        <span class="tooltip-text">معالجة الجذر واللب</span>
                    </span>
                    <span class="tooltip" style="font-size: clamp(10px, 3vw, 12px); display: flex; align-items: center; gap: 4px; padding: 6px 10px; background: rgba(239, 68, 68, 0.1); border-radius: 8px; font-weight: 500;">
                        <span style="width: 14px; height: 14px; background: var(--danger); border-radius: 4px;"></span>
                        قلع (خلع)
                        <span class="tooltip-text">إزالة السن</span>
                    </span>
                    <span class="tooltip" style="font-size: clamp(10px, 3vw, 12px); display: flex; align-items: center; gap: 4px; padding: 6px 10px; background: rgba(107, 114, 128, 0.1); border-radius: 8px; font-weight: 500;">
                        <span style="width: 14px; height: 14px; background: var(--gray); border-radius: 4px;"></span>
                        مفقود
                        <span class="tooltip-text">السن غير موجود</span>
                    </span>
                    <span class="tooltip" style="font-size: clamp(10px, 3vw, 12px); display: flex; align-items: center; gap: 4px; padding: 6px 10px; background: rgba(16, 185, 129, 0.1); border-radius: 8px; font-weight: 500;">
                        <span style="width: 14px; height: 14px; background: var(--secondary); border-radius: 4px;"></span>
                        بتر لو (تاج)
                        <span class="tooltip-text">تاج للسن المؤقت</span>
                    </span>
                    <span class="tooltip" style="font-size: clamp(10px, 3vw, 12px); display: flex; align-items: center; gap: 4px; padding: 6px 10px; background: rgba(236, 72, 153, 0.1); border-radius: 8px; font-weight: 500;">
                        <span style="width: 14px; height: 14px; background: var(--accent); border-radius: 4px;"></span>
                        ترميم محافظ
                        <span class="tooltip-text">حشوة محافظة للسن المؤقت</span>
                    </span>
                </div>
            </div>

            <!-- إحصائيات الأسنان -->
            <div id="teethStats" style="display: none; margin-top: 16px; padding: 16px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(79, 70, 229, 0.1)); border-radius: 12px;">
                <div style="font-size: clamp(11px, 3.2vw, 13px); font-weight: 700; color: var(--dark); margin-bottom: 12px;">
                    <i class="fas fa-calculator" style="margin-left: 4px; color: var(--secondary);"></i>
                    إحصائيات الأسنان:
                </div>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                    <div style="text-align: center; padding: 12px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: clamp(18px, 5vw, 22px); font-weight: 800; color: var(--secondary);" id="fixedTeethCount">0</div>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray); font-weight: 500;">تعويضات ثابتة</div>
                    </div>
                    <div style="text-align: center; padding: 12px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: clamp(18px, 5vw, 22px); font-weight: 800; color: var(--warning);" id="mobileTeethCount">0</div>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray); font-weight: 500;">تعويضات متحركة</div>
                    </div>
                    <div style="text-align: center; padding: 12px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: clamp(18px, 5vw, 22px); font-weight: 800; color: var(--gray);" id="missingTeethCount">0</div>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray); font-weight: 500;">أسنان مفقودة</div>
                    </div>
                    <div style="text-align: center; padding: 12px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: clamp(18px, 5vw, 22px); font-weight: 800; color: var(--primary);" id="totalSelectedTeeth">0</div>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray); font-weight: 500;">إجمالي المحدد</div>
                    </div>
                </div>
                
                <!-- تحديد نوع التعويض تلقائياً -->
                <div id="prosthesisType" style="margin-top: 12px; padding: 12px; background: white; border-radius: 10px; display: none;">
                    <div style="font-size: clamp(10px, 3vw, 12px); font-weight: 700; color: var(--dark); margin-bottom: 6px;">
                        <i class="fas fa-magic" style="margin-left: 4px; color: var(--accent);"></i>
                        تحديد نوع التعويض (تلقائي):
                    </div>
                    <div id="prosthesisResult" style="font-size: clamp(12px, 3.5vw, 14px); color: var(--primary); font-weight: 600;"></div>
                </div>
            </div>

            <!-- قائمة الأسنان المحددة -->
            <div id="selectedTeethList" style="margin-top: 16px; display: none;">
                <div style="font-size: clamp(12px, 3.5vw, 14px); font-weight: 700; color: var(--dark); margin-bottom: 10px;">
                    <i class="fas fa-list" style="margin-left: 4px; color: var(--primary);"></i>
                    الأسنان المحددة:
                </div>
                <div id="teethListContainer" style="max-height: 200px; overflow-y: auto;"></div>
            </div>
        </div>

        <!-- صلاحيات الوصول -->
        <div style="background: rgba(236, 72, 153, 0.05); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
            <div style="font-size: clamp(14px, 4vw, 16px); font-weight: 700; color: var(--accent); margin-bottom: 14px;">
                <i class="fas fa-lock" style="margin-left: 6px;"></i>
                صلاحيات الوصول
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <label class="access-option selected" style="display: flex; align-items: center; gap: 12px; padding: 14px; border: 2px solid var(--primary); border-radius: 12px; cursor: pointer; background: rgba(79, 70, 229, 0.05);" onclick="selectAccessType('private')">
                    <input type="radio" name="accessType" value="private" checked style="display: none;">
                    <div style="width: 44px; height: 44px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-shield" style="color: white; font-size: 18px;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark);">خاص (لي فقط)</div>
                        <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray); margin-top: 2px;">أنت فقط تستطيع رؤية وإدارة هذا المريض</div>
                    </div>
                    <i class="fas fa-check-circle access-check" style="color: var(--primary); font-size: 22px;"></i>
                </label>

                <label class="access-option" style="display: flex; align-items: center; gap: 12px; padding: 14px; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer;" onclick="selectAccessType('public')">
                    <input type="radio" name="accessType" value="public" style="display: none;">
                    <div style="width: 44px; height: 44px; background: var(--secondary); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-globe" style="color: white; font-size: 18px;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark);">عام (للجميع)</div>
                        <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray); margin-top: 2px;">جميع الطلاب يستطيعون رؤية هذا المريض</div>
                    </div>
                    <i class="fas fa-check-circle access-check" style="color: #e5e7eb; font-size: 22px;"></i>
                </label>

                <label class="access-option" style="display: flex; align-items: center; gap: 12px; padding: 14px; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer;" onclick="selectAccessType('custom')">
                    <input type="radio" name="accessType" value="custom" style="display: none;">
                    <div style="width: 44px; height: 44px; background: var(--warning); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users-cog" style="color: white; font-size: 18px;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark);">مخصص (طلاب محددين)</div>
                        <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray); margin-top: 2px;">أنت مدير الحالة ويمكنك إضافة/إزالة طلاب</div>
                    </div>
                    <i class="fas fa-check-circle access-check" style="color: #e5e7eb; font-size: 22px;"></i>
                </label>
            </div>

            <!-- إضافة طلاب مخصصين -->
            <div id="customStudentsSection" style="display: none; margin-top: 14px; padding: 14px; background: rgba(245, 158, 11, 0.1); border-radius: 12px;">
                <div style="font-size: clamp(12px, 3.5vw, 14px); font-weight: 700; color: var(--warning); margin-bottom: 10px;">
                    <i class="fas fa-user-plus" style="margin-left: 4px;"></i>
                    إضافة طلاب بالرقم الجامعي
                </div>
                <div style="display: flex; gap: 8px; margin-bottom: 10px;">
                    <input type="text" id="studentIdInput" class="text-input" placeholder="أدخل الرقم الجامعي" style="flex: 1; font-size: clamp(12px, 3.5vw, 14px);">
                    <button onclick="addStudent()" style="background: var(--warning); color: white; border: none; padding: 12px 18px; border-radius: 10px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div id="studentsList" style="display: flex; flex-wrap: wrap; gap: 6px;"></div>
                <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray); margin-top: 10px;">
                    <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                    أنت مدير الحالة ويمكنك تغيير الطلاب في أي وقت
                </div>
            </div>
        </div>

        <!-- ملاحظات -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                <i class="fas fa-notes-medical" style="margin-left: 6px; color: var(--gray);"></i>
                ملاحظات إضافية
            </label>
            <textarea id="patientNotes" class="text-input" rows="3" placeholder="أضف ملاحظات عن المريض..." style="resize: none; font-size: clamp(12px, 3.5vw, 14px);"></textarea>
        </div>

        <!-- زر الإضافة -->
        <button onclick="addNewPatient()" style="width: 100%; background: linear-gradient(135deg, var(--primary), #6366f1); color: white; border: none; padding: 16px; border-radius: 14px; font-size: clamp(15px, 4.2vw, 17px); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 20px rgba(79, 70, 229, 0.3); transition: all 0.3s;">
            <i class="fas fa-plus-circle" style="font-size: 18px;"></i>
            إضافة المريض
        </button>

        <!-- تنبيه المراجعة الإجبارية -->
        <div style="margin-top: 16px; padding: 14px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05)); border: 2px solid rgba(245, 158, 11, 0.3); border-radius: 12px; display: flex; align-items: start; gap: 12px;">
            <div style="width: 40px; height: 40px; background: var(--warning); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas fa-exclamation-triangle" style="color: white; font-size: 18px;"></i>
            </div>
            <div>
                <div style="font-size: clamp(12px, 3.5vw, 14px); font-weight: 700; color: var(--warning);">ملاحظة هامة</div>
                <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray-dark); margin-top: 4px; line-height: 1.6;">
                    أي تعديل على بيانات المريض بعد التثبيت يتطلب مراجعة <strong style="color: var(--primary);">مكتب قبول المرضى</strong> بشكل إجباري. 
                    سيتم توثيق جميع التعديلات بالسجل التاريخي.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- تبويب تعديل بيانات مريض -->
<div class="tab-content" id="editpatientContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-user-edit"></i>
        <span>تعديل بيانات مريض</span>
    </div>

    <!-- البحث عن المريض -->
    <div class="input-container" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(236, 72, 153, 0.05));">
        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark); margin-bottom: 14px;">
            <i class="fas fa-search" style="margin-left: 6px; color: var(--primary);"></i>
            البحث عن المريض
        </div>
        
        <div style="display: flex; gap: 10px; margin-bottom: 14px;">
            <div style="flex: 1;">
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">البحث بالرقم الجامعي للطالب</label>
                <div style="position: relative;">
                    <input type="text" id="editSearchStudentId" class="text-input" placeholder="أدخل الرقم الجامعي..." style="padding-right: 40px; font-size: clamp(12px, 3.5vw, 14px);">
                    <i class="fas fa-id-card" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
                </div>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">البحث بالاسم الثلاثي</label>
                <div style="position: relative;">
                    <input type="text" id="editSearchPatientName" class="text-input" placeholder="أدخل الاسم الثلاثي..." style="padding-right: 40px; font-size: clamp(12px, 3.5vw, 14px);">
                    <i class="fas fa-user" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
                </div>
            </div>
        </div>
        
        <button onclick="searchPatientForEdit()" style="width: 100%; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 10px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; cursor: pointer;">
            <i class="fas fa-search" style="margin-left: 6px;"></i>
            بحث
        </button>
    </div>

    <!-- نتائج البحث -->
    <div id="editSearchResults" style="margin-top: 16px;"></div>

    <!-- نموذج التعديل الكامل (يظهر بعد اختيار المريض) -->
    <div id="editPatientForm" style="display: none; margin-top: 16px;">
        <div class="input-container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div style="font-size: clamp(14px, 4vw, 16px); font-weight: 700; color: var(--dark);">
                    <i class="fas fa-edit" style="margin-left: 6px; color: var(--primary);"></i>
                    تعديل البيانات الكامل
                </div>
                <div id="editPatientBadge" style="background: var(--primary); color: white; padding: 6px 12px; border-radius: 20px; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600;"></div>
            </div>

            <!-- المعلومات الأساسية -->
            <div style="background: rgba(79, 70, 229, 0.05); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
                <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--primary); margin-bottom: 14px;">
                    <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
                    المعلومات الأساسية
                </div>

                <!-- الاسم -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                        <i class="fas fa-user" style="margin-left: 4px; color: var(--primary);"></i>
                        اسم المريض (الثلاثي)
                    </label>
                    <input type="text" id="editPatientName" class="text-input" style="font-size: clamp(13px, 3.8vw, 15px);">
                </div>

                <!-- الجنس -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        <i class="fas fa-venus-mars" style="margin-left: 4px; color: var(--accent);"></i>
                        الجنس
                    </label>
                    <div style="display: flex; gap: 10px;">
                        <label class="edit-gender-option" id="editGenderMale" onclick="selectEditGender('male')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600;">
                            <input type="radio" name="editPatientGender" value="male" style="display: none;">
                            <i class="fas fa-mars" style="color: var(--primary);"></i>
                            ذكر
                        </label>
                        <label class="edit-gender-option" id="editGenderFemale" onclick="selectEditGender('female')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600;">
                            <input type="radio" name="editPatientGender" value="female" style="display: none;">
                            <i class="fas fa-venus" style="color: var(--accent);"></i>
                            أنثى
                        </label>
                    </div>
                </div>

                <!-- سنة الميلاد -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                        <i class="fas fa-calendar-alt" style="margin-left: 4px; color: var(--accent);"></i>
                        سنة الميلاد
                    </label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="number" id="editPatientBirthYear" class="text-input" min="1900" max="2025" style="font-size: clamp(13px, 3.8vw, 15px); flex: 1;" onchange="calculateEditAge()">
                        <div id="editCalculatedAge" style="background: linear-gradient(135deg, var(--primary), #6366f1); color: white; padding: 12px 18px; border-radius: 10px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; min-width: 100px; text-align: center; display: none;">
                            <span id="editAgeValue">--</span> سنة
                        </div>
                    </div>
                </div>

                <!-- رقم الموبايل -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                        <i class="fas fa-phone" style="margin-left: 4px; color: var(--secondary);"></i>
                        رقم موبايل المريض
                    </label>
                    <div style="display: flex; direction: ltr;">
                        <span style="background: var(--gray-light); border: 1px solid #e5e7eb; border-left: none; padding: 12px; border-radius: 8px 0 0 8px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600;">09</span>
                        <input type="tel" id="editPatientPhone" class="text-input" maxlength="8" style="border-radius: 0 8px 8px 0; font-size: clamp(13px, 3.8vw, 15px); direction: ltr; text-align: left;">
                    </div>
                </div>

                <!-- المحافظة والعنوان -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                            <i class="fas fa-map-marker-alt" style="margin-left: 4px; color: var(--danger);"></i>
                            المحافظة
                        </label>
                        <select id="editPatientGovernorate" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                            <option value="">اختر المحافظة</option>
                            <option value="damascus">دمشق</option>
                            <option value="rif_damascus">ريف دمشق</option>
                            <option value="aleppo">حلب</option>
                            <option value="homs">حمص</option>
                            <option value="hama">حماة</option>
                            <option value="latakia">اللاذقية</option>
                            <option value="tartous">طرطوس</option>
                            <option value="idlib">إدلب</option>
                            <option value="deir_ezzor">دير الزور</option>
                            <option value="hasakah">الحسكة</option>
                            <option value="raqqa">الرقة</option>
                            <option value="daraa">درعا</option>
                            <option value="suwayda">السويداء</option>
                            <option value="quneitra">القنيطرة</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                            <i class="fas fa-home" style="margin-left: 4px; color: var(--warning);"></i>
                            مكان السكن
                        </label>
                        <input type="text" id="editPatientAddress" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                    </div>
                </div>
            </div>

            <!-- الحالة الصحية -->
            <div style="background: rgba(239, 68, 68, 0.05); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
                <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--danger); margin-bottom: 14px;">
                    <i class="fas fa-heartbeat" style="margin-left: 6px;"></i>
                    الحالة الصحية
                </div>

                <div class="form-group" style="margin-bottom: 12px;">
                    <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        الأمراض المزمنة (اختر ما ينطبق)
                    </label>
                    <div id="editDiseasesContainer" style="display: flex; flex-wrap: wrap; gap: 8px;">
                        <label class="edit-health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px);" onclick="toggleEditHealthOption(this)">
                            <input type="checkbox" name="editDiseases" value="diabetes" style="display: none;">
                            <i class="fas fa-tint" style="color: var(--warning);"></i>
                            السكري
                        </label>
                        <label class="edit-health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px);" onclick="toggleEditHealthOption(this)">
                            <input type="checkbox" name="editDiseases" value="hypertension" style="display: none;">
                            <i class="fas fa-heart" style="color: var(--danger);"></i>
                            الضغط
                        </label>
                        <label class="edit-health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px);" onclick="toggleEditHealthOption(this)">
                            <input type="checkbox" name="editDiseases" value="rheumatoid" style="display: none;">
                            <i class="fas fa-bone" style="color: var(--primary);"></i>
                            التهاب رثوي
                        </label>
                        <label class="edit-health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: clamp(12px, 3.5vw, 14px);" onclick="toggleEditHealthOption(this)">
                            <input type="checkbox" name="editDiseases" value="heart_disease" style="display: none;">
                            <i class="fas fa-heartbeat" style="color: var(--danger);"></i>
                            أمراض القلب
                        </label>
                    </div>
                </div>
            </div>

            <!-- مخطط الأسنان -->
            <div style="background: rgba(16, 185, 129, 0.05); padding: 16px; border-radius: 12px; margin-bottom: 16px;">
                <div style="font-size: clamp(14px, 4vw, 16px); font-weight: 700; color: var(--secondary); margin-bottom: 14px;">
                    <i class="fas fa-tooth" style="margin-left: 6px;"></i>
                    تعديل مخطط الأسنان (FDI)
                </div>
                
                <!-- نسخة مبسطة من مخطط الأسنان للتعديل -->
                <div id="editTeethChart" style="margin-bottom: 16px;">
                    <!-- سيتم ملؤه بـ JavaScript -->
                </div>

                <!-- قائمة الأسنان المحددة للتعديل -->
                <div id="editSelectedTeethList" style="margin-top: 16px;">
                    <div style="font-size: clamp(12px, 3.5vw, 14px); font-weight: 700; color: var(--dark); margin-bottom: 10px;">
                        <i class="fas fa-list" style="margin-left: 4px; color: var(--primary);"></i>
                        الأسنان المحددة:
                    </div>
                    <div id="editTeethListContainer" style="max-height: 200px; overflow-y: auto;"></div>
                </div>
            </div>

            <!-- ملاحظات -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-notes-medical" style="margin-left: 4px; color: var(--gray);"></i>
                    ملاحظات إضافية
                </label>
                <textarea id="editPatientNotes" class="text-input" rows="3" style="resize: none; font-size: clamp(12px, 3.5vw, 14px);"></textarea>
            </div>

            <!-- سبب التعديل -->
            <div class="form-group" style="margin-top: 16px; padding: 16px; background: rgba(245, 158, 11, 0.1); border-radius: 10px; border: 1px solid rgba(245, 158, 11, 0.3);">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 700; color: var(--warning); margin-bottom: 8px;">
                    <i class="fas fa-comment-alt" style="margin-left: 4px;"></i>
                    سبب التعديل (إجباري) *
                </label>
                <textarea id="editReason" class="text-input" rows="2" placeholder="اكتب سبب التعديل بالتفصيل..." style="resize: none; font-size: clamp(12px, 3.5vw, 14px);"></textarea>
            </div>

            <!-- أزرار التحكم -->
            <div style="display: flex; gap: 10px; margin-top: 16px;">
                <button onclick="savePatientEdit()" style="flex: 1; background: linear-gradient(135deg, var(--secondary), #34d399); color: white; border: none; padding: 14px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 700; cursor: pointer;">
                    <i class="fas fa-save" style="margin-left: 6px;"></i>
                    حفظ التعديلات
                </button>
                <button onclick="cancelEdit()" style="background: var(--gray-light); color: var(--gray-dark); border: none; padding: 14px 24px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 600; cursor: pointer;">
                    إلغاء
                </button>
            </div>

            <!-- سجل التعديلات -->
            <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #e5e7eb;">
                <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark); margin-bottom: 12px;">
                    <i class="fas fa-history" style="margin-left: 6px; color: var(--primary);"></i>
                    سجل التعديلات
                </div>
                <div id="editHistoryList" style="max-height: 200px; overflow-y: auto;">
                    <!-- سيتم ملؤها بـ JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- تبويب صلاحيات الوصول -->
<div class="tab-content" id="accesspermissionsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-user-shield"></i>
        <span>صلاحيات الوصول</span>
    </div>

    <!-- البحث -->
    <div class="input-container" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(236, 72, 153, 0.05));">
        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark); margin-bottom: 14px;">
            <i class="fas fa-search" style="margin-left: 6px; color: var(--primary);"></i>
            البحث
        </div>
        
        <div style="display: flex; gap: 10px; margin-bottom: 14px;">
            <div style="flex: 1;">
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">الرقم الجامعي للطالب</label>
                <input type="text" id="accessSearchStudentId" class="text-input" placeholder="أدخل الرقم الجامعي..." style="font-size: clamp(12px, 3.5vw, 14px);">
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">الاسم الثلاثي للمريض</label>
                <input type="text" id="accessSearchPatientName" class="text-input" placeholder="أدخل الاسم الثلاثي..." style="font-size: clamp(12px, 3.5vw, 14px);">
            </div>
        </div>
        
        <button onclick="searchAccessPermissions()" style="width: 100%; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 10px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; cursor: pointer;">
            <i class="fas fa-search" style="margin-left: 6px;"></i>
            بحث
        </button>
    </div>

    <!-- قائمة المرضى -->
    <div id="accessPatientsList" style="margin-top: 16px;">
        <!-- سيتم ملؤها بـ JavaScript -->
    </div>
</div>

<!-- تبويب البحث عن الحالة -->
<div class="tab-content" id="searchcasesContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-search"></i>
        <span>البحث عن الحالة</span>
    </div>

    <!-- الفلاتر -->
    <div class="input-container" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));">
        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark); margin-bottom: 14px;">
            <i class="fas fa-filter" style="margin-left: 6px; color: var(--primary);"></i>
            فلترة البحث
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
            <div>
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">المقرر</label>
                <select id="searchCourse" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                    <option value="">جميع المقررات</option>
                    <option value="restorative">ترميمية</option>
                    <option value="endodontic">لبية</option>
                    <option value="surgery">جراحة</option>
                    <option value="pediatric">أطفال</option>
                    <option value="prosthesis">تعويضات</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">نوع الحالة</label>
                <select id="searchCaseType" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                    <option value="">جميع الأنواع</option>
                    <option value="class1">Class 1</option>
                    <option value="class2">Class 2</option>
                    <option value="class3">Class 3</option>
                    <option value="class4">Class 4</option>
                    <option value="class5">Class 5</option>
                    <option value="root_canal">معالجة لبية</option>
                    <option value="extraction">قلع</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
            <div>
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">الجنس</label>
                <select id="searchGender" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                    <option value="">الكل</option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">حالة الحجز</label>
                <select id="searchBookingStatus" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                    <option value="available">متاحة (غير محجوزة)</option>
                    <option value="temp_booked">محجوزة مؤقتاً</option>
                    <option value="confirmed">محجوزة نهائياً</option>
                    <option value="in_progress">قيد المعالجة</option>
                    <option value="all">جميع الحالات</option>
                </select>
            </div>
        </div>

        <div style="background: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: 10px; margin-bottom: 14px;">
            <label style="display: flex; align-items: center; gap: 8px; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); cursor: pointer;">
                <input type="checkbox" id="searchCurrentAppointments" style="width: 18px; height: 18px; accent-color: var(--secondary);">
                <span>المرضى الموجودون حالياً بالجامعة (لديهم مواعيد اليوم)</span>
            </label>
        </div>
        
        <button onclick="searchCases()" style="width: 100%; background: var(--secondary); color: white; border: none; padding: 12px; border-radius: 10px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; cursor: pointer;">
            <i class="fas fa-search" style="margin-left: 6px;"></i>
            بحث
        </button>
    </div>

    <!-- نتائج البحث -->
    <div id="searchResultsList" style="margin-top: 16px;">
        <!-- سيتم ملؤها بـ JavaScript -->
    </div>
</div>

<!-- تبويب تحويل المرضى -->
<div class="tab-content" id="transferpatientsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-exchange-alt"></i>
        <span>تحويل المرضى</span>
    </div>

    <!-- البحث عن المريض -->
    <div class="input-container" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(245, 158, 11, 0.05));">
        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark); margin-bottom: 14px;">
            <i class="fas fa-search" style="margin-left: 6px; color: var(--danger);"></i>
            البحث عن المريض للتحويل
        </div>
        
        <div style="position: relative; margin-bottom: 14px;">
            <input type="text" id="transferPatientSearch" class="text-input" placeholder="ابحث بالاسم الثلاثي للمريض..." style="padding-right: 40px; font-size: clamp(12px, 3.5vw, 14px);">
            <i class="fas fa-user-injured" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
        </div>
        
        <button onclick="searchPatientForTransfer()" style="width: 100%; background: var(--danger); color: white; border: none; padding: 12px; border-radius: 10px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; cursor: pointer;">
            <i class="fas fa-search" style="margin-left: 6px;"></i>
            بحث
        </button>
    </div>

    <!-- نتائج البحث -->
    <div id="transferSearchResults" style="margin-top: 16px;"></div>

    <!-- نموذج التحويل -->
    <div id="transferForm" style="display: none; margin-top: 16px;">
        <div class="input-container" style="background: rgba(239, 68, 68, 0.05); border: 2px solid rgba(239, 68, 68, 0.2);">
            <div style="font-size: clamp(14px, 4vw, 16px); font-weight: 700; color: var(--danger); margin-bottom: 16px;">
                <i class="fas fa-exchange-alt" style="margin-left: 6px;"></i>
                نموذج التحويل الدائم
            </div>

            <!-- معلومات المريض الحالية -->
            <div style="background: white; padding: 14px; border-radius: 10px; margin-bottom: 16px;">
                <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--gray); margin-bottom: 4px;">المريض الحالي</div>
                <div id="transferPatientInfo" style="font-size: clamp(15px, 4.2vw, 17px); font-weight: 700; color: var(--dark);"></div>
                <div id="transferCurrentStudent" style="font-size: clamp(12px, 3.5vw, 14px); color: var(--primary); margin-top: 4px;"></div>
                <div style="margin-top: 8px; padding: 8px; background: rgba(245, 158, 11, 0.1); border-radius: 6px; font-size: clamp(11px, 3.2vw, 13px); color: var(--warning);">
                    <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                    التحويل يكون قبل بدء العلاج فقط
                </div>
            </div>

            <!-- الطالب القديم -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-user-graduate" style="margin-left: 4px; color: var(--gray);"></i>
                    الرقم الجامعي للطالب القديم (الحالي)
                </label>
                <input type="text" id="oldStudentId" class="text-input" readonly style="font-size: clamp(12px, 3.5vw, 14px); background: var(--gray-light);">
            </div>

            <!-- الطالب الجديد -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 700; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-user-graduate" style="margin-left: 4px; color: var(--secondary);"></i>
                    الرقم الجامعي للطالب الجديد *
                </label>
                <input type="text" id="newStudentId" class="text-input" placeholder="أدخل الرقم الجامعي للطالب الجديد..." style="font-size: clamp(12px, 3.5vw, 14px);">
                <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray); margin-top: 6px;">
                    <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                    يجب أن يكون الطالب الجديد نازل نفس المقرر أو مقرر متماثل
                </div>
            </div>

            <!-- نوع التحويل -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-random" style="margin-left: 4px; color: var(--warning);"></i>
                    نوع التحويل
                </label>
                <select id="transferType" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                    <option value="urgent">تحويل إلحاحي (برغبة المريض)</option>
                    <option value="student_change">تغيير الطالب المعالج</option>
                    <option value="supervisor_request">طلب من المشرف</option>
                </select>
            </div>

            <!-- سبب التحويل -->
            <div class="form-group" style="margin-bottom: 14px;">
                <label style="display: block; font-size: clamp(12px, 3.5vw, 14px); font-weight: 700; color: var(--danger); margin-bottom: 6px;">
                    <i class="fas fa-comment-alt" style="margin-left: 4px;"></i>
                    سبب التحويل (إجباري) *
                </label>
                <textarea id="transferReason" class="text-input" rows="2" placeholder="اكتب سبب التحويل بالتفصيل..." style="resize: none; font-size: clamp(12px, 3.5vw, 14px);"></textarea>
            </div>

            <!-- تحذير -->
            <div style="background: rgba(239, 68, 68, 0.1); padding: 12px; border-radius: 10px; margin-bottom: 16px; border: 1px solid rgba(239, 68, 68, 0.3);">
                <div style="font-size: clamp(11px, 3.2vw, 13px); color: var(--danger); font-weight: 600;">
                    <i class="fas fa-exclamation-triangle" style="margin-left: 6px;"></i>
                    تحذير: هذا الإجراء نهائي ولا يمكن التراجع عنه بسهولة وسيتم توثيقه في السجل
                </div>
            </div>

            <!-- أزرار -->
            <div style="display: flex; gap: 10px;">
                <button onclick="executeTransfer()" style="flex: 1; background: var(--danger); color: white; border: none; padding: 14px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 700; cursor: pointer;">
                    <i class="fas fa-exchange-alt" style="margin-left: 6px;"></i>
                    تنفيذ التحويل الدائم
                </button>
                <button onclick="cancelTransfer()" style="background: var(--gray-light); color: var(--gray-dark); border: none; padding: 14px 24px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 600; cursor: pointer;">
                    إلغاء
                </button>
            </div>
        </div>
    </div>

    <!-- سجل التحويلات -->
    <div id="transferHistorySection" style="display: none; margin-top: 16px;">
        <div class="input-container">
            <div style="font-size: clamp(14px, 4vw, 16px); font-weight: 700; color: var(--dark); margin-bottom: 16px;">
                <i class="fas fa-history" style="margin-left: 6px; color: var(--primary);"></i>
                سجل التحويلات
            </div>
            <div id="transferHistoryList" style="max-height: 300px; overflow-y: auto;">
                <!-- سيتم ملؤها بـ JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- تبويب سجل العمليات -->
<div class="tab-content" id="auditlogContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-history"></i>
        <span>سجل العمليات والمراجعة</span>
    </div>

    <!-- فلاتر السجل -->
    <div class="input-container" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));">
        <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark); margin-bottom: 14px;">
            <i class="fas fa-filter" style="margin-left: 6px; color: var(--primary);"></i>
            فلترة السجل
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
            <div>
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">نوع العملية</label>
                <select id="auditOperationType" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
                    <option value="">الكل</option>
                    <option value="add">إضافة مريض</option>
                    <option value="edit">تعديل بيانات</option>
                    <option value="transfer">تحويل مريض</option>
                    <option value="access_change">تغيير صلاحيات</option>
                    <option value="rollback">تراجع عن عملية</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">الموظف/الطالب</label>
                <input type="text" id="auditEmployeeFilter" class="text-input" placeholder="اسم أو رقم الموظف..." style="font-size: clamp(12px, 3.5vw, 14px);">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
            <div>
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">من تاريخ</label>
                <input type="date" id="auditDateFrom" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
            </div>
            <div>
                <label style="display: block; font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--dark); margin-bottom: 6px;">إلى تاريخ</label>
                <input type="date" id="auditDateTo" class="text-input" style="font-size: clamp(12px, 3.5vw, 14px);">
            </div>
        </div>
        
        <button onclick="loadAuditLog()" style="width: 100%; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 10px; font-size: clamp(13px, 3.8vw, 15px); font-weight: 600; cursor: pointer;">
            <i class="fas fa-search" style="margin-left: 6px;"></i>
            عرض السجل
        </button>
    </div>

    <!-- قائمة العمليات -->
    <div id="auditLogList" style="margin-top: 16px;">
        <!-- سيتم ملؤها بـ JavaScript -->
    </div>
</div>

<!-- Modal اختيار حالة السن -->
<div id="toothModal" class="tooth-modal" style="display: none;">
    <div class="tooth-modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: clamp(14px, 4vw, 16px); color: var(--dark);">
                <i class="fas fa-tooth" style="margin-left: 8px; color: var(--secondary);"></i>
                السن رقم <span id="selectedToothNumber"></span>
            </h3>
            <button onclick="closeToothModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <!-- ترميمية -->
            <div class="tooth-option" onclick="selectToothCondition('restorative')" style="border-color: var(--primary); background: rgba(79, 70, 229, 0.05);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--primary), #6366f1); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);">
                        <i class="fas fa-fill-drip" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 700; color: var(--primary); font-size: clamp(13px, 3.8vw, 15px);">ترميمية</span>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray);">حشوة تجميلية أو وظيفية</div>
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--primary);"></i>
            </div>

            <!-- لبية -->
            <div class="tooth-option" onclick="selectToothCondition('endodontic')" style="border-color: var(--warning); background: rgba(245, 158, 11, 0.05);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-syringe" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 700; color: var(--warning); font-size: clamp(13px, 3.8vw, 15px);">لبية (عصب)</span>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray);">معالجة الجذر أو اللب</div>
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--warning);"></i>
            </div>

            <!-- قلع -->
            <div class="tooth-option" onclick="selectToothCondition('extraction')" style="border-color: var(--danger); background: rgba(239, 68, 68, 0.05);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--danger), #f87171); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-tooth" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 700; color: var(--danger); font-size: clamp(13px, 3.8vw, 15px);">قلع (خلع)</span>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray);">إزالة السن</div>
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--danger);"></i>
            </div>

            <!-- مفقود -->
            <div class="tooth-option" onclick="confirmMissingTooth()" style="border-color: var(--gray); background: rgba(107, 114, 128, 0.05);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #6b7280, #9ca3af); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3);">
                        <i class="fas fa-minus-circle" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 700; color: var(--gray-dark); font-size: clamp(13px, 3.8vw, 15px);">مفقود</span>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray);">السن غير موجود</div>
                    </div>
                </div>
                <div style="background: var(--gray); color: white; padding: 4px 10px; border-radius: 6px; font-size: clamp(9px, 2.8vw, 11px); font-weight: 600;">تأكيد</div>
            </div>

            <!-- بتر لو (تاج) - للأسنان المؤقتة -->
            <div id="crownOption" class="tooth-option" onclick="selectToothCondition('crown')" style="border-color: var(--secondary); background: rgba(16, 185, 129, 0.05); display: none;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--secondary), #34d399); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-crown" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 700; color: var(--secondary); font-size: clamp(13px, 3.8vw, 15px);">بتر لو (تاج)</span>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray);">تاج للسن المؤقت</div>
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--secondary);"></i>
            </div>

            <!-- ترميم محافظ - للأسنان المؤقتة -->
            <div id="conservativeOption" class="tooth-option" onclick="selectToothCondition('conservative')" style="border-color: var(--accent); background: rgba(236, 72, 153, 0.05); display: none;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--accent), #f472b6); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(236, 72, 153, 0.3);">
                        <i class="fas fa-shield-alt" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 700; color: var(--accent); font-size: clamp(13px, 3.8vw, 15px);">ترميم محافظ</span>
                        <div style="font-size: clamp(10px, 3vw, 12px); color: var(--gray);">حشوة محافظة للسن المؤقت</div>
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--accent);"></i>
            </div>

            <!-- إزالة -->
            <div class="tooth-option" onclick="removeToothCondition()" style="border-color: var(--danger); border-style: dashed; background: rgba(239, 68, 68, 0.02); margin-top: 8px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 44px; height: 44px; background: white; border: 2px dashed var(--danger); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-trash" style="color: var(--danger);"></i>
                    </div>
                    <span style="font-weight: 700; color: var(--danger); font-size: clamp(13px, 3.8vw, 15px);">إزالة التحديد</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تأكيد السن المفقود -->
<div id="missingConfirmModal" class="tooth-modal" style="display: none;">
    <div class="tooth-modal-content">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 70px; height: 70px; background: var(--gray); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="fas fa-minus-circle" style="color: white; font-size: 32px;"></i>
            </div>
            <h3 style="font-size: clamp(16px, 4.5vw, 18px); color: var(--dark); margin-bottom: 8px;">تأكيد السن المفقود</h3>
            <p style="font-size: clamp(12px, 3.5vw, 14px); color: var(--gray);">هل أنت متأكد أن السن رقم <strong id="missingToothNum" style="color: var(--dark);"></strong> مفقود (غير موجود)؟</p>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button onclick="confirmMissingToothFinal()" style="flex: 1; background: var(--gray); color: white; border: none; padding: 14px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 700; cursor: pointer;">
                <i class="fas fa-check" style="margin-left: 6px;"></i>
                نعم، مفقود
            </button>
            <button onclick="closeMissingConfirmModal()" style="flex: 1; background: var(--gray-light); color: var(--gray-dark); border: none; padding: 14px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 600; cursor: pointer;">
                إلغاء
            </button>
        </div>
    </div>
</div>

<!-- Modal التفاصيل الفرعية -->
<div id="subConditionModal" class="tooth-modal" style="display: none;">
    <div class="tooth-modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: clamp(14px, 4vw, 16px); color: var(--dark);" id="subConditionTitle"></h3>
            <button onclick="closeSubConditionModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="subConditionOptions"></div>
        <div id="confirmSubConditionBtn" style="display: none; margin-top: 16px;">
            <button onclick="confirmToothCondition()" style="width: 100%; background: linear-gradient(135deg, var(--secondary), #34d399); color: white; border: none; padding: 14px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-check-circle"></i>
                تأكيد الاختيار
            </button>
        </div>
    </div>
</div>

<!-- Modal إضافة مرض -->
<div id="addDiseaseModal" class="tooth-modal" style="display: none;">
    <div class="tooth-modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: clamp(14px, 4vw, 16px); color: var(--dark);">
                <i class="fas fa-plus-circle" style="margin-left: 8px; color: var(--secondary);"></i>
                إضافة مرض
            </h3>
            <button onclick="closeAddDiseaseModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="form-group">
            <input type="text" id="newDiseaseInput" class="text-input" placeholder="اكتب اسم المرض..." style="font-size: clamp(13px, 3.8vw, 15px);">
        </div>
        <button onclick="addCustomDisease()" style="width: 100%; background: linear-gradient(135deg, var(--secondary), #34d399); color: white; border: none; padding: 14px; border-radius: 12px; font-size: clamp(14px, 4vw, 16px); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 14px;">
            <i class="fas fa-plus"></i>
            إضافة
        </button>
    </div>
</div>

<!-- Modal عرض مخطط الأسنان (للعرض فقط) -->
<div id="viewTeethModal" class="tooth-modal" style="display: none;">
    <div class="tooth-modal-content" style="max-width: 450px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: clamp(14px, 4vw, 16px); color: var(--dark);">
                <i class="fas fa-tooth" style="margin-left: 8px; color: var(--secondary);"></i>
                مخطط الأسنان - <span id="viewTeethPatientName"></span>
            </h3>
            <button onclick="closeViewTeethModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div id="viewTeethChart" style="padding: 10px; background: #f9fafb; border-radius: 12px;">
            <!-- سيتم ملؤها بـ JavaScript -->
        </div>
        
        <div style="margin-top: 16px; padding: 12px; background: rgba(16, 185, 129, 0.1); border-radius: 10px;">
            <div style="font-size: clamp(11px, 3.2vw, 13px); font-weight: 600; color: var(--secondary);">
                <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                الأسنان باللون الرمادي = تم علاجها أو لم تكن بحاجة لعلاج
            </div>
        </div>
    </div>
</div>

<style>
/* أزرار الأسنان مع Tooltips */
.tooth-btn {
    width: clamp(28px, 8vw, 36px);
    height: clamp(28px, 8vw, 36px);
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    background: white;
    font-size: clamp(9px, 2.8vw, 11px);
    font-weight: 700;
    color: var(--dark);
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tooth-btn:hover {
    border-color: var(--secondary);
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    z-index: 10;
}

.tooth-btn:hover::after {
    content: attr(title);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: var(--dark);
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: clamp(9px, 2.8vw, 11px);
    white-space: nowrap;
    z-index: 100;
    margin-bottom: 6px;
    font-weight: 500;
}

.tooth-btn:hover::before {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 6px solid transparent;
    border-top-color: var(--dark);
    margin-bottom: -6px;
    z-index: 100;
}

.tooth-btn.permanent {
    background: #f0f9ff;
    border-color: #bae6fd;
    color: #0369a1;
}

.tooth-btn.primary {
    background: #fffbeb;
    border-color: #fcd34d;
    color: #b45309;
}

/* حالات الأسنان الملونة - تم إصلاحها */
.tooth-btn.restorative {
    background: var(--primary) !important;
    border-color: var(--primary) !important;
    color: white !important;
    box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
    animation: pulseTooth 2s infinite;
}

.tooth-btn.endodontic {
    background: var(--warning) !important;
    border-color: var(--warning) !important;
    color: white !important;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    animation: pulseTooth 2s infinite;
}

.tooth-btn.extraction {
    background: var(--danger) !important;
    border-color: var(--danger) !important;
    color: white !important;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    animation: pulseTooth 2s infinite;
}

.tooth-btn.missing {
    background: var(--gray) !important;
    border-color: var(--gray) !important;
    color: white !important;
    text-decoration: line-through;
    opacity: 0.7;
}

.tooth-btn.crown {
    background: var(--secondary) !important;
    border-color: var(--secondary) !important;
    color: white !important;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    animation: pulseTooth 2s infinite;
}

.tooth-btn.conservative {
    background: var(--accent) !important;
    border-color: var(--accent) !important;
    color: white !important;
    box-shadow: 0 2px 8px rgba(236, 72, 153, 0.3);
    animation: pulseTooth 2s infinite;
}

@keyframes pulseTooth {
    0%, 100% { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    50% { box-shadow: 0 4px 16px rgba(0,0,0,0.2); }
}

/* Tooltip styling */
.tooltip {
    position: relative;
    cursor: help;
}

.tooltip .tooltip-text {
    visibility: hidden;
    width: 200px;
    background-color: var(--dark);
    color: white;
    text-align: center;
    border-radius: 8px;
    padding: 8px 12px;
    position: absolute;
    z-index: 100;
    bottom: 125%;
    left: 50%;
    margin-left: -100px;
    opacity: 0;
    transition: opacity 0.3s;
    font-size: clamp(10px, 3vw, 12px);
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.tooltip .tooltip-text::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: var(--dark) transparent transparent transparent;
}

.tooltip:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}

/* Modal الأسنان */
.tooth-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 20px;
}

.tooth-modal-content {
    background: white;
    border-radius: 20px;
    padding: 24px;
    width: 100%;
    max-width: 380px;
    max-height: 85vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
}

.tooth-option {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px;
    border: 2px solid #e5e7eb;
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.tooth-option:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* خيارات الصلاحيات */
.access-option.selected {
    border-color: var(--primary) !important;
    background: rgba(79, 70, 229, 0.05) !important;
}

.access-option.selected .access-check {
    color: var(--primary) !important;
}

/* شارات الطلاب */
.student-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    background: var(--warning);
    color: white;
    border-radius: 20px;
    font-size: clamp(11px, 3.2vw, 13px);
    font-weight: 600;
}

.student-badge button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 0;
    font-size: 12px;
}

/* خيارات الحالة الصحية */
.health-checkbox.selected, .edit-health-checkbox.selected {
    border-color: var(--primary) !important;
    background: rgba(79, 70, 229, 0.1) !important;
}

/* خيارات الجنس والعمر */
.gender-option.selected, .age-type-option.selected, 
.edit-gender-option.selected, .edit-age-type-option.selected {
    border-color: var(--primary) !important;
    background: rgba(79, 70, 229, 0.05) !important;
}

/* خيارات التحكم */
.control-option.selected-yes {
    border-color: var(--secondary) !important;
    background: rgba(16, 185, 129, 0.1) !important;
}

.control-option.selected-no {
    border-color: var(--danger) !important;
    background: rgba(239, 68, 68, 0.1) !important;
}

/* خيارات السن الفرعية */
.tooth-sub-option {
    transition: all 0.2s;
}

.tooth-sub-option:hover {
    border-color: var(--primary);
    background: rgba(79, 70, 229, 0.03);
}

.tooth-sub-option.selected {
    border-color: var(--primary) !important;
    background: rgba(79, 70, 229, 0.08) !important;
}

/* بطاقات المرضى */
.patient-card {
    background: white;
    border-radius: 16px;
    padding: 18px;
    margin-bottom: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #f3f4f6;
    transition: all 0.3s;
}

.patient-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

/* سجل التعديلات والعمليات */
.history-item {
    padding: 12px;
    background: white;
    border-radius: 10px;
    margin-bottom: 8px;
    border-right: 3px solid var(--primary);
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

.audit-item {
    padding: 16px;
    background: white;
    border-radius: 12px;
    margin-bottom: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.2s;
}

.audit-item:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.audit-item.rollback {
    border-right-color: var(--warning);
    background: rgba(245, 158, 11, 0.02);
}

.audit-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 10px;
}

.audit-type {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: clamp(10px, 3vw, 12px);
    font-weight: 600;
}

.audit-type.add { background: rgba(16, 185, 129, 0.1); color: var(--secondary); }
.audit-type.edit { background: rgba(79, 70, 229, 0.1); color: var(--primary); }
.audit-type.transfer { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
.audit-type.access_change { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
.audit-type.rollback { background: rgba(107, 114, 128, 0.1); color: var(--gray-dark); }

.audit-employee {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: clamp(11px, 3.2vw, 13px);
    color: var(--dark);
    font-weight: 600;
}

.audit-employee-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    font-weight: 700;
}

.audit-details {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #f3f4f6;
    font-size: clamp(11px, 3.2vw, 13px);
    color: var(--gray-dark);
    line-height: 1.6;
}

.audit-footer {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.audit-date {
    font-size: clamp(10px, 3vw, 12px);
    color: var(--gray);
}

.rollback-btn {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.3);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: clamp(10px, 3vw, 12px);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.rollback-btn:hover {
    background: var(--warning);
    color: white;
}

.rollback-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* سجل التحويلات */
.transfer-history-item {
    padding: 16px;
    background: white;
    border-radius: 12px;
    margin-bottom: 12px;
    border-right: 4px solid var(--danger);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.transfer-history-item.rolled-back {
    border-right-color: var(--warning);
    opacity: 0.7;
}

.transfer-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 12px;
}

.transfer-direction {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: clamp(12px, 3.5vw, 14px);
}

.transfer-from, .transfer-to {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.transfer-arrow {
    color: var(--danger);
    font-size: 20px;
}

.transfer-student-id {
    background: var(--gray-light);
    padding: 4px 10px;
    border-radius: 6px;
    font-size: clamp(11px, 3.2vw, 13px);
    font-weight: 700;
    color: var(--dark);
}

.transfer-date {
    font-size: clamp(10px, 3vw, 12px);
    color: var(--gray);
}

.transfer-reason {
    background: rgba(239, 68, 68, 0.05);
    padding: 10px;
    border-radius: 8px;
    font-size: clamp(11px, 3.2vw, 13px);
    color: var(--dark);
    margin-bottom: 10px;
}

.transfer-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: clamp(10px, 3vw, 12px);
    color: var(--gray);
}

/* Responsive */
@media (max-width: 480px) {
    .tooth-modal-content {
        padding: 18px;
        margin: 10px;
    }
    
    .audit-header {
        flex-direction: column;
        gap: 10px;
    }
    
    .transfer-direction {
        flex-direction: column;
        gap: 8px;
    }
    
    .transfer-arrow {
        transform: rotate(90deg);
    }
}

@media (min-width: 768px) {
    .tooth-btn {
        width: 40px;
        height: 40px;
        font-size: 13px;
    }
}
</style>

<script>

// ==========================================
// بيانات المرضى (محاكاة)
// ==========================================
let patientsData = [
    { 
        id: 1, 
        name: 'أحمد محمد علي', 
        record: 'MED-2024-001', 
        age: 25, 
        ageType: 'adult',
        gender: 'male',
        type: 'private', 
        phone: '0912345678',
        governorate: 'damascus',
        address: 'المزة',
        birthYear: 1999,
        teeth: {
            16: { condition: 'restorative', subCondition: 'class2', label: 'Class 2', isPrimary: false },
            36: { condition: 'endodontic', subCondition: 'full', label: 'معالجة لبية - سن كامل', isPrimary: false }
        },
        healthConditions: {
            diseases: ['diabetes'],
            diabetesControlled: 'yes',
            bpControlled: null,
            addedDiseases: []
        },
        accessPermissions: { type: 'private', allowedStudents: [], caseManager: '2021001' },
        addedBy: '2021001',
        addedByName: 'الطالب أحمد',
        addedAt: new Date().toISOString(),
        editHistory: [],
        transferHistory: [],
        parentInfo: null,
        notes: '',
        treatmentStarted: false
    },
    { 
        id: 2, 
        name: 'سارة خالد محمود', 
        record: 'MED-2024-002', 
        age: 8, 
        ageType: 'child',
        gender: 'female',
        type: 'public', 
        phone: '0998765432',
        governorate: 'aleppo',
        address: 'الشهباء',
        birthYear: 2016,
        teeth: {
            55: { condition: 'restorative', subCondition: 'class1', label: 'Class 1', isPrimary: true },
            65: { condition: 'extraction', subCondition: 'mobile', label: 'قلع - سن متقلقل', isPrimary: true }
        },
        healthConditions: {
            diseases: [],
            diabetesControlled: null,
            bpControlled: null,
            addedDiseases: []
        },
        accessPermissions: { type: 'public', allowedStudents: [], caseManager: '2021002' },
        addedBy: '2021002',
        addedByName: 'الطالبة سارة',
        addedAt: new Date().toISOString(),
        editHistory: [],
        transferHistory: [],
        parentInfo: {
            name: 'خالد محمود',
            phone: '0999888777',
            birthYear: 1980
        },
        notes: '',
        treatmentStarted: false
    }
];

// سجل العمليات العام (Audit Log)
let auditLogData = [
    {
        id: 1,
        operationType: 'add',
        patientId: 1,
        patientName: 'أحمد محمد علي',
        employeeId: '2021001',
        employeeName: 'الطالب أحمد',
        details: 'إضافة مريض جديد',
        changes: [],
        oldValue: null,
        newValue: 'اسم: أحمد محمد علي، العمر: 25',
        reason: null,
        date: new Date().toISOString(),
        isRolledBack: false,
        rollbackReason: null,
        rollbackBy: null,
        rollbackDate: null
    }
];

// المتغيرات العامة
let selectedTeeth = {};
let editSelectedTeeth = {};
let currentToothNumber = null;
let currentCondition = null;
let pendingSubCondition = null;
let pendingSubLabel = null;
let addedStudents = [];
let addedDiseases = [];
let currentEditingPatient = null;
let currentTransferPatient = null;
let currentRollbackId = null;
let isEditMode = false;
let editAddedStudents = [];
let editAddedDiseases = [];

// ==========================================
// تهيئة الصفحة
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    selectAccessType('private');
    updatePrimaryTeethVisibility();
    loadAuditLog();
    buildInitialTeethChart();
    buildEditTeethChart();
});

// ==========================================
// بناء مخطط الأسنان الأولي
// ==========================================
function buildInitialTeethChart() {
    const container = document.getElementById('teethChart');
    if (!container) return;
    
    // الأسنان الدائمة العلوية
    let html = '<div style="margin-bottom: 12px;"><div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
    [18,17,16,15,14,13,12,11].forEach(t => {
        html += `<button type="button" class="tooth-btn permanent" data-tooth="${t}" onclick="selectTooth(${t})" title="">${t}</button>`;
    });
    html += '<div style="width: 12px;"></div>';
    [21,22,23,24,25,26,27,28].forEach(t => {
        html += `<button type="button" class="tooth-btn permanent" data-tooth="${t}" onclick="selectTooth(${t})" title="">${t}</button>`;
    });
    html += '</div></div>';
    
    // الأسنان الدائمة السفلية
    html += '<div style="margin-bottom: 16px;"><div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
    [48,47,46,45,44,43,42,41].forEach(t => {
        html += `<button type="button" class="tooth-btn permanent" data-tooth="${t}" onclick="selectTooth(${t})" title="">${t}</button>`;
    });
    html += '<div style="width: 12px;"></div>';
    [31,32,33,34,35,36,37,38].forEach(t => {
        html += `<button type="button" class="tooth-btn permanent" data-tooth="${t}" onclick="selectTooth(${t})" title="">${t}</button>`;
    });
    html += '</div></div>';
    
    // الأسنان المؤقتة
    html += '<div id="primaryTeethSection" style="margin-top: 16px; padding-top: 16px; border-top: 2px dashed #e5e7eb;">';
    html += '<div style="font-size: 11px; color: var(--warning); text-align: center; margin-bottom: 8px; font-weight: 600;">الأسنان المؤقتة</div>';
    
    html += '<div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap; margin-bottom: 8px;">';
    [55,54,53,52,51].forEach(t => {
        html += `<button type="button" class="tooth-btn primary" data-tooth="${t}" onclick="selectTooth(${t})" title="">${t}</button>`;
    });
    html += '<div style="width: 12px;"></div>';
    [61,62,63,64,65].forEach(t => {
        html += `<button type="button" class="tooth-btn primary" data-tooth="${t}" onclick="selectTooth(${t})" title="">${t}</button>`;
    });
    html += '</div>';
    
    html += '<div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
    [85,84,83,82,81].forEach(t => {
        html += `<button type="button" class="tooth-btn primary" data-tooth="${t}" onclick="selectTooth(${t})" title="">${t}</button>`;
    });
    html += '<div style="width: 12px;"></div>';
    [71,72,73,74,75].forEach(t => {
        html += `<button type="button" class="tooth-btn primary" data-tooth="${t}" onclick="selectTooth(${t})" title="">${t}</button>`;
    });
    html += '</div></div>';
    
    container.innerHTML = html;
}

// ==========================================
// نظام الأسنان FDI - مشترك
// ==========================================
function selectTooth(toothNumber) {
    currentToothNumber = toothNumber;
    
    const modal = document.getElementById('toothModal');
    const toothNumEl = document.getElementById('selectedToothNumber');
    
    if (toothNumEl) toothNumEl.textContent = toothNumber;
    
    const isPrimary = (toothNumber >= 51 && toothNumber <= 86);
    
    const crownOption = document.getElementById('crownOption');
    const conservativeOption = document.getElementById('conservativeOption');
    
    if (crownOption) crownOption.style.display = isPrimary ? 'flex' : 'none';
    if (conservativeOption) conservativeOption.style.display = isPrimary ? 'flex' : 'none';
    
    if (modal) modal.style.display = 'flex';
}

function closeToothModal() {
    const modal = document.getElementById('toothModal');
    if (modal) modal.style.display = 'none';
    currentToothNumber = null;
    isEditMode = false;
}

function closeSubConditionModal() {
    const modal = document.getElementById('subConditionModal');
    const confirmBtn = document.getElementById('confirmSubConditionBtn');
    
    if (modal) modal.style.display = 'none';
    if (confirmBtn) confirmBtn.style.display = 'none';
    
    currentCondition = null;
    pendingSubCondition = null;
    pendingSubLabel = null;
}

// تأكيد السن المفقود
function confirmMissingTooth() {
    const missingModal = document.getElementById('missingConfirmModal');
    const toothNumEl = document.getElementById('missingToothNum');
    const toothModal = document.getElementById('toothModal');
    
    if (toothNumEl) toothNumEl.textContent = currentToothNumber;
    if (missingModal) missingModal.style.display = 'flex';
    if (toothModal) toothModal.style.display = 'none';
}

function closeMissingConfirmModal() {
    const modal = document.getElementById('missingConfirmModal');
    if (modal) modal.style.display = 'none';
    currentToothNumber = null;
}

function confirmMissingToothFinal() {
    if (isEditMode) {
        applyEditToothCondition('missing', 'غير موجود');
    } else {
        applyToothCondition('missing', 'غير موجود');
    }
    closeMissingConfirmModal();
    showToast(`تم تحديد السن ${currentToothNumber} كمفقود`, 'success');
}

function selectToothCondition(condition) {
    currentCondition = condition;

    let title = '';
    let options = [];

    switch(condition) {
        case 'restorative':
            title = '<i class="fas fa-fill-drip" style="margin-left: 8px; color: var(--primary);"></i> ترميمية - اختر الصنف';
            options = [
                { value: 'class1', label: 'Class 1', desc: 'حفرة في السطح الإطباقي' },
                { value: 'class2', label: 'Class 2', desc: 'حفرة في السطح القريب للأرحاء' },
                { value: 'class3', label: 'Class 3', desc: 'حفرة في السطح القريب للأمامية' },
                { value: 'class4', label: 'Class 4', desc: 'حفرة في زاوية القاطعة' },
                { value: 'class5', label: 'Class 5', desc: 'حفرة في الثلث اللثوي' }
            ];
            break;
        case 'endodontic':
            title = '<i class="fas fa-syringe" style="margin-left: 8px; color: var(--warning);"></i> لبية - اختر النوع';
            options = [
                { value: 'full', label: 'سن كامل', desc: 'معالجة لبية للسن الكامل' },
                { value: 'root', label: 'جذر فقط', desc: 'معالجة لبية للجذر' },
                { value: 'retreat_full', label: 'إعادة معالجة سن كامل', desc: 'إعادة المعالجة اللبية للسن الكامل' },
                { value: 'retreat_root', label: 'إعادة معالجة جذر', desc: 'إعادة المعالجة اللبية للجذر' }
            ];
            break;
        case 'extraction':
            title = '<i class="fas fa-tooth" style="margin-left: 8px; color: var(--danger);"></i> قلع - اختر النوع';
            options = [
                { value: 'root_only', label: 'جذر فقط', desc: 'قلع بقايا جذر' },
                { value: 'mobile', label: 'سن متقلقل', desc: 'قلع سن متحرك' },
                { value: 'impacted', label: 'سن منطمر', desc: 'قلع سن منطمر جراحياً' }
            ];
            break;
        case 'crown':
            title = '<i class="fas fa-crown" style="margin-left: 8px; color: var(--secondary);"></i> بتر لو - اختر النوع';
            options = [
                { value: 'ssc', label: 'Stainless Steel Crown', desc: 'تاج فولاذي للأطفال' },
                { value: 'zirconia', label: 'Zirconia Crown', desc: 'تاج زركونيا للأطفال' }
            ];
            break;
        case 'conservative':
            title = '<i class="fas fa-shield-alt" style="margin-left: 8px; color: var(--accent);"></i> ترميم محافظ - اختر النوع';
            options = [
                { value: 'gi', label: 'حشوة زجاجية', desc: 'Glass Ionomer' },
                { value: 'composite', label: 'حشوة مركبة', desc: 'Composite Resin' }
            ];
            break;
    }

    closeToothModal();

    const confirmBtn = document.getElementById('confirmSubConditionBtn');
    if (confirmBtn) confirmBtn.style.display = 'none';
    
    pendingSubCondition = null;
    pendingSubLabel = null;

    const conditionStyles = {
        restorative: { color: 'var(--primary)', bg: 'rgba(79, 70, 229, 0.05)' },
        endodontic: { color: 'var(--warning)', bg: 'rgba(245, 158, 11, 0.05)' },
        extraction: { color: 'var(--danger)', bg: 'rgba(239, 68, 68, 0.05)' },
        crown: { color: 'var(--secondary)', bg: 'rgba(16, 185, 129, 0.05)' },
        conservative: { color: 'var(--accent)', bg: 'rgba(236, 72, 153, 0.05)' }
    };
    
    const style = conditionStyles[condition] || conditionStyles.restorative;

    const titleEl = document.getElementById('subConditionTitle');
    const optionsEl = document.getElementById('subConditionOptions');
    
    if (titleEl) titleEl.innerHTML = title;
    
    if (optionsEl) {
        optionsEl.innerHTML = options.map(opt => `
            <div class="tooth-sub-option" data-value="${opt.value}" data-label="${opt.label}" 
                 onclick="selectSubCondition('${opt.value}', '${opt.label}')" 
                 style="display: flex; justify-content: space-between; align-items: center; padding: 14px; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer; margin-bottom: 10px; transition: all 0.2s;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 36px; height: 36px; background: ${style.bg}; border: 2px solid ${style.color}; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 12px; font-weight: 700; color: ${style.color};">${opt.label.substring(0, 2)}</span>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--dark); font-size: 14px;">${opt.label}</div>
                        <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">${opt.desc}</div>
                    </div>
                </div>
                <i class="fas fa-circle sub-check" style="color: #e5e7eb; font-size: 18px;"></i>
            </div>
        `).join('');
    }

    const modal = document.getElementById('subConditionModal');
    if (modal) modal.style.display = 'flex';
}

function selectSubCondition(value, label) {
    pendingSubCondition = value;
    pendingSubLabel = label;

    const conditionStyles = {
        restorative: { color: 'var(--primary)', bg: 'rgba(79, 70, 229, 0.1)' },
        endodontic: { color: 'var(--warning)', bg: 'rgba(245, 158, 11, 0.1)' },
        extraction: { color: 'var(--danger)', bg: 'rgba(239, 68, 68, 0.1)' },
        crown: { color: 'var(--secondary)', bg: 'rgba(16, 185, 129, 0.1)' },
        conservative: { color: 'var(--accent)', bg: 'rgba(236, 72, 153, 0.1)' }
    };
    
    const style = conditionStyles[currentCondition] || conditionStyles.restorative;

    document.querySelectorAll('.tooth-sub-option').forEach(opt => {
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
        const check = opt.querySelector('.sub-check');
        if (check) {
            check.className = 'fas fa-circle sub-check';
            check.style.color = '#e5e7eb';
        }
    });

    const selectedOpt = document.querySelector(`.tooth-sub-option[data-value="${value}"]`);
    if (selectedOpt) {
        selectedOpt.style.borderColor = style.color;
        selectedOpt.style.background = style.bg;
        const check = selectedOpt.querySelector('.sub-check');
        if (check) {
            check.className = 'fas fa-check-circle sub-check';
            check.style.color = style.color;
        }
    }

    const confirmBtnDiv = document.getElementById('confirmSubConditionBtn');
    if (confirmBtnDiv) {
        confirmBtnDiv.style.display = 'block';
        const btn = confirmBtnDiv.querySelector('button');
        if (btn) {
            const gradients = {
                restorative: 'linear-gradient(135deg, var(--primary), #6366f1)',
                endodontic: 'linear-gradient(135deg, var(--warning), #fbbf24)',
                extraction: 'linear-gradient(135deg, var(--danger), #f87171)',
                crown: 'linear-gradient(135deg, var(--secondary), #34d399)',
                conservative: 'linear-gradient(135deg, var(--accent), #f472b6)'
            };
            btn.style.background = gradients[currentCondition] || gradients.restorative;
        }
    }
}

function confirmToothCondition() {
    if (!pendingSubCondition || !pendingSubLabel) {
        showToast('يرجى اختيار نوع الحالة أولاً', 'warning');
        return;
    }

    if (isEditMode) {
        applyEditToothCondition(currentCondition, pendingSubLabel, pendingSubCondition);
    } else {
        applyToothCondition(currentCondition, pendingSubLabel, pendingSubCondition);
    }
    closeSubConditionModal();
}

function applyToothCondition(condition, label, subValue = null) {
    if (!currentToothNumber) return;

    selectedTeeth[currentToothNumber] = {
        condition: condition,
        subCondition: subValue,
        label: label,
        isPrimary: currentToothNumber >= 51 && currentToothNumber <= 86
    };

    const btn = document.querySelector(`.tooth-btn[data-tooth="${currentToothNumber}"]`);
    if (btn) {
        btn.className = `tooth-btn ${condition}`;
        btn.title = label;
    }

    updateSelectedTeethList();
    updateTeethStats();
    showToast(`تم تحديد السن ${currentToothNumber}: ${label}`, 'success');
}

function applyEditToothCondition(condition, label, subValue = null) {
    if (!currentToothNumber) return;

    editSelectedTeeth[currentToothNumber] = {
        condition: condition,
        subCondition: subValue,
        label: label,
        isPrimary: currentToothNumber >= 51 && currentToothNumber <= 86
    };

    const btn = document.querySelector(`#editTeethChart .tooth-btn[data-tooth="${currentToothNumber}"]`);
    if (btn) {
        btn.className = `tooth-btn ${condition}`;
        btn.title = label;
    }

    updateEditSelectedTeethList();
    showToast(`تم تحديد السن ${currentToothNumber}: ${label}`, 'success');
}

function removeToothCondition() {
    if (!currentToothNumber) return;

    if (isEditMode) {
        delete editSelectedTeeth[currentToothNumber];
        const btn = document.querySelector(`#editTeethChart .tooth-btn[data-tooth="${currentToothNumber}"]`);
        if (btn) {
            const isPrimary = currentToothNumber >= 51 && currentToothNumber <= 86;
            btn.className = `tooth-btn ${isPrimary ? 'primary' : 'permanent'}`;
            btn.title = '';
        }
        updateEditSelectedTeethList();
    } else {
        delete selectedTeeth[currentToothNumber];
        const btn = document.querySelector(`.tooth-btn[data-tooth="${currentToothNumber}"]`);
        if (btn) {
            const isPrimary = currentToothNumber >= 51 && currentToothNumber <= 86;
            btn.className = `tooth-btn ${isPrimary ? 'primary' : 'permanent'}`;
            btn.title = '';
        }
        updateSelectedTeethList();
        updateTeethStats();
    }
    
    closeToothModal();
    showToast(`تم إزالة تحديد السن ${currentToothNumber}`, 'info');
}

// ==========================================
// تحديث قوائم الأسنان
// ==========================================
function updateSelectedTeethList() {
    const listContainer = document.getElementById('selectedTeethList');
    const teethContainer = document.getElementById('teethListContainer');
    const teethKeys = Object.keys(selectedTeeth);

    if (teethKeys.length === 0) {
        if (listContainer) listContainer.style.display = 'none';
        return;
    }

    if (listContainer) listContainer.style.display = 'block';

    const conditionColors = {
        restorative: 'var(--primary)',
        endodontic: 'var(--warning)',
        extraction: 'var(--danger)',
        missing: 'var(--gray)',
        crown: 'var(--secondary)',
        conservative: 'var(--accent)'
    };

    if (teethContainer) {
        teethContainer.innerHTML = teethKeys.map(tooth => {
            const data = selectedTeeth[tooth];
            const color = conditionColors[data.condition] || 'var(--gray)';
            return `
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: white; border-radius: 10px; margin-bottom: 8px; border: 1px solid #e5e7eb; box-shadow: 0 1px 4px rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; background: ${color}; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 700;">
                            ${tooth}
                        </div>
                        <div>
                            <span style="font-size: 13px; font-weight: 700; color: var(--dark);">${data.label}</span>
                            ${data.isPrimary ? '<span style="font-size: 10px; color: var(--warning); margin-right: 6px;">(مؤقت)</span>' : ''}
                        </div>
                    </div>
                    <button onclick="removeToothFromList(${tooth})" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 6px; font-size: 14px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }).join('');
    }
}

function updateEditSelectedTeethList() {
    const listContainer = document.getElementById('editSelectedTeethList');
    const container = document.getElementById('editTeethListContainer');
    const teethKeys = Object.keys(editSelectedTeeth);

    if (teethKeys.length === 0) {
        if (listContainer) listContainer.style.display = 'none';
        return;
    }

    if (listContainer) listContainer.style.display = 'block';

    const conditionColors = {
        restorative: 'var(--primary)',
        endodontic: 'var(--warning)',
        extraction: 'var(--danger)',
        missing: 'var(--gray)',
        crown: 'var(--secondary)',
        conservative: 'var(--accent)'
    };

    if (container) {
        container.innerHTML = teethKeys.map(tooth => {
            const data = editSelectedTeeth[tooth];
            const color = conditionColors[data.condition] || 'var(--gray)';
            return `
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: white; border-radius: 10px; margin-bottom: 8px; border: 1px solid #e5e7eb; box-shadow: 0 1px 4px rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; background: ${color}; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 700;">
                            ${tooth}
                        </div>
                        <div>
                            <span style="font-size: 13px; font-weight: 700; color: var(--dark);">${data.label}</span>
                            ${data.isPrimary ? '<span style="font-size: 10px; color: var(--warning); margin-right: 6px;">(مؤقت)</span>' : ''}
                        </div>
                    </div>
                    <button onclick="removeEditToothFromList(${tooth})" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 6px; font-size: 14px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }).join('');
    }
}

function updateTeethStats() {
    const statsContainer = document.getElementById('teethStats');
    const teethKeys = Object.keys(selectedTeeth);
    
    if (!statsContainer) return;
    
    if (teethKeys.length === 0) {
        statsContainer.style.display = 'none';
        return;
    }
    
    statsContainer.style.display = 'block';

    let fixedCount = 0;
    let mobileCount = 0;
    let missingCount = 0;

    teethKeys.forEach(tooth => {
        const data = selectedTeeth[tooth];
        if (data.condition === 'missing') {
            missingCount++;
        } else if (data.condition === 'extraction' && data.subCondition === 'mobile') {
            mobileCount++;
        } else if (['restorative', 'endodontic', 'crown', 'conservative'].includes(data.condition)) {
            fixedCount++;
        }
    });

    const fixedEl = document.getElementById('fixedTeethCount');
    const mobileEl = document.getElementById('mobileTeethCount');
    const missingEl = document.getElementById('missingTeethCount');
    const totalEl = document.getElementById('totalSelectedTeeth');
    
    if (fixedEl) fixedEl.textContent = fixedCount;
    if (mobileEl) mobileEl.textContent = mobileCount;
    if (missingEl) missingEl.textContent = missingCount;
    if (totalEl) totalEl.textContent = teethKeys.length;

    const prosthesisDiv = document.getElementById('prosthesisType');
    const prosthesisResult = document.getElementById('prosthesisResult');
    
    if (prosthesisDiv && prosthesisResult) {
        if (missingCount > 0) {
            prosthesisDiv.style.display = 'block';
            if (missingCount === 1) {
                prosthesisResult.innerHTML = '<i class="fas fa-tooth" style="margin-left: 6px;"></i> تعويض ثابت (جسر) - يتطلب سنين جانبيتين سليمتين';
            } else if (missingCount <= 3) {
                prosthesisResult.innerHTML = '<i class="fas fa-teeth" style="margin-left: 6px;"></i> تعويض ثابت (جسر) - يمكن استخدامه للفجوات الصغيرة';
            } else {
                prosthesisResult.innerHTML = '<i class="fas fa-teeth-open" style="margin-left: 6px;"></i> تعويض متحرك (طقم أسنان) - يفضل للفجوات الكبيرة';
            }
        } else {
            prosthesisDiv.style.display = 'none';
        }
    }
}

function removeToothFromList(toothNumber) {
    delete selectedTeeth[toothNumber];

    const btn = document.querySelector(`.tooth-btn[data-tooth="${toothNumber}"]`);
    if (btn) {
        const isPrimary = toothNumber >= 51 && toothNumber <= 86;
        btn.className = `tooth-btn ${isPrimary ? 'primary' : 'permanent'}`;
        btn.title = '';
    }

    updateSelectedTeethList();
    updateTeethStats();
}

function removeEditToothFromList(toothNumber) {
    delete editSelectedTeeth[toothNumber];

    const btn = document.querySelector(`#editTeethChart .tooth-btn[data-tooth="${toothNumber}"]`);
    if (btn) {
        const isPrimary = toothNumber >= 51 && toothNumber <= 86;
        btn.className = `tooth-btn ${isPrimary ? 'primary' : 'permanent'}`;
        btn.title = '';
    }

    updateEditSelectedTeethList();
}

// ==========================================
// نظام الحالة الصحية - إضافة مريض
// ==========================================
function toggleHealthOption(element) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    if (!checkbox) return;
    
    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
        element.classList.add('selected');
        element.style.borderColor = 'var(--primary)';
        element.style.background = 'rgba(79, 70, 229, 0.05)';
    } else {
        element.classList.remove('selected');
        element.style.borderColor = '#e5e7eb';
        element.style.background = 'white';
    }

    const value = checkbox.value;

    if (value === 'diabetes') {
        const control = document.getElementById('diabetesControl');
        if (control) control.style.display = checkbox.checked ? 'block' : 'none';
    } else if (value === 'hypertension') {
        const control = document.getElementById('hypertensionControl');
        if (control) control.style.display = checkbox.checked ? 'block' : 'none';
    }
}

// ==========================================
// نظام الحالة الصحية - تعديل مريض
// ==========================================
function toggleEditHealthOption(element) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    if (!checkbox) return;
    
    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
        element.classList.add('selected');
        element.style.borderColor = 'var(--primary)';
        element.style.background = 'rgba(79, 70, 229, 0.05)';
    } else {
        element.classList.remove('selected');
        element.style.borderColor = '#e5e7eb';
        element.style.background = 'white';
    }

    const value = checkbox.value;

    if (value === 'diabetes') {
        const control = document.getElementById('editDiabetesControl');
        if (control) control.style.display = checkbox.checked ? 'block' : 'none';
    } else if (value === 'hypertension') {
        const control = document.getElementById('editHypertensionControl');
        if (control) control.style.display = checkbox.checked ? 'block' : 'none';
    }
}

function showAddDiseaseModal() {
    const modal = document.getElementById('addDiseaseModal');
    const input = document.getElementById('newDiseaseInput');
    
    if (modal) modal.style.display = 'flex';
    if (input) {
        input.value = '';
        setTimeout(() => input.focus(), 100);
    }
}

function closeAddDiseaseModal() {
    const modal = document.getElementById('addDiseaseModal');
    if (modal) modal.style.display = 'none';
}

function addCustomDisease() {
    const input = document.getElementById('newDiseaseInput');
    const diseaseName = input ? input.value.trim() : '';

    if (!diseaseName) {
        showToast('يرجى كتابة اسم المرض', 'warning');
        return;
    }

    if (addedDiseases.includes(diseaseName)) {
        showToast('هذا المرض مضاف مسبقاً', 'warning');
        return;
    }

    addedDiseases.push(diseaseName);
    updateAddedDiseasesList();
    closeAddDiseaseModal();
    showToast(`تم إضافة "${diseaseName}"`, 'success');
}

function updateAddedDiseasesList() {
    const container = document.getElementById('addedDiseasesList');
    if (!container) return;

    if (addedDiseases.length === 0) {
        container.innerHTML = '';
        return;
    }

    container.innerHTML = addedDiseases.map(disease => `
        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; background: rgba(239, 68, 68, 0.1); color: var(--danger); border-radius: 20px; font-size: 12px; font-weight: 600;">
            <i class="fas fa-disease"></i>
            ${disease}
            <button onclick="removeAddedDisease('${disease}')" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 0; font-size: 12px;">
                <i class="fas fa-times"></i>
            </button>
        </span>
    `).join('');
}

function removeAddedDisease(disease) {
    addedDiseases = addedDiseases.filter(d => d !== disease);
    updateAddedDiseasesList();
}

// ==========================================
// حساب العمر
// ==========================================
function calculateAge() {
    const birthYearInput = document.getElementById('patientBirthYear');
    const ageDisplay = document.getElementById('calculatedAge');
    const ageValue = document.getElementById('ageValue');

    if (!birthYearInput || !ageDisplay || !ageValue) return;
    
    const birthYear = parseInt(birthYearInput.value);

    if (!birthYear || birthYear < 1900 || birthYear > new Date().getFullYear()) {
        ageDisplay.style.display = 'none';
        return;
    }

    const currentYear = new Date().getFullYear();
    const age = currentYear - birthYear;

    ageValue.textContent = age;
    ageDisplay.style.display = 'block';
    
    if (age < 12) {
        selectAgeType('child');
    } else {
        selectAgeType('adult');
    }
}

function calculateEditAge() {
    const birthYearInput = document.getElementById('editPatientBirthYear');
    const ageDisplay = document.getElementById('editCalculatedAge');
    const ageValue = document.getElementById('editAgeValue');

    if (!birthYearInput || !ageDisplay || !ageValue) return;
    
    const birthYear = parseInt(birthYearInput.value);

    if (!birthYear || birthYear < 1900 || birthYear > new Date().getFullYear()) {
        ageDisplay.style.display = 'none';
        return;
    }

    const currentYear = new Date().getFullYear();
    const age = currentYear - birthYear;

    ageValue.textContent = age;
    ageDisplay.style.display = 'block';
}

// ==========================================
// اختيار الجنس
// ==========================================
function selectGender(gender) {
    document.querySelectorAll('.gender-option').forEach(opt => {
        opt.classList.remove('selected');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
    });

    const selectedRadio = document.querySelector(`input[name="patientGender"][value="${gender}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.gender-option');
        if (label) {
            label.classList.add('selected');
            label.style.borderColor = 'var(--primary)';
            label.style.background = 'rgba(79, 70, 229, 0.05)';
        }
    }
}

function selectEditGender(gender) {
    document.querySelectorAll('.edit-gender-option').forEach(opt => {
        opt.classList.remove('selected');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
    });

    const selectedRadio = document.querySelector(`input[name="editPatientGender"][value="${gender}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.edit-gender-option');
        if (label) {
            label.classList.add('selected');
            label.style.borderColor = 'var(--primary)';
            label.style.background = 'rgba(79, 70, 229, 0.05)';
        }
    }
}

// ==========================================
// اختيار نوع العمر
// ==========================================
function selectAgeType(type) {
    document.querySelectorAll('.age-type-option').forEach(opt => {
        opt.classList.remove('selected');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
    });

    const selectedRadio = document.querySelector(`input[name="ageType"][value="${type}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.age-type-option');
        if (label) {
            label.classList.add('selected');
            label.style.borderColor = type === 'child' ? 'var(--warning)' : 'var(--secondary)';
            label.style.background = type === 'child' ? 'rgba(245, 158, 11, 0.05)' : 'rgba(16, 185, 129, 0.05)';
        }
    }

    updatePrimaryTeethVisibility();
}

function selectEditAgeType(type) {
    document.querySelectorAll('.edit-age-type-option').forEach(opt => {
        opt.classList.remove('selected');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
    });

    const selectedRadio = document.querySelector(`input[name="editAgeType"][value="${type}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.edit-age-type-option');
        if (label) {
            label.classList.add('selected');
            label.style.borderColor = type === 'child' ? 'var(--warning)' : 'var(--secondary)';
            label.style.background = type === 'child' ? 'rgba(245, 158, 11, 0.05)' : 'rgba(16, 185, 129, 0.05)';
        }
    }

    const parentSection = document.getElementById('editParentInfoSection');
    const primaryTeethSection = document.getElementById('editPrimaryTeethSection');
    
    if (type === 'child') {
        if (parentSection) parentSection.style.display = 'block';
        if (primaryTeethSection) primaryTeethSection.style.display = 'block';
    } else {
        if (parentSection) parentSection.style.display = 'none';
        if (primaryTeethSection) primaryTeethSection.style.display = 'none';
    }
}

function updatePrimaryTeethVisibility() {
    const ageTypeRadio = document.querySelector('input[name="ageType"]:checked');
    const ageType = ageTypeRadio ? ageTypeRadio.value : 'child';
    
    const primarySection = document.getElementById('primaryTeethSection');
    const parentSection = document.getElementById('parentInfoSection');
    
    if (ageType === 'child') {
        if (primarySection) primarySection.style.display = 'block';
        if (parentSection) parentSection.style.display = 'block';
    } else {
        if (primarySection) primarySection.style.display = 'none';
        if (parentSection) parentSection.style.display = 'none';
    }
}

// ==========================================
// اختيار حالة التحكم بالأمراض
// ==========================================
function selectControl(type, value) {
    const inputName = type === 'diabetes' ? 'diabetesControlled' : 'bpControlled';
    const containerId = type === 'diabetes' ? 'diabetesControl' : 'hypertensionControl';
    const container = document.getElementById(containerId);

    if (!container) return;

    container.querySelectorAll('.control-option').forEach(opt => {
        opt.classList.remove('selected-yes', 'selected-no');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
    });

    const selectedRadio = container.querySelector(`input[name="${inputName}"][value="${value}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.control-option');
        if (label) {
            if (value === 'yes') {
                label.classList.add('selected-yes');
                label.style.borderColor = 'var(--secondary)';
                label.style.background = 'rgba(16, 185, 129, 0.1)';
            } else {
                label.classList.add('selected-no');
                label.style.borderColor = 'var(--danger)';
                label.style.background = 'rgba(239, 68, 68, 0.1)';
            }
        }
    }
}

function selectEditControl(type, value) {
    const inputName = type === 'diabetes' ? 'editDiabetesControlled' : 'editBpControlled';
    const containerId = type === 'diabetes' ? 'editDiabetesControl' : 'editHypertensionControl';
    const container = document.getElementById(containerId);

    if (!container) return;

    container.querySelectorAll('.edit-control-option').forEach(opt => {
        opt.classList.remove('selected-yes', 'selected-no');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
    });

    const selectedRadio = container.querySelector(`input[name="${inputName}"][value="${value}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.edit-control-option');
        if (label) {
            if (value === 'yes') {
                label.classList.add('selected-yes');
                label.style.borderColor = 'var(--secondary)';
                label.style.background = 'rgba(16, 185, 129, 0.1)';
            } else {
                label.classList.add('selected-no');
                label.style.borderColor = 'var(--danger)';
                label.style.background = 'rgba(239, 68, 68, 0.1)';
            }
        }
    }
}

// ==========================================
// نظام صلاحيات الوصول - إضافة
// ==========================================
function selectAccessType(type) {
    document.querySelectorAll('.access-option').forEach(opt => {
        opt.classList.remove('selected');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
        const check = opt.querySelector('.access-check');
        if (check) check.style.color = '#e5e7eb';
    });

    const selectedRadio = document.querySelector(`input[name="accessType"][value="${type}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.access-option');
        if (label) {
            label.classList.add('selected');
            label.style.borderColor = 'var(--primary)';
            label.style.background = 'rgba(79, 70, 229, 0.05)';
            const check = label.querySelector('.access-check');
            if (check) check.style.color = 'var(--primary)';
        }
    }

    const customSection = document.getElementById('customStudentsSection');
    if (customSection) {
        customSection.style.display = type === 'custom' ? 'block' : 'none';
    }
}

function addStudent() {
    const input = document.getElementById('studentIdInput');
    const studentId = input ? input.value.trim() : '';

    if (!studentId) {
        showToast('يرجى إدخال الرقم الجامعي', 'warning');
        return;
    }

    if (addedStudents.includes(studentId)) {
        showToast('هذا الطالب مضاف مسبقاً', 'warning');
        return;
    }

    addedStudents.push(studentId);
    updateStudentsList();
    if (input) input.value = '';
    showToast(`تم إضافة الطالب ${studentId}`, 'success');
}

function updateStudentsList() {
    const container = document.getElementById('studentsList');
    if (!container) return;

    if (addedStudents.length === 0) {
        container.innerHTML = '<span style="font-size: 12px; color: var(--gray);">لم تتم إضافة طلاب بعد</span>';
        return;
    }

    container.innerHTML = addedStudents.map(id => `
        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: var(--primary); color: white; border-radius: 20px; font-size: 12px; font-weight: 600;">
            <i class="fas fa-user-graduate"></i>
            ${id}
            <button onclick="removeStudent('${id}')" style="background: none; border: none; color: white; cursor: pointer; padding: 0; font-size: 11px;">
                <i class="fas fa-times"></i>
            </button>
        </span>
    `).join('');
}

function removeStudent(studentId) {
    addedStudents = addedStudents.filter(id => id !== studentId);
    updateStudentsList();
}

// ==========================================
// إضافة مريض جديد
// ==========================================
function addNewPatient() {
    const name = document.getElementById('patientName')?.value.trim();
    const birthYear = parseInt(document.getElementById('patientBirthYear')?.value);
    const phone = document.getElementById('patientPhone')?.value || '';
    const governorate = document.getElementById('patientGovernorate')?.value || '';
    const address = document.getElementById('patientAddress')?.value || '';
    const gender = document.querySelector('input[name="patientGender"]:checked')?.value || 'male';
    const ageType = document.querySelector('input[name="ageType"]:checked')?.value || 'child';
    const accessType = document.querySelector('input[name="accessType"]:checked')?.value || 'private';
    const notes = document.getElementById('patientNotes')?.value || '';

    if (!name) {
        showToast('يرجى إدخال اسم المريض', 'warning');
        return;
    }

    if (!birthYear) {
        showToast('يرجى إدخال سنة الميلاد', 'warning');
        return;
    }

    if (ageType === 'child') {
        const parentName = document.getElementById('parentName')?.value.trim();
        const parentPhone = document.getElementById('parentPhone')?.value.trim();
        
        if (!parentName) {
            showToast('يرجى إدخال اسم ولي الأمر للطفل', 'warning');
            return;
        }
        if (!parentPhone || parentPhone.length < 8) {
            showToast('يرجى إدخال رقم موبايل صحيح لولي الأمر', 'warning');
            return;
        }
    }

    const currentYear = new Date().getFullYear();
    const calculatedAge = currentYear - birthYear;

    const diseases = [];
    document.querySelectorAll('input[name="diseases"]:checked').forEach(cb => {
        diseases.push(cb.value);
    });

    const diabetesControlled = document.querySelector('input[name="diabetesControlled"]:checked')?.value || null;
    const bpControlled = document.querySelector('input[name="bpControlled"]:checked')?.value || null;

    const colors = ['primary', 'secondary', 'accent', 'warning', 'danger'];
    const randomColor = colors[Math.floor(Math.random() * colors.length)];

    const newPatient = {
        id: Date.now(),
        name: name,
        record: 'MED-2024-' + String(patientsData.length + 1).padStart(3, '0'),
        birthYear: birthYear,
        age: calculatedAge,
        ageType: ageType,
        gender: gender,
        phone: phone ? '09' + phone : '',
        governorate: governorate,
        address: address,
        type: accessType,
        specialty: 'أسنان',
        date: new Date().toLocaleDateString('ar-SA'),
        initial: name.charAt(0),
        color: randomColor,
        status: 'active',
        teeth: { ...selectedTeeth },
        healthConditions: {
            diseases: [...diseases],
            addedDiseases: [...addedDiseases],
            diabetesControlled: diabetesControlled,
            bpControlled: bpControlled
        },
        accessPermissions: {
            type: accessType,
            allowedStudents: accessType === 'custom' ? [...addedStudents] : [],
            caseManager: 'current_user'
        },
        parentInfo: ageType === 'child' ? {
            name: document.getElementById('parentName')?.value,
            phone: '09' + (document.getElementById('parentPhone')?.value || ''),
            birthYear: parseInt(document.getElementById('parentBirthYear')?.value) || null
        } : null,
        notes: notes,
        addedBy: 'current_user',
        addedByName: 'الطالب الحالي',
        addedAt: new Date().toISOString(),
        editHistory: [],
        transferHistory: [],
        treatmentStarted: false
    };

    patientsData.push(newPatient);
    
    addToAuditLog({
        operationType: 'add',
        patientId: newPatient.id,
        patientName: newPatient.name,
        employeeId: 'current_user',
        employeeName: 'الطالب الحالي',
        details: 'إضافة مريض جديد',
        changes: [],
        oldValue: null,
        newValue: `اسم: ${name}، العمر: ${calculatedAge}، الجنس: ${gender === 'male' ? 'ذكر' : 'أنثى'}`
    });
    
    resetNewPatientForm();
    showToast('تم إضافة المريض بنجاح', 'success');
}

function resetNewPatientForm() {
    const fields = ['patientName', 'patientBirthYear', 'patientPhone', 'patientGovernorate', 'patientAddress', 'patientNotes', 'parentName', 'parentPhone', 'parentBirthYear'];
    fields.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });

    const ageDisplay = document.getElementById('calculatedAge');
    if (ageDisplay) ageDisplay.style.display = 'none';

    document.querySelectorAll('input[name="diseases"]').forEach(cb => {
        cb.checked = false;
        const label = cb.closest('.health-checkbox');
        if (label) {
            label.classList.remove('selected');
            label.style.borderColor = '#e5e7eb';
            label.style.background = 'white';
        }
    });
    
    const diabetesControl = document.getElementById('diabetesControl');
    const hypertensionControl = document.getElementById('hypertensionControl');
    if (diabetesControl) diabetesControl.style.display = 'none';
    if (hypertensionControl) hypertensionControl.style.display = 'none';

    addedDiseases = [];
    updateAddedDiseasesList();

    selectedTeeth = {};
    document.querySelectorAll('.tooth-btn').forEach(btn => {
        const toothNum = parseInt(btn.dataset.tooth);
        const isPrimary = toothNum >= 51 && toothNum <= 86;
        btn.className = `tooth-btn ${isPrimary ? 'primary' : 'permanent'}`;
        btn.title = '';
    });
    updateSelectedTeethList();
    updateTeethStats();

    addedStudents = [];
    updateStudentsList();

    selectAccessType('private');
    selectGender('male');
    selectAgeType('child');
}

// ==========================================
// البحث عن المريض للتعديل (بالاسم الثلاثي فقط)
// ==========================================
function searchPatientForEdit() {
    const studentId = document.getElementById('editSearchStudentId')?.value.trim();
    const patientName = document.getElementById('editSearchPatientName')?.value.trim();
    const resultsContainer = document.getElementById('editSearchResults');
    
    if (!resultsContainer) return;
    
    let results = [...patientsData];
    
    // البحث بالرقم الجامعي إذا أدخل
    if (studentId) {
        results = results.filter(p => 
            p.addedBy === studentId || 
            p.accessPermissions?.allowedStudents?.includes(studentId) ||
            p.accessPermissions?.caseManager === studentId
        );
    }
    
    // البحث بالاسم الثلاثي (إجباري)
    if (!patientName || patientName.length < 3) {
        showToast('يرجى إدخال الاسم الثلاثي للمريض (3 أحرف على الأقل)', 'warning');
        return;
    }
    
    results = results.filter(p => p.name.toLowerCase().includes(patientName.toLowerCase()));
    
    if (results.length === 0) {
        resultsContainer.innerHTML = `
            <div style="text-align: center; padding: 30px; background: white; border-radius: 12px; color: var(--gray);">
                <i class="fas fa-search" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
                لا توجد نتائج مطابقة للبحث
            </div>
        `;
        return;
    }
    
    // عرض النتائج
    resultsContainer.innerHTML = results.map(p => `
        <div class="patient-card" onclick="loadPatientForEdit(${p.id})" style="cursor: pointer; border: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='transparent'">
            <div style="display: flex; gap: 14px; align-items: center;">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--${p.color}), var(--${p.color}-light, var(--${p.color}))); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700;">
                    ${p.initial}
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${p.name}</div>
                    <div style="font-size: 12px; color: var(--gray); margin-top: 4px;">
                        <i class="fas fa-hashtag" style="margin-left: 4px;"></i>${p.record} | 
                        <i class="fas fa-birthday-cake" style="margin-left: 4px;"></i>${p.age} سنة |
                        <i class="fas fa-user-graduate" style="margin-left: 4px;"></i>${p.addedByName || p.addedBy}
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--gray);"></i>
            </div>
        </div>
    `).join('');
}

// ==========================================
// تحميل وتعديل بيانات المريض
// ==========================================
function loadPatientForEdit(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (!patient) {
        showToast('المريض غير موجود', 'danger');
        return;
    }
    
    currentEditingPatient = patient;
    editSelectedTeeth = JSON.parse(JSON.stringify(patient.teeth || {}));
    editAddedDiseases = [...(patient.healthConditions?.addedDiseases || [])];
    editAddedStudents = [...(patient.accessPermissions?.allowedStudents || [])];
    
    const form = document.getElementById('editPatientForm');
    const results = document.getElementById('editSearchResults');
    const badge = document.getElementById('editPatientBadge');
    
    if (form) form.style.display = 'block';
    if (results) results.style.display = 'none';
    if (badge) badge.textContent = patient.record;
    
    // تعبئة البيانات الأساسية
    const nameEl = document.getElementById('editPatientName');
    const birthYearEl = document.getElementById('editPatientBirthYear');
    const phoneEl = document.getElementById('editPatientPhone');
    const governorateEl = document.getElementById('editPatientGovernorate');
    const addressEl = document.getElementById('editPatientAddress');
    const notesEl = document.getElementById('editPatientNotes');
    
    if (nameEl) nameEl.value = patient.name;
    if (birthYearEl) birthYearEl.value = patient.birthYear || '';
    if (phoneEl) phoneEl.value = patient.phone ? patient.phone.replace('09', '') : '';
    if (governorateEl) governorateEl.value = patient.governorate || '';
    if (addressEl) addressEl.value = patient.address || '';
    if (notesEl) notesEl.value = patient.notes || '';
    
    calculateEditAge();
    selectEditGender(patient.gender);
    selectEditAgeType(patient.ageType);
    
    // معلومات ولي الأمر للأطفال
    if (patient.ageType === 'child' && patient.parentInfo) {
        const parentName = document.getElementById('editParentName');
        const parentPhone = document.getElementById('editParentPhone');
        const parentBirthYear = document.getElementById('editParentBirthYear');
        
        if (parentName) parentName.value = patient.parentInfo.name || '';
        if (parentPhone) parentPhone.value = patient.parentInfo.phone ? patient.parentInfo.phone.replace('09', '') : '';
        if (parentBirthYear) parentBirthYear.value = patient.parentInfo.birthYear || '';
    }
    
    // الأمراض المزمنة
    document.querySelectorAll('input[name="editDiseases"]').forEach(cb => {
        const isChecked = patient.healthConditions?.diseases?.includes(cb.value) || false;
        cb.checked = isChecked;
        const label = cb.closest('.edit-health-checkbox');
        if (label) {
            if (isChecked) {
                label.classList.add('selected');
                label.style.borderColor = 'var(--primary)';
                label.style.background = 'rgba(79, 70, 229, 0.05)';
            } else {
                label.classList.remove('selected');
                label.style.borderColor = '#e5e7eb';
                label.style.background = 'white';
            }
        }
    });
    
    // حالات التحكم بالأمراض
    const editDiabetesControl = document.getElementById('editDiabetesControl');
    const editHypertensionControl = document.getElementById('editHypertensionControl');
    
    if (editDiabetesControl) {
        editDiabetesControl.style.display = patient.healthConditions?.diseases?.includes('diabetes') ? 'block' : 'none';
    }
    if (editHypertensionControl) {
        editHypertensionControl.style.display = patient.healthConditions?.diseases?.includes('hypertension') ? 'block' : 'none';
    }
    
    if (patient.healthConditions?.diabetesControlled) {
        selectEditControl('diabetes', patient.healthConditions.diabetesControlled);
    }
    if (patient.healthConditions?.bpControlled) {
        selectEditControl('bp', patient.healthConditions.bpControlled);
    }
    
    updateEditAddedDiseasesList();
    buildEditTeethChart();
    updateEditSelectedTeethList();
    renderEditHistory(patient);
    
    showToast(`تم تحميل بيانات المريض: ${patient.name}`, 'success');
}

function buildEditTeethChart() {
    const container = document.getElementById('editTeethChart');
    if (!container) return;
    
    const isChild = currentEditingPatient?.ageType === 'child';
    
    // الأسنان الدائمة العلوية
    let html = '<div style="margin-bottom: 12px;"><div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
    [18,17,16,15,14,13,12,11].forEach(t => {
        const toothData = editSelectedTeeth[t];
        const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn permanent';
        html += `<button type="button" class="${btnClass}" data-tooth="${t}" onclick="selectEditTooth(${t})" title="${toothData ? toothData.label : ''}">${t}</button>`;
    });
    html += '<div style="width: 12px;"></div>';
    [21,22,23,24,25,26,27,28].forEach(t => {
        const toothData = editSelectedTeeth[t];
        const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn permanent';
        html += `<button type="button" class="${btnClass}" data-tooth="${t}" onclick="selectEditTooth(${t})" title="${toothData ? toothData.label : ''}">${t}</button>`;
    });
    html += '</div></div>';
    
    // الأسنان الدائمة السفلية
    html += '<div style="margin-bottom: 16px;"><div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
    [48,47,46,45,44,43,42,41].forEach(t => {
        const toothData = editSelectedTeeth[t];
        const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn permanent';
        html += `<button type="button" class="${btnClass}" data-tooth="${t}" onclick="selectEditTooth(${t})" title="${toothData ? toothData.label : ''}">${t}</button>`;
    });
    html += '<div style="width: 12px;"></div>';
    [31,32,33,34,35,36,37,38].forEach(t => {
        const toothData = editSelectedTeeth[t];
        const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn permanent';
        html += `<button type="button" class="${btnClass}" data-tooth="${t}" onclick="selectEditTooth(${t})" title="${toothData ? toothData.label : ''}">${t}</button>`;
    });
    html += '</div></div>';
    
    // الأسنان المؤقتة (للأطفال فقط)
    if (isChild) {
        html += '<div id="editPrimaryTeethSection" style="margin-top: 16px; padding-top: 16px; border-top: 2px dashed #e5e7eb;">';
        html += '<div style="font-size: 11px; color: var(--warning); text-align: center; margin-bottom: 8px; font-weight: 600;">الأسنان المؤقتة</div>';
        
        html += '<div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap; margin-bottom: 8px;">';
        [55,54,53,52,51].forEach(t => {
            const toothData = editSelectedTeeth[t];
            const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn primary';
            html += `<button type="button" class="${btnClass}" data-tooth="${t}" onclick="selectEditTooth(${t})" title="${toothData ? toothData.label : ''}">${t}</button>`;
        });
        html += '<div style="width: 12px;"></div>';
        [61,62,63,64,65].forEach(t => {
            const toothData = editSelectedTeeth[t];
            const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn primary';
            html += `<button type="button" class="${btnClass}" data-tooth="${t}" onclick="selectEditTooth(${t})" title="${toothData ? toothData.label : ''}">${t}</button>`;
        });
        html += '</div>';
        
        html += '<div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
        [85,84,83,82,81].forEach(t => {
            const toothData = editSelectedTeeth[t];
            const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn primary';
            html += `<button type="button" class="${btnClass}" data-tooth="${t}" onclick="selectEditTooth(${t})" title="${toothData ? toothData.label : ''}">${t}</button>`;
        });
        html += '<div style="width: 12px;"></div>';
        [71,72,73,74,75].forEach(t => {
            const toothData = editSelectedTeeth[t];
            const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn primary';
            html += `<button type="button" class="${btnClass}" data-tooth="${t}" onclick="selectEditTooth(${t})" title="${toothData ? toothData.label : ''}">${t}</button>`;
        });
        html += '</div></div>';
    }
    
    container.innerHTML = html;
}

function selectEditTooth(toothNumber) {
    currentToothNumber = toothNumber;
    isEditMode = true;
    
    const modal = document.getElementById('toothModal');
    const toothNumEl = document.getElementById('selectedToothNumber');
    
    if (toothNumEl) toothNumEl.textContent = toothNumber;
    
    const isPrimary = (toothNumber >= 51 && toothNumber <= 86);
    
    const crownOption = document.getElementById('crownOption');
    const conservativeOption = document.getElementById('conservativeOption');
    
    if (crownOption) crownOption.style.display = isPrimary ? 'flex' : 'none';
    if (conservativeOption) conservativeOption.style.display = isPrimary ? 'flex' : 'none';
    
    if (modal) modal.style.display = 'flex';
}

function updateEditAddedDiseasesList() {
    const container = document.getElementById('editAddedDiseasesList');
    if (!container) return;

    if (editAddedDiseases.length === 0) {
        container.innerHTML = '';
        return;
    }

    container.innerHTML = editAddedDiseases.map(disease => `
        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; background: rgba(239, 68, 68, 0.1); color: var(--danger); border-radius: 20px; font-size: 12px; font-weight: 600;">
            <i class="fas fa-disease"></i>
            ${disease}
            <button onclick="removeEditAddedDisease('${disease}')" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 0; font-size: 12px;">
                <i class="fas fa-times"></i>
            </button>
        </span>
    `).join('');
}

function removeEditAddedDisease(disease) {
    editAddedDiseases = editAddedDiseases.filter(d => d !== disease);
    updateEditAddedDiseasesList();
}

function renderEditHistory(patient) {
    const container = document.getElementById('editHistoryList');
    if (!container) return;
    
    if (!patient.editHistory || patient.editHistory.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 30px; color: var(--gray); font-size: 13px; background: white; border-radius: 12px;"><i class="fas fa-history" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>لا يوجد سجل تعديلات</div>';
        return;
    }
    
    container.innerHTML = patient.editHistory.map((edit, index) => `
        <div style="background: white; padding: 16px; border-radius: 12px; margin-bottom: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 32px; height: 32px; background: var(--warning); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: var(--dark);">تعديل #${patient.editHistory.length - index}</div>
                        <div style="font-size: 11px; color: var(--gray);">${new Date(edit.date).toLocaleDateString('ar-SA')} - ${edit.time}</div>
                    </div>
                </div>
            </div>
            
            ${edit.changes && edit.changes.length > 0 ? `
            <div style="background: #f9fafb; padding: 12px; border-radius: 8px; margin-bottom: 10px;">
                ${edit.changes.map(change => `
                    <div style="margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px dashed #e5e7eb;">
                        <div style="font-size: 12px; font-weight: 600; color: var(--dark); margin-bottom: 4px;">
                            <i class="fas fa-tag" style="margin-left: 4px; color: var(--primary);"></i>
                            ${change.field}
                        </div>
                        <div style="font-size: 11px; color: var(--danger); margin-bottom: 2px;">
                            <i class="fas fa-arrow-left" style="margin-left: 4px; transform: rotate(180deg); display: inline-block;"></i>
                            ${change.oldValue}
                        </div>
                        <div style="font-size: 11px; color: var(--secondary);">
                            <i class="fas fa-arrow-left" style="margin-left: 4px;"></i>
                            ${change.newValue}
                        </div>
                    </div>
                `).join('')}
            </div>
            ` : ''}
            
            <div style="font-size: 12px; color: var(--warning); background: rgba(245, 158, 11, 0.1); padding: 10px; border-radius: 8px; margin-bottom: 8px;">
                <i class="fas fa-comment" style="margin-left: 4px;"></i>
                <strong>السبب:</strong> ${edit.reason}
            </div>
            
            <div style="font-size: 11px; color: var(--gray); display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-user"></i>
                بواسطة: ${edit.editedByName || edit.editedBy}
            </div>
        </div>
    `).join('');
}

function savePatientEdit() {
    const reasonInput = document.getElementById('editReason');
    const reason = reasonInput ? reasonInput.value.trim() : '';
    
    if (!reason) {
        showToast('يرجى كتابة سبب التعديل (مطلوب)', 'warning');
        if (reasonInput) reasonInput.focus();
        return;
    }
    
    if (!currentEditingPatient) {
        showToast('خطأ: لا يوجد مريض محدد للتعديل', 'danger');
        return;
    }
    
    const newName = document.getElementById('editPatientName')?.value.trim();
    const newBirthYear = parseInt(document.getElementById('editPatientBirthYear')?.value);
    const newPhone = document.getElementById('editPatientPhone')?.value.trim() || '';
    const newGovernorate = document.getElementById('editPatientGovernorate')?.value || '';
    const newAddress = document.getElementById('editPatientAddress')?.value.trim() || '';
    const newNotes = document.getElementById('editPatientNotes')?.value.trim() || '';
    const newGender = document.querySelector('input[name="editPatientGender"]:checked')?.value;
    const newAgeType = document.querySelector('input[name="editAgeType"]:checked')?.value;
    
    if (!newName) {
        showToast('يرجى إدخال اسم المريض', 'warning');
        return;
    }
    
    if (!newBirthYear) {
        showToast('يرجى إدخال سنة الميلاد', 'warning');
        return;
    }
    
    const changes = [];
    
    if (currentEditingPatient.name !== newName) {
        changes.push({
            field: 'الاسم',
            oldValue: currentEditingPatient.name,
            newValue: newName
        });
    }
    
    if (currentEditingPatient.birthYear !== newBirthYear) {
        changes.push({
            field: 'سنة الميلاد',
            oldValue: currentEditingPatient.birthYear,
            newValue: newBirthYear
        });
    }
    
    const currentYear = new Date().getFullYear();
    const newAge = currentYear - newBirthYear;
    
    if (currentEditingPatient.age !== newAge) {
        changes.push({
            field: 'العمر',
            oldValue: currentEditingPatient.age + ' سنة',
            newValue: newAge + ' سنة'
        });
    }
    
    const newPhoneFull = newPhone ? '09' + newPhone : '';
    if (currentEditingPatient.phone !== newPhoneFull) {
        changes.push({
            field: 'رقم الهاتف',
            oldValue: currentEditingPatient.phone || 'غير محدد',
            newValue: newPhoneFull || 'غير محدد'
        });
    }
    
    if (currentEditingPatient.governorate !== newGovernorate) {
        changes.push({
            field: 'المحافظة',
            oldValue: currentEditingPatient.governorate || 'غير محدد',
            newValue: newGovernorate || 'غير محدد'
        });
    }
    
    if (currentEditingPatient.address !== newAddress) {
        changes.push({
            field: 'العنوان',
            oldValue: currentEditingPatient.address || 'غير محدد',
            newValue: newAddress || 'غير محدد'
        });
    }
    
    if (currentEditingPatient.gender !== newGender) {
        changes.push({
            field: 'الجنس',
            oldValue: currentEditingPatient.gender === 'male' ? 'ذكر' : 'أنثى',
            newValue: newGender === 'male' ? 'ذكر' : 'أنثى'
        });
    }
    
    if (currentEditingPatient.ageType !== newAgeType) {
        changes.push({
            field: 'نوع العمر',
            oldValue: currentEditingPatient.ageType === 'child' ? 'طفل' : 'بالغ',
            newValue: newAgeType === 'child' ? 'طفل' : 'بالغ'
        });
    }
    
    if (currentEditingPatient.notes !== newNotes) {
        changes.push({
            field: 'الملاحظات',
            oldValue: currentEditingPatient.notes || 'لا يوجد',
            newValue: newNotes || 'لا يوجد'
        });
    }
    
    // تحديث بيانات الأسنان
    const oldTeethKeys = Object.keys(currentEditingPatient.teeth || {});
    const newTeethKeys = Object.keys(editSelectedTeeth);
    
    if (JSON.stringify(currentEditingPatient.teeth) !== JSON.stringify(editSelectedTeeth)) {
        changes.push({
            field: 'حالات الأسنان',
            oldValue: `${oldTeethKeys.length} سن`,
            newValue: `${newTeethKeys.length} سن`
        });
    }
    
    // تحديث بيانات المريض
    currentEditingPatient.name = newName;
    currentEditingPatient.birthYear = newBirthYear;
    currentEditingPatient.age = newAge;
    currentEditingPatient.phone = newPhoneFull;
    currentEditingPatient.governorate = newGovernorate;
    currentEditingPatient.address = newAddress;
    currentEditingPatient.notes = newNotes;
    currentEditingPatient.gender = newGender;
    currentEditingPatient.ageType = newAgeType;
    currentEditingPatient.initial = newName.charAt(0);
    currentEditingPatient.teeth = JSON.parse(JSON.stringify(editSelectedTeeth));
    
    // تحديث معلومات ولي الأمر إذا كان طفلاً
    if (newAgeType === 'child') {
        const parentName = document.getElementById('editParentName')?.value.trim();
        const parentPhone = document.getElementById('editParentPhone')?.value.trim();
        const parentBirthYear = parseInt(document.getElementById('editParentBirthYear')?.value);
        
        if (parentName || parentPhone) {
            currentEditingPatient.parentInfo = {
                name: parentName,
                phone: parentPhone ? '09' + parentPhone : '',
                birthYear: parentBirthYear || null
            };
            
            if (!currentEditingPatient.parentInfo || 
                currentEditingPatient.parentInfo.name !== parentName) {
                changes.push({
                    field: 'ولي الأمر',
                    oldValue: currentEditingPatient.parentInfo?.name || 'غير محدد',
                    newValue: parentName || 'غير محدد'
                });
            }
        }
    } else {
        currentEditingPatient.parentInfo = null;
    }
    
    // الأمراض
    const newDiseases = [];
    document.querySelectorAll('input[name="editDiseases"]:checked').forEach(cb => {
        newDiseases.push(cb.value);
    });
    
    const diabetesControlled = document.querySelector('input[name="editDiabetesControlled"]:checked')?.value || null;
    const bpControlled = document.querySelector('input[name="editBpControlled"]:checked')?.value || null;
    
    currentEditingPatient.healthConditions = {
        diseases: newDiseases,
        addedDiseases: [...editAddedDiseases],
        diabetesControlled: diabetesControlled,
        bpControlled: bpControlled
    };
    
    // سجل التعديل
    const editRecord = {
        id: Date.now(),
        field: 'بيانات عامة',
        changes: changes,
        oldValue: changes.length > 0 ? changes.map(c => `${c.field}: ${c.oldValue}`).join(' | ') : 'لا توجد تغييرات',
        newValue: changes.length > 0 ? changes.map(c => `${c.field}: ${c.newValue}`).join(' | ') : 'لا توجد تغييرات',
        reason: reason,
        date: new Date().toISOString(),
        time: new Date().toLocaleTimeString('ar-SA'),
        editedBy: 'current_user',
        editedByName: 'الطالب الحالي'
    };
    
    if (!currentEditingPatient.editHistory) {
        currentEditingPatient.editHistory = [];
    }
    currentEditingPatient.editHistory.unshift(editRecord);
    
    // إضافة للسجل العام
    addToAuditLog({
        operationType: 'edit',
        patientId: currentEditingPatient.id,
        patientName: currentEditingPatient.name,
        employeeId: 'current_user',
        employeeName: 'الطالب الحالي',
        details: `تعديل بيانات مريض - ${changes.length} تغيير`,
        changes: changes,
        oldValue: changes.map(c => `${c.field}: ${c.oldValue}`).join(' | '),
        newValue: changes.map(c => `${c.field}: ${c.newValue}`).join(' | '),
        reason: reason
    });
    
    showToast(`تم حفظ التعديلات بنجاح (${changes.length} تغيير)`, 'success');
    renderEditHistory(currentEditingPatient);
    
    // إعادة تعيين
    setTimeout(() => {
        cancelEdit();
    }, 1500);
}

function cancelEdit() {
    const form = document.getElementById('editPatientForm');
    const results = document.getElementById('editSearchResults');
    const reasonInput = document.getElementById('editReason');
    
    if (form) form.style.display = 'none';
    if (results) results.style.display = 'block';
    if (reasonInput) reasonInput.value = '';
    
    // مسح نتائج البحث
    if (results) results.innerHTML = '';
    
    currentEditingPatient = null;
    editSelectedTeeth = {};
    editAddedDiseases = [];
    editAddedStudents = [];
}

// ==========================================
// باقي الدوال (الصلاحيات، البحث، التحويل، السجل)
// ==========================================
function searchAccessPermissions() {
    const studentId = document.getElementById('accessSearchStudentId')?.value.trim();
    const patientName = document.getElementById('accessSearchPatientName')?.value.trim();
    
    let results = [...patientsData];
    
    if (studentId) {
        results = results.filter(p => 
            p.addedBy === studentId || 
            p.accessPermissions?.allowedStudents?.includes(studentId) ||
            p.accessPermissions?.caseManager === studentId
        );
    }
    
    if (patientName) {
        results = results.filter(p => p.name.includes(patientName));
    }
    
    const container = document.getElementById('accessPatientsList');
    if (!container) return;
    
    if (results.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 40px; background: white; border-radius: 16px;">
                <i class="fas fa-user-shield" style="font-size: 48px; color: var(--gray); margin-bottom: 16px;"></i>
                <div style="font-size: 16px; color: var(--dark); font-weight: 600;">لا توجد نتائج</div>
            </div>
        `;
        return;
    }
    
    container.innerHTML = results.map(p => {
        const accessType = p.accessPermissions?.type || p.type;
        let accessBadge = '';
        let accessIcon = '';
        
        if (accessType === 'private') {
            accessBadge = 'خاص (للطالب فقط)';
            accessIcon = 'fa-user-shield';
        } else if (accessType === 'public') {
            accessBadge = 'عام (للجميع)';
            accessIcon = 'fa-globe';
        } else {
            accessBadge = `مخصص (${p.accessPermissions?.allowedStudents?.length || 0} طلاب)`;
            accessIcon = 'fa-users-cog';
        }
        
        return `
            <div class="patient-card">
                <div style="display: flex; gap: 14px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--${p.color}), var(--${p.color}-light, var(--${p.color}))); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 700;">
                        ${p.initial}
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <div style="font-size: 17px; font-weight: 700; color: var(--dark);">${p.name}</div>
                                <div style="font-size: 12px; color: var(--gray); margin-top: 4px;">
                                    <i class="fas fa-hashtag" style="margin-left: 4px;"></i>${p.record}
                                </div>
                            </div>
                            <span style="background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                <i class="fas ${accessIcon}" style="margin-left: 4px;"></i>${accessBadge}
                            </span>
                        </div>
                        
                        <div style="margin-top: 12px; padding: 12px; background: #f9fafb; border-radius: 10px;">
                            <div style="font-size: 11px; color: var(--gray); margin-bottom: 6px;">الطلاب المصرح لهم:</div>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                <span style="background: var(--primary); color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-star" style="margin-left: 4px;"></i>مدير الحالة: ${p.accessPermissions?.caseManager || p.addedBy}
                                </span>
                                ${(p.accessPermissions?.allowedStudents || []).map(s => `
                                    <span style="background: white; border: 1px solid #e5e7eb; padding: 4px 10px; border-radius: 20px; font-size: 11px;">
                                        ${s}
                                    </span>
                                `).join('')}
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 8px; margin-top: 12px;">
                            <button onclick="editAccessPermissions(${p.id})" style="flex: 1; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-edit" style="margin-left: 4px;"></i>تعديل الصلاحيات
                            </button>
                            <button onclick="notifyStudents(${p.id})" style="background: var(--secondary); color: white; border: none; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-bell"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

function editAccessPermissions(patientId) {
    showToast('جاري فتح نموذج تعديل الصلاحيات...', 'info');
}

function notifyStudents(patientId) {
    showToast('تم إرسال الإشعارات للطلاب المعنيين', 'success');
}

// ==========================================
// البحث عن الحالة - محسن مع عرض رقم السن
// ==========================================
function searchCases() {
    const course = document.getElementById('searchCourse')?.value;
    const caseType = document.getElementById('searchCaseType')?.value;
    const gender = document.getElementById('searchGender')?.value;
    const bookingStatus = document.getElementById('searchBookingStatus')?.value;
    
    let results = [...patientsData];
    
    // فلترة حسب المقرر (حسب نوع الحالة في الأسنان)
    if (course) {
        results = results.filter(p => {
            const teethValues = Object.values(p.teeth || {});
            if (course === 'restorative') {
                return teethValues.some(t => t.condition === 'restorative');
            } else if (course === 'endodontic') {
                return teethValues.some(t => t.condition === 'endodontic');
            } else if (course === 'surgery') {
                return teethValues.some(t => t.condition === 'extraction' && t.subCondition === 'impacted');
            } else if (course === 'pediatric') {
                return p.ageType === 'child';
            } else if (course === 'prosthesis') {
                return teethValues.some(t => t.condition === 'crown');
            }
            return true;
        });
    }
    
    // فلترة حسب نوع الحالة
    if (caseType) {
        results = results.filter(p => {
            const teethValues = Object.values(p.teeth || {});
            if (caseType.startsWith('class')) {
                return teethValues.some(t => t.subCondition === caseType);
            } else if (caseType === 'root_canal') {
                return teethValues.some(t => t.condition === 'endodontic');
            } else if (caseType === 'extraction') {
                return teethValues.some(t => t.condition === 'extraction');
            }
            return true;
        });
    }
    
    if (gender) {
        results = results.filter(p => p.gender === gender);
    }
    
    // فلترة حسب حالة الحجز
    if (bookingStatus && bookingStatus !== 'all') {
        results = results.filter(p => {
            if (bookingStatus === 'available') return !p.treatmentStarted && !p.tempBooked;
            if (bookingStatus === 'temp_booked') return p.tempBooked;
            if (bookingStatus === 'confirmed') return p.treatmentStarted;
            if (bookingStatus === 'in_progress') return p.treatmentStarted;
            return true;
        });
    }
    
    const container = document.getElementById('searchResultsList');
    if (!container) return;
    
    if (results.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 40px; background: white; border-radius: 16px;">
                <i class="fas fa-clipboard-list" style="font-size: 48px; color: var(--gray); margin-bottom: 16px;"></i>
                <div style="font-size: 16px; color: var(--dark); font-weight: 600;">لا توجد حالات مطابقة للبحث</div>
            </div>
        `;
        return;
    }
    
    container.innerHTML = results.map(p => {
        // الحصول على معلومات الأسنان المتاحة
        const teethEntries = Object.entries(p.teeth || {});
        const hasTeeth = teethEntries.length > 0;
        
        // بناء عرض الأرقام والحالات
        let teethInfoHtml = '';
        if (hasTeeth) {
            const conditionColors = {
                restorative: 'var(--primary)',
                endodontic: 'var(--warning)',
                extraction: 'var(--danger)',
                missing: 'var(--gray)',
                crown: 'var(--secondary)',
                conservative: 'var(--accent)'
            };
            
            teethInfoHtml = `
                <div style="margin-top: 12px; padding: 12px; background: #f9fafb; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 8px; font-weight: 600;">
                        <i class="fas fa-tooth" style="margin-left: 4px;"></i>
                        الأسنان المتاحة (${teethEntries.length} سن):
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                        ${teethEntries.map(([toothNum, toothData]) => {
                            const color = conditionColors[toothData.condition] || 'var(--gray)';
                            const isPrimary = toothNum >= 51 && toothNum <= 86;
                            return `
                                <div style="display: flex; align-items: center; gap: 4px; padding: 6px 10px; background: white; border: 2px solid ${color}; border-radius: 8px; font-size: 12px;">
                                    <span style="font-weight: 700; color: ${color};">${toothNum}</span>
                                    <span style="color: var(--dark);">${toothData.label}</span>
                                    ${isPrimary ? '<span style="font-size: 9px; color: var(--warning);">(مؤقت)</span>' : ''}
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>
            `;
        } else {
            teethInfoHtml = `
                <div style="margin-top: 12px; padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 10px; font-size: 12px; color: var(--warning);">
                    <i class="fas fa-exclamation-triangle" style="margin-left: 4px;"></i>
                    لم يتم تحديد حالات أسنان لهذا المريض
                </div>
            `;
        }
        
        // تحديد حالة الحجز
        let statusBadge = '';
        let statusColor = '';
        if (p.treatmentStarted) {
            statusBadge = 'قيد المعالجة';
            statusColor = 'var(--warning)';
        } else if (p.tempBooked) {
            statusBadge = 'محجوز مؤقتاً';
            statusColor = 'var(--primary)';
        } else {
            statusBadge = 'متاح';
            statusColor = 'var(--secondary)';
        }
        
        return `
            <div class="patient-card" style="margin-bottom: 16px;">
                <div style="display: flex; gap: 14px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--${p.color}), var(--${p.color}-light, var(--${p.color}))); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 700;">
                        ${p.initial}
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <div style="font-size: 17px; font-weight: 700; color: var(--dark);">${p.name}</div>
                                <div style="font-size: 12px; color: var(--gray); margin-top: 4px;">
                                    <i class="fas fa-phone" style="margin-left: 4px;"></i>${p.phone || 'غير متوفر'} | 
                                    <i class="fas fa-${p.gender === 'male' ? 'mars' : 'venus'}" style="margin-left: 4px;"></i>${p.gender === 'male' ? 'ذكر' : 'أنثى'} |
                                    <i class="fas fa-birthday-cake" style="margin-left: 4px;"></i>${p.age} سنة
                                </div>
                            </div>
                            <span style="background: ${statusColor}20; color: ${statusColor}; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                ${statusBadge}
                            </span>
                        </div>
                        
                        ${teethInfoHtml}
                        
                        <div style="display: flex; gap: 8px; margin-top: 12px;">
                            <button onclick="copyCaseCode(${p.id})" style="flex: 1; background: var(--secondary); color: white; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-copy" style="margin-left: 4px;"></i>نسخ رمز الحالة
                            </button>
                            <button onclick="viewTeethChart(${p.id})" style="background: var(--primary); color: white; border: none; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="bookCase(${p.id})" style="background: var(--accent); color: white; border: none; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-calendar-check"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

function copyCaseCode(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (patient && navigator.clipboard) {
        navigator.clipboard.writeText(patient.record).then(() => {
            showToast('تم نسخ رمز الحالة: ' + patient.record, 'success');
        });
    }
}

function bookCase(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (!patient) return;
    
    if (patient.treatmentStarted) {
        showToast('هذه الحالة قيد المعالجة بالفعل', 'warning');
        return;
    }
    
    showToast('جاري فتح نموذج حجز الموعد...', 'info');
}

function viewTeethChart(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (!patient) return;
    
    const nameEl = document.getElementById('viewTeethPatientName');
    if (nameEl) nameEl.textContent = patient.name;
    
    const chartContainer = document.getElementById('viewTeethChart');
    if (!chartContainer) return;
    
    let html = '';
    
    html += '<div style="margin-bottom: 12px;"><div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
    [18,17,16,15,14,13,12,11].forEach(t => {
        const toothData = patient.teeth[t];
        const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn permanent';
        const isTreated = toothData && ['restorative', 'endodontic', 'crown', 'conservative'].includes(toothData.condition);
        html += `<button type="button" class="${btnClass}" style="${isTreated ? 'opacity: 0.4; filter: grayscale(100%);' : ''}" disabled>${t}</button>`;
    });
    html += '<div style="width: 12px;"></div>';
    [21,22,23,24,25,26,27,28].forEach(t => {
        const toothData = patient.teeth[t];
        const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn permanent';
        const isTreated = toothData && ['restorative', 'endodontic', 'crown', 'conservative'].includes(toothData.condition);
        html += `<button type="button" class="${btnClass}" style="${isTreated ? 'opacity: 0.4; filter: grayscale(100%);' : ''}" disabled>${t}</button>`;
    });
    html += '</div></div>';
    
    html += '<div style="margin-bottom: 16px;"><div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
    [48,47,46,45,44,43,42,41].forEach(t => {
        const toothData = patient.teeth[t];
        const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn permanent';
        const isTreated = toothData && ['restorative', 'endodontic', 'crown', 'conservative'].includes(toothData.condition);
        html += `<button type="button" class="${btnClass}" style="${isTreated ? 'opacity: 0.4; filter: grayscale(100%);' : ''}" disabled>${t}</button>`;
    });
    html += '<div style="width: 12px;"></div>';
    [31,32,33,34,35,36,37,38].forEach(t => {
        const toothData = patient.teeth[t];
        const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn permanent';
        const isTreated = toothData && ['restorative', 'endodontic', 'crown', 'conservative'].includes(toothData.condition);
        html += `<button type="button" class="${btnClass}" style="${isTreated ? 'opacity: 0.4; filter: grayscale(100%);' : ''}" disabled>${t}</button>`;
    });
    html += '</div></div>';
    
    if (patient.ageType === 'child') {
        html += '<div style="margin-top: 16px; padding-top: 16px; border-top: 2px dashed #e5e7eb;">';
        html += '<div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap; margin-bottom: 8px;">';
        [55,54,53,52,51].forEach(t => {
            const toothData = patient.teeth[t];
            const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn primary';
            const isTreated = toothData && ['restorative', 'endodontic', 'crown', 'conservative'].includes(toothData.condition);
            html += `<button type="button" class="${btnClass}" style="${isTreated ? 'opacity: 0.4; filter: grayscale(100%);' : ''}" disabled>${t}</button>`;
        });
        html += '<div style="width: 12px;"></div>';
        [61,62,63,64,65].forEach(t => {
            const toothData = patient.teeth[t];
            const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn primary';
            const isTreated = toothData && ['restorative', 'endodontic', 'crown', 'conservative'].includes(toothData.condition);
            html += `<button type="button" class="${btnClass}" style="${isTreated ? 'opacity: 0.4; filter: grayscale(100%);' : ''}" disabled>${t}</button>`;
        });
        html += '</div>';
        
        html += '<div style="display: flex; justify-content: center; gap: 3px; flex-wrap: wrap;">';
        [85,84,83,82,81].forEach(t => {
            const toothData = patient.teeth[t];
            const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn primary';
            const isTreated = toothData && ['restorative', 'endodontic', 'crown', 'conservative'].includes(toothData.condition);
            html += `<button type="button" class="${btnClass}" style="${isTreated ? 'opacity: 0.4; filter: grayscale(100%);' : ''}" disabled>${t}</button>`;
        });
        html += '<div style="width: 12px;"></div>';
        [71,72,73,74,75].forEach(t => {
            const toothData = patient.teeth[t];
            const btnClass = toothData ? `tooth-btn ${toothData.condition}` : 'tooth-btn primary';
            const isTreated = toothData && ['restorative', 'endodontic', 'crown', 'conservative'].includes(toothData.condition);
            html += `<button type="button" class="${btnClass}" style="${isTreated ? 'opacity: 0.4; filter: grayscale(100%);' : ''}" disabled>${t}</button>`;
        });
        html += '</div></div>';
    }
    
    chartContainer.innerHTML = html;
    
    const modal = document.getElementById('viewTeethModal');
    if (modal) modal.style.display = 'flex';
}

function closeViewTeethModal() {
    const modal = document.getElementById('viewTeethModal');
    if (modal) modal.style.display = 'none';
}

// ==========================================
// تحويل المرضى - محسن
// ==========================================
function searchPatientForTransfer() {
    const searchTerm = document.getElementById('transferPatientSearch')?.value.trim();
    
    if (!searchTerm) {
        showToast('يرجى إدخال اسم المريض', 'warning');
        return;
    }
    
    // البحث في المرضى النشطين الذين لم يبدأ علاجهم بعد
    const results = patientsData.filter(p => 
        p.name.includes(searchTerm) && 
        p.status === 'active' && 
        !p.treatmentStarted
    );
    
    const container = document.getElementById('transferSearchResults');
    if (!container) return;
    
    if (results.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 20px; background: rgba(239, 68, 68, 0.05); border-radius: 12px; color: var(--danger);">
                <i class="fas fa-exclamation-circle" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                لا توجد نتائج أو المرضى بدأوا العلاج بالفعل
            </div>
        `;
        return;
    }
    
    container.innerHTML = results.map(p => {
        // عرض معلومات الأسنان إن وجدت
        const teethCount = Object.keys(p.teeth || {}).length;
        const teethInfo = teethCount > 0 ? `<span style="color: var(--primary);"><i class="fas fa-tooth" style="margin-left: 4px;"></i>${teethCount} حالة سن</span>` : '<span style="color: var(--gray);">لا توجد حالات أسنان</span>';
        
        return `
            <div class="patient-card" onclick="selectPatientForTransfer(${p.id})" style="cursor: pointer; border: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='transparent'">
                <div style="display: flex; gap: 14px;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--${p.color}), var(--${p.color}-light, var(--${p.color}))); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700;">
                        ${p.initial}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${p.name}</div>
                        <div style="font-size: 11px; color: var(--gray); margin-top: 4px;">
                            <i class="fas fa-hashtag" style="margin-left: 4px;"></i>${p.record} | 
                            ${teethInfo}
                        </div>
                        <div style="font-size: 11px; color: var(--primary); margin-top: 2px;">
                            <i class="fas fa-user-graduate" style="margin-left: 4px;"></i>الطالب الحالي: ${p.addedByName || p.addedBy}
                        </div>
                        <div style="margin-top: 6px; padding: 4px 8px; background: rgba(16, 185, 129, 0.1); border-radius: 6px; font-size: 10px; color: var(--secondary); display: inline-block;">
                            <i class="fas fa-check-circle" style="margin-left: 4px;"></i>متاح للتحويل (لم يبدأ العلاج)
                        </div>
                    </div>
                    <i class="fas fa-chevron-left" style="color: var(--gray); align-self: center;"></i>
                </div>
            </div>
        `;
    }).join('');
}

function selectPatientForTransfer(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (!patient) return;
    
    if (patient.treatmentStarted) {
        showToast('لا يمكن تحويل المريض بعد بدء العلاج', 'danger');
        return;
    }
    
    currentTransferPatient = patient;
    
    const form = document.getElementById('transferForm');
    const searchResults = document.getElementById('transferSearchResults');
    const historySection = document.getElementById('transferHistorySection');
    const patientInfo = document.getElementById('transferPatientInfo');
    const currentStudent = document.getElementById('transferCurrentStudent');
    const oldStudentId = document.getElementById('oldStudentId');
    
    if (form) form.style.display = 'block';
    if (searchResults) searchResults.style.display = 'none';
    if (historySection) historySection.style.display = 'block';
    if (patientInfo) patientInfo.textContent = patient.name;
    if (currentStudent) currentStudent.innerHTML = `<i class="fas fa-user-graduate" style="margin-left: 4px;"></i>الطالب الحالي: ${patient.addedByName || patient.addedBy}`;
    if (oldStudentId) oldStudentId.value = patient.addedBy;
    
    renderTransferHistory(patient);
    showToast(`تم اختيار المريض: ${patient.name}`, 'success');
}

function renderTransferHistory(patient) {
    const container = document.getElementById('transferHistoryList');
    if (!container) return;
    
    if (!patient.transferHistory || patient.transferHistory.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 20px; color: var(--gray); font-size: 13px; background: white; border-radius: 12px;">لا يوجد سجل تحويلات سابقة</div>';
        return;
    }
    
    container.innerHTML = patient.transferHistory.map((transfer, index) => `
        <div style="background: white; padding: 16px; border-radius: 12px; margin-bottom: 12px; border: 1px solid #e5e7eb; ${transfer.isRolledBack ? 'opacity: 0.6;' : ''}">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; background: ${transfer.isRolledBack ? 'var(--gray)' : 'var(--primary)'}; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: var(--dark);">تحويل #${patient.transferHistory.length - index}</div>
                        <div style="font-size: 11px; color: var(--gray);">${new Date(transfer.date).toLocaleDateString('ar-SA')}</div>
                    </div>
                </div>
                ${transfer.isPermanent ? '<span style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 600;">دائم</span>' : ''}
            </div>
            
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; padding: 10px; background: #f9fafb; border-radius: 8px;">
                <div style="text-align: center; flex: 1;">
                    <div style="font-size: 10px; color: var(--gray); margin-bottom: 2px;">من</div>
                    <div style="font-weight: 700; color: var(--dark); font-size: 13px;">${transfer.oldStudentName || transfer.oldStudent}</div>
                </div>
                <i class="fas fa-arrow-left" style="color: var(--primary);"></i>
                <div style="text-align: center; flex: 1;">
                    <div style="font-size: 10px; color: var(--gray); margin-bottom: 2px;">إلى</div>
                    <div style="font-weight: 700; color: var(--secondary); font-size: 13px;">${transfer.newStudentName || transfer.newStudent}</div>
                </div>
            </div>
            
            <div style="font-size: 12px; margin-bottom: 8px; color: var(--dark);">
                <strong>السبب:</strong> ${transfer.reason}
            </div>
            
            <div style="font-size: 11px; color: var(--gray); display: flex; gap: 12px; align-items: center;">
                <span><i class="fas fa-user" style="margin-left: 4px;"></i>${transfer.performedByName || transfer.performedBy}</span>
                <span><i class="fas fa-clock" style="margin-left: 4px;"></i>${transfer.time}</span>
            </div>
            
            ${transfer.isRolledBack ? `
            <div style="margin-top: 10px; padding: 10px; background: rgba(245, 158, 11, 0.1); border-radius: 8px; font-size: 12px; color: var(--warning);">
                <i class="fas fa-undo" style="margin-left: 4px;"></i>
                تم التراجع بواسطة ${transfer.rollbackByName || transfer.rollbackBy} - السبب: ${transfer.rollbackReason}
            </div>
            ` : ''}
        </div>
    `).join('');
}

function executeTransfer() {
    const newStudentId = document.getElementById('newStudentId')?.value.trim();
    const transferType = document.getElementById('transferType')?.value;
    const reason = document.getElementById('transferReason')?.value.trim();
    
    if (!newStudentId) {
        showToast('يرجى إدخال الرقم الجامعي للطالب الجديد', 'warning');
        return;
    }
    
    if (!reason) {
        showToast('يرجى كتابة سبب التحويل', 'warning');
        return;
    }
    
    if (!currentTransferPatient) {
        showToast('خطأ: لا يوجد مريض محدد', 'danger');
        return;
    }
    
    if (currentTransferPatient.treatmentStarted) {
        showToast('لا يمكن التحويل بعد بدء العلاج', 'danger');
        return;
    }
    
    if (newStudentId === currentTransferPatient.addedBy) {
        showToast('الطالب الجديد هو نفس الطالب الحالي', 'warning');
        return;
    }
    
    const oldStudent = currentTransferPatient.addedBy;
    const oldStudentName = currentTransferPatient.addedByName;
    
    // تحديث بيانات المريض
    currentTransferPatient.addedBy = newStudentId;
    currentTransferPatient.addedByName = 'طالب جديد (' + newStudentId + ')';
    currentTransferPatient.transferredAt = new Date().toISOString();
    currentTransferPatient.transferredBy = 'current_user';
    
    // إنشاء سجل التحويل
    const transferRecord = {
        id: Date.now(),
        type: transferType || 'student_change',
        oldStudent: oldStudent,
        oldStudentName: oldStudentName,
        newStudent: newStudentId,
        newStudentName: 'طالب جديد (' + newStudentId + ')',
        reason: reason,
        date: new Date().toISOString(),
        time: new Date().toLocaleTimeString('ar-SA'),
        performedBy: 'current_user',
        performedByName: 'الطالب الحالي',
        isRolledBack: false,
        rollbackReason: null,
        rollbackBy: null,
        rollbackDate: null,
        isPermanent: true
    };
    
    if (!currentTransferPatient.transferHistory) {
        currentTransferPatient.transferHistory = [];
    }
    currentTransferPatient.transferHistory.push(transferRecord);
    
    // إضافة للسجل العام
    addToAuditLog({
        operationType: 'transfer',
        patientId: currentTransferPatient.id,
        patientName: currentTransferPatient.name,
        employeeId: 'current_user',
        employeeName: 'الطالب الحالي',
        details: `تحويل دائم لمريض - ${transferType === 'urgent' ? 'إلحاحي' : transferType === 'supervisor_request' ? 'طلب مشرف' : 'تغيير طالب'}`,
        changes: [
            { field: 'الطالب المسؤول', oldValue: oldStudent + ' (' + oldStudentName + ')', newValue: newStudentId }
        ],
        oldValue: `الطالب القديم: ${oldStudent}`,
        newValue: `الطالب الجديد: ${newStudentId}`,
        reason: reason
    });
    
    showToast('تم تنفيذ التحويل الدائم بنجاح', 'success');
    renderTransferHistory(currentTransferPatient);
    
    // إعادة تعيين النموذج بعد فترة قصيرة
    setTimeout(() => {
        cancelTransfer();
    }, 2000);
}

function cancelTransfer() {
    const form = document.getElementById('transferForm');
    const historySection = document.getElementById('transferHistorySection');
    const searchResults = document.getElementById('transferSearchResults');
    const searchInput = document.getElementById('transferPatientSearch');
    const newStudentId = document.getElementById('newStudentId');
    const transferReason = document.getElementById('transferReason');
    const transferType = document.getElementById('transferType');
    
    if (form) form.style.display = 'none';
    if (historySection) historySection.style.display = 'none';
    if (searchResults) searchResults.style.display = 'block';
    if (searchResults) searchResults.innerHTML = '';
    if (searchInput) searchInput.value = '';
    if (newStudentId) newStudentId.value = '';
    if (transferReason) transferReason.value = '';
    if (transferType) transferType.value = 'student_change';
    
    currentTransferPatient = null;
}

// ==========================================
// سجل العمليات (Audit Log) - محسن
// ==========================================
function addToAuditLog(entry) {
    const newEntry = {
        id: Date.now(),
        ...entry,
        date: new Date().toISOString()
    };
    auditLogData.unshift(newEntry);
    loadAuditLog();
}

function loadAuditLog() {
    const operationType = document.getElementById('auditOperationType')?.value;
    const employeeFilter = document.getElementById('auditEmployeeFilter')?.value.trim();
    const dateFrom = document.getElementById('auditDateFrom')?.value;
    const dateTo = document.getElementById('auditDateTo')?.value;
    
    let results = [...auditLogData];
    
    if (operationType) {
        results = results.filter(r => r.operationType === operationType);
    }
    
    if (employeeFilter) {
        results = results.filter(r => 
            r.employeeId.includes(employeeFilter) || 
            r.employeeName.includes(employeeFilter)
        );
    }
    
    if (dateFrom) {
        results = results.filter(r => new Date(r.date) >= new Date(dateFrom));
    }
    
    if (dateTo) {
        results = results.filter(r => new Date(r.date) <= new Date(dateTo));
    }
    
    const container = document.getElementById('auditLogList');
    if (!container) return;
    
    if (results.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 40px; background: white; border-radius: 16px;">
                <i class="fas fa-clipboard-list" style="font-size: 48px; color: var(--gray); margin-bottom: 16px;"></i>
                <div style="font-size: 16px; color: var(--dark); font-weight: 600;">لا توجد عمليات مسجلة</div>
            </div>
        `;
        return;
    }
    
    const typeLabels = {
        add: 'إضافة',
        edit: 'تعديل',
        transfer: 'تحويل',
        access_change: 'تغيير صلاحيات',
        rollback: 'تراجع'
    };
    
    const typeIcons = {
        add: 'fa-plus-circle',
        edit: 'fa-edit',
        transfer: 'fa-exchange-alt',
        access_change: 'fa-user-shield',
        rollback: 'fa-undo'
    };
    
    container.innerHTML = results.map(item => `
        <div style="background: white; padding: 20px; border-radius: 16px; margin-bottom: 16px; border: 1px solid #e5e7eb; ${item.isRolledBack ? 'opacity: 0.7;' : ''}">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                <div>
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: ${item.operationType === 'add' ? 'rgba(16, 185, 129, 0.1)' : item.operationType === 'edit' ? 'rgba(245, 158, 11, 0.1)' : item.operationType === 'transfer' ? 'rgba(79, 70, 229, 0.1)' : 'rgba(239, 68, 68, 0.1)'}; color: ${item.operationType === 'add' ? 'var(--secondary)' : item.operationType === 'edit' ? 'var(--warning)' : item.operationType === 'transfer' ? 'var(--primary)' : 'var(--danger)'};">
                        <i class="fas ${typeIcons[item.operationType] || 'fa-circle'}"></i>
                        ${typeLabels[item.operationType] || item.operationType}
                    </span>
                    <div style="margin-top: 8px; font-size: 16px; font-weight: 700; color: var(--dark);">
                        ${item.patientName}
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), #6366f1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                        ${item.employeeName.charAt(0)}
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 600;">${item.employeeName}</div>
                        <div style="font-size: 11px; color: var(--gray);">${item.employeeId}</div>
                    </div>
                </div>
            </div>
            
            <div style="background: #f9fafb; padding: 16px; border-radius: 12px; margin-bottom: 12px;">
                <div style="margin-bottom: 8px; font-size: 14px; color: var(--dark);">
                    <strong>التفاصيل:</strong> ${item.details}
                </div>
                
                ${item.changes && item.changes.length > 0 ? `
                <div style="margin-top: 12px; border-top: 1px dashed #e5e7eb; padding-top: 12px;">
                    <div style="font-size: 12px; font-weight: 600; color: var(--primary); margin-bottom: 8px;">
                        <i class="fas fa-list-ul" style="margin-left: 4px;"></i>
                        التغييرات المفصلة:
                    </div>
                    ${item.changes.map(change => `
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; padding: 8px; background: white; border-radius: 8px;">
                            <span style="font-size: 11px; font-weight: 600; color: var(--dark); min-width: 100px;">${change.field}:</span>
                            <span style="font-size: 11px; color: var(--danger); text-decoration: line-through; flex: 1;">${change.oldValue}</span>
                            <i class="fas fa-arrow-left" style="color: var(--primary); font-size: 10px;"></i>
                            <span style="font-size: 11px; color: var(--secondary); flex: 1; font-weight: 600;">${change.newValue}</span>
                        </div>
                    `).join('')}
                </div>
                ` : ''}
                
                ${!item.changes && item.oldValue ? `
                <div style="margin-top: 8px;">
                    <div style="color: var(--danger); margin-bottom: 6px; font-size: 13px;">
                        <i class="fas fa-arrow-left" style="margin-left: 4px; transform: rotate(180deg); display: inline-block;"></i>
                        <strong>القيمة القديمة:</strong> ${item.oldValue}
                    </div>
                    <div style="color: var(--secondary); font-size: 13px;">
                        <i class="fas fa-arrow-left" style="margin-left: 4px;"></i>
                        <strong>القيمة الجديدة:</strong> ${item.newValue}
                    </div>
                </div>
                ` : ''}
                
                ${item.reason ? `
                <div style="margin-top: 12px; padding: 10px; background: rgba(245, 158, 11, 0.1); border-radius: 8px; font-size: 12px; color: var(--warning);">
                    <i class="fas fa-comment" style="margin-left: 4px;"></i>
                    <strong>السبب:</strong> ${item.reason}
                </div>
                ` : ''}
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: var(--gray);">
                <span>
                    <i class="fas fa-calendar" style="margin-left: 4px;"></i>
                    ${new Date(item.date).toLocaleDateString('ar-SA')}
                    <i class="fas fa-clock" style="margin-left: 8px; margin-right: 4px;"></i>
                    ${new Date(item.date).toLocaleTimeString('ar-SA')}
                </span>
                ${!item.isRolledBack && item.operationType !== 'add' ? `
                <button onclick="showRollbackModal(${item.id})" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: none; padding: 6px 12px; border-radius: 6px; font-size: 11px; cursor: pointer;">
                    <i class="fas fa-undo" style="margin-left: 4px;"></i>تراجع
                </button>
                ` : ''}
            </div>
            
            ${item.isRolledBack ? `
            <div style="margin-top: 12px; padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 8px; font-size: 12px; color: var(--warning);">
                <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                تم التراجع بواسطة ${item.rollbackByName || item.rollbackBy} - السبب: ${item.rollbackReason}
            </div>
            ` : ''}
        </div>
    `).join('');
}

// ==========================================
// نظام التراجع (Rollback)
// ==========================================
function showRollbackModal(logId) {
    currentRollbackId = logId;
    const modal = document.getElementById('rollbackModal');
    const reasonInput = document.getElementById('rollbackReason');
    
    if (modal) modal.style.display = 'flex';
    if (reasonInput) {
        reasonInput.value = '';
        setTimeout(() => reasonInput.focus(), 100);
    }
}

function closeRollbackModal() {
    const modal = document.getElementById('rollbackModal');
    if (modal) modal.style.display = 'none';
    currentRollbackId = null;
}

function executeRollback() {
    const reasonInput = document.getElementById('rollbackReason');
    const reason = reasonInput ? reasonInput.value.trim() : '';
    
    if (!reason) {
        showToast('يرجى كتابة سبب التراجع', 'warning');
        return;
    }
    
    if (!currentRollbackId) return;
    
    const logEntry = auditLogData.find(l => l.id === currentRollbackId);
    if (!logEntry) return;
    
    logEntry.isRolledBack = true;
    logEntry.rollbackReason = reason;
    logEntry.rollbackBy = 'current_user';
    logEntry.rollbackByName = 'الطالب الحالي';
    logEntry.rollbackDate = new Date().toISOString();
    
    addToAuditLog({
        operationType: 'rollback',
        patientId: logEntry.patientId,
        patientName: logEntry.patientName,
        employeeId: 'current_user',
        employeeName: 'الطالب الحالي',
        details: `تراجع عن عملية ${logEntry.operationType}`,
        changes: [
            { field: 'العملية الأصلية', oldValue: logEntry.details, newValue: 'تم التراجع' },
            { field: 'سبب التراجع', oldValue: '-', newValue: reason }
        ],
        oldValue: logEntry.newValue,
        newValue: logEntry.oldValue,
        reason: reason,
        rolledBackLogId: currentRollbackId
    });
    
    if (logEntry.operationType === 'edit' && logEntry.changes) {
        const patient = patientsData.find(p => p.id === logEntry.patientId);
        if (patient) {
            logEntry.changes.forEach(change => {
                switch(change.field) {
                    case 'الاسم':
                        patient.name = change.oldValue;
                        break;
                    case 'سنة الميلاد':
                        patient.birthYear = parseInt(change.oldValue);
                        patient.age = new Date().getFullYear() - patient.birthYear;
                        break;
                    case 'رقم الهاتف':
                        patient.phone = change.oldValue === 'غير محدد' ? '' : change.oldValue;
                        break;
                    case 'المحافظة':
                        patient.governorate = change.oldValue === 'غير محدد' ? '' : change.oldValue;
                        break;
                    case 'العنوان':
                        patient.address = change.oldValue === 'غير محدد' ? '' : change.oldValue;
                        break;
                    case 'الجنس':
                        patient.gender = change.oldValue === 'ذكر' ? 'male' : 'female';
                        break;
                    case 'الملاحظات':
                        patient.notes = change.oldValue === 'لا يوجد' ? '' : change.oldValue;
                        break;
                }
            });
            
            if (!patient.editHistory) patient.editHistory = [];
            patient.editHistory.unshift({
                id: Date.now(),
                field: 'تراجع عن تعديل',
                oldValue: 'بعد التعديل',
                newValue: 'قبل التعديل',
                reason: `تراجع: ${reason}`,
                date: new Date().toISOString(),
                time: new Date().toLocaleTimeString('ar-SA'),
                editedBy: 'current_user',
                editedByName: 'الطالب الحالي'
            });
        }
    }
    
    closeRollbackModal();
    showToast('تم التراجع عن العملية بنجاح', 'success');
    loadAuditLog();
}

// ==========================================
// Toast Notifications
// ==========================================
function showToast(message, type = 'info') {
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) {
        existingToast.remove();
    }
    
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: ${type === 'success' ? 'var(--secondary)' : type === 'warning' ? 'var(--warning)' : type === 'danger' ? 'var(--danger)' : 'var(--primary)'};
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: clamp(13px, 3.8vw, 15px);
        font-weight: 600;
        z-index: 10000;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideDown 0.3s ease;
        max-width: 90%;
        text-align: center;
    `;
    
    const icon = type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : type === 'danger' ? 'fa-times-circle' : 'fa-info-circle';
    toast.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ==========================================
// تبديل التبويبات
// ==========================================
function switchTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });
    
    document.querySelectorAll('.tab-item').forEach(tab => {
        tab.classList.remove('active');
    });
    
    const selectedContent = document.getElementById(tabName + 'Content');
    const clickedTab = event?.currentTarget;
    
    if (selectedContent) selectedContent.style.display = 'block';
    if (clickedTab) clickedTab.classList.add('active');
    
    if (tabName === 'auditlog') {
        loadAuditLog();
    }
}

// ==========================================
// CSS Animations
// ==========================================
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from { transform: translate(-50%, -100%); opacity: 0; }
        to { transform: translate(-50%, 0); opacity: 1; }
    }
    @keyframes slideUp {
        from { transform: translate(-50%, 0); opacity: 1; }
        to { transform: translate(-50%, -100%); opacity: 0; }
    }
`;
document.head.appendChild(style);




// ==========================================
// حالات مريض معين - البحث والعرض
// ==========================================
let currentPatientCases = null;

function searchPatientCases() {
    const patientName = document.getElementById('patientCasesSearchName')?.value.trim();
    const resultsContainer = document.getElementById('patientCasesResults');
    const tableSection = document.getElementById('patientTeethTableSection');
    
    if (!patientName || patientName.length < 3) {
        showToast('يرجى إدخال الاسم الثلاثي (3 أحرف على الأقل)', 'warning');
        return;
    }
    
    // البحث في المرضى
    const results = patientsData.filter(p => 
        p.name.toLowerCase().includes(patientName.toLowerCase())
    );
    
    if (results.length === 0) {
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div style="text-align: center; padding: 30px; background: white; border-radius: 12px; color: var(--gray);">
                    <i class="fas fa-search" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
                    لا يوجد مريض بهذا الاسم
                </div>
            `;
        }
        if (tableSection) tableSection.style.display = 'none';
        return;
    }
    
    // إذا وجد مريض واحد، اعرضه مباشرة
    if (results.length === 1) {
        displayPatientTeethTable(results[0]);
        if (resultsContainer) resultsContainer.innerHTML = '';
        return;
    }
    
    // إذا وجد عدة مرضى، اعرض قائمة الاختيار
    if (resultsContainer) {
        resultsContainer.innerHTML = `
            <div style="font-size: clamp(13px, 3.8vw, 15px); font-weight: 700; color: var(--dark); margin-bottom: 12px;">
                <i class="fas fa-list" style="margin-left: 6px; color: var(--primary);"></i>
                اختر المريض:
            </div>
            ${results.map(p => `
                <div class="patient-card" onclick="displayPatientTeethTableById(${p.id})" style="cursor: pointer; border: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='transparent'">
                    <div style="display: flex; gap: 14px; align-items: center;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--${p.color}), var(--${p.color}-light, var(--${p.color}))); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700;">
                            ${p.initial}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${p.name}</div>
                            <div style="font-size: 12px; color: var(--gray); margin-top: 4px;">
                                <i class="fas fa-hashtag" style="margin-left: 4px;"></i>${p.record} | 
                                <i class="fas fa-birthday-cake" style="margin-left: 4px;"></i>${p.age} سنة |
                                <i class="fas fa-tooth" style="margin-left: 4px;"></i>${Object.keys(p.teeth || {}).length} حالة سن
                            </div>
                        </div>
                        <i class="fas fa-chevron-left" style="color: var(--gray);"></i>
                    </div>
                </div>
            `).join('')}
        `;
    }
}

function displayPatientTeethTableById(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (patient) {
        displayPatientTeethTable(patient);
        document.getElementById('patientCasesResults').innerHTML = '';
    }
}

function displayPatientTeethTable(patient) {
    currentPatientCases = patient;
    
    const tableSection = document.getElementById('patientTeethTableSection');
    const nameEl = document.getElementById('patientCasesName');
    const recordEl = document.getElementById('patientCasesRecord');
    const totalEl = document.getElementById('totalTeethCount');
    const availableEl = document.getElementById('availableTeethCount');
    const tbody = document.getElementById('patientTeethTableBody');
    
    if (nameEl) nameEl.textContent = patient.name;
    if (recordEl) recordEl.textContent = patient.record;
    
    // الحصول على أسنان المريض
    const teethEntries = Object.entries(patient.teeth || {});
    const totalCount = teethEntries.length;
    
    // تصفية الأسنان المتاحة فقط (غير محجوزة وغير منجزة)
    const availableTeeth = teethEntries.filter(([toothNum, toothData]) => {
        const isBooked = toothData.isBooked || false;
        const isCompleted = toothData.isCompleted || false;
        const isTempBooked = toothData.isTempBooked || false;
        
        return !isBooked && !isCompleted && !isTempBooked;
    });
    
    const availableCount = availableTeeth.length;
    
    if (totalEl) totalEl.textContent = totalCount;
    if (availableEl) availableEl.textContent = availableCount;
    
    // بناء الجدول
    const conditionLabels = {
        restorative: { label: 'ترميمية', color: 'var(--primary)', bg: 'rgba(79, 70, 229, 0.1)' },
        endodontic: { label: 'لبية (عصب)', color: 'var(--warning)', bg: 'rgba(245, 158, 11, 0.1)' },
        extraction: { label: 'قلع', color: 'var(--danger)', bg: 'rgba(239, 68, 68, 0.1)' },
        missing: { label: 'مفقود', color: 'var(--gray)', bg: 'rgba(107, 114, 128, 0.1)' },
        crown: { label: 'بتر لو (تاج)', color: 'var(--secondary)', bg: 'rgba(16, 185, 129, 0.1)' },
        conservative: { label: 'ترميم محافظ', color: 'var(--accent)', bg: 'rgba(236, 72, 153, 0.1)' }
    };
    
    if (tbody) {
        if (availableTeeth.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" style="padding: 30px; text-align: center; color: var(--gray);">
                        <i class="fas fa-check-circle" style="font-size: 32px; margin-bottom: 12px; display: block; color: var(--secondary);"></i>
                        لا توجد حالات متاحة لهذا المريض<br>
                        <span style="font-size: 12px;">جميع الأسنان محجوزة أو منجزة</span>
                    </td>
                </tr>
            `;
        } else {
            tbody.innerHTML = availableTeeth.map(([toothNum, toothData]) => {
                const condition = conditionLabels[toothData.condition] || { label: 'غير محدد', color: 'var(--gray)', bg: 'rgba(107, 114, 128, 0.1)' };
                const isPrimary = parseInt(toothNum) >= 51 && parseInt(toothNum) <= 86;
                
                // إنشاء رمز الحالة الفريد للسن: رقم_الملف-رقم_السن
                const caseCode = `${patient.record}-T${toothNum}`;
                
                return `
                    <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                        <td style="padding: 14px; text-align: center; font-weight: 700; color: var(--dark);">
                            <div style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: ${condition.color}; color: white; border-radius: 8px; font-size: 14px;">
                                ${toothNum}
                            </div>
                            ${isPrimary ? '<div style="font-size: 10px; color: var(--warning); margin-top: 4px;">(مؤقت)</div>' : ''}
                        </td>
                        <td style="padding: 14px; text-align: center;">
                            <span style="display: inline-block; padding: 6px 12px; background: ${condition.bg}; color: ${condition.color}; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                ${condition.label}
                            </span>
                        </td>
                        <td style="padding: 14px; text-align: center; color: var(--dark); font-size: 13px;">
                            ${toothData.label || '-'}
                        </td>
                        <td style="padding: 14px; text-align: center;">
                            <button onclick="copyToothCaseCode('${caseCode}', ${toothNum})" style="background: linear-gradient(135deg, var(--secondary), #34d399); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-copy"></i>
                                نسخ الرمز
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }
    }
    
    if (tableSection) tableSection.style.display = 'block';
    
    showToast(`تم عرض ${availableCount} حالة متاحة من أصل ${totalCount}`, 'success');
}

function copyToothCaseCode(caseCode, toothNumber) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(caseCode).then(() => {
            showToast(`تم نسخ رمز الحالة للسن ${toothNumber}`, 'success');
        }).catch(() => {
            fallbackCopyText(caseCode, toothNumber);
        });
    } else {
        fallbackCopyText(caseCode, toothNumber);
    }
}

function fallbackCopyText(text, toothNumber) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    showToast(`تم نسخ رمز الحالة للسن ${toothNumber}`, 'success');
}



</script>
@endsection




