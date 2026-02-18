<!-- قسم سجل الحالات الممنوحة (الصادرة) -->
<div class="input-container manh-tables-container">
    <div class="section-header outgoing">
        <h3 class="section-title outgoing">
            <i class="fas fa-paper-plane"></i>
            سجل الحالات الممنوحة (الصادرة)
        </h3>
    </div>
    
    <div class="table-wrapper">
        <table class="data-table manh-table">
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
            <tbody id="outgoingManhTableBody">
                <!-- بيانات تجريبية - يمكن استبدالها بـ foreach من قاعدة البيانات -->
                <tr>
                    <td data-label="تاريخ/وقت المنح">2024-02-14 10:30</td>
                    <td data-label="المريض">أحمد محمد علي</td>
                    <td data-label="رقم السن"><span class="tooth-number">#14</span></td>
                    <td data-label="نوع الحالة">حشوة ترميمية</td>
                    <td data-label="المقرر">مداواة الأسنان الترميمية 4</td>
                    <td data-label="الطالب المستلم">خالد عبدالله</td>
                    <td data-label="الحالة"><span class="status-badge pending">بانتظار الرد</span></td>
                    <td data-label="تاريخ الرد">-</td>
                    <td data-label="إجراءات">
                        <button class="action-btn cancel" onclick="openCancelManhModal(1)" title="إلغاء المنح">
                            <i class="fas fa-ban"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td data-label="تاريخ/وقت المنح">2024-02-13 09:15</td>
                    <td data-label="المريض">سارة أحمد</td>
                    <td data-label="رقم السن"><span class="tooth-number">#21</span></td>
                    <td data-label="نوع الحالة">قلع سن</td>
                    <td data-label="المقرر">تخدير و قلع الأسنان 4</td>
                    <td data-label="الطالب المستلم">محمد خالد</td>
                    <td data-label="الحالة"><span class="status-badge accepted">مقبول</span></td>
                    <td data-label="تاريخ الرد">2024-02-13 09:20</td>
                    <td data-label="إجراءات">
                        <button class="action-btn cancel" onclick="openCancelManhModal(2)" title="إلغاء المنح">
                            <i class="fas fa-ban"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td data-label="تاريخ/وقت المنح">2024-02-12 14:30</td>
                    <td data-label="المريض">فاطمة حسن</td>
                    <td data-label="رقم السن"><span class="tooth-number">#36</span></td>
                    <td data-label="نوع الحالة">علاج جذور</td>
                    <td data-label="المقرر">مداواة الأسنان اللبية 4</td>
                    <td data-label="الطالب المستلم">عمر سمير</td>
                    <td data-label="الحالة"><span class="status-badge rejected">مرفوض</span></td>
                    <td data-label="تاريخ الرد">2024-02-12 15:00</td>
                    <td data-label="إجراءات">-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- قسم الحالات الواردة -->
<div class="input-container manh-tables-container">
    <div class="section-header incoming">
        <h3 class="section-title incoming">
            <i class="fas fa-gift"></i>
            الحالات الممنوحة لي (الواردة)
        </h3>
    </div>
    
    <div class="table-wrapper">
        <table class="data-table manh-table">
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
            <tbody id="incomingManhTableBody">
                <!-- بيانات تجريبية -->
                <tr>
                    <td data-label="تاريخ/وقت المنح">2024-02-14 11:00</td>
                    <td data-label="المريض">ليلى عبدالرحمن</td>
                    <td data-label="رقم السن"><span class="tooth-number">#16</span></td>
                    <td data-label="نوع الحالة">تنظيف جذور</td>
                    <td data-label="المقرر">النسج حول سنية 2</td>
                    <td data-label="المانح">أحمد سالم</td>
                    <td data-label="الحالة"><span class="status-badge pending">بانتظار الرد</span></td>
                    <td data-label="إجراءات">
                        <div class="action-buttons">
                            <button class="action-btn accept" onclick="acceptManh(1)" title="قبول">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="action-btn reject" onclick="openRejectModal(1)" title="رفض">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td data-label="تاريخ/وقت المنح">2024-02-13 10:30</td>
                    <td data-label="المريض">نور الدين</td>
                    <td data-label="رقم السن"><span class="tooth-number">#24</span></td>
                    <td data-label="نوع الحالة">حشوة تجميلية</td>
                    <td data-label="المقرر">مداواة الأسنان الترميمية 4</td>
                    <td data-label="المانح">محمد علي</td>
                    <td data-label="الحالة"><span class="status-badge accepted">مقبول</span></td>
                    <td data-label="إجراءات">-</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div id="sessionTimeAlert" class="session-alert">
        <i class="fas fa-clock"></i>
        <strong>تنبيه:</strong> القبول متاح فقط خلال وقت جلستك (08:00 - 14:00). يمكنك الرفض مع كتابة السبب في أي وقت.
    </div>
</div>

<!-- Modal إلغاء المنح -->
<div id="manhTblCancelModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-icon danger">
            <i class="fas fa-ban"></i>
        </div>
        <h3 class="modal-title">إلغاء الحالة الممنوحة</h3>
        <p class="modal-description">سيتم إلغاء المنح وإعادة الحالة للقائمة المتاحة. يرجى توضيح سبب الإلغاء.</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">المريض:</span>
                <div id="manhTblCancelPatientName" class="info-value"></div>
            </div>
            <div class="info-row">
                <span class="info-label">رقم السن:</span>
                <div id="manhTblCancelToothNumber" class="info-value primary"></div>
            </div>
            <div class="info-row">
                <span class="info-label">الطالب المستلم:</span>
                <div id="manhTblCancelRecipient" class="info-value purple"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">
                سبب الإلغاء <span class="required">*</span>
            </label>
            <textarea id="manhTblCancelReasonText" class="form-textarea" placeholder="مثال: الطالب غير متواجد، خطأ في اختيار السن، الخ..."></textarea>
            <div id="manhTblCancelReasonError" class="error-message">
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
<div id="manhTblRejectModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-icon danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <h3 class="modal-title">رفض الحالة الممنوحة</h3>
        <p class="modal-description">يرجى توضيح سبب الرفض لإبلاغ الطالب المانح</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">المريض:</span>
                <div id="manhTblRejectPatientName" class="info-value"></div>
            </div>
            <div class="info-row">
                <span class="info-label">رقم السن:</span>
                <div id="manhTblRejectToothNumber" class="info-value primary"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">
                سبب الرفض <span class="required">*</span>
            </label>
            <textarea id="manhTblRejectReasonText" class="form-textarea" placeholder="مثال: المريض غير متواجد، السن غير مناسب لخبرتي، الخ..."></textarea>
            <div id="manhTblRejectReasonError" class="error-message">
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

<link rel="stylesheet" href="{{ asset('css/student/explore/manh-tables.css') }}">
<script src="{{ asset('js/student/explore/manh-tables.js') }}"></script>

