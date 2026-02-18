// ===== التنقل بين الأقسام الرئيسية =====
function switchMainTab(element, tabName) {
    // إزالة النشاط من جميع التبويبات في نفس الحاوية
    const container = element.closest('.tabs-container');
    container.querySelectorAll('.tab-item').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // تفعيل التبويب المختار
    element.classList.add('active');
    
    // إخفاء جميع الأقسام المرتبطة بنفس المجموعة
    const wrapper = element.closest('.tabs-wrapper').nextElementSibling;
    if (wrapper && wrapper.classList.contains('tabs-content-wrapper')) {
        wrapper.querySelectorAll('.tab-content-section').forEach(section => {
            section.classList.remove('active');
            section.style.display = 'none';
        });
        
        // إظهار القسم المطلوب
        const targetSection = document.getElementById(tabName + '-section');
        if (targetSection) {
            targetSection.style.display = 'block';
            targetSection.classList.add('active');
        }
    }
    
    // تمرير للأعلى
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    // تخزين التبويب النشط في localStorage (اختياري)
    const pageId = window.location.pathname;
    localStorage.setItem(`activeTab_${pageId}`, tabName);
}

// ===== استعادة التبويب النشط عند تحميل الصفحة =====
document.addEventListener('DOMContentLoaded', function() {
    const pageId = window.location.pathname;
    const savedTab = localStorage.getItem(`activeTab_${pageId}`);
    
    if (savedTab) {
        const tabButton = document.querySelector(`[data-tab="${savedTab}"]`);
        if (tabButton) {
            switchMainTab(tabButton, savedTab);
        }
    }
});

