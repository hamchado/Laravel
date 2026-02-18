const currentStudentId = '202312345';
const currentStudentSession = { start: '08:00', end: '14:00' };
const MAX_CASES_PER_SESSION = 2; // الحد الإجمالي للجلسة

// مصفوفات البيانات المشتركة
window.manhCases = window.manhCases || [];
window.globalReservations = window.globalReservations || [];
window.cancelledManhCases = window.cancelledManhCases || [];
let currentRejectId = null;
let currentCancelManhId = null;

// بيانات المرضى الوهمية
const mockPatients = [
    { id: 101, fullName: 'أحمد محمد العلي', phone: '0935123456', birthDate: '1990-05-15', condition: 'مضبوطة', tissues: 'سليمة', address: 'دمشق - المزة', sessionStart: '00:00', sessionEnd: '23:59', sharedWith: [202398765, 202398766] },
    { id: 102, fullName: 'سارة خالد النجار', phone: '0987654321', birthDate: '1985-08-20', condition: 'غير مضبوطة', tissues: 'تهيج خفيف', address: 'دمشق - المالكي', sessionStart: '00:00', sessionEnd: '23:59', sharedWith: [] }
];

// قاعدة بيانات الطلاب (تمت إضافة طالب برقم 2)
const studentsDatabase = {
    '2': { name: 'طالب تجريبي', courses: ['restorative4'] }, // طالب وهمي للاختبار
    '2023002': { name: 'طالب تجريبي 2', courses: ['restorative4'] },
    '202398765': { name: 'خالد العمر', courses: ['restorative4'] },
    '202398766': { name: 'محمد سليم', courses: ['restorative4', 'exodontia4'] },
    '202398767': { name: 'علي حسن', courses: ['restorative2', 'restorative4'] },
    '202398768': { name: 'فادي يوسف', courses: ['restorative4'] },
    '202312345': { name: 'أنا', courses: ['restorative4', 'exodontia4'] }
};

// أنواع المعالجات (محدثة - فقط ترميمية 4 للاختبار)
const treatmentSchedule = {
    restorative4: [
        { value: 'class2', label: 'كلاس 2', icon: 'fa-tooth', color: '#8b5cf6', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative4', timeSlots: ['all'] },
        { value: 'class3', label: 'كلاس 3', icon: 'fa-tooth', color: '#ec4899', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative4', timeSlots: ['all'] },
        { value: 'class4', label: 'كلاس 4', icon: 'fa-tooth', color: '#f59e0b', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative4', timeSlots: ['all'] },
        { value: 'class5', label: 'كلاس 5', icon: 'fa-tooth', color: '#10b981', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative4', timeSlots: ['all'] }
    ]
};

// متغيرات مؤقتة
let tempManhData = { patient: null, treatment: null, tooth: null };
let selectedPatient = null;
let selectedTreatment = null;
let selectedTooth = null;
let currentTime = '';

// ========== localStorage Integration ==========
function saveToLocalStorage() {
    try {
        localStorage.setItem('dental_reservations', JSON.stringify(window.globalReservations));
        localStorage.setItem('dental_manh_cases', JSON.stringify(window.manhCases));
        localStorage.setItem('dental_cancelled_cases', JSON.stringify(window.cancelledManhCases));
        localStorage.setItem('dental_last_update', new Date().toISOString());
        
        // إعلام الكود الأول بالتحديث (dispatch event للتواصل بين الملفين)
        window.dispatchEvent(new StorageEvent('storage', {
            key: 'dental_reservations',
            newValue: JSON.stringify(window.globalReservations)
        }));
    } catch (e) {
        console.warn('localStorage not available:', e);
    }
}

function loadFromLocalStorage() {
    try {
        const savedReservations = localStorage.getItem('dental_reservations');
        const savedManhCases = localStorage.getItem('dental_manh_cases');
        const savedCancelled = localStorage.getItem('dental_cancelled_cases');
        
        if (savedReservations) window.globalReservations = JSON.parse(savedReservations);
        if (savedManhCases) window.manhCases = JSON.parse(savedManhCases);
        if (savedCancelled) window.cancelledManhCases = JSON.parse(savedCancelled);
        
        if (window.manhCases.length === 0) initDemoData();
    } catch (e) {
        console.warn('localStorage load error:', e);
        initDemoData();
    }
}

// ========== تهيئة البيانات الوهمية ==========
function initDemoData() {
    const today = new Date().toISOString().split('T')[0];
    
    // إضافة حالتين صادرتان (أنا منحتها)
    window.manhCases.push({
        id: 'out_1',
        originalCaseId: 101,
        patientName: 'أحمد محمد العلي',
        toothNumber: '36',
        treatmentType: 'كلاس 2',
        treatmentValue: 'class2',
        course: 'مداواة الأسنان الترميمية 4',
        courseId: 'restorative4',
        fromStudentId: currentStudentId,
        toStudentId: '2', // منحت للطالب رقم 2
        manhDate: today,
        manhTime: '10:30',
        status: 'pending',
        responseDate: null,
        responseTime: null,
        rejectReason: null,
        cancelledReason: null
    });
    
    saveToLocalStorage();
}

// ========== دوال مساعدة ==========
// حساب عدد الحالات المضافة في الجلسة الحالية (للترميمية 4 فقط)
function getSessionCasesCount() {
    // نحسب فقط الحالات العادية (type: normal) وليست المنح
    return window.globalReservations.filter(r => 
        r.type === 'normal' && 
        r.byStudent === currentStudentId &&
        r.courseId === 'restorative4' &&
        !['rejected', 'cancelled', 'deleted'].includes(r.status)
    ).length;
}

// التحقق من إمكانية إضافة حالة جديدة (الحد الإجمالي 2)
function canAddNewCase() {
    const currentCount = getSessionCasesCount();
    return {
        canAdd: currentCount < MAX_CASES_PER_SESSION,
        currentCount: currentCount,
        remaining: MAX_CASES_PER_SESSION - currentCount,
        max: MAX_CASES_PER_SESSION
    };
}

// تحديث عداد الواجهة
function updateSessionCounter() {
    const counter = document.getElementById('remainingCases');
    const btnAdd = document.getElementById('btnAddCase');
    const badge = document.getElementById('addCaseBadge');
    const alert = document.getElementById('limitReachedAlert');
    
    if (!counter) return;
    
    const status = canAddNewCase();
    counter.textContent = status.remaining;
    
    // تغيير لون العداد حسب الحالة
    const counterDiv = document.getElementById('sessionCounter');
    if (status.remaining === 0) {
        counter.style.color = '#dc2626';
        if (counterDiv) counterDiv.style.borderColor = '#dc2626';
        if (alert) alert.style.display = 'block';
        
        // تعطيل زر الإضافة
        if (btnAdd) {
            btnAdd.disabled = true;
            btnAdd.style.opacity = '0.5';
            btnAdd.style.cursor = 'not-allowed';
            btnAdd.style.background = '#9ca3af';
        }
        if (badge) {
            badge.textContent = 'مغلق';
            badge.style.background = '#dc2626';
        }
    } else {
        counter.style.color = '#059669';
        if (counterDiv) counterDiv.style.borderColor = '#10b981';
        if (alert) alert.style.display = 'none';
        
        // تفعيل زر الإضافة
        if (btnAdd) {
            btnAdd.disabled = false;
            btnAdd.style.opacity = '1';
            btnAdd.style.cursor = 'pointer';
            btnAdd.style.background = '';
        }
        if (badge) {
            badge.textContent = `متاح (${status.remaining})`;
            badge.style.background = 'rgba(255,255,255,0.3)';
        }
    }
}

function getTreatmentDetails(treatmentValue) {
    return treatmentSchedule.restorative4.find(t => t.value === treatmentValue) || null;
}

// التحقق مما إذا كان السن محجوزاً أو مجمداً
function isToothFrozenOrReserved(patientId, toothNumber, treatmentValue, excludeManhId = null) {
    const reserved = window.globalReservations.some(r => 
        r.patientId === patientId && 
        r.toothNumber === toothNumber && 
        r.treatmentValue === treatmentValue &&
        !['rejected', 'cancelled', 'deleted'].includes(r.status)
    );
    
    if (reserved) return { frozen: true, reason: 'محجوز' };
    
    const pendingManh = window.manhCases.find(m => 
        m.originalCaseId === patientId && 
        m.toothNumber === toothNumber && 
        m.treatmentValue === treatmentValue &&
        m.status === 'pending' &&
        m.id !== excludeManhId
    );
    
    if (pendingManh) {
        return { 
            frozen: true, 
            reason: 'منحوة لـ ' + pendingManh.toStudentId,
            manhId: pendingManh.id
        };
    }
    
    return { frozen: false };
}

function checkStudentCourseEligibility(studentId, courseId) {
    const student = studentsDatabase[studentId];
    if (!student) return { eligible: false, reason: 'رقم الطالب غير موجود في النظام' };
    if (!student.courses.includes(courseId)) return { eligible: false, reason: 'الطالب غير مسجل في هذا المقرر' };
    return { eligible: true, studentName: student.name };
}

function updateCurrentTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    currentTime = `${hours}:${minutes}`;
    const display = document.getElementById('currentTimeDisplay');
    if (display) display.textContent = currentTime;
}

function isInSessionTime() {
    const now = new Date();
    const currentTime = `${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}`;
    const [currH, currM] = currentTime.split(':').map(Number);
    const [startH, startM] = currentStudentSession.start.split(':').map(Number);
    const [endH, endM] = currentStudentSession.end.split(':').map(Number);
    
    const currMinutes = currH * 60 + currM;
    const startMinutes = startH * 60 + startM;
    const endMinutes = endH * 60 + endM;
    
    return currMinutes >= startMinutes && currMinutes <= endMinutes;
}

function calculateAge(birthDate) {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) age--;
    return age;
}

// ========== تحميل المرضى ==========
function loadAvailablePatients() {
    const grid = document.getElementById('availablePatientsGrid');
    if (!grid) return;
    grid.innerHTML = '';
    
    mockPatients.forEach((patient, index) => {
        const card = document.createElement('div');
        card.className = 'patient-card-compact';
        card.id = `patient-card-${patient.id}`;
        card.style.animation = `fadeIn 0.3s ease forwards ${index * 0.1}s`;
        card.onclick = () => selectPatient(patient.id, card);
        
        const age = calculateAge(patient.birthDate);
        
        const hasActiveReservations = window.globalReservations.some(r => 
            r.patientId === patient.id && 
            !['rejected', 'cancelled', 'deleted'].includes(r.status)
        );
        
        const hasPendingManh = window.manhCases.some(m => 
            m.originalCaseId === patient.id && 
            m.status === 'pending'
        );
        
        let statusBadge = '';
        if (hasPendingManh) {
            statusBadge = '<span class="patient-status-badge" style="background: #fce7f3; color: #be185d;">حالة معلقة</span>';
        } else if (hasActiveReservations) {
            statusBadge = '<span class="patient-status-badge active">به حجوزات</span>';
        } else {
            statusBadge = '<span class="patient-status-badge available">متاح</span>';
        }
        
        card.innerHTML = `
            <input type="radio" name="patientSelect" class="select-radio-compact" value="${patient.id}" onchange="event.stopPropagation()">
            <div class="patient-card-header-compact">
                <div class="patient-name-compact">${patient.fullName}</div>
                ${statusBadge}
            </div>
            <div class="patient-info-compact">
                <div class="patient-info-item-compact"><i class="fas fa-phone"></i><span>${patient.phone}</span></div>
                <div class="patient-info-item-compact"><i class="fas fa-birthday-cake"></i><span>${age} سنة</span></div>
                <div class="patient-info-item-compact"><i class="fas fa-heartbeat"></i><span style="color: ${patient.condition === 'مضبوطة' ? '#10b981' : '#ef4444'}">${patient.condition}</span></div>
            </div>
            <button class="details-btn-compact" onclick="event.stopPropagation(); selectPatient(${patient.id}, document.getElementById('patient-card-${patient.id}'))">
                <i class="fas fa-eye" style="margin-left: 4px;"></i>عرض التفاصيل
            </button>
        `;
        
        grid.appendChild(card);
    });
}

function selectPatient(patientId, cardElement) {
    selectedPatient = mockPatients.find(p => p.id === patientId);
    document.querySelectorAll('.patient-card-compact').forEach(c => c.classList.remove('selected'));
    cardElement.classList.add('selected');
    cardElement.querySelector('input[type="radio"]').checked = true;
    
    const detailsSection = document.getElementById('patientDetailsSection');
    if (detailsSection) {
        detailsSection.style.display = 'block';
        detailsSection.scrollIntoView({ behavior: 'smooth' });
        updatePatientDetails();
        loadTreatmentOptions();
    }
}

function updatePatientDetails() {
    if (!selectedPatient) return;
    const age = calculateAge(selectedPatient.birthDate);
    const content = document.getElementById('patientDetailsContent');
    if (content) {
        content.innerHTML = `
            <div class="detail-box-compact">
                <div class="detail-label-compact"><i class="fas fa-user" style="margin-left: 4px;"></i> الاسم</div>
                <div class="detail-value-compact">${selectedPatient.fullName}</div>
            </div>
            <div class="detail-box-compact">
                <div class="detail-label-compact"><i class="fas fa-phone" style="margin-left: 4px;"></i> الهاتف</div>
                <div class="detail-value-compact" style="direction: ltr; font-size: 12px;">${selectedPatient.phone}</div>
            </div>
            <div class="detail-box-compact">
                <div class="detail-label-compact"><i class="fas fa-map-marker-alt" style="margin-left: 4px;"></i> العنوان</div>
                <div class="detail-value-compact" style="font-size: 12px;">${selectedPatient.address}</div>
            </div>
            <div class="detail-box-compact">
                <div class="detail-label-compact"><i class="fas fa-calendar" style="margin-left: 4px;"></i> العمر</div>
                <div class="detail-value-compact">${age} سنة</div>
            </div>
            <div class="detail-box-compact" style="border-color: ${selectedPatient.condition === 'مضبوطة' ? '#10b981' : '#ef4444'};">
                <div class="detail-label-compact"><i class="fas fa-heartbeat" style="margin-left: 4px;"></i> الحالة الصحية</div>
                <div class="detail-value-compact" style="color: ${selectedPatient.condition === 'مضبوطة' ? '#10b981' : '#ef4444'}; font-size: 12px;">${selectedPatient.condition}</div>
            </div>
            <div class="detail-box-compact">
                <div class="detail-label-compact"><i class="fas fa-layer-group" style="margin-left: 4px;"></i> الأنسجة</div>
                <div class="detail-value-compact" style="font-size: 12px;">${selectedPatient.tissues}</div>
            </div>
        `;
    }
}

// ========== المعالجات ==========
function loadTreatmentOptions() {
    const container = document.getElementById('treatmentOptions');
    const hint = document.getElementById('treatmentTimeHint');
    if (!container || !hint) return;
    container.innerHTML = '';
    
    // عرض جميع خيارات الترميمية 4
    const treatments = treatmentSchedule.restorative4;
    const status = canAddNewCase();
    
    hint.innerHTML = `<i class="fas fa-info-circle" style="margin-left: 4px;"></i> الحد الإجمالي للجلسة: ${status.currentCount}/${MAX_CASES_PER_SESSION} حالة`;
    
    if (selectedPatient) {
        treatments.forEach(treatment => {
            const div = document.createElement('div');
            div.className = 'dropdown-option-simple';
            
            // إظهار عداد الحالات في كل خيار
            div.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fas ${treatment.icon}" style="color: ${treatment.color}; margin-left: 8px;"></i>${treatment.label}</span>
                </div>
                <div style="font-size: 10px; color: #6b7280; margin-right: 24px; margin-top: 2px;">
                    ${treatment.course}
                </div>
            `;
            
            div.onclick = () => selectTreatment(treatment);
            container.appendChild(div);
        });
    }
}

function toggleTreatmentDropdown() {
    const options = document.getElementById('treatmentOptions');
    const icon = document.getElementById('treatmentDropdownIcon');
    if (!options || !icon) return;
    
    if (options.style.display === 'none' || options.style.display === '') {
        loadTreatmentOptions();
        options.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
    } else {
        options.style.display = 'none';
        icon.style.transform = 'rotate(0)';
    }
}

function selectTreatment(treatment) {
    selectedTreatment = treatment;
    const selectedText = document.getElementById('selectedTreatmentText');
    const courseDisplay = document.getElementById('courseNameDisplay');
    const courseText = document.getElementById('courseNameText');
    const options = document.getElementById('treatmentOptions');
    const icon = document.getElementById('treatmentDropdownIcon');
    
    if (selectedText) selectedText.innerHTML = `<i class="fas ${treatment.icon}" style="color: ${treatment.color}; margin-left: 8px;"></i>${treatment.label}`;
    if (options) options.style.display = 'none';
    if (icon) icon.style.transform = 'rotate(0)';
    
    if (courseDisplay) courseDisplay.style.display = 'block';
    if (courseText) courseText.textContent = treatment.course;
    
    showTeethForTreatment(treatment.value, treatment.label);
}

// ========== الأسنان ==========
function showTeethForTreatment(treatmentValue, treatmentLabel) {
    const section = document.getElementById('teethSection');
    const tableBody = document.getElementById('teethTableBody');
    const badge = document.getElementById('treatmentTypeBadge');
    
    if (!section || !tableBody) return;
    
    section.style.display = 'block';
    tableBody.innerHTML = '';
    if (badge) {
        badge.textContent = treatmentLabel;
        badge.style.background = selectedTreatment ? selectedTreatment.color : 'var(--primary)';
    }
    
    // أسنان تجريبية للترميمية
    const teeth = [
        { number: '16', jaw: 'علوي', type: 'رحى' },
        { number: '26', jaw: 'علوي', type: 'رحى' },
        { number: '36', jaw: 'سفلي', type: 'رحى' },
        { number: '46', jaw: 'سفلي', type: 'رحى' },
        { number: '11', jaw: 'علوي', type: 'قاطع' },
        { number: '21', jaw: 'علوي', type: 'قاطع' }
    ];
    
    let availableCount = 0;
    
    teeth.forEach(tooth => {
        const check = isToothFrozenOrReserved(selectedPatient.id, tooth.number, treatmentValue);
        
        if (check.frozen) {
            const row = document.createElement('tr');
            row.style.borderBottom = '1px solid #f3f4f6';
            row.style.background = '#f9fafb';
            row.style.opacity = '0.6';
            
            row.innerHTML = `
                <td style="padding: 10px; text-align: center; font-weight: 700; color: #9ca3af;">${tooth.number}</td>
                <td style="padding: 10px; text-align: center; font-size: 12px; color: #9ca3af;">${tooth.jaw}</td>
                <td style="padding: 10px; text-align: center; font-size: 12px; color: #9ca3af;">${tooth.type}</td>
                <td style="padding: 10px; text-align: center;">
                    <span style="background: #fce7f3; color: #be185d; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 600;">${check.reason}</span>
                </td>
                <td style="padding: 10px; text-align: center;">
                    <i class="fas fa-lock" style="color: #9ca3af;"></i>
                </td>
            `;
            tableBody.appendChild(row);
        } else {
            availableCount++;
            const row = document.createElement('tr');
            row.style.borderBottom = '1px solid #f3f4f6';
            
            row.innerHTML = `
                <td style="padding: 10px; text-align: center; font-weight: 700; color: var(--primary);">${tooth.number}</td>
                <td style="padding: 10px; text-align: center; font-size: 12px;">${tooth.jaw}</td>
                <td style="padding: 10px; text-align: center; font-size: 12px;">${tooth.type}</td>
                <td style="padding: 10px; text-align: center;">
                    <span style="background: #d1fae5; color: #10b981; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 600;">متاح</span>
                </td>
                <td style="padding: 10px; text-align: center;">
                    <input type="radio" name="toothSelect" value="${tooth.number}" onchange="selectedTooth = '${tooth.number}'" style="width: 18px; height: 18px; accent-color: var(--primary); cursor: pointer;">
                </td>
            `;
            tableBody.appendChild(row);
        }
    });
    
    if (availableCount === 0) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td colspan="5" style="padding: 20px; text-align: center; color: #9ca3af; font-size: 13px;">
                <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
                جميع أسنان هذا المريض محجوزة أو مجمدة
            </td>
        `;
        tableBody.appendChild(row);
    }
    
    section.scrollIntoView({ behavior: 'smooth' });
}

// ========== إضافة الحالة ==========
function addNewCase() {
    if (!selectedPatient || !selectedTreatment || !selectedTooth) {
        showToast('الرجاء اختيار جميع البيانات', 'error');
        return;
    }
    
    // التحقق من الحد الإجمالي للجلسة
    const status = canAddNewCase();
    if (!status.canAdd) {
        showToast(`عذراً، لقد وصلت للحد الأقصى (${MAX_CASES_PER_SESSION} حالة في الجلسة). استخدم "منح الحالة" للإضافي.`, 'error');
        return;
    }
    
    const check = isToothFrozenOrReserved(selectedPatient.id, selectedTooth, selectedTreatment.value);
    if (check.frozen) {
        showToast('عذراً، ' + check.reason, 'error');
        return;
    }
    
    window.globalReservations.push({
        patientId: selectedPatient.id,
        toothNumber: selectedTooth,
        treatmentValue: selectedTreatment.value,
        courseId: 'restorative4', // مهم للحد
        status: 'reserved',
        byStudent: currentStudentId,
        date: new Date().toISOString().split('T')[0],
        type: 'normal'
    });
    
    saveToLocalStorage();
    updateSessionCounter();
    showToast(`تم إضافة الحالة بنجاح! (${status.remaining - 1} متبقي من ${MAX_CASES_PER_SESSION})`, 'success');
    showTeethForTreatment(selectedTreatment.value, selectedTreatment.label);
    selectedTooth = null;
    document.querySelectorAll('input[name="toothSelect"]').forEach(r => r.checked = false);
}

// ========== تحميل جداول المنح ==========
function loadAllManhTables() {
    loadOutgoingTable();
    loadIncomingTable();
}

function loadOutgoingTable() {
    const tbody = document.getElementById('outgoingManhTableBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    const outgoing = window.manhCases.filter(m => m.fromStudentId === currentStudentId);
    
    if (outgoing.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 30px; color: #9ca3af;">لا توجد حالات ممنوحة</td></tr>';
        return;
    }
    
    outgoing.forEach(manh => {
        const row = document.createElement('tr');
        row.style.borderBottom = '1px solid #f3f4f6';
        
        let statusHtml = '';
        let actionsHtml = '';
        
        if (manh.status === 'pending') {
            statusHtml = '<span class="status-badge manh-pending"><i class="fas fa-clock" style="margin-left: 4px;"></i>بانتظار الرد</span>';
            actionsHtml = `
                <button class="action-btn cancel" onclick="openCancelManhModal('${manh.id}')" title="إلغاء المنح">
                    <i class="fas fa-ban" style="margin-left: 4px;"></i>إلغاء
                </button>
            `;
        } else if (manh.status === 'accepted') {
            statusHtml = '<span class="status-badge manh-accepted"><i class="fas fa-check" style="margin-left: 4px;"></i>مقبولة</span>';
            actionsHtml = '<span style="color: #059669; font-size: 12px;"><i class="fas fa-check-double" style="margin-left: 4px;"></i>تم التسليم</span>';
        } else if (manh.status === 'rejected') {
            statusHtml = '<span class="status-badge manh-rejected"><i class="fas fa-times" style="margin-left: 4px;"></i>مرفوضة</span>';
            actionsHtml = `<div class="reason-text"><strong>سبب الرفض:</strong> ${manh.rejectReason}</div>`;
        } else if (manh.status === 'cancelled') {
            statusHtml = '<span class="status-badge manh-cancelled"><i class="fas fa-ban" style="margin-left: 4px;"></i>ملغاة</span>';
            actionsHtml = `<div class="cancelled-info"><strong>سبب الإلغاء:</strong> ${manh.cancelledReason}</div>`;
        }
        
        row.innerHTML = `
            <td style="padding: 12px; text-align: center; font-size: 12px;">
                <div style="direction: ltr; font-weight: 600;">${manh.manhDate}</div>
                <div style="color: #6b7280; font-size: 11px; direction: ltr;">${manh.manhTime}</div>
            </td>
            <td style="padding: 12px; text-align: center; font-weight: 600;">${manh.patientName}</td>
            <td style="padding: 12px; text-align: center; color: #7c3aed; font-weight: 700; font-size: 14px;">${manh.toothNumber}</td>
            <td style="padding: 12px; text-align: center; font-size: 12px;">${manh.treatmentType}</td>
            <td style="padding: 12px; text-align: center; font-size: 11px; color: #6b7280;">${manh.course}</td>
            <td style="padding: 12px; text-align: center; direction: ltr; font-weight: 600;">${manh.toStudentId}</td>
            <td style="padding: 12px; text-align: center;">${statusHtml}</td>
            <td style="padding: 12px; text-align: center; color: #6b7280; font-size: 12px;">
                ${manh.responseDate ? `<div>${manh.responseDate}</div><div style="font-size: 11px;">${manh.responseTime}</div>` : '-'}
            </td>
            <td style="padding: 12px; text-align: center;">${actionsHtml}</td>
        `;
        
        tbody.appendChild(row);
    });
}

function loadIncomingTable() {
    const tbody = document.getElementById('incomingManhTableBody');
    const alertBox = document.getElementById('sessionTimeAlert');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    const incoming = window.manhCases.filter(m => m.toStudentId === currentStudentId);
    const inSession = isInSessionTime();
    
    if (incoming.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 30px; color: #9ca3af;">لا توجد حالات ممنوحة لك</td></tr>';
        if (alertBox) alertBox.style.display = 'none';
        return;
    }
    
    const hasPending = incoming.some(m => m.status === 'pending');
    if (alertBox) alertBox.style.display = (hasPending && !inSession) ? 'block' : 'none';
    
    incoming.forEach(manh => {
        const row = document.createElement('tr');
        row.style.borderBottom = '1px solid #f3f4f6';
        
        if (manh.status === 'pending') row.classList.add('incoming-row-new');
        
        let statusHtml = '';
        let actionsHtml = '';
        
        if (manh.status === 'pending') {
            statusHtml = '<span class="status-badge manh-pending">جديدة</span>';
            
            const acceptBtn = inSession ? 
                `<button class="action-btn accept" onclick="acceptIncomingManh('${manh.id}')" style="margin-bottom: 4px;">
                    <i class="fas fa-check" style="margin-left: 4px;"></i>قبول
                 </button>` :
                `<button class="action-btn" disabled style="margin-bottom: 4px; opacity: 0.5; cursor: not-allowed; background: #9ca3af; color: white;">
                    <i class="fas fa-lock" style="margin-left: 4px;"></i>القبول مغلق
                 </button>`;
            
            const rejectBtn = `<button class="action-btn reject" onclick="openRejectModal('${manh.id}')">
                    <i class="fas fa-times" style="margin-left: 4px;"></i>رفض
                 </button>`;
            
            actionsHtml = acceptBtn + rejectBtn;
            
        } else if (manh.status === 'accepted') {
            statusHtml = '<span class="status-badge manh-accepted"><i class="fas fa-check" style="margin-left: 4px;"></i>مقبولة</span>';
            actionsHtml = `
                <div class="accepted-info">
                    <i class="fas fa-folder-open" style="margin-left: 4px;"></i>
                    <strong>في سجلك</strong><br>
                    <small>يمكنك العمل عليها كحالتك الخاصة</small>
                </div>
            `;
            
        } else if (manh.status === 'rejected') {
            statusHtml = '<span class="status-badge manh-rejected"><i class="fas fa-times" style="margin-left: 4px;"></i>مرفوضة</span>';
            actionsHtml = `<div class="reason-text"><strong>السبب:</strong> ${manh.rejectReason}</div>`;
        }
        
        row.innerHTML = `
            <td style="padding: 12px; text-align: center; font-size: 12px;">
                <div style="direction: ltr; font-weight: 600;">${manh.manhDate}</div>
                <div style="color: #6b7280; font-size: 11px; direction: ltr;">${manh.manhTime}</div>
            </td>
            <td style="padding: 12px; text-align: center; font-weight: 600;">${manh.patientName}</td>
            <td style="padding: 12px; text-align: center; color: #7c3aed; font-weight: 700; font-size: 14px;">${manh.toothNumber}</td>
            <td style="padding: 12px; text-align: center; font-size: 12px;">${manh.treatmentType}</td>
            <td style="padding: 12px; text-align: center; font-size: 11px; color: #6b7280;">${manh.course}</td>
            <td style="padding: 12px; text-align: center; direction: ltr; font-weight: 600;">${manh.fromStudentId}</td>
            <td style="padding: 12px; text-align: center;">${statusHtml}</td>
            <td style="padding: 12px; text-align: center;">${actionsHtml}</td>
        `;
        
        tbody.appendChild(row);
    });
}

// ========== إلغاء المنح ==========
function openCancelManhModal(manhId) {
    currentCancelManhId = manhId;
    const manh = window.manhCases.find(m => m.id === manhId);
    if (!manh) return;
    
    document.getElementById('cancelManhPatientName').textContent = manh.patientName;
    document.getElementById('cancelManhToothNumber').textContent = manh.toothNumber;
    document.getElementById('cancelManhRecipient').textContent = manh.toStudentId;
    document.getElementById('cancelReasonText').value = '';
    document.getElementById('cancelReasonError').style.display = 'none';
    document.getElementById('cancelManhModal').style.display = 'block';
}

function closeCancelManhModal() {
    document.getElementById('cancelManhModal').style.display = 'none';
    currentCancelManhId = null;
}

function confirmCancelManh() {
    const reason = document.getElementById('cancelReasonText').value.trim();
    if (!reason) {
        document.getElementById('cancelReasonError').style.display = 'block';
        return;
    }
    
    const manh = window.manhCases.find(m => m.id === currentCancelManhId);
    if (!manh) return;
    
    const now = new Date();
    manh.status = 'cancelled';
    manh.cancelledDate = now.toISOString().split('T')[0];
    manh.cancelledTime = now.toLocaleTimeString('ar-SA', {hour: '2-digit', minute:'2-digit'});
    manh.cancelledReason = reason;
    
    const reservationIndex = window.globalReservations.findIndex(r => 
        r.patientId === manh.originalCaseId && 
        r.toothNumber === manh.toothNumber && 
        r.treatmentValue === manh.treatmentValue &&
        r.type === 'manh'
    );
    
    if (reservationIndex > -1) {
        window.globalReservations[reservationIndex].status = 'cancelled';
        window.globalReservations[reservationIndex].cancelledReason = reason;
    }
    
    window.cancelledManhCases.push({ ...manh, cancelledAt: new Date().toISOString() });
    
    saveToLocalStorage();
    closeCancelManhModal();
    showToast('تم إلغاء الحالة الممنوحة وإعادة السن للقائمة', 'success');
    loadAllManhTables();
    
    if (selectedPatient && selectedTreatment) {
        showTeethForTreatment(selectedTreatment.value, selectedTreatment.label);
    }
}

// ========== قبول/رفض ==========
function acceptIncomingManh(manhId) {
    if (!isInSessionTime()) {
        showToast('القبول متاح فقط خلال وقت الجلسة (08:00 - 14:00)', 'error');
        return;
    }
    
    const manh = window.manhCases.find(m => m.id === manhId);
    if (!manh) return;
    
    const now = new Date();
    manh.status = 'accepted';
    manh.responseDate = now.toISOString().split('T')[0];
    manh.responseTime = now.toLocaleTimeString('ar-SA', {hour: '2-digit', minute:'2-digit'});
    
    const reservation = window.globalReservations.find(r => 
        r.patientId === manh.originalCaseId && 
        r.toothNumber === manh.toothNumber && 
        r.treatmentValue === manh.treatmentValue
    );
    if (reservation) {
        reservation.status = 'accepted';
        reservation.byStudent = currentStudentId;
        reservation.type = 'normal';
    }
    
    saveToLocalStorage();
    showToast('تم قبول الحالة بنجاح! أصبحت في سجلك', 'success');
    loadAllManhTables();
}

function openRejectModal(manhId) {
    currentRejectId = manhId;
    const manh = window.manhCases.find(m => m.id === manhId);
    if (!manh) return;
    
    document.getElementById('rejectPatientName').textContent = manh.patientName;
    document.getElementById('rejectToothNumber').textContent = manh.toothNumber;
    document.getElementById('rejectReasonText').value = '';
    document.getElementById('rejectReasonError').style.display = 'none';
    document.getElementById('rejectReasonModal').style.display = 'block';
}

function closeRejectModal() {
    document.getElementById('rejectReasonModal').style.display = 'none';
    currentRejectId = null;
}

function confirmReject() {
    const reason = document.getElementById('rejectReasonText').value.trim();
    if (!reason) {
        document.getElementById('rejectReasonError').style.display = 'block';
        return;
    }
    
    const manh = window.manhCases.find(m => m.id === currentRejectId);
    if (!manh) return;
    
    const now = new Date();
    manh.status = 'rejected';
    manh.responseDate = now.toISOString().split('T')[0];
    manh.responseTime = now.toLocaleTimeString('ar-SA', {hour: '2-digit', minute:'2-digit'});
    manh.rejectReason = reason;
    
    const reservation = window.globalReservations.find(r => 
        r.patientId === manh.originalCaseId && 
        r.toothNumber === manh.toothNumber && 
        r.treatmentValue === manh.treatmentValue
    );
    if (reservation) {
        reservation.status = 'rejected';
        reservation.rejectReason = reason;
    }
    
    saveToLocalStorage();
    closeRejectModal();
    showToast('تم رفض الحالة وإبلاغ الطالب المانح', 'info');
    loadAllManhTables();
}

// ========== المنح ==========
function showManhModal() {
    if (!selectedPatient || !selectedTreatment || !selectedTooth) {
        showToast('الرجاء اختيار المريض والمعالجة والسن أولاً', 'error');
        return;
    }
    
    const check = isToothFrozenOrReserved(selectedPatient.id, selectedTooth, selectedTreatment.value);
    if (check.frozen) {
        showToast('عذراً، ' + check.reason, 'error');
        return;
    }
    
    // التحقق من المقرر (ترميمية 4 فقط)
    if (selectedTreatment.courseId !== 'restorative4') {
        showToast('المنح متاح فقط لمقرر "مداواة الأسنان الترميمية 4"', 'error');
        return;
    }
    
    tempManhData = {
        patient: selectedPatient,
        treatment: selectedTreatment,
        tooth: selectedTooth
    };
    
    const modal = document.getElementById('manhModal');
    if (modal) {
        document.getElementById('manhPatientName').textContent = selectedPatient.fullName;
        document.getElementById('manhToothNumber').textContent = selectedTooth;
        document.getElementById('manhTreatment').textContent = selectedTreatment.label;
        document.getElementById('manhCourseName').textContent = selectedTreatment.course;
        document.getElementById('manhCourseCheck').textContent = selectedTreatment.course;
        document.getElementById('recipientStudentId').value = '';
        modal.style.display = 'block';
    }
}

function closeManhModal() {
    const modal = document.getElementById('manhModal');
    if (modal) {
        modal.style.display = 'none';
        tempManhData = { patient: null, treatment: null, tooth: null };
    }
}

function confirmManh() {
    const recipientId = document.getElementById('recipientStudentId').value.trim();
    
    if (!recipientId) {
        showToast('الرجاء إدخال رقم الطالب المستلم', 'error');
        return;
    }
    
    if (recipientId === currentStudentId) {
        showToast('لا يمكنك منح الحالة لنفسك!', 'error');
        return;
    }
    
    if (!tempManhData.patient || !tempManhData.treatment || !tempManhData.tooth) {
        showToast('خطأ: البيانات غير مكتملة', 'error');
        return;
    }
    
    // التحقق من المقرر
    const eligibility = checkStudentCourseEligibility(recipientId, 'restorative4');
    if (!eligibility.eligible) {
        showToast('لا يمكن المنح: ' + eligibility.reason, 'error');
        return;
    }
    
    // إضافة الحجز كمنح (محجوز/مجمد)
    window.globalReservations.push({
        patientId: tempManhData.patient.id,
        toothNumber: tempManhData.tooth,
        treatmentValue: tempManhData.treatment.value,
        courseId: 'restorative4',
        status: 'reserved',
        byStudent: currentStudentId,
        recipientStudent: recipientId,
        date: new Date().toISOString().split('T')[0],
        type: 'manh'
    });
    
    // إضافة للسجل
    const manhRecord = {
        id: 'manh_' + Date.now(),
        originalCaseId: tempManhData.patient.id,
        patientName: tempManhData.patient.fullName,
        toothNumber: tempManhData.tooth,
        treatmentType: tempManhData.treatment.label,
        treatmentValue: tempManhData.treatment.value,
        course: tempManhData.treatment.course,
        courseId: 'restorative4',
        fromStudentId: currentStudentId,
        toStudentId: recipientId,
        manhDate: new Date().toISOString().split('T')[0],
        manhTime: new Date().toLocaleTimeString('ar-SA', {hour: '2-digit', minute:'2-digit'}),
        status: 'pending',
        responseDate: null,
        responseTime: null,
        rejectReason: null,
        cancelledReason: null
    };
    
    window.manhCases.push(manhRecord);
    
    saveToLocalStorage();
    closeManhModal();
    showToast(`تم منح الحالة بنجاح لـ ${eligibility.studentName}! (غير محدود)`, 'success');
    
    loadAllManhTables();
    showTeethForTreatment(tempManhData.treatment.value, tempManhData.treatment.label);
    selectedTooth = null;
    document.querySelectorAll('input[name="toothSelect"]').forEach(r => r.checked = false);
}

function resetCaseForm() {
    selectedPatient = null;
    selectedTreatment = null;
    selectedTooth = null;
    
    const detailsSection = document.getElementById('patientDetailsSection');
    const teethSection = document.getElementById('teethSection');
    const courseDisplay = document.getElementById('courseNameDisplay');
    const selectedTreatmentText = document.getElementById('selectedTreatmentText');
    
    if (detailsSection) detailsSection.style.display = 'none';
    if (teethSection) teethSection.style.display = 'none';
    if (courseDisplay) courseDisplay.style.display = 'none';
    if (selectedTreatmentText) selectedTreatmentText.textContent = 'اختر نمط المعالجة...';
    
    document.querySelectorAll('.patient-card-compact').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);
    showToast('تم إعادة تعيين النموذج', 'info');
}

// ========== Toast ==========
function showToast(message, type = 'info') {
    const existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `position: fixed; top: 100px; left: 50%; transform: translateX(-50%); padding: 14px 24px; border-radius: 10px; color: white; font-weight: 600; z-index: 100000; box-shadow: 0 10px 30px rgba(0,0,0,0.2); font-family: inherit; min-width: 280px; text-align: center; font-size: 14px; animation: slideDown 0.3s ease;`;
    
    const colors = {
        success: 'linear-gradient(135deg, #10b981, #059669)',
        error: 'linear-gradient(135deg, #ef4444, #dc2626)',
        info: 'linear-gradient(135deg, #3b82f6, #2563eb)'
    };
    
    toast.style.background = colors[type] || colors.info;
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    toast.innerHTML = `<i class="fas ${icon}" style="margin-left: 8px;"></i>${message}`;
    
    document.body.appendChild(toast);
    setTimeout(() => { 
        toast.style.animation = 'fadeOut 0.3s ease'; 
        setTimeout(() => toast.remove(), 300); 
    }, 3000);
}

// ========== التهيئة ==========
document.addEventListener('DOMContentLoaded', function() {
    loadFromLocalStorage();
    
    updateCurrentTime();
    updateSessionCounter(); // تحديث العداد عند التحميل
    loadAvailablePatients();
    loadAllManhTables();
    
    setInterval(() => {
        updateCurrentTime();
        loadIncomingTable();
    }, 60000);
});

// إغلاق النوافذ عند النقر خارجها
window.onclick = function(event) {
    const dropdown = document.getElementById('treatmentDropdown');
    if (dropdown && !dropdown.contains(event.target)) {
        const options = document.getElementById('treatmentOptions');
        const icon = document.getElementById('treatmentDropdownIcon');
        if (options) options.style.display = 'none';
        if (icon) icon.style.transform = 'rotate(0)';
    }
    
    const manhModal = document.getElementById('manhModal');
    if (manhModal && event.target === manhModal) closeManhModal();
    
    const rejectModal = document.getElementById('rejectReasonModal');
    if (rejectModal && event.target === rejectModal) closeRejectModal();
    
    const cancelModal = document.getElementById('cancelManhModal');
    if (cancelModal && event.target === cancelModal) closeCancelManhModal();
}
