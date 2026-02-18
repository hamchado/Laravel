<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#4f46e5">
    <title>تسجيل الدخول - نظام الإدارة التعليمية</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #eef2ff;
            --secondary: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1f2937;
            --gray-dark: #374151;
            --gray: #6b7280;
            --gray-light: #d1d5db;
            --gray-lighter: #f3f4f6;
            --light: #ffffff;
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 16px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }

        html, body { height: 100%; overflow-x: hidden; }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            direction: rtl;
            line-height: 1.6;
            color: var(--dark);
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header { text-align: center; margin-bottom: 24px; }

        .logo-icon {
            width: 72px;
            height: 72px;
            background: var(--light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: var(--shadow-lg);
        }

        .logo-icon i { font-size: 32px; color: var(--primary); }

        .logo-text h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--light);
            margin-bottom: 6px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .logo-text p { font-size: 14px; color: rgba(255, 255, 255, 0.9); }

        .login-card {
            background: var(--light);
            border-radius: var(--radius-lg);
            padding: 28px 24px;
            box-shadow: var(--shadow-lg);
        }

        .form-header {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray-lighter);
        }

        .form-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .form-header h2 i { color: var(--primary); }
        .form-header p { font-size: 14px; color: var(--gray); }

        .form-group { margin-bottom: 20px; }

        .input-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .input-label i { color: var(--primary); font-size: 14px; }

        .input-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .input-wrapper { position: relative; }

        .form-input {
            width: 100%;
            padding: 14px 44px 14px 14px;
            font-size: 15px;
            font-family: 'Tajawal', sans-serif;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            transition: all 0.3s ease;
            background: var(--light);
            color: var(--dark);
            direction: ltr;
            text-align: left;
        }

        /* حقل كلمة المرور يحتاج padding إضافي من اليسار لزر الإخفاء */
        .form-input[type="password"],
        .form-input[type="text"].password-field,
        .password-input-wrapper .form-input {
            padding-left: 48px;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }

        .form-input::placeholder {
            color: var(--gray);
            direction: rtl;
            text-align: right;
        }

        .form-input.valid { border-color: var(--secondary); }
        .form-input.invalid { border-color: var(--danger); }

        .input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 16px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 16px;
            padding: 6px;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary);
            background: var(--gray-lighter);
        }

        .input-hint { font-size: 12px; color: var(--gray); margin-top: 6px; }

        .forgot-password {
            font-size: 13px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .forgot-password:hover { text-decoration: underline; }

        /* ============ Slim Button Styles ============ */
        .login-button, .modal-submit-btn {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Tajawal', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--primary);
            color: var(--light);
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        }

        .login-button { margin-top: 20px; }

        .login-button:hover, .modal-submit-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }

        .login-button:active, .modal-submit-btn:active {
            transform: translateY(0);
        }

        .login-button:disabled, .modal-submit-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .login-button .spinner, .modal-submit-btn .spinner { display: none; }
        .login-button.loading .spinner, .modal-submit-btn.loading .spinner { display: inline-flex; align-items: center; gap: 6px; }
        .login-button.loading .btn-text, .modal-submit-btn.loading .btn-text { display: none; }

        /* Success Button */
        .modal-submit-btn.success-btn {
            background: var(--secondary);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        }

        .modal-submit-btn.success-btn:hover {
            background: #059669;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        /* Ghost/Secondary Button */
        .modal-back-btn {
            width: 100%;
            padding: 12px 20px;
            background: var(--gray-lighter);
            color: var(--gray-dark);
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Tajawal', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .modal-back-btn:hover {
            background: var(--gray-light);
            transform: translateY(-2px);
        }

        .modal-back-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: var(--radius-sm);
            padding: 12px;
            margin-top: 16px;
            color: var(--danger);
            font-size: 13px;
            display: none;
            align-items: center;
            gap: 8px;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .login-info {
            margin-top: 20px;
            padding: 14px;
            background: var(--gray-lighter);
            border-radius: var(--radius);
            border-right: 3px solid var(--primary);
        }

        .login-info h4 {
            font-size: 13px;
            color: var(--dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .login-info h4 i { color: var(--primary); }
        .login-info ul { list-style: none; padding: 0; margin: 0; }

        .login-info li {
            font-size: 12px;
            color: var(--gray-dark);
            padding: 4px 0;
            padding-right: 16px;
            position: relative;
        }

        .login-info li::before {
            content: "•";
            color: var(--primary);
            position: absolute;
            right: 0;
        }

        .copyright {
            margin-top: 24px;
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
        }

        /* ============ Modal ============ */
        .modal-overlay {
            position: fixed;
            top: 0; right: 0; bottom: 0; left: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.show { display: flex; animation: fadeIn 0.3s ease; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .modal-content {
            background: var(--light);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 420px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            border-bottom: 1px solid var(--gray-lighter);
        }

        .modal-header h3 {
            font-size: 17px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-header h3 i { color: var(--warning); }

        .close-modal {
            background: none;
            border: none;
            color: var(--gray);
            font-size: 18px;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .close-modal:hover { background: var(--gray-lighter); color: var(--dark); }

        .modal-body { padding: 20px; }
        .modal-step { display: none; }
        .modal-step.active { display: block; }

        .modal-info-box {
            background: rgba(79, 70, 229, 0.1);
            border-radius: var(--radius);
            padding: 14px;
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
        }

        .modal-info-box i {
            color: var(--primary);
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .modal-info-box p { font-size: 13px; color: var(--gray-dark); line-height: 1.6; }
        .modal-info-box.warning { background: rgba(245, 158, 11, 0.1); }
        .modal-info-box.warning i { color: var(--warning); }
        .modal-info-box.success { background: rgba(16, 185, 129, 0.1); }
        .modal-info-box.success i { color: var(--secondary); }

        .modal-form .form-group { margin-bottom: 16px; }

        .modal-message {
            padding: 12px;
            border-radius: var(--radius-sm);
            margin-bottom: 16px;
            font-size: 13px;
            display: none;
            align-items: center;
            gap: 8px;
        }

        .modal-message.show { display: flex; }

        .modal-message.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--secondary);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .modal-message.error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .modal-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--gray-lighter);
        }


        /* ============ OTP ============ */
        .otp-container { margin: 24px 0; }
        .otp-title { text-align: center; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: var(--dark); }
        .otp-subtitle { text-align: center; margin-bottom: 20px; font-size: 12px; color: var(--gray); }

        .otp-inputs { display: flex; justify-content: center; gap: 8px; direction: ltr; }

        .otp-input {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            font-family: 'Tajawal', sans-serif;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius-sm);
            background: var(--light);
            color: var(--dark);
            transition: all 0.3s;
            -moz-appearance: textfield;
        }

        .otp-input::-webkit-outer-spin-button,
        .otp-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

        .otp-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }

        .otp-input.filled { border-color: var(--primary); background: var(--primary-light); }
        .otp-input.error { border-color: var(--danger); background: rgba(239, 68, 68, 0.05); }
        .otp-input.success { border-color: var(--secondary); background: rgba(16, 185, 129, 0.1); }

        .otp-timer { text-align: center; margin-top: 20px; font-size: 13px; color: var(--gray); }
        .otp-timer span { color: var(--primary); font-weight: 600; }

        .resend-btn {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
            font-family: 'Tajawal', sans-serif;
        }

        .resend-btn:disabled { color: var(--gray); cursor: not-allowed; text-decoration: none; }

        /* ============ Password Requirements ============ */
        .password-requirements {
            margin-top: 12px;
            padding: 12px;
            background: var(--gray-lighter);
            border-radius: var(--radius-sm);
        }

        .password-requirements h5 {
            font-size: 12px;
            color: var(--dark);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--gray);
            padding: 4px 0;
            transition: all 0.3s;
        }

        .requirement i { font-size: 12px; width: 16px; text-align: center; }
        .requirement.valid { color: var(--secondary); }
        .requirement.valid i { color: var(--secondary); }
        .requirement.invalid { color: var(--danger); }
        .requirement.invalid i { color: var(--danger); }

        /* ============ Password Strength ============ */
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: var(--gray-lighter);
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s;
            border-radius: 2px;
        }

        .strength-bar.weak { width: 33%; background: var(--danger); }
        .strength-bar.medium { width: 66%; background: var(--warning); }
        .strength-bar.strong { width: 100%; background: var(--secondary); }

        .strength-text {
            font-size: 11px;
            margin-top: 4px;
            text-align: left;
            direction: ltr;
        }

        .strength-text.weak { color: var(--danger); }
        .strength-text.medium { color: var(--warning); }
        .strength-text.strong { color: var(--secondary); }

        /* ============ Success ============ */
        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: scaleIn 0.5s ease;
        }

        .success-icon i { font-size: 40px; color: var(--secondary); }

        @keyframes scaleIn { from { transform: scale(0); } to { transform: scale(1); } }

        .success-title { text-align: center; font-size: 18px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
        .success-text { text-align: center; font-size: 14px; color: var(--gray); margin-bottom: 24px; line-height: 1.6; }

        /* ============ Loading ============ */
        .loading-overlay {
            position: fixed;
            top: 0; right: 0; bottom: 0; left: 0;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            z-index: 2000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .loading-overlay.hidden {
            opacity: 0;
            pointer-events: none;
            backdrop-filter: blur(0);
            -webkit-backdrop-filter: blur(0);
        }

        .loading-spinner {
            width: 56px;
            height: 56px;
            border: 4px solid rgba(79, 70, 229, 0.15);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.2);
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .loading-text {
            color: var(--dark);
            margin-top: 20px;
            font-size: 16px;
            font-weight: 600;
        }

        .loading-subtitle {
            color: var(--gray);
            font-size: 13px;
            margin-top: 6px;
        }

        .loading-content {
            text-align: center;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 50px;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* ============ Responsive ============ */
        @media (max-width: 480px) {
            body { padding: 12px; }
            .login-card { padding: 24px 18px; }
            .logo-icon { width: 64px; height: 64px; }
            .logo-icon i { font-size: 28px; }
            .logo-text h1 { font-size: 20px; }
            .form-header h2 { font-size: 18px; }
            .form-input { padding: 12px 40px 12px 12px; font-size: 14px; }
            .login-button { padding: 12px; font-size: 14px; }
            .otp-input { width: 36px; height: 46px; font-size: 18px; }
            .otp-inputs { gap: 6px; }
        }

        @media (max-width: 360px) {
            .login-card { padding: 20px 14px; }
            .form-header { margin-bottom: 20px; padding-bottom: 16px; }
            .form-group { margin-bottom: 16px; }
            .login-info { padding: 12px; }
            .login-info li { font-size: 11px; }
            .otp-input { width: 32px; height: 42px; font-size: 16px; }
            .otp-inputs { gap: 4px; }
        }

        @media (min-height: 800px) { .login-container { margin-top: -40px; } }

        @media (min-width: 768px) {
            .login-container { max-width: 440px; }
            .login-card { padding: 32px; }
            .otp-input { width: 44px; height: 54px; font-size: 22px; }
            .otp-inputs { gap: 10px; }
        }
    </style>
</head>
<body>
    <div class="loading-overlay hidden" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">جاري التحميل...</div>
            <div class="loading-subtitle">يرجى الانتظار</div>
        </div>
    </div>

    <div class="login-container">
        <div class="login-header">
            <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
            <div class="logo-text">
                <h1>نظام الإدارة التعليمية</h1>
                <p>المنصة الرسمية للطلاب والموظفين</p>
            </div>
        </div>

        <div class="login-card">
            <div class="form-header">
                <h2><i class="fas fa-sign-in-alt"></i>تسجيل الدخول</h2>
                <p>أدخل بياناتك للوصول إلى حسابك</p>
            </div>

            <form id="loginForm">
                <div class="form-group">
                    <label class="input-label"><i class="fas fa-id-card"></i>الرقم الجامعي</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-input" id="student_id" placeholder="أدخل الرقم الجامعي" value="212216" required autofocus>
                        <i class="fas fa-id-card input-icon"></i>
                    </div>
                    <div class="input-hint">مثال: 212216</div>
                </div>

                <div class="form-group">
                    <div class="input-label-row">
                        <label class="input-label"><i class="fas fa-lock"></i>كلمة المرور</label>
                        <a href="#" class="forgot-password" id="forgotPasswordLink">نسيت كلمة المرور؟</a>
                    </div>
                    <div class="input-wrapper password-input-wrapper">
                        <input type="password" class="form-input" id="password" placeholder="أدخل كلمة المرور" value="1" required>
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="password-toggle" id="passwordToggle"><i class="fas fa-eye"></i></button>
                    </div>
                </div>

                <button type="submit" class="login-button" id="loginButton">
                    <span class="btn-text"><i class="fas fa-sign-in-alt"></i>تسجيل الدخول</span>
                    <span class="spinner"><i class="fas fa-spinner fa-spin"></i>جاري التحقق...</span>
                </button>

                <div class="error-message" id="errorMessage">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="errorText"></span>
                </div>
            </form>

            <div class="login-info">
                <h4><i class="fas fa-info-circle"></i>ملاحظات مهمة</h4>
                <ul>
                    <li>الرقم الجامعي هو نفس الرقم الموجود على البطاقة</li>
                    <li>في حال نسيان كلمة المرور اضغط على الرابط أعلاه</li>
                </ul>
            </div>
        </div>

        <div class="copyright"><p>© 2024 نظام الإدارة التعليمية</p></div>
    </div>

    <!-- Modal استعادة كلمة المرور -->
    <div id="forgotPasswordModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-key"></i><span id="modalTitle">استعادة كلمة المرور</span></h3>
                <button class="close-modal" onclick="closeForgotModal()"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal-body">
                <!-- الخطوة 1: إدخال الرقم الجامعي -->
                <div class="modal-step active" id="step1">
                    <div class="modal-info-box">
                        <i class="fas fa-info-circle"></i>
                        <p>أدخل الرقم الجامعي وسيتم إرسال رمز التحقق (OTP) المكون من 8 أرقام إلى بريدك الجامعي.</p>
                    </div>

                    <div class="modal-message" id="step1Message">
                        <i class="fas fa-check-circle"></i>
                        <span id="step1MessageText"></span>
                    </div>

                    <form id="requestOtpForm" class="modal-form">
                        <div class="form-group">
                            <label class="input-label"><i class="fas fa-id-card"></i>الرقم الجامعي</label>
                            <div class="input-wrapper">
                                <input type="text" class="form-input" id="forgot_student_id" placeholder="أدخل الرقم الجامعي" required>
                                <i class="fas fa-id-card input-icon"></i>
                            </div>
                        </div>

                        <button type="submit" class="modal-submit-btn" id="requestOtpBtn">
                            <span class="btn-text"><i class="fas fa-paper-plane"></i>إرسال رمز التحقق</span>
                            <span class="spinner"><i class="fas fa-spinner fa-spin"></i>جاري الإرسال...</span>
                        </button>
                    </form>
                </div>

                <!-- الخطوة 2: إدخال رمز OTP -->
                <div class="modal-step" id="step2">
                    <div class="modal-info-box warning">
                        <i class="fas fa-shield-alt"></i>
                        <p>تم إرسال رمز التحقق إلى بريدك الجامعي. الرمز الافتراضي للاختبار: <strong>11111111</strong></p>
                    </div>

                    <div class="modal-message" id="step2Message">
                        <i class="fas fa-check-circle"></i>
                        <span id="step2MessageText"></span>
                    </div>

                    <div class="otp-container">
                        <div class="otp-title">أدخل رمز التحقق</div>
                        <div class="otp-subtitle">رمز مكون من 8 أرقام</div>

                        <div class="otp-inputs" id="otpInputs">
                            <input type="text" class="otp-input" maxlength="1" data-index="0" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" data-index="1" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" data-index="2" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" data-index="3" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" data-index="4" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" data-index="5" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" data-index="6" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" data-index="7" inputmode="numeric">
                        </div>

                        <div class="otp-timer">
                            <span id="timerText">صالح لمدة <span id="countdown">02:00</span></span>
                            <br>
                            <button type="button" class="resend-btn" id="resendBtn" disabled onclick="resendOtp()">إعادة إرسال الرمز</button>
                        </div>
                    </div>

                    <button type="button" class="modal-submit-btn" id="verifyOtpBtn" disabled onclick="verifyOtp()">
                        <span class="btn-text"><i class="fas fa-check-circle"></i>تأكيد الرمز</span>
                        <span class="spinner"><i class="fas fa-spinner fa-spin"></i>جاري التحقق...</span>
                    </button>
                </div>

                <!-- الخطوة 3: تعيين كلمة المرور الجديدة -->
                <div class="modal-step" id="step3">
                    <div class="modal-info-box success">
                        <i class="fas fa-check-circle"></i>
                        <p>تم التحقق بنجاح! الآن قم بإنشاء كلمة مرور جديدة قوية.</p>
                    </div>

                    <div class="modal-message" id="step3Message">
                        <i class="fas fa-check-circle"></i>
                        <span id="step3MessageText"></span>
                    </div>

                    <form id="newPasswordForm" class="modal-form">
                        <div class="form-group">
                            <label class="input-label"><i class="fas fa-lock"></i>كلمة المرور الجديدة</label>
                            <div class="input-wrapper password-input-wrapper">
                                <input type="password" class="form-input" id="new_password" placeholder="أدخل كلمة المرور الجديدة" required>
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="password-toggle" onclick="toggleNewPassword()"><i class="fas fa-eye" id="newPassIcon"></i></button>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar" id="strengthBar"></div>
                            </div>
                            <div class="strength-text" id="strengthText"></div>

                            <div class="password-requirements">
                                <h5>متطلبات كلمة المرور:</h5>
                                <div class="requirement" id="req-length">
                                    <i class="fas fa-circle"></i>
                                    <span>8 أحرف على الأقل</span>
                                </div>
                                <div class="requirement" id="req-number">
                                    <i class="fas fa-circle"></i>
                                    <span>رقم واحد على الأقل (0-9)</span>
                                </div>
                                <div class="requirement" id="req-symbol">
                                    <i class="fas fa-circle"></i>
                                    <span>رمز واحد على الأقل (!@#$%^&*)</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="input-label"><i class="fas fa-lock"></i>تأكيد كلمة المرور</label>
                            <div class="input-wrapper password-input-wrapper">
                                <input type="password" class="form-input" id="confirm_password" placeholder="أعد إدخال كلمة المرور" required>
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="password-toggle" onclick="toggleConfirmPassword()"><i class="fas fa-eye" id="confirmPassIcon"></i></button>
                            </div>
                            <div class="input-hint" id="matchHint" style="display: none;"></div>
                        </div>

                        <button type="submit" class="modal-submit-btn" id="savePasswordBtn" disabled>
                            <span class="btn-text"><i class="fas fa-save"></i>حفظ كلمة المرور</span>
                            <span class="spinner"><i class="fas fa-spinner fa-spin"></i>جاري الحفظ...</span>
                        </button>
                    </form>
                </div>

                <!-- الخطوة 4: النجاح -->
                <div class="modal-step" id="step4">
                    <div class="success-icon"><i class="fas fa-check"></i></div>
                    <div class="success-title">تم تغيير كلمة المرور بنجاح!</div>
                    <div class="success-text">
                        يمكنك الآن تسجيل الدخول باستخدام كلمة المرور الجديدة.
                        <br>سيتم توجيهك لصفحة تسجيل الدخول...
                    </div>

                    <button type="button" class="modal-submit-btn success-btn" onclick="closeForgotModal()">
                        <i class="fas fa-sign-in-alt"></i>
                        تسجيل الدخول الآن
                    </button>
                </div>
            </div>

            <div class="modal-footer" id="modalFooter">
                <button onclick="goBackStep()" class="modal-back-btn" id="backBtn">
                    <i class="fas fa-arrow-right"></i>
                    <span id="backBtnText">العودة لتسجيل الدخول</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // ============ Variables ============
        let currentStep = 1;
        let otpTimer = null;
        let timeLeft = 120;
        let savedStudentId = '';
        const CORRECT_OTP = '11111111';

        // ============ Page Load ============
        window.addEventListener('load', () => {
            setTimeout(() => document.getElementById('loadingOverlay').classList.add('hidden'), 500);
        });

        // ============ Password Toggle (Login) ============
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        function toggleNewPassword() {
            const input = document.getElementById('new_password');
            const icon = document.getElementById('newPassIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function toggleConfirmPassword() {
            const input = document.getElementById('confirm_password');
            const icon = document.getElementById('confirmPassIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // ============ Login Form ============
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const studentId = document.getElementById('student_id').value.trim();
            const password = document.getElementById('password').value;
            const btn = document.getElementById('loginButton');

            document.getElementById('errorMessage').style.display = 'none';

            if (!studentId) { showError('يرجى إدخال الرقم الجامعي'); return; }
            if (!password) { showError('يرجى إدخال كلمة المرور'); return; }

            btn.classList.add('loading');
            btn.disabled = true;

            setTimeout(() => {
                if (studentId === '212216' && password === '1') {
                    localStorage.setItem('isLoggedIn', 'true');
                    localStorage.setItem('studentId', studentId);
                    document.getElementById('loadingOverlay').classList.remove('hidden');
                    document.querySelector('.loading-text').textContent = 'جاري تسجيل الدخول...';
                    setTimeout(() => window.location.href = '/student/home', 1000);
                } else {
                    btn.classList.remove('loading');
                    btn.disabled = false;
                    showError('الرقم الجامعي أو كلمة المرور غير صحيحة');
                }
            }, 1500);
        });

        function showError(msg) {
            document.getElementById('errorText').textContent = msg;
            document.getElementById('errorMessage').style.display = 'flex';
        }

        // ============ Modal Functions ============
        document.getElementById('forgotPasswordLink').addEventListener('click', (e) => {
            e.preventDefault();
            openForgotModal();
        });

        function openForgotModal() {
            document.getElementById('forgotPasswordModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            resetModal();
        }

        function closeForgotModal() {
            document.getElementById('forgotPasswordModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            clearInterval(otpTimer);
            resetModal();
        }

        function resetModal() {
            currentStep = 1;
            timeLeft = 120;
            savedStudentId = '';

            document.querySelectorAll('.modal-step').forEach(s => s.classList.remove('active'));
            document.getElementById('step1').classList.add('active');

            document.getElementById('requestOtpForm').reset();
            document.getElementById('newPasswordForm')?.reset();

            document.querySelectorAll('.otp-input').forEach(input => {
                input.value = '';
                input.classList.remove('filled', 'error', 'success');
            });

            document.querySelectorAll('.modal-message').forEach(m => m.classList.remove('show'));
            document.querySelectorAll('.requirement').forEach(r => {
                r.classList.remove('valid', 'invalid');
                r.querySelector('i').className = 'fas fa-circle';
            });

            document.getElementById('strengthBar').className = 'strength-bar';
            document.getElementById('strengthText').textContent = '';
            document.getElementById('matchHint').style.display = 'none';

            document.getElementById('modalTitle').textContent = 'استعادة كلمة المرور';
            document.getElementById('backBtnText').textContent = 'العودة لتسجيل الدخول';
            document.getElementById('modalFooter').style.display = 'block';
        }

        function goToStep(step) {
            document.querySelectorAll('.modal-step').forEach(s => s.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');
            currentStep = step;

            const titles = {
                1: 'استعادة كلمة المرور',
                2: 'إدخال رمز التحقق',
                3: 'تعيين كلمة مرور جديدة',
                4: 'تم بنجاح'
            };
            document.getElementById('modalTitle').textContent = titles[step];

            if (step === 2) {
                document.getElementById('backBtnText').textContent = 'الرجوع للخطوة السابقة';
                startTimer();
                document.querySelector('.otp-input').focus();
            } else if (step === 3) {
                document.getElementById('backBtnText').textContent = 'الرجوع للخطوة السابقة';
                document.getElementById('new_password').focus();
            } else if (step === 4) {
                document.getElementById('modalFooter').style.display = 'none';
                // Auto close after 5 seconds
                setTimeout(() => closeForgotModal(), 5000);
            }
        }

        function goBackStep() {
            if (currentStep === 1) {
                closeForgotModal();
            } else if (currentStep === 2) {
                clearInterval(otpTimer);
                goToStep(1);
                document.getElementById('backBtnText').textContent = 'العودة لتسجيل الدخول';
            } else if (currentStep === 3) {
                goToStep(2);
            }
        }

        // ============ Step 1: Request OTP ============
        document.getElementById('requestOtpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const studentId = document.getElementById('forgot_student_id').value.trim();
            const btn = document.getElementById('requestOtpBtn');

            if (!studentId) {
                showStepMessage(1, 'يرجى إدخال الرقم الجامعي', 'error');
                return;
            }

            btn.classList.add('loading');
            btn.disabled = true;

            setTimeout(() => {
                btn.classList.remove('loading');
                btn.disabled = false;
                savedStudentId = studentId;
                goToStep(2);
            }, 1500);
        });

        // ============ Step 2: OTP ============
        const otpInputs = document.querySelectorAll('.otp-input');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                const value = this.value.replace(/[^0-9]/g, '');
                this.value = value;

                if (value) {
                    this.classList.add('filled');
                    if (index < otpInputs.length - 1) otpInputs[index + 1].focus();
                } else {
                    this.classList.remove('filled');
                }

                this.classList.remove('error');
                checkOtpComplete();
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
                if (e.key === 'ArrowLeft' && index < otpInputs.length - 1) otpInputs[index + 1].focus();
                if (e.key === 'ArrowRight' && index > 0) otpInputs[index - 1].focus();
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const data = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 8);
                data.split('').forEach((char, i) => {
                    if (otpInputs[i]) {
                        otpInputs[i].value = char;
                        otpInputs[i].classList.add('filled');
                    }
                });
                if (data.length > 0) otpInputs[Math.min(data.length, 7)].focus();
                checkOtpComplete();
            });

            input.addEventListener('focus', function() { this.select(); });
        });

        function checkOtpComplete() {
            const otp = getOtpValue();
            document.getElementById('verifyOtpBtn').disabled = otp.length !== 8;
        }

        function getOtpValue() {
            return Array.from(otpInputs).map(i => i.value).join('');
        }

        function verifyOtp() {
            const otp = getOtpValue();
            const btn = document.getElementById('verifyOtpBtn');

            if (otp.length !== 8) {
                showStepMessage(2, 'يرجى إدخال الرمز المكون من 8 أرقام', 'error');
                otpInputs.forEach(i => i.classList.add('error'));
                return;
            }

            btn.classList.add('loading');
            btn.disabled = true;

            setTimeout(() => {
                btn.classList.remove('loading');

                if (otp === CORRECT_OTP) {
                    otpInputs.forEach(i => i.classList.add('success'));
                    clearInterval(otpTimer);
                    setTimeout(() => goToStep(3), 500);
                } else {
                    btn.disabled = false;
                    showStepMessage(2, 'رمز التحقق غير صحيح. الرمز الصحيح: 11111111', 'error');
                    otpInputs.forEach(i => i.classList.add('error'));
                }
            }, 1500);
        }

        function startTimer() {
            timeLeft = 120;
            updateTimerDisplay();
            document.getElementById('resendBtn').disabled = true;

            otpTimer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                if (timeLeft <= 0) {
                    clearInterval(otpTimer);
                    document.getElementById('timerText').innerHTML = 'انتهت صلاحية الرمز';
                    document.getElementById('resendBtn').disabled = false;
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const m = Math.floor(timeLeft / 60);
            const s = timeLeft % 60;
            document.getElementById('countdown').textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }

        function resendOtp() {
            document.getElementById('resendBtn').disabled = true;
            otpInputs.forEach(i => {
                i.value = '';
                i.classList.remove('filled', 'error', 'success');
            });
            showStepMessage(2, 'تم إعادة إرسال رمز التحقق', 'success');
            startTimer();
        }

        // ============ Step 3: New Password ============
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        newPasswordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        function validatePassword() {
            const password = newPasswordInput.value;

            // Requirements
            const hasLength = password.length >= 8;
            const hasNumber = /[0-9]/.test(password);
            const hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);

            updateRequirement('req-length', hasLength);
            updateRequirement('req-number', hasNumber);
            updateRequirement('req-symbol', hasSymbol);

            // Strength
            let strength = 0;
            if (hasLength) strength++;
            if (hasNumber) strength++;
            if (hasSymbol) strength++;
            if (password.length >= 12) strength++;
            if (/[A-Z]/.test(password) && /[a-z]/.test(password)) strength++;

            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');

            strengthBar.className = 'strength-bar';
            strengthText.className = 'strength-text';

            if (password.length === 0) {
                strengthText.textContent = '';
            } else if (strength <= 2) {
                strengthBar.classList.add('weak');
                strengthText.classList.add('weak');
                strengthText.textContent = 'ضعيفة';
            } else if (strength <= 3) {
                strengthBar.classList.add('medium');
                strengthText.classList.add('medium');
                strengthText.textContent = 'متوسطة';
            } else {
                strengthBar.classList.add('strong');
                strengthText.classList.add('strong');
                strengthText.textContent = 'قوية';
            }

            // Update input style
            if (password.length > 0) {
                if (hasLength && hasNumber && hasSymbol) {
                    newPasswordInput.classList.remove('invalid');
                    newPasswordInput.classList.add('valid');
                } else {
                    newPasswordInput.classList.remove('valid');
                    newPasswordInput.classList.add('invalid');
                }
            } else {
                newPasswordInput.classList.remove('valid', 'invalid');
            }

            checkPasswordMatch();
            updateSaveButton();
        }

        function updateRequirement(id, valid) {
            const el = document.getElementById(id);
            const icon = el.querySelector('i');

            el.classList.remove('valid', 'invalid');
            if (newPasswordInput.value.length > 0) {
                el.classList.add(valid ? 'valid' : 'invalid');
                icon.className = valid ? 'fas fa-check-circle' : 'fas fa-times-circle';
            } else {
                icon.className = 'fas fa-circle';
            }
        }

        function checkPasswordMatch() {
            const password = newPasswordInput.value;
            const confirm = confirmPasswordInput.value;
            const hint = document.getElementById('matchHint');

            if (confirm.length > 0) {
                hint.style.display = 'block';
                if (password === confirm) {
                    hint.textContent = '✓ كلمتا المرور متطابقتان';
                    hint.style.color = 'var(--secondary)';
                    confirmPasswordInput.classList.remove('invalid');
                    confirmPasswordInput.classList.add('valid');
                } else {
                    hint.textContent = '✗ كلمتا المرور غير متطابقتين';
                    hint.style.color = 'var(--danger)';
                    confirmPasswordInput.classList.remove('valid');
                    confirmPasswordInput.classList.add('invalid');
                }
            } else {
                hint.style.display = 'none';
                confirmPasswordInput.classList.remove('valid', 'invalid');
            }

            updateSaveButton();
        }

        function updateSaveButton() {
            const password = newPasswordInput.value;
            const confirm = confirmPasswordInput.value;

            const hasLength = password.length >= 8;
            const hasNumber = /[0-9]/.test(password);
            const hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            const matches = password === confirm && confirm.length > 0;

            document.getElementById('savePasswordBtn').disabled = !(hasLength && hasNumber && hasSymbol && matches);
        }

        document.getElementById('newPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('savePasswordBtn');
            btn.classList.add('loading');
            btn.disabled = true;

            setTimeout(() => {
                btn.classList.remove('loading');
                goToStep(4);
            }, 1500);
        });

        // ============ Helpers ============
        function showStepMessage(step, msg, type) {
            const el = document.getElementById('step' + step + 'Message');
            const text = document.getElementById('step' + step + 'MessageText');
            const icon = el.querySelector('i');

            text.textContent = msg;
            el.className = 'modal-message show ' + type;
            icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

            if (type === 'success') {
                setTimeout(() => el.classList.remove('show'), 3000);
            }
        }

        // ============ Event Listeners ============
        document.getElementById('forgotPasswordModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('forgotPasswordModal')) closeForgotModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeForgotModal();
        });

        document.getElementById('student_id').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        document.getElementById('forgot_student_id').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>
