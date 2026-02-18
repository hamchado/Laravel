@extends('layouts.app')

@section('title', 'سجل المرضى')
@section('page_title', 'سجل المرضى')

@section('tabs')
<div class="tab-item active" onclick="switchTab('mypatients')">
    <i class="fas fa-user-shield" style="margin-left: 4px;"></i>
    مرضايي الخاصين
</div>
<div class="tab-item" onclick="switchTab('publicpatients')">
    <i class="fas fa-users" style="margin-left: 4px;"></i>
    مرضايي العامين
</div>
<div class="tab-item" onclick="switchTab('allpatients')">
    <i class="fas fa-clipboard-list" style="margin-left: 4px;"></i>
    جميع المرضى
</div>
<div class="tab-item" onclick="switchTab('newpatient')">
    <i class="fas fa-user-plus" style="margin-left: 4px;"></i>
    إضافة مريض
</div>
@endsection

@section('tab_content')
<!-- تبويب مرضايي الخاصين -->
<div class="tab-content" id="mypatientsContent" style="display: block;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-user-shield"></i>
        <span>مرضايي الخاصين</span>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="horizontal-scroll-container">
        <div class="horizontal-cards">
            <div class="horizontal-card" style="background: linear-gradient(135deg, var(--primary), #6366f1); color: white; min-width: 140px;">
                <div class="card-icon" style="background: rgba(255,255,255,0.2); color: white;">
                    <i class="fas fa-user-injured"></i>
                </div>
                <h3 style="color: white; font-size: 28px;">12</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">إجمالي المرضى</p>
            </div>

            <div class="horizontal-card" style="background: linear-gradient(135deg, var(--secondary), #34d399); color: white; min-width: 140px;">
                <div class="card-icon" style="background: rgba(255,255,255,0.2); color: white;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 style="color: white; font-size: 28px;">8</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">حالات مكتملة</p>
            </div>

            <div class="horizontal-card" style="background: linear-gradient(135deg, var(--warning), #fbbf24); color: white; min-width: 140px;">
                <div class="card-icon" style="background: rgba(255,255,255,0.2); color: white;">
                    <i class="fas fa-spinner"></i>
                </div>
                <h3 style="color: white; font-size: 28px;">3</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">قيد المتابعة</p>
            </div>

            <div class="horizontal-card" style="background: linear-gradient(135deg, var(--accent), #f472b6); color: white; min-width: 140px;">
                <div class="card-icon" style="background: rgba(255,255,255,0.2); color: white;">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h3 style="color: white; font-size: 28px;">1</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">جديد اليوم</p>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <div class="scroll-progress"></div>
    </div>
    <div class="scroll-hint">
        <i class="fas fa-hand-point-left"></i>
        <span>اسحب لمشاهدة المزيد</span>
    </div>

    <!-- شريط البحث -->
    <div style="margin: 20px 0;">
        <div style="position: relative;">
            <input type="text" id="privatePatientSearch" class="text-input"
                   placeholder="ابحث عن مريض بالاسم أو رقم السجل..."
                   style="padding-right: 40px; border-radius: 12px;"
                   onkeyup="searchPatients('private', this.value)">
            <i class="fas fa-search" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
        </div>
    </div>

    <!-- قائمة المرضى الخاصين -->
    <div class="patients-list" id="privatePatientsList">
        <!-- سيتم ملؤها بـ JavaScript -->
    </div>
</div>

<!-- تبويب مرضايي العامين -->
<div class="tab-content" id="publicpatientsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-users"></i>
        <span>مرضايي العامين</span>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="horizontal-scroll-container">
        <div class="horizontal-cards">
            <div class="horizontal-card" style="background: linear-gradient(135deg, var(--secondary), #34d399); color: white; min-width: 140px;">
                <div class="card-icon" style="background: rgba(255,255,255,0.2); color: white;">
                    <i class="fas fa-users"></i>
                </div>
                <h3 style="color: white; font-size: 28px;">28</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">إجمالي المرضى</p>
            </div>

            <div class="horizontal-card" style="background: linear-gradient(135deg, var(--primary), #6366f1); color: white; min-width: 140px;">
                <div class="card-icon" style="background: rgba(255,255,255,0.2); color: white;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 style="color: white; font-size: 28px;">20</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">حالات مكتملة</p>
            </div>

            <div class="horizontal-card" style="background: linear-gradient(135deg, var(--warning), #fbbf24); color: white; min-width: 140px;">
                <div class="card-icon" style="background: rgba(255,255,255,0.2); color: white;">
                    <i class="fas fa-spinner"></i>
                </div>
                <h3 style="color: white; font-size: 28px;">5</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">قيد المتابعة</p>
            </div>

            <div class="horizontal-card" style="background: linear-gradient(135deg, var(--danger), #f87171); color: white; min-width: 140px;">
                <div class="card-icon" style="background: rgba(255,255,255,0.2); color: white;">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 style="color: white; font-size: 28px;">3</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">بانتظار المراجعة</p>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <div class="scroll-progress"></div>
    </div>

    <!-- شريط البحث -->
    <div style="margin: 20px 0;">
        <div style="position: relative;">
            <input type="text" id="publicPatientSearch" class="text-input"
                   placeholder="ابحث عن مريض بالاسم أو رقم السجل..."
                   style="padding-right: 40px; border-radius: 12px;"
                   onkeyup="searchPatients('public', this.value)">
            <i class="fas fa-search" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
        </div>
    </div>

    <!-- قائمة المرضى العامين -->
    <div class="patients-list" id="publicPatientsList">
        <!-- سيتم ملؤها بـ JavaScript -->
    </div>
</div>

<!-- تبويب جميع المرضى -->
<div class="tab-content" id="allpatientsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-clipboard-list"></i>
        <span>جميع المرضى</span>
    </div>

    <!-- فلتر -->
    <div style="display: flex; gap: 10px; margin: 16px 0; flex-wrap: wrap;">
        <button class="filter-btn active" onclick="filterAllPatients('all')" style="padding: 8px 16px; border-radius: 20px; border: none; background: var(--primary); color: white; font-size: 13px; cursor: pointer;">
            الكل (40)
        </button>
        <button class="filter-btn" onclick="filterAllPatients('private')" style="padding: 8px 16px; border-radius: 20px; border: 2px solid #e5e7eb; background: white; color: var(--dark); font-size: 13px; cursor: pointer;">
            خاص (12)
        </button>
        <button class="filter-btn" onclick="filterAllPatients('public')" style="padding: 8px 16px; border-radius: 20px; border: 2px solid #e5e7eb; background: white; color: var(--dark); font-size: 13px; cursor: pointer;">
            عام (28)
        </button>
    </div>

    <!-- شريط البحث -->
    <div style="margin: 16px 0;">
        <div style="position: relative;">
            <input type="text" id="allPatientSearch" class="text-input"
                   placeholder="ابحث عن مريض..."
                   style="padding-right: 40px; border-radius: 12px;"
                   onkeyup="searchPatients('all', this.value)">
            <i class="fas fa-search" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
        </div>
    </div>

    <!-- قائمة جميع المرضى -->
    <div class="patients-list" id="allPatientsList">
        <!-- سيتم ملؤها بـ JavaScript -->
    </div>
</div>

<!-- تبويب إضافة مريض -->
<div class="tab-content" id="newpatientContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-user-plus"></i>
        <span>إضافة مريض جديد</span>
    </div>

    <div class="input-container" style="margin-top: 16px;">
        <!-- المعلومات الأساسية -->
        <div style="background: rgba(79, 70, 229, 0.05); padding: 12px; border-radius: 10px; margin-bottom: 16px;">
            <div style="font-size: 14px; font-weight: 700; color: var(--primary); margin-bottom: 12px;">
                <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
                المعلومات الأساسية
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-user" style="margin-left: 4px; color: var(--primary);"></i>
                    اسم المريض
                </label>
                <input type="text" id="patientName" class="text-input" placeholder="أدخل الاسم الكامل">
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-calendar-alt" style="margin-left: 4px; color: var(--accent);"></i>
                    سنة الميلاد
                </label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="number" id="patientBirthYear" class="text-input" placeholder="مثال: 1990" min="1900" max="2025" style="font-size: 13px; flex: 1;" onchange="calculateAge()">
                    <div id="calculatedAge" style="background: linear-gradient(135deg, var(--primary), #6366f1); color: white; padding: 10px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; min-width: 80px; text-align: center; display: none;">
                        <span id="ageValue">--</span> سنة
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-venus-mars" style="margin-left: 4px; color: var(--accent);"></i>
                    الجنس
                </label>
                <div style="display: flex; gap: 10px;">
                    <label class="gender-option selected" onclick="selectGender('male')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid var(--primary); border-radius: 8px; cursor: pointer; background: rgba(79, 70, 229, 0.05); font-size: 13px;">
                        <input type="radio" name="patientGender" value="male" checked style="display: none;">
                        <i class="fas fa-mars" style="color: var(--primary);"></i>
                        ذكر
                    </label>
                    <label class="gender-option" onclick="selectGender('female')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 13px;">
                        <input type="radio" name="patientGender" value="female" style="display: none;">
                        <i class="fas fa-venus" style="color: var(--accent);"></i>
                        أنثى
                    </label>
                </div>
            </div>

            <!-- رقم الموبايل -->
            <div class="form-group" style="margin-top: 12px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                    <i class="fas fa-phone" style="margin-left: 4px; color: var(--secondary);"></i>
                    رقم الموبايل
                </label>
                <div style="display: flex; direction: ltr;">
                    <span style="background: var(--gray-100); border: 1px solid #e5e7eb; border-left: none; padding: 10px 12px; border-radius: 8px 0 0 8px; font-size: 14px; font-weight: 600; color: var(--dark);">09</span>
                    <input type="tel" id="patientPhone" class="text-input" placeholder="12345678" maxlength="8" style="border-radius: 0 8px 8px 0; font-size: 14px; direction: ltr; text-align: left;">
                </div>
            </div>

            <!-- المحافظة ومكان السكن -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 12px;">
                <div class="form-group">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                        <i class="fas fa-map-marker-alt" style="margin-left: 4px; color: var(--danger);"></i>
                        المحافظة
                    </label>
                    <select id="patientGovernorate" class="text-input" style="font-size: 13px;">
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
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px;">
                        <i class="fas fa-home" style="margin-left: 4px; color: var(--warning);"></i>
                        مكان السكن
                    </label>
                    <input type="text" id="patientAddress" class="text-input" placeholder="الحي / المنطقة" style="font-size: 13px;">
                </div>
            </div>
        </div>

        <!-- الحالة الصحية -->
        <div style="background: rgba(239, 68, 68, 0.05); padding: 12px; border-radius: 10px; margin-bottom: 16px;">
            <div style="font-size: 14px; font-weight: 700; color: var(--danger); margin-bottom: 12px;">
                <i class="fas fa-heartbeat" style="margin-left: 6px;"></i>
                الحالة الصحية
            </div>

            <!-- الأمراض المزمنة -->
            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    الأمراض المزمنة (اختر ما ينطبق)
                </label>
                <div id="diseasesContainer" style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <label class="health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 12px;" onclick="toggleHealthOption(this)">
                        <input type="checkbox" name="diseases" value="diabetes" style="display: none;">
                        <i class="fas fa-tint" style="color: var(--warning);"></i>
                        السكري
                    </label>
                    <label class="health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 12px;" onclick="toggleHealthOption(this)">
                        <input type="checkbox" name="diseases" value="hypertension" style="display: none;">
                        <i class="fas fa-heart" style="color: var(--danger);"></i>
                        الضغط
                    </label>
                    <label class="health-checkbox" style="display: flex; align-items: center; gap: 6px; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 12px;" onclick="toggleHealthOption(this)">
                        <input type="checkbox" name="diseases" value="rheumatoid" style="display: none;">
                        <i class="fas fa-bone" style="color: var(--primary);"></i>
                        التهاب رثوي
                    </label>
                    <button type="button" onclick="showAddDiseaseModal()" style="display: flex; align-items: center; gap: 6px; padding: 8px 12px; border: 2px dashed var(--secondary); border-radius: 8px; cursor: pointer; font-size: 12px; background: rgba(16, 185, 129, 0.05); color: var(--secondary);">
                        <i class="fas fa-plus"></i>
                        إضافة مرض
                    </button>
                </div>
                <!-- الأمراض المضافة -->
                <div id="addedDiseasesList" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px;"></div>
            </div>

            <!-- حالة السكري -->
            <div id="diabetesControl" style="display: none; margin-bottom: 12px; padding: 10px; background: rgba(245, 158, 11, 0.1); border-radius: 8px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--warning); margin-bottom: 6px;">
                    <i class="fas fa-tint" style="margin-left: 4px;"></i>
                    هل السكر مضبوط؟
                </label>
                <div style="display: flex; gap: 10px;">
                    <label class="control-option" onclick="selectControl('diabetes', 'yes')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 12px;">
                        <input type="radio" name="diabetesControlled" value="yes" style="display: none;">
                        <i class="fas fa-check" style="color: var(--secondary);"></i>
                        مضبوط
                    </label>
                    <label class="control-option" onclick="selectControl('diabetes', 'no')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 12px;">
                        <input type="radio" name="diabetesControlled" value="no" style="display: none;">
                        <i class="fas fa-times" style="color: var(--danger);"></i>
                        غير مضبوط
                    </label>
                </div>
            </div>

            <!-- حالة الضغط -->
            <div id="hypertensionControl" style="display: none; margin-bottom: 12px; padding: 10px; background: rgba(239, 68, 68, 0.1); border-radius: 8px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--danger); margin-bottom: 6px;">
                    <i class="fas fa-heart" style="margin-left: 4px;"></i>
                    هل الضغط مضبوط؟
                </label>
                <div style="display: flex; gap: 10px;">
                    <label class="control-option" onclick="selectControl('bp', 'yes')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 12px;">
                        <input type="radio" name="bpControlled" value="yes" style="display: none;">
                        <i class="fas fa-check" style="color: var(--secondary);"></i>
                        مضبوط
                    </label>
                    <label class="control-option" onclick="selectControl('bp', 'no')" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 12px;">
                        <input type="radio" name="bpControlled" value="no" style="display: none;">
                        <i class="fas fa-times" style="color: var(--danger);"></i>
                        غير مضبوط
                    </label>
                </div>
            </div>

        </div>

        <!-- مخطط الأسنان FDI -->
        <div style="background: rgba(16, 185, 129, 0.05); padding: 12px; border-radius: 10px; margin-bottom: 16px;">
            <div style="font-size: 14px; font-weight: 700; color: var(--secondary); margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                <span>
                    <i class="fas fa-tooth" style="margin-left: 6px;"></i>
                    مخطط الأسنان (FDI)
                </span>
                <span style="font-size: 11px; color: var(--gray); font-weight: 500;">اضغط على السن لتحديد الحالة</span>
            </div>

            <!-- الفك العلوي -->
            <div style="margin-bottom: 12px;">
                <div style="font-size: 11px; color: var(--gray); text-align: center; margin-bottom: 6px;">الفك العلوي</div>
                <div style="display: flex; justify-content: center; gap: 2px; flex-wrap: wrap;">
                    <!-- الربع الأول (يمين علوي) 18-11 -->
                    <div style="display: flex; gap: 2px;">
                        <button class="tooth-btn" data-tooth="18" onclick="selectTooth(18)">18</button>
                        <button class="tooth-btn" data-tooth="17" onclick="selectTooth(17)">17</button>
                        <button class="tooth-btn" data-tooth="16" onclick="selectTooth(16)">16</button>
                        <button class="tooth-btn" data-tooth="15" onclick="selectTooth(15)">15</button>
                        <button class="tooth-btn" data-tooth="14" onclick="selectTooth(14)">14</button>
                        <button class="tooth-btn" data-tooth="13" onclick="selectTooth(13)">13</button>
                        <button class="tooth-btn" data-tooth="12" onclick="selectTooth(12)">12</button>
                        <button class="tooth-btn" data-tooth="11" onclick="selectTooth(11)">11</button>
                    </div>
                    <div style="width: 8px;"></div>
                    <!-- الربع الثاني (يسار علوي) 21-28 -->
                    <div style="display: flex; gap: 2px;">
                        <button class="tooth-btn" data-tooth="21" onclick="selectTooth(21)">21</button>
                        <button class="tooth-btn" data-tooth="22" onclick="selectTooth(22)">22</button>
                        <button class="tooth-btn" data-tooth="23" onclick="selectTooth(23)">23</button>
                        <button class="tooth-btn" data-tooth="24" onclick="selectTooth(24)">24</button>
                        <button class="tooth-btn" data-tooth="25" onclick="selectTooth(25)">25</button>
                        <button class="tooth-btn" data-tooth="26" onclick="selectTooth(26)">26</button>
                        <button class="tooth-btn" data-tooth="27" onclick="selectTooth(27)">27</button>
                        <button class="tooth-btn" data-tooth="28" onclick="selectTooth(28)">28</button>
                    </div>
                </div>
            </div>

            <!-- الفك السفلي -->
            <div>
                <div style="display: flex; justify-content: center; gap: 2px; flex-wrap: wrap;">
                    <!-- الربع الرابع (يمين سفلي) 48-41 -->
                    <div style="display: flex; gap: 2px;">
                        <button class="tooth-btn" data-tooth="48" onclick="selectTooth(48)">48</button>
                        <button class="tooth-btn" data-tooth="47" onclick="selectTooth(47)">47</button>
                        <button class="tooth-btn" data-tooth="46" onclick="selectTooth(46)">46</button>
                        <button class="tooth-btn" data-tooth="45" onclick="selectTooth(45)">45</button>
                        <button class="tooth-btn" data-tooth="44" onclick="selectTooth(44)">44</button>
                        <button class="tooth-btn" data-tooth="43" onclick="selectTooth(43)">43</button>
                        <button class="tooth-btn" data-tooth="42" onclick="selectTooth(42)">42</button>
                        <button class="tooth-btn" data-tooth="41" onclick="selectTooth(41)">41</button>
                    </div>
                    <div style="width: 8px;"></div>
                    <!-- الربع الثالث (يسار سفلي) 31-38 -->
                    <div style="display: flex; gap: 2px;">
                        <button class="tooth-btn" data-tooth="31" onclick="selectTooth(31)">31</button>
                        <button class="tooth-btn" data-tooth="32" onclick="selectTooth(32)">32</button>
                        <button class="tooth-btn" data-tooth="33" onclick="selectTooth(33)">33</button>
                        <button class="tooth-btn" data-tooth="34" onclick="selectTooth(34)">34</button>
                        <button class="tooth-btn" data-tooth="35" onclick="selectTooth(35)">35</button>
                        <button class="tooth-btn" data-tooth="36" onclick="selectTooth(36)">36</button>
                        <button class="tooth-btn" data-tooth="37" onclick="selectTooth(37)">37</button>
                        <button class="tooth-btn" data-tooth="38" onclick="selectTooth(38)">38</button>
                    </div>
                </div>
                <div style="font-size: 11px; color: var(--gray); text-align: center; margin-top: 6px;">الفك السفلي</div>
            </div>

            <!-- دليل الألوان -->
            <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #e5e7eb;">
                <div style="font-size: 11px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">دليل الألوان:</div>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <span style="font-size: 10px; display: flex; align-items: center; gap: 4px; padding: 4px 8px; background: rgba(79, 70, 229, 0.1); border-radius: 6px;">
                        <span style="width: 12px; height: 12px; background: var(--primary); border-radius: 3px;"></span>
                        ترميمية
                    </span>
                    <span style="font-size: 10px; display: flex; align-items: center; gap: 4px; padding: 4px 8px; background: rgba(245, 158, 11, 0.1); border-radius: 6px;">
                        <span style="width: 12px; height: 12px; background: var(--warning); border-radius: 3px;"></span>
                        لبية
                    </span>
                    <span style="font-size: 10px; display: flex; align-items: center; gap: 4px; padding: 4px 8px; background: rgba(239, 68, 68, 0.1); border-radius: 6px;">
                        <span style="width: 12px; height: 12px; background: var(--danger); border-radius: 3px;"></span>
                        قلع
                    </span>
                    <span style="font-size: 10px; display: flex; align-items: center; gap: 4px; padding: 4px 8px; background: rgba(107, 114, 128, 0.1); border-radius: 6px;">
                        <span style="width: 12px; height: 12px; background: var(--gray); border-radius: 3px;"></span>
                        مفقود
                    </span>
                </div>
            </div>

            <!-- إحصائيات الأسنان (تحسب تلقائياً) -->
            <div id="teethStats" style="display: none; margin-top: 12px; padding: 12px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(79, 70, 229, 0.1)); border-radius: 10px;">
                <div style="font-size: 11px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    <i class="fas fa-calculator" style="margin-left: 4px; color: var(--secondary);"></i>
                    إحصائيات تلقائية:
                </div>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                    <div style="text-align: center; padding: 8px; background: white; border-radius: 8px;">
                        <div style="font-size: 18px; font-weight: 700; color: var(--secondary);" id="fixedTeethCount">0</div>
                        <div style="font-size: 10px; color: var(--gray);">أسنان ثابتة</div>
                    </div>
                    <div style="text-align: center; padding: 8px; background: white; border-radius: 8px;">
                        <div style="font-size: 18px; font-weight: 700; color: var(--warning);" id="mobileTeethCount">0</div>
                        <div style="font-size: 10px; color: var(--gray);">أسنان متحركة</div>
                    </div>
                    <div style="text-align: center; padding: 8px; background: white; border-radius: 8px;">
                        <div style="font-size: 18px; font-weight: 700; color: var(--gray);" id="missingTeethCount">0</div>
                        <div style="font-size: 10px; color: var(--gray);">أسنان مفقودة</div>
                    </div>
                    <div style="text-align: center; padding: 8px; background: white; border-radius: 8px;">
                        <div style="font-size: 18px; font-weight: 700; color: var(--primary);" id="totalSelectedTeeth">0</div>
                        <div style="font-size: 10px; color: var(--gray);">إجمالي المحدد</div>
                    </div>
                </div>
                <div style="font-size: 9px; color: var(--gray); margin-top: 8px; text-align: center;">
                    <i class="fas fa-info-circle" style="margin-left: 3px;"></i>
                    الأسنان الثابتة والمتحركة تُحسب تلقائياً بناءً على اختياراتك
                </div>
            </div>

            <!-- قائمة الأسنان المحددة -->
            <div id="selectedTeethList" style="margin-top: 12px; display: none;">
                <div style="font-size: 12px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                    الأسنان المحددة:
                </div>
                <div id="teethListContainer" style="max-height: 150px; overflow-y: auto;"></div>
            </div>
        </div>

        <!-- صلاحيات الوصول -->
        <div style="background: rgba(236, 72, 153, 0.05); padding: 12px; border-radius: 10px; margin-bottom: 16px;">
            <div style="font-size: 14px; font-weight: 700; color: var(--accent); margin-bottom: 12px;">
                <i class="fas fa-lock" style="margin-left: 6px;"></i>
                صلاحيات الوصول
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label class="access-option" style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 2px solid var(--primary); border-radius: 10px; cursor: pointer; background: rgba(79, 70, 229, 0.05);" onclick="selectAccessType('private')">
                    <input type="radio" name="accessType" value="private" checked style="display: none;">
                    <div style="width: 36px; height: 36px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-shield" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 14px; font-weight: 600; color: var(--dark);">خاص (لي فقط)</div>
                        <div style="font-size: 11px; color: var(--gray);">أنت فقط تستطيع رؤية وإدارة هذا المريض</div>
                    </div>
                    <i class="fas fa-check-circle access-check" style="color: var(--primary); font-size: 18px;"></i>
                </label>

                <label class="access-option" style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer;" onclick="selectAccessType('public')">
                    <input type="radio" name="accessType" value="public" style="display: none;">
                    <div style="width: 36px; height: 36px; background: var(--secondary); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-globe" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 14px; font-weight: 600; color: var(--dark);">عام (للجميع)</div>
                        <div style="font-size: 11px; color: var(--gray);">جميع الطلاب يستطيعون رؤية هذا المريض</div>
                    </div>
                    <i class="fas fa-check-circle access-check" style="color: var(--gray-300); font-size: 18px;"></i>
                </label>

                <label class="access-option" style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer;" onclick="selectAccessType('custom')">
                    <input type="radio" name="accessType" value="custom" style="display: none;">
                    <div style="width: 36px; height: 36px; background: var(--warning); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users-cog" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 14px; font-weight: 600; color: var(--dark);">مخصص (طلاب محددين)</div>
                        <div style="font-size: 11px; color: var(--gray);">أنت مدير الحالة ويمكنك إضافة/إزالة طلاب</div>
                    </div>
                    <i class="fas fa-check-circle access-check" style="color: var(--gray-300); font-size: 18px;"></i>
                </label>
            </div>

            <!-- إضافة طلاب مخصصين -->
            <div id="customStudentsSection" style="display: none; margin-top: 12px; padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 10px;">
                <div style="font-size: 12px; font-weight: 600; color: var(--warning); margin-bottom: 8px;">
                    <i class="fas fa-user-plus" style="margin-left: 4px;"></i>
                    إضافة طلاب بالرقم الجامعي
                </div>
                <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                    <input type="text" id="studentIdInput" class="text-input" placeholder="أدخل الرقم الجامعي" style="flex: 1; font-size: 13px;">
                    <button onclick="addStudent()" style="background: var(--warning); color: white; border: none; padding: 10px 16px; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div id="studentsList" style="display: flex; flex-wrap: wrap; gap: 6px;"></div>
                <div style="font-size: 10px; color: var(--gray); margin-top: 8px;">
                    <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                    أنت مدير الحالة ويمكنك تغيير الطلاب في أي وقت
                </div>
            </div>
        </div>

        <!-- ملاحظات -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                <i class="fas fa-notes-medical" style="margin-left: 6px; color: var(--gray);"></i>
                ملاحظات إضافية
            </label>
            <textarea id="patientNotes" class="text-input" rows="2" placeholder="أضف ملاحظات عن المريض..." style="resize: none; font-size: 13px;"></textarea>
        </div>

        <button onclick="addNewPatient()" style="width: 100%; background: linear-gradient(135deg, var(--primary), #6366f1); color: white; border: none; padding: 14px; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);">
            <i class="fas fa-plus-circle"></i>
            إضافة المريض
        </button>

        <!-- تنبيه التعديل -->
        <div style="margin-top: 12px; padding: 10px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 10px; display: flex; align-items: start; gap: 10px;">
            <div style="width: 32px; height: 32px; background: var(--warning); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas fa-exclamation-triangle" style="color: white; font-size: 14px;"></i>
            </div>
            <div>
                <div style="font-size: 12px; font-weight: 700; color: var(--warning);">ملاحظة هامة</div>
                <div style="font-size: 11px; color: var(--gray-dark); margin-top: 2px; line-height: 1.5;">
                    أي تعديل على بيانات المريض بعد التثبيت يتطلب مراجعة <strong style="color: var(--primary);">مكتب قبول المرضى</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal اختيار حالة السن -->
<div id="toothModal" class="tooth-modal" style="display: none;">
    <div class="tooth-modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 16px; color: var(--dark);">
                <i class="fas fa-tooth" style="margin-left: 8px; color: var(--secondary);"></i>
                السن رقم <span id="selectedToothNumber"></span>
            </h3>
            <button onclick="closeToothModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <!-- ترميمية -->
            <div class="tooth-option" onclick="selectToothCondition('restorative')" style="border-color: var(--primary); background: rgba(79, 70, 229, 0.05);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), #6366f1); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);">
                        <i class="fas fa-fill-drip" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 600; color: var(--primary);">ترميمية</span>
                        <div style="font-size: 10px; color: var(--gray);">Class 1, 2, 3, 4, 5</div>
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--primary);"></i>
            </div>

            <!-- لبية -->
            <div class="tooth-option" onclick="selectToothCondition('endodontic')" style="border-color: var(--warning); background: rgba(245, 158, 11, 0.05);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-syringe" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 600; color: var(--warning);">لبية</span>
                        <div style="font-size: 10px; color: var(--gray);">سن كامل، جذر، إعادة معالجة</div>
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--warning);"></i>
            </div>

            <!-- قلع -->
            <div class="tooth-option" onclick="selectToothCondition('extraction')" style="border-color: var(--danger); background: rgba(239, 68, 68, 0.05);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--danger), #f87171); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-tooth" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 600; color: var(--danger);">قلع</span>
                        <div style="font-size: 10px; color: var(--gray);">جذر، متقلقل، منطمر</div>
                    </div>
                </div>
                <i class="fas fa-chevron-left" style="color: var(--danger);"></i>
            </div>

            <!-- مفقود -->
            <div class="tooth-option" onclick="selectToothCondition('missing')" style="border-color: var(--gray); background: rgba(107, 114, 128, 0.05);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #6b7280, #9ca3af); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3);">
                        <i class="fas fa-minus-circle" style="color: white;"></i>
                    </div>
                    <div>
                        <span style="font-weight: 600; color: var(--gray-dark);">مفقود</span>
                        <div style="font-size: 10px; color: var(--gray);">غير موجود</div>
                    </div>
                </div>
                <div style="background: var(--gray); color: white; padding: 4px 8px; border-radius: 6px; font-size: 10px;">مباشر</div>
            </div>

            <!-- إزالة -->
            <div class="tooth-option" onclick="removeToothCondition()" style="border-color: var(--danger); border-style: dashed; background: rgba(239, 68, 68, 0.02);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 40px; height: 40px; background: white; border: 2px dashed var(--danger); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-trash" style="color: var(--danger);"></i>
                    </div>
                    <span style="font-weight: 600; color: var(--danger);">إزالة التحديد</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal التفاصيل الفرعية -->
<div id="subConditionModal" class="tooth-modal" style="display: none;">
    <div class="tooth-modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 16px; color: var(--dark);" id="subConditionTitle"></h3>
            <button onclick="closeSubConditionModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="subConditionOptions"></div>
        <!-- زر التأكيد -->
        <div id="confirmSubConditionBtn" style="display: none; margin-top: 16px;">
            <button onclick="confirmToothCondition()" style="width: 100%; background: linear-gradient(135deg, var(--secondary), #34d399); color: white; border: none; padding: 12px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
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
            <h3 style="font-size: 16px; color: var(--dark);">
                <i class="fas fa-plus-circle" style="margin-left: 8px; color: var(--secondary);"></i>
                إضافة مرض
            </h3>
            <button onclick="closeAddDiseaseModal()" style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="form-group">
            <input type="text" id="newDiseaseInput" class="text-input" placeholder="اكتب اسم المرض..." style="font-size: 14px;">
        </div>
        <button onclick="addCustomDisease()" style="width: 100%; background: linear-gradient(135deg, var(--secondary), #34d399); color: white; border: none; padding: 12px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 12px;">
            <i class="fas fa-plus"></i>
            إضافة
        </button>
    </div>
</div>

<style>
/* أزرار الأسنان */
.tooth-btn {
    width: 32px;
    height: 32px;
    border: 2px solid #e5e7eb;
    border-radius: 6px;
    background: white;
    font-size: 10px;
    font-weight: 600;
    color: var(--dark);
    cursor: pointer;
    transition: all 0.2s;
}

.tooth-btn:hover {
    border-color: var(--secondary);
    transform: scale(1.1);
}

.tooth-btn.restorative {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

.tooth-btn.endodontic {
    background: var(--warning);
    border-color: var(--warning);
    color: white;
}

.tooth-btn.extraction {
    background: var(--danger);
    border-color: var(--danger);
    color: white;
}

.tooth-btn.missing {
    background: var(--gray);
    border-color: var(--gray);
    color: white;
    text-decoration: line-through;
}

/* Modal الأسنان */
.tooth-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 20px;
}

.tooth-modal-content {
    background: white;
    border-radius: 16px;
    padding: 20px;
    width: 100%;
    max-width: 350px;
    max-height: 80vh;
    overflow-y: auto;
}

.tooth-option {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s;
}

.tooth-option:hover {
    border-color: var(--primary);
    background: rgba(79, 70, 229, 0.03);
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
    padding: 6px 10px;
    background: var(--warning);
    color: white;
    border-radius: 20px;
    font-size: 12px;
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
.health-checkbox.selected {
    border-color: var(--primary) !important;
    background: rgba(79, 70, 229, 0.1) !important;
}

/* خيارات الجنس */
.gender-option.selected {
    border-color: var(--primary) !important;
    background: rgba(79, 70, 229, 0.05) !important;
}

/* خيارات التحكم (مضبوط/غير مضبوط) */
.control-option.selected-yes {
    border-color: var(--secondary) !important;
    background: rgba(16, 185, 129, 0.1) !important;
}

.control-option.selected-no {
    border-color: var(--danger) !important;
    background: rgba(239, 68, 68, 0.1) !important;
}

/* خيارات السن الفرعية */
.tooth-sub-option:hover {
    border-color: var(--primary);
    background: rgba(79, 70, 229, 0.03);
}

.tooth-sub-option.selected {
    border-color: var(--primary) !important;
    background: rgba(79, 70, 229, 0.05) !important;
}
</style>

<script>
// بيانات المرضى
let patientsData = [
    { id: 1, name: 'أحمد محمد علي', record: 'MED-2024-001', age: 45, type: 'private', specialty: 'قلبية', date: '15/01/2024', initial: 'أ', color: 'primary', status: 'active' },
    { id: 2, name: 'سارة أحمد الخالد', record: 'MED-2024-002', age: 32, type: 'public', specialty: 'تنفسية', date: '20/01/2024', initial: 'س', color: 'secondary', status: 'completed' },
    { id: 3, name: 'محمود خالد العمري', record: 'MED-2024-003', age: 58, type: 'private', specialty: 'عصبية', date: '22/01/2024', initial: 'م', color: 'accent', status: 'active' },
    { id: 4, name: 'فاطمة علي حسن', record: 'MED-2024-004', age: 28, type: 'public', specialty: 'باطنية', date: '25/01/2024', initial: 'ف', color: 'warning', status: 'pending' },
    { id: 5, name: 'خالد يوسف أحمد', record: 'MED-2024-005', age: 52, type: 'private', specialty: 'قلبية', date: '28/01/2024', initial: 'خ', color: 'danger', status: 'completed' },
    { id: 6, name: 'نور محمد سالم', record: 'MED-2024-006', age: 35, type: 'public', specialty: 'جلدية', date: '30/01/2024', initial: 'ن', color: 'primary', status: 'active' },
    { id: 7, name: 'عمر سعيد الحسن', record: 'MED-2024-007', age: 41, type: 'private', specialty: 'باطنية', date: '01/02/2024', initial: 'ع', color: 'secondary', status: 'active' },
    { id: 8, name: 'ليلى عبدالله محمد', record: 'MED-2024-008', age: 29, type: 'public', specialty: 'قلبية', date: '02/02/2024', initial: 'ل', color: 'accent', status: 'pending' }
];

const colorGradients = {
    'primary': 'linear-gradient(135deg, var(--primary), #6366f1)',
    'secondary': 'linear-gradient(135deg, var(--secondary), #34d399)',
    'accent': 'linear-gradient(135deg, var(--accent), #f472b6)',
    'warning': 'linear-gradient(135deg, var(--warning), #fbbf24)',
    'danger': 'linear-gradient(135deg, var(--danger), #f87171)'
};

let currentAllFilter = 'all';

// تهيئة الصفحة
document.addEventListener('DOMContentLoaded', function() {
    renderPrivatePatients();
    renderPublicPatients();
    renderAllPatients();
    updateStudentsList();

    // تهيئة صلاحيات الوصول الافتراضية
    selectAccessType('private');
});

// عرض المرضى الخاصين
function renderPrivatePatients(searchTerm = '') {
    let patients = patientsData.filter(p => p.type === 'private');
    if (searchTerm) {
        patients = patients.filter(p => p.name.includes(searchTerm) || p.record.includes(searchTerm));
    }
    renderPatientsList('privatePatientsList', patients);
}

// عرض المرضى العامين
function renderPublicPatients(searchTerm = '') {
    let patients = patientsData.filter(p => p.type === 'public');
    if (searchTerm) {
        patients = patients.filter(p => p.name.includes(searchTerm) || p.record.includes(searchTerm));
    }
    renderPatientsList('publicPatientsList', patients);
}

// عرض جميع المرضى
function renderAllPatients(filter = 'all', searchTerm = '') {
    let patients = patientsData;
    if (filter !== 'all') {
        patients = patients.filter(p => p.type === filter);
    }
    if (searchTerm) {
        patients = patients.filter(p => p.name.includes(searchTerm) || p.record.includes(searchTerm));
    }
    renderPatientsList('allPatientsList', patients);
}

// البحث في المرضى
function searchPatients(type, term) {
    if (type === 'private') {
        renderPrivatePatients(term);
    } else if (type === 'public') {
        renderPublicPatients(term);
    } else {
        renderAllPatients(currentAllFilter, term);
    }
}

// فلترة جميع المرضى
function filterAllPatients(filter) {
    currentAllFilter = filter;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.style.background = 'white';
        btn.style.color = 'var(--dark)';
        btn.style.border = '2px solid #e5e7eb';
    });
    event.target.style.background = 'var(--primary)';
    event.target.style.color = 'white';
    event.target.style.border = 'none';

    const searchTerm = document.getElementById('allPatientSearch')?.value || '';
    renderAllPatients(filter, searchTerm);
}

// عرض قائمة المرضى
function renderPatientsList(containerId, patients) {
    const container = document.getElementById(containerId);
    if (!container) return;

    if (patients.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 40px 20px;">
                <div style="width: 80px; height: 80px; background: var(--gray-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fas fa-user-slash" style="font-size: 32px; color: var(--gray);"></i>
                </div>
                <div style="font-size: 16px; font-weight: 600; color: var(--dark);">لا يوجد مرضى</div>
                <div style="font-size: 14px; color: var(--gray); margin-top: 8px;">أضف مريض جديد للبدء</div>
            </div>
        `;
        return;
    }

    container.innerHTML = patients.map(p => `
        <div class="patient-card" style="background: white; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f3f4f6;">
            <div style="display: flex; gap: 12px;">
                <div style="width: 56px; height: 56px; background: ${colorGradients[p.color]}; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                    ${p.initial}
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${p.name}</div>
                            <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">
                                <i class="fas fa-hashtag" style="margin-left: 4px;"></i>${p.record}
                            </div>
                        </div>
                        <span style="background: ${p.type === 'private' ? 'rgba(79, 70, 229, 0.1)' : 'rgba(16, 185, 129, 0.1)'};
                                     color: ${p.type === 'private' ? 'var(--primary)' : 'var(--secondary)'};
                                     padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 600;">
                            <i class="fas ${p.type === 'private' ? 'fa-user-shield' : 'fa-users'}" style="margin-left: 4px;"></i>
                            ${p.type === 'private' ? 'خاص' : 'عام'}
                        </span>
                    </div>
                    <div style="display: flex; gap: 12px; margin-top: 10px; font-size: 12px; color: var(--gray); flex-wrap: wrap;">
                        <span><i class="fas fa-birthday-cake" style="margin-left: 4px; color: var(--accent);"></i>${p.age} سنة</span>
                        <span><i class="fas fa-stethoscope" style="margin-left: 4px; color: var(--secondary);"></i>${p.specialty}</span>
                        <span><i class="fas fa-calendar" style="margin-left: 4px; color: var(--warning);"></i>${p.date}</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f3f4f6;">
                <button onclick="viewPatientDetails(${p.id})" style="flex: 1; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-eye"></i>
                    عرض التفاصيل
                </button>
                <button onclick="editPatient(${p.id})" style="background: rgba(79, 70, 229, 0.1); color: var(--primary); border: none; padding: 10px 14px; border-radius: 10px; cursor: pointer;">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deletePatient(${p.id})" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: none; padding: 10px 14px; border-radius: 10px; cursor: pointer;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `).join('');
}

// عرض تفاصيل المريض
function viewPatientDetails(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (!patient) return;

    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = () => { overlay.remove(); modal.remove(); };

    const modal = document.createElement('div');
    modal.className = 'images-alert';
    modal.style.maxWidth = '450px';
    modal.onclick = e => e.stopPropagation();

    modal.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-user-injured" style="color: var(--primary);"></i>
                تفاصيل المريض
            </h3>
            <button onclick="this.closest('.images-alert').remove(); document.querySelector('.alert-overlay').remove();"
                    style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 80px; height: 80px; background: ${colorGradients[patient.color]}; border-radius: 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700; margin: 0 auto 12px;">
                ${patient.initial}
            </div>
            <div style="font-size: 20px; font-weight: 700; color: var(--dark);">${patient.name}</div>
            <div style="font-size: 13px; color: var(--gray); margin-top: 4px;">${patient.record}</div>
        </div>

        <div style="background: var(--gray-50); border-radius: 12px; padding: 16px; margin-bottom: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div style="text-align: center; padding: 12px; background: white; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">العمر</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${patient.age} سنة</div>
                </div>
                <div style="text-align: center; padding: 12px; background: white; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">التخصص</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--primary);">${patient.specialty}</div>
                </div>
                <div style="text-align: center; padding: 12px; background: white; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">النوع</div>
                    <div style="font-size: 16px; font-weight: 700; color: ${patient.type === 'private' ? 'var(--primary)' : 'var(--secondary)'};">
                        ${patient.type === 'private' ? 'خاص' : 'عام'}
                    </div>
                </div>
                <div style="text-align: center; padding: 12px; background: white; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">تاريخ التسجيل</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${patient.date}</div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 12px;">
            <button onclick="showToast('جاري فتح سجل المريض...', 'info')"
                    style="flex: 1; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-folder-open" style="margin-left: 6px;"></i>
                فتح السجل
            </button>
            <button onclick="this.closest('.images-alert').remove(); document.querySelector('.alert-overlay').remove();"
                    style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer;">
                إغلاق
            </button>
        </div>
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(modal);
}

// تعديل المريض
function editPatient(patientId) {
    showToast('جاري فتح نموذج التعديل...', 'info');
}

// حذف المريض
function deletePatient(patientId) {
    if (!confirm('هل أنت متأكد من حذف هذا المريض؟')) return;

    patientsData = patientsData.filter(p => p.id !== patientId);
    renderPrivatePatients();
    renderPublicPatients();
    renderAllPatients(currentAllFilter);
    showToast('تم حذف المريض بنجاح', 'success');
}

// ========== نظام الأسنان FDI ==========
let selectedTeeth = {}; // {toothNumber: {condition: 'restorative', subCondition: 'class2'}}
let currentToothNumber = null;
let currentCondition = null;
let pendingSubCondition = null; // الخيار الفرعي المعلق للتأكيد
let pendingSubLabel = null;
let addedStudents = []; // قائمة الطلاب المضافين
let addedDiseases = []; // الأمراض المضافة يدوياً

// فتح modal اختيار حالة السن
function selectTooth(toothNumber) {
    currentToothNumber = toothNumber;
    document.getElementById('selectedToothNumber').textContent = toothNumber;
    document.getElementById('toothModal').style.display = 'flex';
}

// إغلاق modal السن
function closeToothModal() {
    document.getElementById('toothModal').style.display = 'none';
    currentToothNumber = null;
}

// إغلاق modal التفاصيل الفرعية
function closeSubConditionModal() {
    document.getElementById('subConditionModal').style.display = 'none';
    document.getElementById('confirmSubConditionBtn').style.display = 'none';
    currentCondition = null;
    pendingSubCondition = null;
    pendingSubLabel = null;
}

// اختيار حالة السن الرئيسية
function selectToothCondition(condition) {
    currentCondition = condition;

    // إذا كان السن مفقود - لا يحتاج تفاصيل فرعية
    if (condition === 'missing') {
        applyToothCondition('missing', 'غير موجود');
        closeToothModal();
        return;
    }

    // إعداد الخيارات الفرعية
    let title = '';
    let options = [];

    if (condition === 'restorative') {
        title = '<i class="fas fa-fill-drip" style="margin-left: 8px; color: var(--primary);"></i> ترميمية - اختر الصنف';
        options = [
            { value: 'class1', label: 'Class 1', desc: 'حفرة في السطح الإطباقي' },
            { value: 'class2', label: 'Class 2', desc: 'حفرة في السطح القريب للأرحاء' },
            { value: 'class3', label: 'Class 3', desc: 'حفرة في السطح القريب للأمامية' },
            { value: 'class4', label: 'Class 4', desc: 'حفرة في زاوية القاطعة' },
            { value: 'class5', label: 'Class 5', desc: 'حفرة في الثلث اللثوي' }
        ];
    } else if (condition === 'endodontic') {
        title = '<i class="fas fa-syringe" style="margin-left: 8px; color: var(--warning);"></i> لبية - اختر النوع';
        options = [
            { value: 'full', label: 'سن كامل', desc: 'معالجة لبية للسن الكامل' },
            { value: 'root', label: 'جذر فقط', desc: 'معالجة لبية للجذر' },
            { value: 'retreat_full', label: 'إعادة معالجة سن كامل', desc: 'إعادة المعالجة اللبية للسن الكامل' },
            { value: 'retreat_root', label: 'إعادة معالجة جذر', desc: 'إعادة المعالجة اللبية للجذر' }
        ];
    } else if (condition === 'extraction') {
        title = '<i class="fas fa-tooth" style="margin-left: 8px; color: var(--danger);"></i> قلع - اختر النوع';
        options = [
            { value: 'root_only', label: 'جذر فقط', desc: 'قلع بقايا جذر' },
            { value: 'mobile', label: 'سن متقلقل', desc: 'قلع سن متحرك' },
            { value: 'impacted', label: 'سن منطمر', desc: 'قلع سن منطمر جراحياً' }
        ];
    }

    // إغلاق modal الأول وفتح modal التفاصيل
    closeToothModal();

    // إخفاء زر التأكيد مبدئياً
    document.getElementById('confirmSubConditionBtn').style.display = 'none';
    pendingSubCondition = null;
    pendingSubLabel = null;

    // ألوان حسب نوع الحالة
    const conditionStyles = {
        restorative: { color: 'var(--primary)', bg: 'rgba(79, 70, 229, 0.05)', gradient: 'linear-gradient(135deg, var(--primary), #6366f1)' },
        endodontic: { color: 'var(--warning)', bg: 'rgba(245, 158, 11, 0.05)', gradient: 'linear-gradient(135deg, var(--warning), #fbbf24)' },
        extraction: { color: 'var(--danger)', bg: 'rgba(239, 68, 68, 0.05)', gradient: 'linear-gradient(135deg, var(--danger), #f87171)' }
    };
    const style = conditionStyles[condition];

    document.getElementById('subConditionTitle').innerHTML = title;
    document.getElementById('subConditionOptions').innerHTML = options.map(opt => `
        <div class="tooth-sub-option" data-value="${opt.value}" data-label="${opt.label}" onclick="selectSubCondition('${opt.value}', '${opt.label}')" style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer; transition: all 0.2s; margin-bottom: 8px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: ${style.bg}; border: 2px solid ${style.color}; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 11px; font-weight: 700; color: ${style.color};">${opt.label.replace('Class ', '').replace('سن ', '').replace('جذر', 'ج').replace('إعادة معالجة ', '↻').substring(0, 2)}</span>
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 600; color: var(--dark);">${opt.label}</div>
                    <div style="font-size: 11px; color: var(--gray); margin-top: 2px;">${opt.desc}</div>
                </div>
            </div>
            <i class="fas fa-circle sub-check" style="color: #e5e7eb; font-size: 16px;"></i>
        </div>
    `).join('');

    document.getElementById('subConditionModal').style.display = 'flex';
}

// اختيار الخيار الفرعي (بدون تأكيد)
function selectSubCondition(value, label) {
    pendingSubCondition = value;
    pendingSubLabel = label;

    const conditionStyles = {
        restorative: { color: 'var(--primary)', bg: 'rgba(79, 70, 229, 0.1)' },
        endodontic: { color: 'var(--warning)', bg: 'rgba(245, 158, 11, 0.1)' },
        extraction: { color: 'var(--danger)', bg: 'rgba(239, 68, 68, 0.1)' }
    };
    const style = conditionStyles[currentCondition] || conditionStyles.restorative;

    // تحديث مظهر الخيارات
    document.querySelectorAll('.tooth-sub-option').forEach(opt => {
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
        opt.querySelector('.sub-check').className = 'fas fa-circle sub-check';
        opt.querySelector('.sub-check').style.color = '#e5e7eb';
    });

    // تحديد الخيار المختار
    const selectedOpt = document.querySelector(`.tooth-sub-option[data-value="${value}"]`);
    if (selectedOpt) {
        selectedOpt.style.borderColor = style.color;
        selectedOpt.style.background = style.bg;
        selectedOpt.querySelector('.sub-check').className = 'fas fa-check-circle sub-check';
        selectedOpt.querySelector('.sub-check').style.color = style.color;

        // تحديث لون زر التأكيد
        const confirmBtn = document.querySelector('#confirmSubConditionBtn button');
        const gradients = {
            restorative: 'linear-gradient(135deg, var(--primary), #6366f1)',
            endodontic: 'linear-gradient(135deg, var(--warning), #fbbf24)',
            extraction: 'linear-gradient(135deg, var(--danger), #f87171)'
        };
        confirmBtn.style.background = gradients[currentCondition] || gradients.restorative;
    }

    // إظهار زر التأكيد
    document.getElementById('confirmSubConditionBtn').style.display = 'block';
}

// تأكيد اختيار حالة السن
function confirmToothCondition() {
    if (!pendingSubCondition || !pendingSubLabel) {
        showToast('يرجى اختيار نوع الحالة أولاً', 'warning');
        return;
    }

    applyToothCondition(currentCondition, pendingSubLabel, pendingSubCondition);
    closeSubConditionModal();
}

// تطبيق حالة السن
function applyToothCondition(condition, label, subValue = null) {
    if (!currentToothNumber && currentToothNumber !== 0) return;

    selectedTeeth[currentToothNumber] = {
        condition: condition,
        subCondition: subValue,
        label: label
    };

    // تحديث مظهر الزر
    const btn = document.querySelector(`.tooth-btn[data-tooth="${currentToothNumber}"]`);
    if (btn) {
        btn.className = 'tooth-btn ' + condition;
        btn.title = label;
    }

    // تحديث قائمة الأسنان المحددة
    updateSelectedTeethList();

    closeSubConditionModal();
    showToast(`تم تحديد السن ${currentToothNumber}: ${label}`, 'success');
}

// إزالة تحديد السن
function removeToothCondition() {
    if (!currentToothNumber) return;

    delete selectedTeeth[currentToothNumber];

    const btn = document.querySelector(`.tooth-btn[data-tooth="${currentToothNumber}"]`);
    if (btn) {
        btn.className = 'tooth-btn';
        btn.title = '';
    }

    updateSelectedTeethList();
    closeToothModal();
    showToast(`تم إزالة تحديد السن ${currentToothNumber}`, 'info');
}

// تحديث قائمة الأسنان المحددة
function updateSelectedTeethList() {
    const listContainer = document.getElementById('selectedTeethList');
    const teethContainer = document.getElementById('teethListContainer');
    const statsContainer = document.getElementById('teethStats');
    const teethKeys = Object.keys(selectedTeeth);

    if (teethKeys.length === 0) {
        listContainer.style.display = 'none';
        statsContainer.style.display = 'none';
        return;
    }

    listContainer.style.display = 'block';
    statsContainer.style.display = 'block';

    // حساب الإحصائيات
    let fixedCount = 0;    // الأسنان الثابتة (ترميمية + لبية غير قلع)
    let mobileCount = 0;   // الأسنان المتحركة (قلع متقلقل)
    let missingCount = 0;  // المفقودة

    teethKeys.forEach(tooth => {
        const data = selectedTeeth[tooth];
        if (data.condition === 'missing') {
            missingCount++;
        } else if (data.condition === 'extraction' && data.subCondition === 'mobile') {
            mobileCount++;
        } else if (data.condition === 'restorative' || data.condition === 'endodontic') {
            fixedCount++;
        }
    });

    // تحديث الإحصائيات في الواجهة
    document.getElementById('fixedTeethCount').textContent = fixedCount;
    document.getElementById('mobileTeethCount').textContent = mobileCount;
    document.getElementById('missingTeethCount').textContent = missingCount;
    document.getElementById('totalSelectedTeeth').textContent = teethKeys.length;

    const conditionColors = {
        restorative: 'var(--primary)',
        endodontic: 'var(--warning)',
        extraction: 'var(--danger)',
        missing: 'var(--gray)'
    };

    const conditionIcons = {
        restorative: 'fa-fill-drip',
        endodontic: 'fa-syringe',
        extraction: 'fa-tooth',
        missing: 'fa-minus-circle'
    };

    teethContainer.innerHTML = teethKeys.map(tooth => {
        const data = selectedTeeth[tooth];
        const color = conditionColors[data.condition];
        const icon = conditionIcons[data.condition];
        return `
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: white; border-radius: 8px; margin-bottom: 6px; border: 1px solid #e5e7eb;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 28px; height: 28px; background: ${color}; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 11px; font-weight: 600;">
                        ${tooth}
                    </div>
                    <div>
                        <span style="font-size: 12px; font-weight: 600; color: var(--dark);">${data.label}</span>
                    </div>
                </div>
                <button onclick="removeToothFromList(${tooth})" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 4px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    }).join('');
}

// إزالة سن من القائمة
function removeToothFromList(toothNumber) {
    delete selectedTeeth[toothNumber];

    const btn = document.querySelector(`.tooth-btn[data-tooth="${toothNumber}"]`);
    if (btn) {
        btn.className = 'tooth-btn';
        btn.title = '';
    }

    updateSelectedTeethList();
}

// ========== نظام الحالة الصحية ==========
function toggleHealthOption(element) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
        element.classList.add('selected');
    } else {
        element.classList.remove('selected');
    }

    // إظهار/إخفاء خيارات التحكم
    const value = checkbox.value;

    if (value === 'diabetes') {
        document.getElementById('diabetesControl').style.display = checkbox.checked ? 'block' : 'none';
    } else if (value === 'hypertension') {
        document.getElementById('hypertensionControl').style.display = checkbox.checked ? 'block' : 'none';
    }
}

// فتح modal إضافة مرض
function showAddDiseaseModal() {
    document.getElementById('addDiseaseModal').style.display = 'flex';
    document.getElementById('newDiseaseInput').value = '';
    document.getElementById('newDiseaseInput').focus();
}

// إغلاق modal إضافة مرض
function closeAddDiseaseModal() {
    document.getElementById('addDiseaseModal').style.display = 'none';
}

// إضافة مرض مخصص
function addCustomDisease() {
    const input = document.getElementById('newDiseaseInput');
    const diseaseName = input.value.trim();

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

// تحديث قائمة الأمراض المضافة
function updateAddedDiseasesList() {
    const container = document.getElementById('addedDiseasesList');

    if (addedDiseases.length === 0) {
        container.innerHTML = '';
        return;
    }

    container.innerHTML = addedDiseases.map(disease => `
        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; background: rgba(239, 68, 68, 0.1); color: var(--danger); border-radius: 20px; font-size: 12px; font-weight: 600;">
            <i class="fas fa-disease"></i>
            ${disease}
            <button onclick="removeAddedDisease('${disease}')" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 0; font-size: 12px;">
                <i class="fas fa-times"></i>
            </button>
        </span>
    `).join('');
}

// إزالة مرض مضاف
function removeAddedDisease(disease) {
    addedDiseases = addedDiseases.filter(d => d !== disease);
    updateAddedDiseasesList();
}

// ========== حساب العمر من سنة الميلاد ==========
function calculateAge() {
    const birthYearInput = document.getElementById('patientBirthYear');
    const birthYear = parseInt(birthYearInput.value);
    const ageDisplay = document.getElementById('calculatedAge');
    const ageValue = document.getElementById('ageValue');

    if (!birthYear || birthYear < 1900 || birthYear > new Date().getFullYear()) {
        ageDisplay.style.display = 'none';
        return;
    }

    const currentYear = new Date().getFullYear();
    const age = currentYear - birthYear;

    ageValue.textContent = age;
    ageDisplay.style.display = 'block';
}

// ========== اختيار الجنس ==========
function selectGender(gender) {
    // إزالة التحديد من الكل
    document.querySelectorAll('.gender-option').forEach(opt => {
        opt.classList.remove('selected');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
    });

    // تحديد الخيار المختار
    const selectedRadio = document.querySelector(`input[name="patientGender"][value="${gender}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.gender-option');
        label.classList.add('selected');
        label.style.borderColor = 'var(--primary)';
        label.style.background = 'rgba(79, 70, 229, 0.05)';
    }
}

// ========== اختيار حالة التحكم (السكري/الضغط) ==========
function selectControl(type, value) {
    const inputName = type === 'diabetes' ? 'diabetesControlled' : 'bpControlled';
    const container = type === 'diabetes' ? document.getElementById('diabetesControl') : document.getElementById('hypertensionControl');

    // إزالة التحديد من الكل في هذا القسم
    container.querySelectorAll('.control-option').forEach(opt => {
        opt.classList.remove('selected-yes', 'selected-no');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
    });

    // تحديد الخيار المختار
    const selectedRadio = container.querySelector(`input[name="${inputName}"][value="${value}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.control-option');
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

// ========== نظام صلاحيات الوصول ==========
function selectAccessType(type) {
    // إزالة التحديد من الكل
    document.querySelectorAll('.access-option').forEach(opt => {
        opt.classList.remove('selected');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
        opt.querySelector('.access-check').style.color = 'var(--gray-300)';
    });

    // تحديد الخيار المختار
    const selectedRadio = document.querySelector(`input[name="accessType"][value="${type}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.access-option');
        label.classList.add('selected');
        label.style.borderColor = 'var(--primary)';
        label.style.background = 'rgba(79, 70, 229, 0.05)';
        label.querySelector('.access-check').style.color = 'var(--primary)';
    }

    // إظهار/إخفاء قسم الطلاب المخصصين
    const customSection = document.getElementById('customStudentsSection');
    if (type === 'custom') {
        customSection.style.display = 'block';
    } else {
        customSection.style.display = 'none';
    }
}

// إضافة طالب بالرقم الجامعي
function addStudent() {
    const input = document.getElementById('studentIdInput');
    const studentId = input.value.trim();

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
    input.value = '';
    showToast(`تم إضافة الطالب ${studentId}`, 'success');
}

// تحديث قائمة الطلاب
function updateStudentsList() {
    const container = document.getElementById('studentsList');

    if (addedStudents.length === 0) {
        container.innerHTML = '<span style="font-size: 11px; color: var(--gray);">لم تتم إضافة طلاب بعد</span>';
        return;
    }

    container.innerHTML = addedStudents.map(id => `
        <span class="student-badge">
            <i class="fas fa-user-graduate"></i>
            ${id}
            <button onclick="removeStudent('${id}')">
                <i class="fas fa-times"></i>
            </button>
        </span>
    `).join('');
}

// إزالة طالب
function removeStudent(studentId) {
    addedStudents = addedStudents.filter(id => id !== studentId);
    updateStudentsList();
}

// ========== إضافة مريض جديد ==========
function addNewPatient() {
    const name = document.getElementById('patientName').value;
    const birthYear = document.getElementById('patientBirthYear').value;
    const phone = document.getElementById('patientPhone')?.value || '';
    const governorate = document.getElementById('patientGovernorate')?.value || '';
    const address = document.getElementById('patientAddress')?.value || '';
    const gender = document.querySelector('input[name="patientGender"]:checked')?.value || 'male';
    const accessType = document.querySelector('input[name="accessType"]:checked')?.value || 'private';
    const notes = document.getElementById('patientNotes')?.value || '';

    // جمع الأمراض
    const diseases = [];
    document.querySelectorAll('input[name="diseases"]:checked').forEach(cb => {
        diseases.push(cb.value);
    });

    // حالة السكري
    const diabetesControlled = document.querySelector('input[name="diabetesControlled"]:checked')?.value || null;

    // حالة الضغط
    const bpControlled = document.querySelector('input[name="bpControlled"]:checked')?.value || null;

    if (!name) {
        showToast('يرجى إدخال اسم المريض', 'warning');
        return;
    }

    if (!birthYear) {
        showToast('يرجى إدخال سنة الميلاد', 'warning');
        return;
    }

    // حساب العمر من سنة الميلاد
    const currentYear = new Date().getFullYear();
    const calculatedAge = currentYear - parseInt(birthYear);

    const newPatient = {
        id: Date.now(),
        name: name,
        record: 'MED-2024-' + String(patientsData.length + 1).padStart(3, '0'),
        birthYear: parseInt(birthYear), // يُحفظ في السيرفر
        age: calculatedAge, // للعرض فقط
        phone: phone ? '09' + phone : '',
        governorate: governorate,
        address: address,
        gender: gender,
        type: accessType,
        specialty: 'أسنان',
        date: new Date().toLocaleDateString('ar-SA'),
        initial: name.charAt(0),
        color: ['primary', 'secondary', 'accent', 'warning', 'danger'][Math.floor(Math.random() * 5)],
        status: 'active',
        // بيانات إضافية
        teeth: { ...selectedTeeth },
        healthConditions: {
            diseases: [...diseases, ...addedDiseases],
            diabetesControlled: diabetesControlled,
            bpControlled: bpControlled
        },
        accessPermissions: {
            type: accessType,
            allowedStudents: accessType === 'custom' ? [...addedStudents] : [],
            caseManager: 'current_user' // المستخدم الحالي
        },
        notes: notes
    };

    patientsData.push(newPatient);

    // مسح النموذج
    document.getElementById('patientName').value = '';
    document.getElementById('patientBirthYear').value = '';
    document.getElementById('calculatedAge').style.display = 'none';
    document.getElementById('patientPhone').value = '';
    document.getElementById('patientGovernorate').value = '';
    document.getElementById('patientAddress').value = '';
    if (document.getElementById('patientNotes')) {
        document.getElementById('patientNotes').value = '';
    }

    // مسح الأمراض
    document.querySelectorAll('input[name="diseases"]').forEach(cb => {
        cb.checked = false;
        cb.closest('.health-checkbox')?.classList.remove('selected');
    });
    document.getElementById('diabetesControl').style.display = 'none';
    document.getElementById('hypertensionControl').style.display = 'none';

    // مسح الأمراض المضافة
    addedDiseases = [];
    updateAddedDiseasesList();

    // مسح الأسنان
    selectedTeeth = {};
    document.querySelectorAll('.tooth-btn').forEach(btn => {
        btn.className = 'tooth-btn';
        btn.title = '';
    });
    updateSelectedTeethList();

    // مسح الطلاب
    addedStudents = [];
    updateStudentsList();

    // إعادة تعيين الصلاحيات إلى خاص
    selectAccessType('private');

    // تحديث القوائم
    renderPrivatePatients();
    renderPublicPatients();
    renderAllPatients(currentAllFilter);

    showToast('تم إضافة المريض بنجاح', 'success');

    // الانتقال لتبويب المرضى
    setTimeout(() => {
        if (accessType === 'private') {
            switchTab('mypatients');
        } else {
            switchTab('publicpatients');
        }
    }, 1000);
}
</script>
@endsection
