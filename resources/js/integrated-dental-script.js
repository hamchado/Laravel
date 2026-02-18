// =====================================================
// ========== Dental System - Integrated Script ========
// =====================================================

// ========== Data Storage ==========
const STORAGE_KEYS = {
    STUDIO_IMAGES: 'dental_studio_images',
    RESERVATIONS: 'dental_reservations',
    MANH_CASES: 'dental_manh_cases',
    CANCELLED_CASES: 'dental_cancelled_cases',
    CASE_IMAGES: 'dental_case_images'
};

// ========== Mock Data ==========
const mockPatients = [
    { id: 101, name: 'أحمد محمد علي', phone: '0935123456', age: 34, condition: 'مضبوطة', address: 'دمشق - المزة' },
    { id: 102, name: 'سارة خالد النجار', phone: '0987654321', age: 39, condition: 'غير مضبوطة', address: 'دمشق - المالكي' },
    { id: 103, name: 'محمد عمر النجار', phone: '0955112233', age: 28, condition: 'مضبوطة', address: 'حلب - الجميلية' },
    { id: 104, name: 'فاطمة أحمد حسن', phone: '0966778899', age: 45, condition: 'سليمة', address: 'دمشق - المهاجرين' },
    { id: 105, name: 'خالد سعيد رضوان', phone: '0999887766', age: 52, condition: 'مضبوطة', address: 'دمشق - ركن الدين' }
];

const mockStudents = [
    { id: '202312001', name: 'خالد العمر' },
    { id: '202312002', name: 'محمد سليم' },
    { id: '202312003', name: 'علي حسن' },
    { id: '202312004', name: 'فادي يوسف' },
    { id: '202312005', name: 'أحمد محمود' }
];

const treatments = [
    { value: 'filling', label: 'حشوة تجميلية', course: 'restorative-4' },
    { value: 'crown', label: 'تاج أسنان', course: 'prosthodontics' },
    { value: 'root-canal', label: 'علاج جذور', course: 'endo' },
    { value: 'extraction', label: 'خلع سن', course: 'restorative-3' }
];

// ========== State ==========
let studioImages = [];
let reservations = [];
let manhCases = [];
let cancelledCases = [];
let caseImages = {};
let selectedImages = new Set();
let currentModalImage = null;

let selectedPatient = null;
let selectedTreatment = null;
let selectedTeeth = [];
let sessionUsed = 0;
const SESSION_MAX = 2;

// ========== LocalStorage Functions ==========
function saveToLocalStorage(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
}

function loadFromLocalStorage(key, defaultValue = []) {
    const data = localStorage.getItem(key);
    return data ? JSON.parse(data) : defaultValue;
}

function saveAllData() {
    saveToLocalStorage(STORAGE_KEYS.STUDIO_IMAGES, studioImages);
    saveToLocalStorage(STORAGE_KEYS.RESERVATIONS, reservations);
    saveToLocalStorage(STORAGE_KEYS.MANH_CASES, manhCases);
    saveToLocalStorage(STORAGE_KEYS.CANCELLED_CASES, cancelledCases);
    saveToLocalStorage(STORAGE_KEYS.CASE_IMAGES, caseImages);
}

function loadAllData() {
    studioImages = loadFromLocalStorage(STORAGE_KEYS.STUDIO_IMAGES);
    reservations = loadFromLocalStorage(STORAGE_KEYS.RESERVATIONS);
    manhCases = loadFromLocalStorage(STORAGE_KEYS.MANH_CASES);
    cancelledCases = loadFromLocalStorage(STORAGE_KEYS.CANCELLED_CASES);
    caseImages = loadFromLocalStorage(STORAGE_KEYS.CASE_IMAGES, {});
}

// ========== Notification ==========
function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.className = `notification ${type}`;
    notification.classList.add('show');
    
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// ========== Tab Navigation ==========
function initTabs() {
    const tabs = document.querySelectorAll('.nav-tab');
    const contents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetTab = tab.dataset.tab;
            
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            
            tab.classList.add('active');
            document.getElementById(`${targetTab}-tab`).classList.add('active');
        });
    });
}

// ========== Image Studio ==========
function initImageStudio() {
    const uploadArea = document.getElementById('upload-area');
    const imageUpload = document.getElementById('image-upload');
    const gallery = document.getElementById('image-gallery');
    
    uploadArea.addEventListener('click', () => imageUpload.click());
    
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--primary)';
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.style.borderColor = 'var(--glass-border)';
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--glass-border)';
        handleImageUpload(e.dataTransfer.files);
    });
    
    imageUpload.addEventListener('change', (e) => {
        handleImageUpload(e.target.files);
    });
    
    renderImageGallery();
}

function handleImageUpload(files) {
    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        
        const reader = new FileReader();
        reader.onload = (e) => {
            const image = {
                id: Date.now() + Math.random(),
                url: e.target.result,
                name: file.name,
                date: new Date().toISOString()
            };
            studioImages.push(image);
            saveAllData();
            renderImageGallery();
            showNotification('تم رفع الصورة بنجاح');
        };
        reader.readAsDataURL(file);
    });
}

function renderImageGallery() {
    const gallery = document.getElementById('image-gallery');
    if (!gallery) return;
    
    gallery.innerHTML = studioImages.map(img => `
        <div class="gallery-item ${selectedImages.has(img.id) ? 'selected' : ''}" data-id="${img.id}">
            <img src="${img.url}" alt="${img.name}">
            <div class="gallery-item-overlay">
                <div class="gallery-item-actions">
                    <button onclick="viewImage(${img.id})" title="عرض"><i class="fas fa-eye"></i></button>
                    <button onclick="selectImage(${img.id})" title="تحديد"><i class="fas fa-check"></i></button>
                    <button onclick="deleteImage(${img.id})" title="حذف"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    `).join('');
}

function viewImage(id) {
    const image = studioImages.find(img => img.id === id);
    if (!image) return;
    
    currentModalImage = id;
    document.getElementById('modal-image').src = image.url;
    document.getElementById('image-modal').classList.add('active');
}

function selectImage(id) {
    if (selectedImages.has(id)) {
        selectedImages.delete(id);
    } else {
        selectedImages.add(id);
    }
    renderImageGallery();
}

function deleteImage(id) {
    if (!confirm('هل أنت متأكد من حذف هذه الصورة؟')) return;
    
    studioImages = studioImages.filter(img => img.id !== id);
    selectedImages.delete(id);
    saveAllData();
    renderImageGallery();
    showNotification('تم حذف الصورة');
}

function deleteSelectedImages() {
    if (selectedImages.size === 0) {
        showNotification('الرجاء تحديد صور أولاً', 'warning');
        return;
    }
    
    if (!confirm(`هل أنت متأكد من حذف ${selectedImages.size} صورة؟`)) return;
    
    studioImages = studioImages.filter(img => !selectedImages.has(img.id));
    selectedImages.clear();
    saveAllData();
    renderImageGallery();
    showNotification('تم حذف الصور المحددة');
}

function selectAllImages() {
    if (selectedImages.size === studioImages.length) {
        selectedImages.clear();
    } else {
        studioImages.forEach(img => selectedImages.add(img.id));
    }
    renderImageGallery();
}

// ========== Cases Table ==========
function initCasesTable() {
    renderCasesTable();
    
    document.getElementById('course-filter')?.addEventListener('change', renderCasesTable);
    document.getElementById('status-filter')?.addEventListener('change', renderCasesTable);
    document.getElementById('search-input')?.addEventListener('input', renderCasesTable);
}

function renderCasesTable() {
    const tbody = document.getElementById('cases-tbody');
    if (!tbody) return;
    
    const courseFilter = document.getElementById('course-filter')?.value || '';
    const statusFilter = document.getElementById('status-filter')?.value || '';
    const searchTerm = document.getElementById('search-input')?.value.toLowerCase() || '';
    
    let filtered = [...reservations];
    
    if (courseFilter) filtered = filtered.filter(r => r.course === courseFilter);
    if (statusFilter) filtered = filtered.filter(r => r.status === statusFilter);
    if (searchTerm) filtered = filtered.filter(r => 
        r.patientName?.toLowerCase().includes(searchTerm) ||
        r.treatment?.toLowerCase().includes(searchTerm)
    );
    
    if (filtered.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" style="text-align: center; padding: 40px;">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>لا توجد حالات</h3>
                        <p>لم يتم العثور على أي حالات مطابقة للبحث</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = filtered.map(r => `
        <tr>
            <td><span class="status-badge status-${r.status}">${getStatusLabel(r.status)}</span></td>
            <td>${r.patientName}</td>
            <td>${getCourseLabel(r.course)}</td>
            <td>${r.tooth || '-'}</td>
            <td>${getTreatmentLabel(r.treatment)}</td>
            <td>
                <div class="rating">
                    ${Array(5).fill(0).map((_, i) => `
                        <span class="star ${i < (r.rating || 0) ? '' : 'empty'}">★</span>
                    `).join('')}
                </div>
            </td>
            <td>${r.supervisor || '-'}</td>
            <td>${formatDate(r.date)}</td>
            <td>
                <button class="action-btn" onclick="viewCase('${r.id}')" title="عرض"><i class="fas fa-eye"></i></button>
                <button class="action-btn danger" onclick="cancelCase('${r.id}')" title="إلغاء"><i class="fas fa-times"></i></button>
            </td>
        </tr>
    `).join('');
}

function getStatusLabel(status) {
    const labels = {
        pending: 'قيد الانتظار',
        approved: 'تمت الموافقة',
        rejected: 'مرفوض',
        completed: 'مكتمل'
    };
    return labels[status] || status;
}

function getCourseLabel(course) {
    const labels = {
        'restorative-4': 'Restorative 4',
        'restorative-3': 'Restorative 3',
        'restorative-2': 'Restorative 2',
        'restorative-1': 'Restorative 1',
        'prosthodontics': 'Prosthodontics',
        'endo': 'Endodontics'
    };
    return labels[course] || course;
}

function getTreatmentLabel(treatment) {
    const t = treatments.find(t => t.value === treatment);
    return t ? t.label : treatment;
}

function formatDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    return date.toLocaleDateString('ar-SA');
}

function viewCase(id) {
    showNotification('عرض تفاصيل الحالة: ' + id, 'info');
}

function cancelCase(id) {
    if (!confirm('هل أنت متأكد من إلغاء هذه الحالة؟')) return;
    
    const index = reservations.findIndex(r => r.id === id);
    if (index > -1) {
        cancelledCases.push({
            ...reservations[index],
            cancelDate: new Date().toISOString(),
            cancelReason: 'إلغاء يدوي'
        });
        reservations.splice(index, 1);
        saveAllData();
        renderCasesTable();
        updateSessionCounter();
        showNotification('تم إلغاء الحالة');
    }
}

// ========== Add Case Form ==========
function initAddCaseForm() {
    renderPatients();
    renderTreatments();
    renderToothGrid();
    updateSessionCounter();
    
    document.getElementById('reset-form')?.addEventListener('click', resetCaseForm);
    document.getElementById('submit-reservation')?.addEventListener('click', submitReservation);
}

function renderPatients() {
    const grid = document.getElementById('patient-grid');
    if (!grid) return;
    
    grid.innerHTML = mockPatients.map(p => `
        <div class="patient-card ${selectedPatient === p.id ? 'selected' : ''}" data-id="${p.id}">
            <div class="patient-card-header">
                <span class="patient-name">${p.name}</span>
                <span class="patient-id">#${p.id}</span>
            </div>
            <div class="patient-info">
                <div class="patient-info-item"><i class="fas fa-phone"></i> ${p.phone}</div>
                <div class="patient-info-item"><i class="fas fa-birthday-cake"></i> ${p.age} سنة</div>
                <div class="patient-info-item"><i class="fas fa-map-marker-alt"></i> ${p.address}</div>
            </div>
        </div>
    `).join('');
    
    grid.querySelectorAll('.patient-card').forEach(card => {
        card.addEventListener('click', () => {
            selectedPatient = parseInt(card.dataset.id);
            renderPatients();
        });
    });
}

function renderTreatments() {
    const grid = document.getElementById('treatment-grid');
    if (!grid) return;
    
    grid.querySelectorAll('.treatment-card').forEach(card => {
        card.addEventListener('click', () => {
            selectedTreatment = card.dataset.treatment;
            grid.querySelectorAll('.treatment-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
        });
    });
}

function renderToothGrid() {
    const grid = document.getElementById('tooth-grid');
    if (!grid) return;
    
    grid.innerHTML = Array(32).fill(0).map((_, i) => {
        const toothNum = i + 1;
        return `
            <div class="tooth-item ${selectedTeeth.includes(toothNum) ? 'selected' : ''}" data-tooth="${toothNum}">
                ${toothNum}
            </div>
        `;
    }).join('');
    
    grid.querySelectorAll('.tooth-item').forEach(item => {
        item.addEventListener('click', () => {
            const toothNum = parseInt(item.dataset.tooth);
            if (selectedTeeth.includes(toothNum)) {
                selectedTeeth = selectedTeeth.filter(t => t !== toothNum);
            } else {
                selectedTeeth.push(toothNum);
            }
            renderToothGrid();
        });
    });
}

function updateSessionCounter() {
    const used = reservations.filter(r => r.course === 'restorative-4' && r.status !== 'cancelled').length;
    sessionUsed = used;
    
    const usedEl = document.getElementById('session-used');
    const remainingEl = document.getElementById('session-remaining');
    
    if (usedEl) usedEl.textContent = used;
    if (remainingEl) remainingEl.textContent = SESSION_MAX - used;
}

function resetCaseForm() {
    selectedPatient = null;
    selectedTreatment = null;
    selectedTeeth = [];
    
    renderPatients();
    document.querySelectorAll('.treatment-card').forEach(c => c.classList.remove('selected'));
    renderToothGrid();
    
    showNotification('تم إعادة تعيين النموذج', 'info');
}

function submitReservation() {
    if (!selectedPatient) {
        showNotification('الرجاء اختيار مريض', 'warning');
        return;
    }
    if (!selectedTreatment) {
        showNotification('الرجاء اختيار نوع العلاج', 'warning');
        return;
    }
    if (selectedTeeth.length === 0) {
        showNotification('الرجاء اختيار رقم السن', 'warning');
        return;
    }
    
    const treatment = treatments.find(t => t.value === selectedTreatment);
    if (treatment?.course === 'restorative-4' && sessionUsed >= SESSION_MAX) {
        showNotification('لقد تجاوزت الحد الأقصى للحجز في هذه الجلسة', 'error');
        return;
    }
    
    const patient = mockPatients.find(p => p.id === selectedPatient);
    
    const reservation = {
        id: Date.now().toString(),
        patientId: selectedPatient,
        patientName: patient.name,
        treatment: selectedTreatment,
        course: treatment?.course || '',
        tooth: selectedTeeth.join(', '),
        status: 'pending',
        date: new Date().toISOString(),
        supervisor: null,
        rating: 0
    };
    
    reservations.push(reservation);
    saveAllData();
    renderCasesTable();
    updateSessionCounter();
    resetCaseForm();
    
    showNotification('تم حجز الحالة بنجاح');
}

// ========== Manh Hala (Grant) ==========
function initManhHala() {
    const patientSelect = document.getElementById('grant-patient');
    const recipientSelect = document.getElementById('grant-recipient');
    
    if (patientSelect) {
        patientSelect.innerHTML = `
            <option value="">اختر المريض</option>
            ${mockPatients.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
        `;
    }
    
    if (recipientSelect) {
        recipientSelect.innerHTML = `
            <option value="">اختر الطالب</option>
            ${mockStudents.map(s => `<option value="${s.id}">${s.name}</option>`).join('')}
        `;
    }
    
    document.getElementById('submit-grant')?.addEventListener('click', submitGrant);
    
    renderOutgoingTable();
}

function submitGrant() {
    const patientId = document.getElementById('grant-patient')?.value;
    const treatment = document.getElementById('grant-treatment')?.value;
    const recipientId = document.getElementById('grant-recipient')?.value;
    
    if (!patientId || !treatment || !recipientId) {
        showNotification('الرجاء ملء جميع الحقول', 'warning');
        return;
    }
    
    const patient = mockPatients.find(p => p.id == patientId);
    const recipient = mockStudents.find(s => s.id === recipientId);
    
    const grant = {
        id: Date.now().toString(),
        patientId,
        patientName: patient.name,
        treatment,
        recipientId,
        recipientName: recipient.name,
        date: new Date().toISOString(),
        status: 'pending'
    };
    
    manhCases.push(grant);
    saveAllData();
    renderOutgoingTable();
    
    document.getElementById('grant-patient').value = '';
    document.getElementById('grant-treatment').value = '';
    document.getElementById('grant-recipient').value = '';
    
    showNotification('تم منح الحالة بنجاح');
}

function renderOutgoingTable() {
    const tbody = document.getElementById('outgoing-grants-tbody');
    if (!tbody) return;
    
    const outgoing = manhCases.filter(m => m.recipientId);
    
    if (outgoing.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                    <div class="empty-state">
                        <i class="fas fa-hand-holding-heart"></i>
                        <h3>لا توجد منح صادرة</h3>
                        <p>لم تقم بمنح أي حالات بعد</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = outgoing.map(m => `
        <tr>
            <td>${m.patientName}</td>
            <td>${getTreatmentLabel(m.treatment)}</td>
            <td>${m.recipientName}</td>
            <td>${formatDate(m.date)}</td>
            <td><span class="status-badge status-${m.status}">${getStatusLabel(m.status)}</span></td>
            <td>
                <button class="action-btn danger" onclick="revokeGrant('${m.id}')" title="استرداد"><i class="fas fa-undo"></i></button>
            </td>
        </tr>
    `).join('');
}

function revokeGrant(id) {
    if (!confirm('هل أنت متأكد من استرداد هذا المنح؟')) return;
    
    const index = manhCases.findIndex(m => m.id === id);
    if (index > -1) {
        manhCases.splice(index, 1);
        saveAllData();
        renderOutgoingTable();
        showNotification('تم استرداد المنح');
    }
}

// ========== Incoming ==========
function initIncoming() {
    renderIncomingTable();
    renderCancelledTable();
}

function renderIncomingTable() {
    const tbody = document.getElementById('incoming-grants-tbody');
    if (!tbody) return;
    
    // Simulated incoming grants for demo
    const incoming = manhCases.filter(m => m.status === 'pending' && !m.recipientId);
    
    if (incoming.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>لا توجد منح واردة</h3>
                        <p>لم تستلم أي منح بعد</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = incoming.map(m => `
        <tr>
            <td>${m.patientName}</td>
            <td>${getTreatmentLabel(m.treatment)}</td>
            <td>${m.senderName || '-'}</td>
            <td>${formatDate(m.date)}</td>
            <td><span class="status-badge status-${m.status}">${getStatusLabel(m.status)}</span></td>
            <td>
                <button class="action-btn" onclick="acceptGrant('${m.id}')" title="قبول"><i class="fas fa-check"></i></button>
                <button class="action-btn danger" onclick="rejectGrant('${m.id}')" title="رفض"><i class="fas fa-times"></i></button>
            </td>
        </tr>
    `).join('');
}

function renderCancelledTable() {
    const tbody = document.getElementById('cancelled-cases-tbody');
    if (!tbody) return;
    
    if (cancelledCases.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                    <div class="empty-state">
                        <i class="fas fa-ban"></i>
                        <h3>لا توجد حالات ملغاة</h3>
                        <p>لم يتم إلغاء أي حالات</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = cancelledCases.map(c => `
        <tr>
            <td>${c.patientName}</td>
            <td>${getTreatmentLabel(c.treatment)}</td>
            <td>${getCourseLabel(c.course)}</td>
            <td>${formatDate(c.cancelDate)}</td>
            <td>${c.cancelReason || '-'}</td>
            <td>
                <button class="action-btn" onclick="restoreCase('${c.id}')" title="استعادة"><i class="fas fa-redo"></i></button>
            </td>
        </tr>
    `).join('');
}

function acceptGrant(id) {
    const grant = manhCases.find(m => m.id === id);
    if (grant) {
        grant.status = 'approved';
        saveAllData();
        renderIncomingTable();
        showNotification('تم قبول المنح');
    }
}

function rejectGrant(id) {
    if (!confirm('هل أنت متأكد من رفض هذا المنح؟')) return;
    
    const grant = manhCases.find(m => m.id === id);
    if (grant) {
        grant.status = 'rejected';
        saveAllData();
        renderIncomingTable();
        showNotification('تم رفض المنح');
    }
}

function restoreCase(id) {
    const index = cancelledCases.findIndex(c => c.id === id);
    if (index > -1) {
        const caseData = cancelledCases[index];
        delete caseData.cancelDate;
        delete caseData.cancelReason;
        reservations.push(caseData);
        cancelledCases.splice(index, 1);
        saveAllData();
        renderCasesTable();
        renderCancelledTable();
        updateSessionCounter();
        showNotification('تم استعادة الحالة');
    }
}

// ========== Modals ==========
function initModals() {
    document.getElementById('close-image-modal')?.addEventListener('click', closeImageModal);
    document.getElementById('close-image-btn')?.addEventListener('click', closeImageModal);
    document.getElementById('delete-image-btn')?.addEventListener('click', () => {
        if (currentModalImage) {
            deleteImage(currentModalImage);
            closeImageModal();
        }
    });
    
    document.getElementById('close-confirm-modal')?.addEventListener('click', closeConfirmModal);
    document.getElementById('cancel-confirm')?.addEventListener('click', closeConfirmModal);
    
    document.getElementById('select-all-images')?.addEventListener('click', selectAllImages);
    document.getElementById('delete-selected-images')?.addEventListener('click', deleteSelectedImages);
}

function closeImageModal() {
    document.getElementById('image-modal').classList.remove('active');
}

function closeConfirmModal() {
    document.getElementById('confirm-modal').classList.remove('active');
}

// ========== Initialization ==========
document.addEventListener('DOMContentLoaded', function() {
    loadAllData();
    initTabs();
    initImageStudio();
    initCasesTable();
    initAddCaseForm();
    initManhHala();
    initIncoming();
    initModals();
    
    // Add sample data if empty
    if (reservations.length === 0) {
        reservations.push({
            id: '1',
            patientId: 101,
            patientName: 'أحمد محمد علي',
            treatment: 'filling',
            course: 'restorative-4',
            tooth: '14, 15',
            status: 'approved',
            date: new Date().toISOString(),
            supervisor: 'د. أحمد النجار',
            rating: 4
        });
        saveAllData();
        renderCasesTable();
        updateSessionCounter();
    }
});

