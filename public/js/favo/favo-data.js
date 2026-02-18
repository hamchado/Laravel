// ========== LocalStorage Manager (بديل MySQL مؤقتاً) ==========
const DBManager = {
    keys: {
        patients: 'dental_patients',
        settings: 'dental_settings',
        currentSession: 'dental_session'
    },
    
    // حفظ البيانات
    save(key, data) {
        try {
            localStorage.setItem(key, JSON.stringify(data));
            return true;
        } catch (e) {
            console.error('Error saving to LocalStorage:', e);
            return false;
        }
    },
    
    // استرجاع البيانات
    get(key, defaultValue = null) {
        try {
            const data = localStorage.getItem(key);
            return data ? JSON.parse(data) : defaultValue;
        } catch (e) {
            console.error('Error reading from LocalStorage:', e);
            return defaultValue;
        }
    },
    
    // إضافة عنصر لقائمة
    addToList(key, item, maxItems = 1000) {
        const list = this.get(key, []);
        item._id = Date.now().toString(36) + Math.random().toString(36).substr(2);
        item._createdAt = new Date().toISOString();
        item._updatedAt = new Date().toISOString();
        
        list.unshift(item); // إضافة في البداية
        
        // تحديد الحجم الأقصى لتجنب امتلاء الذاكرة
        if (list.length > maxItems) {
            list.pop();
        }
        
        return this.save(key, list) ? item : null;
    },
    
    // تحديث عنصر في قائمة
    updateInList(key, id, updates) {
        const list = this.get(key, []);
        const index = list.findIndex(item => item._id === id || item.id === id);
        
        if (index !== -1) {
            list[index] = { ...list[index], ...updates, _updatedAt: new Date().toISOString() };
            return this.save(key, list) ? list[index] : null;
        }
        return null;
    },
    
    // حذف من قائمة
    deleteFromList(key, id) {
        const list = this.get(key, []);
        const filtered = list.filter(item => item._id !== id && item.id !== id);
        return this.save(key, filtered);
    },
    
    // البحث
    search(key, field, value) {
        const list = this.get(key, []);
        return list.filter(item => item[field] && item[field].toString().toLowerCase().includes(value.toLowerCase()));
    },
    
    // مسح الكل
    clearAll() {
        Object.values(this.keys).forEach(key => localStorage.removeItem(key));
    }
};

// ========== متغيرات الحالة الرئيسية (State Management) ==========
const AppState = {
    // نظام الأسنان FDI
    teeth: {
        selected: {},           
        currentNumber: null,    
        currentCondition: null,
        pendingSubCondition: null,
        pendingSubLabel: null
    },
    
    // نظام القلح
    periodontal: {
        data: {},               
        currentSegment: null    
    },
    
    // قوائم مؤقتة
    lists: {
        addedStudents: [],      
        addedDiseases: [],      
        patientsData: []        
    },
    
    // إعدادات النموذج الحالية
    form: {
        ageType: 'child',
        gender: 'male',
        accessType: 'private'
    },
    
    // حالة التحميل
    ui: {
        isLoading: false,
        currentTab: 'add-patient'
    }
};

// ========== نظام الأسنان FDI - إدارة البيانات ==========
const TeethDataManager = {
    addCondition(toothNumber, condition, label, subValue = null) {
        const isPrimary = (toothNumber >= 51 && toothNumber <= 86);
        
        AppState.teeth.selected[toothNumber] = {
            condition: condition,
            subCondition: subValue,
            label: label,
            isPrimary: isPrimary,
            timestamp: Date.now()
        };
        
        return AppState.teeth.selected[toothNumber];
    },
    
    removeCondition(toothNumber) {
        delete AppState.teeth.selected[toothNumber];
        return toothNumber;
    },
    
    getSelected() {
        return AppState.teeth.selected;
    },
    
    getStats() {
        const teeth = AppState.teeth.selected;
        const keys = Object.keys(teeth);
        
        let stats = {
            fixed: 0,
            mobile: 0,
            missing: 0,
            total: keys.length
        };
        
        keys.forEach(tooth => {
            const data = teeth[tooth];
            if (data.condition === 'missing') stats.missing++;
            else if (data.condition === 'extraction') stats.mobile++;
            else if (['restorative', 'endodontic'].includes(data.condition)) stats.fixed++;
        });
        
        return stats;
    },
    
    clearAll() {
        AppState.teeth.selected = {};
        AppState.teeth.currentNumber = null;
        AppState.teeth.currentCondition = null;
        AppState.teeth.pendingSubCondition = null;
        AppState.teeth.pendingSubLabel = null;
        return true;
    }
};

// ========== نظام القلح - إدارة البيانات ==========
const PeriodontalDataManager = {
    setSegmentGrade(segmentId, grade, pockets = []) {
        AppState.periodontal.data[segmentId] = {
            grade: grade,
            pockets: pockets.filter(p => p !== null && p !== undefined && p !== ''),
            timestamp: Date.now()
        };
        return AppState.periodontal.data[segmentId];
    },
    
    getSegmentData(segmentId) {
        return AppState.periodontal.data[segmentId] || null;
    },
    
    getAllData() {
        return AppState.periodontal.data;
    },
    
    clearAll() {
        AppState.periodontal.data = {};
        AppState.periodontal.currentSegment = null;
        return true;
    }
};

// ========== إدارة القوائم المؤقتة ==========
const ListsManager = {
    addStudent(studentId) {
        if (!studentId || !/^\d+$/.test(studentId)) {
            return { error: 'الرقم الجامعي يجب أن يحتوي على أرقام فقط' };
        }
        if (AppState.lists.addedStudents.includes(studentId)) {
            return { error: 'هذا الطالب مضاف مسبقاً' };
        }
        
        AppState.lists.addedStudents.push(studentId);
        return { success: true, data: [...AppState.lists.addedStudents] };
    },
    
    removeStudent(studentId) {
        AppState.lists.addedStudents = AppState.lists.addedStudents.filter(id => id !== studentId);
        return [...AppState.lists.addedStudents];
    },
    
    getStudents() {
        return [...AppState.lists.addedStudents];
    },
    
    addDisease(diseaseName) {
        if (!diseaseName || !diseaseName.trim()) {
            return { error: 'يرجى كتابة اسم المرض' };
        }
        if (AppState.lists.addedDiseases.includes(diseaseName)) {
            return { error: 'هذا المرض مضاف مسبقاً' };
        }
        
        AppState.lists.addedDiseases.push(diseaseName);
        return { success: true, data: [...AppState.lists.addedDiseases] };
    },
    
    removeDisease(diseaseName) {
        AppState.lists.addedDiseases = AppState.lists.addedDiseases.filter(d => d !== diseaseName);
        return [...AppState.lists.addedDiseases];
    },
    
    getDiseases() {
        return [...AppState.lists.addedDiseases];
    },
    
    clearAll() {
        AppState.lists.addedStudents = [];
        AppState.lists.addedDiseases = [];
        return true;
    }
};

// ========== نظام المرضى - بناء وحفظ البيانات ==========
const PatientManager = {
    calculateAge(birthYear) {
        const currentYear = new Date().getFullYear();
        const age = currentYear - parseInt(birthYear);
        return { 
            age, 
            currentYear, 
            isValid: birthYear >= 1900 && birthYear <= currentYear && age >= 0 && age <= 120 
        };
    },
    
    buildPatientObject(formData) {
        const ageData = this.calculateAge(formData.birthYear);
        if (!ageData.isValid) return { error: 'سنة الميلاد غير صالحة' };
        
        const patientId = Date.now().toString(36) + Math.random().toString(36).substr(2);
        const recordNumber = 'MED-' + ageData.currentYear + '-' + String(DBManager.get(DBManager.keys.patients, []).length + 1).padStart(4, '0');
        
        // جمع الأمراض المختارة
        const diseases = [...formData.diseases, ...AppState.lists.addedDiseases];
        
        // بناء كائن المريض الكامل
        const patient = {
            id: patientId,
            record: recordNumber,
            name: formData.name,
            birthYear: parseInt(formData.birthYear),
            age: ageData.age,
            ageType: formData.ageType,
            gender: formData.gender,
            phone: formData.ageType === 'adult' ? '09' + formData.phone : '',
            governorate: formData.governorate,
            address: formData.address,
            notes: formData.notes,
            
            // البيانات الطبية
            medical: {
                teeth: { ...AppState.teeth.selected },
                periodontal: { ...AppState.periodontal.data },
                healthConditions: {
                    diseases: diseases,
                    diabetesControlled: formData.diabetesControlled,
                    bpControlled: formData.bpControlled
                }
            },
            
            // ولي الأمر (للأطفال فقط)
            parentInfo: formData.ageType === 'child' ? {
                name: formData.parentName,
                phone: '09' + formData.parentPhone,
                birthYear: parseInt(formData.parentBirthYear) || null
            } : null,
            
            // الصلاحيات
            access: {
                type: formData.accessType,
                students: formData.accessType === 'custom' ? [...AppState.lists.addedStudents] : []
            },
            
            // بيانات النظام
            createdAt: new Date().toISOString(),
            displayDate: new Date().toLocaleDateString('ar-SA'),
            specialty: 'أسنان',
            status: 'active',
            initial: formData.name.charAt(0).toUpperCase(),
            color: ['primary', 'secondary', 'accent', 'warning', 'danger'][Math.floor(Math.random() * 5)]
        };
        
        return { success: true, patient: patient };
    },
    
    // حفظ مريض جديد (في LocalStorage مؤقتاً)
    savePatient(formData) {
        const result = this.buildPatientObject(formData);
        
        if (result.error) {
            return result;
        }
        
        // حفظ في LocalStorage (بديل MySQL)
        const saved = DBManager.addToList(DBManager.keys.patients, result.patient);
        
        if (saved) {
            // تحديث القائمة المحلية
            AppState.lists.patientsData = DBManager.get(DBManager.keys.patients, []);
            return { success: true, patient: saved };
        }
        
        return { error: 'فشل في حفظ البيانات' };
    },
    
    // جيع جميع المرضى
    getAllPatients() {
        AppState.lists.patientsData = DBManager.get(DBManager.keys.patients, []);
        return AppState.lists.patientsData;
    },
    
    // حذف مريض
    deletePatient(patientId) {
        DBManager.deleteFromList(DBManager.keys.patients, patientId);
        AppState.lists.patientsData = DBManager.get(DBManager.keys.patients, []);
        return true;
    },
    
    // البحث في المرضى
    searchPatients(query) {
        const patients = this.getAllPatients();
        if (!query) return patients;
        
        return patients.filter(p => 
            p.name.includes(query) || 
            p.record.includes(query) ||
            (p.phone && p.phone.includes(query))
        );
    }
};

// ========== إعادة تعيين جميع البيانات ==========
const DataResetManager = {
    resetAll() {
        TeethDataManager.clearAll();
        PeriodontalDataManager.clearAll();
        ListsManager.clearAll();
        
        AppState.form.ageType = 'child';
        AppState.form.gender = 'male';
        AppState.form.accessType = 'private';
        
        return true;
    },
    
    resetFormOnly() {
        TeethDataManager.clearAll();
        PeriodontalDataManager.clearAll();
        ListsManager.clearAll();
        return true;
    }
};

// تصدير للاستخدام العام
window.DBManager = DBManager;
window.AppState = AppState;
window.TeethDataManager = TeethDataManager;
window.PeriodontalDataManager = PeriodontalDataManager;
window.ListsManager = ListsManager;
window.PatientManager = PatientManager;
window.DataResetManager = DataResetManager;

