// ========== نظام الأسنان FDI ==========
let selectedTeeth = {}; 
let currentToothNumber = null;
let currentCondition = null;
let pendingSubCondition = null; 
let pendingSubLabel = null;
let addedStudents = []; 
let addedDiseases = []; 
let patientsData = []; 

// ========== نظام القلح ==========
let periodontalData = {};
let currentSegment = null;

// ========== تصنيف العمر وولي الأمر ==========
function selectAgeType(type) {
    document.querySelectorAll('.age-type-option').forEach(opt => {
        opt.classList.remove('selected');
        const icon = opt.querySelector('i');
        if (icon) icon.style.color = '#9ca3af';
    });

    const selectedRadio = document.querySelector(`input[name="ageType"][value="${type}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.age-type-option');
        if (label) {
            label.classList.add('selected');
            const icon = label.querySelector('i');
            if (icon) icon.style.color = '#4f46e5';
        }
    }

    updateAgeTypeVisibility(type);
}

function updateAgeTypeVisibility(type) {
    const parentSection = document.getElementById('parentInfoSection');
    const primaryTeethSection = document.getElementById('primaryTeethSection');
    const patientPhoneSection = document.getElementById('patientPhoneSection');
    
    if (type === 'child') {
        if (parentSection) parentSection.style.display = 'block';
        if (primaryTeethSection) primaryTeethSection.style.display = 'block';
        if (patientPhoneSection) patientPhoneSection.style.display = 'none';
        
        const patientPhone = document.getElementById('patientPhone');
        if (patientPhone) patientPhone.value = '';
    } else {
        if (parentSection) {
            parentSection.style.opacity = '0';
            setTimeout(() => { parentSection.style.display = 'none'; }, 300);
        }
        if (primaryTeethSection) {
            primaryTeethSection.style.opacity = '0';
            setTimeout(() => { primaryTeethSection.style.display = 'none'; }, 300);
        }
        if (patientPhoneSection) patientPhoneSection.style.display = 'block';
        
        const parentName = document.getElementById('parentName');
        const parentPhone = document.getElementById('parentPhone');
        const parentBirthYear = document.getElementById('parentBirthYear');
        if (parentName) parentName.value = '';
        if (parentPhone) parentPhone.value = '';
        if (parentBirthYear) parentBirthYear.value = '';
    }
}

// ========== نظام الأسنان FDI ==========
function selectTooth(toothNumber) {
    currentToothNumber = toothNumber;
    const toothNumEl = document.getElementById('selectedToothNumber');
    if (toothNumEl) toothNumEl.textContent = toothNumber;
    
    const modal = document.getElementById('toothModal');
    if (modal) {
        modal.classList.add('active');
        modal.style.display = 'flex';
    }
}

function closeToothModal() {
    const modal = document.getElementById('toothModal');
    if (modal) {
        modal.classList.remove('active');
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }
}

function closeSubConditionModal() {
    const modal = document.getElementById('subConditionModal');
    if (modal) {
        modal.classList.remove('active');
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }
    
    const confirmBtn = document.getElementById('confirmSubConditionBtn');
    if (confirmBtn) confirmBtn.style.display = 'none';
    
    currentCondition = null;
    pendingSubCondition = null;
    pendingSubLabel = null;
}

function selectToothCondition(condition) {
    currentCondition = condition;

    if (condition === 'missing') {
        applyToothCondition('missing', 'غير موجود');
        closeToothModal();
        return;
    }

    let title = '';
    let options = [];
    let themeColor = '';

    if (condition === 'restorative') {
        title = '<i class="fas fa-fill-drip" style="margin-left: 8px; color: #3b82f6;"></i> ترميمية - اختر الصنف';
        themeColor = '#3b82f6';
        options = [
            { value: 'class1', label: 'Class I', desc: 'حفرة في السطح الإطباقي' },
            { value: 'class2', label: 'Class II', desc: 'حفرة في السطح القريب للأرحاء' },
            { value: 'class3', label: 'Class III', desc: 'حفرة في السطح القريب للأمامية' },
            { value: 'class4', label: 'Class IV', desc: 'حفرة تشمل زاوية القاطعة' },
            { value: 'class5', label: 'Class V', desc: 'حفرة في الثلث اللثوي' }
        ];
    } else if (condition === 'endodontic') {
        title = '<i class="fas fa-syringe" style="margin-left: 8px; color: #f59e0b;"></i> لبية - اختر النوع';
        themeColor = '#f59e0b';
        options = [
            { value: 'full', label: 'سن كامل', desc: 'معالجة لبية كاملة' },
            { value: 'root', label: 'جذر فقط', desc: 'معالجة لبية للجذر فقط' },
            { value: 'retreat_full', label: 'إعادة معالجة', desc: 'إعادة المعالجة للسن الكامل' },
            { value: 'retreat_root', label: 'إعادة جذر', desc: 'إعادة المعالجة للجذر فقط' }
        ];
    } else if (condition === 'extraction') {
        title = '<i class="fas fa-tooth" style="margin-left: 8px; color: #ef4444;"></i> قلع - اختر النوع';
        themeColor = '#ef4444';
        options = [
            { value: 'simple', label: 'قلع بسيط', desc: 'سن ظاهر وسهل القلع' },
            { value: 'surgical', label: 'قلع جراحي', desc: 'سن منطمر أو جزئي الانبثاق' },
            { value: 'root', label: 'قلع جذر', desc: 'إزالة بقايا الجذر فقط' },
            { value: 'mobile', label: 'سن متحرك', desc: 'سن متقلقل بسبب التهاب اللثة' }
        ];
    }

    closeToothModal();

    const confirmBtn = document.getElementById('confirmSubConditionBtn');
    if (confirmBtn) confirmBtn.style.display = 'none';
    
    pendingSubCondition = null;
    pendingSubLabel = null;

    const subTitle = document.getElementById('subConditionTitle');
    if (subTitle) subTitle.innerHTML = title;
    
    const subOptions = document.getElementById('subConditionOptions');
    if (subOptions) {
        subOptions.innerHTML = options.map(opt => `
            <div class="tooth-sub-option" data-value="${opt.value}" data-label="${opt.label}" onclick="selectSubCondition('${opt.value}', '${opt.label}', '${themeColor}')" 
                 style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer; transition: all 0.2s; margin-bottom: 10px; background: white;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; background: ${themeColor}15; border: 2px solid ${themeColor}; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 13px; font-weight: 800; color: ${themeColor};">${opt.label.substring(0, 2).toUpperCase()}</span>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: #1f2937; font-size: 15px; margin-bottom: 2px;">${opt.label}</div>
                        <div style="font-size: 12px; color: #6b7280;">${opt.desc}</div>
                    </div>
                </div>
                <i class="fas fa-circle sub-check" style="color: #e5e7eb; font-size: 22px; transition: all 0.2s;"></i>
            </div>
        `).join('');
    }

    const subModal = document.getElementById('subConditionModal');
    if (subModal) {
        subModal.classList.add('active');
        subModal.style.display = 'flex';
    }
}

function selectSubCondition(value, label, color) {
    pendingSubCondition = value;
    pendingSubLabel = label;

    document.querySelectorAll('.tooth-sub-option').forEach(opt => {
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
        opt.classList.remove('selected');
        const check = opt.querySelector('.sub-check');
        if (check) {
            check.className = 'fas fa-circle sub-check';
            check.style.color = '#e5e7eb';
        }
    });

    const selectedOpt = document.querySelector(`.tooth-sub-option[data-value="${value}"]`);
    if (selectedOpt) {
        selectedOpt.style.borderColor = color;
        selectedOpt.style.background = color + '15';
        selectedOpt.classList.add('selected');
        const check = selectedOpt.querySelector('.sub-check');
        if (check) {
            check.className = 'fas fa-check-circle sub-check';
            check.style.color = color;
        }
    }

    const confirmBtnDiv = document.getElementById('confirmSubConditionBtn');
    if (confirmBtnDiv) {
        confirmBtnDiv.style.display = 'block';
        const btn = confirmBtnDiv.querySelector('button');
        if (btn) btn.style.background = `linear-gradient(135deg, ${color}, ${adjustColor(color, 20)})`;
    }
}

function adjustColor(color, amount) {
    const num = parseInt(color.replace('#', ''), 16);
    const r = Math.min(255, (num >> 16) + amount);
    const g = Math.min(255, ((num >> 8) & 0x00FF) + amount);
    const b = Math.min(255, (num & 0x0000FF) + amount);
    return '#' + ((r << 16) | (g << 8) | b).toString(16).padStart(6, '0');
}

function confirmToothCondition() {
    if (!pendingSubCondition || !pendingSubLabel) {
        showToast('يرجى اختيار نوع الحالة أولاً', 'warning');
        return;
    }

    applyToothCondition(currentCondition, pendingSubLabel, pendingSubCondition);
    closeSubConditionModal();
}

function applyToothCondition(condition, label, subValue = null) {
    if (currentToothNumber === null) return;

    const isPrimary = (currentToothNumber >= 51 && currentToothNumber <= 86);

    selectedTeeth[currentToothNumber] = {
        condition: condition,
        subCondition: subValue,
        label: label,
        isPrimary: isPrimary,
        timestamp: Date.now()
    };

    const btn = document.querySelector(`.tooth-btn[data-tooth="${currentToothNumber}"]`);
    if (btn) {
        btn.className = 'tooth-btn ' + condition;
        btn.title = `${label} (${currentToothNumber})`;
        
        btn.style.animation = 'none';
        setTimeout(() => {
            btn.style.animation = 'toothPulse 0.3s ease';
        }, 10);
    }

    updateSelectedTeethList();
    showToast(`تم تحديد السن ${currentToothNumber}: ${label}`, 'success');
}

function removeToothCondition() {
    if (currentToothNumber === null) return;

    delete selectedTeeth[currentToothNumber];

    const btn = document.querySelector(`.tooth-btn[data-tooth="${currentToothNumber}"]`);
    if (btn) {
        const isPrimary = (currentToothNumber >= 51 && currentToothNumber <= 86);
        btn.className = isPrimary ? 'tooth-btn primary' : 'tooth-btn permanent';
        btn.title = '';
    }

    updateSelectedTeethList();
    currentToothNumber = null;
    closeToothModal();
    showToast(`تم إزالة تحديد السن`, 'info');
}

function updateSelectedTeethList() {
    const listContainer = document.getElementById('selectedTeethList');
    const teethContainer = document.getElementById('teethListContainer');
    const statsContainer = document.getElementById('teethStats');
    
    if (!listContainer || !teethContainer || !statsContainer) return;
    
    const teethKeys = Object.keys(selectedTeeth);

    if (teethKeys.length === 0) {
        listContainer.classList.remove('visible');
        listContainer.style.display = 'none';
        statsContainer.classList.remove('visible');
        statsContainer.style.display = 'none';
        return;
    }

    listContainer.style.display = 'block';
    listContainer.classList.add('visible');
    statsContainer.style.display = 'block';
    statsContainer.classList.add('visible');

    let fixedCount = 0;
    let mobileCount = 0;
    let missingCount = 0;

    teethKeys.forEach(tooth => {
        const data = selectedTeeth[tooth];
        if (data.condition === 'missing') {
            missingCount++;
        } else if (data.condition === 'extraction') {
            mobileCount++;
        } else if (data.condition === 'restorative' || data.condition === 'endodontic') {
            fixedCount++;
        }
    });

    const fixedEl = document.getElementById('fixedTeethCount');
    const mobileEl = document.getElementById('mobileTeethCount');
    const missingEl = document.getElementById('missingTeethCount');
    const totalEl = document.getElementById('totalSelectedTeeth');
    
    if (fixedEl) fixedEl.textContent = fixedCount;
    if (mobileEl) mobileEl.textContent = mobileCount;
    if (missingEl) missingEl.textContent = missingCount;
    if (totalEl) totalEl.textContent = teethKeys.length;

    const conditionColors = {
        restorative: '#3b82f6',
        endodontic: '#f59e0b',
        extraction: '#ef4444',
        missing: '#6b7280'
    };

    const conditionIcons = {
        restorative: 'fa-fill-drip',
        endodontic: 'fa-syringe',
        extraction: 'fa-tooth',
        missing: 'fa-minus-circle'
    };

    const conditionLabels = {
        restorative: 'ترميمية',
        endodontic: 'لبية',
        extraction: 'قلع',
        missing: 'مفقود'
    };

    teethContainer.innerHTML = teethKeys.sort((a, b) => a - b).map(tooth => {
        const data = selectedTeeth[tooth];
        const color = conditionColors[data.condition];
        const icon = conditionIcons[data.condition];
        const typeLabel = data.isPrimary ? '<span style="font-size: 11px; color: #f59e0b; margin-right: 6px;">(مؤقت)</span>' : '';
        return `
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: white; border-radius: 12px; border: 2px solid ${color}30; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; background: ${color}; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; font-weight: 800; box-shadow: 0 4px 10px ${color}50;">
                        ${tooth}
                    </div>
                    <div>
                        <div style="font-size: 15px; font-weight: 700; color: #1f2937;">${data.label} ${typeLabel}</div>
                        <div style="font-size: 12px; color: #6b7280; margin-top: 2px;">
                            <i class="fas ${icon}" style="margin-left: 4px;"></i>
                            ${conditionLabels[data.condition]}
                        </div>
                    </div>
                </div>
                <button onclick="removeToothFromList(${tooth})" style="width: 36px; height: 36px; border-radius: 10px; background: #fee2e2; border: none; color: #ef4444; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `;
    }).join('');
}

function removeToothFromList(toothNumber) {
    delete selectedTeeth[toothNumber];

    const btn = document.querySelector(`.tooth-btn[data-tooth="${toothNumber}"]`);
    if (btn) {
        const isPrimary = (toothNumber >= 51 && toothNumber <= 86);
        btn.className = isPrimary ? 'tooth-btn primary' : 'tooth-btn permanent';
        btn.title = '';
    }

    updateSelectedTeethList();
    showToast(`تم إزالة السن ${toothNumber} من القائمة`, 'info');
}

// ========== نظام القلح (Periodontal) ==========
function selectPeriodontalSegment(segmentId) {
    currentSegment = segmentId;
    
    const segmentNames = {
        'upper-right': 'الخلفية اليمنى (الفك العلوي)',
        'upper-front': 'الأمامية (الفك العلوي)',
        'upper-left': 'الخلفية اليسرى (الفك العلوي)',
        'lower-left': 'الخلفية اليسرى (الفك السفلي)',
        'lower-front': 'الأمامية (الفك السفلي)',
        'lower-right': 'الخلفية اليمنى (الفك السفلي)'
    };
    
    const titleEl = document.getElementById('periodontalSegmentTitle');
    if (titleEl) titleEl.textContent = segmentNames[segmentId] || segmentId;
    
    const modal = document.getElementById('periodontalModal');
    if (modal) {
        modal.classList.add('active');
        modal.style.display = 'flex';
    }
}

function closePeriodontalModal() {
    const modal = document.getElementById('periodontalModal');
    if (modal) {
        modal.classList.remove('active');
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }
    currentSegment = null;
}

function selectPeriodontalGrade(grade) {
    if (!currentSegment) return;
    
    periodontalData[currentSegment] = {
        grade: grade,
        pockets: [],
        timestamp: Date.now()
    };
    
    const pocketInputs = document.querySelectorAll(`#pockets-${currentSegment} .pocket-input`);
    pocketInputs.forEach((input, index) => {
        if (input.value) {
            periodontalData[currentSegment].pockets.push(parseFloat(input.value));
        }
    });
    
    updatePeriodontalSegmentUI(currentSegment, grade);
    updatePeriodontalSummary();
    
    closePeriodontalModal();
    
    const gradeNames = {
        'healthy': 'سليم',
        'mild': 'بسيط',
        'moderate': 'متوسط',
        'severe': 'شديد'
    };
    
    showToast(`تم تحديد القلح ${gradeNames[grade]} للمنطقة المختارة`, 'success');
}

function updatePeriodontalSegmentUI(segmentId, grade) {
    const segment = document.querySelector(`[data-segment="${segmentId}"]`);
    const statusDiv = document.getElementById(`status-${segmentId}`);
    const pocketsDiv = document.getElementById(`pockets-${segmentId}`);
    
    if (!segment || !statusDiv) return;
    
    segment.classList.remove('selected-healthy', 'selected-mild', 'selected-moderate', 'selected-severe');
    statusDiv.classList.remove('healthy', 'mild', 'moderate', 'severe');
    
    segment.classList.add(`selected-${grade}`);
    statusDiv.classList.add(grade);
    
    const gradeNames = {
        'healthy': 'لثة سليمة',
        'mild': 'قلح بسيط',
        'moderate': 'قلح متوسط',
        'severe': 'قلح شديد'
    };
    
    statusDiv.textContent = gradeNames[grade];
    
    if (pocketsDiv) {
        pocketsDiv.style.display = 'block';
    }
}

function updatePeriodontalSummary() {
    const summaryDiv = document.getElementById('periodontalSummary');
    const contentDiv = document.getElementById('periodontalSummaryContent');
    
    if (!summaryDiv || !contentDiv) return;
    
    const segments = Object.keys(periodontalData);
    if (segments.length === 0) {
        summaryDiv.style.display = 'none';
        return;
    }
    
    summaryDiv.style.display = 'block';
    
    const segmentNames = {
        'upper-right': 'علوي يمين',
        'upper-front': 'علوي أمامي',
        'upper-left': 'علوي يسار',
        'lower-left': 'سفلي يسار',
        'lower-front': 'سفلي أمامي',
        'lower-right': 'سفلي يمين'
    };
    
    const gradeNames = {
        'healthy': 'سليم',
        'mild': 'بسيط',
        'moderate': 'متوسط',
        'severe': 'شديد'
    };
    
    contentDiv.innerHTML = segments.map(segment => {
        const data = periodontalData[segment];
        const avgPocket = data.pockets.length > 0 
            ? (data.pockets.reduce((a, b) => a + b, 0) / data.pockets.length).toFixed(1) 
            : 0;
        
        return `
            <div class="summary-item ${data.grade}">
                <div>
                    <strong>${segmentNames[segment]}</strong>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                        متوسط الجيب: ${avgPocket} مم
                    </div>
                </div>
                <span style="font-weight: 700;">${gradeNames[data.grade]}</span>
            </div>
        `;
    }).join('');
}

// ========== نظام الحالة الصحية ==========
function toggleHealthOption(element) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    if (!checkbox) return;
    
    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
        element.classList.add('selected');
    } else {
        element.classList.remove('selected');
    }

    const value = checkbox.value;

    if (value === 'diabetes') {
        const control = document.getElementById('diabetesControl');
        if (control) {
            if (checkbox.checked) {
                control.classList.add('visible');
                control.style.display = 'block';
            } else {
                control.classList.remove('visible');
                control.style.display = 'none';
            }
        }
    } else if (value === 'hypertension') {
        const control = document.getElementById('hypertensionControl');
        if (control) {
            if (checkbox.checked) {
                control.classList.add('visible');
                control.style.display = 'block';
            } else {
                control.classList.remove('visible');
                control.style.display = 'none';
            }
        }
    }
}

function showAddDiseaseModal() {
    const modal = document.getElementById('addDiseaseModal');
    if (modal) {
        modal.classList.add('active');
        modal.style.display = 'flex';
        const input = document.getElementById('newDiseaseInput');
        if (input) {
            input.value = '';
            setTimeout(() => input.focus(), 100);
        }
    }
}

function closeAddDiseaseModal() {
    const modal = document.getElementById('addDiseaseModal');
    if (modal) {
        modal.classList.remove('active');
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }
}

function addCustomDisease() {
    const input = document.getElementById('newDiseaseInput');
    if (!input) return;
    
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
    showToast(`تم إضافة "${diseaseName}" إلى القائمة`, 'success');
}

function updateAddedDiseasesList() {
    const container = document.getElementById('addedDiseasesList');
    if (!container) return;
    
    if (addedDiseases.length === 0) {
        container.innerHTML = '';
        return;
    }
    
    container.innerHTML = addedDiseases.map(disease => `
        <span style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid #fecaca;">
            <i class="fas fa-disease"></i> ${disease}
            <button onclick="removeAddedDisease('${disease}')" style="background: rgba(255,255,255,0.3); border: none; color: #dc2626; cursor: pointer; padding: 2px; margin-right: 4px; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-times" style="font-size: 10px;"></i>
            </button>
        </span>
    `).join('');
}

function removeAddedDisease(disease) {
    addedDiseases = addedDiseases.filter(d => d !== disease);
    updateAddedDiseasesList();
    showToast('تم إزالة المرض', 'info');
}

// ========== حساب العمر ==========
function calculateAge() {
    const birthYearInput = document.getElementById('patientBirthYear');
    const ageDisplay = document.getElementById('calculatedAge');
    const ageValue = document.getElementById('ageValue');
    
    if (!birthYearInput || !ageDisplay || !ageValue) return;

    const birthYear = parseInt(birthYearInput.value);
    const currentYear = new Date().getFullYear();
    const age = currentYear - birthYear;

    if (!birthYear || birthYear < 1900 || birthYear > currentYear || age < 0 || age > 120) {
        ageDisplay.style.display = 'none';
        ageDisplay.classList.remove('visible');
        return;
    }

    ageValue.textContent = age;
    ageDisplay.style.display = 'block';
    ageDisplay.classList.add('visible');
    
    if (age < 12) {
        selectAgeType('child');
    } else {
        selectAgeType('adult');
    }
}

// ========== اختيار الجنس ==========
function selectGender(gender) {
    document.querySelectorAll('.gender-option').forEach(opt => {
        opt.classList.remove('selected');
    });

    const selectedRadio = document.querySelector(`input[name="patientGender"][value="${gender}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.gender-option');
        if (label) label.classList.add('selected');
    }
}

// ========== اختيار حالة التحكم ==========
function selectControl(type, value) {
    const inputName = type === 'diabetes' ? 'diabetesControlled' : 'bpControlled';
    const containerId = type === 'diabetes' ? 'diabetesControl' : 'hypertensionControl';
    const container = document.getElementById(containerId);
    
    if (!container) return;

    container.querySelectorAll('.control-option').forEach(opt => {
        opt.classList.remove('selected-yes', 'selected-no');
    });

    const selectedRadio = container.querySelector(`input[name="${inputName}"][value="${value}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.control-option');
        if (label) {
            if (value === 'yes') {
                label.classList.add('selected-yes');
            } else {
                label.classList.add('selected-no');
            }
        }
    }
}

// ========== نظام صلاحيات الوصول ==========
function selectAccessType(type) {
    document.querySelectorAll('.access-option').forEach(opt => {
        opt.classList.remove('selected');
        const checkIcon = opt.querySelector('.check-icon');
        if (checkIcon) checkIcon.className = 'fas fa-circle check-icon';
    });

    const selectedRadio = document.querySelector(`input[name="accessType"][value="${type}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        const label = selectedRadio.closest('.access-option');
        if (label) {
            label.classList.add('selected');
            const checkIcon = label.querySelector('.check-icon');
            if (checkIcon) checkIcon.className = 'fas fa-check-circle check-icon';
        }
    }

    const customSection = document.getElementById('customStudentsSection');
    if (customSection) {
        if (type === 'custom') {
            customSection.style.display = 'block';
            customSection.classList.add('visible');
        } else {
            customSection.classList.remove('visible');
            customSection.style.display = 'none';
        }
    }
}

function addStudent() {
    const input = document.getElementById('studentIdInput');
    if (!input) return;
    
    const studentId = input.value.trim();

    if (!studentId) {
        showToast('يرجى إدخال الرقم الجامعي', 'warning');
        return;
    }

    if (!/^\d+$/.test(studentId)) {
        showToast('الرقم الجامعي يجب أن يحتوي على أرقام فقط', 'warning');
        return;
    }

    if (addedStudents.includes(studentId)) {
        showToast('هذا الطالب مضاف مسبقاً', 'warning');
        return;
    }

    addedStudents.push(studentId);
    updateStudentsList();
    input.value = '';
    input.focus();
    showToast(`تم إضافة الطالب ${studentId}`, 'success');
}

function updateStudentsList() {
    const container = document.getElementById('studentsList');
    if (!container) return;
    
    if (addedStudents.length === 0) {
        container.innerHTML = '<span style="font-size: 13px; color: #9ca3af; font-style: italic;">لم تتم إضافة طلاب بعد</span>';
        return;
    }
    
    container.innerHTML = addedStudents.map(id => `
        <span class="student-badge">
            <i class="fas fa-user-graduate"></i> ${id}
            <button onclick="removeStudent('${id}')" style="background: rgba(255,255,255,0.3); border: none; color: white; cursor: pointer; padding: 2px; margin-right: 4px; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-times" style="font-size: 10px;"></i>
            </button>
        </span>
    `).join('');
}

function removeStudent(studentId) {
    addedStudents = addedStudents.filter(id => id !== studentId);
    updateStudentsList();
    showToast('تم إزالة الطالب', 'info');
}

// ========== إضافة مريض جديد ==========
function addNewPatient() {
    const name = document.getElementById('patientName')?.value.trim();
    const birthYear = document.getElementById('patientBirthYear')?.value;
    const phone = document.getElementById('patientPhone')?.value || '';
    const governorate = document.getElementById('patientGovernorate')?.value || '';
    const address = document.getElementById('patientAddress')?.value || '';
    const gender = document.querySelector('input[name="patientGender"]:checked')?.value || 'male';
    const ageType = document.querySelector('input[name="ageType"]:checked')?.value || 'child';
    const accessType = document.querySelector('input[name="accessType"]:checked')?.value || 'private';
    const notes = document.getElementById('patientNotes')?.value || '';

    if (!name) {
        showToast('يرجى إدخال اسم المريض', 'error');
        document.getElementById('patientName')?.focus();
        return;
    }

    if (!birthYear) {
        showToast('يرجى إدخال سنة الميلاد', 'error');
        document.getElementById('patientBirthYear')?.focus();
        return;
    }

    const birthYearNum = parseInt(birthYear);
    const currentYear = new Date().getFullYear();

    if (birthYearNum < 1900 || birthYearNum > currentYear) {
        showToast('سنة الميلاد غير صالحة', 'error');
        return;
    }

    const calculatedAge = currentYear - birthYearNum;

    let parentInfo = null;
    if (ageType === 'child') {
        const parentName = document.getElementById('parentName')?.value.trim();
        const parentPhone = document.getElementById('parentPhone')?.value.trim();

        if (!parentName) {
            showToast('يرجى إدخال اسم ولي الأمر للطفل', 'error');
            document.getElementById('parentName')?.focus();
            return;
        }
        if (!parentPhone || parentPhone.length < 8) {
            showToast('يرجى إدخال رقم موبايل صحيح لولي الأمر', 'error');
            return;
        }

        parentInfo = {
            name: parentName,
            phone: '09' + parentPhone,
            birthYear: parseInt(document.getElementById('parentBirthYear')?.value) || null
        };
    } else {
        if (!phone || phone.length < 8) {
            showToast('يرجى إدخال رقم موبايل صحيح', 'error');
            return;
        }
    }

    const diseases = [];
    document.querySelectorAll('input[name="diseases"]:checked').forEach(cb => {
        diseases.push(cb.value);
    });

    const diabetesControlled = document.querySelector('input[name="diabetesControlled"]:checked')?.value || null;
    const bpControlled = document.querySelector('input[name="bpControlled"]:checked')?.value || null;

    // تحويل بيانات الأسنان من كائن إلى مصفوفة
    const teethArray = Object.keys(selectedTeeth).map(function(toothNum) {
        var t = selectedTeeth[toothNum];
        return {
            tooth_number: parseInt(toothNum),
            condition: t.condition,
            sub_condition: t.subCondition || null,
            label: t.label,
            is_primary: t.isPrimary || false
        };
    });

    // تحويل بيانات القلح من كائن إلى مصفوفة
    const perioArray = Object.keys(periodontalData).map(function(seg) {
        var p = periodontalData[seg];
        return {
            segment: seg,
            grade: p.grade,
            pockets: p.pockets || []
        };
    });

    // بناء كائن الطلب
    const requestBody = {
        full_name: name,
        birth_year: birthYearNum,
        age: calculatedAge,
        age_type: ageType,
        phone: ageType === 'adult' ? '09' + phone : (parentInfo ? parentInfo.phone : ''),
        governorate: governorate,
        address: address,
        gender: gender,
        access_type: accessType,
        notes: notes,
        teeth: teethArray,
        perio: perioArray,
        health: {
            diseases: [...diseases, ...addedDiseases],
            diabetes_controlled: diabetesControlled === 'yes' ? true : (diabetesControlled === 'no' ? false : null),
            bp_controlled: bpControlled === 'yes' ? true : (bpControlled === 'no' ? false : null)
        },
        access_students: accessType === 'custom' ? [...addedStudents] : [],
        parent_name: parentInfo ? parentInfo.name : null,
        parent_phone: parentInfo ? parentInfo.phone : null
    };

    // إرسال للـ API
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const submitBtn = document.querySelector('.btn-submit, [onclick="addNewPatient()"]');
    if (submitBtn) submitBtn.disabled = true;

    fetch('/api/patients', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin',
        body: JSON.stringify(requestBody)
    })
    .then(function(res) {
        if (res.status === 401) {
            window.location.href = '/login';
            throw new Error('Unauthorized');
        }
        return res.json();
    })
    .then(function(data) {
        if (data.success) {
            resetForm();
            showToast('تم إضافة المريض بنجاح! الرقم الطبي: ' + (data.patient ? data.patient.record_number : ''), 'success');

            setTimeout(function() {
                var patientTab = document.querySelector('button[onclick*="favo-patient"]');
                if (patientTab) patientTab.click();
            }, 1500);
        } else {
            var errorMsg = data.message || 'حدث خطأ أثناء حفظ بيانات المريض';
            if (data.errors) {
                var firstError = Object.values(data.errors)[0];
                if (Array.isArray(firstError)) errorMsg = firstError[0];
            }
            showToast(errorMsg, 'error');
        }
    })
    .catch(function(err) {
        console.error('Error adding patient:', err);
        showToast('حدث خطأ في الاتصال بالخادم', 'error');
    })
    .finally(function() {
        if (submitBtn) submitBtn.disabled = false;
    });
}

function resetForm() {
    const patientName = document.getElementById('patientName');
    const patientBirthYear = document.getElementById('patientBirthYear');
    const calculatedAge = document.getElementById('calculatedAge');
    const patientPhone = document.getElementById('patientPhone');
    const patientGovernorate = document.getElementById('patientGovernorate');
    const patientAddress = document.getElementById('patientAddress');
    const patientNotes = document.getElementById('patientNotes');
    const parentName = document.getElementById('parentName');
    const parentPhone = document.getElementById('parentPhone');
    const parentBirthYear = document.getElementById('parentBirthYear');
    
    if (patientName) patientName.value = '';
    if (patientBirthYear) patientBirthYear.value = '';
    if (calculatedAge) {
        calculatedAge.style.display = 'none';
        calculatedAge.classList.remove('visible');
    }
    if (patientPhone) patientPhone.value = '';
    if (patientGovernorate) patientGovernorate.value = '';
    if (patientAddress) patientAddress.value = '';
    if (patientNotes) patientNotes.value = '';
    if (parentName) parentName.value = '';
    if (parentPhone) parentPhone.value = '';
    if (parentBirthYear) parentBirthYear.value = '';

    document.querySelectorAll('input[name="diseases"]').forEach(cb => {
        cb.checked = false;
        cb.closest('.health-checkbox')?.classList.remove('selected');
    });
    
    const diabetesControl = document.getElementById('diabetesControl');
    const hypertensionControl = document.getElementById('hypertensionControl');
    if (diabetesControl) {
        diabetesControl.style.display = 'none';
        diabetesControl.classList.remove('visible');
    }
    if (hypertensionControl) {
        hypertensionControl.style.display = 'none';
        hypertensionControl.classList.remove('visible');
    }

    addedDiseases = [];
    updateAddedDiseasesList();

    selectedTeeth = {};
    document.querySelectorAll('.tooth-btn').forEach(btn => {
        const toothNum = parseInt(btn.dataset.tooth);
        if (toothNum) {
            btn.className = 'tooth-btn ' + ((toothNum >= 51 && toothNum <= 86) ? 'primary' : 'permanent');
            btn.title = '';
        }
    });
    updateSelectedTeethList();

    periodontalData = {};
    document.querySelectorAll('.periodontal-segment').forEach(segment => {
        segment.classList.remove('selected-healthy', 'selected-mild', 'selected-moderate', 'selected-severe');
    });
    document.querySelectorAll('.segment-status').forEach(status => {
        status.classList.remove('healthy', 'mild', 'moderate', 'severe');
        status.textContent = 'لم يتم الفحص';
        status.style.background = '#f1f5f9';
        status.style.color = '#64748b';
    });
    document.querySelectorAll('.pockets-section').forEach(pockets => {
        pockets.style.display = 'none';
    });
    const summaryDiv = document.getElementById('periodontalSummary');
    if (summaryDiv) summaryDiv.style.display = 'none';
    
    document.querySelectorAll('.pocket-input').forEach(input => input.value = '');

    addedStudents = [];
    updateStudentsList();

    selectAccessType('private');
    selectGender('male');
    selectAgeType('child');
    updateAgeTypeVisibility('child');
}

// ========== Toast Notification ==========
function showToast(message, type = 'info') {
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) existingToast.remove();

    const toast = document.createElement('div');
    const colors = {
        success: { bg: '#059669', icon: 'fa-check-circle' },
        error: { bg: '#dc2626', icon: 'fa-times-circle' },
        warning: { bg: '#d97706', icon: 'fa-exclamation-triangle' },
        info: { bg: '#4f46e5', icon: 'fa-info-circle' }
    };
    
    const style = colors[type] || colors.info;
    
    toast.className = 'toast-notification';
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-100px);
        background: ${style.bg};
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        z-index: 10000;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 300px;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    `;
    
    toast.innerHTML = `<i class="fas ${style.icon}" style="font-size: 20px;"></i><span>${message}</span>`;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';
    }, 100);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(-100px)';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// ========== تهيئة الصفحة ==========
document.addEventListener('DOMContentLoaded', function() {
    selectAccessType('private');
    selectGender('male');
    selectAgeType('child');
    updateAgeTypeVisibility('child');
    updateStudentsList();
    updateAddedDiseasesList();
    console.log('Add Patient JS Loaded Successfully');
});

// ========== إغلاق Modals ==========
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('tooth-modal')) {
        if (e.target.id === 'toothModal') closeToothModal();
        else if (e.target.id === 'subConditionModal') closeSubConditionModal();
        else if (e.target.id === 'addDiseaseModal') closeAddDiseaseModal();
        else if (e.target.id === 'periodontalModal') closePeriodontalModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeToothModal();
        closeSubConditionModal();
        closeAddDiseaseModal();
        closePeriodontalModal();
    }
    if (e.key === 'Enter' && document.activeElement.id === 'studentIdInput') addStudent();
    if (e.key === 'Enter' && document.activeElement.id === 'newDiseaseInput') addCustomDisease();
});

