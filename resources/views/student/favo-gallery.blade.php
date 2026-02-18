<!-- قسم معرض الصور -->
<div class="tab-content" id="galleryContent">

    <!-- العنوان -->
    <div class="section-title-all">
        <i class="fas fa-images"></i>
        <span>معرض الصور</span>
    </div>

    <!-- فلاتر المعرض -->
    <div class="filters-container">
        <button class="filter-btn active" data-filter="all" onclick="filterGallery('all', this)">
            الكل (<span id="galleryCountAll">0</span>)
        </button>
        <button class="filter-btn" data-filter="before" onclick="filterGallery('before', this)">
            قبل العلاج
        </button>
        <button class="filter-btn" data-filter="after" onclick="filterGallery('after', this)">
            بعد العلاج
        </button>
        <button class="filter-btn" data-filter="xray" onclick="filterGallery('xray', this)">
            أشعة
        </button>
    </div>

    <!-- زر رفع صورة -->
    <div style="margin-bottom: 16px;">
        <button onclick="openGalleryUpload()" class="gallery-upload-btn">
            <i class="fas fa-camera-retro"></i>
            إضافة صورة جديدة
        </button>
    </div>

    <!-- شبكة الصور -->
    <div class="gallery-grid" id="galleryGrid">
        <!-- يتم ملؤها بواسطة JavaScript -->
    </div>

    <!-- حالة فارغة -->
    <div id="galleryEmpty" style="display: none; text-align: center; padding: 40px; color: #9ca3af;">
        <i class="fas fa-camera" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
        <p>لا توجد صور في المعرض بعد</p>
        <p style="font-size: 12px; margin-top: 8px;">قم بإضافة صور للمرضى من خلال زر الإضافة أعلاه</p>
    </div>

</div>

<!-- Modal رفع صورة -->
<div id="galleryUploadModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 450px;">
        <div class="modal-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1; width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px;">
            <i class="fas fa-cloud-upload-alt"></i>
        </div>
        <h3 style="text-align: center; color: #1f2937; margin-bottom: 8px;">إضافة صورة جديدة</h3>
        <p style="text-align: center; color: #6b7280; font-size: 13px; margin-bottom: 20px;">اختر صورة وحدد تفاصيلها</p>

        <!-- منطقة الرفع -->
        <div class="gallery-drop-zone" id="galleryDropZone" onclick="document.getElementById('galleryFileInput').click()">
            <i class="fas fa-image" style="font-size: 36px; color: #d1d5db; margin-bottom: 8px;"></i>
            <p style="color: #6b7280; font-size: 13px;">اضغط لاختيار صورة</p>
            <input type="file" id="galleryFileInput" accept="image/*" style="display: none;" onchange="previewGalleryImage(this)">
        </div>

        <!-- معاينة الصورة -->
        <div id="galleryPreview" style="display: none; margin: 12px 0; text-align: center;">
            <img id="galleryPreviewImg" src="" style="max-width: 100%; max-height: 200px; border-radius: 12px; border: 2px solid #e5e7eb;">
        </div>

        <!-- اسم المريض (مع قائمة اقتراحات من البيانات المحفوظة) -->
        <div style="margin-bottom: 12px;">
            <label style="font-size: 13px; font-weight: 600; color: #374151; display: block; margin-bottom: 6px;">اسم المريض</label>
            <input type="text" id="galleryPatientName" list="galleryPatientsList" placeholder="ابحث أو اكتب اسم المريض..." style="width: 100%; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; font-family: inherit; outline: none; box-sizing: border-box;">
            <datalist id="galleryPatientsList"></datalist>
        </div>

        <!-- نوع الصورة -->
        <div style="margin-bottom: 12px;">
            <label style="font-size: 13px; font-weight: 600; color: #374151; display: block; margin-bottom: 6px;">نوع الصورة</label>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                <button type="button" class="gallery-type-btn active" data-type="before" onclick="selectGalleryType('before', this)">
                    <i class="fas fa-clock"></i> قبل
                </button>
                <button type="button" class="gallery-type-btn" data-type="after" onclick="selectGalleryType('after', this)">
                    <i class="fas fa-check"></i> بعد
                </button>
                <button type="button" class="gallery-type-btn" data-type="xray" onclick="selectGalleryType('xray', this)">
                    <i class="fas fa-x-ray"></i> أشعة
                </button>
            </div>
        </div>

        <!-- ملاحظة -->
        <div style="margin-bottom: 16px;">
            <label style="font-size: 13px; font-weight: 600; color: #374151; display: block; margin-bottom: 6px;">ملاحظة (اختياري)</label>
            <input type="text" id="galleryNote" placeholder="ملاحظة..." style="width: 100%; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; font-family: inherit; outline: none; box-sizing: border-box;">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 16px;">
            <button onclick="closeGalleryUpload()" style="flex: 1; padding: 12px; border: 2px solid #e5e7eb; background: white; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: inherit; color: #6b7280;">إلغاء</button>
            <button onclick="saveGalleryImage()" style="flex: 1; padding: 12px; border: none; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: inherit;">
                <i class="fas fa-save" style="margin-left: 6px;"></i>حفظ
            </button>
        </div>
    </div>
</div>

<!-- Modal عرض الصورة -->
<div id="galleryViewModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 500px; padding: 0; overflow: hidden;">
        <div style="position: relative;">
            <img id="galleryViewImg" src="" style="width: 100%; display: block;">
            <button onclick="closeGalleryView()" style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 36px; height: 36px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 16px;">
            <div id="galleryViewInfo"></div>
            <button onclick="deleteGalleryImage()" style="width: 100%; margin-top: 12px; padding: 10px; border: 2px solid #fee2e2; background: #fff5f5; color: #ef4444; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit;">
                <i class="fas fa-trash-alt" style="margin-left: 6px;"></i>حذف الصورة
            </button>
        </div>
    </div>
</div>

<script>
// ========== معرض الصور ==========
var galleryImages = [];
var currentGalleryFilter = 'all';
var selectedGalleryType = 'before';
var currentViewImageId = null;
var galleryPatientNames = []; // أسماء المرضى من كل المصادر

document.addEventListener('DOMContentLoaded', function() {
    loadGalleryData();
    loadGalleryPatientNames();
    renderGallery();
});

function loadGalleryData() {
    try {
        var saved = localStorage.getItem('favo_gallery_images');
        galleryImages = saved ? JSON.parse(saved) : [];
    } catch (e) {
        galleryImages = [];
    }
}

// تحميل أسماء المرضى من كل مصادر البيانات
function loadGalleryPatientNames() {
    var namesMap = {};
    try {
        // من dental_patients (المضافين من صفحة إضافة مريض)
        var dp = localStorage.getItem('dental_patients');
        if (dp) {
            JSON.parse(dp).forEach(function(p) {
                if (p.name) namesMap[p.name] = { record: p.record || '', id: p.id || p._id };
            });
        }
        // من favo_patients (سجل المرضى مع الحجوزات)
        var fp = localStorage.getItem('favo_patients');
        if (fp) {
            JSON.parse(fp).forEach(function(p) {
                if (p.fullName && !namesMap[p.fullName]) {
                    namesMap[p.fullName] = { record: p.recordNumber || '', id: p.id };
                }
            });
        }
        // من confirmed_patients
        var cp = localStorage.getItem('confirmed_patients');
        if (cp) {
            JSON.parse(cp).forEach(function(p) {
                if (p.fullName && !namesMap[p.fullName]) {
                    namesMap[p.fullName] = { record: p.recordNumber || '', id: p.id };
                }
            });
        }
    } catch (e) {
        console.warn('Error loading patient names for gallery:', e);
    }

    galleryPatientNames = Object.keys(namesMap).map(function(name) {
        return { name: name, record: namesMap[name].record, id: namesMap[name].id };
    });

    // تعبئة datalist
    var datalist = document.getElementById('galleryPatientsList');
    if (datalist) {
        datalist.innerHTML = galleryPatientNames.map(function(p) {
            return '<option value="' + p.name + '">' + (p.record ? p.record + ' - ' : '') + p.name + '</option>';
        }).join('');
    }
}

function saveGalleryData() {
    try {
        localStorage.setItem('favo_gallery_images', JSON.stringify(galleryImages));
    } catch (e) {
        console.warn('Error saving gallery:', e);
    }
}

function filterGallery(filter, btn) {
    currentGalleryFilter = filter;
    document.querySelectorAll('#galleryContent .filter-btn').forEach(function(b) {
        b.classList.remove('active');
    });
    if (btn) btn.classList.add('active');
    renderGallery();
}

function renderGallery() {
    var container = document.getElementById('galleryGrid');
    var emptyState = document.getElementById('galleryEmpty');
    var countAll = document.getElementById('galleryCountAll');
    if (!container) return;

    if (countAll) countAll.textContent = galleryImages.length;

    var filtered = galleryImages;
    if (currentGalleryFilter !== 'all') {
        filtered = galleryImages.filter(function(img) { return img.type === currentGalleryFilter; });
    }

    if (filtered.length === 0) {
        container.innerHTML = '';
        if (emptyState) emptyState.style.display = 'block';
        return;
    }

    if (emptyState) emptyState.style.display = 'none';

    var typeLabels = { before: 'قبل العلاج', after: 'بعد العلاج', xray: 'أشعة' };
    var typeColors = { before: '#f59e0b', after: '#10b981', xray: '#3b82f6' };

    container.innerHTML = filtered.map(function(img, index) {
        return '<div class="gallery-item" style="animation: fadeIn 0.3s ease forwards ' + (index * 0.05) + 's; opacity: 0;" onclick="viewGalleryImage(\'' + img.id + '\')">' +
            '<div class="gallery-item-img">' +
                '<img src="' + img.thumbnail + '" alt="' + img.patientName + '">' +
                '<span class="gallery-item-type" style="background: ' + (typeColors[img.type] || '#6b7280') + ';">' +
                    (typeLabels[img.type] || img.type) +
                '</span>' +
            '</div>' +
            '<div class="gallery-item-info">' +
                '<div class="gallery-item-name">' + img.patientName + '</div>' +
                '<div class="gallery-item-date">' + img.date + '</div>' +
            '</div>' +
        '</div>';
    }).join('');
}

// ========== رفع الصور ==========
function openGalleryUpload() {
    // تحديث أسماء المرضى عند كل فتح
    loadGalleryPatientNames();

    document.getElementById('galleryUploadModal').style.display = 'flex';
    document.getElementById('galleryPreview').style.display = 'none';
    document.getElementById('galleryPatientName').value = '';
    document.getElementById('galleryNote').value = '';
    document.getElementById('galleryFileInput').value = '';
    selectedGalleryType = 'before';
    document.querySelectorAll('.gallery-type-btn').forEach(function(b) { b.classList.remove('active'); });
    document.querySelector('.gallery-type-btn[data-type="before"]').classList.add('active');
}

function closeGalleryUpload() {
    document.getElementById('galleryUploadModal').style.display = 'none';
}

function selectGalleryType(type, btn) {
    selectedGalleryType = type;
    document.querySelectorAll('.gallery-type-btn').forEach(function(b) { b.classList.remove('active'); });
    if (btn) btn.classList.add('active');
}

function previewGalleryImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('galleryPreviewImg').src = e.target.result;
            document.getElementById('galleryPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function saveGalleryImage() {
    var patientName = document.getElementById('galleryPatientName').value.trim();
    var note = document.getElementById('galleryNote').value.trim();
    var previewImg = document.getElementById('galleryPreviewImg').src;

    if (!patientName) {
        alert('الرجاء إدخال اسم المريض');
        return;
    }
    if (!previewImg || previewImg === window.location.href) {
        alert('الرجاء اختيار صورة');
        return;
    }

    // البحث عن رقم السجل من قائمة المرضى المحملة
    var patientInfo = galleryPatientNames.find(function(p) { return p.name === patientName; });
    var patientRecord = patientInfo ? patientInfo.record : '';
    var patientId = patientInfo ? patientInfo.id : null;

    var imageObj = {
        id: Date.now().toString(36) + Math.random().toString(36).substr(2, 5),
        patientName: patientName,
        patientRecord: patientRecord,
        patientId: patientId,
        type: selectedGalleryType,
        note: note,
        thumbnail: previewImg,
        date: new Date().toLocaleDateString('ar-SA'),
        createdAt: new Date().toISOString()
    };

    galleryImages.unshift(imageObj);
    saveGalleryData();
    closeGalleryUpload();
    renderGallery();
}

// ========== عرض وحذف الصور ==========
function viewGalleryImage(imageId) {
    var img = galleryImages.find(function(i) { return i.id === imageId; });
    if (!img) return;

    currentViewImageId = imageId;
    document.getElementById('galleryViewImg').src = img.thumbnail;

    var typeLabels = { before: 'قبل العلاج', after: 'بعد العلاج', xray: 'أشعة' };

    document.getElementById('galleryViewInfo').innerHTML =
        '<div style="font-weight: 700; color: #1f2937; margin-bottom: 4px;">' + img.patientName + '</div>' +
        (img.patientRecord ? '<div style="font-size: 11px; color: #6366f1; margin-bottom: 4px;"><i class="fas fa-hashtag" style="margin-left: 4px;"></i>' + img.patientRecord + '</div>' : '') +
        '<div style="font-size: 12px; color: #6b7280;">' + (typeLabels[img.type] || '') + ' - ' + img.date + '</div>' +
        (img.note ? '<div style="font-size: 12px; color: #374151; margin-top: 6px; padding: 8px; background: #f9fafb; border-radius: 8px;">' + img.note + '</div>' : '');

    document.getElementById('galleryViewModal').style.display = 'flex';
}

function closeGalleryView() {
    document.getElementById('galleryViewModal').style.display = 'none';
    currentViewImageId = null;
}

function deleteGalleryImage() {
    if (!currentViewImageId) return;
    if (!confirm('هل أنت متأكد من حذف هذه الصورة؟')) return;

    galleryImages = galleryImages.filter(function(i) { return i.id !== currentViewImageId; });
    saveGalleryData();
    closeGalleryView();
    renderGallery();
}

// إغلاق المودالات بالنقر خارجها
document.addEventListener('click', function(e) {
    if (e.target.id === 'galleryUploadModal') closeGalleryUpload();
    if (e.target.id === 'galleryViewModal') closeGalleryView();
});
</script>

<style>
.gallery-upload-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: inherit;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.gallery-drop-zone {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 12px;
}

.gallery-drop-zone:hover {
    border-color: #6366f1;
    background: rgba(99, 102, 241, 0.02);
}

.gallery-type-btn {
    padding: 10px;
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    font-family: inherit;
    color: #6b7280;
    transition: all 0.2s;
}

.gallery-type-btn.active {
    border-color: #6366f1;
    background: rgba(99, 102, 241, 0.08);
    color: #6366f1;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.gallery-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid #f3f4f6;
    cursor: pointer;
    transition: transform 0.2s;
}

.gallery-item:active {
    transform: scale(0.98);
}

.gallery-item-img {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
}

.gallery-item-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-item-type {
    position: absolute;
    top: 8px;
    right: 8px;
    color: white;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
}

.gallery-item-info {
    padding: 10px;
}

.gallery-item-name {
    font-weight: 700;
    font-size: 13px;
    color: #1f2937;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.gallery-item-date {
    font-size: 11px;
    color: #9ca3af;
}

@media (max-width: 360px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>
