function switchMainTab(element, tabName) {
    // إزالة النشاط من جميع التبويبات
    document.querySelectorAll('.tabs-container .tab-item').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // تفعيل التبويب المختار
    element.classList.add('active');
    
    // إخفاء جميع الأقسام
    document.querySelectorAll('.tab-content-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // إظهار القسم المطلوب
    const targetSection = document.getElementById(tabName + '-section');
    if (targetSection) {
        targetSection.style.display = 'block';
    }
    
    // تمرير للأعلى
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ========== Dropdown Functions ==========
function toggleDropdownSimple(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const isOpen = dropdown.classList.contains('dropdown-open');
    
    document.querySelectorAll('.custom-dropdown-simple').forEach(d => {
        d.classList.remove('dropdown-open');
    });
    
    if (!isOpen) {
        dropdown.classList.add('dropdown-open');
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.custom-dropdown-simple')) {
        document.querySelectorAll('.custom-dropdown-simple').forEach(d => {
            d.classList.remove('dropdown-open');
        });
    }
});

function selectCourseSimple(value, label) {
    document.getElementById('courseHeaderText').textContent = label;
    const dropdown = document.getElementById('courseDropdown');
    
    dropdown.querySelectorAll('.dropdown-option-simple').forEach(opt => {
        opt.classList.toggle('selected', opt.textContent.trim() === label);
    });
    
    dropdown.classList.remove('dropdown-open');
    currentCourseFilter = value;
    currentPage = 1;
    loadCasesTable();
}

function selectStatusSimple(value, label) {
    document.getElementById('statusHeaderText').textContent = label;
    const dropdown = document.getElementById('statusDropdown');
    
    dropdown.querySelectorAll('.dropdown-option-simple').forEach(opt => {
        opt.classList.toggle('selected', opt.textContent.trim() === label);
    });
    
    dropdown.classList.remove('dropdown-open');
    currentStatusFilter = value;
    currentPage = 1;
    loadCasesTable();
}

// ========== Tooltip Functions ==========
function showUnifiedTooltip(event, text, element) {
    event.stopPropagation();
    const tooltip = document.getElementById('unifiedTooltip');
    
    hideUnifiedTooltip();
    
    tooltip.textContent = text;
    tooltip.style.display = 'block';
    activeTooltipElement = element;
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
    
    setTimeout(() => {
        document.addEventListener('click', hideTooltipOnClickOutside);
    }, 10);
}

function hideUnifiedTooltip() {
    const tooltip = document.getElementById('unifiedTooltip');
    if (tooltip) {
        tooltip.style.display = 'none';
    }
    activeTooltipElement = null;
    document.removeEventListener('click', hideTooltipOnClickOutside);
}

function hideTooltipOnClickOutside(event) {
    const tooltip = document.getElementById('unifiedTooltip');
    if (tooltip && !tooltip.contains(event.target) && (!activeTooltipElement || !activeTooltipElement.contains(event.target))) {
        hideUnifiedTooltip();
    }
}

// ========== بيانات الحالات ==========
const casesData = [
    { id: 1, patientName: 'أحمد محمد علي', caseType: 'حشوة تجميلية', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative', status: 'completed', ratings: 3, ratingDates: ['2024-01-15 10:00', '2024-01-15 10:30', '2024-01-15 11:00'], supervisor: 'د. أحمد النجار', addedDate: '2024-01-08', acceptedDate: '2024-01-10', requiresImages: true, requiresPanorama: true },
    { id: 2, patientName: 'سارة خالد حسن', caseType: 'خلع جراحي', course: 'تخدير و قلع الأسنان 4', courseId: 'exodontia', status: 'inProgress', ratings: 1, ratingDates: ['2024-01-14 14:20', null, null], supervisor: 'د. خالد محمود', addedDate: '2024-01-09', acceptedDate: '2024-01-12', requiresImages: true, requiresPanorama: false },
    { id: 3, patientName: 'محمد عمر النجار', caseType: 'تنظيف جيب', course: 'النسج حول سنية 2', courseId: 'periodontics', status: 'waitingEvaluation', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. سارة عبدالله', addedDate: '2024-01-10', acceptedDate: '2024-01-13', requiresImages: false, requiresPanorama: false },
    { id: 4, patientName: 'لينا أحمد محمود', caseType: 'علاج عصب', course: 'مداواة الأسنان اللبية 4', courseId: 'endodontics', status: 'rejected', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. لينا حسن', addedDate: '2024-01-11', acceptedDate: null, requiresImages: false, requiresPanorama: false },
    { id: 5, patientName: 'خالد سعيد رضوان', caseType: 'تاج دائم', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative', status: 'waitingAcceptance', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. أنس أحمد', addedDate: '2024-01-12', acceptedDate: null, requiresImages: false, requiresPanorama: false },
    { id: 6, patientName: 'فاطمة سالم', caseType: 'حشوة تجميلية', course: 'مداواة الأسنان الترميمية 4', courseId: 'restorative', status: 'transferred', ratings: 0, ratingDates: [null, null, null], supervisor: 'د. أحمد النجار', addedDate: '2024-01-13', acceptedDate: null, requiresImages: false, requiresPanorama: false }
];

const imageTypes = [
    { key: 'diagnostic', label: 'أشعة تشخيصية (شعاعية)', icon: 'fa-x-ray', isPanorama: true },
    { key: 'cones', label: 'صورة تجربة أقمار', icon: 'fa-tooth', isPanorama: false },
    { key: 'final', label: 'صورة نهائية', icon: 'fa-check-circle', isPanorama: false },
    { key: 'followup', label: 'صورة متابعة', icon: 'fa-calendar-check', isPanorama: false }
];

// تهيئة البيانات
let studioData = {
    restorative: { panorama: [], regular: [], deleted: [] },
    exodontia: { panorama: [], regular: [], deleted: [] },
    periodontics: { panorama: [], regular: [], deleted: [] },
    endodontics: { panorama: [], regular: [], deleted: [] }
};

const initialPanoramaData = {
    restorative: [
        { id: 'p1_rest', url: 'https://placehold.co/400x225/f59e0b/ffffff?text=شعاعية+ترميمية+1', date: '2024-01-10', status: 'available', usedBy: null, label: 'أشعة أولية' },
        { id: 'p2_rest', url: 'https://placehold.co/400x225/d97706/ffffff?text=شعاعية+ترميمية+2', date: '2024-01-15', status: 'available', usedBy: null, label: 'أشعة نهائية' }
    ],
    exodontia: [
        { id: 'p1_exo', url: 'https://placehold.co/400x225/f59e0b/ffffff?text=شعاعية+قلع+1', date: '2024-01-12', status: 'available', usedBy: null, label: 'بانوراما قبل القلع' }
    ],
    periodontics: [
        { id: 'p1_per', url: 'https://placehold.co/400x225/f59e0b/ffffff?text=شعاعية+نسجية+1', date: '2024-01-14', status: 'available', usedBy: null, label: 'أشعة تشخيصية' }
    ],
    endodontics: [
        { id: 'p1_end', url: 'https://placehold.co/400x225/f59e0b/ffffff?text=شعاعية+لبية+1', date: '2024-01-11', status: 'available', usedBy: null, label: 'أشعة قبل العلاج' },
        { id: 'p2_end', url: 'https://placehold.co/400x225/d97706/ffffff?text=شعاعية+لبية+2', date: '2024-01-16', status: 'available', usedBy: null, label: 'أشعة أثناء العلاج' }
    ]
};

const caseImages = {};
let currentStatusFilter = 'all';
let currentCourseFilter = 'all';
let currentPage = 1;
const casesPerPage = 5;
let currentOpenCaseId = null;
let currentImageSlot = null;
let currentStudioTab = 'regular';
let selectedStudioImageId = null;
let selectedStudioImageType = null;
let tempUploadFiles = [];
let currentSelectingIsPanorama = false;
let selectedImageUrl = null;
let selectedImageLabel = null;
let currentStudioCourse = null;
let activeTooltipElement = null;

// ========== LocalStorage Functions ==========
function loadFromLocalStorage() {
    try {
        const saved = localStorage.getItem('dentalStudioData_v2');
        if (saved) {
            const parsed = JSON.parse(saved);
            Object.keys(parsed).forEach(courseId => {
                if (studioData[courseId]) {
                    if (parsed[courseId].regular) studioData[courseId].regular = parsed[courseId].regular;
                    if (parsed[courseId].deleted) studioData[courseId].deleted = parsed[courseId].deleted;
                }
            });
            cleanDeletedImages();
        } else {
            Object.keys(initialPanoramaData).forEach(courseId => {
                studioData[courseId].panorama = [...initialPanoramaData[courseId]];
            });
        }
    } catch (e) {
        Object.keys(initialPanoramaData).forEach(courseId => {
            studioData[courseId].panorama = [...initialPanoramaData[courseId]];
        });
    }
}

function saveToLocalStorage() {
    try {
        const dataToSave = {};
        Object.keys(studioData).forEach(courseId => {
            dataToSave[courseId] = {
                regular: studioData[courseId].regular,
                deleted: studioData[courseId].deleted,
                lastUpdated: new Date().toISOString()
            };
        });
        localStorage.setItem('dentalStudioData_v2', JSON.stringify(dataToSave));
    } catch (e) {
        console.error('Error saving to localStorage:', e);
    }
}

function cleanDeletedImages() {
    const now = new Date();
    Object.keys(studioData).forEach(courseId => {
        studioData[courseId].deleted = studioData[courseId].deleted.filter(img => {
            if (!img.deletedAt) return false;
            const deleteTime = new Date(img.deletedAt);
            const hoursPassed = (now - deleteTime) / (1000 * 60 * 60);
            return hoursPassed < 48;
        });
    });
}

// ========== الربط مع الكود الثاني (إضافة حالة) ==========
// تحويل معرفات المقررات من الكود الثاني إلى الأول
const courseMapping = {
    'restorative4': 'restorative',
    'exodontia4': 'exodontia',
    'periodontics2': 'periodontics',
    'endodontics4': 'endodontics'
};

// تحويل نوع المعالجة إلى اسم الحالة
function getCaseTypeFromTreatment(treatmentValue) {
    const mapping = {
        'class2': 'حشوة كلاس 2',
        'class3': 'حشوة كلاس 3',
        'class4': 'حشوة كلاس 4',
        'class5': 'حشوة كلاس 5'
    };
    return mapping[treatmentValue] || 'حشوة تجميلية';
}

// تحميل الحالات من الكود الثاني (من localStorage)
function syncWithAddCaseModule() {
    try {
        const savedReservations = localStorage.getItem('dental_reservations');
        if (!savedReservations) return;
        
        const reservations = JSON.parse(savedReservations);
        let updated = false;
        
        // إضافة الحالات الجديدة من الكود الثاني التي لا وجود لها هنا
        reservations.forEach(reservation => {
            // التحقق مما إذا كانت الحالة موجودة بالفعل (بناءً على معرف فريد)
            const exists = casesData.some(c => 
                c.patientName.includes(reservation.patientId) && 
                c.addedDate === reservation.date &&
                c.caseType === getCaseTypeFromTreatment(reservation.treatmentValue)
            );
            
            if (!exists && reservation.status !== 'deleted' && reservation.status !== 'cancelled') {
                const courseId = courseMapping[reservation.courseId] || 'restorative';
                const newCase = {
                    id: casesData.length + 1000 + Math.floor(Math.random() * 1000), // معرف فريد
                    patientName: `مريض #${reservation.patientId} (من حجز جديد)`,
                    caseType: getCaseTypeFromTreatment(reservation.treatmentValue),
                    course: courseId === 'restorative' ? 'مداواة الأسنان الترميمية 4' : 
                            courseId === 'exodontia' ? 'تخدير و قلع الأسنان 4' :
                            courseId === 'periodontics' ? 'النسج حول سنية 2' : 'مداواة الأسنان اللبية 4',
                    courseId: courseId,
                    status: reservation.status === 'reserved' ? 'waitingAcceptance' : 
                            reservation.status === 'accepted' ? 'inProgress' : 'waitingAcceptance',
                    ratings: 0,
                    ratingDates: [null, null, null],
                    supervisor: 'د. المشرف',
                    addedDate: reservation.date,
                    acceptedDate: reservation.status === 'accepted' ? reservation.date : null,
                    requiresImages: true,
                    requiresPanorama: false
                };
                casesData.push(newCase);
                updated = true;
            }
        });
        
        if (updated) {
            loadCasesTable();
        }
    } catch (e) {
        console.error('Error syncing with add-case module:', e);
    }
}

// ========== Table Functions ==========
function getFilteredCases() {
    let filtered = [...casesData];
    
    if (currentStatusFilter !== 'all') {
        filtered = filtered.filter(c => c.status === currentStatusFilter);
    }
    
    if (currentCourseFilter !== 'all') {
        filtered = filtered.filter(c => c.courseId === currentCourseFilter);
    }
    
    const searchInput = document.getElementById('casesSearch');
    if (searchInput && searchInput.value.trim() !== '') {
        const term = searchInput.value.trim().toLowerCase();
        filtered = filtered.filter(c => 
            c.patientName.toLowerCase().includes(term) ||
            c.course.toLowerCase().includes(term) ||
            c.caseType.toLowerCase().includes(term)
        );
    }
    
    return filtered;
}

function showNoImageHint(event, status) {
    event.stopPropagation();
    let message = '';
    
    switch(status) {
        case 'waitingAcceptance':
            message = 'لا حاجة لرفع الصور: الحالة بانتظار قبول المشرف';
            break;
        case 'rejected':
            message = 'لا حاجة لرفع الصور: الحالة مرفوضة';
            break;
        case 'transferred':
            message = 'لا حاجة لرفع الصور: الحالة محولة لنوع آخر';
            break;
        case 'waitingEvaluation':
            message = 'يتم بدء رفع صور الحالة بعد أول تقييم';
            break;
        default:
            message = 'لا حاجة لرفع صور لهذه الحالة';
    }
    
    showUnifiedTooltip(event, message, event.currentTarget);
}

function loadCasesTable() {
    const tableBody = document.getElementById('casesTableBody');
    if (!tableBody) return;
    
    let filteredCases = getFilteredCases();
    const totalPages = Math.ceil(filteredCases.length / casesPerPage);
    const startIndex = (currentPage - 1) * casesPerPage;
    const endIndex = startIndex + casesPerPage;
    const paginatedCases = filteredCases.slice(startIndex, endIndex);
    
    tableBody.innerHTML = '';
    
    if (paginatedCases.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 40px 20px;"><div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;"><i class="fas fa-search" style="font-size: 24px; color: #9ca3af;"></i></div><div style="font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px;">لا توجد حالات</div></td></tr>`;
        updatePagination(totalPages, filteredCases.length);
        return;
    }
    
    paginatedCases.forEach((caseItem, index) => {
        const row = document.createElement('tr');
        row.style.animationDelay = (index * 0.05) + 's';
        
        let statusText = '', statusClass = '', statusIcon = '';
        
        switch(caseItem.status) {
            case 'completed': 
                statusText = 'مكتمل'; statusClass = 'completed'; statusIcon = 'fa-check-circle';
                break;
            case 'inProgress': 
                statusText = 'قيد الإنجاز'; statusClass = 'inProgress'; statusIcon = 'fa-spinner';
                break;
            case 'waitingEvaluation': 
                statusText = 'بانتظار التقييم'; statusClass = 'waitingEvaluation'; statusIcon = 'fa-clock';
                break;
            case 'waitingAcceptance': 
                statusText = 'بانتظار القبول'; statusClass = 'waitingAcceptance'; statusIcon = 'fa-hourglass-start';
                break;
            case 'rejected': 
                statusText = 'مرفوض'; statusClass = 'rejected'; statusIcon = 'fa-times-circle';
                break;
            case 'transferred': 
                statusText = 'محولة'; statusClass = 'transferred'; statusIcon = 'fa-exchange-alt';
                break;
        }
        
        const statusHtml = `<span class="status-badge ${statusClass}"><i class="fas ${statusIcon}" style="font-size: 10px; margin-left: 4px;"></i>${statusText}</span>`;
        
        let ratingsHtml = '';
        if (caseItem.status === 'waitingAcceptance') {
            ratingsHtml = '<span style="color: #9ca3af; font-size: 12px;">-</span>';
        } else if (caseItem.status === 'rejected' || caseItem.status === 'transferred') {
            const isTransferred = caseItem.status === 'transferred';
            const bg = isTransferred ? '#8b5cf6' : '#ef4444';
            const icon = isTransferred ? 'fa-exchange-alt' : 'fa-times';
            const text = isTransferred ? 'محولة' : 'مرفوض';
            const tooltipText = isTransferred ? 'تم تحويل الحالة إلى نوع آخر' : 'تم رفض الحالة من المشرف';
            
            ratingsHtml = `<div style="display: flex; justify-content: center; gap: 6px; direction: ltr;">
                <div class="rating-checkbox" style="background: ${bg}; color: white; width: 80px; border-radius: 12px; font-size: 11px;" onclick="showUnifiedTooltip(event, '${tooltipText}', this)">
                    <i class="fas ${icon}"></i> ${text}
                </div>
            </div>`;
        } else {
            ratingsHtml = '<div style="display: flex; justify-content: center; gap: 6px; direction: ltr;">';
            for (let i = 1; i <= 3; i++) {
                let bg, icon, color, tooltipText;
                if (i <= caseItem.ratings) {
                    bg = '#10b981'; icon = 'fa-check'; color = 'white';
                    tooltipText = caseItem.ratingDates && caseItem.ratingDates[i-1] ? `تم التقييم: ${caseItem.ratingDates[i-1]}` : 'تم التقييم';
                } else {
                    bg = '#e5e7eb'; icon = ''; color = '#9ca3af';
                    tooltipText = 'لم يتم التقييم';
                }
                ratingsHtml += `<div class="rating-checkbox" style="background: ${bg}; color: ${color};" onclick="showUnifiedTooltip(event, '${tooltipText}', this)">${icon ? `<i class="fas ${icon}"></i>` : i}</div>`;
            }
            ratingsHtml += '</div>';
        }
        
        let imagesHtml = '';
        if (caseItem.status === 'rejected' || caseItem.status === 'transferred' || caseItem.status === 'waitingAcceptance' || caseItem.status === 'waitingEvaluation') {
            imagesHtml = `<div class="images-icon not-required" onclick="showNoImageHint(event, '${caseItem.status}')">-</div>`;
        } else if (caseItem.requiresImages) {
            imagesHtml = `<div class="images-icon required" onclick="event.stopPropagation(); openCaseImagesModal(${caseItem.id});"><i class="fas fa-images"></i></div>`;
        } else {
            imagesHtml = `<div class="images-icon not-required" onclick="showNoImageHint(event, 'none')">-</div>`;
        }
        
        const addedDateHtml = caseItem.addedDate ? `<span style="direction: ltr; display: inline-block;">${caseItem.addedDate}</span>` : '<span style="color: #9ca3af;">-</span>';
        const acceptedDateHtml = caseItem.acceptedDate ? `<span style="direction: ltr; display: inline-block;">${caseItem.acceptedDate}</span>` : '<span style="color: #9ca3af;">-</span>';
        
        row.innerHTML = `
            <td style="padding: clamp(10px, 2.5vw, 14px);"><span style="font-weight: 700; color: #1f2937; font-size: clamp(0.8125rem, 2.2vw, 0.9375rem); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 150px;">${caseItem.patientName}</span></td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;"><span style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 6px 10px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap; display: inline-block; max-width: 120px; overflow: hidden; text-overflow: ellipsis;">${caseItem.caseType}</span></td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;"><span style="font-size: 13px; font-weight: 600; color: var(--dark); white-space: nowrap;">${caseItem.course}</span></td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${statusHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${ratingsHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;">${imagesHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center;"><span style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 6px 10px; border-radius: 20px; font-size: clamp(0.6875rem, 1.8vw, 0.8125rem); font-weight: 700; white-space: nowrap;">${caseItem.supervisor}</span></td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-size: clamp(0.75rem, 2vw, 0.875rem); white-space: nowrap;">${addedDateHtml}</td>
            <td style="padding: clamp(10px, 2.5vw, 14px); text-align: center; color: #64748b; font-size: clamp(0.75rem, 2vw, 0.875rem); white-space: nowrap;">${acceptedDateHtml}</td>
        `;
        tableBody.appendChild(row);
    });
    
    updatePagination(totalPages, filteredCases.length);
}

function updatePagination(totalPages, totalItems) {
    const paginationDiv = document.getElementById('casesPagination');
    if (totalPages <= 1) {
        paginationDiv.style.display = 'none';
        return;
    }
    paginationDiv.style.display = 'flex';
    document.getElementById('casesPageIndicator').textContent = `صفحة ${currentPage} من ${totalPages}`;
    
    const prevBtn = document.getElementById('casesPrevBtn');
    const nextBtn = document.getElementById('casesNextBtn');
    
    prevBtn.disabled = currentPage === 1;
    prevBtn.style.opacity = currentPage === 1 ? '0.5' : '1';
    prevBtn.style.cursor = currentPage === 1 ? 'not-allowed' : 'pointer';
    
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.style.opacity = currentPage === totalPages ? '0.5' : '1';
    nextBtn.style.cursor = currentPage === totalPages ? 'not-allowed' : 'pointer';
}

function changeCasesPage(direction) {
    if (direction === 'prev' && currentPage > 1) {
        currentPage--;
        loadCasesTable();
    } else if (direction === 'next') {
        const filtered = getFilteredCases();
        const totalPages = Math.ceil(filtered.length / casesPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            loadCasesTable();
        }
    }
}

function searchCases() {
    currentPage = 1;
    loadCasesTable();
}

// ========== Image Modal Functions ==========
function openCaseImagesModal(caseId) {
    currentOpenCaseId = caseId;
    const caseItem = casesData.find(c => c.id === caseId);
    if (!caseItem) return;
    
    currentStudioCourse = caseItem.courseId;
    
    document.getElementById('modalCaseName').textContent = `المريض: ${caseItem.patientName} | ${caseItem.caseType}`;
    document.getElementById('caseImagesModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    renderCaseImages();
}

function closeCaseImagesModal() {
    document.getElementById('caseImagesModal').style.display = 'none';
    document.body.style.overflow = '';
    currentOpenCaseId = null;
}

function renderCaseImages() {
    const grid = document.getElementById('caseImagesGrid');
    grid.innerHTML = '';
    
    if (!caseImages[currentOpenCaseId]) caseImages[currentOpenCaseId] = {};
    const caseItem = casesData.find(c => c.id === currentOpenCaseId);
    if (!caseItem) return;
    
    imageTypes.forEach((type) => {
        if (type.isPanorama && !caseItem.requiresPanorama) return;
        
        const existingImage = caseImages[currentOpenCaseId][type.key];
        const slot = document.createElement('div');
        
        if (existingImage) {
            slot.innerHTML = `
                <div style="position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <img src="${existingImage.url}" onerror="this.src='https://placehold.co/400x300/ef4444/ffffff?text=خطأ+في+الصورة'" onclick="openImageViewer('${existingImage.url}', '${existingImage.label}')" style="width: 100%; aspect-ratio: ${type.isPanorama ? '16/9' : '1'}; object-fit: cover; display: block; cursor: pointer;">
                    <div style="position: absolute; top: 8px; left: 8px; display: flex; gap: 8px;">
                        <button onclick="event.stopPropagation(); removeCaseImage('${type.key}')" style="background: #ef4444; color: white; border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 20px 8px 8px;">
                        <div style="color: white; font-size: 12px; font-weight: 600; text-align: center;">${type.label}</div>
                    </div>
                </div>
            `;
        } else {
            slot.innerHTML = `
                <div onclick="openStudioForSlot('${type.key}', ${type.isPanorama})" style="border: 2px dashed #d1d5db; border-radius: 16px; padding: 30px 15px; text-align: center; cursor: pointer; transition: all 0.2s; background: #f9fafb; aspect-ratio: ${type.isPanorama ? '16/9' : '1'}; display: flex; flex-direction: column; align-items: center; justify-content: center;" onmouseover="this.style.borderColor='var(--primary)'; this.style.background='rgba(99,102,241,0.03)'" onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f9fafb'">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; color: white; font-size: 20px;">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div style="color: var(--dark); font-weight: 600; font-size: 13px; margin-bottom: 4px;">اختر من الاستديو</div>
                    <div style="color: var(--gray); font-size: 11px;">${type.label}</div>
                </div>
            `;
        }
        grid.appendChild(slot);
    });
}

function openImageViewer(url, label) {
    document.getElementById('viewerImage').src = url;
    document.getElementById('viewerLabel').textContent = label || '';
    document.getElementById('imageViewerModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeImageViewer() {
    document.getElementById('imageViewerModal').style.display = 'none';
    document.getElementById('viewerImage').src = '';
    if (document.getElementById('caseImagesModal').style.display === 'none') {
        document.body.style.overflow = '';
    }
}

// ========== Studio Functions ==========
function openStudioForSlot(imageType, isPanorama) {
    currentImageSlot = imageType;
    currentSelectingIsPanorama = isPanorama;
    openStudioModal();
}

function openStudioModal() {
    if (!currentStudioCourse) {
        showToast('يجب تحديد المقرر أولاً', 'error');
        return;
    }
    
    const caseItem = casesData.find(c => c.id === currentOpenCaseId);
    const courseName = caseItem ? caseItem.course : 'المقرر الحالي';
    
    document.getElementById('studioCourseName').textContent = `استديو خاص بمقرر: ${courseName}`;
    document.getElementById('studioModal').style.display = 'block';
    
    if (currentSelectingIsPanorama) {
        switchStudioTab('panorama');
    } else {
        switchStudioTab('regular');
    }
    
    updateDeletedCount();
}

function closeStudioModal() {
    document.getElementById('studioModal').style.display = 'none';
    currentImageSlot = null;
    currentSelectingIsPanorama = false;
    selectedStudioImageId = null;
    selectedStudioImageType = null;
    selectedImageUrl = null;
    selectedImageLabel = null;
}

function switchStudioTab(tab) {
    currentStudioTab = tab;
    
    document.getElementById('studio-regular-section').style.display = 'none';
    document.getElementById('studio-panorama-section').style.display = 'none';
    document.getElementById('studio-deleted-section').style.display = 'none';
    
    document.getElementById('tab-regular').style.cssText = 'flex: 1; padding: 12px; background: transparent; border: none; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 13px;';
    document.getElementById('tab-panorama').style.cssText = 'flex: 1; padding: 12px; background: transparent; border: none; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 13px;';
    document.getElementById('tab-deleted').style.cssText = 'flex: 1; padding: 12px; background: transparent; border: none; border-bottom: 2px solid transparent; color: #6b7280; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 13px; position: relative;';
    
    if (tab === 'regular') {
        document.getElementById('studio-regular-section').style.display = 'block';
        document.getElementById('tab-regular').style.cssText = 'flex: 1; padding: 12px; background: white; border: none; border-bottom: 2px solid var(--primary); color: var(--primary); font-weight: 700; cursor: pointer; font-family: inherit; font-size: 13px;';
        renderRegularImages();
    } else if (tab === 'panorama') {
        document.getElementById('studio-panorama-section').style.display = 'block';
        document.getElementById('tab-panorama').style.cssText = 'flex: 1; padding: 12px; background: white; border: none; border-bottom: 2px solid #f59e0b; color: #f59e0b; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 13px;';
        renderPanoramaImages();
    } else if (tab === 'deleted') {
        document.getElementById('studio-deleted-section').style.display = 'block';
        document.getElementById('tab-deleted').style.cssText = 'flex: 1; padding: 12px; background: white; border: none; border-bottom: 2px solid var(--primary); color: var(--primary); font-weight: 700; cursor: pointer; font-family: inherit; font-size: 13px; position: relative;';
        renderDeletedImages();
    }
}

function renderPanoramaImages() {
    const grid = document.getElementById('studioPanoramaGrid');
    grid.innerHTML = '';
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-x-ray" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>لا توجد صور شعاعية</div></div>';
        return;
    }
    
    const panoramaImages = studioData[currentStudioCourse].panorama;
    
    if (panoramaImages.length === 0) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-x-ray" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>لا توجد صور شعاعية</div></div>';
        return;
    }
    
    panoramaImages.forEach(img => {
        const div = document.createElement('div');
        div.className = `studio-image-item panorama ${img.status === 'in-use' ? 'in-use' : ''}`;
        
        if (img.status !== 'in-use') {
            div.onclick = function(e) {
                e.stopPropagation();
                handleImageSelect(img.id, 'panorama', img.url, img.label);
            };
        }
        
        div.innerHTML = `
            <img src="${img.url}" onerror="this.src='https://placehold.co/400x225/ef4444/ffffff?text=صورة+غير+متوفرة'" style="width: 100%; height: 100%; object-fit: cover;">
            ${img.label ? `<div class="image-label">${img.label}</div>` : ''}
        `;
        grid.appendChild(div);
    });
}

function groupImagesByDate(images) {
    const grouped = {};
    images.forEach(img => {
        if (!grouped[img.date]) grouped[img.date] = [];
        grouped[img.date].push(img);
    });
    return grouped;
}

function handleImageSelect(imageId, imageType, url, label) {
    if (currentSelectingIsPanorama && imageType !== 'panorama') {
        showToast('هذه الحالة تتطلب صورة شعاعية فقط', 'error');
        return;
    }
    if (!currentSelectingIsPanorama && imageType === 'panorama') {
        showToast('لا يمكن اختيار صورة شعاعية لهذا النوع', 'error');
        return;
    }
    
    selectedStudioImageId = imageId;
    selectedStudioImageType = imageType;
    selectedImageUrl = url;
    selectedImageLabel = label;
    
    document.getElementById('optionsImageLabel').textContent = label || 'صورة بدون تسمية';
    
    const deleteBtn = document.getElementById('deleteImageBtn');
    if (imageType === 'panorama') {
        deleteBtn.style.display = 'none';
    } else {
        deleteBtn.style.display = 'flex';
    }
    
    document.getElementById('imageOptionsModal').style.display = 'block';
}

function renderRegularImages() {
    const regularGrid = document.getElementById('studioRegularGrid');
    regularGrid.innerHTML = '';
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        regularGrid.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-images" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>لا توجد صور متاحة</div></div>';
        return;
    }
    
    const availableRegular = studioData[currentStudioCourse].regular.filter(img => img.status === 'available');
    const grouped = groupImagesByDate(availableRegular);
    const sortedDates = Object.keys(grouped).sort((a, b) => new Date(b) - new Date(a));
    
    if (sortedDates.length === 0) {
        regularGrid.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-images" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>لا توجد صور متاحة</div><div style="font-size: 12px; margin-top: 8px;">ارفع صوراً من الموبايل</div></div>';
    } else {
        sortedDates.forEach(date => {
            const dateGroup = document.createElement('div');
            const dateHeader = document.createElement('div');
            dateHeader.className = 'date-header';
            dateHeader.innerHTML = `<i class="fas fa-calendar-alt"></i>${formatDate(date)}`;
            dateGroup.appendChild(dateHeader);
            
            const grid = document.createElement('div');
            grid.style.cssText = 'display: grid; grid-template-columns: 1fr 1fr; gap: 12px;';
            
            grouped[date].forEach(img => {
                const div = document.createElement('div');
                div.className = 'studio-image-item';
                div.style.cursor = 'pointer';
                
                div.setAttribute('data-id', img.id);
                div.setAttribute('data-type', 'regular');
                div.setAttribute('data-url', img.url);
                div.setAttribute('data-label', img.label || '');
                
                div.onclick = function(e) {
                    e.stopPropagation();
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    const url = this.getAttribute('data-url');
                    const label = this.getAttribute('data-label');
                    handleImageSelect(id, type, url, label);
                };
                
                div.innerHTML = `
                    <img src="${img.url}" onerror="this.src='https://placehold.co/200x200/ef4444/ffffff?text=خطأ'" style="width: 100%; height: 100%; object-fit: cover;">
                    ${img.label ? `<div class="image-label">${img.label}</div>` : ''}
                `;
                grid.appendChild(div);
            });
            
            dateGroup.appendChild(grid);
            regularGrid.appendChild(dateGroup);
        });
    }
}

function closeImageOptions() {
    document.getElementById('imageOptionsModal').style.display = 'none';
}

function viewSelectedImage() {
    if (selectedImageUrl) {
        closeImageOptions();
        openImageViewer(selectedImageUrl, selectedImageLabel);
    }
}

function selectImageForCase() {
    if (!selectedStudioImageId || !selectedStudioImageType) {
        showToast('خطأ: لم يتم تحديد الصورة بشكل صحيح', 'error');
        return;
    }
    
    if (!currentOpenCaseId) {
        showToast('خطأ: لم يتم تحديد الحالة', 'error');
        return;
    }
    
    const caseItem = casesData.find(c => c.id === currentOpenCaseId);
    if (!caseItem) return;
    
    closeImageOptions();
    
    document.getElementById('confirmCaseType').textContent = caseItem.caseType;
    document.getElementById('confirmPatientName').textContent = caseItem.patientName;
    document.getElementById('selectConfirmModal').style.display = 'block';
}

function cancelSelectConfirm() {
    document.getElementById('selectConfirmModal').style.display = 'none';
    selectedStudioImageId = null;
    selectedStudioImageType = null;
    selectedImageUrl = null;
    selectedImageLabel = null;
}

function confirmSelectImage() {
    document.getElementById('selectConfirmModal').style.display = 'none';
    
    if (!selectedStudioImageId || !selectedStudioImageType) {
        showToast('خطأ: لم يتم تحديد الصورة', 'error');
        return;
    }
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        showToast('خطأ: لم يتم تحديد المقرر', 'error');
        return;
    }
    
    const imageArray = selectedStudioImageType === 'panorama' ? 
        studioData[currentStudioCourse].panorama : 
        studioData[currentStudioCourse].regular;
    
    const image = imageArray.find(img => img.id === selectedStudioImageId);
    
    if (!image) {
        showToast('الصورة غير موجودة في الاستديو', 'error');
        return;
    }
    
    if (image.status !== 'available') {
        showToast('هذه الصورة غير متاحة (قد تكون مستخدمة)', 'error');
        return;
    }
    
    image.status = 'in-use';
    image.usedBy = currentOpenCaseId;
    saveToLocalStorage();
    
    if (!caseImages[currentOpenCaseId]) caseImages[currentOpenCaseId] = {};
    
    const imageTypeObj = imageTypes.find(t => t.key === currentImageSlot);
    caseImages[currentOpenCaseId][currentImageSlot] = {
        url: image.url,
        label: image.label,
        typeLabel: imageTypeObj ? imageTypeObj.label : '',
        studioId: selectedStudioImageId,
        studioType: selectedStudioImageType
    };
    
    closeStudioModal();
    renderCaseImages();
    showToast('تمت إضافة الصورة بنجاح', 'success');
    
    selectedStudioImageId = null;
    selectedStudioImageType = null;
    selectedImageUrl = null;
    selectedImageLabel = null;
}

function moveToTrashFromOptions() {
    if (!selectedStudioImageId) {
        showToast('خطأ: لم يتم تحديد الصورة', 'error');
        return;
    }
    
    if (selectedStudioImageType === 'panorama') {
        showToast('لا يمكن حذف الصور الشعاعية', 'error');
        closeImageOptions();
        return;
    }
    
    closeImageOptions();
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) return;
    
    const index = studioData[currentStudioCourse].regular.findIndex(img => img.id === selectedStudioImageId);
    if (index === -1) {
        showToast('الصورة غير موجودة', 'error');
        return;
    }
    
    const image = studioData[currentStudioCourse].regular[index];
    
    if (image.status === 'in-use') {
        showToast('لا يمكن حذف صورة مستخدمة في حالة', 'error');
        return;
    }
    
    const deletedImage = {
        ...image,
        status: 'deleted',
        deletedAt: new Date().toISOString()
    };
    
    studioData[currentStudioCourse].deleted.push(deletedImage);
    studioData[currentStudioCourse].regular.splice(index, 1);
    saveToLocalStorage();
    
    renderRegularImages();
    updateDeletedCount();
    showToast('تم نقل الصورة لسلة المحذوفات', 'info');
    
    selectedStudioImageId = null;
    selectedStudioImageType = null;
    selectedImageUrl = null;
    selectedImageLabel = null;
}

function renderDeletedImages() {
    const grid = document.getElementById('deletedImagesGrid');
    grid.innerHTML = '';
    
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;">لا توجد صور محذوفة</div>';
        updateDeletedCount();
        return;
    }
    
    cleanDeletedImages();
    
    const deletedImages = studioData[currentStudioCourse].deleted;
    
    if (deletedImages.length === 0) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;"><i class="fas fa-trash-alt" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3; display: block;"></i><div>سلة المحذوفات فارغة</div></div>';
        updateDeletedCount();
        return;
    }
    
    const now = new Date();
    deletedImages.forEach(img => {
        const deleteTime = new Date(img.deletedAt);
        const hoursLeft = Math.max(0, 48 - ((now - deleteTime) / (1000 * 60 * 60)));
        const hours = Math.floor(hoursLeft);
        const minutes = Math.floor((hoursLeft - hours) * 60);
        
        const div = document.createElement('div');
        div.className = 'deleted-item studio-image-item';
        div.style.cssText = 'border: 2px solid #fecaca;';
        div.innerHTML = `
            <img src="${img.url}" onerror="this.src='https://placehold.co/200x200/9ca3af/ffffff?text=محذوف'" style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(0.5);">
            ${img.label ? `<div class="image-label">${img.label}</div>` : ''}
            <div class="time-left">${hours}س ${minutes}د</div>
            <button class="restore-btn" onclick="restoreImage('${img.id}')">
                <i class="fas fa-undo" style="margin-left: 4px;"></i>استرداد
            </button>
        `;
        grid.appendChild(div);
    });
    
    updateDeletedCount();
}

function updateDeletedCount() {
    if (!currentStudioCourse || !studioData[currentStudioCourse]) return;
    
    const count = studioData[currentStudioCourse].deleted.length;
    const badge = document.getElementById('deletedCount');
    if (count > 0) {
        badge.textContent = count;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }
}

function restoreImage(imageId) {
    if (!currentStudioCourse || !studioData[currentStudioCourse]) return;
    
    const index = studioData[currentStudioCourse].deleted.findIndex(img => img.id === imageId);
    if (index > -1) {
        const image = studioData[currentStudioCourse].deleted[index];
        const restoredImage = {...image};
        delete restoredImage.deletedAt;
        restoredImage.status = 'available';
        studioData[currentStudioCourse].regular.push(restoredImage);
        studioData[currentStudioCourse].deleted.splice(index, 1);
        
        saveToLocalStorage();
        
        renderDeletedImages();
        renderRegularImages();
        updateDeletedCount();
        showToast('تم استرداد الصورة بنجاح', 'success');
    }
}

function removeCaseImage(imageType) {
    if (!currentOpenCaseId) {
        showToast('خطأ: لم يتم تحديد الحالة', 'error');
        return;
    }
    
    if (!caseImages[currentOpenCaseId] || !caseImages[currentOpenCaseId][imageType]) {
        showToast('الصورة غير موجودة في الحالة', 'error');
        return;
    }
    
    const image = caseImages[currentOpenCaseId][imageType];
    
    if (!image.studioId || !image.studioType) {
        showToast('خطأ: معلومات الصورة غير مكتملة', 'error');
        delete caseImages[currentOpenCaseId][imageType];
        renderCaseImages();
        return;
    }
    
    const caseItem = casesData.find(c => c.id === currentOpenCaseId);
    const courseId = caseItem ? caseItem.courseId : currentStudioCourse;
    
    if (courseId && studioData[courseId]) {
        let studioImg = null;
        if (image.studioType === 'panorama') {
            studioImg = studioData[courseId].panorama.find(img => img.id === image.studioId);
        } else {
            studioImg = studioData[courseId].regular.find(img => img.id === image.studioId);
        }
        
        if (studioImg) {
            studioImg.status = 'available';
            studioImg.usedBy = null;
        }
        
        saveToLocalStorage();
    }
    
    delete caseImages[currentOpenCaseId][imageType];
    renderCaseImages();
    showToast('تم إزالة الصورة وإرجاعها للاستديو', 'success');
}

// ========== Upload Functions ==========
function checkMobileUploadAllowed() {
    if (currentSelectingIsPanorama) {
        showToast('الصور الشعاعية يجب اختيارها من الاستديو فقط', 'error');
        return;
    }
    document.getElementById('mobileUploadInput').click();
}

function handleMobileUpload(event) {
    const files = Array.from(event.target.files);
    if (!files || files.length === 0) return;
    
    const allowedExtensions = ['jpg', 'jpeg', 'png', 'heic', 'heif'];
    const validFiles = [];
    
    files.forEach(file => {
        const ext = file.name.split('.').pop().toLowerCase();
        if (allowedExtensions.includes(ext)) {
            validFiles.push(file);
        } else {
            showToast(`صيغة ${ext} غير مدعومة`, 'error');
        }
    });
    
    if (validFiles.length === 0) return;
    
    tempUploadFiles = [];
    let processedCount = 0;
    
    const progressContainer = document.getElementById('uploadProgressContainer');
    const progressBar = document.getElementById('uploadProgressBar');
    const progressText = document.getElementById('uploadProgressText');
    
    progressContainer.style.display = 'block';
    
    validFiles.forEach((file) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            tempUploadFiles.push({
                file: file,
                url: e.target.result
            });
            
            processedCount++;
            const progress = Math.round((processedCount / validFiles.length) * 100);
            progressBar.style.width = progress + '%';
            progressText.textContent = progress + '%';
            
            if (processedCount === validFiles.length) {
                setTimeout(() => {
                    progressContainer.style.display = 'none';
                    progressBar.style.width = '0%';
                    showUploadLabelsModal();
                }, 500);
            }
        };
        reader.readAsDataURL(file);
    });
    
    event.target.value = '';
}

function showUploadLabelsModal() {
    const container = document.getElementById('uploadLabelsContainer');
    container.innerHTML = '';
    
    tempUploadFiles.forEach((item, index) => {
        const div = document.createElement('div');
        div.style.cssText = 'background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px;';
        div.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <img src="${item.url}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" onerror="this.style.display='none'">
                <div style="flex: 1; font-size: 12px; color: #6b7280; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${item.file.name}</div>
            </div>
            <input type="text" id="label-${index}" placeholder="وصف الصورة (اختياري)" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-family: inherit; font-size: 13px; box-sizing: border-box;">
        `;
        container.appendChild(div);
    });
    
    document.getElementById('uploadLabelsModal').style.display = 'block';
}

function saveUploadLabels() {
    if (!currentStudioCourse || !studioData[currentStudioCourse]) {
        showToast('خطأ: لم يتم تحديد المقرر', 'error');
        return;
    }
    
    const today = new Date().toISOString().split('T')[0];
    let savedCount = 0;
    
    if (tempUploadFiles.length === 0) {
        document.getElementById('uploadLabelsModal').style.display = 'none';
        return;
    }
    
    tempUploadFiles.forEach((item, index) => {
        const labelInput = document.getElementById(`label-${index}`);
        const label = labelInput ? labelInput.value.trim() : '';
        
        const newId = 'img_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        const newImage = {
            id: newId,
            url: item.url,
            date: today,
            status: 'available',
            usedBy: null,
            label: label || 'صورة مرفوعة',
            isDataUrl: true
        };
        
        studioData[currentStudioCourse].regular.push(newImage);
        savedCount++;
        
        if (savedCount === tempUploadFiles.length) {
            saveToLocalStorage();
            document.getElementById('uploadLabelsModal').style.display = 'none';
            tempUploadFiles = [];
            renderRegularImages();
            showToast(`تم رفع ${savedCount} صورة بنجاح`, 'success');
        }
    });
}

// ========== Utility Functions ==========
function formatDate(dateStr) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateStr).toLocaleDateString('ar-SA', options);
}

function showToast(message, type = 'info') {
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `
        position: fixed;
        top: 100px;
        left: 50%;
        transform: translateX(-50%);
        padding: 16px 28px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        z-index: 100000;
        animation: slideDown 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        font-family: inherit;
        min-width: 250px;
        text-align: center;
    `;
    
    const colors = {
        success: 'linear-gradient(135deg, #10b981, #059669)',
        error: 'linear-gradient(135deg, #ef4444, #dc2626)',
        info: 'linear-gradient(135deg, var(--primary), var(--primary-light))',
        warning: 'linear-gradient(135deg, #f59e0b, #fbbf24)'
    };
    
    toast.style.background = colors[type] || colors.info;
    toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}" style="margin-left: 8px;"></i>${message}`;
    
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ========== Event Listeners ==========
document.addEventListener('DOMContentLoaded', function() {
    loadFromLocalStorage();
    
    // مزامنة البيانات مع الكود الثاني
    syncWithAddCaseModule();
    
    loadCasesTable();
    
    const searchInput = document.getElementById('casesSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => { searchCases(); }, 300);
        });
    }
    
    // الاستماع لتغييرات localStorage من الكود الثاني
    window.addEventListener('storage', function(e) {
        if (e.key === 'dental_reservations' || e.key === 'dental_manh_cases') {
            syncWithAddCaseModule();
        }
    });
    
    // تنظيف الصور المحذوفة كل دقيقة
    setInterval(() => {
        let updated = false;
        Object.keys(studioData).forEach(courseId => {
            if (studioData[courseId].deleted.length > 0) {
                const beforeCount = studioData[courseId].deleted.length;
                cleanDeletedImages();
                if (studioData[courseId].deleted.length !== beforeCount) {
                    updated = true;
                }
            }
        });
        
        if (updated) {
            saveToLocalStorage();
            if (currentStudioTab === 'deleted') {
                renderDeletedImages();
            }
            updateDeletedCount();
        }
    }, 60000);
});

window.addEventListener('scroll', function() {
    if (activeTooltipElement && document.getElementById('unifiedTooltip').style.display !== 'none') {
        const tooltip = document.getElementById('unifiedTooltip');
        const rect = activeTooltipElement.getBoundingClientRect();
        tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
    }
}, true);

window.onclick = function(event) {
    if (event.target.id === 'caseImagesModal') closeCaseImagesModal();
    if (event.target.id === 'studioModal') closeStudioModal();
    if (event.target.id === 'imageViewerModal') closeImageViewer();
    if (event.target.id === 'imageOptionsModal') closeImageOptions();
    if (event.target.id === 'selectConfirmModal') cancelSelectConfirm();
    if (event.target.id === 'uploadLabelsModal') {
        document.getElementById('uploadLabelsModal').style.display = 'none';
    }
}
