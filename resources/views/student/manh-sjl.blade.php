
<div class="input-container">
    <div class="section-header outgoing">
        <h3 class="section-title outgoing">
            <i class="fas fa-paper-plane"></i>
            سجل الحالات الممنوحة (الصادرة)
        </h3>
    </div>
    
    <div class="table-wrapper">
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

<!-- قسم الحالات الواردة -->
<div class="input-container">
    <div class="section-header incoming">
        <h3 class="section-title incoming">
            <i class="fas fa-gift"></i>
            الحالات الممنوحة لي (الواردة)
        </h3>
    </div>
    
    <div class="table-wrapper">
        <table class="data-table">
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
    
    <div id="sessionTimeAlert" class="session-alert">
        <i class="fas fa-clock"></i>
        <strong>تنبيه:</strong> القبول متاح فقط خلال وقت جلستك (08:00 - 14:00). يمكنك الرفض مع كتابة السبب في أي وقت.
    </div>
</div>

<!-- Modal إلغاء المنح -->
<div id="cancelManhModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-icon danger">
            <i class="fas fa-ban"></i>
        </div>
        <h3 class="modal-title">إلغاء الحالة الممنوحة</h3>
        <p class="modal-description">سيتم إلغاء المنح وإعادة الحالة للقائمة المتاحة. يرجى توضيح سبب الإلغاء.</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">المريض:</span>
                <div id="cancelManhPatientName" class="info-value"></div>
            </div>
            <div class="info-row">
                <span class="info-label">رقم السن:</span>
                <div id="cancelManhToothNumber" class="info-value primary"></div>
            </div>
            <div class="info-row">
                <span class="info-label">الطالب المستلم:</span>
                <div id="cancelManhRecipient" class="info-value purple"></div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">
                سبب الإلغاء <span class="required">*</span>
            </label>
            <textarea id="cancelReasonText" class="form-textarea" placeholder="مثال: الطالب غير متواجد، خطأ في اختيار السن، الخ..."></textarea>
            <div id="cancelReasonError" class="error-message">
                <i class="fas fa-exclamation-circle"></i>الرجاء كتابة سبب الإلغاء
            </div>
        </div>
        
        <div class="modal-actions">
            <button onclick="closeCancelManhModal()" class="modal-btn secondary">إلغاء</button>
            <button onclick="confirmCancelManh()" class="modal-btn danger">
                <i class="fas fa-ban"></i>تأكيد الإلغاء
            </button>
        </div>
    </div>
</div>

<!-- Modal رفض الحالة -->
<div id="rejectReasonModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-icon danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <h3 class="modal-title">رفض الحالة الممنوحة</h3>
        <p class="modal-description">يرجى توضيح سبب الرفض لإبلاغ الطالب المانح</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">المريض:</span>
                <div id="rejectPatientName" class="info-value"></div>
            </div>
            <div class="info-row">
                <span class="info-label">رقم السن:</span>
                <div id="rejectToothNumber" class="info-value primary"></div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">
                سبب الرفض <span class="required">*</span>
            </label>
            <textarea id="rejectReasonText" class="form-textarea" placeholder="مثال: المريض غير متواجد، السن غير مناسب لخبرتي، الخ..."></textarea>
            <div id="rejectReasonError" class="error-message">
                <i class="fas fa-exclamation-circle"></i>الرجاء كتابة سبب الرفض
            </div>
        </div>
        
        <div class="modal-actions">
            <button onclick="closeRejectModal()" class="modal-btn secondary">إلغاء</button>
            <button onclick="confirmReject()" class="modal-btn danger">
                <i class="fas fa-times"></i>تأكيد الرفض
            </button>
        </div>
    </div>
</div>


<script src="{{ asset('js/student/explore/manh-tables.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/student/explore/manh-tables.css') }}">

