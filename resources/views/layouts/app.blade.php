<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#4f46e5">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'تطبيق التصفح')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/tash.css') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Student CSS -->
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">

   <link rel="stylesheet" href="{{ asset('css/explore.css') }}">




    <!-- Additional Enhanced Styles -->
    <style>
        /* Smooth Page Transitions */
        .page-content {
            animation: pageEnter 0.4s ease;
        }

        @keyframes pageEnter {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Bottom Nav Enhancement */
        .bottom-nav {
            background: linear-gradient(180deg, #fff 0%, #fafafa 100%);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06);
        }

        .nav-item {
            position: relative;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 24px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            border-radius: 0 0 3px 3px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item.active::before {
            transform: translateX(-50%) scaleX(1);
        }

        .nav-item.active {
            background: linear-gradient(180deg, rgba(79, 70, 229, 0.08), transparent);
        }

        .nav-item:active {
            transform: scale(0.92);
        }

        /* Modal Enhancements */
        .modal {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Overlay Blur Enhancement */
        .overlay {
            background: rgba(0, 0, 0, 0.5) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            transition: all 0.3s ease !important;
        }

        /* Logout Modal Enhancement */
        #logoutModal {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        #logoutModal .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
        }

        #logoutModal .modal-text {
            font-size: 15px;
            color: var(--gray-600);
            margin-bottom: 24px;
        }

        #logoutModal .modal-actions {
            display: flex;
            gap: 12px;
        }

        #logoutModal .modal-btn {
            flex: 1;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        #logoutModal .modal-btn-cancel {
            background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
            color: var(--gray-700);
        }

        #logoutModal .modal-btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #logoutModal .modal-btn-confirm {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            position: relative;
            overflow: hidden;
        }

        #logoutModal .modal-btn-confirm::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        #logoutModal .modal-btn-confirm:hover::before {
            left: 100%;
        }

        #logoutModal .modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        #logoutModal .modal-btn:active {
            transform: translateY(0);
        }

        /* Logout Loading State */
        #logoutModal .modal-btn-confirm.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        #logoutModal .modal-btn-confirm.loading .btn-text {
            display: none;
        }

        #logoutModal .modal-btn-confirm .spinner {
            display: none;
        }

        #logoutModal .modal-btn-confirm.loading .spinner {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Page Loading Enhancement with Full Blur */
        .page-loading-overlay {
            background: rgba(255, 255, 255, 0.75) !important;
            backdrop-filter: blur(25px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(25px) saturate(180%) !important;
        }

        .page-loading-overlay .loading-spinner {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 50px;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.5);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .page-loading-overlay .spinner-circle {
            width: 56px;
            height: 56px;
            border: 4px solid rgba(79, 70, 229, 0.15);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.2);
        }

        .page-loading-overlay .loading-text {
            color: var(--dark);
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .page-loading-overlay .loading-subtitle {
            color: var(--gray-500);
            font-size: 13px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Logout Modal with Blur */
        .overlay.logout-active {
            background: rgba(0, 0, 0, 0.4) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
        }

        /* Notifications Modal Enhancement */
        .notifications-content {
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.15);
        }

        /* Tutorial Overlay Enhancement */
        .tutorial-content {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Loading Overlay Gradient */
        .page-loading-overlay {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%);
        }

        /* Scrollbar Enhancement */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        /* Tab Navigation Enhancement */
        .tab-navigation-container {
            background: linear-gradient(180deg, #fff 0%, #fafafa 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        /* Powered By Enhancement */
        .powered-by {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
            padding: 4px 16px;
            border-radius: 12px;
        }
    </style>

</head>
<body>
    <!-- شريط الرأس العلوي -->
    <div class="top-header">
        <button class="header-btn logout-btn" onclick="showLogoutModal()">
            <i class="fas fa-sign-out-alt"></i>
        </button>
        
        <div class="page-title">
            @yield('page_title', 'عنوان الصفحة')
        </div>
        
        <button class="header-btn notification-btn" onclick="showNotificationsModal()">
            <i class="fas fa-bell"></i>
            <span class="notification-badge" id="notificationBadge" data-count="3">3</span>
        </button>
    </div>
    
    <!-- Tab Navigation (للصفحات التي تحتاجه) -->
    @hasSection('tabs')
    <div class="page-content">
        <div class="tab-navigation-container">
            <div class="tab-navigation" id="tabNavigation">
                @yield('tabs')
            </div>
            <div class="tab-scroll-hint tab-scroll-left" onclick="scrollTabs('left')">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="tab-scroll-hint tab-scroll-right" onclick="scrollTabs('right')">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
        @yield('tab_content')
    </div>
    @else
    <!-- محتوى الصفحة العادي -->
    <div class="page-content">
        @yield('content')
    </div>
    @endif
    
    <!-- Bottom Navigation -->
    @if(isset($navItems) && isset($section))
    <nav class="bottom-nav">
        @foreach($navItems as $item)
        <a href="{{ url('/' . $section . '/' . $item['id']) }}"
           class="nav-item {{ isset($currentPage) && $currentPage == $item['id'] ? 'active' : '' }}">
            <i class="{{ $item['icon'] }} nav-icon"></i>
            <span class="nav-label">{{ $item['label'] }}</span>
        </a>
        @endforeach
    </nav>
    @endif
    
    <!-- Modal إشعارات عائم -->
    <div class="notifications-modal" id="notificationsModal" onclick="if(event.target === this) hideNotificationsModal()">
        <div class="notifications-content" onclick="event.stopPropagation()">
            <div class="notifications-header">
                <div class="notifications-title">الإشعارات</div>
                <button class="close-btn" onclick="hideNotificationsModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="notifications-body" id="notificationsList">
                <!-- سيتم تحميل محتوى الإشعارات هنا -->
            </div>
        </div>
    </div>
    
    <!-- Modal تسجيل الخروج -->
    <div class="modal" id="logoutModal">
        <div class="modal-title">
            <i class="fas fa-sign-out-alt" style="margin-left: 8px; color: var(--danger);"></i>
            تسجيل الخروج
        </div>
        <div class="modal-text">
            هل أنت متأكد من رغبتك في تسجيل الخروج؟
        </div>
        <div class="modal-actions">
            <button class="modal-btn modal-btn-cancel" onclick="closeModal()">
                <i class="fas fa-times" style="margin-left: 6px;"></i>
                إلغاء
            </button>
            <button class="modal-btn modal-btn-confirm" id="logoutConfirmBtn" onclick="performLogout()">
                <span class="btn-text">
                    <i class="fas fa-sign-out-alt" style="margin-left: 6px;"></i>
                    تسجيل خروج
                </span>
                <span class="spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    جاري الخروج...
                </span>
            </button>
        </div>
    </div>
    
    <!-- Tutorial Overlay -->
    <div class="tutorial-overlay" id="tutorialOverlay">
        <div class="tutorial-content" id="tutorialContent">
            <!-- سيتم تحميل الشرح هنا -->
        </div>
    </div>
    
    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="closeAllModals()" style="display: none;"></div>

    <!-- Page Loading Overlay with Full Blur -->
    <div class="page-loading-overlay active" id="pageLoadingOverlay">
        <div class="loading-spinner">
            <div class="spinner-circle"></div>
            <div class="loading-text">جاري التحميل...</div>
            <div class="loading-subtitle">يرجى الانتظار</div>
        </div>
    </div>

    <!-- Connection Error Toast -->
    <div class="connection-error-toast" id="connectionErrorToast" style="display: none;">
        <div class="error-icon">
            <i class="fas fa-wifi"></i>
        </div>
        <h3>خطأ في الاتصال</h3>
        <p>تحقق من اتصالك بالإنترنت وحاول مرة أخرى</p>
        <button onclick="retryConnection()">إعادة المحاولة</button>
    </div>

    <!-- Powered By -->
    <div class="powered-by">
        Powered by: <strong>Dr. Ayham Hamchado</strong>
    </div>
    
    <script>
        // Page Loading Functions with Timeout
        let loadingTimeout = null;
        let connectionTimeout = null;
        const LOADING_MIN_DURATION = 2000; // 2 ثانية كحد أدنى
        const LOADING_MAX_DURATION = 10000; // 10 ثواني كحد أقصى

        function showPageLoading() {
            const overlay = document.getElementById('pageLoadingOverlay');
            if (overlay) {
                overlay.classList.add('active');

                // تعيين timeout للاتصال (10 ثواني)
                connectionTimeout = setTimeout(() => {
                    showConnectionError();
                }, LOADING_MAX_DURATION);
            }
        }

        function hidePageLoading() {
            const overlay = document.getElementById('pageLoadingOverlay');
            if (overlay) {
                overlay.classList.remove('active');
            }

            // إلغاء الـ timeouts
            if (connectionTimeout) {
                clearTimeout(connectionTimeout);
                connectionTimeout = null;
            }
            if (loadingTimeout) {
                clearTimeout(loadingTimeout);
                loadingTimeout = null;
            }
        }

        function showConnectionError() {
            hidePageLoading();
            const errorToast = document.getElementById('connectionErrorToast');
            const overlay = document.getElementById('pageLoadingOverlay');

            if (errorToast) {
                // إظهار الـ overlay بدون الـ spinner
                overlay.classList.add('active');
                overlay.querySelector('.loading-spinner').style.display = 'none';
                errorToast.style.display = 'block';
            }
        }

        function retryConnection() {
            const errorToast = document.getElementById('connectionErrorToast');
            const overlay = document.getElementById('pageLoadingOverlay');

            if (errorToast) {
                errorToast.style.display = 'none';
                overlay.querySelector('.loading-spinner').style.display = 'block';
            }

            // إعادة تحميل الصفحة
            window.location.reload();
        }

        // تفعيل الـ loading عند النقر على الروابط
        document.addEventListener('DOMContentLoaded', function() {
            // إخفاء التحميل بعد تحميل الصفحة كاملة
            setTimeout(() => {
                hidePageLoading();
            }, 500);

            // إضافة تأثير التحميل لجميع روابط التنقل
            document.querySelectorAll('a.nav-item, a[href^="/"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    // تجاهل الروابط الخارجية والـ anchors
                    if (href && !href.startsWith('#') && !href.startsWith('http') && !href.startsWith('javascript')) {
                        e.preventDefault();
                        showPageLoading();

                        // تأخير التنقل لمدة 1.5 ثانية
                        loadingTimeout = setTimeout(() => {
                            window.location.href = href;
                        }, 1500);
                    }
                });
            });

            // تحديث badge الإشعارات
            updateNotificationBadge();

            // تهيئة التمرير الأفقي
            initHorizontalScroll();
        });

        // تحديث badge الإشعارات (إخفاؤها إذا كانت 0)
        function updateNotificationBadge() {
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                const count = parseInt(badge.textContent) || 0;
                badge.setAttribute('data-count', count);
                if (count === 0) {
                    badge.classList.add('hidden');
                    badge.textContent = '';
                } else {
                    badge.classList.remove('hidden');
                }
            }
        }

        // تحديث العدد في الـ badge
        function setNotificationCount(count) {
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                badge.setAttribute('data-count', count);
                if (count === 0) {
                    badge.classList.add('hidden');
                    badge.textContent = '';
                } else {
                    badge.classList.remove('hidden');
                    badge.textContent = count.toString();
                }
            }
        }

        // Auth is now handled server-side via Laravel middleware
        // No localStorage check needed

        // تعريف المتغيرات العامة
        let currentTutorialSlide = 0;
        const totalTutorialSlides = 5;
        
        // إدارة Dropdown
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            
            if (dropdown.classList.contains('dropdown-open')) {
                dropdown.classList.remove('dropdown-open');
            } else {
                closeAllDropdowns();
                dropdown.classList.add('dropdown-open');
            }
        }
        
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
        }
        
        function closeAllDropdowns() {
            document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                dropdown.classList.remove('dropdown-open');
            });
        }
        
        // إدارة Tabs
        function switchTab(tabId) {
            // إخفاء جميع محتويات التبويبات
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });
            
            // إزالة النشاط من جميع التبويبات
            document.querySelectorAll('.tab-item').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // إظهار المحتوى المطلوب وتفعيل التبويب
            document.getElementById(tabId + 'Content').style.display = 'block';
            event.currentTarget.classList.add('active');
        }
        
        function scrollTabs(direction) {
            const tabNav = document.getElementById('tabNavigation');
            const scrollAmount = 150;
            
            if (direction === 'left') {
                tabNav.scrollLeft -= scrollAmount;
            } else {
                tabNav.scrollLeft += scrollAmount;
            }
        }
        
        // إدارة الـ Horizontal Scroll مع مؤشر التقدم
        function initHorizontalScroll() {
            const containers = document.querySelectorAll('.horizontal-scroll-container');

            containers.forEach(container => {
                const cards = container.querySelector('.horizontal-cards, .status-filter-cards');
                const hint = container.querySelector('.scroll-hint');
                const progressBar = container.querySelector('.scroll-progress');
                const scrollIndicator = container.querySelector('.scroll-indicator');

                if (cards) {
                    // إخفاء التلميح ومؤشر التقدم إذا لم يكن هناك تمرير
                    const checkScroll = () => {
                        const hasScroll = cards.scrollWidth > cards.clientWidth;
                        if (hint) {
                            hint.style.display = hasScroll ? 'flex' : 'none';
                        }
                        if (scrollIndicator) {
                            scrollIndicator.style.display = hasScroll ? 'block' : 'none';
                        }
                    };

                    // تحديث مؤشر التقدم عند التمرير
                    const updateProgress = () => {
                        if (progressBar && cards.scrollWidth > cards.clientWidth) {
                            const scrollPercent = (cards.scrollLeft / (cards.scrollWidth - cards.clientWidth)) * 100;
                            const progressWidth = 30 + (scrollPercent * 0.7); // من 30% إلى 100%
                            progressBar.style.width = Math.min(progressWidth, 100) + '%';
                        }
                        container.classList.add('scrolled');
                    };

                    cards.addEventListener('scroll', updateProgress);

                    // تحديث مبدئي
                    setTimeout(() => {
                        checkScroll();
                        updateProgress();
                    }, 100);
                    window.addEventListener('resize', checkScroll);
                }
            });
        }
        
        // إدارة Modal إشعارات
        function showNotificationsModal() {
            const modal = document.getElementById('notificationsModal');

            loadNotifications();

            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            // تفعيل الأنيميشن بعد إظهار العنصر
            requestAnimationFrame(() => {
                modal.classList.add('active');
                modal.classList.remove('closing');
            });
        }

        function hideNotificationsModal() {
            const modal = document.getElementById('notificationsModal');

            modal.classList.add('closing');
            modal.classList.remove('active');

            // إخفاء بعد انتهاء الأنيميشن
            setTimeout(() => {
                modal.style.display = 'none';
                modal.classList.remove('closing');
                document.body.style.overflow = 'auto';
            }, 300);
        }
        
        function loadNotifications() {
            const notificationsList = document.getElementById('notificationsList');

            // جلب إشعارات الملف الشخصي من localStorage
            const profileNotifications = JSON.parse(localStorage.getItem('profileNotifications') || '[]');
            let profileNotificationsHTML = '';

            profileNotifications.forEach(notif => {
                const timeAgo = getTimeAgo(notif.time);
                profileNotificationsHTML += `
                    <div class="notification-item ${notif.read ? '' : 'unread'} notification-success" onclick="markProfileNotifAsRead('${notif.id}', this)">
                        <div class="notification-header">
                            <div class="notification-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div style="flex: 1;">
                                <div class="notification-title">${notif.title}</div>
                                <div class="notification-time">${timeAgo}</div>
                            </div>
                        </div>
                        <div class="notification-body">
                            <div class="notification-text">${notif.message}</div>
                            <div class="notification-course">الملف الشخصي</div>
                        </div>
                    </div>
                `;
            });

            notificationsList.innerHTML = profileNotificationsHTML + `
                <!-- إشعار 1 - غير مقروء -->
                <div class="notification-item unread notification-info" onclick="markAsRead(this)">
                    <div class="notification-header">
                        <div class="notification-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">موعد تسليم الواجب</div>
                            <div class="notification-time">قبل 2 ساعة</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">
                            تذكير: موعد تسليم واجب الرياضيات غداً الساعة 10:00
                        </div>
                        <div class="notification-course">الرياضيات</div>
                    </div>
                </div>
                
                <!-- إشعار 2 -->
                <div class="notification-item notification-success" onclick="markAsRead(this)">
                    <div class="notification-header">
                        <div class="notification-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">تم تسليم الواجب</div>
                            <div class="notification-time">قبل 5 ساعات</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">
                            تم تسليم واجب الفيزياء بنجاح
                        </div>
                        <div class="notification-course">الفيزياء</div>
                    </div>
                </div>
                
                <!-- إشعار 3 - غير مقروء -->
                <div class="notification-item unread notification-warning" onclick="markAsRead(this)">
                    <div class="notification-header">
                        <div class="notification-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">تغيير في الجدول</div>
                            <div class="notification-time">قبل يوم</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">
                            تم تغيير موعد محاضرة الكيمياء
                        </div>
                        <div class="notification-course">الكيمياء</div>
                    </div>
                </div>

        
        /* إشعارات داخلية */

                
                <!-- إشعار 4 -->
                <div class="notification-item" onclick="markAsRead(this)">
                    <div class="notification-header">
                        <div class="notification-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                            <i class="fas fa-book"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">مادة جديدة</div>
                            <div class="notification-time">قبل يومين</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">
                            تم إضافة مادة البرمجة إلى جدولك
                        </div>
                        <div class="notification-course">البرمجة</div>
                    </div>
                </div>
                
                <!-- إشعار 5 - غير مقروء -->
                <div class="notification-item unread" onclick="markAsRead(this)">
                    <div class="notification-header">
                        <div class="notification-icon" style="background: rgba(236, 72, 153, 0.1); color: var(--accent);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">اختبار قادم</div>
                            <div class="notification-time">قبل 3 أيام</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">
                            اختبار نصفي في اللغة الإنجليزية
                        </div>
                        <div class="notification-course">الإنجليزية</div>
                    </div>
                </div>
            `;
        }
        
        function markAsRead(element) {
            if (element.classList.contains('unread')) {
                element.classList.remove('unread');

                const badge = document.getElementById('notificationBadge');
                if (badge) {
                    const currentCount = parseInt(badge.getAttribute('data-count')) || 0;
                    const newCount = Math.max(0, currentCount - 1);
                    setNotificationCount(newCount);
                }
            }
        }

        function markProfileNotifAsRead(id, element) {
            const notifications = JSON.parse(localStorage.getItem('profileNotifications') || '[]');
            const notif = notifications.find(n => n.id == id);
            if (notif && !notif.read) {
                notif.read = true;
                localStorage.setItem('profileNotifications', JSON.stringify(notifications));

                element.classList.remove('unread');

                const badge = document.getElementById('notificationBadge');
                if (badge) {
                    const currentCount = parseInt(badge.getAttribute('data-count')) || 0;
                    const newCount = Math.max(0, currentCount - 1);
                    setNotificationCount(newCount);
                }
            }
        }

        function getTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);

            if (diffMins < 1) return 'الآن';
            if (diffMins < 60) return `قبل ${diffMins} دقيقة`;
            if (diffHours < 24) return `قبل ${diffHours} ساعة`;
            if (diffDays < 7) return `قبل ${diffDays} يوم`;
            return date.toLocaleDateString('ar-SA');
        }
        
        // إدارة Modal تسجيل الخروج
        function showLogoutModal() {
            const overlay = document.getElementById('overlay');
            const modal = document.getElementById('logoutModal');

            overlay.style.display = 'block';
            overlay.classList.add('logout-active');
            modal.style.display = 'block';

            // Reset button state
            const btn = document.getElementById('logoutConfirmBtn');
            if (btn) {
                btn.classList.remove('loading');
            }
        }

        function closeModal() {
            const overlay = document.getElementById('overlay');
            const modal = document.getElementById('logoutModal');

            modal.style.display = 'none';
            overlay.classList.remove('logout-active');
            overlay.style.display = 'none';
        }

        function closeAllModals() {
            closeModal();
            hideNotificationsModal();
        }

        function performLogout() {
            const btn = document.getElementById('logoutConfirmBtn');
            btn.classList.add('loading');

            const pageOverlay = document.getElementById('pageLoadingOverlay');
            const loadingText = pageOverlay.querySelector('.loading-text');
            const loadingSubtitle = pageOverlay.querySelector('.loading-subtitle');

            if (loadingText) loadingText.textContent = 'جاري تسجيل الخروج...';
            if (loadingSubtitle) loadingSubtitle.textContent = 'يرجى الانتظار';

            setTimeout(() => {
                closeModal();
                pageOverlay.classList.add('active');

                // POST logout via form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/logout';
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }, 300);
        }
        
        // إدارة Tutorial محسن
        function showTutorial() {
            const tutorialOverlay = document.getElementById('tutorialOverlay');
            const tutorialContent = document.getElementById('tutorialContent');

            tutorialContent.innerHTML = `
                <!-- مؤشرات التقدم الرئيسية -->
                <div class="tutorial-progress-bar" id="tutorialProgressBar">
                    <div class="progress-dot active" data-slide="0"></div>
                    <div class="progress-dot" data-slide="1"></div>
                    <div class="progress-dot" data-slide="2"></div>
                    <div class="progress-dot" data-slide="3"></div>
                    <div class="progress-dot" data-slide="4"></div>
                </div>

                <div class="tutorial-slide active" id="slide1">
                    <div class="tutorial-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="tutorial-title">مرحباً بك!</div>
                    <div class="tutorial-text">
                        مرحباً بك في نظام إدارة التدريب السريري.<br>
                        دعنا نتعرف معاً على أهم ميزات النظام.
                    </div>
                    <div class="tutorial-step-counter">1 / 5</div>
                </div>

                <div class="tutorial-slide" id="slide2">
                    <div class="tutorial-icon" style="background: linear-gradient(145deg, var(--secondary), #059669);">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div class="tutorial-title">شريط التنقل</div>
                    <div class="tutorial-text">
                        استخدم شريط التنقل السفلي للتنقل بين الصفحات:<br>
                        <span style="display: inline-flex; gap: 8px; margin-top: 8px; flex-wrap: wrap; justify-content: center;">
                            <span style="background: rgba(79,70,229,0.1); padding: 4px 10px; border-radius: 8px; font-size: 12px;">🏠 الرئيسية</span>
                            <span style="background: rgba(16,185,129,0.1); padding: 4px 10px; border-radius: 8px; font-size: 12px;">🔍 الاستكشاف</span>
                            <span style="background: rgba(236,72,153,0.1); padding: 4px 10px; border-radius: 8px; font-size: 12px;">⭐ المفضلة</span>
                        </span>
                    </div>
                    <div class="tutorial-step-counter">2 / 5</div>
                </div>

                <div class="tutorial-slide" id="slide3">
                    <div class="tutorial-icon" style="background: linear-gradient(145deg, var(--warning), #d97706);">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="tutorial-title">الإشعارات</div>
                    <div class="tutorial-text">
                        اضغط على أيقونة الجرس <i class="fas fa-bell" style="color: var(--warning);"></i> للاطلاع على آخر الإشعارات.<br>
                        <span style="color: var(--primary); font-weight: 600;">الإشعارات غير المقروءة تظهر بلون مميز.</span>
                    </div>
                    <div class="tutorial-step-counter">3 / 5</div>
                </div>

                <div class="tutorial-slide" id="slide4">
                    <div class="tutorial-icon" style="background: linear-gradient(145deg, var(--accent), #be185d);">
                        <i class="fas fa-arrows-alt-h"></i>
                    </div>
                    <div class="tutorial-title">التمرير الأفقي</div>
                    <div class="tutorial-text">
                        عند رؤية علامة <i class="fas fa-hand-point-left" style="color: var(--primary);"></i><br>
                        اسحب <strong>يميناً أو يساراً</strong> لاستعراض المزيد من المحتوى.
                    </div>
                    <div class="tutorial-step-counter">4 / 5</div>
                </div>

                <div class="tutorial-slide" id="slide5">
                    <div class="tutorial-icon" style="background: linear-gradient(145deg, #10b981, #047857);">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="tutorial-title">أنت جاهز!</div>
                    <div class="tutorial-text">
                        رائع! أنت الآن جاهز لاستخدام النظام بكل سهولة.<br>
                        <span style="font-size: 13px; color: var(--gray);">يمكنك إعادة مشاهدة هذه الجولة من الإعدادات.</span>
                    </div>
                    <div class="tutorial-step-counter">5 / 5</div>
                </div>

                <!-- أزرار التنقل -->
                <div class="tutorial-nav-actions" id="tutorialNavActions">
                    <button class="tutorial-btn tutorial-btn-skip" id="tutorialSkipBtn" onclick="skipTutorial()">
                        تخطي
                    </button>
                    <button class="tutorial-btn tutorial-btn-next" id="tutorialNextBtn" onclick="nextTutorialSlide()">
                        <span id="nextBtnText">التالي</span>
                        <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>
                    </button>
                </div>
            `;

            tutorialOverlay.style.display = 'block';
            currentTutorialSlide = 0;
            updateTutorialUI();
        }

        function restartTutorial() {
            currentTutorialSlide = 0;
            document.querySelectorAll('.tutorial-slide').forEach(slide => {
                slide.classList.remove('active');
            });
            document.getElementById('slide1').classList.add('active');
            updateTutorialUI();
        }

        function nextTutorialSlide() {
            if (currentTutorialSlide < totalTutorialSlides - 1) {
                document.querySelectorAll('.tutorial-slide').forEach(slide => {
                    slide.classList.remove('active');
                });

                currentTutorialSlide++;
                document.getElementById(`slide${currentTutorialSlide + 1}`).classList.add('active');
                updateTutorialUI();
            } else {
                finishTutorial();
            }
        }

        function updateTutorialUI() {
            // تحديث النقاط
            const dots = document.querySelectorAll('.progress-dot');
            dots.forEach((dot, index) => {
                if (index === currentTutorialSlide) {
                    dot.classList.add('active');
                } else if (index < currentTutorialSlide) {
                    dot.classList.add('completed');
                    dot.classList.remove('active');
                } else {
                    dot.classList.remove('active', 'completed');
                }
            });

            // تحديث زر التالي
            const nextBtn = document.getElementById('tutorialNextBtn');
            const nextBtnText = document.getElementById('nextBtnText');
            const skipBtn = document.getElementById('tutorialSkipBtn');

            if (currentTutorialSlide === totalTutorialSlides - 1) {
                nextBtnText.textContent = 'ابدأ الآن';
                nextBtn.classList.remove('tutorial-btn-next');
                nextBtn.classList.add('tutorial-btn-finish');
                skipBtn.innerHTML = '<i class="fas fa-redo" style="margin-left: 6px;"></i> إعادة';
                skipBtn.onclick = restartTutorial;
            } else {
                nextBtnText.textContent = 'التالي';
                nextBtn.classList.add('tutorial-btn-next');
                nextBtn.classList.remove('tutorial-btn-finish');
                skipBtn.textContent = 'تخطي';
                skipBtn.onclick = skipTutorial;
            }
        }

        function updateTutorialIndicators() {
            updateTutorialUI();
        }
        
        function skipTutorial() {
            document.getElementById('tutorialOverlay').style.display = 'none';
            localStorage.setItem('appTutorialShown', 'true');
        }
        
        function finishTutorial() {
            document.getElementById('tutorialOverlay').style.display = 'none';
            localStorage.setItem('appTutorialShown', 'true');
        }
        
        // إدارة التنقل بين الصفحات
        function handleNavigation(event, pageId) {
            event.preventDefault();
            const section = '{{ $section ?? "" }}';
            window.location.href = `/${section}/${pageId}`;
        }
        
        // عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            // تفعيل أول تبويب إذا كان موجوداً
            const firstTab = document.querySelector('.tab-item');
            const firstTabContent = document.querySelector('.tab-content');
            if (firstTab && firstTabContent) {
                firstTab.classList.add('active');
                firstTabContent.style.display = 'block';
            }
            
            // تهيئة الـ Horizontal Scroll
            initHorizontalScroll();
            
            // عرض الشرح لأول مرة فقط
            if (!localStorage.getItem('appTutorialShown')) {
                setTimeout(() => {
                    showTutorial();
                }, 1000);
            }
            
            // إغلاق Dropdown عند النقر خارجها
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.custom-dropdown')) {
                    closeAllDropdowns();
                }
            });
            
            // إغلاق Modal عند الضغط على Esc
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeAllModals();
                }
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
