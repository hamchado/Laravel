<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'مكتب الاستقبال') - نظام إدارة المرضى</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --staff-primary: #0891b2;
            --staff-primary-dark: #0e7490;
            --staff-secondary: #06b6d4;
            --staff-accent: #8b5cf6;
            --staff-success: #10b981;
            --staff-warning: #f59e0b;
            --staff-danger: #ef4444;
            --staff-dark: #1e293b;
            --staff-gray: #64748b;
            --staff-gray-light: #94a3b8;
            --staff-gray-100: #f1f5f9;
            --staff-gray-200: #e2e8f0;
            --staff-white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #164e63 100%);
            min-height: 100vh;
            color: var(--staff-dark);
        }

        /* Header */
        .staff-header {
            background: linear-gradient(135deg, rgba(8, 145, 178, 0.95), rgba(14, 116, 144, 0.95));
            backdrop-filter: blur(20px);
            padding: 16px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .staff-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .staff-logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--staff-white), #e0f2fe);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .staff-logo-icon i {
            font-size: 20px;
            color: var(--staff-primary);
        }

        .staff-logo-text {
            color: white;
        }

        .staff-logo-text h1 {
            font-size: 16px;
            font-weight: 700;
        }

        .staff-logo-text span {
            font-size: 11px;
            opacity: 0.85;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .header-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            position: relative;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.05);
        }

        .header-btn .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 18px;
            height: 18px;
            background: var(--staff-danger);
            border-radius: 50%;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--staff-primary);
        }

        /* Page Title */
        .page-title-bar {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-title {
            color: white;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-title i {
            font-size: 14px;
            opacity: 0.9;
        }

        .current-date {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Main Content */
        .staff-main {
            background: var(--staff-gray-100);
            min-height: calc(100vh - 180px);
            border-radius: 24px 24px 0 0;
            margin-top: -10px;
            padding: 20px 16px;
            padding-bottom: 100px;
        }

        /* Tabs */
        .staff-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 8px;
            margin-bottom: 16px;
            scrollbar-width: none;
        }

        .staff-tabs::-webkit-scrollbar {
            display: none;
        }

        .staff-tab {
            padding: 10px 16px;
            background: white;
            border: 2px solid var(--staff-gray-200);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--staff-gray);
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .staff-tab:hover {
            border-color: var(--staff-primary);
            color: var(--staff-primary);
        }

        .staff-tab.active {
            background: linear-gradient(135deg, var(--staff-primary), var(--staff-secondary));
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 15px rgba(8, 145, 178, 0.3);
        }

        .staff-tab i {
            font-size: 12px;
        }

        /* Cards */
        .staff-card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--staff-gray-200);
        }

        .staff-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .staff-card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--staff-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .staff-card-title i {
            color: var(--staff-primary);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 16px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--staff-gray-200);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card.primary {
            background: linear-gradient(135deg, var(--staff-primary), var(--staff-secondary));
            border: none;
            color: white;
        }

        .stat-card.primary .stat-value,
        .stat-card.primary .stat-label {
            color: white;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 20px;
        }

        .stat-card.primary .stat-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .stat-card:not(.primary) .stat-icon {
            background: var(--staff-gray-100);
            color: var(--staff-primary);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--staff-dark);
        }

        .stat-label {
            font-size: 12px;
            color: var(--staff-gray);
            margin-top: 4px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }

        .quick-action {
            background: white;
            border-radius: 14px;
            padding: 14px 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid var(--staff-gray-200);
        }

        .quick-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .quick-action-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-size: 18px;
            color: white;
        }

        .quick-action-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--staff-dark);
        }

        /* Form Elements */
        .staff-input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid var(--staff-gray-200);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
        }

        .staff-input:focus {
            outline: none;
            border-color: var(--staff-primary);
            box-shadow: 0 0 0 3px rgba(8, 145, 178, 0.1);
        }

        .staff-select {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid var(--staff-gray-200);
            border-radius: 10px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        .staff-btn {
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .staff-btn-primary {
            background: linear-gradient(135deg, var(--staff-primary), var(--staff-secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(8, 145, 178, 0.3);
        }

        .staff-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(8, 145, 178, 0.4);
        }

        .staff-btn-secondary {
            background: var(--staff-gray-100);
            color: var(--staff-dark);
        }

        .staff-btn-success {
            background: linear-gradient(135deg, var(--staff-success), #34d399);
            color: white;
        }

        .staff-btn-danger {
            background: linear-gradient(135deg, var(--staff-danger), #f87171);
            color: white;
        }

        /* Bottom Navigation */
        .staff-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 10px 16px;
            padding-bottom: calc(10px + env(safe-area-inset-bottom));
            display: flex;
            justify-content: space-around;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 20px 20px 0 0;
            z-index: 100;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 8px 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: var(--staff-gray);
        }

        .nav-item:hover {
            background: var(--staff-gray-100);
        }

        .nav-item.active {
            color: var(--staff-primary);
        }

        .nav-item.active .nav-icon {
            background: linear-gradient(135deg, var(--staff-primary), var(--staff-secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(8, 145, 178, 0.3);
        }

        .nav-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s;
        }

        .nav-label {
            font-size: 11px;
            font-weight: 600;
        }

        /* Section Title */
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--staff-dark);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--staff-primary);
        }

        /* List Items */
        .list-item {
            background: white;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--staff-gray-200);
            cursor: pointer;
            transition: all 0.3s;
        }

        .list-item:hover {
            border-color: var(--staff-primary);
            box-shadow: 0 4px 15px rgba(8, 145, 178, 0.1);
        }

        .list-avatar {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .list-content {
            flex: 1;
        }

        .list-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--staff-dark);
        }

        .list-subtitle {
            font-size: 12px;
            color: var(--staff-gray);
            margin-top: 2px;
        }

        .list-badge {
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Toast */
        .staff-toast {
            position: fixed;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--staff-dark);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .staff-toast.show {
            display: block;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--staff-gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--staff-gray-light);
            border-radius: 4px;
        }

        /* Modal */
        .staff-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
            display: none;
        }

        .staff-modal.show {
            display: flex;
        }

        .staff-modal-content {
            background: white;
            border-radius: 20px;
            padding: 24px;
            width: 100%;
            max-width: 400px;
            max-height: 85vh;
            overflow-y: auto;
        }

        /* Responsive */
        @media (max-width: 380px) {
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="staff-header">
        <div class="header-top">
            <div class="staff-logo">
                <div class="staff-logo-icon">
                    <i class="fas fa-hospital-user"></i>
                </div>
                <div class="staff-logo-text">
                    <h1>مكتب الاستقبال</h1>
                    <span>نظام إدارة المرضى</span>
                </div>
            </div>
            <div class="header-actions">
                <button class="header-btn" onclick="showNotifications()">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <button class="header-btn" onclick="showSearch()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="page-title-bar">
            <div class="page-title">
                <i class="@yield('page_icon', 'fas fa-home')"></i>
                <span>@yield('page_title', 'الرئيسية')</span>
            </div>
            <div class="current-date">
                <i class="fas fa-calendar-alt"></i>
                <span id="currentDate"></span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="staff-main">
        @yield('content')
    </main>

    <!-- Bottom Navigation -->
    <nav class="staff-bottom-nav">
        <a href="{{ url('/staff/home') }}" class="nav-item {{ request()->is('staff/home') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-home"></i>
            </div>
            <span class="nav-label">الرئيسية</span>
        </a>
        <a href="{{ url('/staff/patients') }}" class="nav-item {{ request()->is('staff/patients') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-users"></i>
            </div>
            <span class="nav-label">المرضى</span>
        </a>
        <a href="{{ url('/staff/cases') }}" class="nav-item {{ request()->is('staff/cases') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <span class="nav-label">الحالات</span>
        </a>
        <a href="{{ url('/staff/profile') }}" class="nav-item {{ request()->is('staff/profile') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-user-cog"></i>
            </div>
            <span class="nav-label">حسابي</span>
        </a>
    </nav>

    <!-- Toast -->
    <div id="staffToast" class="staff-toast"></div>

    <script>
        // تحديث التاريخ
        function updateDate() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const date = new Date().toLocaleDateString('ar-SA', options);
            document.getElementById('currentDate').textContent = date;
        }
        updateDate();

        // Toast
        function showStaffToast(message, type = 'info') {
            const toast = document.getElementById('staffToast');
            toast.textContent = message;
            toast.style.background = type === 'success' ? 'var(--staff-success)' :
                                      type === 'error' ? 'var(--staff-danger)' :
                                      type === 'warning' ? 'var(--staff-warning)' : 'var(--staff-dark)';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // Tab switching
        function switchStaffTab(tabId) {
            document.querySelectorAll('.staff-tab').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            event.currentTarget.classList.add('active');
            document.getElementById(tabId + 'Content').classList.add('active');
        }

        // Notifications
        function showNotifications() {
            showStaffToast('لديك 3 إشعارات جديدة', 'info');
        }

        // Search
        function showSearch() {
            showStaffToast('البحث في النظام...', 'info');
        }
    </script>

    @yield('scripts')
</body>
</html>
