// ========== Grant Tables - API Based ==========
let currentCancelId = null;
let currentRejectId = null;
let outgoingGrants = [];
let incomingGrants = [];

const csrfTokenManh = document.querySelector('meta[name="csrf-token"]')?.content;

function manhApiFetch(url, options = {}) {
    const defaults = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfTokenManh,
        },
    };
    if (options.body && typeof options.body === 'object') {
        options.body = JSON.stringify(options.body);
    }
    return fetch('/api' + url, { ...defaults, ...options })
        .then(r => r.json())
        .catch(err => {
            console.error('API Error:', err);
            return { success: false, message: 'خطأ في الاتصال' };
        });
}

// تحميل البيانات من API
async function loadGrantsFromAPI() {
    // Load sent grants
    const sentData = await manhApiFetch('/grants?type=sent');
    if (sentData.success) {
        outgoingGrants = sentData.grants;
    }

    // Load received grants
    const recvData = await manhApiFetch('/grants?type=received');
    if (recvData.success) {
        incomingGrants = recvData.grants;
    }

    loadOutgoingTable();
    loadIncomingTable();
}

// تحميل البيانات عند بدء التشغيل
document.addEventListener('DOMContentLoaded', function() {
    loadGrantsFromAPI();
});

// تحميل جدول الحالات الصادرة
function loadOutgoingTable() {
    const tbody = document.getElementById('outgoingManhTableBody');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (outgoingGrants.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:20px;color:#94a3b8;">لا توجد حالات ممنوحة</td></tr>';
        return;
    }

    outgoingGrants.forEach(grant => {
        const c = grant.dental_case || {};
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${grant.created_at ? new Date(grant.created_at).toLocaleDateString('ar-SA') : '-'}</td>
            <td>${c.patient?.full_name || '-'}</td>
            <td>${c.tooth_number || '-'}</td>
            <td>${c.treatment_label || c.treatment_type || '-'}</td>
            <td>${c.course?.name || '-'}</td>
            <td>${grant.grantee?.name || '-'} (${grant.grantee?.student_id || ''})</td>
            <td><span class="status-badge status-${grant.status}">${getStatusLabel(grant.status)}</span></td>
            <td>${grant.responded_at ? new Date(grant.responded_at).toLocaleDateString('ar-SA') : '-'}</td>
            <td>
                <div class="action-buttons">
                    ${grant.status === 'pending' ? `
                        <button onclick="openCancelManhModal(${grant.id})" class="action-btn btn-cancel">
                            <i class="fas fa-ban"></i> إلغاء
                        </button>
                    ` : '-'}
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// تحميل جدول الحالات الواردة
function loadIncomingTable() {
    const tbody = document.getElementById('incomingManhTableBody');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (incomingGrants.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:20px;color:#94a3b8;">لا توجد حالات واردة</td></tr>';
        return;
    }

    incomingGrants.forEach(grant => {
        const c = grant.dental_case || {};
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${grant.created_at ? new Date(grant.created_at).toLocaleDateString('ar-SA') : '-'}</td>
            <td>${c.patient?.full_name || '-'}</td>
            <td>${c.tooth_number || '-'}</td>
            <td>${c.treatment_label || c.treatment_type || '-'}</td>
            <td>${c.course?.name || '-'}</td>
            <td>${grant.granter?.name || '-'} (${grant.granter?.student_id || ''})</td>
            <td><span class="status-badge status-${grant.status}">${getStatusLabel(grant.status)}</span></td>
            <td>
                <div class="action-buttons">
                    ${grant.status === 'pending' ? `
                        <button onclick="acceptManh(${grant.id})" class="action-btn btn-accept">
                            <i class="fas fa-check"></i> قبول
                        </button>
                        <button onclick="openRejectModal(${grant.id})" class="action-btn btn-reject">
                            <i class="fas fa-times"></i> رفض
                        </button>
                    ` : '-'}
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// الحصول على اسم الحالة
function getStatusLabel(status) {
    const labels = {
        'pending': '<i class="fas fa-clock"></i> في الانتظار',
        'accepted': '<i class="fas fa-check-circle"></i> مقبول',
        'rejected': '<i class="fas fa-times-circle"></i> مرفوض',
        'cancelled': '<i class="fas fa-ban"></i> ملغي'
    };
    return labels[status] || status;
}

// فتح مودال إلغاء المنح
function openCancelManhModal(id) {
    currentCancelId = id;
    const grant = outgoingGrants.find(r => r.id === id);
    if (grant) {
        const c = grant.dental_case || {};
        const el1 = document.getElementById('manhTblCancelPatientName');
        const el2 = document.getElementById('manhTblCancelToothNumber');
        const el3 = document.getElementById('manhTblCancelRecipient');
        if (el1) el1.textContent = c.patient?.full_name || '-';
        if (el2) el2.textContent = c.tooth_number || '-';
        if (el3) el3.textContent = grant.grantee?.name || '-';
    }
    const reasonEl = document.getElementById('manhTblCancelReasonText');
    const errorEl = document.getElementById('manhTblCancelReasonError');
    if (reasonEl) reasonEl.value = '';
    if (errorEl) errorEl.classList.remove('show');
    const modal = document.getElementById('manhTblCancelModal');
    if (modal) modal.classList.add('active');
}

function closeCancelManhModal() {
    const modal = document.getElementById('manhTblCancelModal');
    if (modal) modal.classList.remove('active');
    currentCancelId = null;
}

async function confirmCancelManh() {
    const reason = document.getElementById('manhTblCancelReasonText')?.value.trim();
    if (!reason) {
        const errorEl = document.getElementById('manhTblCancelReasonError');
        if (errorEl) errorEl.classList.add('show');
        return;
    }

    const result = await manhApiFetch(`/grants/${currentCancelId}/cancel`, {
        method: 'PUT',
        body: { reason },
    });

    closeCancelManhModal();

    if (result.success) {
        showToast('تم إلغاء المنح بنجاح', 'success');
        loadGrantsFromAPI();
    } else {
        showToast(result.message || 'حدث خطأ', 'error');
    }
}

// فتح مودال الرفض
function openRejectModal(id) {
    currentRejectId = id;
    const grant = incomingGrants.find(r => r.id === id);
    if (grant) {
        const c = grant.dental_case || {};
        const el1 = document.getElementById('manhTblRejectPatientName');
        const el2 = document.getElementById('manhTblRejectToothNumber');
        if (el1) el1.textContent = c.patient?.full_name || '-';
        if (el2) el2.textContent = c.tooth_number || '-';
    }
    const reasonEl = document.getElementById('manhTblRejectReasonText');
    const errorEl = document.getElementById('manhTblRejectReasonError');
    if (reasonEl) reasonEl.value = '';
    if (errorEl) errorEl.classList.remove('show');
    const modal = document.getElementById('manhTblRejectModal');
    if (modal) modal.classList.add('active');
}

function closeRejectModal() {
    const modal = document.getElementById('manhTblRejectModal');
    if (modal) modal.classList.remove('active');
    currentRejectId = null;
}

async function confirmReject() {
    const result = await manhApiFetch(`/grants/${currentRejectId}/reject`, {
        method: 'PUT',
    });

    closeRejectModal();

    if (result.success) {
        showToast('تم رفض الحالة', 'success');
        loadGrantsFromAPI();
    } else {
        showToast(result.message || 'حدث خطأ', 'error');
    }
}

// قبول الحالة
async function acceptManh(id) {
    if (confirm('هل أنت متأكد من قبول هذه الحالة؟')) {
        const result = await manhApiFetch(`/grants/${id}/accept`, {
            method: 'PUT',
        });

        if (result.success) {
            showToast('تم قبول الحالة بنجاح', 'success');
            loadGrantsFromAPI();
        } else {
            showToast(result.message || 'حدث خطأ', 'error');
        }
    }
}

// Toast notification
function showToast(message, type = 'info') {
    if (typeof window.showToast === 'function' && window.showToast !== showToast) {
        window.showToast(message, type);
        return;
    }
    const existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `position:fixed;top:100px;left:50%;transform:translateX(-50%);padding:14px 24px;border-radius:10px;color:white;font-weight:600;z-index:100000;box-shadow:0 10px 30px rgba(0,0,0,0.2);min-width:280px;text-align:center;font-size:14px;`;

    const colors = {
        success: 'linear-gradient(135deg, #10b981, #059669)',
        error: 'linear-gradient(135deg, #ef4444, #dc2626)',
        info: 'linear-gradient(135deg, #3b82f6, #2563eb)'
    };

    toast.style.background = colors[type] || colors.info;
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    toast.innerHTML = `<i class="fas ${icon}" style="margin-left:8px;"></i>${message}`;

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// إغلاق المودال عند النقر خارج المحتوى
document.addEventListener('click', function(e) {
    const cancelModal = document.getElementById('manhTblCancelModal');
    const rejectModal = document.getElementById('manhTblRejectModal');

    if (e.target === cancelModal) closeCancelManhModal();
    if (e.target === rejectModal) closeRejectModal();
});
