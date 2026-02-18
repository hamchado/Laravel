<!-- قسم جميع المرضى -->
<div class="tab-content active" id="allpatientsContent">
    
    <!-- العنوان -->
    <div class="section-title-all">
        <i class="fas fa-clipboard-list"></i>
        <span>جميع المرضى</span>
    </div>

    <!-- فلاتر التصفية -->
    <div class="filters-container">
        <button class="filter-btn active" data-filter="all" onclick="filterAllPatients('all')">
            الكل (<span id="countAll">8</span>)
        </button>
        <button class="filter-btn" data-filter="private" onclick="filterAllPatients('private')">
            خاص (<span id="countPrivate">4</span>)
        </button>
        <button class="filter-btn" data-filter="public" onclick="filterAllPatients('public')">
            عام (<span id="countPublic">4</span>)
        </button>
    </div>

    <!-- شريط البحث -->
    <div class="search-container">
        <input type="text" 
               id="allPatientSearch" 
               class="search-input"
               placeholder="ابحث عن مريض بالاسم أو رقم السجل أو التخصص..."
               onkeyup="searchAllPatients(this.value)">
        <i class="fas fa-search search-icon"></i>
    </div>

    <!-- قائمة المرضى - بطاقات -->
    <div class="patients-cards-grid" id="allPatientsList">
        <!-- يتم ملؤها بواسطة JavaScript -->
    </div>

</div>

<!-- Modal الحجز المؤقت -->
<div id="tempReservationModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 450px;">
        <div class="modal-icon purple">
            <i class="fas fa-clock"></i>
        </div>
        <h3 class="modal-title">حجز مؤقت للمريض</h3>
        <p class="modal-text">اختر المقرر والجلسة المناسبة للحجز المؤقت. سيتم تجميد المريض لديك حتى إلغاء الحجز أو تثبيته.</p>
        
        <div class="modal-info-box">
            <div class="modal-info-item">
                <span class="modal-info-label">المريض:</span>
                <div class="modal-info-value" id="tempPatientName"></div>
            </div>
            <div class="modal-info-item">
                <span class="modal-info-label">العمر:</span>
                <div class="modal-info-value primary" id="tempPatientAge"></div>
            </div>
        </div>

        <!-- اختيار المقرر -->
        <div class="modal-input-group">
            <label class="modal-input-label">اختر المقرر <span class="required">*</span></label>
            <div class="custom-dropdown" id="courseDropdown">
                <div class="dropdown-header" onclick="toggleCourseDropdown()">
                    <span id="selectedCourseText">اختر المقرر...</span>
                    <i class="fas fa-chevron-down" id="courseDropdownIcon"></i>
                </div>
                <div class="dropdown-options" id="courseOptions" style="display: none;">
                    <!-- يتم ملؤها ديناميكياً -->
                </div>
            </div>
            <div class="dropdown-hint" id="courseHint"></div>
        </div>

        <!-- تفاصيل الجلسة (تظهر بعد اختيار المقرر) -->
        <div id="sessionDetails" style="display: none; margin-top: 16px;">
            <div class="session-info-card">
                <div class="session-info-header">
                    <i class="fas fa-info-circle"></i>
                    <span>تفاصيل الجلسة المحددة</span>
                </div>
                <div class="session-info-body">
                    <div class="session-info-row">
                        <i class="fas fa-clock"></i>
                        <span id="sessionTime">--:--</span>
                    </div>
                    <div class="session-info-row">
                        <i class="fas fa-hospital"></i>
                        <span id="sessionLocation">--</span>
                    </div>
                    <div class="session-info-row">
                        <i class="fas fa-user-md"></i>
                        <span id="sessionSupervisors">--</span>
                    </div>
                    <div class="session-info-row" id="quotaRow">
                        <i class="fas fa-chart-pie"></i>
                        <span id="sessionQuota">السقف المتبقي: --</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-warning" id="frozenWarning" style="display: none;">
            <i class="fas fa-snowflake" style="margin-left: 6px;"></i>
            <strong>تنبيه:</strong> هذا المريض محجوز مؤقتاً عندك بالفعل في هذا المقرر. يمكنك إلغاء الحجز السابق أولاً.
        </div>

        <div class="modal-buttons" style="margin-top: 20px;">
            <button onclick="closeTempReservationModal()" class="modal-btn cancel">إلغاء</button>
            <button onclick="confirmTempReservation()" class="modal-btn confirm purple" id="confirmTempBtn">
                <i class="fas fa-clock" style="margin-left: 6px;"></i>تأكيد الحجز المؤقت
            </button>
        </div>
    </div>
</div>

<!-- Modal عرض التفاصيل (للخاص/العام) -->
<div id="patientDetailsViewModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 500px; max-height: 80vh; overflow-y: auto;">
        <div class="modal-header-custom">
            <h3 class="modal-title">تفاصيل المريض</h3>
            <button onclick="closePatientDetailsViewModal()" class="close-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div id="patientDetailsViewContent" style="text-align: right; padding: 10px 0;">
            <!-- يتم ملؤها ديناميكياً -->
        </div>

        <!-- قسم السجل الطبي وتفاصيل الأسنان -->
        <div class="previous-treatments-section" style="margin-top: 20px; border-top: 2px solid #e5e7eb; padding-top: 16px;">
            <h4 style="font-size: 15px; color: #1f2937; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; font-weight: 800;">
                <i class="fas fa-file-medical" style="color: #6366f1;"></i>
                السجل الطبي وتفاصيل الأسنان
            </h4>
            <div id="previousTreatmentsList" style="display: flex; flex-direction: column; gap: 8px;">
                <!-- يتم ملؤها ديناميكياً بمخطط الأسنان + القلح + الحالة الصحية -->
            </div>
        </div>

        <!-- قسم صور البانوراما الشعاعية -->
        <div class="panorama-section" style="margin-top: 20px; border-top: 2px solid #e5e7eb; padding-top: 16px;">
            <h4 style="font-size: 15px; color: #1f2937; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; font-weight: 800;">
                <i class="fas fa-x-ray" style="color: #f59e0b;"></i>
                صور البانوراما الشعاعية
            </h4>
            <div id="panoramaImagesList" style="display: flex; flex-direction: column; gap: 10px;">
                <div style="text-align: center; padding: 20px; color: #9ca3af; font-size: 13px;">
                    <i class="fas fa-x-ray" style="font-size: 24px; margin-bottom: 8px; opacity: 0.3; display: block;"></i>
                    جاري التحميل...
                </div>
            </div>
        </div>

        <!-- زر المشاركة (للحالات الخاصة فقط) -->
        <div id="shareSection" style="display: none; margin-top: 20px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
            <button onclick="sharePatientWithOthers()" class="btn-share" style="width: 100%;">
                <i class="fas fa-share-alt"></i>
                مشاركة الحالة مع طلاب آخرين
            </button>
        </div>
    </div>
</div>

<!-- استدعاء CSS -->
<link rel="stylesheet" href="{{ asset('css/favo/favo-patient.css') }}">

<!-- استدعاء JavaScript -->
<script src="{{ asset('js/favo/favo-patient.js') }}"></script>

