@extends('layouts.app')

@section('title', 'الاستكشاف')
@section('page_title', 'الاستكشاف')

@section('tabs')
<div class="tab-item active" onclick="switchTab('trending')">
    <i class="fas fa-fire" style="margin-left: 4px;"></i>
    رائج
</div>
<div class="tab-item" onclick="switchTab('new')">
    <i class="fas fa-star" style="margin-left: 4px;"></i>
    جديد
</div>
<div class="tab-item" onclick="switchTab('categories')">
    <i class="fas fa-th-large" style="margin-left: 4px;"></i>
    فئات
</div>
<div class="tab-item" onclick="switchTab('following')">
    <i class="fas fa-users" style="margin-left: 4px;"></i>
    متابعات
</div>
<div class="tab-item" onclick="switchTab('videos')">
    <i class="fas fa-video" style="margin-left: 4px;"></i>
    فيديوهات
</div>
<div class="tab-item" onclick="switchTab('articles')">
    <i class="fas fa-newspaper" style="margin-left: 4px;"></i>
    مقالات
</div>
<div class="tab-item" onclick="switchTab('mypatients')">
    <i class="fas fa-user-injured" style="margin-left: 4px;"></i>
    مرضايي
</div>
<div class="tab-item" onclick="switchTab('events')">
    <i class="fas fa-calendar" style="margin-left: 4px;"></i>
    فعاليات
</div>
@endsection

@section('tab_content')
<!-- تبويب الرائج -->
<div class="tab-content" id="trendingContent" style="display: block;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-fire"></i>
        <span>المحتوى الرائج اليوم</span>
    </div>
    
    <div class="horizontal-scroll-container">
        <div class="horizontal-cards">
            <div class="horizontal-card">
                <div class="card-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                    <i class="fas fa-code"></i>
                </div>
                <h3>برمجة</h3>
                <p>أحدث دورات البرمجة والتطوير</p>
            </div>
            
            <div class="horizontal-card">
                <div class="card-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>تحليل بيانات</h3>
                <p>تعلم تحليل البيانات والإحصاء</p>
            </div>
            
            <div class="horizontal-card">
                <div class="card-icon" style="background: rgba(236, 72, 153, 0.1); color: var(--accent);">
                    <i class="fas fa-paint-brush"></i>
                </div>
                <h3>تصميم</h3>
                <p>تصميم الويب والجرافيك</p>
            </div>
            
            <div class="horizontal-card">
                <div class="card-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                    <i class="fas fa-business-time"></i>
                </div>
                <h3>أعمال</h3>
                <p>إدارة الأعمال والتسويق</p>
            </div>
            
            <div class="horizontal-card">
                <div class="card-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3>صحة</h3>
                <p>لياقة وتغذية</p>
            </div>
            
            <div class="horizontal-card">
                <div class="card-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                    <i class="fas fa-language"></i>
                </div>
                <h3>لغات</h3>
                <p>تعلم اللغات الأجنبية</p>
            </div>
        </div>
    </div>
    <!-- مؤشر التقدم -->
    <div class="scroll-indicator">
        <div class="scroll-progress"></div>
    </div>
    <!-- تلميح السحب -->
    <div class="scroll-hint">
        <i class="fas fa-hand-point-left"></i>
        <span>اسحب لمشاهدة المزيد</span>
    </div>

    <div class="vertical-cards">
        <div class="vertical-card">
            <div class="vertical-card-content">
                <div class="card-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <div class="vertical-card-info">
                    <h3>تطوير تطبيقات الموبايل</h3>
                    <p>تعلم Flutter و React Native من الصفر</p>
                </div>
                <span style="background: var(--primary); color: white; padding: 4px 10px; 
                      border-radius: 12px; font-size: 11px; font-weight: 600;">
                    4.8 ★
                </span>
            </div>
        </div>
        
        <div class="vertical-card">
            <div class="vertical-card-content">
                <div class="card-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="vertical-card-info">
                    <h3>الذكاء الاصطناعي</h3>
                    <p>مقدمة في تعلم الآلة و AI</p>
                </div>
                <span style="background: var(--secondary); color: white; padding: 4px 10px; 
                      border-radius: 12px; font-size: 11px; font-weight: 600;">
                    4.9 ★
                </span>
            </div>
        </div>
    </div>
</div>

<!-- تبويب الجديد -->
<div class="tab-content" id="newContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-star"></i>
        <span>المحتوى المضاف حديثاً</span>
    </div>
    
    <div class="vertical-cards">
        <div class="vertical-card">
            <div class="vertical-card-content">
                <div class="card-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                    <i class="fas fa-database"></i>
                </div>
                <div class="vertical-card-info">
                    <h3>قواعد البيانات المتقدمة</h3>
                    <p>أضيف منذ 5 ساعات • 45 دقيقة</p>
                </div>
                <span style="background: var(--primary); color: white; padding: 4px 8px; 
                      border-radius: 12px; font-size: 10px; font-weight: 600;">
                    جديد
                </span>
            </div>
        </div>
        
        <div class="vertical-card">
            <div class="vertical-card-content">
                <div class="card-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                    <i class="fas fa-cloud"></i>
                </div>
                <div class="vertical-card-info">
                    <h3>الحوسبة السحابية</h3>
                    <p>أضيف منذ يوم • 1.5 ساعة</p>
                </div>
                <span style="background: var(--secondary); color: white; padding: 4px 8px; 
                      border-radius: 12px; font-size: 10px; font-weight: 600;">
                    جديد
                </span>
            </div>
        </div>
    </div>
</div>

<!-- تبويب الفئات (المعدل) -->
<div class="tab-content" id="categoriesContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-th-large"></i>
        <span>إدارة الحالات والمقررات</span>
    </div>
    
    <!-- Dropdown اختيار المقرر -->
    <div class="input-container">
        <div class="section-title">
            <i class="fas fa-book-medical"></i>
            <span>اختر المقرر</span>
        </div>
        <div class="custom-dropdown" id="courseDropdown">
            <div class="dropdown-header" onclick="toggleDropdown('courseDropdown')">
                <span>جميع المقررات</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>
            <div class="dropdown-options">
                <div class="dropdown-option selected" 
                     data-value="all"
                     onclick="selectOption('courseDropdown', 'all', 'جميع المقررات')">
                    جميع المقررات
                </div>
                <div class="dropdown-option" 
                     data-value="cardiology"
                     onclick="selectOption('courseDropdown', 'cardiology', 'طب القلب السريري')">
                    طب القلب السريري
                </div>
                <div class="dropdown-option" 
                     data-value="respiratory"
                     onclick="selectOption('courseDropdown', 'respiratory', 'أمراض الجهاز التنفسي')">
                    أمراض الجهاز التنفسي
                </div>
                <div class="dropdown-option" 
                     data-value="neurology"
                     onclick="selectOption('courseDropdown', 'neurology', 'طب الأعصاب السريري')">
                    طب الأعصاب السريري
                </div>
                <div class="dropdown-option" 
                     data-value="clinical"
                     onclick="selectOption('courseDropdown', 'clinical', 'الفحص السريري المتقدم')">
                    الفحص السريري المتقدم
                </div>
            </div>
        </div>
    </div>
    
    <!-- نمط العرض - قائمة أفقية قابلة للتمرير -->
    <div class="input-container">
        <div class="section-title">
            <i class="fas fa-filter"></i>
            <span>نمط العرض</span>
        </div>

        <div class="status-filter-cards">
            <div class="status-filter-card active" data-status="all" onclick="handleStatusFilter('all')">
                <div class="status-icon" style="background: rgba(79, 70, 229, 0.12);">
                    <i class="fas fa-list" style="color: var(--primary);"></i>
                </div>
                <div class="status-info">
                    <div class="status-count">32</div>
                    <div class="status-title">الكل</div>
                </div>
            </div>

            <div class="status-filter-card" data-status="completed" onclick="handleStatusFilter('completed')">
                <div class="status-icon" style="background: rgba(16, 185, 129, 0.12);">
                    <i class="fas fa-check-circle" style="color: var(--secondary);"></i>
                </div>
                <div class="status-info">
                    <div class="status-count">24</div>
                    <div class="status-title">مكتمل</div>
                </div>
            </div>

            <div class="status-filter-card" data-status="inProgress" onclick="handleStatusFilter('inProgress')">
                <div class="status-icon" style="background: rgba(245, 158, 11, 0.12);">
                    <i class="fas fa-spinner" style="color: var(--warning);"></i>
                </div>
                <div class="status-info">
                    <div class="status-count">12</div>
                    <div class="status-title">قيد الإنجاز</div>
                </div>
            </div>

            <div class="status-filter-card" data-status="pending" onclick="handleStatusFilter('pending')">
                <div class="status-icon" style="background: rgba(236, 72, 153, 0.12);">
                    <i class="fas fa-clock" style="color: var(--accent);"></i>
                </div>
                <div class="status-info">
                    <div class="status-count">5</div>
                    <div class="status-title">بانتظار</div>
                </div>
            </div>

            <div class="status-filter-card" data-status="rejected" onclick="handleStatusFilter('rejected')">
                <div class="status-icon" style="background: rgba(239, 68, 68, 0.12);">
                    <i class="fas fa-times-circle" style="color: var(--danger);"></i>
                </div>
                <div class="status-info">
                    <div class="status-count">3</div>
                    <div class="status-title">مرفوض</div>
                </div>
            </div>
        </div>
        <!-- مؤشر التقدم -->
        <div class="scroll-indicator">
            <div class="scroll-progress"></div>
        </div>
        <!-- تلميح السحب -->
        <div class="scroll-hint">
            <i class="fas fa-hand-point-left"></i>
            <span>اسحب لمشاهدة المزيد</span>
        </div>
    </div>

    <!-- جدول الحالات مع تمرير أفقي -->
    <div class="input-container" style="padding: 0; overflow: hidden; margin-top: 20px;">
        <div class="section-title" style="padding: 20px 20px 16px; margin: 0; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-table"></i>
                <span>قائمة الحالات</span>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <span id="casesCount" style="font-size: 12px; color: var(--primary); background: rgba(79, 70, 229, 0.1); 
                      padding: 4px 10px; border-radius: 12px;">
                    8 حالات
                </span>
                <!-- أزرار التحكم بالصور -->
                <div style="display: flex; gap: 8px;">
                    <!-- زر رفع صور للاستديو -->
                    <button onclick="showUploadToStudioModal()"
                            style="background: none; border: none; color: var(--secondary); cursor: pointer; font-size: 16px; position: relative;"
                            title="رفع صور للاستديو">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span style="position: absolute; top: -8px; right: -8px; background: var(--secondary);
                              color: white; width: 16px; height: 16px; border-radius: 50%; font-size: 10px;
                              display: flex; align-items: center; justify-content: center;">
                            +
                        </span>
                    </button>
                    <!-- زر استديو الصور (حسب المقرر المحدد) -->
                    <button onclick="showPhotoStudio()"
                            style="background: none; border: none; color: var(--accent); cursor: pointer; font-size: 16px; position: relative;"
                            title="استديو الصور">
                        <i class="fas fa-images"></i>
                        <span id="studioCountBadge" style="position: absolute; top: -8px; right: -8px; background: var(--accent);
                              color: white; min-width: 16px; height: 16px; border-radius: 50%; font-size: 10px;
                              display: flex; align-items: center; justify-content: center; padding: 0 4px;">
                            0
                        </span>
                        <!-- تحذير الصور القديمة -->
                        <span id="studioWarningBadge" style="display: none; position: absolute; top: -8px; left: -8px; background: var(--warning);
                              color: white; width: 16px; height: 16px; border-radius: 50%; font-size: 10px;
                              align-items: center; justify-content: center; animation: pulse 1.5s infinite;">
                            <i class="fas fa-exclamation" style="font-size: 8px;"></i>
                        </span>
                    </button>
                    <!-- زر استديو الصور المحذوفة -->
                    <button onclick="showDeletedPhotosStudio()"
                            style="background: none; border: none; color: var(--danger); cursor: pointer; font-size: 16px; position: relative;"
                            title="استديو الصور المحذوفة">
                        <i class="fas fa-trash-restore"></i>
                        <span id="deletedStudioCountBadge" style="position: absolute; top: -8px; right: -8px; background: var(--danger);
                              color: white; min-width: 16px; height: 16px; border-radius: 50%; font-size: 10px;
                              display: none; align-items: center; justify-content: center; padding: 0 4px;">
                            0
                        </span>
                    </button>
                    <button onclick="exportCases()"
                            style="background: none; border: none; color: var(--primary); cursor: pointer; font-size: 16px;">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- شريط البحث -->
        <div style="padding: 16px 20px; border-bottom: 1px solid #f3f4f6;">
            <div style="position: relative;">
                <input type="text" 
                       id="casesSearch"
                       class="text-input" 
                       placeholder="ابحث عن حالة، مريض، أو مقرر..."
                       style="padding-right: 40px;">
                <button onclick="searchCases()" 
                        style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); 
                               background: var(--primary); color: white; border: none; border-radius: 8px; 
                               width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; 
                               cursor: pointer;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <!-- جدول الحالات مع تمرير أفقي -->
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="cases-table" id="casesTable" style="min-width: 800px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: rgba(79, 70, 229, 0.05);">
                        <th style="padding: 16px; text-align: right; font-size: 13px; font-weight: 600; color: var(--dark); border-bottom: 2px solid rgba(79, 70, 229, 0.2); min-width: 180px;">
                            <i class="fas fa-user" style="margin-left: 6px;"></i>
                            اسم المريض
                        </th>
                        <th style="padding: 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--dark); border-bottom: 2px solid rgba(79, 70, 229, 0.2); min-width: 120px;">
                            <i class="fas fa-hashtag" style="margin-left: 6px;"></i>
                            رقم السجل
                        </th>
                        <th style="padding: 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--dark); border-bottom: 2px solid rgba(79, 70, 229, 0.2); min-width: 140px;">
                            <i class="fas fa-tag" style="margin-left: 6px;"></i>
                            نوع الحالة
                        </th>
                        <th style="padding: 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--dark); border-bottom: 2px solid rgba(79, 70, 229, 0.2); min-width: 180px;">
                            <i class="fas fa-book" style="margin-left: 6px;"></i>
                            المقرر
                        </th>
                        <th style="padding: 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--dark); border-bottom: 2px solid rgba(79, 70, 229, 0.2); min-width: 140px;">
                            <i class="fas fa-star" style="margin-left: 6px;"></i>
                            التقييمات
                        </th>
                        <th style="padding: 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--dark); border-bottom: 2px solid rgba(79, 70, 229, 0.2); min-width: 100px;">
                            <i class="fas fa-qrcode" style="margin-left: 6px;"></i>
                            QR
                        </th>
                        <th style="padding: 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--dark); border-bottom: 2px solid rgba(79, 70, 229, 0.2); min-width: 100px;">
                            <i class="fas fa-images" style="margin-left: 6px;"></i>
                            الصور
                        </th>
                        <th style="padding: 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--dark); border-bottom: 2px solid rgba(79, 70, 229, 0.2); min-width: 160px;">
                            <i class="fas fa-user-md" style="margin-left: 6px;"></i>
                            المشرف
                        </th>
                    </tr>
                </thead>
                <tbody id="casesTableBody">
                    <!-- سيتم تحميل البيانات هنا -->
                </tbody>
            </table>
        </div>
        
        <!-- تذييل الجدول -->
        <div style="padding: 16px 20px; border-top: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 12px; color: var(--gray);" id="tableFooter">
                <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
                عرض 1-8 من 32 حالة
            </div>
            <div style="display: flex; gap: 8px;">
                <button onclick="previousPage()" 
                        id="prevPageBtn"
                        style="background: white; color: var(--primary); border: 1.5px solid var(--primary); 
                               padding: 8px 16px; border-radius: var(--radius-sm); font-size: 12px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-chevron-right" style="margin-left: 4px;"></i>
                    السابق
                </button>
                <button onclick="nextPage()" 
                        id="nextPageBtn"
                        style="background: var(--primary); color: white; border: none; 
                               padding: 8px 16px; border-radius: var(--radius-sm); font-size: 12px; font-weight: 600; cursor: pointer;">
                    التالي
                    <i class="fas fa-chevron-left" style="margin-right: 4px;"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- إحصائيات سريعة -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 20px;">
        <div class="stat-card" style="border-right: 4px solid var(--primary);">
            <div class="stat-number" style="color: var(--primary);">24</div>
            <div class="stat-label">حالة مكتملة</div>
        </div>
        <div class="stat-card" style="border-right: 4px solid var(--warning);">
            <div class="stat-number" style="color: var(--warning);">12</div>
            <div class="stat-label">قيد الإنجاز</div>
        </div>
        <div class="stat-card" style="border-right: 4px solid var(--accent);">
            <div class="stat-number" style="color: var(--accent);">5</div>
            <div class="stat-label">بانتظار الموافقة</div>
        </div>
        <div class="stat-card" style="border-right: 4px solid var(--danger);">
            <div class="stat-number" style="color: var(--danger);">3</div>
            <div class="stat-label">حالات مرفوضة</div>
        </div>
    </div>
</div>

<!-- تبويب المتابعات -->
<div class="tab-content" id="followingContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-users"></i>
        <span>الأشخاص الذين تتابعهم</span>
    </div>
    
    <div class="vertical-cards">
        <div class="vertical-card">
            <div class="vertical-card-content">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--accent)); 
                          border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                          color: white; font-weight: 600; font-size: 16px; flex-shrink: 0;">
                    أ
                </div>
                <div class="vertical-card-info">
                    <h3>أحمد محمد</h3>
                    <p>مطور ويب • 12 دورة • 5.4K متابع</p>
                </div>
                <button style="background: var(--primary); color: white; border: none; padding: 8px 16px; 
                         border-radius: var(--radius-sm); font-size: 12px; cursor: pointer;">
                    تابع
                </button>
            </div>
        </div>
        
        <div class="vertical-card">
            <div class="vertical-card-content">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--secondary), var(--warning)); 
                          border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                          color: white; font-weight: 600; font-size: 16px; flex-shrink: 0;">
                    س
                </div>
                <div class="vertical-card-info">
                    <h3>سارة عبدالله</h3>
                    <p>مصممة جرافيك • 8 دورات • 3.2K متابع</p>
                </div>
                <button style="background: var(--primary); color: white; border: none; padding: 8px 16px; 
                         border-radius: var(--radius-sm); font-size: 12px; cursor: pointer;">
                    تابع
                </button>
            </div>
        </div>
    </div>
</div>

<!-- تبويبات إضافية -->
<div class="tab-content" id="videosContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-video"></i>
        <span>الفيديوهات التعليمية</span>
    </div>
    <p style="text-align: center; color: var(--gray); padding: 40px 20px;">
        محتوى الفيديوهات سيظهر هنا قريباً
    </p>
</div>

<div class="tab-content" id="articlesContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-newspaper"></i>
        <span>المقالات التعليمية</span>
    </div>
    <p style="text-align: center; color: var(--gray); padding: 40px 20px;">
        محتوى المقالات سيظهر هنا قريباً
    </p>
</div>

<!-- تبويب مرضايي -->
<div class="tab-content" id="mypatientsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-user-injured"></i>
        <span>مرضايي</span>
    </div>

    <!-- فلتر نوع المرضى -->
    <div class="patients-filter-container" style="margin-bottom: 20px;">
        <div class="patients-filter-cards" style="display: flex; gap: 12px; overflow-x: auto; padding: 8px 4px; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;">
            <div class="patient-filter-card active" data-filter="private" onclick="filterPatients('private')"
                 style="flex-shrink: 0; background: linear-gradient(135deg, var(--primary), #6366f1); color: white; padding: 16px 24px; border-radius: 16px; cursor: pointer; min-width: 160px; scroll-snap-align: start; box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-shield" style="font-size: 18px;"></i>
                    </div>
                    <span style="font-size: 24px; font-weight: 700;">12</span>
                </div>
                <div style="font-size: 14px; font-weight: 600;">مرضايي الخاصين</div>
                <div style="font-size: 11px; opacity: 0.8; margin-top: 4px;">حالات خاصة بي</div>
            </div>

            <div class="patient-filter-card" data-filter="public" onclick="filterPatients('public')"
                 style="flex-shrink: 0; background: white; color: var(--dark); padding: 16px 24px; border-radius: 16px; cursor: pointer; min-width: 160px; scroll-snap-align: start; border: 2px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <div style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="font-size: 18px; color: var(--secondary);"></i>
                    </div>
                    <span style="font-size: 24px; font-weight: 700; color: var(--secondary);">28</span>
                </div>
                <div style="font-size: 14px; font-weight: 600;">مرضايي العامين</div>
                <div style="font-size: 11px; color: var(--gray); margin-top: 4px;">حالات مشتركة</div>
            </div>
        </div>
    </div>

    <!-- قائمة المرضى -->
    <div class="patients-list" id="patientsList">
        <!-- مريض 1 -->
        <div class="patient-card" style="background: white; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f3f4f6;">
            <div style="display: flex; gap: 12px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--primary), #6366f1); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                    أ
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: var(--dark);">أحمد محمد علي</div>
                            <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">
                                <i class="fas fa-hashtag" style="margin-left: 4px;"></i>MED-2024-001
                            </div>
                        </div>
                        <span style="background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 600;">
                            <i class="fas fa-user-shield" style="margin-left: 4px;"></i>خاص
                        </span>
                    </div>
                    <div style="display: flex; gap: 16px; margin-top: 10px; font-size: 12px; color: var(--gray);">
                        <span><i class="fas fa-birthday-cake" style="margin-left: 4px; color: var(--accent);"></i>45 سنة</span>
                        <span><i class="fas fa-stethoscope" style="margin-left: 4px; color: var(--secondary);"></i>قلبية</span>
                        <span><i class="fas fa-calendar" style="margin-left: 4px; color: var(--warning);"></i>15/01/2024</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f3f4f6;">
                <button onclick="viewPatientDetails(1)" style="flex: 1; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-eye"></i>
                    عرض التفاصيل
                </button>
                <button onclick="editPatient(1)" style="background: rgba(79, 70, 229, 0.1); color: var(--primary); border: none; padding: 10px 16px; border-radius: 10px; cursor: pointer;">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <!-- مريض 2 -->
        <div class="patient-card" style="background: white; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f3f4f6;">
            <div style="display: flex; gap: 12px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--secondary), #34d399); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                    س
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: var(--dark);">سارة أحمد الخالد</div>
                            <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">
                                <i class="fas fa-hashtag" style="margin-left: 4px;"></i>MED-2024-002
                            </div>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.1); color: var(--secondary); padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 600;">
                            <i class="fas fa-users" style="margin-left: 4px;"></i>عام
                        </span>
                    </div>
                    <div style="display: flex; gap: 16px; margin-top: 10px; font-size: 12px; color: var(--gray);">
                        <span><i class="fas fa-birthday-cake" style="margin-left: 4px; color: var(--accent);"></i>32 سنة</span>
                        <span><i class="fas fa-stethoscope" style="margin-left: 4px; color: var(--secondary);"></i>تنفسية</span>
                        <span><i class="fas fa-calendar" style="margin-left: 4px; color: var(--warning);"></i>20/01/2024</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f3f4f6;">
                <button onclick="viewPatientDetails(2)" style="flex: 1; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-eye"></i>
                    عرض التفاصيل
                </button>
                <button onclick="editPatient(2)" style="background: rgba(79, 70, 229, 0.1); color: var(--primary); border: none; padding: 10px 16px; border-radius: 10px; cursor: pointer;">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <!-- مريض 3 -->
        <div class="patient-card" style="background: white; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f3f4f6;">
            <div style="display: flex; gap: 12px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--accent), #f472b6); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                    م
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: var(--dark);">محمود خالد العمري</div>
                            <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">
                                <i class="fas fa-hashtag" style="margin-left: 4px;"></i>MED-2024-003
                            </div>
                        </div>
                        <span style="background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 600;">
                            <i class="fas fa-user-shield" style="margin-left: 4px;"></i>خاص
                        </span>
                    </div>
                    <div style="display: flex; gap: 16px; margin-top: 10px; font-size: 12px; color: var(--gray);">
                        <span><i class="fas fa-birthday-cake" style="margin-left: 4px; color: var(--accent);"></i>58 سنة</span>
                        <span><i class="fas fa-stethoscope" style="margin-left: 4px; color: var(--secondary);"></i>عصبية</span>
                        <span><i class="fas fa-calendar" style="margin-left: 4px; color: var(--warning);"></i>22/01/2024</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f3f4f6;">
                <button onclick="viewPatientDetails(3)" style="flex: 1; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-eye"></i>
                    عرض التفاصيل
                </button>
                <button onclick="editPatient(3)" style="background: rgba(79, 70, 229, 0.1); color: var(--primary); border: none; padding: 10px 16px; border-radius: 10px; cursor: pointer;">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <!-- مريض 4 -->
        <div class="patient-card" style="background: white; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f3f4f6;">
            <div style="display: flex; gap: 12px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--warning), #fbbf24); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                    ف
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: var(--dark);">فاطمة علي حسن</div>
                            <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">
                                <i class="fas fa-hashtag" style="margin-left: 4px;"></i>MED-2024-004
                            </div>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.1); color: var(--secondary); padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 600;">
                            <i class="fas fa-users" style="margin-left: 4px;"></i>عام
                        </span>
                    </div>
                    <div style="display: flex; gap: 16px; margin-top: 10px; font-size: 12px; color: var(--gray);">
                        <span><i class="fas fa-birthday-cake" style="margin-left: 4px; color: var(--accent);"></i>28 سنة</span>
                        <span><i class="fas fa-stethoscope" style="margin-left: 4px; color: var(--secondary);"></i>باطنية</span>
                        <span><i class="fas fa-calendar" style="margin-left: 4px; color: var(--warning);"></i>25/01/2024</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f3f4f6;">
                <button onclick="viewPatientDetails(4)" style="flex: 1; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-eye"></i>
                    عرض التفاصيل
                </button>
                <button onclick="editPatient(4)" style="background: rgba(79, 70, 229, 0.1); color: var(--primary); border: none; padding: 10px 16px; border-radius: 10px; cursor: pointer;">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="tab-content" id="eventsContent" style="display: none;">
    <div class="section-title" style="margin-top: 20px;">
        <i class="fas fa-calendar"></i>
        <span>الفعاليات القادمة</span>
    </div>
    <p style="text-align: center; color: var(--gray); padding: 40px 20px;">
        محتوى الفعاليات سيظهر هنا قريباً
    </p>
</div>

<!-- أنماط الجدول والتصميم -->
<style>
/* Enhanced Status Filter Cards */
.status-filter-cards {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding: 8px 4px 16px;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.status-filter-cards::-webkit-scrollbar { display: none; }

/* Table Row Hover Animation */
.cases-table tbody tr {
    cursor: pointer;
}

.cases-table tbody tr:hover {
    background: linear-gradient(90deg, rgba(79, 70, 229, 0.04), transparent);
}

.cases-table tbody tr:active {
    transform: scale(0.995);
}

/* Enhanced Pagination Buttons */
#prevPageBtn, #nextPageBtn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#prevPageBtn:not(:disabled):hover,
#nextPageBtn:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
}

#nextPageBtn:not(:disabled):active,
#prevPageBtn:not(:disabled):active {
    transform: scale(0.96);
}

/* Search Input Enhancement */
#casesSearch {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px 48px 12px 16px;
    font-size: 14px;
    transition: all 0.3s;
}

#casesSearch:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    outline: none;
}

/* Export and Upload Buttons */
.input-container [onclick*="export"],
.input-container [onclick*="Upload"],
.input-container [onclick*="Images"] {
    transition: all 0.25s;
}

.input-container [onclick*="export"]:hover,
.input-container [onclick*="Upload"]:hover,
.input-container [onclick*="Images"]:hover {
    transform: scale(1.15);
}

/* Stat Cards in Categories */
.stat-card {
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(79, 70, 229, 0.05) 0%, transparent 70%);
    transition: all 0.5s;
}

.stat-card:hover::before {
    transform: scale(1.5);
}

/* Smooth Tab Transitions */
.tab-item {
    position: relative;
    overflow: hidden;
}

.tab-item::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: calc(100% - 16px);
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    border-radius: 3px 3px 0 0;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.tab-item.active::before {
    transform: translateX(-50%) scaleX(1);
}

.tab-item:hover:not(.active)::before {
    transform: translateX(-50%) scaleX(0.5);
    background: var(--gray-300);
}

/* Cards Entrance Animation */
@keyframes cardEntrance {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.vertical-card {
    animation: cardEntrance 0.4s ease backwards;
}

.vertical-card:nth-child(1) { animation-delay: 0.1s; }
.vertical-card:nth-child(2) { animation-delay: 0.15s; }
.vertical-card:nth-child(3) { animation-delay: 0.2s; }
.vertical-card:nth-child(4) { animation-delay: 0.25s; }
.vertical-card:nth-child(5) { animation-delay: 0.3s; }

/* Floating Alert Enhancements */
.qr-floating-alert,
.images-alert {
    border: 1px solid rgba(0, 0, 0, 0.05);
}

/* Loading Shimmer for Table */
.skeleton-row {
    background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
}

/* Button Ripple Effect */
.qr-btn::after,
.images-btn::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(255,255,255,0.3) 0%, transparent 70%);
    opacity: 0;
    transform: scale(0);
    transition: all 0.5s;
}

.qr-btn:active::after,
.images-btn:active::after {
    opacity: 1;
    transform: scale(2);
}

/* ========== استديو الصور Styles ========== */
.studio-modal {
    max-width: 420px;
}

.studio-image-item {
    transition: all 0.3s ease;
}

.studio-image-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

#studioWarningBadge {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.1); }
}

/* Studio Upload Area */
.studio-modal .upload-area {
    border: 2px dashed var(--gray-300);
    border-radius: var(--radius-lg);
    padding: 30px 20px;
    text-align: center;
    transition: all 0.3s;
    cursor: pointer;
}

.studio-modal .upload-area:hover,
.studio-modal .upload-area.dragover {
    border-color: var(--secondary);
    background: rgba(16, 185, 129, 0.03);
}

.studio-modal .upload-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    font-size: 24px;
    color: var(--secondary);
}

/* Image item from studio badge */
.image-item .studio-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: var(--primary);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    z-index: 5;
}
</style>

<script>
// بيانات الحالات
const casesData = [
    {
        id: 1,
        patientName: "أحمد محمد علي",
        patientInitial: "أ",
        recordNumber: "MED-2024-001",
        caseType: "قلبية",
        course: "طب القلب السريري",
        status: "completed",
        rating: 4.5,
        maxRating: 5,
        qrCode: "QR-MED-001",
        images: [
            { id: 1, name: "صورة 1.jpg", size: "2.3 MB", url: "https://via.placeholder.com/300x200/4F46E5/FFFFFF?text=صورة+1" },
            { id: 2, name: "تخطيط.png", size: "1.5 MB", url: "https://via.placeholder.com/300x200/10B981/FFFFFF?text=تخطيط" }
        ],
        supervisor: {
            name: "د. سامر الحلبي",
            initial: "س"
        },
        caseDetails: {
            age: "45 سنة",
            gender: "ذكر",
            admissionDate: "15/01/2024",
            diagnosis: "ارتفاع ضغط الدم الشرياني"
        }
    },
    {
        id: 2,
        patientName: "سارة خالد حسن",
        patientInitial: "س",
        recordNumber: "MED-2024-002",
        caseType: "صدرية",
        course: "أمراض الجهاز التنفسي",
        status: "inProgress",
        rating: 3.8,
        maxRating: 5,
        qrCode: "QR-MED-002",
        images: [
            { id: 3, name: "أشعة.jpg", size: "3.1 MB", url: "https://via.placeholder.com/300x200/EC4899/FFFFFF?text=أشعة" },
            { id: 4, name: "تحليل.pdf", size: "4.2 MB", url: "https://via.placeholder.com/300x200/F59E0B/FFFFFF?text=تحليل" },
            { id: 5, name: "ملاحظات.png", size: "1.8 MB", url: "https://via.placeholder.com/300x200/3B82F6/FFFFFF?text=ملاحظات" }
        ],
        supervisor: {
            name: "د. لينا محمود",
            initial: "ل"
        },
        caseDetails: {
            age: "32 سنة",
            gender: "أنثى",
            admissionDate: "20/01/2024",
            diagnosis: "ربو قصبي"
        }
    },
    {
        id: 3,
        patientName: "محمد عمر النجار",
        patientInitial: "م",
        recordNumber: "MED-2024-003",
        caseType: "عصبية",
        course: "طب الأعصاب السريري",
        status: "pending",
        rating: 4.2,
        maxRating: 5,
        qrCode: "QR-MED-003",
        images: [
            { id: 6, name: "رنين.jpg", size: "5.3 MB", url: "https://via.placeholder.com/300x200/8B5CF6/FFFFFF?text=رنين" }
        ],
        supervisor: {
            name: "د. خالد أحمد",
            initial: "خ"
        },
        caseDetails: {
            age: "58 سنة",
            gender: "ذكر",
            admissionDate: "05/02/2024",
            diagnosis: "صداع نصفي مزمن"
        }
    },
    {
        id: 4,
        patientName: "لينا أحمد محمود",
        patientInitial: "ل",
        recordNumber: "MED-2024-004",
        caseType: "قلبية",
        course: "طب القلب السريري",
        status: "rejected",
        rating: 2.5,
        maxRating: 5,
        qrCode: "QR-MED-004",
        images: [],
        supervisor: {
            name: "د. سامر الحلبي",
            initial: "س"
        },
        caseDetails: {
            age: "67 سنة",
            gender: "أنثى",
            admissionDate: "12/02/2024",
            diagnosis: "قصور القلب الاحتقاني"
        }
    },
{
        id: 5,
        patientName: "خالد سعيد رضوان",
        patientInitial: "خ",
        recordNumber: "MED-2024-005",
        caseType: "صدرية",
        course: "أمراض الجهاز التنفسي",
        status: "completed",
        rating: 4.8,
        maxRating: 5,
        qrCode: "QR-MED-005",
        images: [
            { id: 7, name: "فحص.jpg", size: "2.9 MB", url: "https://via.placeholder.com/300x200/EF4444/FFFFFF?text=فحص" },
            { id: 8, name: "نتائج.png", size: "1.2 MB", url: "https://via.placeholder.com/300x200/06B6D4/FFFFFF?text=نتائج" }
        ],
        supervisor: {
            name: "د. لينا محمود",
            initial: "ل"
        },
        caseDetails: {
            age: "29 سنة",
            gender: "ذكر",
            admissionDate: "25/02/2024",
            diagnosis: "التهاب رئوي"
        }
    }
];

// متغيرات التصفية
let currentStatusFilter = 'all';
let currentCourseFilter = 'all';
let currentPage = 1;
const casesPerPage = 8;

// متغيرات الصور
let selectedCaseId = null;
let imagesToUpload = [];
let currentImageViewerIndex = 0;
let currentImages = [];

// ========== استديو الصور (منفصل لكل مقرر) ==========
// تخزين صور الاستديو حسب المقرر في localStorage
function getStudioKey(course) {
    return `photoStudio_${course || 'all'}`;
}

function getDeletedStudioKey() {
    return 'deletedPhotosStudio';
}

// الحصول على استديو المقرر الحالي
function getCurrentStudio() {
    const key = getStudioKey(currentCourseFilter);
    return JSON.parse(localStorage.getItem(key) || '[]');
}

// الحصول على استديو الصور المحذوفة
function getDeletedStudio() {
    return JSON.parse(localStorage.getItem(getDeletedStudioKey()) || '[]');
}

// حفظ استديو المقرر الحالي
function saveCurrentStudio(studio) {
    const key = getStudioKey(currentCourseFilter);
    localStorage.setItem(key, JSON.stringify(studio));
    updateStudioBadge();
    updateDeletedStudioBadge();
}

// حفظ استديو الصور المحذوفة
function saveDeletedStudio(studio) {
    localStorage.setItem(getDeletedStudioKey(), JSON.stringify(studio));
    updateDeletedStudioBadge();
}

// تهيئة الاستديو مع بيانات تجريبية
function initPhotoStudio() {
    // إضافة صور تجريبية لكل مقرر (مرة واحدة فقط)
    const courses = ['all', 'cardiology', 'respiratory', 'neurology', 'clinical'];

    courses.forEach((course, idx) => {
        const key = getStudioKey(course);
        const existing = JSON.parse(localStorage.getItem(key) || '[]');

        if (existing.length === 0 && !localStorage.getItem(`studioInitialized_${course}`)) {
            const now = new Date();
            const fiveHoursAgo = new Date(now.getTime() - (5 * 60 * 60 * 1000));
            const twoHoursAgo = new Date(now.getTime() - (2 * 60 * 60 * 1000));
            const thirtyMinsAgo = new Date(now.getTime() - (30 * 60 * 1000));

            const courseNames = {
                'all': 'عام',
                'cardiology': 'قلب',
                'respiratory': 'تنفسي',
                'neurology': 'أعصاب',
                'clinical': 'سريري'
            };

            const demoImages = [
                {
                    id: Date.now() + idx * 100 + 1,
                    name: `أشعة_${courseNames[course]}_001.jpg`,
                    size: '2.4 MB',
                    url: `https://via.placeholder.com/300x200/4F46E5/FFFFFF?text=${courseNames[course]}+Xray`,
                    uploadTime: fiveHoursAgo.toISOString(),
                    assignedTo: null,
                    assignedStep: null,
                    course: course
                },
                {
                    id: Date.now() + idx * 100 + 2,
                    name: `تخطيط_${courseNames[course]}_ECG.png`,
                    size: '1.8 MB',
                    url: `https://via.placeholder.com/300x200/10B981/FFFFFF?text=${courseNames[course]}+ECG`,
                    uploadTime: twoHoursAgo.toISOString(),
                    assignedTo: null,
                    assignedStep: null,
                    course: course
                },
                {
                    id: Date.now() + idx * 100 + 3,
                    name: `تحليل_${courseNames[course]}_CBC.jpg`,
                    size: '1.2 MB',
                    url: `https://via.placeholder.com/300x200/EC4899/FFFFFF?text=${courseNames[course]}+CBC`,
                    uploadTime: thirtyMinsAgo.toISOString(),
                    assignedTo: null,
                    assignedStep: null,
                    course: course
                }
            ];

            localStorage.setItem(key, JSON.stringify(demoImages));
            localStorage.setItem(`studioInitialized_${course}`, 'true');
        }
    });

    updateStudioBadge();
    updateDeletedStudioBadge();
    checkOldImages();
}

// تحديث badge الاستديو
function updateStudioBadge() {
    const badge = document.getElementById('studioCountBadge');
    const warningBadge = document.getElementById('studioWarningBadge');
    const studio = getCurrentStudio();
    const unassignedCount = studio.filter(img => !img.assignedTo).length;

    if (badge) {
        badge.textContent = unassignedCount;
        badge.style.display = unassignedCount > 0 ? 'flex' : 'none';
    }

    // التحقق من الصور القديمة (أكثر من 4 ساعات)
    const oldImages = studio.filter(img => {
        if (img.assignedTo) return false;
        const uploadTime = new Date(img.uploadTime);
        const now = new Date();
        const hoursDiff = (now - uploadTime) / (1000 * 60 * 60);
        return hoursDiff > 4;
    });

    if (warningBadge) {
        warningBadge.style.display = oldImages.length > 0 ? 'flex' : 'none';
    }
}

// تحديث badge استديو الصور المحذوفة
function updateDeletedStudioBadge() {
    const badge = document.getElementById('deletedStudioCountBadge');
    const deletedStudio = getDeletedStudio();

    if (badge) {
        badge.textContent = deletedStudio.length;
        badge.style.display = deletedStudio.length > 0 ? 'flex' : 'none';
    }
}

// التحقق من الصور القديمة
function checkOldImages() {
    const studio = getCurrentStudio();
    const oldImages = studio.filter(img => {
        if (img.assignedTo) return false;
        const uploadTime = new Date(img.uploadTime);
        const now = new Date();
        const hoursDiff = (now - uploadTime) / (1000 * 60 * 60);
        return hoursDiff > 4;
    });

    return oldImages;
}

// الحصول على اسم المقرر
function getCourseName(courseKey) {
    const names = {
        'all': 'جميع المقررات',
        'cardiology': 'طب القلب السريري',
        'respiratory': 'أمراض الجهاز التنفسي',
        'neurology': 'طب الأعصاب السريري',
        'clinical': 'الفحص السريري المتقدم'
    };
    return names[courseKey] || courseKey;
}

// عرض modal رفع صور للاستديو
function showUploadToStudioModal() {
    imagesToUpload = [];
    const courseName = getCourseName(currentCourseFilter);

    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = closeStudioModal;

    const modal = document.createElement('div');
    modal.className = 'studio-modal images-alert';
    modal.id = 'uploadStudioModal';
    modal.onclick = function(e) { e.stopPropagation(); };

    modal.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-cloud-upload-alt" style="color: var(--secondary);"></i>
                رفع صور إلى الاستديو
            </h3>
            <button onclick="closeStudioModal()"
                    style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- المقرر المحدد -->
        <div style="background: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: var(--radius); margin-bottom: 16px; border: 1px solid rgba(16, 185, 129, 0.3);">
            <div style="font-size: 13px; color: var(--secondary); display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-book"></i>
                <span><strong>المقرر:</strong> ${courseName}</span>
            </div>
        </div>

        <div style="background: rgba(79, 70, 229, 0.05); padding: 12px; border-radius: var(--radius); margin-bottom: 16px;">
            <div style="font-size: 13px; color: var(--gray-dark); display: flex; align-items: start; gap: 8px;">
                <i class="fas fa-info-circle" style="color: var(--primary); margin-top: 2px;"></i>
                <span>الصور ترفع أولاً للاستديو، ثم يمكنك توجيهها للحالات المناسبة. لا يمكن رفع صور مباشرة للحالات.</span>
            </div>
        </div>

        <div class="upload-area" id="studioUploadArea"
             ondragover="handleStudioDragOver(event)"
             ondragleave="handleStudioDragLeave(event)"
             ondrop="handleStudioDrop(event)">
            <div class="upload-icon">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <div style="font-size: 16px; font-weight: 600; color: var(--dark);">
                اسحب وأفلت الصور هنا
            </div>
            <div class="upload-hint">أو</div>
            <input type="file" id="studioFileInput" multiple accept="image/*"
                   style="display: none;" onchange="handleStudioFileSelect(event)">
            <button onclick="document.getElementById('studioFileInput').click()"
                    style="background: var(--secondary); color: white; border: none;
                           padding: 10px 24px; border-radius: var(--radius-sm);
                           font-weight: 600; cursor: pointer; margin-top: 12px;">
                <i class="fas fa-folder-open" style="margin-left: 8px;"></i>
                اختر ملفات
            </button>
            <div class="file-types">
                يدعم: JPG, PNG, GIF (حتى 10MB لكل صورة)
            </div>
        </div>

        <!-- شريط تقدم الرفع -->
        <div id="uploadProgressContainer" style="display: none; margin-top: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 13px; color: var(--dark);">جاري الرفع...</span>
                <span id="uploadProgressPercent" style="font-size: 14px; font-weight: 700; color: var(--secondary);">0%</span>
            </div>
            <div style="background: var(--gray-100); border-radius: 10px; height: 12px; overflow: hidden;">
                <div id="uploadProgressBar" style="background: linear-gradient(90deg, var(--secondary), var(--primary)); height: 100%; width: 0%; border-radius: 10px; transition: width 0.3s ease;"></div>
            </div>
            <div id="uploadProgressText" style="font-size: 12px; color: var(--gray); text-align: center; margin-top: 8px;">
                تحضير الملفات...
            </div>
        </div>

        <div class="file-preview" id="studioFilePreview" style="display: none;">
            <h4 style="text-align: right; margin-bottom: 12px; color: var(--dark);">
                <i class="fas fa-list" style="margin-left: 6px;"></i>
                الملفات المختارة (<span id="studioFileCount">0</span>)
            </h4>
            <div id="studioPreviewList"></div>
        </div>

        <div id="uploadButtonsContainer" style="display: flex; gap: 12px; margin-top: 24px;">
            <button onclick="uploadToStudio()"
                    id="uploadStudioBtn"
                    style="flex: 1; background: var(--secondary); color: white; border: none;
                           padding: 12px; border-radius: var(--radius-sm); font-weight: 600;
                           cursor: pointer; opacity: 0.5;" disabled>
                <i class="fas fa-upload" style="margin-left: 8px;"></i>
                رفع للاستديو
            </button>
            <button onclick="closeStudioModal()"
                    style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb;
                           padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                إلغاء
            </button>
        </div>
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(modal);
}

// معالجة السحب والإفلات للاستديو
function handleStudioDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    document.getElementById('studioUploadArea')?.classList.add('dragover');
}

function handleStudioDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    document.getElementById('studioUploadArea')?.classList.remove('dragover');
}

function handleStudioDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    document.getElementById('studioUploadArea')?.classList.remove('dragover');
    handleStudioFiles(e.dataTransfer.files);
}

function handleStudioFileSelect(e) {
    handleStudioFiles(e.target.files);
}

function handleStudioFiles(files) {
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (!file.type.startsWith('image/')) {
            showToast(`الملف "${file.name}" ليس صورة`, 'warning');
            continue;
        }

        if (file.size > 10 * 1024 * 1024) {
            showToast(`الملف "${file.name}" أكبر من 10MB`, 'warning');
            continue;
        }

        imagesToUpload.push({
            id: Date.now() + i,
            file: file,
            name: file.name,
            size: formatFileSize(file.size),
            preview: URL.createObjectURL(file)
        });
    }

    updateStudioPreview();
    toggleStudioUploadButton();
}

function updateStudioPreview() {
    const previewContainer = document.getElementById('studioFilePreview');
    const previewList = document.getElementById('studioPreviewList');
    const fileCount = document.getElementById('studioFileCount');

    if (!previewContainer || !previewList) return;

    if (imagesToUpload.length === 0) {
        previewContainer.style.display = 'none';
        return;
    }

    previewContainer.style.display = 'block';
    if (fileCount) fileCount.textContent = imagesToUpload.length;

    previewList.innerHTML = imagesToUpload.map(item => `
        <div class="preview-item">
            <div class="preview-info">
                <div class="file-icon">
                    <i class="fas fa-image"></i>
                </div>
                <div style="text-align: right; flex: 1;">
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark);">${item.name}</div>
                    <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">${item.size}</div>
                </div>
            </div>
            <button class="delete-btn" onclick="removeStudioFile(${item.id})">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');
}

function removeStudioFile(fileId) {
    const index = imagesToUpload.findIndex(item => item.id === fileId);
    if (index > -1) {
        URL.revokeObjectURL(imagesToUpload[index].preview);
        imagesToUpload.splice(index, 1);
        updateStudioPreview();
        toggleStudioUploadButton();
    }
}

function toggleStudioUploadButton() {
    const btn = document.getElementById('uploadStudioBtn');
    if (btn) {
        btn.disabled = imagesToUpload.length === 0;
        btn.style.opacity = imagesToUpload.length === 0 ? '0.5' : '1';
    }
}

function uploadToStudio() {
    if (imagesToUpload.length === 0) return;

    const btn = document.getElementById('uploadStudioBtn');
    const buttonsContainer = document.getElementById('uploadButtonsContainer');
    const progressContainer = document.getElementById('uploadProgressContainer');
    const progressBar = document.getElementById('uploadProgressBar');
    const progressPercent = document.getElementById('uploadProgressPercent');
    const progressText = document.getElementById('uploadProgressText');

    // إخفاء الأزرار وإظهار شريط التقدم
    if (buttonsContainer) buttonsContainer.style.display = 'none';
    if (progressContainer) progressContainer.style.display = 'block';

    const totalFiles = imagesToUpload.length;
    let uploadedCount = 0;
    const now = new Date();
    const studio = getCurrentStudio();

    // محاكاة رفع كل ملف مع تحديث المؤشر
    function uploadNextFile() {
        if (uploadedCount >= totalFiles) {
            // اكتمل الرفع
            if (progressPercent) progressPercent.textContent = '100%';
            if (progressBar) progressBar.style.width = '100%';
            if (progressText) progressText.textContent = 'اكتمل الرفع بنجاح!';

            saveCurrentStudio(studio);

            setTimeout(() => {
                showToast(`تم رفع ${totalFiles} صورة للاستديو بنجاح`, 'success');
                imagesToUpload = [];
                closeStudioModal();
                // فتح الاستديو لعرض الصور
                setTimeout(() => showPhotoStudio(), 300);
            }, 500);
            return;
        }

        const item = imagesToUpload[uploadedCount];
        const percent = Math.round(((uploadedCount + 1) / totalFiles) * 100);

        // تحديث المؤشر
        if (progressPercent) progressPercent.textContent = `${percent}%`;
        if (progressBar) progressBar.style.width = `${percent}%`;
        if (progressText) progressText.textContent = `جاري رفع: ${item.name} (${uploadedCount + 1}/${totalFiles})`;

        // إضافة الصورة للاستديو
        studio.push({
            id: Date.now() + Math.random(),
            name: item.name,
            size: item.size,
            url: item.preview,
            uploadTime: now.toISOString(),
            assignedTo: null,
            assignedStep: null,
            course: currentCourseFilter
        });

        uploadedCount++;

        // تأخير محاكاة لرفع الملف التالي
        setTimeout(uploadNextFile, 400);
    }

    // بدء الرفع
    if (progressText) progressText.textContent = 'بدء الرفع...';
    setTimeout(uploadNextFile, 300);
}

// عرض استديو الصور (حسب المقرر المحدد)
function showPhotoStudio() {
    const studio = getCurrentStudio();
    const unassignedImages = studio.filter(img => !img.assignedTo);
    const oldImages = checkOldImages();
    const courseName = getCourseName(currentCourseFilter);

    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = closeStudioModal;

    const modal = document.createElement('div');
    modal.className = 'studio-modal images-alert';
    modal.id = 'photoStudioModal';
    modal.style.maxWidth = '500px';
    modal.onclick = function(e) { e.stopPropagation(); };

    modal.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-images" style="color: var(--accent);"></i>
                استديو الصور
                <span style="background: var(--accent); color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">
                    ${unassignedImages.length}
                </span>
            </h3>
            <button onclick="closeStudioModal()"
                    style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- المقرر المحدد -->
        <div style="background: rgba(236, 72, 153, 0.1); padding: 10px 12px; border-radius: var(--radius); margin-bottom: 16px; border: 1px solid rgba(236, 72, 153, 0.3);">
            <div style="font-size: 13px; color: var(--accent); display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-book"></i>
                <span><strong>المقرر:</strong> ${courseName}</span>
            </div>
        </div>

        ${oldImages.length > 0 ? `
            <div style="background: rgba(245, 158, 11, 0.1); padding: 12px; border-radius: var(--radius);
                      margin-bottom: 16px; border: 1px solid rgba(245, 158, 11, 0.3);">
                <div style="font-size: 13px; color: var(--warning); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span><strong>${oldImages.length} صورة</strong> مضى عليها أكثر من 4 ساعات بدون تحديد حالة!</span>
                </div>
            </div>
        ` : ''}

        <div id="studioImagesList" style="max-height: 350px; overflow-y: auto;">
            ${unassignedImages.length > 0 ? unassignedImages.map(img => {
                const uploadTime = new Date(img.uploadTime);
                const now = new Date();
                const hoursDiff = (now - uploadTime) / (1000 * 60 * 60);
                const isOld = hoursDiff > 4;

                return `
                    <div class="studio-image-item" style="background: ${isOld ? 'rgba(245, 158, 11, 0.08)' : '#fff'};
                              border: 1px solid ${isOld ? 'var(--warning)' : 'var(--gray-200)'};
                              border-radius: var(--radius); padding: 12px; margin-bottom: 12px;
                              ${isOld ? 'animation: pulse 2s infinite;' : ''}">
                        <div style="display: flex; gap: 12px;">
                            <div style="width: 70px; height: 70px; border-radius: 8px; overflow: hidden; flex-shrink: 0; cursor: pointer;"
                                 onclick="openStudioImageViewer('${img.url}', '${img.name}')">
                                <img src="${img.url}" alt="${img.name}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="flex: 1; text-align: right;">
                                <div style="font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 4px;">
                                    ${img.name}
                                </div>
                                <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">
                                    <i class="fas fa-hdd" style="margin-left: 4px;"></i>${img.size}
                                </div>
                                <div style="font-size: 11px; color: ${isOld ? 'var(--warning)' : 'var(--gray)'};">
                                    <i class="fas fa-clock" style="margin-left: 4px;"></i>
                                    ${formatUploadTime(img.uploadTime)}
                                    ${isOld ? '<span style="color: var(--warning); font-weight: 600;"> (قديمة!)</span>' : ''}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 8px; margin-top: 12px;">
                            <button onclick="showAssignImageModal(${img.id})"
                                    style="flex: 1; background: var(--primary); color: white; border: none;
                                           padding: 10px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-share" style="margin-left: 6px;"></i>
                                توجيه للحالة
                            </button>
                            <button onclick="moveToDeletedStudio(${img.id})"
                                    style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: none;
                                           padding: 10px 14px; border-radius: 8px; cursor: pointer;"
                                    title="نقل للمحذوفات">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            }).join('') : `
                <div style="text-align: center; padding: 40px 20px;">
                    <div style="width: 80px; height: 80px; background: var(--gray-100);
                              border-radius: 50%; display: flex; align-items: center;
                              justify-content: center; margin: 0 auto 16px;">
                        <i class="fas fa-images" style="font-size: 32px; color: var(--gray);"></i>
                    </div>
                    <div style="font-size: 16px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        استديو ${courseName} فارغ
                    </div>
                    <div style="font-size: 14px; color: var(--gray);">
                        قم برفع صور جديدة للبدء
                    </div>
                </div>
            `}
        </div>

        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <button onclick="closeStudioModal(); setTimeout(showUploadToStudioModal, 300);"
                    style="flex: 1; background: var(--secondary); color: white; border: none;
                           padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                <i class="fas fa-plus" style="margin-left: 8px;"></i>
                رفع صور جديدة
            </button>
            <button onclick="closeStudioModal()"
                    style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb;
                           padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                إغلاق
            </button>
        </div>
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(modal);
}

// تنسيق وقت الرفع
function formatUploadTime(isoString) {
    const date = new Date(isoString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);

    if (diffMins < 1) return 'الآن';
    if (diffMins < 60) return `منذ ${diffMins} دقيقة`;
    if (diffHours < 24) return `منذ ${diffHours} ساعة`;

    return date.toLocaleDateString('ar-SA') + ' ' + date.toLocaleTimeString('ar-SA', {hour: '2-digit', minute: '2-digit'});
}

// عرض صورة الاستديو
function openStudioImageViewer(url, name) {
    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.style.zIndex = '2000';
    overlay.onclick = function() { this.remove(); document.querySelector('.studio-image-viewer')?.remove(); };

    const viewer = document.createElement('div');
    viewer.className = 'studio-image-viewer';
    viewer.style.cssText = `
        position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
        z-index: 2001; background: white; padding: 20px; border-radius: 16px;
        max-width: 90%; max-height: 90vh; text-align: center;
    `;
    viewer.onclick = function(e) { e.stopPropagation(); };

    viewer.innerHTML = `
        <button onclick="this.parentElement.remove(); document.querySelector('.alert-overlay[style*=\\'z-index: 2000\\']')?.remove();"
                style="position: absolute; top: 10px; left: 10px; background: var(--gray-100);
                       border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
        <img src="${url}" alt="${name}" style="max-width: 100%; max-height: 70vh; border-radius: 8px;">
        <div style="margin-top: 12px; font-size: 14px; color: var(--dark);">${name}</div>
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(viewer);
}

// نقل صورة لاستديو المحذوفات
function moveToDeletedStudio(imageId) {
    if (!confirm('هل تريد نقل هذه الصورة إلى استديو المحذوفات؟')) return;

    const studio = getCurrentStudio();
    const index = studio.findIndex(img => img.id === imageId);
    if (index > -1) {
        const image = studio[index];
        image.deletedTime = new Date().toISOString();
        image.deletedFromCourse = currentCourseFilter;

        // نقل للمحذوفات
        const deletedStudio = getDeletedStudio();
        deletedStudio.push(image);
        saveDeletedStudio(deletedStudio);

        // حذف من الاستديو الحالي
        studio.splice(index, 1);
        saveCurrentStudio(studio);

        showToast('تم نقل الصورة للمحذوفات', 'success');

        // تحديث العرض
        closeStudioModal();
        setTimeout(showPhotoStudio, 300);
    }
}

// استعادة صورة من المحذوفات
function restoreFromDeletedStudio(imageId) {
    const deletedStudio = getDeletedStudio();
    const index = deletedStudio.findIndex(img => img.id === imageId);

    if (index > -1) {
        const image = deletedStudio[index];
        const targetCourse = image.deletedFromCourse || 'all';

        // إزالة بيانات الحذف
        delete image.deletedTime;
        delete image.deletedFromCourse;

        // استعادة للاستديو الأصلي
        const targetKey = getStudioKey(targetCourse);
        const targetStudio = JSON.parse(localStorage.getItem(targetKey) || '[]');
        targetStudio.push(image);
        localStorage.setItem(targetKey, JSON.stringify(targetStudio));

        // حذف من المحذوفات
        deletedStudio.splice(index, 1);
        saveDeletedStudio(deletedStudio);

        showToast('تم استعادة الصورة بنجاح', 'success');

        // تحديث العرض
        closeDeletedStudioModal();
        setTimeout(showDeletedPhotosStudio, 300);
        updateStudioBadge();
    }
}

// حذف صورة نهائياً من المحذوفات
function permanentlyDeleteImage(imageId) {
    if (!confirm('هل تريد حذف هذه الصورة نهائياً؟ لا يمكن التراجع!')) return;

    const deletedStudio = getDeletedStudio();
    const index = deletedStudio.findIndex(img => img.id === imageId);

    if (index > -1) {
        deletedStudio.splice(index, 1);
        saveDeletedStudio(deletedStudio);

        showToast('تم حذف الصورة نهائياً', 'success');

        closeDeletedStudioModal();
        setTimeout(showDeletedPhotosStudio, 300);
    }
}

// عرض استديو الصور المحذوفة
function showDeletedPhotosStudio() {
    const deletedStudio = getDeletedStudio();

    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = closeDeletedStudioModal;

    const modal = document.createElement('div');
    modal.className = 'studio-modal images-alert';
    modal.id = 'deletedStudioModal';
    modal.style.maxWidth = '500px';
    modal.onclick = function(e) { e.stopPropagation(); };

    modal.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-trash-restore" style="color: var(--danger);"></i>
                استديو الصور المحذوفة
                <span style="background: var(--danger); color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">
                    ${deletedStudio.length}
                </span>
            </h3>
            <button onclick="closeDeletedStudioModal()"
                    style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="background: rgba(239, 68, 68, 0.05); padding: 12px; border-radius: var(--radius); margin-bottom: 16px;">
            <div style="font-size: 13px; color: var(--gray-dark); display: flex; align-items: start; gap: 8px;">
                <i class="fas fa-info-circle" style="color: var(--danger); margin-top: 2px;"></i>
                <span>الصور المحذوفة يمكن استعادتها أو حذفها نهائياً.</span>
            </div>
        </div>

        <div id="deletedImagesList" style="max-height: 350px; overflow-y: auto;">
            ${deletedStudio.length > 0 ? deletedStudio.map(img => {
                return `
                    <div class="studio-image-item" style="background: rgba(239, 68, 68, 0.03);
                              border: 1px solid rgba(239, 68, 68, 0.2);
                              border-radius: var(--radius); padding: 12px; margin-bottom: 12px;">
                        <div style="display: flex; gap: 12px;">
                            <div style="width: 70px; height: 70px; border-radius: 8px; overflow: hidden; flex-shrink: 0; opacity: 0.7;">
                                <img src="${img.url}" alt="${img.name}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="flex: 1; text-align: right;">
                                <div style="font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 4px;">
                                    ${img.name}
                                </div>
                                <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">
                                    <i class="fas fa-hdd" style="margin-left: 4px;"></i>${img.size}
                                </div>
                                <div style="font-size: 11px; color: var(--danger);">
                                    <i class="fas fa-trash" style="margin-left: 4px;"></i>
                                    حذف: ${formatUploadTime(img.deletedTime)}
                                </div>
                                <div style="font-size: 10px; color: var(--gray); margin-top: 2px;">
                                    <i class="fas fa-book" style="margin-left: 4px;"></i>
                                    من: ${getCourseName(img.deletedFromCourse)}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 8px; margin-top: 12px;">
                            <button onclick="restoreFromDeletedStudio(${img.id})"
                                    style="flex: 1; background: var(--secondary); color: white; border: none;
                                           padding: 10px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-undo" style="margin-left: 6px;"></i>
                                استعادة
                            </button>
                            <button onclick="permanentlyDeleteImage(${img.id})"
                                    style="background: var(--danger); color: white; border: none;
                                           padding: 10px 14px; border-radius: 8px; cursor: pointer;"
                                    title="حذف نهائي">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
            }).join('') : `
                <div style="text-align: center; padding: 40px 20px;">
                    <div style="width: 80px; height: 80px; background: var(--gray-100);
                              border-radius: 50%; display: flex; align-items: center;
                              justify-content: center; margin: 0 auto 16px;">
                        <i class="fas fa-trash-restore" style="font-size: 32px; color: var(--gray);"></i>
                    </div>
                    <div style="font-size: 16px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        لا توجد صور محذوفة
                    </div>
                    <div style="font-size: 14px; color: var(--gray);">
                        الصور المحذوفة ستظهر هنا
                    </div>
                </div>
            `}
        </div>

        ${deletedStudio.length > 0 ? `
            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <button onclick="emptyDeletedStudio()"
                        style="flex: 1; background: var(--danger); color: white; border: none;
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-trash" style="margin-left: 8px;"></i>
                    إفراغ المحذوفات
                </button>
                <button onclick="closeDeletedStudioModal()"
                        style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb;
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    إغلاق
                </button>
            </div>
        ` : `
            <div style="margin-top: 20px;">
                <button onclick="closeDeletedStudioModal()"
                        style="width: 100%; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb;
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    إغلاق
                </button>
            </div>
        `}
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(modal);
}

// إفراغ استديو المحذوفات
function emptyDeletedStudio() {
    if (!confirm('هل تريد حذف جميع الصور المحذوفة نهائياً؟ لا يمكن التراجع!')) return;

    saveDeletedStudio([]);
    showToast('تم إفراغ استديو المحذوفات', 'success');

    closeDeletedStudioModal();
    setTimeout(showDeletedPhotosStudio, 300);
}

// إغلاق modal المحذوفات
function closeDeletedStudioModal() {
    const overlay = document.querySelector('.alert-overlay');
    const modal = document.getElementById('deletedStudioModal');

    if (modal) {
        modal.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => modal.remove(), 300);
    }

    if (overlay) {
        overlay.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => overlay.remove(), 300);
    }
}

// عرض modal توجيه الصورة للحالة
function showAssignImageModal(imageId) {
    const studio = getCurrentStudio();
    const image = studio.find(img => img.id === imageId);
    if (!image) return;

    closeStudioModal();

    setTimeout(() => {
        const overlay = document.createElement('div');
        overlay.className = 'alert-overlay';
        overlay.onclick = function() { closeAssignModal(); showPhotoStudio(); };

        const modal = document.createElement('div');
        modal.className = 'assign-modal images-alert';
        modal.id = 'assignImageModal';
        modal.onclick = function(e) { e.stopPropagation(); };

        modal.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 18px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-share" style="color: var(--primary);"></i>
                    توجيه الصورة إلى حالة
                </h3>
                <button onclick="closeAssignModal(); setTimeout(showPhotoStudio, 300);"
                        style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div style="display: flex; gap: 12px; margin-bottom: 20px; background: var(--gray-50); padding: 12px; border-radius: var(--radius);">
                <img src="${image.url}" alt="${image.name}"
                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                <div style="text-align: right;">
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark);">${image.name}</div>
                    <div style="font-size: 12px; color: var(--gray);">${image.size}</div>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-size: 14px; font-weight: 600; color: var(--dark); display: block; margin-bottom: 8px;">
                    <i class="fas fa-user" style="margin-left: 6px;"></i>
                    اختر الحالة
                </label>
                <select id="assignCaseSelect" style="width: 100%; padding: 12px; border: 2px solid var(--gray-200);
                        border-radius: var(--radius); font-size: 14px; font-family: inherit;">
                    <option value="">-- اختر حالة --</option>
                    ${casesData.map(c => `<option value="${c.id}">${c.patientName} (${c.recordNumber})</option>`).join('')}
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-size: 14px; font-weight: 600; color: var(--dark); display: block; margin-bottom: 8px;">
                    <i class="fas fa-list-ol" style="margin-left: 6px;"></i>
                    الخطوة (اختياري)
                </label>
                <select id="assignStepSelect" style="width: 100%; padding: 12px; border: 2px solid var(--gray-200);
                        border-radius: var(--radius); font-size: 14px; font-family: inherit;">
                    <option value="">-- بدون خطوة محددة --</option>
                    <option value="diagnosis">التشخيص</option>
                    <option value="treatment">العلاج</option>
                    <option value="followup">المتابعة</option>
                    <option value="results">النتائج</option>
                </select>
            </div>

            <div style="display: flex; gap: 12px;">
                <button onclick="assignImageToCase(${imageId})"
                        id="assignBtn"
                        style="flex: 1; background: var(--primary); color: white; border: none;
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-check" style="margin-left: 8px;"></i>
                    توجيه الصورة
                </button>
                <button onclick="closeAssignModal(); setTimeout(showPhotoStudio, 300);"
                        style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb;
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    إلغاء
                </button>
            </div>
        `;

        document.body.appendChild(overlay);
        document.body.appendChild(modal);
    }, 300);
}

// توجيه الصورة للحالة
function assignImageToCase(imageId) {
    const caseSelect = document.getElementById('assignCaseSelect');
    const stepSelect = document.getElementById('assignStepSelect');

    if (!caseSelect.value) {
        showToast('يرجى اختيار حالة', 'warning');
        return;
    }

    const caseId = parseInt(caseSelect.value);
    const step = stepSelect.value || null;
    const caseItem = casesData.find(c => c.id === caseId);
    const studio = getCurrentStudio();
    const image = studio.find(img => img.id === imageId);

    if (!caseItem || !image) return;

    // إضافة الصورة للحالة
    caseItem.images.push({
        id: imageId,
        name: image.name,
        size: image.size,
        url: image.url,
        step: step,
        assignedFrom: 'studio',
        assignedTime: new Date().toISOString(),
        fromCourse: currentCourseFilter
    });

    // تحديث حالة الصورة في الاستديو
    image.assignedTo = caseId;
    image.assignedStep = step;
    saveCurrentStudio(studio);

    // تحديث الجدول
    loadCasesTable();
    updateTotalImagesCount();

    showToast(`تم توجيه الصورة لحالة ${caseItem.patientName}`, 'success');
    closeAssignModal();
}

// إرجاع صورة من الحالة للاستديو
function returnImageToStudio(imageId, caseId) {
    if (!confirm('هل تريد إرجاع هذه الصورة للاستديو؟')) return;

    const caseItem = casesData.find(c => c.id === caseId);
    if (!caseItem) return;

    const imageIndex = caseItem.images.findIndex(img => img.id === imageId && img.assignedFrom === 'studio');
    if (imageIndex === -1) {
        showToast('لا يمكن إرجاع هذه الصورة', 'warning');
        return;
    }

    const removedImage = caseItem.images[imageIndex];
    const coursKey = removedImage.fromCourse || currentCourseFilter;

    // إرجاع الصورة للاستديو المناسب
    const targetKey = getStudioKey(coursKey);
    const targetStudio = JSON.parse(localStorage.getItem(targetKey) || '[]');
    const studioImage = targetStudio.find(img => img.id === imageId);

    if (studioImage) {
        studioImage.assignedTo = null;
        studioImage.assignedStep = null;
        localStorage.setItem(targetKey, JSON.stringify(targetStudio));
        updateStudioBadge();
    }

    // حذف الصورة من الحالة
    caseItem.images.splice(imageIndex, 1);

    loadCasesTable();
    updateTotalImagesCount();
    showToast('تم إرجاع الصورة للاستديو', 'success');

    // تحديث عرض صور الحالة إذا كان مفتوحاً
    closeImagesModal();
    setTimeout(() => showCaseImages(caseId), 300);
}

// إغلاق modals
function closeStudioModal() {
    const overlay = document.querySelector('.alert-overlay');
    const modals = document.querySelectorAll('.studio-modal, #photoStudioModal, #uploadStudioModal');

    modals.forEach(modal => {
        if (modal) {
            modal.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => modal.remove(), 300);
        }
    });

    if (overlay) {
        overlay.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => overlay.remove(), 300);
    }

    imagesToUpload.forEach(item => URL.revokeObjectURL(item.preview));
    imagesToUpload = [];
}

function closeAssignModal() {
    const overlay = document.querySelector('.alert-overlay');
    const modal = document.getElementById('assignImageModal');

    if (modal) {
        modal.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => modal.remove(), 300);
    }

    if (overlay) {
        overlay.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => overlay.remove(), 300);
    }
}

// تهيئة الصفحة
document.addEventListener('DOMContentLoaded', function() {
    loadCasesTable();
    initStatusFilterScroll();
    updateTotalImagesCount();
    initPhotoStudio(); // تهيئة استديو الصور
    
    // تفعيل البحث عند الضغط على Enter
    const searchInput = document.getElementById('casesSearch');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchCases();
            }
        });
    }
    
    // تحميل جدول الحالات عند فتح تبويب الفئات
    const categoriesTab = document.querySelector('.tab-item[onclick="switchTab(\'categories\')"]');
    if (categoriesTab) {
        categoriesTab.addEventListener('click', function() {
            setTimeout(() => {
                loadCasesTable();
                initStatusFilterScroll();
                updateTotalImagesCount();
            }, 100);
        });
    }
});

// تهيئة التمرير الأفقي لبطاقات حالة العرض
function initStatusFilterScroll() {
    const statusCards = document.querySelector('.status-filter-cards');
    const progressBar = document.querySelector('.status-filter-cards').nextElementSibling?.querySelector('.scroll-progress');
    
    if (statusCards && progressBar) {
        statusCards.addEventListener('scroll', function() {
            const scrollWidth = statusCards.scrollWidth - statusCards.clientWidth;
            const scrollLeft = statusCards.scrollLeft;
            const progress = scrollWidth > 0 ? (scrollLeft / scrollWidth) * 100 : 0;
            progressBar.style.width = progress + '%';
        });
    }
}

// تحميل جدول الحالات
function loadCasesTable() {
    const tableBody = document.getElementById('casesTableBody');
    if (!tableBody) return;
    
    // تصفية البيانات
    let filteredCases = casesData;
    
    if (currentStatusFilter !== 'all') {
        filteredCases = filteredCases.filter(caseItem => caseItem.status === currentStatusFilter);
    }
    
    if (currentCourseFilter !== 'all') {
        filteredCases = filteredCases.filter(caseItem => {
            const courseMap = {
                'cardiology': 'طب القلب السريري',
                'respiratory': 'أمراض الجهاز التنفسي',
                'neurology': 'طب الأعصاب السريري',
                'clinical': 'الفحص السريري المتقدم'
            };
            return caseItem.course === courseMap[currentCourseFilter];
        });
    }
    
    // تطبيق البحث
    const searchInput = document.getElementById('casesSearch');
    if (searchInput && searchInput.value.trim() !== '') {
        const searchTerm = searchInput.value.trim().toLowerCase();
        filteredCases = filteredCases.filter(caseItem => 
            caseItem.patientName.toLowerCase().includes(searchTerm) ||
            caseItem.recordNumber.toLowerCase().includes(searchTerm) ||
            caseItem.course.toLowerCase().includes(searchTerm) ||
            caseItem.caseType.toLowerCase().includes(searchTerm) ||
            caseItem.supervisor.name.toLowerCase().includes(searchTerm)
        );
    }
    
    // حساب الترقيم
    const startIndex = (currentPage - 1) * casesPerPage;
    const endIndex = startIndex + casesPerPage;
    const paginatedCases = filteredCases.slice(startIndex, endIndex);
    
    // بناء الجدول
    tableBody.innerHTML = '';
    
    if (paginatedCases.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="8" style="text-align: center; padding: 40px 20px;">
                    <div style="width: 60px; height: 60px; background: var(--gray-light); 
                              border-radius: 50%; display: flex; align-items: center; 
                              justify-content: center; margin: 0 auto 16px;">
                        <i class="fas fa-search" style="font-size: 24px; color: var(--gray);"></i>
                    </div>
                    <div style="font-size: 16px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        لا توجد حالات
                    </div>
                    <div style="font-size: 14px; color: var(--gray);">
                        لم يتم العثور على حالات تطابق معايير البحث
                    </div>
                </td>
            </tr>
        `;
        updateTableFooter(filteredCases.length);
        return;
    }
    
    paginatedCases.forEach(caseItem => {
        const row = document.createElement('tr');
        
        // إنشاء النجوم للتقييم
        const starsHtml = generateStarsHtml(caseItem.rating, caseItem.maxRating);
        
        // تحديد حالة الحالة
        const statusInfo = getStatusInfo(caseItem.status);
        
        row.innerHTML = `
            <td>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary), var(--accent)); 
                              border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                              color: white; font-weight: 600; font-size: 14px;">
                        ${caseItem.patientInitial}
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 14px; font-weight: 600; color: var(--dark);">${caseItem.patientName}</div>
                        <div style="font-size: 11px; color: var(--gray);">${caseItem.caseDetails.age}</div>
                    </div>
                </div>
            </td>
            <td>
                <div style="font-family: monospace; font-weight: 600; color: var(--primary);">
                    ${caseItem.recordNumber}
                </div>
            </td>
            <td>
                <div class="status-badge ${statusInfo.class}">
                    <i class="fas ${statusInfo.icon}" style="margin-left: 4px;"></i>
                    ${statusInfo.text}
                </div>
            </td>
            <td>
                <div style="font-size: 13px; font-weight: 600; color: var(--dark);">${caseItem.course}</div>
                <div style="font-size: 11px; color: var(--gray); margin-top: 2px;">${caseItem.caseType}</div>
            </td>
            <td>
                <div class="rating-stars">
                    ${starsHtml}
                </div>
                <div style="font-size: 11px; color: var(--gray); margin-top: 4px;">
                    ${caseItem.rating} من ${caseItem.maxRating}
                </div>
            </td>
            <td>
                <button class="qr-btn" onclick="event.stopPropagation(); showQRFloatingAlert(${caseItem.id})">
                    <i class="fas fa-qrcode"></i>
                </button>
            </td>
            <td>
                <button class="images-btn" onclick="event.stopPropagation(); showCaseImages(${caseItem.id})">
                    <i class="fas fa-images"></i>
                    ${caseItem.images.length > 0 ? `<span class="images-count">${caseItem.images.length}</span>` : ''}
                </button>
            </td>
            <td>
                <div class="supervisor">
                    <div class="supervisor-avatar">
                        ${caseItem.supervisor.initial}
                    </div>
                    <div class="supervisor-name">
                        ${caseItem.supervisor.name}
                    </div>
                </div>
            </td>
        `;
        
        // إضافة تأثير النقر على الصف
        row.style.cursor = 'pointer';
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.qr-btn') && !e.target.closest('.images-btn')) {
                viewCaseDetails(caseItem.id);
            }
        });
        
        tableBody.appendChild(row);
    });
    
    // تحديث واجهة المستخدم
    updateTableFooter(filteredCases.length);
    updateStatusFilterCards(filteredCases);
    updateCasesCount(filteredCases.length);
}

// تحديث عدد الصور الكلي
function updateTotalImagesCount() {
    const totalImages = casesData.reduce((total, caseItem) => total + caseItem.images.length, 0);
    const badge = document.getElementById('imagesCountBadge');
    if (badge) {
        badge.textContent = totalImages;
    }
}

// توليد HTML للنجوم
function generateStarsHtml(rating, maxRating) {
    let html = '';
    const fullStars = Math.floor(rating);
    
    for (let i = 1; i <= maxRating; i++) {
        if (i <= fullStars) {
            html += '<span class="star filled">★</span>';
        } else {
            html += '<span class="star">★</span>';
        }
    }
    
    return html;
}

// الحصول على معلومات الحالة
function getStatusInfo(status) {
    switch(status) {
        case 'completed':
            return {
                class: 'completed',
                text: 'مكتمل',
                icon: 'fa-check-circle'
            };
        case 'inProgress':
            return {
                class: 'in-progress',
                text: 'قيد الإنجاز',
                icon: 'fa-spinner'
            };
        case 'pending':
            return {
                class: 'pending',
                text: 'بانتظار الموافقة',
                icon: 'fa-clock'
            };
        case 'rejected':
            return {
                class: 'rejected',
                text: 'مرفوض',
                icon: 'fa-times-circle'
            };
        default:
            return {
                class: '',
                text: '',
                icon: ''
            };
    }
}

// تحديث تذييل الجدول
function updateTableFooter(totalCases) {
    const startCase = (currentPage - 1) * casesPerPage + 1;
    const endCase = Math.min(currentPage * casesPerPage, totalCases);
    
    // تحديث نص التذييل
    const footerText = document.getElementById('tableFooter');
    if (footerText) {
        footerText.innerHTML = `
            <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
            عرض ${startCase}-${endCase} من ${totalCases} حالة
        `;
    }
    
    // تفعيل/تعطيل أزرار التصفح
    const prevButton = document.getElementById('prevPageBtn');
    const nextButton = document.getElementById('nextPageBtn');
    
    if (prevButton) {
        prevButton.disabled = currentPage === 1;
        prevButton.style.opacity = currentPage === 1 ? '0.5' : '1';
        prevButton.style.cursor = currentPage === 1 ? 'not-allowed' : 'pointer';
    }
    
    if (nextButton) {
        const totalPages = Math.ceil(totalCases / casesPerPage);
        nextButton.disabled = currentPage >= totalPages;
        nextButton.style.opacity = currentPage >= totalPages ? '0.5' : '1';
        nextButton.style.cursor = currentPage >= totalPages ? 'not-allowed' : 'pointer';
    }
}

// تحديث بطاقات حالة العرض
function updateStatusFilterCards(filteredCases) {
    // حساب العدد الفعلي من كل البيانات (وليس المُصفاة)
    const allCases = casesData;
    const totalCases = allCases.length;
    const completedCount = allCases.filter(c => c.status === 'completed').length;
    const inProgressCount = allCases.filter(c => c.status === 'inProgress').length;
    const pendingCount = allCases.filter(c => c.status === 'pending').length;
    const rejectedCount = allCases.filter(c => c.status === 'rejected').length;

    // تحديث العدادات في البطاقات
    const statusCards = {
        'all': totalCases,
        'completed': completedCount,
        'inProgress': inProgressCount,
        'pending': pendingCount,
        'rejected': rejectedCount
    };

    for (const [status, count] of Object.entries(statusCards)) {
        const card = document.querySelector(`.status-filter-card[data-status="${status}"]`);
        if (card) {
            const countElement = card.querySelector('.status-count');
            if (countElement) {
                countElement.textContent = count;
            }
        }
    }
}

// تحديث عداد الحالات
function updateCasesCount(totalCases) {
    const casesCountElement = document.getElementById('casesCount');
    if (casesCountElement) {
        casesCountElement.textContent = `${totalCases} حالة`;
    }
}

// تصفية حسب الحالة
function handleStatusFilter(status) {
    // تحديث البطاقات النشطة
    document.querySelectorAll('.status-filter-card').forEach(card => {
        card.classList.remove('active');
    });

    const selectedCard = document.querySelector(`.status-filter-card[data-status="${status}"]`);
    if (selectedCard) {
        selectedCard.classList.add('active');
    }

    // تطبيق التصفية
    currentStatusFilter = status;
    currentPage = 1;
    loadCasesTable();
}

// اختيار المقرر
function selectOption(dropdownId, value, label) {
    const dropdown = document.getElementById(dropdownId);
    const header = dropdown.querySelector('.dropdown-header span:first-child');
    header.textContent = label;
    
    dropdown.querySelectorAll('.dropdown-option').forEach(option => {
        option.classList.remove('selected');
        if (option.getAttribute('data-value') === value) {
            option.classList.add('selected');
        }
    });
    
    closeAllDropdowns();
    
    // تطبيق التصفية
    if (dropdownId === 'courseDropdown') {
        currentCourseFilter = value;
        currentPage = 1;
        loadCasesTable();
        // تحديث badge الاستديو للمقرر الجديد
        updateStudioBadge();
    }
}

// البحث
function searchCases() {
    currentPage = 1;
    loadCasesTable();
    
    const searchInput = document.getElementById('casesSearch');
    if (searchInput && searchInput.value.trim() !== '') {
        showToast(`تم البحث عن: "${searchInput.value}"`);
    }
}

// التصفح بين الصفحات
function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        loadCasesTable();
    }
}

function nextPage() {
    const totalCases = casesData.length;
    const totalPages = Math.ceil(totalCases / casesPerPage);
    
    if (currentPage < totalPages) {
        currentPage++;
        loadCasesTable();
    }
}

// عرض صور الحالة
function showCaseImages(caseId) {
    selectedCaseId = caseId;
    const caseItem = casesData.find(c => c.id === caseId);
    if (!caseItem) return;
    
    currentImages = caseItem.images;
    
    // إنشاء التنبيه العائم
    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = closeImagesModal;
    
    const alert = document.createElement('div');
    alert.className = 'view-images-alert images-alert';
    alert.onclick = function(e) {
        e.stopPropagation(); // منع إغلاق عند النقر داخل التنبيه
    };
    
    alert.innerHTML = `
        <div class="view-images-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 18px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-images" style="color: var(--accent);"></i>
                    صور الحالة: ${caseItem.patientName}
                </h3>
                <button onclick="closeImagesModal()" 
                        style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div style="text-align: right; margin-bottom: 16px;">
                <div style="font-size: 14px; color: var(--gray);">
                    <i class="fas fa-hashtag" style="margin-left: 6px;"></i>
                    رقم السجل: ${caseItem.recordNumber}
                </div>
                <div style="font-size: 14px; color: var(--gray);">
                    <i class="fas fa-tag" style="margin-left: 6px;"></i>
                    نوع الحالة: ${caseItem.caseType}
                </div>
            </div>
            
            ${currentImages.length > 0 ? `
                <div class="images-grid" id="imagesGrid">
                    ${generateImagesGrid(currentImages)}
                </div>
            ` : `
                <div style="text-align: center; padding: 40px 20px;">
                    <div style="width: 80px; height: 80px; background: var(--gray-light); 
                              border-radius: 50%; display: flex; align-items: center; 
                              justify-content: center; margin: 0 auto 16px;">
                        <i class="fas fa-images" style="font-size: 32px; color: var(--gray);"></i>
                    </div>
                    <div style="font-size: 16px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        لا توجد صور
                    </div>
                    <div style="font-size: 14px; color: var(--gray);">
                        لم يتم رفع أي صور لهذه الحالة بعد
                    </div>
                </div>
            `}
            
            <div style="background: rgba(79, 70, 229, 0.05); padding: 10px; border-radius: var(--radius);
                      margin-top: 16px; margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--primary); display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-info-circle"></i>
                    <span>لإضافة صور، ارفعها أولاً للاستديو ثم وجّهها لهذه الحالة.</span>
                </div>
            </div>

            <div style="display: flex; gap: 12px;">
                <button onclick="closeImagesModal(); setTimeout(showPhotoStudio, 300);"
                        style="flex: 1; background: var(--secondary); color: white; border: none;
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-images" style="margin-left: 8px;"></i>
                    فتح الاستديو
                </button>
                <button onclick="closeImagesModal()"
                        style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb;
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    إغلاق
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(alert);
}

// توليد شبكة الصور
function generateImagesGrid(images) {
    return images.map((image, index) => `
        <div class="image-item" style="position: relative; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <!-- شارة الخطوة -->
            ${image.step ? `
                <div style="position: absolute; top: 8px; left: 8px; background: var(--primary); color: white;
                          padding: 4px 10px; border-radius: 8px; font-size: 11px; z-index: 5; font-weight: 600;">
                    <i class="fas fa-list-ol" style="margin-left: 4px;"></i>
                    ${getStepName(image.step)}
                </div>
            ` : ''}
            <!-- شارة الاستديو -->
            ${image.assignedFrom === 'studio' ? `
                <div style="position: absolute; top: 8px; right: 8px; background: var(--accent); color: white;
                          padding: 4px 8px; border-radius: 8px; font-size: 10px; z-index: 5;">
                    <i class="fas fa-images" style="margin-left: 4px;"></i>
                    استديو
                </div>
            ` : ''}
            <!-- الصورة -->
            <div style="height: 140px; overflow: hidden; cursor: pointer;" onclick="openImageViewer(${index})">
                <img src="${image.url}" alt="${image.name}"
                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;"
                     onmouseover="this.style.transform='scale(1.05)'"
                     onmouseout="this.style.transform='scale(1)'">
            </div>
            <!-- معلومات الصورة -->
            <div style="padding: 10px;">
                <div style="font-size: 12px; font-weight: 600; color: var(--dark); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    ${image.name}
                </div>
                <div style="font-size: 11px; color: var(--gray); margin-bottom: 8px;">
                    ${image.size}
                </div>
                <!-- أزرار التحكم -->
                <div style="display: flex; gap: 6px;">
                    <button onclick="openImageViewer(${index})"
                            style="flex: 1; background: var(--primary); color: white; border: none;
                                   padding: 8px; border-radius: 6px; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;">
                        <i class="fas fa-expand"></i>
                        عرض
                    </button>
                    ${image.assignedFrom === 'studio' ? `
                        <button onclick="returnImageToStudio(${image.id}, ${selectedCaseId})"
                                style="flex: 1; background: var(--warning); color: white; border: none;
                                       padding: 8px; border-radius: 6px; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;">
                            <i class="fas fa-undo"></i>
                            إرجاع
                        </button>
                    ` : `
                        <button onclick="deleteImage(${image.id}, ${selectedCaseId})"
                                style="flex: 1; background: var(--danger); color: white; border: none;
                                       padding: 8px; border-radius: 6px; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;">
                            <i class="fas fa-trash"></i>
                            حذف
                        </button>
                    `}
                </div>
            </div>
        </div>
    `).join('');
}

// الحصول على اسم الخطوة
function getStepName(step) {
    const steps = {
        'diagnosis': 'التشخيص',
        'treatment': 'العلاج',
        'followup': 'المتابعة',
        'results': 'النتائج'
    };
    return steps[step] || step;
}

// حذف صورة
function deleteImage(imageId, caseId) {
    if (!confirm('هل أنت متأكد من حذف هذه الصورة؟')) return;
    
    const caseItem = casesData.find(c => c.id === caseId);
    if (caseItem) {
        const imageIndex = caseItem.images.findIndex(img => img.id === imageId);
        if (imageIndex > -1) {
            caseItem.images.splice(imageIndex, 1);
            showToast('تم حذف الصورة بنجاح', 'success');
            updateTotalImagesCount();
            
            // تحديث العرض إذا كان مفتوحاً
            const alert = document.querySelector('.view-images-alert');
            if (alert) {
                const imagesGrid = document.getElementById('imagesGrid');
                if (imagesGrid) {
                    imagesGrid.innerHTML = caseItem.images.length > 0 
                        ? generateImagesGrid(caseItem.images)
                        : '<div style="grid-column: 1/-1; text-align: center; padding: 40px;">لا توجد صور</div>';
                }
            }
            
            // تحديث الجدول
            loadCasesTable();
        }
    }
}

// فتح مشغل الصور
function openImageViewer(index) {
    currentImageViewerIndex = index;
    
    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = closeImageViewer;
    
    const viewer = document.createElement('div');
    viewer.className = 'image-viewer';
    viewer.onclick = function(e) {
        e.stopPropagation();
    };
    
    viewer.innerHTML = `
        <button class="viewer-close" onclick="closeImageViewer()">
            <i class="fas fa-times"></i>
        </button>
        
        <button class="viewer-nav prev" onclick="prevImage()">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <button class="viewer-nav next" onclick="nextImage()">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <img src="${currentImages[currentImageViewerIndex].url}" 
             alt="${currentImages[currentImageViewerIndex].name}" 
             class="viewer-image">
        
        <div class="viewer-info">
            <div style="font-size: 16px; font-weight: 600;">${currentImages[currentImageViewerIndex].name}</div>
            <div style="font-size: 14px; margin-top: 4px;">${currentImages[currentImageViewerIndex].size}</div>
            <div style="font-size: 14px; margin-top: 4px;">${currentImageViewerIndex + 1} من ${currentImages.length}</div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.appendChild(viewer);
}

// الصورة السابقة
function prevImage() {
    if (currentImages.length === 0) return;
    currentImageViewerIndex = (currentImageViewerIndex - 1 + currentImages.length) % currentImages.length;
    updateImageViewer();
}

// الصورة التالية
function nextImage() {
    if (currentImages.length === 0) return;
    currentImageViewerIndex = (currentImageViewerIndex + 1) % currentImages.length;
    updateImageViewer();
}

// تحديث مشغل الصور
function updateImageViewer() {
    const viewer = document.querySelector('.image-viewer');
    if (viewer) {
        viewer.querySelector('.viewer-image').src = currentImages[currentImageViewerIndex].url;
        viewer.querySelector('.viewer-image').alt = currentImages[currentImageViewerIndex].name;
        viewer.querySelector('.viewer-info div:nth-child(1)').textContent = currentImages[currentImageViewerIndex].name;
        viewer.querySelector('.viewer-info div:nth-child(2)').textContent = currentImages[currentImageViewerIndex].size;
        viewer.querySelector('.viewer-info div:nth-child(3)').textContent = `${currentImageViewerIndex + 1} من ${currentImages.length}`;
    }
}

// إغلاق مشغل الصور
function closeImageViewer() {
    const overlay = document.querySelector('.alert-overlay');
    const viewer = document.querySelector('.image-viewer');
    
    if (viewer) viewer.remove();
    if (overlay) overlay.remove();
}

// عرض نموذج رفع الصور - يوجه للاستديو
function showUploadImagesModal() {
    showUploadToStudioModal();
}

function showUploadImagesModalForCase(caseId) {
    // لم يعد يمكن الرفع مباشرة للحالة - يجب المرور عبر الاستديو
    showToast('يرجى رفع الصور للاستديو أولاً ثم توجيهها للحالة', 'warning');
    showUploadToStudioModal();
    return;
    // الكود القديم (معطل):
    selectedCaseId = caseId;
    imagesToUpload = [];
    
    // إغلاق أي تنبيهات مفتوحة
    closeImagesModal();
    
    const caseItem = caseId ? casesData.find(c => c.id === caseId) : null;
    
    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = closeImagesModal;
    
    const alert = document.createElement('div');
    alert.className = 'upload-images-alert images-alert';
    alert.onclick = function(e) {
        e.stopPropagation(); // منع إغلاق عند النقر داخل التنبيه
    };
    
    alert.innerHTML = `
        <div class="upload-images-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 18px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-cloud-upload-alt" style="color: var(--secondary);"></i>
                    ${caseItem ? `رفع صور للحالة: ${caseItem.patientName}` : 'رفع صور جديدة'}
                </h3>
                <button onclick="closeImagesModal()" 
                        style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            ${caseItem ? `
                <div style="text-align: right; margin-bottom: 16px; background: rgba(16, 185, 129, 0.05); 
                          padding: 12px; border-radius: var(--radius);">
                    <div style="font-size: 14px; color: var(--dark);">
                        <i class="fas fa-user" style="margin-left: 6px;"></i>
                        المريض: ${caseItem.patientName}
                    </div>
                    <div style="font-size: 14px; color: var(--gray); margin-top: 4px;">
                        <i class="fas fa-hashtag" style="margin-left: 6px;"></i>
                        رقم السجل: ${caseItem.recordNumber}
                    </div>
                </div>
            ` : ''}
            
            <div class="upload-container">
                <div class="upload-area" id="uploadArea" 
                     ondragover="handleDragOver(event)" 
                     ondragleave="handleDragLeave(event)" 
                     ondrop="handleDrop(event)">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div style="font-size: 16px; font-weight: 600; color: var(--dark);">
                        اسحب وأفلت الصور هنا
                    </div>
                    <div class="upload-hint">أو</div>
                    <input type="file" id="fileInput" multiple accept="image/*" 
                           style="display: none;" onchange="handleFileSelect(event)">
                    <button onclick="document.getElementById('fileInput').click()" 
                            style="background: var(--secondary); color: white; border: none; 
                                   padding: 10px 24px; border-radius: var(--radius-sm); 
                                   font-weight: 600; cursor: pointer; margin-top: 12px;">
                        <i class="fas fa-folder-open" style="margin-left: 8px;"></i>
                        اختر ملفات
                    </button>
                    <div class="file-types">
                        يدعم: JPG, PNG, GIF (حتى 10MB لكل صورة)
                    </div>
                </div>
                
                <div class="file-preview" id="filePreview" style="display: none;">
                    <h4 style="text-align: right; margin-bottom: 12px; color: var(--dark);">
                        <i class="fas fa-list" style="margin-left: 6px;"></i>
                        الملفات المختارة (${imagesToUpload.length})
                    </h4>
                    <div id="previewList"></div>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button onclick="uploadImages()" 
                        id="uploadBtn"
                        style="flex: 1; background: var(--secondary); color: white; border: none; 
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; 
                               cursor: pointer; opacity: 0.5;" disabled>
                    <i class="fas fa-upload" style="margin-left: 8px;"></i>
                    رفع الصور
                </button>
                <button onclick="closeImagesModal()" 
                        style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb; 
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    إلغاء
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.appendChild(alert);
}

// معالجة سحب وإفلات الملفات
function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    const uploadArea = document.getElementById('uploadArea');
    if (uploadArea) {
        uploadArea.classList.add('dragover');
    }
}

function handleDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    const uploadArea = document.getElementById('uploadArea');
    if (uploadArea) {
        uploadArea.classList.remove('dragover');
    }
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    const uploadArea = document.getElementById('uploadArea');
    if (uploadArea) {
        uploadArea.classList.remove('dragover');
    }
    
    const files = e.dataTransfer.files;
    handleFiles(files);
}

// معالجة اختيار الملفات
function handleFileSelect(e) {
    const files = e.target.files;
    handleFiles(files);
}

// معالجة الملفات
function handleFiles(files) {
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        
        // التحقق من نوع الملف
        if (!file.type.startsWith('image/')) {
            showToast(`الملف "${file.name}" ليس صورة`, 'warning');
            continue;
        }
        
        // التحقق من حجم الملف (10MB كحد أقصى)
        if (file.size > 10 * 1024 * 1024) {
            showToast(`الملف "${file.name}" أكبر من 10MB`, 'warning');
            continue;
        }
        
        // إضافة الملف إلى القائمة
        imagesToUpload.push({
            id: Date.now() + i,
            file: file,
            name: file.name,
            size: formatFileSize(file.size),
            preview: URL.createObjectURL(file)
        });
    }
    
    updateFilePreview();
    toggleUploadButton();
}

// تحديث معاينة الملفات
function updateFilePreview() {
    const previewContainer = document.getElementById('filePreview');
    const previewList = document.getElementById('previewList');
    
    if (!previewContainer || !previewList) return;
    
    if (imagesToUpload.length === 0) {
        previewContainer.style.display = 'none';
        return;
    }
previewContainer.style.display = 'block';
    
    previewList.innerHTML = imagesToUpload.map(item => `
        <div class="preview-item">
            <div class="preview-info">
                <div class="file-icon">
                    <i class="fas fa-image"></i>
                </div>
                <div style="text-align: right; flex: 1;">
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark);">${item.name}</div>
                    <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">${item.size}</div>
                </div>
            </div>
            <button class="delete-btn" onclick="removeFile(${item.id})">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');
}

// إزالة ملف من القائمة
function removeFile(fileId) {
    const index = imagesToUpload.findIndex(item => item.id === fileId);
    if (index > -1) {
        // تحرير عناوين URL المؤقتة
        URL.revokeObjectURL(imagesToUpload[index].preview);
        imagesToUpload.splice(index, 1);
        updateFilePreview();
        toggleUploadButton();
    }
}

// تبديل حالة زر الرفع
function toggleUploadButton() {
    const uploadBtn = document.getElementById('uploadBtn');
    if (uploadBtn) {
        uploadBtn.disabled = imagesToUpload.length === 0;
        uploadBtn.style.opacity = imagesToUpload.length === 0 ? '0.5' : '1';
    }
}

// تنسيق حجم الملف
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// رفع الصور
function uploadImages() {
    if (imagesToUpload.length === 0) return;
    
    const uploadBtn = document.getElementById('uploadBtn');
    if (uploadBtn) {
        uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-left: 8px;"></i> جاري الرفع...';
        uploadBtn.disabled = true;
    }
    
    // محاكاة رفع الملفات (في تطبيق حقيقي، هنا ستكون استدعاء API)
    setTimeout(() => {
        // إضافة الصور إلى الحالة المختارة
        if (selectedCaseId) {
            const caseItem = casesData.find(c => c.id === selectedCaseId);
            if (caseItem) {
                imagesToUpload.forEach(item => {
                    caseItem.images.push({
                        id: Date.now() + Math.random(),
                        name: item.name,
                        size: item.size,
                        url: item.preview
                    });
                });
                
                showToast(`تم رفع ${imagesToUpload.length} صورة بنجاح`, 'success');
                updateTotalImagesCount();
                loadCasesTable();
                
                // إعادة فتح عرض الصور
                closeImagesModal();
                setTimeout(() => {
                    showCaseImages(selectedCaseId);
                }, 300);
            }
        } else {
            showToast(`تم رفع ${imagesToUpload.length} صورة بنجاح`, 'success');
            closeImagesModal();
        }
        
        // تنظيف الملفات المؤقتة
        imagesToUpload.forEach(item => {
            URL.revokeObjectURL(item.preview);
        });
        imagesToUpload = [];
        
    }, 1500);
}

// إغلاق نافذة الصور
function closeImagesModal() {
    const overlay = document.querySelector('.alert-overlay');
    const alerts = document.querySelectorAll('.upload-images-alert, .view-images-alert');
    
    alerts.forEach(alert => {
        if (alert) {
            alert.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => alert.remove(), 300);
        }
    });
    
    if (overlay) {
        overlay.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => overlay.remove(), 300);
    }
    
    // تنظيف الملفات المؤقتة
    imagesToUpload.forEach(item => {
        URL.revokeObjectURL(item.preview);
    });
    imagesToUpload = [];
}

// عرض تنبيه QR عائم
function showQRFloatingAlert(caseId) {
    const caseItem = casesData.find(c => c.id === caseId);
    if (!caseItem) return;
    
    const statusInfo = getStatusInfo(caseItem.status);
    
    // إنشاء الـ QR Code الافتراضي
    const qrPattern = generateQRPattern(caseItem.qrCode);
    
    // إنشاء التنبيه العائم
    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = closeQRFloatingAlert;
    
    const alert = document.createElement('div');
    alert.className = 'qr-floating-alert';
    alert.onclick = function(e) {
        e.stopPropagation(); // منع إغلاق عند النقر داخل التنبيه
    };
    
    alert.innerHTML = `
        <div class="qr-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 18px; color: var(--dark);">رمز QR للحالة</h3>
                <button onclick="closeQRFloatingAlert()" 
                        style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="qr-display">
                <div style="font-family: monospace; font-size: 24px; font-weight: 700; color: var(--primary); margin-bottom: 10px;">
                    ${qrPattern}
                </div>
                <div class="qr-code">${caseItem.qrCode}</div>
                <div class="qr-text">رمز QR للحالة</div>
            </div>
            
            <div class="patient-info">
                <div class="info-row">
                    <span class="info-label">اسم المريض:</span>
                    <span class="info-value">${caseItem.patientName}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">رقم السجل:</span>
                    <span class="info-value record">${caseItem.recordNumber}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">نوع الحالة:</span>
                    <span class="info-value">${caseItem.caseType}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">المشرف:</span>
                    <span class="info-value">${caseItem.supervisor.name}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">الحالة:</span>
                    <span style="background: ${getStatusColor(caseItem.status)}20; color: ${getStatusColor(caseItem.status)}; 
                          padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                        <i class="fas ${statusInfo.icon}" style="margin-left: 4px;"></i>
                        ${statusInfo.text}
                    </span>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button onclick="downloadQR('${caseItem.qrCode}', '${caseItem.patientName}')" 
                        style="flex: 1; background: var(--primary); color: white; border: none; 
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-download" style="margin-left: 8px;"></i>
                    تحميل
                </button>
                <button onclick="shareQR('${caseItem.qrCode}', '${caseItem.patientName}')" 
                        style="flex: 1; background: white; color: var(--primary); border: 1.5px solid var(--primary); 
                               padding: 12px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-share-alt" style="margin-left: 8px;"></i>
                    مشاركة
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.appendChild(alert);
}

// إغلاق تنبيه QR
function closeQRFloatingAlert() {
    const overlay = document.querySelector('.alert-overlay');
    const alert = document.querySelector('.qr-floating-alert');
    
    if (alert) {
        alert.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => alert.remove(), 300);
    }
    
    if (overlay) {
        overlay.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => overlay.remove(), 300);
    }
}

// توليد نمط QR افتراضي
function generateQRPattern(code) {
    // نمط بسيط لتمثيل QR Code
    const patterns = ['■□■□■', '□■□■□', '■□■□■', '□■□■□', '■□■□■'];
    return patterns.join('<br>');
}

// الحصول على لون الحالة
function getStatusColor(status) {
    switch(status) {
        case 'completed': return 'var(--secondary)';
        case 'inProgress': return 'var(--warning)';
        case 'pending': return 'var(--accent)';
        case 'rejected': return 'var(--danger)';
        default: return 'var(--gray)';
    }
}

// تحميل QR Code
function downloadQR(qrCode, patientName) {
    showToast(`جاري تحميل QR Code لـ ${patientName}`, 'info');
    
    setTimeout(() => {
        showToast(`تم تحميل QR Code بنجاح`, 'success');
        closeQRFloatingAlert();
    }, 1500);
}

// مشاركة QR Code
function shareQR(qrCode, patientName) {
    if (navigator.share) {
        navigator.share({
            title: 'رمز QR للحالة الطبية',
            text: `رمز QR لحالة ${patientName}: ${qrCode}`,
            url: window.location.href
        }).then(() => {
            showToast('تمت المشاركة بنجاح', 'success');
        }).catch(error => {
            console.log('Error sharing:', error);
            copyToClipboard(qrCode);
        });
    } else {
        copyToClipboard(qrCode);
    }
}

// نسخ إلى الحافظة
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('تم نسخ رمز QR إلى الحافظة', 'success');
    }).catch(err => {
        console.error('Failed to copy:', err);
        showToast('فشل نسخ الرمز', 'warning');
    });
}

// تصدير الحالات
function exportCases() {
    showToast('جاري تصدير بيانات الحالات...', 'info');

    setTimeout(() => {
        showToast('تم تصدير البيانات بنجاح', 'success');
    }, 1500);
}

// ========== دوال المرضى ==========
let currentPatientFilter = 'private';

// بيانات المرضى التجريبية
const patientsData = [
    { id: 1, name: 'أحمد محمد علي', record: 'MED-2024-001', age: 45, type: 'private', specialty: 'قلبية', date: '15/01/2024', initial: 'أ', color: 'primary' },
    { id: 2, name: 'سارة أحمد الخالد', record: 'MED-2024-002', age: 32, type: 'public', specialty: 'تنفسية', date: '20/01/2024', initial: 'س', color: 'secondary' },
    { id: 3, name: 'محمود خالد العمري', record: 'MED-2024-003', age: 58, type: 'private', specialty: 'عصبية', date: '22/01/2024', initial: 'م', color: 'accent' },
    { id: 4, name: 'فاطمة علي حسن', record: 'MED-2024-004', age: 28, type: 'public', specialty: 'باطنية', date: '25/01/2024', initial: 'ف', color: 'warning' },
    { id: 5, name: 'خالد يوسف أحمد', record: 'MED-2024-005', age: 52, type: 'private', specialty: 'قلبية', date: '28/01/2024', initial: 'خ', color: 'danger' },
    { id: 6, name: 'نور محمد سالم', record: 'MED-2024-006', age: 35, type: 'public', specialty: 'جلدية', date: '30/01/2024', initial: 'ن', color: 'primary' }
];

// تصفية المرضى
function filterPatients(type) {
    currentPatientFilter = type;

    // تحديث البطاقات
    document.querySelectorAll('.patient-filter-card').forEach(card => {
        if (card.dataset.filter === type) {
            card.style.background = type === 'private' ?
                'linear-gradient(135deg, var(--primary), #6366f1)' :
                'linear-gradient(135deg, var(--secondary), #34d399)';
            card.style.color = 'white';
            card.style.border = 'none';
            card.style.boxShadow = type === 'private' ?
                '0 4px 15px rgba(79, 70, 229, 0.3)' :
                '0 4px 15px rgba(16, 185, 129, 0.3)';
        } else {
            card.style.background = 'white';
            card.style.color = 'var(--dark)';
            card.style.border = '2px solid #e5e7eb';
            card.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
        }
    });

    // تصفية القائمة
    const filtered = patientsData.filter(p => p.type === type);
    renderPatientsList(filtered);
}

// عرض قائمة المرضى
function renderPatientsList(patients) {
    const container = document.getElementById('patientsList');
    if (!container) return;

    const colorGradients = {
        'primary': 'linear-gradient(135deg, var(--primary), #6366f1)',
        'secondary': 'linear-gradient(135deg, var(--secondary), #34d399)',
        'accent': 'linear-gradient(135deg, var(--accent), #f472b6)',
        'warning': 'linear-gradient(135deg, var(--warning), #fbbf24)',
        'danger': 'linear-gradient(135deg, var(--danger), #f87171)'
    };

    container.innerHTML = patients.map(p => `
        <div class="patient-card" style="background: white; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f3f4f6;">
            <div style="display: flex; gap: 12px;">
                <div style="width: 56px; height: 56px; background: ${colorGradients[p.color]}; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                    ${p.initial}
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${p.name}</div>
                            <div style="font-size: 12px; color: var(--gray); margin-top: 2px;">
                                <i class="fas fa-hashtag" style="margin-left: 4px;"></i>${p.record}
                            </div>
                        </div>
                        <span style="background: ${p.type === 'private' ? 'rgba(79, 70, 229, 0.1)' : 'rgba(16, 185, 129, 0.1)'};
                                     color: ${p.type === 'private' ? 'var(--primary)' : 'var(--secondary)'};
                                     padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 600;">
                            <i class="fas ${p.type === 'private' ? 'fa-user-shield' : 'fa-users'}" style="margin-left: 4px;"></i>
                            ${p.type === 'private' ? 'خاص' : 'عام'}
                        </span>
                    </div>
                    <div style="display: flex; gap: 16px; margin-top: 10px; font-size: 12px; color: var(--gray);">
                        <span><i class="fas fa-birthday-cake" style="margin-left: 4px; color: var(--accent);"></i>${p.age} سنة</span>
                        <span><i class="fas fa-stethoscope" style="margin-left: 4px; color: var(--secondary);"></i>${p.specialty}</span>
                        <span><i class="fas fa-calendar" style="margin-left: 4px; color: var(--warning);"></i>${p.date}</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f3f4f6;">
                <button onclick="viewPatientDetails(${p.id})" style="flex: 1; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fas fa-eye"></i>
                    عرض التفاصيل
                </button>
                <button onclick="editPatient(${p.id})" style="background: rgba(79, 70, 229, 0.1); color: var(--primary); border: none; padding: 10px 16px; border-radius: 10px; cursor: pointer;">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>
    `).join('');
}

// عرض تفاصيل المريض
function viewPatientDetails(patientId) {
    const patient = patientsData.find(p => p.id === patientId);
    if (!patient) return;

    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.onclick = () => { overlay.remove(); modal.remove(); };

    const modal = document.createElement('div');
    modal.className = 'images-alert';
    modal.style.maxWidth = '450px';
    modal.onclick = e => e.stopPropagation();

    modal.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-user-injured" style="color: var(--primary);"></i>
                تفاصيل المريض
            </h3>
            <button onclick="this.closest('.images-alert').remove(); document.querySelector('.alert-overlay').remove();"
                    style="background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), #6366f1); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700; margin: 0 auto 12px;">
                ${patient.initial}
            </div>
            <div style="font-size: 20px; font-weight: 700; color: var(--dark);">${patient.name}</div>
            <div style="font-size: 13px; color: var(--gray); margin-top: 4px;">${patient.record}</div>
        </div>

        <div style="background: var(--gray-50); border-radius: 12px; padding: 16px; margin-bottom: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div style="text-align: center; padding: 12px; background: white; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">العمر</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${patient.age} سنة</div>
                </div>
                <div style="text-align: center; padding: 12px; background: white; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">التخصص</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--primary);">${patient.specialty}</div>
                </div>
                <div style="text-align: center; padding: 12px; background: white; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">النوع</div>
                    <div style="font-size: 16px; font-weight: 700; color: ${patient.type === 'private' ? 'var(--primary)' : 'var(--secondary)'};">
                        ${patient.type === 'private' ? 'خاص' : 'عام'}
                    </div>
                </div>
                <div style="text-align: center; padding: 12px; background: white; border-radius: 10px;">
                    <div style="font-size: 11px; color: var(--gray); margin-bottom: 4px;">تاريخ التسجيل</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--dark);">${patient.date}</div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 12px;">
            <button onclick="showToast('جاري فتح سجل المريض...', 'info')"
                    style="flex: 1; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-folder-open" style="margin-left: 6px;"></i>
                فتح السجل
            </button>
            <button onclick="this.closest('.images-alert').remove(); document.querySelector('.alert-overlay').remove();"
                    style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer;">
                إغلاق
            </button>
        </div>
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(modal);
}

// تعديل المريض
function editPatient(patientId) {
    showToast('جاري فتح نموذج التعديل...', 'info');
}

// عرض تفاصيل الحالة
function viewCaseDetails(caseId) {
    const caseItem = casesData.find(c => c.id === caseId);
    if (!caseItem) return;
    
    const statusInfo = getStatusInfo(caseItem.status);
    
    showModal(`
        <div style="padding: 10px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), var(--accent)); 
                          border-radius: 12px; display: flex; align-items: center; justify-content: center; 
                          color: white; font-weight: 700; font-size: 24px;">
                    ${caseItem.patientInitial}
                </div>
                <div style="flex: 1; text-align: right;">
                    <h3 style="font-size: 20px; color: var(--dark); margin-bottom: 4px;">${caseItem.patientName}</h3>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="background: ${getStatusColor(caseItem.status)}20; color: ${getStatusColor(caseItem.status)}; 
                              padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                            <i class="fas ${statusInfo.icon}" style="margin-left: 4px;"></i>
                            ${statusInfo.text}
                        </div>
                        <div style="font-size: 13px; color: var(--gray);">
                            ${caseItem.recordNumber}
                        </div>
                    </div>
                </div>
            </div>
  
            <div style="background: white; border: 1px solid #e5e7eb; border-radius: var(--radius); padding: 20px; margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                    <div>
                        <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">نوع الحالة</div>
                        <div style="font-size: 15px; font-weight: 600; color: var(--dark);">${caseItem.caseType}</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">المقرر</div>
                        <div style="font-size: 15px; font-weight: 600; color: var(--dark);">${caseItem.course}</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">العمر</div>
                        <div style="font-size: 15px; font-weight: 600; color: var(--dark);">${caseItem.caseDetails.age}</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">تاريخ القبول</div>
                        <div style="font-size: 15px; font-weight: 600; color: var(--dark);">${caseItem.caseDetails.admissionDate}</div>
                    </div>
                </div>
                
                <div>
                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 8px;">التشخيص</div>
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark); padding: 12px; 
                          background: var(--gray-light); border-radius: var(--radius-sm);">
                        ${caseItem.caseDetails.diagnosis}
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button onclick="showCaseImages(${caseItem.id})" 
                        style="flex: 1; background: var(--accent); color: white; border: none; 
                               padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-images" style="margin-left: 8px;"></i>
                    عرض الصور (${caseItem.images.length})
                </button>
                <button onclick="showQRFloatingAlert(${caseItem.id})" 
                        style="flex: 1; background: var(--primary); color: white; border: none; 
                               padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-qrcode" style="margin-left: 8px;"></i>
                    عرض QR Code
                </button>
                <button onclick="closeModal()" 
                        style="flex: 1; background: white; color: var(--gray-dark); border: 1.5px solid #e5e7eb; 
                               padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer;">
                    إغلاق
                </button>
            </div>
        </div>
    `, 'تفاصيل الحالة');
}

// وظائف المساعدة
function showToast(message, type = 'info') {
    const colors = {
        info: { bg: 'var(--primary)', icon: 'fa-info-circle' },
        success: { bg: 'var(--secondary)', icon: 'fa-check-circle' },
        warning: { bg: 'var(--warning)', icon: 'fa-exclamation-triangle' }
    };
    
    const color = colors[type] || colors.info;
    const toast = document.createElement('div');
    
    toast.innerHTML = `
        <div style="position: fixed; top: 80px; right: 16px; left: 16px; background: ${color.bg}; 
                   color: white; padding: 12px 16px; border-radius: var(--radius); z-index: 1000; 
                   text-align: center; font-weight: 500; animation: slideDown 0.3s ease;">
            <i class="fas ${color.icon}" style="margin-left: 8px;"></i>
            ${message}
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// إضافة أنيميشن إذا لم تكن موجودة
if (!document.querySelector('style[data-cases-animations]')) {
    const style = document.createElement('style');
    style.setAttribute('data-cases-animations', 'true');
    style.textContent = `
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .fa-spin {
            animation: spin 1s linear infinite;
        }
    `;
    document.head.appendChild(style);
}
</script>

<script>
// تحسين تفاعل الـ Tabs عند التمرير
document.addEventListener('DOMContentLoaded', function() {
    const tabNav = document.getElementById('tabNavigation');
    
    // التحقق مما إذا كان هناك محتوى أكثر من العرض
    setTimeout(() => {
        if (tabNav.scrollWidth > tabNav.clientWidth) {
            document.querySelector('.tab-scroll-left').style.display = 'flex';
            document.querySelector('.tab-scroll-right').style.display = 'flex';
        }
    }, 100);
});
</script>
@endsection
