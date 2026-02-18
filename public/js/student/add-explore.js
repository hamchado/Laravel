// ========== API-based Add Case & Grant System ==========
const addCsrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

// State
let selectedPatient = null;
let selectedTreatment = null;
let selectedTooth = null;
let currentCourseId = null;
let currentCourseData = null;
let sessionStatus = { session_limit: 2, used: 0, remaining: 2, limit_reached: false, in_session: false };
let confirmedPatients = [];
let courseWorks = [];

function addApiFetch(url, options = {}) {
    const defaults = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': addCsrfToken,
        },
    };
    if (options.body && typeof options.body === 'object') {
        options.body = JSON.stringify(options.body);
    }
    return fetch('/api' + url, { ...defaults, ...options })
        .then(r => r.json())
        .catch(err => {
            console.error('API Error:', err);
            return { success: false, message: 'خطأ في الاتصال' };
        });
}

// ========== تحميل البيانات ==========
async function loadCourseData(courseId) {
    if (!courseId) return;
    currentCourseId = courseId;

    const data = await addApiFetch(`/courses/${courseId}/works`);
    if (data.success) {
        currentCourseData = data.course;
        courseWorks = data.works || [];
        confirmedPatients = data.confirmed_patients || [];
        loadAvailablePatients();
        loadTreatmentOptions();
    }

    await refreshSessionStatus();
}

async function refreshSessionStatus() {
    if (!currentCourseId) return;
    const data = await addApiFetch(`/cases/session-status?course_id=${currentCourseId}`);
    if (data.success) {
        sessionStatus = data;
        updateSessionCounter();
        updateAddButtonState();
    }
}

// ========== عداد الجلسة ==========
function updateSessionCounter() {
    const counterEl = document.getElementById('sessionCounter');
    if (counterEl) {
        counterEl.textContent = `${sessionStatus.used} / ${sessionStatus.session_limit}`;
        counterEl.style.color = sessionStatus.limit_reached ? '#ef4444' : '#10b981';
    }

    const remainingEl = document.getElementById('sessionRemaining');
    if (remainingEl) {
        remainingEl.textContent = sessionStatus.remaining;
    }

    const statusEl = document.getElementById('sessionStatusBadge');
    if (statusEl) {
        if (sessionStatus.limit_reached) {
            statusEl.innerHTML = '<i class="fas fa-lock"></i> تم الوصول للحد';
            statusEl.className = 'session-badge session-locked';
        } else {
            statusEl.innerHTML = '<i class="fas fa-lock-open"></i> متاح';
            statusEl.className = 'session-badge session-open';
        }
    }
}

function updateAddButtonState() {
    const addBtn = document.getElementById('addCaseBtn');
    if (addBtn) {
        if (sessionStatus.limit_reached) {
            addBtn.disabled = true;
            addBtn.title = 'تم الوصول لحد الجلسة - استخدم المنح';
        } else {
            addBtn.disabled = false;
            addBtn.title = 'إضافة حالة';
        }
    }
}

// ========== تحميل المرضى المثبتين ==========
function loadAvailablePatients() {
    const container = document.getElementById('patientsList') || document.getElementById('availablePatients');
    if (!container) return;
    container.innerHTML = '';

    if (confirmedPatients.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-user-slash"></i><p>لا يوجد مرضى مثبتين لهذا المقرر</p></div>';
        return;
    }

    confirmedPatients.forEach(patient => {
        const card = document.createElement('div');
        card.className = `patient-card ${selectedPatient?.id === patient.id ? 'selected' : ''}`;
        card.onclick = () => selectPatient(patient);
        card.innerHTML = `
            <div class="patient-info">
                <strong>${patient.full_name}</strong>
                <span class="record-num">${patient.record_number}</span>
            </div>
            <div class="patient-meta">
                ${patient.phone ? `<span><i class="fas fa-phone"></i> ${patient.phone}</span>` : ''}
                ${patient.age ? `<span><i class="fas fa-calendar"></i> ${patient.age} سنة</span>` : ''}
            </div>
        `;
        container.appendChild(card);
    });
}

function selectPatient(patient) {
    selectedPatient = patient;
    loadAvailablePatients(); // refresh highlighting
    const nameEl = document.getElementById('selectedPatientName');
    if (nameEl) nameEl.textContent = patient.full_name;
    updateSubmitButton();
}

// ========== تحميل أنواع المعالجات ==========
function loadTreatmentOptions() {
    const container = document.getElementById('treatmentOptions') || document.getElementById('treatmentList');
    if (!container) return;
    container.innerHTML = '';

    courseWorks.forEach(work => {
        const option = document.createElement('div');
        option.className = `treatment-option ${selectedTreatment?.name === work.name ? 'selected' : ''}`;
        option.onclick = () => selectTreatment(work);
        option.innerHTML = `
            <div class="treatment-name">${work.name}</div>
            <div class="treatment-progress">
                <span class="completed">${work.completed}</span> / <span class="required">${work.required}</span>
                ${work.in_progress > 0 ? `<span class="pending">(${work.in_progress} قيد المراجعة)</span>` : ''}
            </div>
        `;
        container.appendChild(option);
    });
}

function selectTreatment(work) {
    selectedTreatment = work;
    loadTreatmentOptions(); // refresh highlighting
    const nameEl = document.getElementById('selectedTreatmentName');
    if (nameEl) nameEl.textContent = work.name;
    updateSubmitButton();
}

// ========== اختيار السن ==========
function selectTooth(toothNumber) {
    selectedTooth = toothNumber;
    document.querySelectorAll('.tooth-btn').forEach(btn => {
        btn.classList.toggle('selected', btn.dataset.tooth == toothNumber);
    });
    const nameEl = document.getElementById('selectedToothNumber');
    if (nameEl) nameEl.textContent = toothNumber;
    updateSubmitButton();
}

function updateSubmitButton() {
    const btn = document.getElementById('submitCaseBtn') || document.getElementById('addCaseBtn');
    if (btn) {
        btn.disabled = !selectedPatient || !selectedTreatment;
    }
}

// ========== إضافة حالة ==========
async function submitCase() {
    if (!selectedPatient || !selectedTreatment || !currentCourseId) {
        showAddToast('يرجى اختيار المريض ونوع المعالجة', 'error');
        return;
    }

    if (sessionStatus.limit_reached) {
        showAddToast('تم الوصول لحد الجلسة. استخدم المنح.', 'error');
        return;
    }

    const payload = {
        patient_id: selectedPatient.id,
        course_id: currentCourseId,
        tooth_number: selectedTooth || null,
        treatment_type: selectedTreatment.name,
        treatment_label: selectedTreatment.name,
        description: document.getElementById('caseDescription')?.value || '',
    };

    const result = await addApiFetch('/cases', {
        method: 'POST',
        body: payload,
    });

    if (result.success) {
        showAddToast('تم تسجيل الحالة بنجاح', 'success');
        resetForm();
        await refreshSessionStatus();
        // Reload cases table
        if (window.CasesData && window.CasesData.loadCasesFromAPI) {
            await window.CasesData.loadCasesFromAPI();
        }
        // Trigger table refresh
        if (typeof window.renderCasesTable === 'function') {
            window.renderCasesTable();
        }
    } else {
        showAddToast(result.message || 'حدث خطأ في تسجيل الحالة', 'error');
    }
}

// ========== نظام المنح ==========
async function openGrantModal(caseId) {
    const modal = document.getElementById('manhModal') || document.getElementById('grantModal');
    if (modal) {
        modal.dataset.caseId = caseId;
        modal.classList.add('active');
    }
}

function closeGrantModal() {
    const modal = document.getElementById('manhModal') || document.getElementById('grantModal');
    if (modal) modal.classList.remove('active');
}

async function submitGrant() {
    const modal = document.getElementById('manhModal') || document.getElementById('grantModal');
    const caseId = modal?.dataset.caseId;
    const studentIdInput = document.getElementById('granteeStudentId') || document.getElementById('manhStudentId');
    const studentId = studentIdInput?.value.trim();

    if (!studentId) {
        showAddToast('يرجى إدخال الرقم الجامعي للطالب', 'error');
        return;
    }

    if (!caseId || !currentCourseId) {
        showAddToast('يرجى تحديد الحالة والمقرر', 'error');
        return;
    }

    const result = await addApiFetch('/grants', {
        method: 'POST',
        body: {
            case_id: parseInt(caseId),
            grantee_student_id: studentId,
            course_id: currentCourseId,
        },
    });

    if (result.success) {
        showAddToast('تم إرسال المنح بنجاح', 'success');
        closeGrantModal();
        if (typeof loadGrantsFromAPI === 'function') loadGrantsFromAPI();
    } else {
        showAddToast(result.message || 'حدث خطأ في المنح', 'error');
    }
}

// ========== إعادة التعيين ==========
function resetForm() {
    selectedPatient = null;
    selectedTreatment = null;
    selectedTooth = null;
    const descEl = document.getElementById('caseDescription');
    if (descEl) descEl.value = '';
    loadAvailablePatients();
    loadTreatmentOptions();
    document.querySelectorAll('.tooth-btn').forEach(btn => btn.classList.remove('selected'));
    const patientNameEl = document.getElementById('selectedPatientName');
    const treatmentNameEl = document.getElementById('selectedTreatmentName');
    const toothEl = document.getElementById('selectedToothNumber');
    if (patientNameEl) patientNameEl.textContent = '-';
    if (treatmentNameEl) treatmentNameEl.textContent = '-';
    if (toothEl) toothEl.textContent = '-';
    updateSubmitButton();
}

// ========== Toast ==========
function showAddToast(message, type = 'info') {
    const existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `position:fixed;top:100px;left:50%;transform:translateX(-50%);padding:14px 24px;border-radius:10px;color:white;font-weight:600;z-index:100000;box-shadow:0 10px 30px rgba(0,0,0,0.2);min-width:280px;text-align:center;font-size:14px;`;

    const colors = {
        success: 'linear-gradient(135deg, #10b981, #059669)',
        error: 'linear-gradient(135deg, #ef4444, #dc2626)',
        info: 'linear-gradient(135deg, #3b82f6, #2563eb)'
    };

    toast.style.background = colors[type] || colors.info;
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    toast.innerHTML = `<i class="fas ${icon}" style="margin-left:8px;"></i>${message}`;

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// ========== التهيئة ==========
document.addEventListener('DOMContentLoaded', async function() {
    // Load courses to populate dropdown
    const coursesData = await addApiFetch('/courses');
    if (coursesData.success && coursesData.courses.length > 0) {
        // Populate course dropdown if exists
        const courseSelect = document.getElementById('courseSelect') || document.getElementById('courseDropdown');
        if (courseSelect && courseSelect.tagName === 'SELECT') {
            courseSelect.innerHTML = '<option value="">اختر المقرر</option>';
            coursesData.courses.forEach(c => {
                courseSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
            });
            courseSelect.addEventListener('change', function() {
                if (this.value) loadCourseData(parseInt(this.value));
            });
        }

        // Auto-load first course
        if (coursesData.courses.length === 1) {
            await loadCourseData(coursesData.courses[0].id);
        }
    }
});

// Make functions globally available
window.submitCase = submitCase;
window.submitGrant = submitGrant;
window.openGrantModal = openGrantModal;
window.closeGrantModal = closeGrantModal;
window.selectPatient = selectPatient;
window.selectTreatment = selectTreatment;
window.selectTooth = selectTooth;
window.resetForm = resetForm;
window.loadCourseData = loadCourseData;
window.refreshSessionStatus = refreshSessionStatus;
