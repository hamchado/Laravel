@extends('layouts.app')

@section('title', 'الأعمال')
@section('page_title', 'الأعمال')

@section('content')

<style>
:root {
    --primary: #6366f1;
    --primary-light: #818cf8;
    --gray: #6b7280;
    --font-sm: clamp(11px, 1.4vw, 13px);
    --font-base: clamp(12px, 1.6vw, 14px);
    --font-lg: clamp(14px, 2vw, 16px);
}

/* ===== الشريط العلوي ===== */
.tabs-container {
    display: flex;
    background: white;
    overflow-x: auto; /* مهم: يسمح بالتمرير إذا لزم */
    overflow-y: hidden;
    scrollbar-width: none;
    -ms-overflow-style: none;
    -webkit-overflow-scrolling: touch;
    width: 100%;
    border-radius: 16px;
    padding: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    gap: 4px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.tabs-container::-webkit-scrollbar {
    display: none;
}

.tab-item {
    flex: 0 0 auto; /* مهم: لا يتقلص ولا يتمدد */
    width: auto; /* يأخذ عرض المحتوى */
    min-width: max-content; /* على الأقل عرض المحتوى */
    display: inline-flex; /* مهم: يسمح للعناصر بالتواجد بجانب بعض */
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 24px; /* زيادة الحشوة الجانبية */
    font-size: 13px;
    font-weight: 600;
    color: #9ca3af;
    cursor: pointer;
    position: relative;
    white-space: nowrap; /* مهم: النص في سطر واحد */
    transition: all 0.3s ease;
    background: transparent;
    border: none;
    font-family: inherit;
    border-radius: 12px;
}

.tab-item i {
    font-size: 15px;
    color: inherit;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.tab-item span {
    white-space: nowrap; /* النص كامل في سطر واحد */
    overflow: visible; /* إظهار الكل */
    text-overflow: clip; /* لا نقاط */
}

.tab-item.active {
    color: var(--primary);
    background: rgba(99, 102, 241, 0.08);
}

.tab-item.active::after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    border-radius: 3px;
    box-shadow: 0 -2px 8px rgba(99, 102, 241, 0.4);
    animation: expandLine 0.3s ease;
}

@keyframes expandLine {
    from { width: 0; opacity: 0; }
    to { width: 60%; opacity: 1; }
}

.tab-item:active {
    opacity: 0.8;
    transform: scale(0.98);
}

.tab-item:hover:not(.active) {
    color: var(--gray);
    background: rgba(0,0,0,0.02);
}

/* ===== التجاوب ===== */
@media (max-width: 640px) {
    .tab-item {
        padding: 12px 20px;
        font-size: 12px;
    }
    .tab-item i {
        font-size: 14px;
    }
    .tab-item.active::after {
        height: 2.5px;
        bottom: 4px;
        width: 70%;
    }
}

@media (max-width: 380px) {
    .tab-item {
        font-size: 11px;
        gap: 4px;
        padding: 10px 16px;
    }
    .tab-item i {
        font-size: 12px;
    }
}

/* ===== الأقسام ===== */
.tab-section {
    display: none;
    animation: fadeIn 0.3s ease;
}

.tab-section.active {
    display: block !important;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== العناوين ===== */
.section-title {
    font-size: var(--font-lg);
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: var(--primary);
    font-size: 18px;
}

.management-section {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border-radius: 16px;
    padding: 20px;
    margin: 20px 0;
    border: 1px solid rgba(229, 231, 235, 0.6);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}
</style>

<!-- الشريط العلوي -->
<div class="tabs-container">
    <button class="tab-item active" onclick="showTab('works', this)">
        <i class="fas fa-clipboard-list"></i>
        <span>الأعمال والحالات</span>
    </button>
    <button class="tab-item" onclick="showTab('add', this)">
        <i class="fas fa-user-plus"></i>
        <span>إضافة مريض</span>
    </button>
    <button class="tab-item" onclick="showTab('patients', this)">
        <i class="fas fa-users"></i>
        <span>سجل المرضى</span>
    </button>
    <button class="tab-item" onclick="showTab('gallery', this)">
        <i class="fas fa-images"></i>
        <span>معرض الصور</span>
    </button>
</div>

<!-- الأقسام -->
<div id="works-content" class="tab-section active">
    @include('student.favo-works')
</div>

<div id="add-content" class="tab-section">
    @include('student.favo-add')
</div>

<div id="patients-content" class="tab-section">
    @include('student.favo-patient')
</div>

<div id="gallery-content" class="tab-section">
    @include('student.favo-gallery')
</div>

<script>
function showTab(tabName, buttonElement) {
    document.querySelectorAll('.tab-item').forEach(btn => {
        btn.classList.remove('active');
    });
    buttonElement.classList.add('active');
    
    document.querySelectorAll('.tab-section').forEach(section => {
        section.classList.remove('active');
        section.style.display = 'none';
    });
    
    const targetId = tabName + '-content';
    const targetSection = document.getElementById(targetId);
    
    if (targetSection) {
        targetSection.classList.add('active');
        targetSection.style.display = 'block';
        localStorage.setItem('current_tab', tabName);
    }

    // تحديث البيانات عند التبديل بين التبويبات
    if (tabName === 'works' && typeof loadWorksData === 'function') {
        loadWorksData();
        renderWorksList();
    } else if (tabName === 'patients' && typeof loadFromLocalStorage === 'function') {
        loadFromLocalStorage();
        renderPatientsList();
        updateCounts();
    } else if (tabName === 'gallery' && typeof loadGalleryData === 'function') {
        loadGalleryData();
        loadGalleryPatientNames();
        renderGallery();
    }

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function() {
    const savedTab = localStorage.getItem('current_tab');
    if (savedTab) {
        const buttons = document.querySelectorAll('.tab-item');
        buttons.forEach(btn => {
            if (btn.getAttribute('onclick').includes("'" + savedTab + "'")) {
                showTab(savedTab, btn);
            }
        });
    }
});
</script>

@endsection

