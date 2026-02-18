<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#4f46e5">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'مكتب الاستقبال')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Student CSS -->
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">

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
            @yield('page_title', 'مكتب الاستقبال')
        </div>

        <button class="header-btn notification-btn" onclick="showNotificationsModal()">
            <i class="fas fa-bell"></i>
            <span class="notification-badge" id="notificationBadge" data-count="3">3</span>
        </button>
    </div>

    <!-- محتوى الصفحة -->
    <div class="page-content">
        @yield('content')
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ url('/tash/home') }}" class="nav-item {{ request()->is('tash/home') || request()->is('tash') ? 'active' : '' }}">
            <i class="fas fa-home nav-icon"></i>
            <span class="nav-label">الرئيسية</span>
        </a>
        <a href="{{ url('/tash/cases') }}" class="nav-item {{ request()->is('tash/cases') ? 'active' : '' }}">
            <i class="fas fa-folder-open nav-icon"></i>
            <span class="nav-label">الحالات</span>
        </a>
        <a href="{{ url('/tash/patients') }}" class="nav-item {{ request()->is('tash/patients') ? 'active' : '' }}">
            <i class="fas fa-users nav-icon"></i>
            <span class="nav-label">المرضى</span>
        </a>
        <a href="{{ url('/tash/profile') }}" class="nav-item {{ request()->is('tash/profile') ? 'active' : '' }}">
            <i class="fas fa-user-cog nav-icon"></i>
            <span class="nav-label">حسابي</span>
        </a>
    </nav>

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

    <!-- Powered By -->
    <div class="powered-by">
        Powered by: <strong>Dr. Ayham Hamchado</strong>
    </div>

    <script>
        // Page Loading Functions
        function showPageLoading() {
            const overlay = document.getElementById('pageLoadingOverlay');
            if (overlay) {
                overlay.classList.add('active');
            }
        }

        function hidePageLoading() {
            const overlay = document.getElementById('pageLoadingOverlay');
            if (overlay) {
                overlay.classList.remove('active');
            }
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
                    if (href && !href.startsWith('#') && !href.startsWith('http') && !href.startsWith('javascript')) {
                        e.preventDefault();
                        showPageLoading();
                        setTimeout(() => {
                            window.location.href = href;
                        }, 500);
                    }
                });
            });

            // تهيئة التمرير الأفقي
            initHorizontalScroll();
        });

        // تحديث badge الإشعارات
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

        // إدارة الـ Horizontal Scroll مع مؤشر التقدم
        function initHorizontalScroll() {
            const containers = document.querySelectorAll('.horizontal-scroll-container');

            containers.forEach(container => {
                const cards = container.querySelector('.horizontal-cards, .status-filter-cards');
                const hint = container.querySelector('.scroll-hint');
                const progressBar = container.querySelector('.scroll-progress');
                const scrollIndicator = container.querySelector('.scroll-indicator');

                if (cards) {
                    const checkScroll = () => {
                        const hasScroll = cards.scrollWidth > cards.clientWidth;
                        if (hint) {
                            hint.style.display = hasScroll ? 'flex' : 'none';
                        }
                        if (scrollIndicator) {
                            scrollIndicator.style.display = hasScroll ? 'block' : 'none';
                        }
                    };

                    const updateProgress = () => {
                        if (progressBar && cards.scrollWidth > cards.clientWidth) {
                            const scrollPercent = (cards.scrollLeft / (cards.scrollWidth - cards.clientWidth)) * 100;
                            const progressWidth = 30 + (scrollPercent * 0.7);
                            progressBar.style.width = Math.min(progressWidth, 100) + '%';
                        }
                        container.classList.add('scrolled');
                    };

                    cards.addEventListener('scroll', updateProgress);

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
            requestAnimationFrame(() => {
                modal.classList.add('active');
                modal.classList.remove('closing');
            });
        }

        function hideNotificationsModal() {
            const modal = document.getElementById('notificationsModal');
            modal.classList.add('closing');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
                modal.classList.remove('closing');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function loadNotifications() {
            const notificationsList = document.getElementById('notificationsList');
            notificationsList.innerHTML = `
                <div class="notification-item unread notification-info" onclick="markAsRead(this)">
                    <div class="notification-header">
                        <div class="notification-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">مريض جديد</div>
                            <div class="notification-time">قبل 5 دقائق</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">تم تسجيل مريض جديد: أحمد محمد</div>
                    </div>
                </div>

                <div class="notification-item notification-success" onclick="markAsRead(this)">
                    <div class="notification-header">
                        <div class="notification-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">حالة مكتملة</div>
                            <div class="notification-time">قبل 30 دقيقة</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">تم إكمال علاج المريض: سارة خالد</div>
                    </div>
                </div>

                <div class="notification-item unread notification-warning" onclick="markAsRead(this)">
                    <div class="notification-header">
                        <div class="notification-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">تنبيه انتظار</div>
                            <div class="notification-time">قبل ساعة</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">3 مرضى ينتظرون أكثر من 30 دقيقة</div>
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

        // إدارة Modal تسجيل الخروج
        function showLogoutModal() {
            const overlay = document.getElementById('overlay');
            const modal = document.getElementById('logoutModal');
            overlay.style.display = 'block';
            overlay.classList.add('logout-active');
            modal.style.display = 'block';
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
                setTimeout(() => {
                    localStorage.removeItem('isLoggedIn');
                    window.location.href = '/login';
                }, 1000);
            }, 300);
        }

        // إغلاق Modal عند الضغط على Esc
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAllModals();
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
