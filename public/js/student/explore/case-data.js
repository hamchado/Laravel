// ========== API-based Case Data Module ==========
// All data comes from the database via API - no localStorage

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

function apiFetch(url, options = {}) {
    const defaults = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    };
    if (options.body && typeof options.body === 'object' && !(options.body instanceof FormData)) {
        options.body = JSON.stringify(options.body);
    }
    if (options.body instanceof FormData) {
        delete defaults.headers['Content-Type'];
    }
    return fetch('/api' + url, { ...defaults, ...options })
        .then(r => r.json())
        .catch(err => {
            console.error('API Error:', err);
            return { success: false, message: 'خطأ في الاتصال' };
        });
}

// ========== بيانات الحالات ==========
let casesData = [];
let coursesData = [];
let currentCourseSlug = null;

// أنواع الصور
const imageTypes = [
    { key: 'diagnostic', label: 'أشعة تشخيصية (شعاعية)', icon: 'fa-x-ray', isPanorama: true },
    { key: 'cones', label: 'صورة تجربة أقمار', icon: 'fa-tooth', isPanorama: false },
    { key: 'final', label: 'صورة نهائية', icon: 'fa-check-circle', isPanorama: false },
    { key: 'followup', label: 'صورة متابعة', icon: 'fa-calendar-check', isPanorama: false }
];

// بيانات الاستديو (من API)
let studioData = {};
const caseImages = {};

// ========== تحميل البيانات من API ==========
async function loadCasesFromAPI(courseId) {
    const params = courseId ? `?course_id=${courseId}` : '';
    const data = await apiFetch('/cases' + params);
    if (data.success) {
        casesData = data.cases.map(c => ({
            id: c.id,
            patientName: c.patient?.full_name || 'غير معروف',
            patientRecord: c.patient?.record_number || '',
            caseType: c.treatment_label || c.treatment_type || '',
            treatmentValue: c.treatment_type,
            course: c.course?.name || '',
            courseId: c.course?.id,
            courseCode: c.course?.code || '',
            status: mapApiStatus(c.status),
            apiStatus: c.status,
            ratings: c.evaluation_count || 0,
            evaluations: c.evaluations || [],
            isGrant: c.is_grant,
            grant: c.grant,
            toothNumber: c.tooth_number,
            supervisor: c.evaluated_by ? 'مُقيَّم' : '-',
            addedDate: c.created_at ? new Date(c.created_at).toLocaleDateString('ar-SA') : '',
            acceptedDate: c.evaluated_at ? new Date(c.evaluated_at).toLocaleDateString('ar-SA') : null,
            images: c.images || [],
            reservationStatus: c.reservation?.status,
            rawCase: c,
        }));
    }
    return casesData;
}

async function loadCoursesFromAPI() {
    const data = await apiFetch('/courses');
    if (data.success) {
        coursesData = data.courses;
    }
    return coursesData;
}

// ربط الحالة من API بالحالة المحلية
function mapApiStatus(status) {
    switch (status) {
        case 'pending': return 'waitingAcceptance';
        case 'accepted': return 'waitingEvaluation';
        case 'in_progress': return 'inProgress';
        case 'completed': return 'completed';
        case 'rejected': return 'rejected';
        case 'transferred': return 'transferred';
        default: return 'waitingAcceptance';
    }
}

// للتوافق مع الكود القديم
function loadCasesFromSharedStorage() {
    loadCasesFromAPI();
}

// ========== دوال مساعدة للبيانات ==========
function getFilteredCases(statusFilter, courseFilter, searchTerm) {
    let filtered = [...casesData];

    if (statusFilter !== 'all') {
        filtered = filtered.filter(c => c.status === statusFilter);
    }

    if (courseFilter && courseFilter !== 'all') {
        filtered = filtered.filter(c => {
            if (typeof courseFilter === 'number') return c.courseId === courseFilter;
            return c.courseCode === courseFilter || c.courseId == courseFilter;
        });
    }

    if (searchTerm && searchTerm.trim() !== '') {
        const term = searchTerm.trim().toLowerCase();
        filtered = filtered.filter(c =>
            (c.patientName && c.patientName.toLowerCase().includes(term)) ||
            (c.course && c.course.toLowerCase().includes(term)) ||
            (c.caseType && c.caseType.toLowerCase().includes(term)) ||
            (c.patientRecord && c.patientRecord.includes(term)) ||
            (c.toothNumber && String(c.toothNumber).includes(term))
        );
    }

    return filtered;
}

function formatDate(dateStr) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateStr).toLocaleDateString('ar-SA', options);
}

function groupImagesByDate(images) {
    const grouped = {};
    images.forEach(img => {
        const date = img.date || img.created_at?.split('T')[0] || 'unknown';
        if (!grouped[date]) grouped[date] = [];
        grouped[date].push(img);
    });
    return grouped;
}

function cleanDeletedImages() {
    // No-op: images managed server-side
}

// ========== دوال إدارة الصور (API-based) ==========
async function addImagesToStudio(courseId, files, labels) {
    let success = true;
    for (let i = 0; i < files.length; i++) {
        const formData = new FormData();
        formData.append('image', files[i].file || files[i]);
        formData.append('type', labels[i] || 'regular');
        // Upload via case image API if case_id available
        if (files[i].caseId) {
            formData.append('case_id', files[i].caseId);
        }
        const res = await fetch('/api/images/upload', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData,
        }).then(r => r.json());
        if (!res.success) success = false;
    }
    return success;
}

function moveImageToTrash(courseId, imageId) {
    // Images are managed server-side, this is a placeholder
    console.log('Delete image:', imageId);
    return true;
}

function restoreImageFromTrash(courseId, imageId) {
    console.log('Restore image:', imageId);
    return true;
}

function assignImageToCase(courseId, imageId, imageType, caseId) {
    console.log('Assign image to case:', imageId, caseId);
    return true;
}

function releaseImageFromCase(courseId, imageId, imageType) {
    console.log('Release image from case:', imageId);
    return true;
}

function saveStudioToLocalStorage() {
    // No-op: all data in database
}

// ========== QR Code Helper ==========
async function getQrData(caseId) {
    const data = await apiFetch(`/cases/${caseId}/qr`);
    return data;
}

// ========== Session Status ==========
async function getSessionStatus(courseId) {
    const data = await apiFetch(`/cases/session-status?course_id=${courseId}`);
    return data;
}

// ========== التهيئة ==========
function initDataSync(onDataChange) {
    // Poll for updates every 30 seconds
    setInterval(async () => {
        await loadCasesFromAPI();
        if (onDataChange) onDataChange();
    }, 30000);
}

// ========== جعل الدوال متاحة عالمياً ==========
window.CasesData = {
    get casesData() { return casesData; },
    get coursesData() { return coursesData; },
    studioData,
    imageTypes,
    caseImages,
    loadCasesFromAPI,
    loadCoursesFromAPI,
    loadCasesFromSharedStorage,
    saveStudioToLocalStorage,
    getFilteredCases,
    addImagesToStudio,
    moveImageToTrash,
    restoreImageFromTrash,
    assignImageToCase,
    releaseImageFromCase,
    initDataSync,
    formatDate,
    groupImagesByDate,
    cleanDeletedImages,
    getQrData,
    getSessionStatus,
    apiFetch,
};
