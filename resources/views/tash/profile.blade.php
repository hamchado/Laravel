@extends('layouts.tash')

@section('title', 'الملف الشخصي - المشرف')
@section('page_title', 'الملف الشخصي')

@section('content')
<!-- رأس الملف الشخصي -->
<div style="text-align: center; margin-bottom: 28px; padding: 20px 0;">
    <div style="position: relative; display: inline-block; margin-bottom: 20px;">
        <div style="width: 100px; height: 100px; background: linear-gradient(145deg, var(--primary), var(--primary-light));
                    border-radius: 50%; display: flex; align-items: center; justify-content: center;
                    border: 4px solid white; box-shadow: 0 8px 30px rgba(99, 102, 241, 0.3);">
            <span id="profileLetter" style="color: white; font-size: 38px; font-weight: 800;">م</span>
        </div>
    </div>
    <h1 id="profileName" style="font-size: 22px; color: var(--dark); margin-bottom: 8px; font-weight: 800;">جاري التحميل...</h1>
    <div id="profileRole" style="display: inline-flex; align-items: center; background: rgba(99, 102, 241, 0.1);
                color: var(--primary); padding: 8px 18px; border-radius: 20px; font-size: 14px; margin-bottom: 12px; font-weight: 600;">
        <i class="fas fa-id-badge" style="margin-left: 8px;"></i>
        <span>--</span>
    </div>
</div>

<!-- معلومات الحساب -->
<div class="input-container" style="margin-bottom: 20px;">
    <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--dark); margin: 0;">
            <i class="fas fa-user-circle" style="color: var(--primary); margin-left: 8px;"></i>
            معلومات الحساب
        </h3>
    </div>
    <div style="padding: 16px; display: flex; flex-direction: column; gap: 12px;">
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">
            <span style="color: #6b7280; font-size: 14px;">الاسم:</span>
            <span id="infoName" style="font-weight: 700; color: #1f2937;">--</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">
            <span style="color: #6b7280; font-size: 14px;">الرقم الجامعي:</span>
            <span id="infoStudentId" style="font-weight: 700; color: #1f2937;">--</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">
            <span style="color: #6b7280; font-size: 14px;">الهاتف:</span>
            <span id="infoPhone" style="font-weight: 700; color: #1f2937; direction: ltr;">--</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px 0;">
            <span style="color: #6b7280; font-size: 14px;">الدور:</span>
            <span id="infoRole" style="font-weight: 700; color: var(--primary);">--</span>
        </div>
    </div>
</div>

<!-- تغيير كلمة المرور -->
<div class="input-container" style="margin-bottom: 20px;">
    <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--dark); margin: 0;">
            <i class="fas fa-lock" style="color: #f59e0b; margin-left: 8px;"></i>
            تغيير كلمة المرور
        </h3>
    </div>
    <div style="padding: 16px; display: flex; flex-direction: column; gap: 14px;">
        <div>
            <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">كلمة المرور الحالية</label>
            <input type="password" id="currentPassword" class="text-input" placeholder="أدخل كلمة المرور الحالية">
        </div>
        <div>
            <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">كلمة المرور الجديدة</label>
            <input type="password" id="newPassword" class="text-input" placeholder="أدخل كلمة المرور الجديدة">
        </div>
        <div>
            <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">تأكيد كلمة المرور</label>
            <input type="password" id="confirmPassword" class="text-input" placeholder="أعد إدخال كلمة المرور الجديدة">
        </div>
        <button onclick="changePassword()" id="changePasswordBtn" style="width: 100%; padding: 14px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 15px;">
            <i class="fas fa-key" style="margin-left: 6px;"></i>
            تغيير كلمة المرور
        </button>
    </div>
</div>

<!-- تسجيل الخروج -->
<div style="text-align: center; margin-top: 20px;">
    <form method="POST" action="/logout">
        @csrf
        <button type="submit" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; padding: 14px 40px; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 15px;">
            <i class="fas fa-sign-out-alt" style="margin-left: 6px;"></i>
            تسجيل الخروج
        </button>
    </form>
</div>

<script>
function apiFetch(url, options) {
    options = options || {};
    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    var defaults = {
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    };
    var merged = Object.assign({}, defaults, options);
    if (options.headers) merged.headers = Object.assign({}, defaults.headers, options.headers);
    return fetch(url, merged).then(function(res) {
        if (res.status === 401) { window.location.href = '/login'; return; }
        return res.json();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    apiFetch('/api/profile').then(function(data) {
        if (data && data.success) {
            var u = data.user;
            document.getElementById('profileName').textContent = u.name || '';
            document.getElementById('profileLetter').textContent = (u.name || '?')[0];
            document.getElementById('profileRole').querySelector('span').textContent = u.role_label || u.role || '';
            document.getElementById('infoName').textContent = u.name || '';
            document.getElementById('infoStudentId').textContent = u.student_id || '';
            document.getElementById('infoPhone').textContent = u.phone || '';
            document.getElementById('infoRole').textContent = u.role_label || u.role || '';
        }
    });
});

function changePassword() {
    var current = document.getElementById('currentPassword').value;
    var newPass = document.getElementById('newPassword').value;
    var confirm = document.getElementById('confirmPassword').value;

    if (!current || !newPass || !confirm) {
        showToast('الرجاء ملء جميع الحقول', 'error');
        return;
    }
    if (newPass !== confirm) {
        showToast('كلمة المرور الجديدة غير متطابقة', 'error');
        return;
    }
    if (newPass.length < 6) {
        showToast('كلمة المرور يجب أن تكون 6 أحرف على الأقل', 'error');
        return;
    }

    var btn = document.getElementById('changePasswordBtn');
    btn.disabled = true;

    apiFetch('/api/profile/password', {
        method: 'PUT',
        body: JSON.stringify({
            current_password: current,
            password: newPass,
            password_confirmation: confirm
        })
    }).then(function(data) {
        if (data && data.success) {
            showToast('تم تغيير كلمة المرور بنجاح', 'success');
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        } else {
            showToast(data?.message || 'حدث خطأ في تغيير كلمة المرور', 'error');
        }
    }).catch(function(err) {
        showToast('حدث خطأ في الاتصال', 'error');
    }).finally(function() {
        btn.disabled = false;
    });
}

function showToast(message, type) {
    type = type || 'info';
    var existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();
    var colors = { success: 'linear-gradient(135deg, #10b981, #059669)', error: 'linear-gradient(135deg, #ef4444, #dc2626)', info: 'linear-gradient(135deg, #3b82f6, #2563eb)' };
    var toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = 'position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: ' + (colors[type] || colors.info) + '; color: white; padding: 14px 24px; border-radius: 12px; font-size: 14px; font-weight: 600; z-index: 100000; box-shadow: 0 10px 30px rgba(0,0,0,0.2); min-width: 280px; text-align: center; font-family: inherit;';
    toast.innerHTML = '<i class="fas fa-' + (type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle') + '" style="margin-left: 8px;"></i>' + message;
    document.body.appendChild(toast);
    setTimeout(function() { toast.remove(); }, 3000);
}
</script>
@endsection
