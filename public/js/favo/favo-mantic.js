// ========== التكوين الثابت (Static Configuration) ==========
const AppConfig = {
    // روابط API (ثابتة)
    api: {
        baseUrl: '/api',
        endpoints: {
            patients: '/patients',
            students: '/students',
            diseases: '/diseases'
        }
    },
    
    // إعدادات الأسنان (FDI)
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
    
    // خرائط الألوان والأيقونات (ثابتة)
    ui: {
        colors: {
            primary: '#3b82f6',
            secondary: '#8b5cf6',
            accent: '#06b6d4',
            warning: '#f59e0b',
            danger: '#ef4444',
            success: '#10b981',
            info: '#4f46e5'
        },
        icons: {
            restorative: 'fa-fill-drip',
            endodontic: 'fa-syringe',
            extraction: 'fa-tooth',
            missing: 'fa-minus-circle',
            healthy: 'fa-check-circle',
            disease: 'fa-disease'
        }
    },
    
    // نصوص ثابتة
    labels: {
        teethConditions: {
            restorative: 'ترميمية',
            endodontic: 'لبية',
            extraction: 'قلع',
            missing: 'مفقود'
        },
        periodontalGrades: {
            healthy: 'لثة سليمة',
            mild: 'قلح بسيط',
            moderate: 'قلح متوسط',
            severe: 'قلح شديد'
        },
        segments: {
            'upper-right': 'الخلفية اليمنى (الفك العلوي)',
            'upper-front': 'الأمامية (الفك العلوي)',
            'upper-left': 'الخلفية اليسرى (الفك العلوي)',
            'lower-left': 'الخلفية اليسرى (الفك السفلي)',
            'lower-front': 'الأمامية (الفك السفلي)',
            'lower-right': 'الخلفية اليمنى (الفك السفلي)'
        }
    }
};

// ========== المنطق المتحرك والمحاكاة (Dynamic Logic & Simulation) ==========
const AppSimulator = {
    // محاكاة API للحصول على بيانات (للاختبار)
    mockData: {
        students: [
            { id: '2021001', name: 'أحمد محمد' },
            { id: '2021002', name: 'سارة أحمد' },
            { id: '2021003', name: 'خالد عمر' }
        ],
        diseases: ['سكري', 'ضغط', 'ربو', 'قلب', 'حساسية'],
        governorates: ['دمشق', 'حلب', 'حمص', 'حماة', 'اللاذقية', 'طرطوس', 'درعا', 'سويداء', 'دير الزور', 'الرقة', 'الحسكة', 'إدلب']
    },
    
    // محاكاة تأخير الشبكة
    async simulateDelay(ms = 500) {
        return new Promise(resolve => setTimeout(resolve, ms));
    },
    
    // محاكاة جلب الطلاب
    async fetchStudents() {
        await this.simulateDelay();
        return this.mockData.students;
    },
    
    // محاكاة حفظ المريض
    async savePatient(patientData) {
        await this.simulateDelay(800);
        console.log('Saving to server:', patientData);
        return { success: true, id: Date.now() };
    },
    
    // محاكاة التحقق من الرقم الجامعي
    async validateStudentId(studentId) {
        await this.simulateDelay(300);
        return this.mockData.students.some(s => s.id === studentId);
    }
};

// ========== المساعدات العامة (Utilities) ==========
const Helpers = {
    // توليد ID فريد
    generateId() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    },
    
    // تنسيق التاريخ
    formatDate(date = new Date(), locale = 'ar-SA') {
        return date.toLocaleDateString(locale);
    },
    
    // تنسيق الوقت
    formatTime(date = new Date(), locale = 'ar-SA') {
        return date.toLocaleTimeString(locale);
    },
    
    // توليد لون عشوائي
    getRandomColor() {
        const colors = ['primary', 'secondary', 'accent', 'warning', 'danger'];
        return colors[Math.floor(Math.random() * colors.length)];
    },
    
    // توليد الأحرف الأولى
    getInitials(name) {
        return name.charAt(0).toUpperCase();
    },
    
    // تأمين النصوص (防止 XSS)
    sanitizeInput(input) {
        const div = document.createElement('div');
        div.textContent = input;
        return div.innerHTML;
    },
    
    // التحقق من صحة رقم الموبايل السوري
    isValidSyrianPhone(phone) {
        const cleaned = phone.replace(/\s/g, '');
        return /^09\d{8}$/.test(cleaned);
    },
    
    // التحقق من صحة سنة الميلاد
    isValidBirthYear(year) {
        const currentYear = new Date().getFullYear();
        const y = parseInt(year);
        return y >= 1900 && y <= currentYear && (currentYear - y) <= 120;
    }
};

// ========== إدارة التطبيق الرئيسية (App Controller) ==========
const AppController = {
    // تهيئة التطبيق
    init() {
        console.log('🏥 Dental Clinic App Initialized');
        console.log('📊 App Config:', AppConfig);
        
        // تحميل البيانات الأولية إذا لزم الأمر
        this.loadInitialData();
        
        // إعداد المستمعين العامين
        this.setupGlobalListeners();
    },
    
    // تحميل البيانات الأولية
    async loadInitialData() {
        try {
            // يمكن إضافة تحميل من localStorage أو API هنا
            const savedPatients = localStorage.getItem('patientsData');
            if (savedPatients) {
                AppState.lists.patientsData = JSON.parse(savedPatients);
                console.log('📋 Loaded saved patients:', AppState.lists.patientsData.length);
            }
        } catch (e) {
            console.warn('Could not load saved data:', e);
        }
    },
    
    // حفظ البيانات
    saveData() {
        try {
            localStorage.setItem('patientsData', JSON.stringify(AppState.lists.patientsData));
        } catch (e) {
            console.warn('Could not save data:', e);
        }
    },
    
    // مستمعين عامين
    setupGlobalListeners() {
        // حفظ قبل إغلاق الصفحة
        window.addEventListener('beforeunload', () => {
            this.saveData();
        });
        
        // التعامل مع الأخطاء العامة
        window.addEventListener('error', (e) => {
            console.error('Global Error:', e.error);
            // يمكن إضافة إرسال الأخطاء إلى خدمة التتبع هنا
        });
    },
    
    // تبديل الأقسام/التبويبات
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
        localStorage.setItem('currentTab', tabId);
    }
};

// تهيئة التطبيق عند التحميل
document.addEventListener('DOMContentLoaded', () => {
    AppController.init();
});

// تصدير للاستخدام الخارجي
window.AppConfig = AppConfig;
window.AppSimulator = AppSimulator;
window.Helpers = Helpers;
window.AppController = AppController;

