// ========== API Helper ==========
function apiFetch(url, options = {}) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const defaults = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    };
    const merged = { ...defaults, ...options };
    if (options.headers) {
        merged.headers = { ...defaults.headers, ...options.headers };
    }
    return fetch(url, merged).then(function(res) {
        if (res.status === 401) {
            window.location.href = '/login';
            throw new Error('Unauthorized');
        }
        return res.json();
    });
}

// ========== بيانات النظام ==========
let currentUser = null;
let patients = [];
let courses = [];

// متغيرات عامة
let currentFilter = 'all';
let selectedPatientForTemp = null;
let selectedCourseId = null;

// ========== تهيئة الصفحة ==========
document.addEventListener('DOMContentLoaded', function() {
    loadCurrentUser()
        .then(function() {
            return Promise.all([loadPatients(), loadCourses()]);
        })
        .then(function() {
            renderPatientsList();
            updateCounts();
        })
        .catch(function(err) {
            console.error('Error initializing:', err);
        });
});

// ========== تحميل بيانات المستخدم ==========
function loadCurrentUser() {
    return apiFetch('/api/user').then(function(data) {
        if (data.success) {
            currentUser = data.user;
        }
    });
}

// ========== تحميل المرضى من API ==========
function loadPatients() {
    return apiFetch('/api/patients').then(function(data) {
        if (data.success) {
            patients = data.patients || [];
        }
    });
}

// ========== تحميل المقررات من API ==========
function loadCourses() {
    return apiFetch('/api/courses').then(function(data) {
        if (data.success) {
            courses = data.courses || [];
        }
    });
}

// ========== عرض قائمة المرضى ==========
function renderPatientsList() {
    const container = document.getElementById('allPatientsList');
    if (!container) return;

    container.innerHTML = '';

    let filteredPatients = patients;

    // تطبيق الفلتر
    if (currentFilter === 'private') {
        filteredPatients = patients.filter(function(p) { return p.access_type === 'private'; });
    } else if (currentFilter === 'public') {
        filteredPatients = patients.filter(function(p) { return p.access_type === 'public'; });
    }

    // تطبيق البحث
    const searchTerm = (document.getElementById('allPatientSearch')?.value || '').toLowerCase();
    if (searchTerm) {
        filteredPatients = filteredPatients.filter(function(p) {
            return (p.full_name || '').toLowerCase().includes(searchTerm) ||
                   (p.record_number || '').toLowerCase().includes(searchTerm) ||
                   (p.phone || '').includes(searchTerm);
        });
    }

    if (filteredPatients.length === 0) {
        container.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #9ca3af;">' +
            '<i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>' +
            '<p>لا يوجد مرضى مطابقين للبحث</p></div>';
        return;
    }

    filteredPatients.forEach(function(patient, index) {
        var card = createPatientCard(patient, index);
        container.appendChild(card);
    });
}

function createPatientCard(patient, index) {
    var card = document.createElement('div');

    // تحديد حالة الحجز
    var reservation = getMyReservation(patient);
    var isMyReserved = !!reservation;
    var isConfirmed = reservation && reservation.status === 'confirmed';
    var isTemp = reservation && reservation.status === 'temporary';
    var isReservedByOthers = !isMyReserved && patient.is_reserved;

    card.className = 'patient-card' + (isMyReserved ? ' frozen' : '');
    card.style.animation = 'fadeIn 0.3s ease forwards ' + (index * 0.1) + 's';

    // شارة الحجز
    var reservedBadge = '';
    if (isConfirmed) {
        reservedBadge = '<div class="frozen-badge" style="background: linear-gradient(135deg, #10b981, #059669);">' +
            '<i class="fas fa-check-double"></i> حجز مثبت</div>';
    } else if (isTemp) {
        reservedBadge = '<div class="frozen-badge"><i class="fas fa-snowflake"></i> محجوز مؤقتاً</div>';
    }

    // شارة النوع
    var typeBadge = '<div class="patient-type-badge ' + (patient.access_type || 'public') + '">' +
        (patient.access_type === 'private' ? '<i class="fas fa-lock"></i> خاص' : '<i class="fas fa-globe"></i> عام') +
        '</div>';

    // أزرار التحكم
    var actionButtons = '';
    if (isConfirmed) {
        var courseCode = reservation ? getCourseCode(reservation.course_id) : '';
        actionButtons = '<button class="btn-action btn-view" onclick="viewPatientDetails(' + patient.id + ')">' +
            '<i class="fas fa-eye"></i> عرض التفاصيل والأسنان</button>' +
            '<button class="btn-action btn-confirmed" disabled style="background: linear-gradient(135deg, #10b981, #059669); color: white; opacity: 1; cursor: default;">' +
            '<i class="fas fa-check-double"></i> مثبت (' + courseCode + ')</button>';
    } else if (isTemp) {
        actionButtons = '<button class="btn-action btn-confirm-reserve" onclick="confirmReservation(' + reservation.id + ')" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none;">' +
            '<i class="fas fa-check-circle"></i> تثبيت الحجز (' + getCourseCode(reservation.course_id) + ')</button>' +
            '<button class="btn-action btn-cancel-reserve" onclick="cancelTempReservation(' + reservation.id + ')" style="margin-top: 4px;">' +
            '<i class="fas fa-times-circle"></i> إلغاء الحجز</button>';
    } else if (isReservedByOthers) {
        actionButtons = '<button class="btn-action btn-view" onclick="viewPatientDetails(' + patient.id + ')">' +
            '<i class="fas fa-eye"></i> عرض التفاصيل</button>' +
            '<button class="btn-action btn-reserve" disabled style="opacity: 0.5; cursor: not-allowed;">' +
            '<i class="fas fa-lock"></i> محجوز لطالب آخر</button>';
    } else {
        actionButtons = '<button class="btn-action btn-view" onclick="viewPatientDetails(' + patient.id + ')">' +
            '<i class="fas fa-eye"></i> عرض التفاصيل</button>' +
            '<button class="btn-action btn-reserve" onclick="openTempReservationModal(' + patient.id + ')">' +
            '<i class="fas fa-clock"></i> حجز مؤقت</button>';
    }

    card.innerHTML = reservedBadge + typeBadge +
        '<div class="patient-card-header">' +
            '<div class="patient-name">' + (patient.full_name || '') + '</div>' +
            '<div class="patient-record"><i class="fas fa-hashtag" style="font-size: 10px;"></i> ' + (patient.record_number || '') + '</div>' +
        '</div>' +
        '<div class="patient-info-grid">' +
            '<div class="patient-info-item age"><i class="fas fa-birthday-cake"></i><span>' + (patient.age || 0) + ' سنة</span></div>' +
            '<div class="patient-info-item phone"><i class="fas fa-phone"></i><span style="direction: ltr; display: inline-block;">' + (patient.phone || '') + '</span></div>' +
        '</div>' +
        '<div class="patient-card-actions">' + actionButtons + '</div>';

    return card;
}

// ========== وظائف مساعدة ==========
function getMyReservation(patient) {
    if (!patient.reservations) return null;
    return patient.reservations.find(function(r) {
        return r.user_id === (currentUser ? currentUser.id : 0) &&
               (r.status === 'temporary' || r.status === 'confirmed');
    }) || null;
}

function getCourseCode(courseId) {
    var course = courses.find(function(c) { return c.id === courseId; });
    return course ? course.code : '';
}

function getCourseName(courseId) {
    var course = courses.find(function(c) { return c.id === courseId; });
    return course ? course.name : '';
}

// ========== فلاتر البحث ==========
function filterAllPatients(filter) {
    currentFilter = filter;
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });
    if (event && event.target) event.target.classList.add('active');
    renderPatientsList();
}

function searchAllPatients(value) {
    renderPatientsList();
}

function updateCounts() {
    var all = patients.length;
    var privateCount = patients.filter(function(p) { return p.access_type === 'private'; }).length;
    var publicCount = patients.filter(function(p) { return p.access_type === 'public'; }).length;

    var countAll = document.getElementById('countAll');
    var countPrivate = document.getElementById('countPrivate');
    var countPublic = document.getElementById('countPublic');

    if (countAll) countAll.textContent = all;
    if (countPrivate) countPrivate.textContent = privateCount;
    if (countPublic) countPublic.textContent = publicCount;
}

// ========== الحجز المؤقت ==========
function openTempReservationModal(patientId) {
    var patient = patients.find(function(p) { return p.id === patientId; });
    if (!patient) return;

    // التحقق إذا كان المريض محجوزاً عندي
    var existing = getMyReservation(patient);
    if (existing) {
        showToast('هذا المريض محجوز مؤقتاً عندك بالفعل! يمكنك إلغاء الحجز السابق أولاً.', 'warning');
        return;
    }

    selectedPatientForTemp = patient;
    selectedCourseId = null;

    document.getElementById('tempPatientName').textContent = patient.full_name || '';
    document.getElementById('tempPatientAge').textContent = (patient.age || 0) + ' سنة';

    renderCourseOptions();

    document.getElementById('sessionDetails').style.display = 'none';
    document.getElementById('frozenWarning').style.display = 'none';
    document.getElementById('tempReservationModal').style.display = 'flex';
}

function renderCourseOptions() {
    var container = document.getElementById('courseOptions');
    if (!container) return;
    container.innerHTML = '';

    courses.forEach(function(course) {
        var isFull = course.current_reserved >= course.max_reservations;
        var remaining = course.max_reservations - course.current_reserved;

        var option = document.createElement('div');
        option.className = 'course-option';
        option.style.opacity = isFull ? '0.5' : '1';
        option.style.cursor = isFull ? 'not-allowed' : 'pointer';

        option.innerHTML = '<div class="course-option-header">' +
            '<span style="background: rgba(79, 70, 229, 0.1); color: #4f46e5; padding: 2px 8px; border-radius: 6px; font-size: 12px;">' + course.code + '</span>' +
            '<span>' + course.name + '</span></div>' +
            '<div class="course-option-meta">' +
            '<i class="fas fa-clock"></i> ' + (course.schedule || '') + ' | ' +
            '<i class="fas fa-hospital"></i> ' + (course.location || '') + ' | ' +
            '<span style="' + (remaining > 0 ? 'color: #10b981;' : 'color: #ef4444;') + '">' +
            (isFull ? 'السقف ممتلئ' : 'متبقي ' + remaining + ' من ' + course.max_reservations) +
            '</span></div>';

        if (!isFull) {
            option.onclick = function() { selectCourse(course.id); };
        }

        container.appendChild(option);
    });
}

function toggleCourseDropdown() {
    var options = document.getElementById('courseOptions');
    var icon = document.getElementById('courseDropdownIcon');
    if (options.style.display === 'none') {
        options.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
    } else {
        options.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}

function selectCourse(courseId) {
    var course = courses.find(function(c) { return c.id === courseId; });
    if (!course) return;

    selectedCourseId = courseId;

    document.getElementById('selectedCourseText').innerHTML =
        '<span style="background: rgba(79, 70, 229, 0.1); color: #4f46e5; padding: 2px 8px; border-radius: 6px; font-size: 12px; margin-left: 6px;">' + course.code + '</span>' +
        course.name;

    document.getElementById('courseOptions').style.display = 'none';
    document.getElementById('courseDropdownIcon').style.transform = 'rotate(0deg)';

    var detailsDiv = document.getElementById('sessionDetails');
    detailsDiv.style.display = 'block';

    document.getElementById('sessionTime').textContent = course.schedule || '';
    document.getElementById('sessionLocation').textContent = course.location || '';
    document.getElementById('sessionSupervisors').textContent = course.supervisors || '';

    var remaining = course.max_reservations - (course.current_reserved || 0);
    var quotaText = document.getElementById('sessionQuota');
    quotaText.textContent = 'السقف المتبقي: ' + remaining + ' من ' + course.max_reservations;
    quotaText.style.color = remaining > 0 ? '#059669' : '#dc2626';
}

function confirmTempReservation() {
    if (!selectedCourseId) {
        showToast('الرجاء اختيار المقرر أولاً', 'error');
        return;
    }
    if (!selectedPatientForTemp) return;

    var btn = document.getElementById('confirmTempBtn');
    if (btn) btn.disabled = true;

    apiFetch('/api/reservations', {
        method: 'POST',
        body: JSON.stringify({
            patient_id: selectedPatientForTemp.id,
            course_id: selectedCourseId
        })
    }).then(function(data) {
        if (data.success) {
            closeTempReservationModal();
            showToast('تم الحجز المؤقت بنجاح! لديك 24 ساعة لتثبيت الحجز.', 'success');
            // إعادة تحميل البيانات
            Promise.all([loadPatients(), loadCourses()]).then(function() {
                renderPatientsList();
                updateCounts();
            });
        } else {
            showToast(data.message || 'حدث خطأ أثناء الحجز', 'error');
        }
    }).catch(function(err) {
        console.error('Reservation error:', err);
        showToast('حدث خطأ في الاتصال', 'error');
    }).finally(function() {
        if (btn) btn.disabled = false;
    });
}

function closeTempReservationModal() {
    document.getElementById('tempReservationModal').style.display = 'none';
    selectedPatientForTemp = null;
    selectedCourseId = null;
}

// ========== تثبيت الحجز ==========
function confirmReservation(reservationId) {
    apiFetch('/api/reservations/' + reservationId + '/confirm', {
        method: 'PUT'
    }).then(function(data) {
        if (data.success) {
            showToast('تم تثبيت الحجز بنجاح! المريض أصبح متاحاً في صفحة إضافة الحالات.', 'success');
            Promise.all([loadPatients(), loadCourses()]).then(function() {
                renderPatientsList();
                updateCounts();
            });
        } else {
            showToast(data.message || 'حدث خطأ أثناء تثبيت الحجز', 'error');
        }
    }).catch(function(err) {
        console.error('Confirm error:', err);
        showToast('حدث خطأ في الاتصال', 'error');
    });
}

// ========== إلغاء الحجز المؤقت ==========
function cancelTempReservation(reservationId) {
    apiFetch('/api/reservations/' + reservationId + '/cancel', {
        method: 'PUT',
        body: JSON.stringify({ reason: 'إلغاء يدوي من صفحة المرضى' })
    }).then(function(data) {
        if (data.success) {
            showToast('تم إلغاء الحجز بنجاح', 'info');
            Promise.all([loadPatients(), loadCourses()]).then(function() {
                renderPatientsList();
                updateCounts();
            });
        } else {
            showToast(data.message || 'حدث خطأ أثناء إلغاء الحجز', 'error');
        }
    }).catch(function(err) {
        console.error('Cancel error:', err);
        showToast('حدث خطأ في الاتصال', 'error');
    });
}

// ========== عرض التفاصيل ==========
function viewPatientDetails(patientId) {
    apiFetch('/api/patients/' + patientId).then(function(data) {
        if (!data.success || !data.patient) {
            showToast('لم يتم العثور على بيانات المريض', 'error');
            return;
        }

        var patient = data.patient;
        var reservation = getMyReservation(patient);

        // حالة الحجز
        var reservationHtml = '';
        if (reservation) {
            if (reservation.status === 'confirmed') {
                reservationHtml = '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;"><span style="color: #6b7280; font-size: 13px;">حالة الحجز:</span><span style="font-weight: 700; color: #059669;"><i class="fas fa-check-double"></i> حجز مثبت</span></div>';
                var courseName = getCourseName(reservation.course_id);
                if (courseName) {
                    reservationHtml += '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;"><span style="color: #6b7280; font-size: 13px;">المقرر:</span><span style="font-weight: 700; color: #1f2937;">' + courseName + '</span></div>';
                }
            } else if (reservation.status === 'temporary') {
                reservationHtml = '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;"><span style="color: #6b7280; font-size: 13px;">حالة الحجز:</span><span style="font-weight: 700; color: #8b5cf6;"><i class="fas fa-snowflake"></i> محجوز مؤقتاً عندك</span></div>';
            }
        }

        var content = document.getElementById('patientDetailsViewContent');
        content.innerHTML = '<div style="display: grid; gap: 12px;">' +
            '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">' +
                '<span style="color: #6b7280; font-size: 13px;">الاسم:</span>' +
                '<span style="font-weight: 700; color: #1f2937;">' + (patient.full_name || '') + '</span></div>' +
            '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">' +
                '<span style="color: #6b7280; font-size: 13px;">العمر:</span>' +
                '<span style="font-weight: 700; color: #1f2937;">' + (patient.age || 0) + ' سنة</span></div>' +
            '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">' +
                '<span style="color: #6b7280; font-size: 13px;">رقم الموبايل:</span>' +
                '<span style="font-weight: 700; color: #1f2937; direction: ltr;">' + (patient.phone || '') + '</span></div>' +
            '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">' +
                '<span style="color: #6b7280; font-size: 13px;">رقم السجل:</span>' +
                '<span style="font-weight: 700; color: #1f2937;">' + (patient.record_number || '') + '</span></div>' +
            '<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">' +
                '<span style="color: #6b7280; font-size: 13px;">النوع:</span>' +
                '<span style="font-weight: 700; color: ' + (patient.access_type === 'private' ? '#4f46e5' : '#059669') + ';">' +
                (patient.access_type === 'private' ? 'خاص (مخصص لي)' : 'عام (متاح للجميع)') + '</span></div>' +
            reservationHtml +
        '</div>';

        // قسم مخطط الأسنان
        var treatmentsList = document.getElementById('previousTreatmentsList');
        var fullDentalHtml = '';

        // مخطط الأسنان
        var teethData = patient.teeth || [];
        fullDentalHtml += '<div style="margin-bottom: 16px;">';
        fullDentalHtml += '<h4 style="font-size: 13px; color: #374151; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;"><i class="fas fa-teeth" style="color: #6366f1;"></i> مخطط الأسنان (FDI)</h4>';
        fullDentalHtml += buildReadOnlyTeethChart(teethData);
        fullDentalHtml += '</div>';

        // مخطط القلح
        var perioData = patient.perio || [];
        if (perioData.length > 0) {
            fullDentalHtml += '<div style="margin-bottom: 16px; padding-top: 12px; border-top: 1px solid #e5e7eb;">';
            fullDentalHtml += '<h4 style="font-size: 13px; color: #374151; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;"><i class="fas fa-teeth-open" style="color: #f59e0b;"></i> فحص القلح (حول سنية)</h4>';
            fullDentalHtml += buildReadOnlyPeriodontal(perioData);
            fullDentalHtml += '</div>';
        }

        // الحالة الصحية
        var healthData = patient.health;
        fullDentalHtml += '<div style="padding-top: 12px; border-top: 1px solid #e5e7eb;">';
        fullDentalHtml += '<h4 style="font-size: 13px; color: #374151; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;"><i class="fas fa-heartbeat" style="color: #ef4444;"></i> الحالة الصحية</h4>';
        fullDentalHtml += buildReadOnlyHealth(healthData);
        fullDentalHtml += '</div>';

        treatmentsList.innerHTML = fullDentalHtml;

        // إظهار زر المشاركة فقط للحالات الخاصة التي أنا صاحبها
        var shareSection = document.getElementById('shareSection');
        if (patient.access_type === 'private' && patient.added_by === (currentUser ? currentUser.id : 0)) {
            shareSection.style.display = 'block';
        } else {
            shareSection.style.display = 'none';
        }

        // تحميل صور البانوراما
        loadPanoramaImages(patientId);

        document.getElementById('patientDetailsViewModal').style.display = 'flex';
    }).catch(function(err) {
        console.error('Error loading patient details:', err);
        showToast('حدث خطأ في تحميل بيانات المريض', 'error');
    });
}

// ========== بناء مخطط الأسنان للقراءة فقط ==========
function buildReadOnlyTeethChart(teethData) {
    // teethData is an array from API: [{tooth_number, condition, label, is_primary}]
    if (!teethData || teethData.length === 0) {
        return '<div style="text-align: center; padding: 20px; color: #9ca3af; font-size: 13px;"><i class="fas fa-tooth" style="font-size: 24px; margin-bottom: 8px; opacity: 0.3; display: block;"></i>لا توجد بيانات أسنان مسجلة</div>';
    }

    // Convert array to map
    var teethMap = {};
    teethData.forEach(function(t) { teethMap[t.tooth_number] = t; });

    var conditionColors = {
        restorative: '#3b82f6', endodontic: '#f59e0b', extraction: '#ef4444', missing: '#6b7280'
    };
    var conditionLabels = {
        restorative: 'ترميمية', endodontic: 'لبية', extraction: 'قلع', missing: 'مفقود'
    };
    var conditionIcons = {
        restorative: 'fa-fill-drip', endodontic: 'fa-syringe', extraction: 'fa-tooth', missing: 'fa-minus-circle'
    };

    var permanentUpper = [18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28];
    var permanentLower = [48,47,46,45,44,43,42,41,31,32,33,34,35,36,37,38];
    var primaryUpper = [55,54,53,52,51,61,62,63,64,65];
    var primaryLower = [85,84,83,82,81,71,72,73,74,75];

    function renderToothRow(numbers, label) {
        var cells = numbers.map(function(num) {
            var data = teethMap[num];
            if (data) {
                var col = conditionColors[data.condition] || '#6b7280';
                return '<div style="width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 800; color: white; background: ' + col + '; box-shadow: 0 2px 4px ' + col + '50;" title="' + num + ': ' + (data.label || conditionLabels[data.condition] || '') + '">' + num + '</div>';
            } else {
                return '<div style="width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 600; color: #9ca3af; background: #f3f4f6; border: 1px solid #e5e7eb;">' + num + '</div>';
            }
        }).join('');
        return '<div style="margin-bottom: 4px;"><div style="font-size: 10px; color: #9ca3af; margin-bottom: 3px; text-align: center;">' + label + '</div><div style="display: flex; gap: 3px; justify-content: center; flex-wrap: wrap;">' + cells + '</div></div>';
    }

    var html = '<div style="background: #f9fafb; border-radius: 12px; padding: 12px; border: 1px solid #e5e7eb;">';
    html += renderToothRow(permanentUpper, 'الفك العلوي - الدائمة');
    html += '<div style="height: 1px; background: #e5e7eb; margin: 6px 0;"></div>';
    html += renderToothRow(permanentLower, 'الفك السفلي - الدائمة');

    var hasPrimary = primaryUpper.concat(primaryLower).some(function(n) { return teethMap[n]; });
    if (hasPrimary) {
        html += '<div style="height: 1px; background: #e5e7eb; margin: 8px 0;"></div>';
        html += renderToothRow(primaryUpper, 'العلوي - اللبنية');
        html += '<div style="height: 1px; background: #e5e7eb; margin: 6px 0;"></div>';
        html += renderToothRow(primaryLower, 'السفلي - اللبنية');
    }
    html += '</div>';

    // قائمة الأسنان المحددة
    if (teethData.length > 0) {
        html += '<div style="margin-top: 10px; display: flex; flex-direction: column; gap: 6px;">';
        teethData.sort(function(a, b) { return a.tooth_number - b.tooth_number; }).forEach(function(d) {
            var col = conditionColors[d.condition] || '#6b7280';
            var icon = conditionIcons[d.condition] || 'fa-tooth';
            var isPrimary = d.is_primary;
            html += '<div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: white; border-radius: 10px; border: 1px solid ' + col + '30;">';
            html += '<div style="display: flex; align-items: center; gap: 10px;">';
            html += '<div style="width: 32px; height: 32px; background: ' + col + '; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 800;">' + d.tooth_number + '</div>';
            html += '<div><div style="font-size: 13px; font-weight: 700; color: #1f2937;">' + (d.label || conditionLabels[d.condition]) + (isPrimary ? ' <span style="font-size: 10px; color: #f59e0b;">(مؤقت)</span>' : '') + '</div>';
            html += '<div style="font-size: 11px; color: #6b7280;"><i class="fas ' + icon + '" style="margin-left: 4px;"></i>' + (conditionLabels[d.condition] || '') + '</div></div>';
            html += '</div></div>';
        });
        html += '</div>';
    }

    return html;
}

// ========== بناء عرض القلح للقراءة فقط ==========
function buildReadOnlyPeriodontal(perioData) {
    // perioData is an array from API: [{segment, grade, pockets}]
    if (!perioData || perioData.length === 0) return '';

    var gradeNames = { healthy: 'سليم', mild: 'بسيط', moderate: 'متوسط', severe: 'شديد' };
    var gradeColors = { healthy: '#10b981', mild: '#f59e0b', moderate: '#f97316', severe: '#ef4444' };
    var segmentNames = {
        'upper-right': 'علوي يمين', 'upper-front': 'علوي أمامي', 'upper-left': 'علوي يسار',
        'lower-left': 'سفلي يسار', 'lower-front': 'سفلي أمامي', 'lower-right': 'سفلي يمين'
    };

    var html = '<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px;">';
    perioData.forEach(function(d) {
        var col = gradeColors[d.grade] || '#6b7280';
        html += '<div style="background: ' + col + '10; border: 1px solid ' + col + '30; border-radius: 8px; padding: 8px 10px;">';
        html += '<div style="font-size: 11px; color: #6b7280;">' + (segmentNames[d.segment] || d.segment) + '</div>';
        html += '<div style="font-size: 13px; font-weight: 700; color: ' + col + ';">' + (gradeNames[d.grade] || d.grade) + '</div>';
        if (d.pockets && d.pockets.length > 0) {
            var avg = (d.pockets.reduce(function(a, b) { return a + b; }, 0) / d.pockets.length).toFixed(1);
            html += '<div style="font-size: 10px; color: #9ca3af;">متوسط الجيب: ' + avg + ' مم</div>';
        }
        html += '</div>';
    });
    html += '</div>';
    return html;
}

// ========== بناء عرض الحالة الصحية للقراءة فقط ==========
function buildReadOnlyHealth(healthData) {
    if (!healthData) return '<div style="font-size: 12px; color: #9ca3af;">لا توجد بيانات صحية مسجلة</div>';

    var html = '';
    var diseases = healthData.diseases || [];
    if (diseases.length > 0) {
        html += '<div style="display: flex; flex-wrap: wrap; gap: 6px;">';
        diseases.forEach(function(disease) {
            html += '<span style="background: #fef2f2; color: #dc2626; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 600; border: 1px solid #fecaca;"><i class="fas fa-heartbeat" style="margin-left: 4px;"></i>' + disease + '</span>';
        });
        html += '</div>';
        if (healthData.diabetes_controlled !== null && healthData.diabetes_controlled !== undefined) {
            html += '<div style="font-size: 11px; color: #6b7280; margin-top: 6px;">السكري: ' + (healthData.diabetes_controlled ? '<span style="color: #10b981; font-weight: 600;">منضبط</span>' : '<span style="color: #ef4444; font-weight: 600;">غير منضبط</span>') + '</div>';
        }
        if (healthData.bp_controlled !== null && healthData.bp_controlled !== undefined) {
            html += '<div style="font-size: 11px; color: #6b7280; margin-top: 4px;">الضغط: ' + (healthData.bp_controlled ? '<span style="color: #10b981; font-weight: 600;">منضبط</span>' : '<span style="color: #ef4444; font-weight: 600;">غير منضبط</span>') + '</div>';
        }
    } else {
        html = '<div style="font-size: 12px; color: #9ca3af;">لا توجد أمراض مسجلة</div>';
    }
    return html;
}

// ========== صور البانوراما ==========
function loadPanoramaImages(patientId) {
    var container = document.getElementById('panoramaImagesList');
    if (!container) return;

    container.innerHTML = '<div style="text-align: center; padding: 20px; color: #9ca3af; font-size: 13px;">' +
        '<i class="fas fa-spinner fa-spin" style="font-size: 20px; margin-bottom: 8px; display: block;"></i>جاري التحميل...</div>';

    apiFetch('/api/patients/' + patientId + '/panorama').then(function(data) {
        if (!data.success || !data.images || data.images.length === 0) {
            container.innerHTML = '<div style="text-align: center; padding: 20px; color: #9ca3af; font-size: 13px;">' +
                '<i class="fas fa-x-ray" style="font-size: 24px; margin-bottom: 8px; opacity: 0.3; display: block;"></i>' +
                'لا توجد صور شعاعية مسجلة لهذا المريض</div>';
            return;
        }

        container.innerHTML = '';
        data.images.forEach(function(img) {
            var dateStr = img.taken_at ? new Date(img.taken_at).toLocaleDateString('ar-SA') : '';
            var uploaderName = img.uploader ? img.uploader.name : '';

            var card = document.createElement('div');
            card.style.cssText = 'background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;';
            card.innerHTML = '<div style="position: relative; cursor: pointer;" onclick="openPanoramaViewer(\'/storage/' + img.path + '\')">' +
                '<img src="/storage/' + img.path + '" onerror="this.src=\'https://placehold.co/400x200/f3f4f6/9ca3af?text=صورة+غير+متوفرة\'" ' +
                'style="width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block;">' +
                '<div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); padding: 20px 12px 8px;">' +
                '<div style="color: white; font-size: 12px; font-weight: 600;">' +
                (img.notes || 'صورة بانوراما') + '</div></div></div>' +
                '<div style="padding: 8px 12px; display: flex; justify-content: space-between; align-items: center;">' +
                '<span style="font-size: 11px; color: #6b7280;"><i class="fas fa-calendar" style="margin-left: 4px;"></i>' + (dateStr || '-') + '</span>' +
                '<span style="font-size: 11px; color: #6b7280;"><i class="fas fa-user" style="margin-left: 4px;"></i>' + (uploaderName || '-') + '</span>' +
                '</div>';

            container.appendChild(card);
        });
    }).catch(function(err) {
        console.error('Error loading panorama:', err);
        container.innerHTML = '<div style="text-align: center; padding: 20px; color: #ef4444; font-size: 13px;">حدث خطأ في تحميل صور البانوراما</div>';
    });
}

function openPanoramaViewer(url) {
    // Simple fullscreen image viewer
    var overlay = document.createElement('div');
    overlay.id = 'panoramaViewerOverlay';
    overlay.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.95); z-index: 100000; display: flex; align-items: center; justify-content: center; padding: 20px; cursor: pointer;';
    overlay.onclick = function() { overlay.remove(); };
    overlay.innerHTML = '<img src="' + url + '" style="max-width: 100%; max-height: 90vh; border-radius: 12px; object-fit: contain; box-shadow: 0 20px 60px rgba(0,0,0,0.5);">' +
        '<button style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; font-size: 20px;">' +
        '<i class="fas fa-times"></i></button>';
    document.body.appendChild(overlay);
}

function closePatientDetailsViewModal() {
    document.getElementById('patientDetailsViewModal').style.display = 'none';
}

function sharePatientWithOthers() {
    showToast('سيتم فتح نافذة المشاركة قريباً', 'info');
}

// ========== Toast Notification ==========
function showToast(message, type) {
    type = type || 'info';
    var existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();

    var toast = document.createElement('div');
    toast.className = 'toast-notification';

    var colors = {
        success: 'linear-gradient(135deg, #10b981, #059669)',
        error: 'linear-gradient(135deg, #ef4444, #dc2626)',
        warning: 'linear-gradient(135deg, #f59e0b, #d97706)',
        info: 'linear-gradient(135deg, #3b82f6, #2563eb)'
    };

    toast.style.cssText = 'position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: ' + (colors[type] || colors.info) + '; color: white; padding: 14px 24px; border-radius: 12px; font-size: 14px; font-weight: 600; z-index: 100000; box-shadow: 0 10px 30px rgba(0,0,0,0.2); min-width: 300px; text-align: center; animation: slideDown 0.3s ease; font-family: inherit;';

    var icon = type === 'success' ? 'fa-check-circle' :
               type === 'error' ? 'fa-exclamation-circle' :
               type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

    toast.innerHTML = '<i class="fas ' + icon + '" style="margin-left: 8px;"></i>' + message;

    document.body.appendChild(toast);

    setTimeout(function() {
        toast.style.animation = 'fadeOut 0.3s ease';
        setTimeout(function() { toast.remove(); }, 300);
    }, 3000);
}

// ========== إغلاق النوافذ عند النقر خارجها ==========
window.onclick = function(event) {
    var tempModal = document.getElementById('tempReservationModal');
    var detailsModal = document.getElementById('patientDetailsViewModal');

    if (event.target === tempModal) {
        closeTempReservationModal();
    }
    if (event.target === detailsModal) {
        closePatientDetailsViewModal();
    }
};
