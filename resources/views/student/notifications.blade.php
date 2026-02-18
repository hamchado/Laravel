@extends('layouts.app')

@section('title', 'الإشعارات')
@section('page_title', 'الإشعارات')

@section('content')
<div class="header" style="text-align: center; margin-bottom: 28px; position: relative;">
    <div style="position: absolute; top: -30px; left: 50%; transform: translateX(-50%); width: 120px; height: 120px;
                background: linear-gradient(145deg, rgba(79, 70, 229, 0.08), rgba(236, 72, 153, 0.05));
                border-radius: 50%; filter: blur(30px); z-index: -1;"></div>
    <div style="display: inline-flex; align-items: center; justify-content: center; width: 60px; height: 60px;
                background: linear-gradient(145deg, var(--primary), var(--primary-light)); border-radius: 16px;
                margin-bottom: 16px; box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);">
        <i class="fas fa-bell" style="color: white; font-size: 24px;"></i>
    </div>
    <h1 style="font-size: 24px; color: var(--dark); margin-bottom: 10px; font-weight: 700; letter-spacing: -0.5px;">الإشعارات</h1>
    <p style="color: var(--gray); font-size: 14px;">آخر التحديثات والأنشطة</p>
</div>

<!-- إحصائيات سريعة -->
<div style="display: flex; gap: 14px; margin-bottom: 24px;">
    <div style="flex: 1; background: white; border-radius: var(--radius); padding: 18px; text-align: center; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.06); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -10px; right: -10px; width: 40px; height: 40px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), transparent); border-radius: 50%;"></div>
        <div id="totalNotifCount" style="font-size: 26px; font-weight: 800; color: var(--primary); margin-bottom: 6px;">5</div>
        <div style="font-size: 13px; color: var(--gray); font-weight: 500;">إجمالي الإشعارات</div>
    </div>
    <div style="flex: 1; background: white; border-radius: var(--radius); padding: 18px; text-align: center; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.06); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -10px; right: -10px; width: 40px; height: 40px; background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), transparent); border-radius: 50%;"></div>
        <div id="unreadNotifCount" style="font-size: 26px; font-weight: 800; color: var(--accent); margin-bottom: 6px;">3</div>
        <div style="font-size: 13px; color: var(--gray); font-weight: 500;">غير مقروء</div>
    </div>
</div>

<!-- خط فاصل -->
<div class="section-divider"></div>

<!-- إشعارات تغيير الرقم من الملف الشخصي -->
<div id="profileNotificationsSection" style="display: none; margin-bottom: 20px;">
    <div class="input-container" style="padding: 0; overflow: hidden; border: 1.5px solid rgba(16, 185, 129, 0.2);">
        <div class="section-title" style="padding: 16px 20px 14px; margin: 0; border-bottom: 1px solid rgba(16, 185, 129, 0.1); background: rgba(16, 185, 129, 0.03);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05)); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-mobile-alt" style="color: var(--secondary); font-size: 14px;"></i>
                </div>
                <span style="color: var(--secondary); font-weight: 700;">إشعارات الحساب</span>
            </div>
        </div>
        <div id="profileNotificationsList"></div>
    </div>
</div>

<!-- خط فاصل -->
<div class="section-divider"></div>

<!-- قائمة الإشعارات -->
<div class="input-container" style="padding: 0; overflow: hidden;">
    <div class="section-title" style="padding: 20px 20px 16px; margin: 0; border-bottom: 1px solid #f3f4f6;">
        <i class="fas fa-bell"></i>
        <span>الإشعارات الحديثة</span>
    </div>
    
    <div style="max-height: 500px; overflow-y: auto;">
        <!-- إشعار 1 - غير مقروء -->
        <div class="notification-item unread notification-info">
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
                    تذكير: موعد تسليم واجب مادة الرياضيات غداً الساعة 10:00 صباحاً
                </div>
                <div class="notification-course">الرياضيات - د. أحمد محمد</div>
            </div>
        </div>
        
        <div class="notification-divider"></div>
        
        <!-- إشعار 2 - مقروء -->
        <div class="notification-item notification-success">
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
                    تم تسليم واجب مادة الفيزياء بنجاح. يمكنك الاطلاع على الدرجة لاحقاً
                </div>
                <div class="notification-course">الفيزياء - أ. سارة عبدالله</div>
            </div>
        </div>
        
        <div class="notification-divider"></div>
        
        <!-- إشعار 3 - غير مقروء -->
        <div class="notification-item unread notification-warning">
            <div class="notification-header">
                <div class="notification-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div style="flex: 1;">
                    <div class="notification-title">تغيير في الجدول</div>
                    <div class="notification-time">قبل يوم واحد</div>
                </div>
            </div>
            <div class="notification-body">
                <div class="notification-text">
                    تم تغيير موعد محاضرة مادة الكيمياء من يوم الأحد إلى يوم الثلاثاء في نفس الوقت
                </div>
                <div class="notification-course">الكيمياء - د. خالد حسن</div>
            </div>
        </div>
        
        <div class="notification-divider"></div>
        
        <!-- إشعار 4 - مقروء -->
        <div class="notification-item">
            <div class="notification-header">
                <div style="width: 36px; height: 36px; border-radius: var(--radius-sm); 
                          background: rgba(79, 70, 229, 0.1); color: var(--primary);
                          display: flex; align-items: center; justify-content: center; 
                          margin-left: 12px;">
                    <i class="fas fa-book"></i>
                </div>
                <div style="flex: 1;">
                    <div class="notification-title">مادة جديدة مضافة</div>
                    <div class="notification-time">قبل يومين</div>
                </div>
            </div>
            <div class="notification-body">
                <div class="notification-text">
                    تم إضافة مادة جديدة إلى جدولك: "مقدمة في البرمجة" مع المحاضر د. عمر علي
                </div>
                <div class="notification-course">البرمجة - د. عمر علي</div>
            </div>
        </div>
        
        <div class="notification-divider"></div>
        
        <!-- إشعار 5 - غير مقروء -->
        <div class="notification-item unread">
            <div class="notification-header">
                <div style="width: 36px; height: 36px; border-radius: var(--radius-sm); 
                          background: rgba(236, 72, 153, 0.1); color: var(--accent);
                          display: flex; align-items: center; justify-content: center; 
                          margin-left: 12px;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div style="flex: 1;">
                    <div class="notification-title">اختبار قادم</div>
                    <div class="notification-time">قبل 3 أيام</div>
                </div>
            </div>
            <div class="notification-body">
                <div class="notification-text">
                    اختبار نصفي في مادة اللغة الإنجليزية يوم الأربعاء القادم الساعة 9:00 صباحاً
                </div>
                <div class="notification-course">الإنجليزية - أ. لينا محمود</div>
            </div>
        </div>
    </div>
    
    <div style="padding: 16px 20px; border-top: 1px solid #f3f4f6;">
        <div style="font-size: 14px; color: var(--gray); text-align: center;">
            <i class="fas fa-check-circle" style="margin-left: 6px; color: var(--secondary);"></i>
            تم تحميل 5 إشعارات
        </div>
    </div>
</div>

<!-- خط فاصل -->
<div class="section-divider"></div>

<!-- أزرار الإجراءات -->
<div style="display: flex; gap: 14px;">
    <button style="flex: 1; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none;
                   font-weight: 600; padding: 16px; border-radius: var(--radius); cursor: pointer; display: flex; align-items: center; justify-content: center;
                   box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25); transition: all 0.2s;"
            onclick="markAllAsRead()">
        <i class="fas fa-check-double" style="margin-left: 10px;"></i>
        تعيين الكل كمقروء
    </button>
    <button style="flex: 1; background: white; color: var(--gray-dark);
                   border: 2px solid #e5e7eb; padding: 16px; border-radius: var(--radius); cursor: pointer; display: flex; align-items: center; justify-content: center;
                   transition: all 0.2s; font-weight: 600;"
            onclick="clearNotifications()">
        <i class="fas fa-trash-alt" style="margin-left: 10px;"></i>
        مسح الإشعارات
    </button>
</div>

<script>
function markAllAsRead() {
    showLoading();
    
    setTimeout(() => {
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
            item.style.borderRight = '1px solid #e5e7eb';
        });
        
        // تحديث العداد
        const badge = document.querySelector('.notification-badge');
        if (badge) badge.textContent = '0';
        
        hideLoading();
        
        // إشعار نجاح
        const successDiv = document.createElement('div');
        successDiv.innerHTML = `
            <div style="position: fixed; top: 70px; right: 16px; left: 16px; 
                       background: var(--secondary); color: white; padding: 12px 16px; 
                       border-radius: var(--radius); z-index: 1000; text-align: center;
                       animation: modalIn 0.3s ease; font-weight: 500;">
                <i class="fas fa-check-circle" style="margin-left: 8px;"></i>
                تم تعيين جميع الإشعارات كمقروءة
            </div>
        `;
        document.body.appendChild(successDiv);
        
        setTimeout(() => {
            successDiv.remove();
        }, 3000);
    }, 800);
}

function clearNotifications() {
    if (confirm('هل تريد مسح جميع الإشعارات؟ هذا الإجراء لا يمكن التراجع عنه.')) {
        showLoading();
        
        setTimeout(() => {
            const notificationsContainer = document.querySelector('.notification-item').parentNode;
            notificationsContainer.innerHTML = `
                <div style="padding: 40px 20px; text-align: center;">
                    <div style="width: 60px; height: 60px; background: var(--gray-light); 
                              border-radius: 50%; display: flex; align-items: center; 
                              justify-content: center; margin: 0 auto 16px;">
                        <i class="fas fa-inbox" style="font-size: 24px; color: var(--gray);"></i>
                    </div>
                    <div style="font-size: 16px; font-weight: 600; color: var(--dark); margin-bottom: 8px;">
                        لا توجد إشعارات
                    </div>
                    <div style="font-size: 14px; color: var(--gray);">
                        ستظهر الإشعارات الجديدة هنا عند وصولها
                    </div>
                </div>
            `;
            
            // تحديث العداد
            const badge = document.querySelector('.notification-badge');
            if (badge) badge.style.display = 'none';
            
            hideLoading();
        }, 800);
    }
}

// عند النقر على إشعار
document.addEventListener('DOMContentLoaded', function() {
    // تحميل إشعارات الملف الشخصي
    loadProfileNotifications();

    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function() {
            if (this.classList.contains('unread')) {
                this.classList.remove('unread');
                this.style.borderRight = '1px solid #e5e7eb';

                // تحديث العداد
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    const currentCount = parseInt(badge.textContent);
                    if (currentCount > 0) {
                        badge.textContent = (currentCount - 1).toString();
                    }
                }

                updateNotificationCounts();
            }
        });
    });
});

function loadProfileNotifications() {
    const notifications = JSON.parse(localStorage.getItem('profileNotifications') || '[]');
    const section = document.getElementById('profileNotificationsSection');
    const list = document.getElementById('profileNotificationsList');

    if (notifications.length > 0) {
        section.style.display = 'block';
        let html = '';

        notifications.forEach(notif => {
            const timeAgo = getTimeAgoLocal(notif.time);
            html += `
                <div class="notification-item ${notif.read ? '' : 'unread'} notification-success" onclick="markProfileNotifRead('${notif.id}', this)" style="border-right: ${notif.read ? '1px solid #e5e7eb' : '3px solid var(--secondary)'};">
                    <div class="notification-header">
                        <div class="notification-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">${notif.title}</div>
                            <div class="notification-time">${timeAgo}</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <div class="notification-text">${notif.message}</div>
                        <div class="notification-course" style="background: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                            <i class="fas fa-user-circle" style="margin-left: 4px;"></i>
                            الملف الشخصي
                        </div>
                    </div>
                </div>
                <div class="notification-divider"></div>
            `;
        });

        list.innerHTML = html;
        updateNotificationCounts();
    }
}

function markProfileNotifRead(id, element) {
    const notifications = JSON.parse(localStorage.getItem('profileNotifications') || '[]');
    const notif = notifications.find(n => n.id == id);

    if (notif && !notif.read) {
        notif.read = true;
        localStorage.setItem('profileNotifications', JSON.stringify(notifications));
        element.classList.remove('unread');
        element.style.borderRight = '1px solid #e5e7eb';

        const badge = document.querySelector('.notification-badge');
        if (badge) {
            const currentCount = parseInt(badge.textContent) || 0;
            if (currentCount > 0) {
                badge.textContent = (currentCount - 1).toString();
            }
        }

        updateNotificationCounts();
    }
}

function getTimeAgoLocal(dateString) {
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

function updateNotificationCounts() {
    const profileNotifs = JSON.parse(localStorage.getItem('profileNotifications') || '[]');
    const unreadProfile = profileNotifs.filter(n => !n.read).length;
    const unreadRegular = document.querySelectorAll('.notification-item.unread').length - unreadProfile;

    const total = 5 + profileNotifs.length;
    const unread = 3 + unreadProfile;

    document.getElementById('totalNotifCount').textContent = total;
    document.getElementById('unreadNotifCount').textContent = unread;
}
</script>
@endsection
