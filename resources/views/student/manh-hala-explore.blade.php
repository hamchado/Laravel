<!-- قسم الميزات والتعليمات -->
<div class="input-container guide-section">
    <div class="guide-header">
        <div class="guide-icon">
            <i class="fas fa-tooth"></i>
        </div>
        <h3 class="guide-title">دليل استخدام نظام الحجز والمنح</h3>
    </div>
    
    <div class="guide-grid">
        <div class="guide-item">
            <strong class="guide-item-title danger"><i class="fas fa-exclamation-triangle" style="margin-left: 4px;"></i>حد الجلسة الإجمالي (ترميمية 4)</strong>
            مسموح بـ <strong style="color: #dc2626; font-size: 14px;">حالتين فقط</strong> في الجلسة الواحدة بغض النظر عن المريض أو نوع الحالة. هذا الحد خاص بمقرر "مداواة الأسنان الترميمية 4" فقط.
        </div>
        
        <div class="guide-item success">
            <strong class="guide-item-title success"><i class="fas fa-infinity" style="margin-left: 4px;"></i>المنح مفتوح (غير محدود)</strong>
            يمكنك منح أي عدد من الحالات بدون حد، حتى لو استنفذت حالتيك في الجلسة. المنح لا يحسب ضمن حد الإضافة.
        </div>
        
        <div class="guide-item info">
            <strong class="guide-item-title info"><i class="fas fa-tooth" style="margin-left: 4px;"></i>منع التكرار حسب السن</strong>
            لا يمكن حجز نفس السن مرتين بنفس المعالجة. السن المحجوز يظهر كـ "محجوز" ولا يمكن اختياره.
        </div>
        
        <div class="guide-item warning">
            <strong class="guide-item-title warning"><i class="fas fa-undo" style="margin-left: 4px;"></i>إعادة الظهور</strong>
            السن المحجوز يعود للقائمة إذا: رفض المشرف الحالة، أو رُفض المنح وتم تجديده، أو أُلغي المنح قبل القبول.
        </div>
        
        <div class="guide-item purple">
            <strong class="guide-item-title purple"><i class="fas fa-gift" style="margin-left: 4px;"></i>المنح مخصص للترميمية</strong>
            يمكنك منح الحالات فقط لطلاب مقرر "مداواة الأسنان الترميمية 4" ويتم التحقق من تسجيلهم تلقائياً.
        </div>
        
        <div class="guide-item">
            <strong class="guide-item-title danger"><i class="fas fa-ban" style="margin-left: 4px;"></i>إلغاء المنح (قبل القبول)</strong>
            يمكنك إلغاء الحالة الممنوحة طالما لم يتم قبولها بعد. تُسجل كـ "ملغاة" في السجل مع السبب، وتعود للقائمة.
        </div>
    </div>
    
    <!-- تنبيه خاص بالحد الإجمالي -->
    <div class="session-alert">
        <i class="fas fa-info-circle session-alert-icon"></i>
        <div>
            <div class="session-alert-title">⚠️ تنبيه مهم حول حد الجلسة:</div>
            <div class="session-alert-text">
                • <strong>الحد الإجمالي لإضافة الحالات في الجلسة = حالتان فقط</strong> (للمقرر الترميمي 4).<br>
                • هذا الحد يشمل جميع الحالات بغض النظر عن المريض (أحمد أو سارة أو غيرهم).<br>
                • بمجرد إضافة حالتين، يتم قفل زر "إضافة حالة" ويصبح متاحاً فقط الـ "منح".<br>
                • <strong>المنح غير محدود:</strong> يمكنك منح 10 حالات أو أكثر حتى لو أضفت حالتيك.
            </div>
        </div>
    </div>
</div>

<!-- قسم إضافة حالة جديدة -->
<div class="tab-content" id="addCaseContent">
    <div class="section-title section-title-custom">
        <i class="fas fa-plus-circle"></i>
        <span>تسجيل حالة علاجية جديدة</span>
    </div>
    
    <!-- عداد الحالات المتبقية -->
    <div class="session-counter" id="sessionCounter">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="session-counter-icon">
                <i class="fas fa-calculator"></i>
            </div>
            <div>
                <div class="session-counter-title">عداد حالات الجلسة (ترميمية 4)</div>
                <div class="session-counter-subtitle">يتم احتساب جميع الحالات المضافة في هذه الجلسة</div>
            </div>
        </div>
        <div class="session-counter-value">
            <div class="session-counter-number">
                <span id="remainingCases">2</span><span style="font-size: 16px; color: #6b7280;">/2</span>
            </div>
            <div class="session-counter-label">متبقي من الحد الإجمالي</div>
        </div>
    </div>
    
    <!-- تنبيه الفترة التجريبية -->
    <div class="trial-alert">
        <i class="fas fa-info-circle trial-alert-icon"></i>
        <div>
            <div class="trial-alert-title">الفترة التجريبية</div>
            <div class="trial-alert-text">المريضان الظاهران أدناه هما بيانات وهمية للتوضيح فقط خلال هذه الفترة.</div>
        </div>
    </div>

    <!-- عرض المرضى المتاحين -->
    <div class="input-container" style="padding: 20px; margin-bottom: 20px;">
        <div class="patients-header">
            <h3 class="patients-title">
                <i class="fas fa-users" style="color: var(--primary); margin-left: 8px;"></i>
                المرضى المتاحين
            </h3>
            <span class="current-time-badge" id="currentTimeDisplay"></span>
        </div>
        
        <div class="patients-grid" id="availablePatientsGrid"></div>
    </div>

    <!-- تفاصيل المريض المختار -->
    <div class="input-container patient-details-section" id="patientDetailsSection">
        <div class="patient-details-header">
            <h3 class="patient-details-title">
                <i class="fas fa-user-injured" style="color: var(--primary); margin-left: 8px;"></i>
                تفاصيل المريض المختار
            </h3>
            <span class="selected-badge" id="selectedPatientBadge">تم الاختيار</span>
        </div>
        
        <div class="patient-details-content" id="patientDetailsContent"></div>

        <!-- اختيار نمط المعالجة -->
        <div class="treatment-section">
            <label class="treatment-label">
                <i class="fas fa-procedures" style="color: var(--primary); margin-left: 6px;"></i>
                نمط المعالجة المطلوب
                <span class="treatment-hint" id="treatmentTimeHint"></span>
            </label>
            <div class="treatment-dropdown" id="treatmentDropdown">
                <div class="treatment-dropdown-header" onclick="toggleTreatmentDropdown()">
                    <span id="selectedTreatmentText">اختر نمط المعالجة...</span>
                    <i class="fas fa-chevron-down treatment-dropdown-icon" id="treatmentDropdownIcon"></i>
                </div>
                <div class="treatment-dropdown-options" id="treatmentOptions"></div>
            </div>
            <div class="course-display" id="courseNameDisplay">
                <i class="fas fa-book" style="margin-left: 4px; color: var(--primary);"></i>
                المقرر: <span id="courseNameText" style="font-weight: 600; color: var(--dark);"></span>
                <span id="sessionLimitHint" style="color: #f59e0b; margin-right: 8px; font-size: 11px;"></span>
            </div>
        </div>

        <!-- عرض أرقام الأسنان -->
        <div class="teeth-section" id="teethSection">
            <div class="teeth-header">
                <label class="teeth-label">
                    <i class="fas fa-teeth" style="color: var(--primary); margin-left: 6px;"></i>
                    أرقام الأسنان المتاحة
                    <span class="teeth-hint">الأسنان المحجوزة تظهر كـ "محجوز" ولا يمكن اختيارها</span>
                </label>
                <span class="treatment-type-badge" id="treatmentTypeBadge"></span>
            </div>
            
            <div class="teeth-table-container">
                <table class="teeth-table">
                    <thead>
                        <tr>
                            <th>رقم السن</th>
                            <th>الفك</th>
                            <th>النوع</th>
                            <th>الحالة</th>
                            <th>اختيار</th>
                        </tr>
                    </thead>
                    <tbody id="teethTableBody"></tbody>
                </table>
            </div>
        </div>

        <!-- أزرار التحكم -->
        <div class="action-buttons">
            <button type="button" id="btnAddCase" onclick="addNewCase()" class="btn-add-case">
                <i class="fas fa-plus-circle"></i>
                إضافة حالة
                <span class="btn-badge" id="addCaseBadge">متاح</span>
            </button>
            <button type="button" onclick="showManhModal()" class="btn-manh">
                <i class="fas fa-gift"></i>
                منح حالة (بدون حد)
                <span class="btn-badge">∞</span>
            </button>
            <button type="button" onclick="resetCaseForm()" class="btn-reset">
                <i class="fas fa-undo"></i>
                إعادة تعيين
            </button>
        </div>
        
        <!-- تنبيه عند امتلاء الحد -->
        <div class="limit-alert" id="limitReachedAlert">
            <i class="fas fa-lock" style="margin-left: 6px;"></i>
            <strong>تم الوصول للحد الأقصى (2 حالة)</strong> - يمكنك فقط "منح الحالات" الآن.
        </div>
    </div>
</div>

<!-- قسم سجل الحالات الممنوحة (الصادرة) - أنا منحتها للآخرين -->
<div class="input-container outgoing-section">
    <div class="outgoing-header">
        <h3 class="outgoing-title">
            <i class="fas fa-paper-plane" style="color: #8b5cf6; margin-left: 8px;"></i>
            سجل الحالات الممنوحة (الصادرة)
        </h3>
    </div>
    
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>تاريخ/وقت المنح</th>
                    <th>المريض</th>
                    <th>رقم السن</th>
                    <th>نوع الحالة</th>
                    <th>المقرر</th>
                    <th>الطالب المستلم</th>
                    <th>الحالة</th>
                    <th>تاريخ الرد</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody id="outgoingManhTableBody"></tbody>
        </table>
    </div>
</div>

<!-- قسم الحالات الواردة (منحوها لي) -->
<div class="input-container incoming-section">
    <div class="incoming-header">
        <h3 class="incoming-title">
            <i class="fas fa-gift" style="color: #10b981; margin-left: 8px;"></i>
            الحالات الممنوحة لي (الواردة)
        </h3>
    </div>
    
    <div class="table-container">
        <table class="data-table" style="min-width: 900px;">
            <thead>
                <tr>
                    <th>تاريخ/وقت المنح</th>
                    <th>المريض</th>
                    <th>رقم السن</th>
                    <th>نوع الحالة</th>
                    <th>المقرر</th>
                    <th>المانح</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody id="incomingManhTableBody"></tbody>
        </table>
    </div>
    
    <!-- تنبيه وقت الجلسة -->
    <div class="session-time-alert" id="sessionTimeAlert">
        <i class="fas fa-clock" style="margin-left: 6px;"></i>
        <strong>تنبيه:</strong> القبول متاح فقط خلال وقت جلستك (08:00 - 14:00). يمكنك الرفض مع كتابة السبب في أي وقت.
    </div>
</div>

<!-- Modal إلغاء المنح (مع سبب) - قبل القبول -->
<div class="modal-overlay" id="cancelManhModal">
    <div class="modal-content">
        <div class="modal-icon danger">
            <i class="fas fa-ban"></i>
        </div>
        <h3 class="modal-title">إلغاء الحالة الممنوحة</h3>
        <p class="modal-text">سيتم إلغاء المنح وإعادة الحالة للقائمة المتاحة. يرجى توضيح سبب الإلغاء.</p>
        
        <div class="modal-info-box">
            <div class="modal-info-item">
                <span class="modal-info-label">المريض:</span>
                <div class="modal-info-value" id="cancelManhPatientName"></div>
            </div>
            <div class="modal-info-item">
                <span class="modal-info-label">رقم السن:</span>
                <div class="modal-info-value primary" id="cancelManhToothNumber"></div>
            </div>
            <div class="modal-info-item">
                <span class="modal-info-label">الطالب المستلم:</span>
                <div class="modal-info-value purple" id="cancelManhRecipient"></div>
            </div>
        </div>
        
        <div class="modal-input-group">
            <label class="modal-input-label">
                سبب الإلغاء <span class="required">*</span>
            </label>
            <textarea class="modal-textarea" id="cancelReasonText" placeholder="مثال: الطالب غير متواجد، خطأ في اختيار السن، الخ..."></textarea>
            <div class="modal-error" id="cancelReasonError">
                <i class="fas fa-exclamation-circle" style="margin-left: 4px;"></i>الرجاء كتابة سبب الإلغاء
            </div>
        </div>
        
        <div class="modal-buttons">
            <button onclick="closeCancelManhModal()" class="modal-btn cancel">إلغاء</button>
            <button onclick="confirmCancelManh()" class="modal-btn confirm">
                <i class="fas fa-ban" style="margin-left: 6px;"></i>تأكيد الإلغاء
            </button>
        </div>
    </div>
</div>

<!-- Modal رفض الحالة مع سبب -->
<div class="modal-overlay" id="rejectReasonModal">
    <div class="modal-content">
        <div class="modal-icon danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <h3 class="modal-title">رفض الحالة الممنوحة</h3>
        <p class="modal-text">يرجى توضيح سبب الرفض لإبلاغ الطالب المانح</p>
        
        <div class="modal-info-box">
            <div class="modal-info-item">
                <span class="modal-info-label">المريض:</span>
                <div class="modal-info-value" id="rejectPatientName"></div>
            </div>
            <div class="modal-info-item">
                <span class="modal-info-label">رقم السن:</span>
                <div class="modal-info-value primary" id="rejectToothNumber"></div>
            </div>
        </div>
        
        <div class="modal-input-group">
            <label class="modal-input-label">
                سبب الرفض <span class="required">*</span>
            </label>
            <textarea class="modal-textarea" id="rejectReasonText" placeholder="مثال: المريض غير متواجد، السن غير مناسب لخبرتي، الخ..."></textarea>
            <div class="modal-error" id="rejectReasonError">
                <i class="fas fa-exclamation-circle" style="margin-left: 4px;"></i>الرجاء كتابة سبب الرفض
            </div>
        </div>
        
        <div class="modal-buttons">
            <button onclick="closeRejectModal()" class="modal-btn cancel">إلغاء</button>
            <button onclick="confirmReject()" class="modal-btn confirm">
                <i class="fas fa-times" style="margin-left: 6px;"></i>تأكيد الرفض
            </button>
        </div>
    </div>
</div>

<!-- Modal تأكيد المنح -->
<div class="modal-overlay" id="manhModal">
    <div class="modal-content" style="max-width: 380px; text-align: center; padding: 20px;">
        <div class="modal-icon purple">
            <i class="fas fa-gift"></i>
        </div>
        <h3 class="modal-title" style="font-size: 17px;">تأكيد منح الحالة</h3>
        
        <div class="modal-warning">
            <i class="fas fa-exclamation-triangle" style="margin-left: 6px;"></i>
            <strong>تنبيه:</strong> يجب أن يكون الطالب مسجلاً في مقرر <span id="manhCourseCheck" style="font-weight: 700;"></span>
        </div>
        
        <div class="modal-success">
            <i class="fas fa-check-circle" style="margin-left: 6px;"></i>
            <strong>غير محدود:</strong> يمكنك منح أي عدد من الحالات حتى لو استنفذت حالتيك في الجلسة.
        </div>
        
        <div class="modal-info-box" style="text-align: right;">
            <div class="modal-info-item">
                <span class="modal-info-label">المريض:</span>
                <div class="modal-info-value" id="manhPatientName" style="font-size: 13px;"></div>
            </div>
            <div class="modal-info-item">
                <span class="modal-info-label">رقم السن:</span>
                <div class="modal-info-value primary" id="manhToothNumber" style="font-size: 13px;"></div>
            </div>
            <div class="modal-info-item">
                <span class="modal-info-label">نوع المعالجة:</span>
                <div class="modal-info-value" id="manhTreatment" style="font-size: 13px;"></div>
            </div>
            <div class="modal-info-item">
                <span class="modal-info-label">المقرر:</span>
                <div class="modal-info-value purple" id="manhCourseName" style="font-size: 13px;"></div>
            </div>
            <div class="modal-info-item">
                <span class="modal-info-label">رقم الجامعي (المستلم):</span>
                <div style="margin-top: 4px;">
                    <input type="text" class="modal-input" id="recipientStudentId" placeholder="مثال: 2 أو 2023002">
                </div>
                <div class="modal-input-hint">
                    <i class="fas fa-info-circle" style="margin-left: 4px;"></i>جرب رقم: 2 (طالب وهمي للاختبار)
                </div>
            </div>
        </div>
        
        <div class="modal-buttons">
            <button onclick="closeManhModal()" class="modal-btn cancel" style="padding: 10px; font-size: 13px;">إلغاء</button>
            <button onclick="confirmManh()" class="modal-btn confirm purple" style="padding: 10px; font-size: 13px;">تأكيد المنح</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/student/explore/ui.js') }}"></script>
<script src="{{ asset('js/student/explore/case-data.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/student/add-explore.css') }}">

