=====================================
  Student Section - Documentation
  Dental Clinic Management System
=====================================

1. OVERVIEW (نظرة عامة)
========================
قسم الطالب هو الواجهة الرئيسية لطلاب كلية طب الأسنان.
يسمح للطالب بإدارة الحالات السريرية، تسجيل المرضى، متابعة الأعمال،
ومنح الحالات لطلاب آخرين.

النظام يعتمد على Laravel Blade Templates مع JavaScript على جانب العميل
و localStorage كقاعدة بيانات مؤقتة (بديل MySQL للنموذج التجريبي).


2. FILE STRUCTURE (هيكل الملفات)
=================================

--- Blade Views (resources/views/student/) ---

  home.blade.php          → الصفحة الرئيسية (لوحة التحكم)
                            - إحصائيات سريعة
                            - بطاقات المقررات المسجلة
                            - modal عرض الأعمال المطلوبة

  explore.blade.php       → صفحة سجل الأعمال (الحالات السريرية)
                            - تبويبان: "الأعمال والحالات" + "إضافة حالة جديدة"
                            - يتضمن: add-hala-explore + manh-tables

  favorites.blade.php     → صفحة سجل المرضى (المفضلة)
                            - 4 تبويبات: أعمال / إضافة مريض / سجل المرضى / معرض الصور
                            - يتضمن: favo-works + favo-add + favo-patient + favo-gallery

  profile.blade.php       → الملف الشخصي
                            - تعديل رقم الموبايل (OTP)
                            - تغيير كلمة المرور
                            - شكاوى واستبيانات

  notifications.blade.php → صفحة الإشعارات

  login.blade.php         → صفحة تسجيل الدخول (مستقلة بدون layout)

  page.blade.php          → قالب صفحة عام (للصفحات البسيطة)

--- Partial Views (ملفات جزئية مضمنة) ---

  add-hala-explore.blade.php  → نموذج إضافة حالة جديدة (ضمن explore)
                                - اختيار المريض
                                - اختيار العلاج والسن
                                - نظام المنح (منح/استقبال حالات)

  manh-tables.blade.php       → جداول الحالات الممنوحة (ضمن explore)
                                - جدول الصادرة
                                - جدول الواردة
                                - modal إلغاء + modal رفض

  favo-works.blade.php        → عرض الأعمال والحالات (ضمن favorites)
                                - إحصائيات سريعة
                                - فلاتر (مكتمل/قيد المعالجة/محجوز)
                                - بطاقات الأعمال

  favo-add.blade.php          → نموذج إضافة مريض جديد (ضمن favorites)
                                - مخطط أسنان FDI (دائم + لبني)
                                - مخطط القلح
                                - بيانات صحية
                                - صلاحيات الوصول

  favo-patient.blade.php      → سجل جميع المرضى (ضمن favorites)
                                - فلتر (الكل/خاص/عام)
                                - بحث
                                - بطاقات المرضى
                                - modal الحجز المؤقت
                                - modal عرض التفاصيل

  favo-gallery.blade.php      → معرض صور المرضى (ضمن favorites)
                                - رفع صور (قبل/بعد/أشعة)
                                - عرض وحذف الصور


3. JAVASCRIPT FILES (ملفات JavaScript)
========================================

--- Explore Section (public/js/student/) ---

  explore/ui.js            → واجهة صفحة الحالات
                             - عرض جدول الحالات
                             - ترقيم الصفحات
                             - إدارة الصور (استديو)
                             - Global: window.CasesUI

  explore/case-data.js     → طبقة البيانات لصفحة الحالات
                             - localStorage integration
                             - إدارة الحالات والصور
                             - Global: window.CasesData

  explore/manh-tables.js   → منطق جداول المنح
                             - بيانات تجريبية
                             - قبول/رفض/إلغاء
                             - فحص وقت الجلسة

  add-explore.js           → منطق إضافة حالة جديدة
                             - قاعدة بيانات المرضى والطلاب
                             - جداول المقررات والمواعيد
                             - نظام المنح

--- Favorites Section (public/js/favo/) ---

  favo-data.js             → طبقة البيانات (Data Layer)
                             - DBManager (localStorage CRUD)
                             - AppState (حالة التطبيق)
                             - TeethDataManager (نظام FDI)
                             - PeriodontalDataManager (نظام القلح)
                             - ListsManager (الطلاب/الأمراض)
                             - PatientManager (إدارة المرضى)
                             - DataResetManager

  favo-ui.js               → طبقة الواجهة (UI Layer)
                             - UIUtils (أدوات مساعدة)
                             - ToastManager (إشعارات)
                             - ModalManager (نوافذ منبثقة)
                             - TeethUIManager (واجهة الأسنان)
                             - PeriodontalUIManager (واجهة القلح)
                             - PatientFormUIManager (واجهة النموذج)

  favo-mantic.js           → إعدادات ومحاكاة
                             - AppConfig (إعدادات ثابتة)
                             - AppSimulator (محاكاة API)
                             - Helpers (أدوات عامة)
                             - AppController (متحكم رئيسي)

  favo-add.js              → منطق نموذج إضافة مريض
                             - إدارة الأسنان (تحديد/إزالة)
                             - إدارة القلح
                             - التحقق من البيانات
                             - حفظ المريض

  favo-patient.js          → منطق سجل المرضى
                             - عرض بطاقات المرضى
                             - فلاتر وبحث
                             - الحجز المؤقت
                             - عرض التفاصيل

  favo-main.js             → [غير مستخدم حالياً]
                             - نسخة مبكرة من AppController
                             - تم استبداله بـ favo-mantic.js

--- Other JS ---

  tab-bar.js               → منطق شريط التنقل السفلي
  explore.js               → [غير مستخدم - نسخة قديمة]
  explore1.js              → [غير مستخدم - نسخة قديمة]


4. JS LOAD ORDER (ترتيب تحميل JavaScript)
==========================================

صفحة Explore (explore.blade.php):
  1. js/student/explore/ui.js
  2. js/student/explore/case-data.js
  ضمن add-hala-explore:
    3. js/student/add-explore.js
  ضمن manh-tables:
    4. js/student/explore/manh-tables.js

صفحة Favorites (favorites.blade.php):
  ضمن favo-add:
    1. js/favo/favo-data.js      (البيانات أولاً)
    2. js/favo/favo-ui.js        (الواجهة ثانياً)
    3. js/favo/favo-mantic.js    (الإعدادات ثالثاً)
    4. js/favo/favo-add.js       (منطق النموذج أخيراً)
  ضمن favo-patient:
    5. js/favo/favo-patient.js


5. DATA FLOW (تدفق البيانات)
==============================

localStorage Keys:
  - dental_patients         → قائمة المرضى (من favo-add)
  - dental_settings         → إعدادات التطبيق
  - dental_session          → بيانات الجلسة الحالية
  - dental_reservations     → حجوزات الحالات (من explore)
  - dentalStudioData_v2     → بيانات استديو الصور (من explore)
  - favo_patients           → بيانات المرضى مع الحجز المؤقت (من favo-patient)
  - favo_courses_reservations → عدادات حجوزات المقررات
  - favo_gallery_images     → صور معرض المرضى (من favo-gallery)
  - dental_manh_cases       → بيانات حالات المنح
  - confirmed_patients      → المرضى ذوي الحجز المثبت (مشترك بين favo-patient و add-explore)


10. DATA FLOW: RESERVATION TO CASE (تدفق: من الحجز إلى الحالة)
================================================================

  سجل المرضى (favo-patient)          →     إضافة حالة (add-explore)
  ─────────────────────────           →     ────────────────────────
  1. حجز مؤقت (isFrozen)             →
  2. تثبيت الحجز (isConfirmed)        →     3. يظهر المريض في "المرضى المتاحين"
                                      →     4. يُعرض وقت الجلسة والمقرر
                                      →     5. يمكن إضافة حالة علاجية للمريض

  localStorage المشترك: confirmed_patients
  - يُكتب من favo-patient.js عند التثبيت
  - يُقرأ من add-explore.js عند تحميل المرضى


6. ROUTING (التوجيه)
=====================

المسار الأساسي: /student/{page}

  /student/home       → student/home.blade.php
  /student/explore    → student/explore.blade.php
  /student/favorites  → student/favorites.blade.php
  /student/profile    → student/profile.blade.php

Controller: App\Http\Controllers\HomeController
  - studentIndex()  → GET /student/home
  - studentShow()   → GET /student/{page}

Bottom Nav Items: home, explore, favorites, profile


7. LAYOUT (القالب الأساسي)
===========================

layouts/app.blade.php:
  - شريط علوي (الاسم + إشعارات)
  - شريط تنقل سفلي (4 أزرار)
  - modal تسجيل الخروج
  - modal الإشعارات
  - overlay التعليمات
  - overlay التحميل

CSS Files (لا تلمسها!):
  - css/student.css
  - css/explore.css
  - css/student/explore.css
  - css/student/add-explore.css
  - css/student/explore/manh-tables.css
  - css/favo/favo-add.css
  - css/favo/favo-patient.css


8. GLOBAL JS OBJECTS (الكائنات العامة)
=======================================

Explore:
  - window.CasesUI      → واجهة الحالات
  - window.CasesData    → بيانات الحالات

Favorites:
  - window.DBManager              → إدارة localStorage
  - window.AppState               → حالة التطبيق
  - window.TeethDataManager       → بيانات الأسنان
  - window.PeriodontalDataManager → بيانات القلح
  - window.ListsManager           → القوائم المؤقتة
  - window.PatientManager         → إدارة المرضى
  - window.DataResetManager       → إعادة تعيين البيانات
  - window.UIUtils                → أدوات واجهة
  - window.ToastManager           → إشعارات
  - window.ModalManager           → نوافذ منبثقة
  - window.TeethUIManager         → واجهة الأسنان
  - window.PeriodontalUIManager   → واجهة القلح
  - window.PatientFormUIManager   → واجهة نموذج المريض
  - window.AppConfig              → إعدادات عامة
  - window.AppSimulator           → محاكاة API
  - window.Helpers                → أدوات مساعدة
  - window.AppController          → المتحكم الرئيسي


9. NOTES (ملاحظات)
====================

- النظام يعمل بالكامل على جانب العميل (Client-Side) باستخدام localStorage.
- البيانات الموجودة تجريبية (mock data) ويمكن استبدالها بطلبات API/AJAX.
- نظام الأسنان يتبع ترميز FDI الدولي (ISO 3950).
- اللغة الأساسية: العربية (RTL).
- التصميم متجاوب (Responsive) للموبايل أولاً.
- لا تعدل ملفات CSS مباشرة - التنسيقات الداخلية (inline styles)
  في الـ blade templates هي جزء من المنطق البرمجي.
