// ========== التكوين العام ==========
const AppConfig = {
    appName: 'Dental Clinic System',
    version: '1.0.0',
    defaultLanguage: 'ar',
    dateFormat: 'ar-SA',
    
    teeth: {
        permanent: {
            upperRight: [18, 17, 16, 15, 14, 13, 12, 11],
            upperLeft: [21, 22, 23, 24, 25, 26, 27, 28],
            lowerRight: [48, 47, 46, 45, 44, 43, 42, 41],
            lowerLeft: [31, 32, 33, 34, 35, 36, 37, 38]
        },
        primary: {
            upperRight: [55, 54, 53, 52, 51],
            upperLeft: [61, 62, 63, 64, 65],
            lowerRight: [85, 84, 83, 82, 81],
            lowerLeft: [71, 72, 73, 74, 75]
        }
    },
    
    validation: {
        minBirthYear: 1900,
        maxAge: 120,
        phoneLength: 9 // بدون الصفر الأول
    }
};

// ========== المساعدات العامة ==========
const Helpers = {
    generateId() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
    },
    
    formatDate(date = new Date()) {
        return date.toLocaleDateString('ar-SA', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    },
    
    formatTime(date = new Date()) {
        return date.toLocaleTimeString('ar-SA', {
            hour: '2-digit',
            minute: '2-digit'
        });
    },
    
    sanitizeInput(input) {
        if (typeof input !== 'string') return input;
        const div = document.createElement('div');
        div.textContent = input;
        return div.innerHTML;
    },
    
    validatePhone(phone) {
        const cleaned = phone.toString().replace(/\s/g, '');
        return /^09\d{8}$/.test(cleaned);
    },
    
    validateBirthYear(year) {
        const currentYear = new Date().getFullYear();
        const y = parseInt(year);
        return y >= AppConfig.validation.minBirthYear && 
               y <= currentYear && 
               (currentYear - y) <= AppConfig.validation.maxAge;
    }
};

// ========== وحدة التحكم الرئيسية ==========
const AppController = {
    init() {
        console.log(`🏥 ${AppConfig.appName} v${AppConfig.version} Initialized`);
        
        // تحميل البيانات المحفوظة
        this.loadSavedData();
        
        // إعداد المستمعين
        this.setupEventListeners();
        
        // تهيئة الواجهة
        this.initializeUI();
    },
    
    loadSavedData() {
        // تحميل قائمة المرضى
        const patients = DBManager.get(DBManager.keys.patients, []);
        AppState.lists.patientsData = patients;
        console.log(`📋 Loaded ${patients.length} patients from storage`);
        
        // تحميل الإعدادات
        const settings = DBManager.get(DBManager.keys.settings, {});
        if (settings.lastTab) {
            AppState.ui.currentTab = settings.lastTab;
        }
    },
    
    setupEventListeners() {
        // حفظ البيانات قبل إغلاق الصفحة
        window.addEventListener('beforeunload', () => {
            this.saveCurrentState();
        });
        
        // التعامل مع الأخطاء
        window.addEventListener('error', (e) => {
            console.error('❌ Global Error:', e.error);
            // يمكن إضافة إرسال الأخطاء إلى الخادم هنا
        });
        
        // مراقبة تغييرات التخزين (للتزامن بين نوافذ المتصفح)
        window.addEventListener('storage', (e) => {
            if (e.key === DBManager.keys.patients) {
                AppState.lists.patientsData = JSON.parse(e.newValue || '[]');
                console.log('🔄 Data updated from another window');
            }
        });
    },
    
    initializeUI() {
        // تعيين التبويب الافتراضي
        const lastTab = DBManager.get(DBManager.keys.settings, {}).lastTab || 'add-patient';
        this.switchTab(lastTab);
    },
    
    saveCurrentState() {
        // حفظ الإعدادات الحالية
        DBManager.save(DBManager.keys.settings, {
            lastTab: AppState.ui.currentTab,
            lastAccess: new Date().toISOString()
        });
    },
    
    switchTab(tabId) {
        // إخفاء جميع الأقسام
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
            content.classList.remove('active');
        });
        
        // إلغاء تنشيط جميع الأزرار
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // إظهار القسم المطلوب
        const targetContent = document.getElementById(tabId);
        if (targetContent) {
            targetContent.style.display = 'block';
            setTimeout(() => targetContent.classList.add('active'), 10);
        }
        
        // تنشيط الزر المقابل
        const targetBtn = document.querySelector(`[data-tab="${tabId}"]`);
        if (targetBtn) targetBtn.classList.add('active');
        
        // حفظ التبويب الحالي
        AppState.ui.currentTab = tabId;
        DBManager.save(DBManager.keys.settings, {
            lastTab: tabId,
            lastAccess: new Date().toISOString()
        });
        
        // تحميل بيانات القسم إذا لزم الأمر
        if (tabId === 'patients-list') {
            this.loadPatientsList();
        }
    },
    
    loadPatientsList() {
        const container = document.getElementById('patientsContainer');
        if (!container) return;
        
        const patients = PatientManager.getAllPatients();
        
        if (patients.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #6b7280;">
                    <i class="fas fa-users" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p>لا يوجد مرضى مسجلين بعد</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = patients.map(patient => `
            <div class="patient-card" style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div style="display: flex; gap: 16px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold;">
                            ${patient.initial}
                        </div>
                        <div>
                            <h3 style="margin: 0 0 4px 0; color: #1f2937;">${patient.name}</h3>
                            <p style="margin: 0; color: #6b7280; font-size: 14px;">
                                <i class="fas fa-id-card" style="margin-left: 6px;"></i>
                                ${patient.record}
                            </p>
                            <p style="margin: 4px 0 0 0; color: #6b7280; font-size: 13px;">
                                <i class="fas fa-calendar" style="margin-left: 6px;"></i>
                                ${patient.age} سنة - ${patient.displayDate}
                            </p>
                        </div>
                    </div>
                    <div style="text-align: left;">
                        <span style="display: inline-block; padding: 4px 12px; background: ${patient.ageType === 'child' ? '#dbeafe' : '#dcfce7'}; color: ${patient.ageType === 'child' ? '#1e40af' : '#166534'}; border-radius: 20px; font-size: 12px; font-weight: 600;">
                            ${patient.ageType === 'child' ? 'طفل' : 'بالغ'}
                        </span>
                    </div>
                </div>
            </div>
        `).join('');
    },
    
    // تصدير البيانات كـ JSON (للنسخ الاحتياطي)
    exportData() {
        const data = {
            patients: DBManager.get(DBManager.keys.patients, []),
            exportDate: new Date().toISOString(),
            version: AppConfig.version
        };
        
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `dental_backup_${new Date().toISOString().split('T')[0]}.json`;
        a.click();
        URL.revokeObjectURL(url);
        
        ToastManager.show('تم تصدير البيانات بنجاح', 'success');
    },
    
    // استيراد البيانات
    importData(jsonData) {
        try {
            const data = JSON.parse(jsonData);
            if (data.patients && Array.isArray(data.patients)) {
                DBManager.save(DBManager.keys.patients, data.patients);
                AppState.lists.patientsData = data.patients;
                ToastManager.show(`تم استيراد ${data.patients.length} مريض بنجاح`, 'success');
                return true;
            }
        } catch (e) {
            ToastManager.show('ملف غير صالح', 'error');
            return false;
        }
    }
};

// ========== التهيئة عند التحميل ==========
document.addEventListener('DOMContentLoaded', () => {
    AppController.init();
    
    // إضافة دوال مساعدة للنافذة للوصول السريع من الكونسول (للتطوير)
    window.debug = {
        state: AppState,
        clearAll: () => {
            DBManager.clearAll();
            location.reload();
        },
        export: () => AppController.exportData()
    };
});

// تصدير للاستخدام الخارجي
window.AppConfig = AppConfig;
window.Helpers = Helpers;
window.AppController = AppController;

