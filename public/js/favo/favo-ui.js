// ========== مساعدات الواجهة ==========
const UIUtils = {
    getEl(id) {
        return document.getElementById(id);
    },
    
    adjustColor(color, amount) {
        const num = parseInt(color.replace('#', ''), 16);
        const r = Math.min(255, (num >> 16) + amount);
        const g = Math.min(255, ((num >> 8) & 0x00FF) + amount);
        const b = Math.min(255, (num & 0x0000FF) + amount);
        return '#' + ((r << 16) | (g << 8) | b).toString(16).padStart(6, '0');
    },
    
    setDisplay(elementId, show, displayType = 'block') {
        const el = this.getEl(elementId);
        if (!el) return;
        el.style.display = show ? displayType : 'none';
        if (show) {
            el.style.opacity = '1';
            el.classList.add('visible');
        } else {
            el.classList.remove('visible');
        }
    }
};

// ========== نظام الإشعارات ==========
const ToastManager = {
    show(message, type = 'info') {
        const existing = document.querySelector('.toast-notification');
        if (existing) existing.remove();

        const colors = {
            success: { bg: '#059669', icon: 'fa-check-circle' },
            error: { bg: '#dc2626', icon: 'fa-times-circle' },
            warning: { bg: '#d97706', icon: 'fa-exclamation-triangle' },
            info: { bg: '#4f46e5', icon: 'fa-info-circle' }
        };
        
        const style = colors[type] || colors.info;
        
        const toast = document.createElement('div');
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
        
        requestAnimationFrame(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(-50%) translateY(0)';
        });
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-50%) translateY(-100px)';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }
};

// ========== إدارة المودالات ==========
const ModalManager = {
    open(modalId) {
        const modal = UIUtils.getEl(modalId);
        if (modal) {
            modal.style.display = 'flex';
            requestAnimationFrame(() => modal.classList.add('active'));
        }
    },
    
    close(modalId) {
        const modal = UIUtils.getEl(modalId);
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => { modal.style.display = 'none'; }, 300);
        }
    },
    
    closeAll() {
        ['toothModal', 'subConditionModal', 'addDiseaseModal', 'periodontalModal'].forEach(id => {
            this.close(id);
        });
    }
};

// ========== واجهة الأسنان ==========
const TeethUIManager = {
    selectTooth(toothNumber) {
        AppState.teeth.currentNumber = toothNumber;
        const toothNumEl = UIUtils.getEl('selectedToothNumber');
        if (toothNumEl) toothNumEl.textContent = toothNumber;
        ModalManager.open('toothModal');
    },
    
    closeModal() {
        ModalManager.close('toothModal');
    },
    
    selectCondition(condition) {
        AppState.teeth.currentCondition = condition;
        
        if (condition === 'missing') {
            TeethDataManager.addCondition(AppState.teeth.currentNumber, 'missing', 'غير موجود');
            this.updateSelectedList();
            ToastManager.show(`تم تحديد السن ${AppState.teeth.currentNumber}: غير موجود`, 'success');
            this.closeModal();
            return;
        }

        const config = this.getConditionConfig(condition);
        this.renderSubOptions(config);
        ModalManager.close('toothModal');
        ModalManager.open('subConditionModal');
    },
    
    getConditionConfig(condition) {
        const configs = {
            restorative: {
                title: '<i class="fas fa-fill-drip" style="margin-left: 8px; color: #3b82f6;"></i> ترميمية - اختر الصنف',
                color: '#3b82f6',
                options: [
                    { value: 'class1', label: 'Class I', desc: 'حفرة في السطح الإطباقي' },
                    { value: 'class2', label: 'Class II', desc: 'حفرة في السطح القريب للأرحاء' },
                    { value: 'class3', label: 'Class III', desc: 'حفرة في السطح القريب للأمامية' },
                    { value: 'class4', label: 'Class IV', desc: 'حفرة تشمل زاوية القاطعة' },
                    { value: 'class5', label: 'Class V', desc: 'حفرة في الثلث اللثوي' }
                ]
            },
            endodontic: {
                title: '<i class="fas fa-syringe" style="margin-left: 8px; color: #f59e0b;"></i> لبية - اختر النوع',
                color: '#f59e0b',
                options: [
                    { value: 'full', label: 'سن كامل', desc: 'معالجة لبية كاملة' },
                    { value: 'root', label: 'جذر فقط', desc: 'معالجة لبية للجذر فقط' },
                    { value: 'retreat_full', label: 'إعادة معالجة', desc: 'إعادة المعالجة للسن الكامل' },
                    { value: 'retreat_root', label: 'إعادة جذر', desc: 'إعادة المعالجة للجذر فقط' }
                ]
            },
            extraction: {
                title: '<i class="fas fa-tooth" style="margin-left: 8px; color: #ef4444;"></i> قلع - اختر النوع',
                color: '#ef4444',
                options: [
                    { value: 'simple', label: 'قلع بسيط', desc: 'سن ظاهر وسهل القلع' },
                    { value: 'surgical', label: 'قلع جراحي', desc: 'سن منطمر أو جزئي الانبثاق' },
                    { value: 'root', label: 'قلع جذر', desc: 'إزالة بقايا الجذر فقط' },
                    { value: 'mobile', label: 'سن متحرك', desc: 'سن متقلقل بسبب التهاب اللثة' }
                ]
            }
        };
        return configs[condition];
    },
    
    renderSubOptions(config) {
        const subTitle = UIUtils.getEl('subConditionTitle');
        const subOptions = UIUtils.getEl('subConditionOptions');
        const confirmBtn = UIUtils.getEl('confirmSubConditionBtn');
        
        if (subTitle) subTitle.innerHTML = config.title;
        if (confirmBtn) confirmBtn.style.display = 'none';
        
        AppState.teeth.pendingSubCondition = null;
        AppState.teeth.pendingSubLabel = null;
        
        if (subOptions) {
            subOptions.innerHTML = config.options.map(opt => `
                <div class="tooth-sub-option" data-value="${opt.value}" data-label="${opt.label}" 
                     onclick="TeethUIManager.selectSubOption('${opt.value}', '${opt.label}', '${config.color}')" 
                     style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer; transition: all 0.2s; margin-bottom: 10px; background: white;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 44px; height: 44px; background: ${config.color}15; border: 2px solid ${config.color}; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 13px; font-weight: 800; color: ${config.color};">${opt.label.substring(0, 2).toUpperCase()}</span>
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
    },
    
    selectSubOption(value, label, color) {
        AppState.teeth.pendingSubCondition = value;
        AppState.teeth.pendingSubLabel = label;

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

        const confirmBtnDiv = UIUtils.getEl('confirmSubConditionBtn');
        if (confirmBtnDiv) {
            confirmBtnDiv.style.display = 'block';
            const btn = confirmBtnDiv.querySelector('button');
            if (btn) btn.style.background = `linear-gradient(135deg, ${color}, ${UIUtils.adjustColor(color, 20)})`;
        }
    },
    
    confirmCondition() {
        if (!AppState.teeth.pendingSubCondition || !AppState.teeth.pendingSubLabel) {
            ToastManager.show('يرجى اختيار نوع الحالة أولاً', 'warning');
            return;
        }

        TeethDataManager.addCondition(
            AppState.teeth.currentNumber, 
            AppState.teeth.currentCondition, 
            AppState.teeth.pendingSubLabel, 
            AppState.teeth.pendingSubCondition
        );
        
        this.updateToothButton(AppState.teeth.currentNumber);
        this.updateSelectedList();
        ToastManager.show(`تم تحديد السن ${AppState.teeth.currentNumber}: ${AppState.teeth.pendingSubLabel}`, 'success');
        this.closeSubModal();
    },
    
    closeSubModal() {
        ModalManager.close('subConditionModal');
        const confirmBtn = UIUtils.getEl('confirmSubConditionBtn');
        if (confirmBtn) confirmBtn.style.display = 'none';
        
        AppState.teeth.currentCondition = null;
        AppState.teeth.pendingSubCondition = null;
        AppState.teeth.pendingSubLabel = null;
    },
    
    removeCondition() {
        if (AppState.teeth.currentNumber === null) return;
        
        TeethDataManager.removeCondition(AppState.teeth.currentNumber);
        this.resetToothButton(AppState.teeth.currentNumber);
        this.updateSelectedList();
        ToastManager.show(`تم إزالة تحديد السن`, 'info');
        this.closeModal();
    },
    
    removeFromList(toothNumber) {
        TeethDataManager.removeCondition(toothNumber);
        this.resetToothButton(toothNumber);
        this.updateSelectedList();
        ToastManager.show(`تم إزالة السن ${toothNumber} من القائمة`, 'info');
    },
    
    updateToothButton(toothNumber) {
        const btn = document.querySelector(`.tooth-btn[data-tooth="${toothNumber}"]`);
        const data = AppState.teeth.selected[toothNumber];
        if (btn && data) {
            btn.className = 'tooth-btn ' + data.condition;
            btn.title = `${data.label} (${toothNumber})`;
            btn.style.animation = 'none';
            setTimeout(() => btn.style.animation = 'toothPulse 0.3s ease', 10);
        }
    },
    
    resetToothButton(toothNumber) {
        const btn = document.querySelector(`.tooth-btn[data-tooth="${toothNumber}"]`);
        if (btn) {
            const isPrimary = (toothNumber >= 51 && toothNumber <= 86);
            btn.className = isPrimary ? 'tooth-btn primary' : 'tooth-btn permanent';
            btn.title = '';
        }
    },
    
    updateSelectedList() {
        const listContainer = UIUtils.getEl('selectedTeethList');
        const teethContainer = UIUtils.getEl('teethListContainer');
        const statsContainer = UIUtils.getEl('teethStats');
        
        if (!listContainer || !teethContainer || !statsContainer) return;
        
        const stats = TeethDataManager.getStats();
        
        if (stats.total === 0) {
            listContainer.style.display = 'none';
            statsContainer.style.display = 'none';
            return;
        }

        listContainer.style.display = 'block';
        listContainer.classList.add('visible');
        statsContainer.style.display = 'block';
        statsContainer.classList.add('visible');

        const fixedEl = UIUtils.getEl('fixedTeethCount');
        const mobileEl = UIUtils.getEl('mobileTeethCount');
        const missingEl = UIUtils.getEl('missingTeethCount');
        const totalEl = UIUtils.getEl('totalSelectedTeeth');
        
        if (fixedEl) fixedEl.textContent = stats.fixed;
        if (mobileEl) mobileEl.textContent = stats.mobile;
        if (missingEl) missingEl.textContent = stats.missing;
        if (totalEl) totalEl.textContent = stats.total;

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

        teethContainer.innerHTML = Object.keys(AppState.teeth.selected)
            .sort((a, b) => a - b)
            .map(tooth => {
                const data = AppState.teeth.selected[tooth];
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
                        <button onclick="TeethUIManager.removeFromList(${tooth})" style="width: 36px; height: 36px; border-radius: 10px; background: #fee2e2; border: none; color: #ef4444; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `;
            }).join('');
    }
};

// ========== واجهة القلح ==========
const PeriodontalUIManager = {
    selectSegment(segmentId) {
        AppState.periodontal.currentSegment = segmentId;
        
        const segmentNames = {
            'upper-right': 'الخلفية اليمنى (الفك العلوي)',
            'upper-front': 'الأمامية (الفك العلوي)',
            'upper-left': 'الخلفية اليسرى (الفك العلوي)',
            'lower-left': 'الخلفية اليسرى (الفك السفلي)',
            'lower-front': 'الأمامية (الفك السفلي)',
            'lower-right': 'الخلفية اليمنى (الفك السفلي)'
        };
        
        const titleEl = UIUtils.getEl('periodontalSegmentTitle');
        if (titleEl) titleEl.textContent = segmentNames[segmentId] || segmentId;
        
        ModalManager.open('periodontalModal');
    },
    
    closeModal() {
        ModalManager.close('periodontalModal');
        AppState.periodontal.currentSegment = null;
    },
    
    selectGrade(grade) {
        if (!AppState.periodontal.currentSegment) return;
        
        const pocketInputs = document.querySelectorAll(`#pockets-${AppState.periodontal.currentSegment} .pocket-input`);
        const pockets = Array.from(pocketInputs).map(input => parseFloat(input.value) || 0).filter(v => v > 0);
        
        PeriodontalDataManager.setSegmentGrade(AppState.periodontal.currentSegment, grade, pockets);
        this.updateSegmentUI(AppState.periodontal.currentSegment, grade);
        this.updateSummary();
        
        this.closeModal();
        
        const gradeNames = { healthy: 'سليم', mild: 'بسيط', moderate: 'متوسط', severe: 'شديد' };
        ToastManager.show(`تم تحديد القلح ${gradeNames[grade]} للمنطقة المختارة`, 'success');
    },
    
    updateSegmentUI(segmentId, grade) {
        const segment = document.querySelector(`[data-segment="${segmentId}"]`);
        const statusDiv = UIUtils.getEl(`status-${segmentId}`);
        const pocketsDiv = UIUtils.getEl(`pockets-${segmentId}`);
        
        if (!segment || !statusDiv) return;
        
        segment.classList.remove('selected-healthy', 'selected-mild', 'selected-moderate', 'selected-severe');
        statusDiv.classList.remove('healthy', 'mild', 'moderate', 'severe');
        
        segment.classList.add(`selected-${grade}`);
        statusDiv.classList.add(grade);
        
        const gradeNames = {
            healthy: 'لثة سليمة',
            mild: 'قلح بسيط',
            moderate: 'قلح متوسط',
            severe: 'قلح شديد'
        };
        
        statusDiv.textContent = gradeNames[grade];
        if (pocketsDiv) pocketsDiv.style.display = 'block';
    },
    
    updateSummary() {
        const summaryDiv = UIUtils.getEl('periodontalSummary');
        const contentDiv = UIUtils.getEl('periodontalSummaryContent');
        
        if (!summaryDiv || !contentDiv) return;
        
        const data = PeriodontalDataManager.getAllData();
        const segments = Object.keys(data);
        
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
            healthy: 'سليم',
            mild: 'بسيط',
            moderate: 'متوسط',
            severe: 'شديد'
        };
        
        contentDiv.innerHTML = segments.map(segment => {
            const segData = data[segment];
            const avgPocket = segData.pockets.length > 0 
                ? (segData.pockets.reduce((a, b) => a + b, 0) / segData.pockets.length).toFixed(1) 
                : 0;
            
            return `
                <div class="summary-item ${segData.grade}">
                    <div>
                        <strong>${segmentNames[segment]}</strong>
                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                            متوسط الجيب: ${avgPocket} مم
                        </div>
                    </div>
                    <span style="font-weight: 700;">${gradeNames[segData.grade]}</span>
                </div>
            `;
        }).join('');
    }
};

// ========== واجهة نموذج المريض (معدل بالكامل) ==========
const PatientFormUIManager = {
    
    // ===== تبديل نوع العمر (الجزء المهم) =====
    selectAgeType(type) {
        AppState.form.ageType = type;
        
        // إزالة التحديد من جميع الخيارات
        document.querySelectorAll('.age-type-option').forEach(opt => {
            opt.classList.remove('selected');
            const icon = opt.querySelector('i');
            if (icon) icon.style.color = '#9ca3af';
        });

        // تطبيق التحديد على الخيار المختار
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

        // تحديث ظهور العناصر حسب النوع
        this.updateAgeTypeVisibility(type);
    },
    
    // ===== منطق إظهار/إخفاء العناصر (مضبوط بدقة) =====
    updateAgeTypeVisibility(type) {
        const parentSection = UIUtils.getEl('parentInfoSection');
        const primaryTeethSection = UIUtils.getEl('primaryTeethSection');
        const patientPhoneSection = UIUtils.getEl('patientPhoneSection');
        
        if (type === 'child') {
            // إظهار قسم ولي الأمر والأسنان اللبنية
            if (parentSection) {
                parentSection.style.display = 'block';
                setTimeout(() => { parentSection.style.opacity = '1'; }, 10);
            }
            if (primaryTeethSection) {
                primaryTeethSection.style.display = 'block';
                setTimeout(() => { primaryTeethSection.style.opacity = '1'; }, 10);
            }
            // إخفاء رقم موبايل المريض (لأن الطفل يستخدم رقم الوالد)
            if (patientPhoneSection) {
                patientPhoneSection.style.display = 'none';
            }
            
            // تفريغ حقل موبايل المريض
            const patientPhone = UIUtils.getEl('patientPhone');
            if (patientPhone) patientPhone.value = '';
            
        } else {
            // إخفاء قسم ولي الأمر بتأثير تلاشي
            if (parentSection) {
                parentSection.style.opacity = '0';
                setTimeout(() => { parentSection.style.display = 'none'; }, 300);
            }
            // إخفاء قسم الأسنان اللبنية
            if (primaryTeethSection) {
                primaryTeethSection.style.opacity = '0';
                setTimeout(() => { primaryTeethSection.style.display = 'none'; }, 300);
            }
            // إظهار رقم موبايل المريض (للبالغ)
            if (patientPhoneSection) {
                patientPhoneSection.style.display = 'block';
                setTimeout(() => { patientPhoneSection.style.opacity = '1'; }, 10);
            }
            
            // تفريغ حقول ولي الأمر
            ['parentName', 'parentPhone', 'parentBirthYear'].forEach(id => {
                const el = UIUtils.getEl(id);
                if (el) el.value = '';
            });
        }
    },
    
    // ===== اختيار الجنس =====
    selectGender(gender) {
        AppState.form.gender = gender;
        document.querySelectorAll('.gender-option').forEach(opt => opt.classList.remove('selected'));
        
        const selectedRadio = document.querySelector(`input[name="patientGender"][value="${gender}"]`);
        if (selectedRadio) {
            selectedRadio.checked = true;
            const label = selectedRadio.closest('.gender-option');
            if (label) label.classList.add('selected');
        }
    },
    
    // ===== حساب العمر =====
    calculateAge() {
        const birthYearInput = UIUtils.getEl('patientBirthYear');
        const ageDisplay = UIUtils.getEl('calculatedAge');
        const ageValue = UIUtils.getEl('ageValue');
        
        if (!birthYearInput || !ageDisplay || !ageValue) return;

        const birthYear = parseInt(birthYearInput.value);
        const result = PatientManager.calculateAge(birthYear);

        if (!result.isValid) {
            ageDisplay.style.display = 'none';
            ageDisplay.classList.remove('visible');
            return;
        }

        ageValue.textContent = result.age;
        ageDisplay.style.display = 'block';
        ageDisplay.classList.add('visible');
        
        // تغيير النوع تلقائياً حسب العمر
        if (result.age < 12) {
            this.selectAgeType('child');
        } else {
            this.selectAgeType('adult');
        }
    },
    
    // ===== الحالة الصحية =====
    toggleHealthOption(element) {
        const checkbox = element.querySelector('input[type="checkbox"]');
        if (!checkbox) return;
        
        checkbox.checked = !checkbox.checked;
        element.classList.toggle('selected', checkbox.checked);
        
        const value = checkbox.value;
        
        if (value === 'diabetes') {
            const control = UIUtils.getEl('diabetesControl');
            if (control) {
                if (checkbox.checked) {
                    control.style.display = 'block';
                    setTimeout(() => control.classList.add('visible'), 10);
                } else {
                    control.classList.remove('visible');
                    setTimeout(() => control.style.display = 'none', 300);
                }
            }
        } else if (value === 'hypertension') {
            const control = UIUtils.getEl('hypertensionControl');
            if (control) {
                if (checkbox.checked) {
                    control.style.display = 'block';
                    setTimeout(() => control.classList.add('visible'), 10);
                } else {
                    control.classList.remove('visible');
                    setTimeout(() => control.style.display = 'none', 300);
                }
            }
        }
    },
    
    // ===== التحكم بالأمراض =====
    selectControl(type, value) {
        const inputName = type === 'diabetes' ? 'diabetesControlled' : 'bpControlled';
        const containerId = type === 'diabetes' ? 'diabetesControl' : 'hypertensionControl';
        const container = UIUtils.getEl(containerId);
        
        if (!container) return;

        container.querySelectorAll('.control-option').forEach(opt => {
            opt.classList.remove('selected-yes', 'selected-no');
        });

        const selectedRadio = container.querySelector(`input[name="${inputName}"][value="${value}"]`);
        if (selectedRadio) {
            selectedRadio.checked = true;
            const label = selectedRadio.closest('.control-option');
            if (label) {
                label.classList.add(value === 'yes' ? 'selected-yes' : 'selected-no');
            }
        }
    },
    
    // ===== صلاحيات الوصول =====
    selectAccessType(type) {
        AppState.form.accessType = type;
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

        const customSection = UIUtils.getEl('customStudentsSection');
        if (customSection) {
            if (type === 'custom') {
                customSection.style.display = 'block';
                setTimeout(() => customSection.classList.add('visible'), 10);
            } else {
                customSection.classList.remove('visible');
                setTimeout(() => customSection.style.display = 'none', 300);
            }
        }
    },
    
    // ===== إدارة الطلاب =====
    addStudent() {
        const input = UIUtils.getEl('studentIdInput');
        if (!input) return;
        
        const studentId = input.value.trim();
        const result = ListsManager.addStudent(studentId);
        
        if (result.error) {
            ToastManager.show(result.error, 'warning');
            return;
        }
        
        this.updateStudentsList();
        input.value = '';
        input.focus();
        ToastManager.show(`تم إضافة الطالب ${studentId}`, 'success');
    },
    
    removeStudent(studentId) {
        ListsManager.removeStudent(studentId);
        this.updateStudentsList();
        ToastManager.show('تم إزالة الطالب', 'info');
    },
    
    updateStudentsList() {
        const container = UIUtils.getEl('studentsList');
        if (!container) return;
        
        const students = ListsManager.getStudents();
        
        if (students.length === 0) {
            container.innerHTML = '<span style="font-size: 13px; color: #9ca3af; font-style: italic;">لم تتم إضافة طلاب بعد</span>';
            return;
        }
        
        container.innerHTML = students.map(id => `
            <span class="student-badge" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border-radius: 20px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-user-graduate"></i> ${id}
                <button onclick="PatientFormUIManager.removeStudent('${id}')" style="background: rgba(255,255,255,0.3); border: none; color: white; cursor: pointer; padding: 2px; margin-right: 4px; border-radius: 50%; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times" style="font-size: 10px;"></i>
                </button>
            </span>
        `).join('');
    },
    
    // ===== إدارة الأمراض المخصصة =====
    showAddDiseaseModal() {
        ModalManager.open('addDiseaseModal');
        const input = UIUtils.getEl('newDiseaseInput');
        if (input) {
            input.value = '';
            setTimeout(() => input.focus(), 100);
        }
    },
    
    closeAddDiseaseModal() {
        ModalManager.close('addDiseaseModal');
    },
    
    addCustomDisease() {
        const input = UIUtils.getEl('newDiseaseInput');
        if (!input) return;
        
        const result = ListsManager.addDisease(input.value.trim());
        
        if (result.error) {
            ToastManager.show(result.error, 'warning');
            return;
        }
        
        this.updateAddedDiseasesList();
        this.closeAddDiseaseModal();
        ToastManager.show(`تم إضافة المرض بنجاح`, 'success');
    },
    
    removeAddedDisease(disease) {
        ListsManager.removeDisease(disease);
        this.updateAddedDiseasesList();
        ToastManager.show('تم إزالة المرض', 'info');
    },
    
    updateAddedDiseasesList() {
        const container = UIUtils.getEl('addedDiseasesList');
        if (!container) return;
        
        const diseases = ListsManager.getDiseases();
        
        if (diseases.length === 0) {
            container.innerHTML = '';
            return;
        }
        
        container.innerHTML = diseases.map(disease => `
            <span style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid #fecaca; margin: 4px;">
                <i class="fas fa-disease"></i> ${disease}
                <button onclick="PatientFormUIManager.removeAddedDisease('${disease}')" style="background: rgba(255,255,255,0.5); border: none; color: #dc2626; cursor: pointer; padding: 2px; margin-right: 4px; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times" style="font-size: 10px;"></i>
                </button>
            </span>
        `).join('');
    },
    
    // ===== إضافة المريض النهائية =====
    submitPatient() {
        const formData = {
            name: UIUtils.getEl('patientName')?.value.trim(),
            birthYear: UIUtils.getEl('patientBirthYear')?.value,
            phone: UIUtils.getEl('patientPhone')?.value || '',
            governorate: UIUtils.getEl('patientGovernorate')?.value || '',
            address: UIUtils.getEl('patientAddress')?.value || '',
            notes: UIUtils.getEl('patientNotes')?.value || '',
            gender: document.querySelector('input[name="patientGender"]:checked')?.value || 'male',
            ageType: document.querySelector('input[name="ageType"]:checked')?.value || 'child',
            accessType: document.querySelector('input[name="accessType"]:checked')?.value || 'private',
            parentName: UIUtils.getEl('parentName')?.value.trim(),
            parentPhone: UIUtils.getEl('parentPhone')?.value.trim(),
            parentBirthYear: UIUtils.getEl('parentBirthYear')?.value,
            diabetesControlled: document.querySelector('input[name="diabetesControlled"]:checked')?.value || null,
            bpControlled: document.querySelector('input[name="bpControlled"]:checked')?.value || null,
            diseases: Array.from(document.querySelectorAll('input[name="diseases"]:checked')).map(cb => cb.value)
        };

        // التحقق من البيانات الأساسية
        if (!formData.name) {
            ToastManager.show('يرجى إدخال اسم المريض', 'error');
            UIUtils.getEl('patientName')?.focus();
            return;
        }

        if (!formData.birthYear) {
            ToastManager.show('يرجى إدخال سنة الميلاد', 'error');
            UIUtils.getEl('patientBirthYear')?.focus();
            return;
        }

        // التحقق حسب نوع العمر
        if (formData.ageType === 'child') {
            if (!formData.parentName) {
                ToastManager.show('يرجى إدخال اسم ولي الأمر للطفل', 'error');
                UIUtils.getEl('parentName')?.focus();
                return;
            }
            if (!formData.parentPhone || formData.parentPhone.length < 8) {
                ToastManager.show('يرجى إدخال رقم موبايل صحيح لولي الأمر', 'error');
                return;
            }
        } else {
            if (!formData.phone || formData.phone.length < 8) {
                ToastManager.show('يرجى إدخال رقم موبايل صحيح', 'error');
                return;
            }
        }

        // حفظ المريض
        const result = PatientManager.savePatient(formData);
        
        if (result.error) {
            ToastManager.show(result.error, 'error');
            return;
        }

        this.resetForm();
        ToastManager.show('تم إضافة المريض بنجاح! الرقم الطبي: ' + result.patient.record, 'success');

        // الانتقال لقسم المرضى بعد ثانية ونصف
        setTimeout(() => {
            const patientTab = document.querySelector('button[onclick*="favo-patient"]');
            if (patientTab) patientTab.click();
        }, 1500);
    },
    
    // ===== إعادة تعيين النموذج =====
    resetForm() {
        // تفريغ الحقول النصية
        const fields = ['patientName', 'patientBirthYear', 'patientPhone', 'patientGovernorate', 
                       'patientAddress', 'patientNotes', 'parentName', 'parentPhone', 'parentBirthYear'];
        
        fields.forEach(id => {
            const el = UIUtils.getEl(id);
            if (el) el.value = '';
        });
        
        // إخفاء عرض العمر
        const ageDisplay = UIUtils.getEl('calculatedAge');
        if (ageDisplay) {
            ageDisplay.style.display = 'none';
            ageDisplay.classList.remove('visible');
        }
        
        // إعادة تعيين Checkboxes
        document.querySelectorAll('input[name="diseases"]').forEach(cb => {
            cb.checked = false;
            cb.closest('.health-checkbox')?.classList.remove('selected');
        });
        
        // إخفاء أقسام التحكم بالأمراض
        ['diabetesControl', 'hypertensionControl'].forEach(id => {
            const el = UIUtils.getEl(id);
            if (el) {
                el.classList.remove('visible');
                el.style.display = 'none';
            }
        });

        // إعادة تعيين البيانات الداخلية
        DataResetManager.resetFormOnly();
        
        // تحديث الواجهات
        this.updateStudentsList();
        this.updateAddedDiseasesList();
        TeethUIManager.updateSelectedList();
        
        // إعادة تعيين أزرار الأسنان
        document.querySelectorAll('.tooth-btn').forEach(btn => {
            const toothNum = parseInt(btn.dataset.tooth);
            if (toothNum) {
                const isPrimary = (toothNum >= 51 && toothNum <= 86);
                btn.className = isPrimary ? 'tooth-btn primary' : 'tooth-btn permanent';
                btn.title = '';
            }
        });
        
        // إعادة تعيين أقسام القلح
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
        document.querySelectorAll('.pocket-input').forEach(input => input.value = '');
        
        const summaryDiv = UIUtils.getEl('periodontalSummary');
        if (summaryDiv) summaryDiv.style.display = 'none';
        
        // إعادة الافتراضيات
        this.selectAccessType('private');
        this.selectGender('male');
        this.selectAgeType('child');
        this.updateAgeTypeVisibility('child');
    }
};

// ========== الأحداث العامة ==========
document.addEventListener('DOMContentLoaded', function() {
    // تهيئة القيم الافتراضية
    PatientFormUIManager.selectAccessType('private');
    PatientFormUIManager.selectGender('male');
    PatientFormUIManager.selectAgeType('child');
    PatientFormUIManager.updateAgeTypeVisibility('child');
    PatientFormUIManager.updateStudentsList();
    PatientFormUIManager.updateAddedDiseasesList();
    
    console.log('✅ UI Layer Loaded Successfully');
});

// إغلاق المودالات بالنقر خارجها
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay') || e.target.classList.contains('tooth-modal')) {
        const modalId = e.target.id;
        if (modalId === 'toothModal') TeethUIManager.closeModal();
        else if (modalId === 'subConditionModal') TeethUIManager.closeSubModal();
        else if (modalId === 'addDiseaseModal') PatientFormUIManager.closeAddDiseaseModal();
        else if (modalId === 'periodontalModal') PeriodontalUIManager.closeModal();
    }
});

// اختصارات لوحة المفاتيح
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') ModalManager.closeAll();
    if (e.key === 'Enter') {
        if (document.activeElement.id === 'studentIdInput') PatientFormUIManager.addStudent();
        if (document.activeElement.id === 'newDiseaseInput') PatientFormUIManager.addCustomDisease();
    }
});

// تصدير للاستخدام العام
window.UIUtils = UIUtils;
window.ToastManager = ToastManager;
window.ModalManager = ModalManager;
window.TeethUIManager = TeethUIManager;
window.PeriodontalUIManager = PeriodontalUIManager;
window.PatientFormUIManager = PatientFormUIManager;

