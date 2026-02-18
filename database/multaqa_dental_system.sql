-- ================================================================================
-- MULTAQA DENTAL PLATFORM - COMPLETE DATABASE SCHEMA
-- منصة ملتقى لإدارة عيادة الأسنان
-- Generated: 2026-02-19
-- Laravel + SQLite Database
-- ================================================================================

-- ================================================================================
-- 1. TABLE: roles
-- Purpose: User roles (student, admin, supervisor, ayham)
-- ================================================================================
CREATE TABLE IF NOT EXISTS roles (
    id          INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name        VARCHAR NOT NULL UNIQUE,
    label       VARCHAR NULL,
    created_at  DATETIME NULL,
    updated_at  DATETIME NULL
);

-- Insert default roles
INSERT INTO roles (id, name, label, created_at, updated_at) VALUES
(1, 'student', 'طالب', datetime('now'), datetime('now')),
(2, 'admin', 'مشرف إداري', datetime('now'), datetime('now')),
(3, 'supervisor', 'مشرف سريري', datetime('now'), datetime('now')),
(4, 'ayham', 'مدير النظام', datetime('now'), datetime('now'));

-- ================================================================================
-- 2. TABLE: users
-- Purpose: All users (students, admins, supervisors, ayham)
-- ================================================================================
CREATE TABLE IF NOT EXISTS users (
    id                INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    student_id        VARCHAR NULL UNIQUE,
    name              VARCHAR NOT NULL,
    email             VARCHAR NULL UNIQUE,
    role_id           INTEGER NOT NULL DEFAULT 1,
    email_verified_at DATETIME NULL,
    password          VARCHAR NOT NULL,
    is_active         TINYINT(1) NOT NULL DEFAULT 1,
    remember_token    VARCHAR NULL,
    phone             VARCHAR NULL,
    created_at        DATETIME NULL,
    updated_at        DATETIME NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Create indexes
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_student_id ON users(student_id);
CREATE INDEX IF NOT EXISTS idx_users_role_id ON users(role_id);

-- Insert default users with hashed passwords
-- Passwords: Student@123, Admin@123, Super@123, Ayham@123
INSERT INTO users (id, student_id, name, email, role_id, password, phone, is_active, created_at, updated_at) VALUES
(1, '202312345', 'أيهم رياض حمشدو', 'student@multaqa.com', 1, '$2y$12$LQv3j8m1Jq8Q8Q8Q8Q8Q8O8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q', '0935123456', 1, datetime('now'), datetime('now')),
(2, '202398765', 'خالد العمر', 'khaled@multaqa.com', 1, '$2y$12$LQv3j8m1Jq8Q8Q8Q8Q8Q8O8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q', '0937654321', 1, datetime('now'), datetime('now')),
(3, 'admin', 'المشرف الإداري', 'admin@multaqa.com', 2, '$2y$12$LQv3j8m1Jq8Q8Q8Q8Q8Q8O8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q', '0911111111', 1, datetime('now'), datetime('now')),
(4, 'supervisor', 'المشرف السريري', 'supervisor@multaqa.com', 3, '$2y$12$LQv3j8m1Jq8Q8Q8Q8Q8Q8O8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q', '0922222222', 1, datetime('now'), datetime('now')),
(5, 'ayham', 'أيهم - مدير النظام', 'ayham@multaqa.com', 4, '$2y$12$LQv3j8m1Jq8Q8Q8Q8Q8Q8O8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q8Q', '0933333333', 1, datetime('now'), datetime('now'));

-- ================================================================================
-- 3. TABLE: password_reset_tokens
-- Purpose: Laravel default password reset tokens
-- ================================================================================
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email      VARCHAR PRIMARY KEY NOT NULL,
    token      VARCHAR NOT NULL,
    created_at DATETIME NULL
);

-- ================================================================================
-- 4. TABLE: sessions
-- Purpose: Database session storage (single-device enforcement)
-- ================================================================================
CREATE TABLE IF NOT EXISTS sessions (
    id            VARCHAR PRIMARY KEY NOT NULL,
    user_id       INTEGER NULL,
    ip_address    VARCHAR NULL,
    user_agent    TEXT NULL,
    payload       TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

CREATE INDEX IF NOT EXISTS idx_sessions_user_id ON sessions(user_id);
CREATE INDEX IF NOT EXISTS idx_sessions_last_activity ON sessions(last_activity);

-- ================================================================================
-- 5. TABLE: cache
-- Purpose: Laravel cache storage
-- ================================================================================
CREATE TABLE IF NOT EXISTS cache (
    key        VARCHAR PRIMARY KEY NOT NULL,
    value      TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS cache_locks (
    key        VARCHAR PRIMARY KEY NOT NULL,
    owner      VARCHAR NOT NULL,
    expiration INTEGER NOT NULL
);

-- ================================================================================
-- 6. TABLE: jobs
-- Purpose: Laravel queue system
-- ================================================================================
CREATE TABLE IF NOT EXISTS jobs (
    id           INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    queue        VARCHAR NOT NULL,
    payload      TEXT NOT NULL,
    attempts     INTEGER NOT NULL,
    reserved_at  INTEGER NULL,
    available_at INTEGER NOT NULL,
    created_at   INTEGER NOT NULL
);

CREATE INDEX IF NOT EXISTS idx_jobs_queue ON jobs(queue);

CREATE TABLE IF NOT EXISTS job_batches (
    id             VARCHAR PRIMARY KEY NOT NULL,
    name           VARCHAR NOT NULL,
    total_jobs     INTEGER NOT NULL,
    pending_jobs   INTEGER NOT NULL,
    failed_jobs    INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options        TEXT NULL,
    cancelled_at   INTEGER NULL,
    created_at     INTEGER NOT NULL,
    finished_at    INTEGER NULL
);

CREATE TABLE IF NOT EXISTS failed_jobs (
    id         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    uuid       VARCHAR NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue      TEXT NOT NULL,
    payload    TEXT NOT NULL,
    exception  TEXT NOT NULL,
    failed_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ================================================================================
-- 7. TABLE: courses
-- Purpose: Clinical courses offered in dental college
-- ================================================================================
CREATE TABLE IF NOT EXISTS courses (
    id               INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    code             VARCHAR NOT NULL,
    slug             VARCHAR NOT NULL UNIQUE,
    name             VARCHAR NOT NULL,
    supervisors      VARCHAR NULL,
    schedule         VARCHAR NULL,
    location         VARCHAR NULL,
    max_reservations INTEGER NOT NULL DEFAULT 2,
    session_limit    INTEGER NOT NULL DEFAULT 2,
    is_active        TINYINT(1) NOT NULL DEFAULT 1,
    created_at       DATETIME NULL,
    updated_at       DATETIME NULL
);

CREATE INDEX IF NOT EXISTS idx_courses_code ON courses(code);
CREATE INDEX IF NOT EXISTS idx_courses_slug ON courses(slug);

-- Insert default courses
INSERT INTO courses (id, code, slug, name, supervisors, schedule, location, max_reservations, session_limit, is_active, created_at, updated_at) VALUES
(1, 'A', 'course-a', 'مداواة الأسنان الترميمية 4', 'د. أحمد الخطيب، د. سارة القاسم', 'السبت 8:00-12:00', 'عيادة الترميم 10', 2, 2, 1, datetime('now'), datetime('now')),
(2, 'B', 'course-b', 'تخدير و قلع الأسنان 4', 'د. محمد العلي، د. فاطمة الزهراء', 'الأحد 9:00-13:00', 'عيادة الجراحة 7', 3, 3, 1, datetime('now'), datetime('now')),
(3, 'C', 'course-c', 'النسج حول سنية 2', 'د. خالد العمر، د. ليلى الحسن', 'الثلاثاء 10:00-14:00', 'عيادة اللثة 15', 2, 2, 1, datetime('now'), datetime('now')),
(4, 'D', 'course-d', 'مداواة الأسنان اللبية 4', 'د. يوسف الدين، د. نور الهدى', 'الأربعاء 8:00-11:00', 'عيادة العلاج اللبي 3', 2, 2, 1, datetime('now'), datetime('now'));

-- ================================================================================
-- 8. TABLE: course_schedules
-- Purpose: Weekly session schedule per course (when QR is allowed)
-- ================================================================================
CREATE TABLE IF NOT EXISTS course_schedules (
    id          INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    course_id   INTEGER NOT NULL,
    group_name  VARCHAR NULL,
    day_of_week VARCHAR NOT NULL,
    start_time  TIME NOT NULL,
    end_time    TIME NOT NULL,
    location    VARCHAR NULL,
    created_at  DATETIME NULL,
    updated_at  DATETIME NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_course_schedules_course_id ON course_schedules(course_id);

-- Insert default course schedules
INSERT INTO course_schedules (id, course_id, group_name, day_of_week, start_time, end_time, location, created_at, updated_at) VALUES
(1, 1, 'المجموعة أ', 'saturday', '08:00', '12:00', 'عيادة الترميم 10', datetime('now'), datetime('now')),
(2, 2, 'المجموعة أ', 'sunday', '09:00', '13:00', 'عيادة الجراحة 7', datetime('now'), datetime('now')),
(3, 3, 'المجموعة أ', 'tuesday', '10:00', '14:00', 'عيادة اللثة 15', datetime('now'), datetime('now')),
(4, 4, 'المجموعة أ', 'wednesday', '08:00', '11:00', 'عيادة العلاج اللبي 3', datetime('now'), datetime('now'));

-- ================================================================================
-- 9. TABLE: course_rules
-- Purpose: Business rules per course (session limits, grants, tooth duplication)
-- ================================================================================
CREATE TABLE IF NOT EXISTS course_rules (
    id                      INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    course_id               INTEGER NOT NULL UNIQUE,
    max_cases_per_session   INTEGER NOT NULL DEFAULT 2,
    allow_grants            TINYINT(1) NOT NULL DEFAULT 1,
    grant_unlimited         TINYINT(1) NOT NULL DEFAULT 1,
    prevent_duplicate_tooth TINYINT(1) NOT NULL DEFAULT 1,
    notes                   TEXT NULL,
    created_at              DATETIME NULL,
    updated_at              DATETIME NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Insert default course rules
INSERT INTO course_rules (id, course_id, max_cases_per_session, allow_grants, grant_unlimited, prevent_duplicate_tooth, notes, created_at, updated_at) VALUES
(1, 1, 2, 1, 1, 1, 'قواعد المقرر أ', datetime('now'), datetime('now')),
(2, 2, 3, 1, 1, 1, 'قواعد المقرر ب', datetime('now'), datetime('now')),
(3, 3, 2, 1, 1, 1, 'قواعد المقرر ج', datetime('now'), datetime('now')),
(4, 4, 2, 1, 1, 1, 'قواعد المقرر د', datetime('now'), datetime('now'));

-- ================================================================================
-- 10. TABLE: course_evaluation_stages
-- Purpose: Evaluation stages required per course (3 stages each)
-- ================================================================================
CREATE TABLE IF NOT EXISTS course_evaluation_stages (
    id                INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    course_id         INTEGER NOT NULL,
    stage_number      INTEGER NOT NULL,
    stage_name        VARCHAR NOT NULL,
    required_images   INTEGER NOT NULL DEFAULT 0,
    requires_panorama TINYINT(1) NOT NULL DEFAULT 0,
    description       TEXT NULL,
    created_at        DATETIME NULL,
    updated_at        DATETIME NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE(course_id, stage_number)
);

CREATE INDEX IF NOT EXISTS idx_course_evaluation_stages_course_id ON course_evaluation_stages(course_id);

-- Insert evaluation stages for all courses
INSERT INTO course_evaluation_stages (id, course_id, stage_number, stage_name, required_images, requires_panorama, description, created_at, updated_at) VALUES
-- Course A stages
(1, 1, 1, 'فحص أولي', 1, 0, 'الفحص الأولي للحالة', datetime('now'), datetime('now')),
(2, 1, 2, 'تنفيذ المعالجة', 2, 0, 'تنفيذ الإجراء العلاجي', datetime('now'), datetime('now')),
(3, 1, 3, 'متابعة نهائية', 1, 1, 'المتابعة النهائية مع بانوراما', datetime('now'), datetime('now')),
-- Course B stages
(4, 2, 1, 'فحص قبل القلع', 1, 0, 'الفحص قبل إجراء القلع', datetime('now'), datetime('now')),
(5, 2, 2, 'إجراء القلع', 2, 0, 'إجراء عملية القلع', datetime('now'), datetime('now')),
(6, 2, 3, 'متابعة ما بعد القلع', 1, 1, 'المتابعة بعد القلع', datetime('now'), datetime('now')),
-- Course C stages
(7, 3, 1, 'فحص لثوي', 1, 0, 'الفحص اللثوي الأولي', datetime('now'), datetime('now')),
(8, 3, 2, 'تنظيف جيب عميق', 2, 0, 'إجراء التنظيف العميق', datetime('now'), datetime('now')),
(9, 3, 3, 'متابعة لثوية', 1, 1, 'المتابعة اللثوية النهائية', datetime('now'), datetime('now')),
-- Course D stages
(10, 4, 1, 'فحص عصبي', 1, 0, 'الفحص العصبي الأولي', datetime('now'), datetime('now')),
(11, 4, 2, 'علاج العصب', 2, 0, 'إجراء علاج العصب', datetime('now'), datetime('now')),
(12, 4, 3, 'حشو قناة', 1, 1, 'حشو قناة الجذر', datetime('now'), datetime('now'));

-- ================================================================================
-- 11. TABLE: course_works
-- Purpose: Required clinical works per course (treatments students must perform)
-- ================================================================================
CREATE TABLE IF NOT EXISTS course_works (
    id               INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    course_id        INTEGER NOT NULL,
    name             VARCHAR NOT NULL,
    required_count   INTEGER NOT NULL DEFAULT 1,
    evaluation_stages INTEGER NOT NULL DEFAULT 3,
    required_images  INTEGER NOT NULL DEFAULT 1,
    is_active        TINYINT(1) NOT NULL DEFAULT 1,
    created_at       DATETIME NULL,
    updated_at       DATETIME NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_course_works_course_id ON course_works(course_id);

-- Insert course works
INSERT INTO course_works (id, course_id, name, required_count, evaluation_stages, required_images, is_active, created_at, updated_at) VALUES
-- Course A works
(1, 1, 'حشو تجميلي (Composite)', 10, 3, 2, 1, datetime('now'), datetime('now')),
(2, 1, 'حشو خلفي (Amalgam)', 8, 3, 2, 1, datetime('now'), datetime('now')),
(3, 1, 'تيجان مؤقتة', 6, 3, 2, 1, datetime('now'), datetime('now')),
(4, 1, 'تلبيس دائم', 5, 3, 3, 1, datetime('now'), datetime('now')),
(5, 1, 'جسر سنية', 4, 3, 3, 1, datetime('now'), datetime('now')),
-- Course B works
(6, 2, 'قلع بسيط', 12, 3, 1, 1, datetime('now'), datetime('now')),
(7, 2, 'قلع جراحي', 8, 3, 2, 1, datetime('now'), datetime('now')),
(8, 2, 'قلع عقل', 6, 3, 2, 1, datetime('now'), datetime('now')),
(9, 2, 'تخدير موضعي', 15, 2, 1, 1, datetime('now'), datetime('now')),
(10, 2, 'تخدير عظمي (Block)', 10, 2, 1, 1, datetime('now'), datetime('now')),
-- Course C works
(11, 3, 'تنظيف جيب عميق (Scaling)', 15, 2, 1, 1, datetime('now'), datetime('now')),
(12, 3, 'جراحة إعادة تشكيل اللثة', 8, 3, 2, 1, datetime('now'), datetime('now')),
(13, 3, 'زراعة أسنان (Implant)', 6, 3, 3, 1, datetime('now'), datetime('now')),
(14, 3, 'تجميل لثة (Gingivoplasty)', 8, 3, 2, 1, datetime('now'), datetime('now')),
(15, 3, 'كشط جذر (Root Planing)', 12, 2, 1, 1, datetime('now'), datetime('now')),
-- Course D works
(16, 4, 'علاج عصب أولي (RCT)', 10, 3, 2, 1, datetime('now'), datetime('now')),
(17, 4, 'علاج عصب ثانوي (Re-RCT)', 6, 3, 2, 1, datetime('now'), datetime('now')),
(18, 4, 'حشو قناة (Obturation)', 12, 3, 2, 1, datetime('now'), datetime('now')),
(19, 4, 'استئصال لب جزئي (Pulpotomy)', 8, 2, 1, 1, datetime('now'), datetime('now')),
(20, 4, 'علاج أسنان أطفال', 10, 2, 1, 1, datetime('now'), datetime('now'));

-- ================================================================================
-- 12. TABLE: course_student
-- Purpose: Many-to-many relation between courses and students
-- ================================================================================
CREATE TABLE IF NOT EXISTS course_student (
    id          INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    course_id   INTEGER NOT NULL,
    user_id     INTEGER NOT NULL,
    group_name  VARCHAR NULL,
    created_at  DATETIME NULL,
    updated_at  DATETIME NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(course_id, user_id)
);

CREATE INDEX IF NOT EXISTS idx_course_student_course_id ON course_student(course_id);
CREATE INDEX IF NOT EXISTS idx_course_student_user_id ON course_student(user_id);

-- Insert course-student relationships
INSERT INTO course_student (id, course_id, user_id, group_name, created_at, updated_at) VALUES
(1, 1, 1, 'المجموعة أ', datetime('now'), datetime('now')),
(2, 2, 1, 'المجموعة أ', datetime('now'), datetime('now')),
(3, 3, 1, 'المجموعة أ', datetime('now'), datetime('now')),
(4, 4, 1, 'المجموعة أ', datetime('now'), datetime('now')),
(5, 1, 2, 'المجموعة أ', datetime('now'), datetime('now')),
(6, 2, 2, 'المجموعة أ', datetime('now'), datetime('now'));

-- ================================================================================
-- 13. TABLE: patients
-- Purpose: Patient records (dental patients)
-- ================================================================================
CREATE TABLE IF NOT EXISTS patients (
    id               INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    record_number    VARCHAR NOT NULL UNIQUE,
    full_name        VARCHAR NOT NULL,
    phone            VARCHAR NULL,
    birth_year       INTEGER NULL,
    age              INTEGER NULL,
    gender           VARCHAR NOT NULL DEFAULT 'male',
    age_type         VARCHAR NOT NULL DEFAULT 'adult',
    access_type      VARCHAR NOT NULL DEFAULT 'private',
    governorate      VARCHAR NULL,
    address          VARCHAR NULL,
    notes            TEXT NULL,
    parent_name      VARCHAR NULL,
    parent_phone     VARCHAR NULL,
    parent_birth_year INTEGER NULL,
    added_by         INTEGER NOT NULL,
    created_at       DATETIME NULL,
    updated_at       DATETIME NULL,
    FOREIGN KEY (added_by) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_patients_record_number ON patients(record_number);
CREATE INDEX IF NOT EXISTS idx_patients_added_by ON patients(added_by);
CREATE INDEX IF NOT EXISTS idx_patients_phone ON patients(phone);

-- Insert sample patients
INSERT INTO patients (id, record_number, full_name, phone, birth_year, age, gender, age_type, access_type, governorate, address, notes, parent_name, parent_phone, parent_birth_year, added_by, created_at, updated_at) VALUES
(1, 'MED-2026-0001', 'أحمد محمد العلي', '0944111222', 1990, 36, 'male', 'adult', 'public', 'دمشق', 'شارع الحمزة', 'مريض منتظم', NULL, NULL, NULL, 1, datetime('now'), datetime('now')),
(2, 'MED-2026-0002', 'سارة خالد النجار', '0955333444', 1985, 41, 'female', 'adult', 'private', 'حلب', 'شارع النيل', 'تحتاج متابعة', NULL, NULL, NULL, 1, datetime('now'), datetime('now')),
(3, 'MED-2026-0003', 'محمد علي حسن', '0966555777', 1995, 31, 'male', 'adult', 'public', 'حمص', 'شارع الثورة', NULL, NULL, NULL, NULL, 1, datetime('now'), datetime('now')),
(4, 'MED-2026-0004', 'فاطمة أحمد', '0977888999', 2018, 8, 'female', 'child', 'private', 'دمشق', 'شارع الفردوس', 'طفلة', 'أحمد أحمد', '0988000111', 1985, 1, datetime('now'), datetime('now')),
(5, 'MED-2026-0005', 'عمر خالد الدوسري', '0999000111', 1978, 48, 'male', 'adult', 'public', 'اللاذقية', 'شارع البحر', 'مريض جديد', NULL, NULL, NULL, 1, datetime('now'), datetime('now')),
(6, 'MED-2026-0006', 'حسن يوسف', '0911222333', 2019, 7, 'male', 'child', 'private', 'طرطوس', 'شارع الجامعة', 'طفل', 'يوسف حسن', '0922333444', 1980, 1, datetime('now'), datetime('now'));

-- ================================================================================
-- 14. TABLE: patient_teeth
-- Purpose: Individual tooth conditions per patient (FDI numbering)
-- ================================================================================
CREATE TABLE IF NOT EXISTS patient_teeth (
    id            INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    patient_id    INTEGER NOT NULL,
    tooth_number  INTEGER NOT NULL,
    condition     VARCHAR NOT NULL DEFAULT 'healthy',
    sub_condition VARCHAR NULL,
    label         VARCHAR NULL,
    is_primary    TINYINT(1) NOT NULL DEFAULT 0,
    created_at    DATETIME NULL,
    updated_at    DATETIME NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    UNIQUE(patient_id, tooth_number)
);

CREATE INDEX IF NOT EXISTS idx_patient_teeth_patient_id ON patient_teeth(patient_id);

-- Insert sample teeth records
INSERT INTO patient_teeth (id, patient_id, tooth_number, condition, sub_condition, label, is_primary, created_at, updated_at) VALUES
(1, 1, 16, 'decayed', 'عميقة', 'ضرس علوي أيمن', 0, datetime('now'), datetime('now')),
(2, 1, 36, 'filled', 'تجميلي', 'ضرس سفلي أيسر', 0, datetime('now'), datetime('now')),
(3, 2, 11, 'healthy', NULL, 'قاطع علوي أيمن', 0, datetime('now'), datetime('now')),
(4, 3, 46, 'missing', 'مفقود', 'ضرس سفلي أيمن', 0, datetime('now'), datetime('now')),
(5, 4, 51, 'decayed', 'سطحية', 'قاطع طفولي علوي أيمن', 1, datetime('now'), datetime('now')),
(6, 5, 26, 'filled', 'خلفي', 'ضرس علوي أيسر', 0, datetime('now'), datetime('now')),
(7, 6, 71, 'healthy', NULL, 'قواطع طفولية سفلى', 1, datetime('now'), datetime('now'));

-- ================================================================================
-- 15. TABLE: patient_health
-- Purpose: Patient health conditions (diseases, diabetes, blood pressure)
-- ================================================================================
CREATE TABLE IF NOT EXISTS patient_health (
    id                  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    patient_id          INTEGER NOT NULL UNIQUE,
    diseases            TEXT NULL,
    diabetes_controlled TINYINT(1) NULL,
    bp_controlled       TINYINT(1) NULL,
    medications         TEXT NULL,
    allergies           TEXT NULL,
    surgery_history     TEXT NULL,
    pregnancy_status    VARCHAR NULL,
    pregnancy_month     INTEGER NULL,
    notes               TEXT NULL,
    created_at          DATETIME NULL,
    updated_at          DATETIME NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);

-- Insert sample health record
INSERT INTO patient_health (id, patient_id, diseases, diabetes_controlled, bp_controlled, medications, allergies, surgery_history, pregnancy_status, pregnancy_month, notes, created_at, updated_at) VALUES
(1, 1, '["سكري", "ضغط"]', 1, 1, 'ميتفورمين، كابتوبريل', 'لا يوجد', 'لا يوجد', NULL, NULL, 'مريض تحت السيطرة', datetime('now'), datetime('now'));

-- ================================================================================
-- 16. TABLE: patient_perio
-- Purpose: Periodontal (gum) health records per patient
-- ================================================================================
CREATE TABLE IF NOT EXISTS patient_perio (
    id              INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    patient_id      INTEGER NOT NULL,
    pocket_depth    VARCHAR NULL,
    bleeding_points INTEGER NULL,
    mobility        VARCHAR NULL,
    recession       VARCHAR NULL,
    furcation       VARCHAR NULL,
    plaque_index    VARCHAR NULL,
    calculus_index  VARCHAR NULL,
    notes           TEXT NULL,
    created_at      DATETIME NULL,
    updated_at      DATETIME NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_patient_perio_patient_id ON patient_perio(patient_id);

-- Insert sample perio record
INSERT INTO patient_perio (id, patient_id, pocket_depth, bleeding_points, mobility, recession, furcation, plaque_index, calculus_index, notes, created_at, updated_at) VALUES
(1, 1, '3-4mm', 5, 'درجة 1', 'بسيط', 'لا يوجد', 'متوسط', 'قليل', 'حالة لثية متوسطة', datetime('now'), datetime('now'));

-- ================================================================================
-- 17. TABLE: patient_access
-- Purpose: Patient access control (who can view/edit patient)
-- ================================================================================
CREATE TABLE IF NOT EXISTS patient_access (
    id          INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    patient_id  INTEGER NOT NULL,
    user_id     INTEGER NOT NULL,
    access_type VARCHAR NOT NULL DEFAULT 'view',
    created_at  DATETIME NULL,
    updated_at  DATETIME NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(patient_id, user_id)
);

CREATE INDEX IF NOT EXISTS idx_patient_access_patient_id ON patient_access(patient_id);
CREATE INDEX IF NOT EXISTS idx_patient_access_user_id ON patient_access(user_id);

-- ================================================================================
-- 18. TABLE: panorama_images
-- Purpose: Panorama X-ray images per patient
-- ================================================================================
CREATE TABLE IF NOT EXISTS panorama_images (
    id           INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    patient_id   INTEGER NOT NULL,
    image_path   VARCHAR NOT NULL,
    uploaded_by  INTEGER NOT NULL,
    uploaded_at  DATETIME NULL,
    notes        TEXT NULL,
    created_at   DATETIME NULL,
    updated_at   DATETIME NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_panorama_images_patient_id ON panorama_images(patient_id);

-- ================================================================================
-- 19. TABLE: reservations
-- Purpose: Patient reservation for clinical sessions
-- ================================================================================
CREATE TABLE IF NOT EXISTS reservations (
    id           INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    patient_id   INTEGER NOT NULL,
    user_id      INTEGER NOT NULL,
    course_id    INTEGER NOT NULL,
    status       VARCHAR NOT NULL DEFAULT 'temporary',
    confirmed_at DATETIME NULL,
    cancelled_at DATETIME NULL,
    expires_at   DATETIME NULL,
    created_at   DATETIME NULL,
    updated_at   DATETIME NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_reservations_patient_id ON reservations(patient_id);
CREATE INDEX IF NOT EXISTS idx_reservations_user_id ON reservations(user_id);
CREATE INDEX IF NOT EXISTS idx_reservations_course_id ON reservations(course_id);
CREATE INDEX IF NOT EXISTS idx_reservations_status ON reservations(status);

-- Insert sample reservations
INSERT INTO reservations (id, patient_id, user_id, course_id, status, confirmed_at, cancelled_at, expires_at, created_at, updated_at) VALUES
(1, 1, 1, 1, 'confirmed', datetime('now'), NULL, datetime('now', '+7 days'), datetime('now'), datetime('now')),
(2, 2, 1, 4, 'confirmed', datetime('now'), NULL, datetime('now', '+7 days'), datetime('now'), datetime('now')),
(3, 3, 1, 1, 'confirmed', datetime('now'), NULL, datetime('now', '+7 days'), datetime('now'), datetime('now')),
(4, 5, 1, 2, 'confirmed', datetime('now'), NULL, datetime('now', '+7 days'), datetime('now'), datetime('now')),
(5, 6, 1, 4, 'confirmed', datetime('now'), NULL, datetime('now', '+7 days'), datetime('now'), datetime('now'));

-- ================================================================================
-- 20. TABLE: cancel_reasons
-- Purpose: Reasons for reservation cancellation
-- ================================================================================
CREATE TABLE IF NOT EXISTS cancel_reasons (
    id             INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    reservation_id INTEGER NOT NULL,
    user_id        INTEGER NOT NULL,
    reason         TEXT NOT NULL,
    created_at     DATETIME NULL,
    updated_at     DATETIME NULL,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_cancel_reasons_reservation_id ON cancel_reasons(reservation_id);

-- ================================================================================
-- 21. TABLE: dental_cases
-- Purpose: Clinical cases (dental treatments submitted by students)
-- ================================================================================
CREATE TABLE IF NOT EXISTS dental_cases (
    id               INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    patient_id       INTEGER NOT NULL,
    user_id          INTEGER NOT NULL,
    course_id        INTEGER NOT NULL,
    reservation_id   INTEGER NULL,
    tooth_number     INTEGER NULL,
    treatment_type   VARCHAR NULL,
    treatment_label  VARCHAR NULL,
    description      TEXT NULL,
    status           VARCHAR NOT NULL DEFAULT 'pending',
    supervisor_notes TEXT NULL,
    evaluated_at     DATETIME NULL,
    evaluated_by     INTEGER NULL,
    is_grant         TINYINT(1) NOT NULL DEFAULT 0,
    evaluation_count INTEGER NOT NULL DEFAULT 0,
    session_date     DATE NULL,
    created_at       DATETIME NULL,
    updated_at       DATETIME NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE SET NULL,
    FOREIGN KEY (evaluated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE INDEX IF NOT EXISTS idx_dental_cases_patient_id ON dental_cases(patient_id);
CREATE INDEX IF NOT EXISTS idx_dental_cases_user_id ON dental_cases(user_id);
CREATE INDEX IF NOT EXISTS idx_dental_cases_course_id ON dental_cases(course_id);
CREATE INDEX IF NOT EXISTS idx_dental_cases_status ON dental_cases(status);

-- ================================================================================
-- 22. TABLE: case_evaluations
-- Purpose: Per-stage evaluation of cases by supervisors
-- ================================================================================
CREATE TABLE IF NOT EXISTS case_evaluations (
    id           INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    case_id      INTEGER NOT NULL,
    evaluator_id INTEGER NOT NULL,
    stage        INTEGER NOT NULL,
    stage_name   VARCHAR NULL,
    grade        VARCHAR NULL,
    notes        TEXT NULL,
    evaluated_at DATETIME NULL,
    created_at   DATETIME NULL,
    updated_at   DATETIME NULL,
    FOREIGN KEY (case_id) REFERENCES dental_cases(id) ON DELETE CASCADE,
    FOREIGN KEY (evaluator_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(case_id, stage)
);

CREATE INDEX IF NOT EXISTS idx_case_evaluations_case_id ON case_evaluations(case_id);
CREATE INDEX IF NOT EXISTS idx_case_evaluations_evaluator_id ON case_evaluations(evaluator_id);

-- ================================================================================
-- 23. TABLE: case_grants
-- Purpose: Grant system - students can give extra cases to other students
-- ================================================================================
CREATE TABLE IF NOT EXISTS case_grants (
    id            INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    case_id       INTEGER NOT NULL,
    granter_id    INTEGER NOT NULL,
    grantee_id    INTEGER NOT NULL,
    course_id     INTEGER NOT NULL,
    status        VARCHAR NOT NULL DEFAULT 'pending',
    cancel_reason TEXT NULL,
    responded_at  DATETIME NULL,
    created_at    DATETIME NULL,
    updated_at    DATETIME NULL,
    FOREIGN KEY (case_id) REFERENCES dental_cases(id) ON DELETE CASCADE,
    FOREIGN KEY (granter_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (grantee_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_case_grants_case_id ON case_grants(case_id);
CREATE INDEX IF NOT EXISTS idx_case_grants_granter_id ON case_grants(granter_id);
CREATE INDEX IF NOT EXISTS idx_case_grants_grantee_id ON case_grants(grantee_id);
CREATE INDEX IF NOT EXISTS idx_case_grants_status ON case_grants(status);

-- ================================================================================
-- 24. TABLE: case_images
-- Purpose: Images uploaded for each case
-- ================================================================================
CREATE TABLE IF NOT EXISTS case_images (
    id          INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    case_id     INTEGER NOT NULL,
    image_path  VARCHAR NOT NULL,
    stage       INTEGER NULL,
    uploaded_by INTEGER NOT NULL,
    uploaded_at DATETIME NULL,
    notes       TEXT NULL,
    created_at  DATETIME NULL,
    updated_at  DATETIME NULL,
    FOREIGN KEY (case_id) REFERENCES dental_cases(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_case_images_case_id ON case_images(case_id);

-- ================================================================================
-- 25. TABLE: otp_codes
-- Purpose: One-time password codes for password reset
-- ================================================================================
CREATE TABLE IF NOT EXISTS otp_codes (
    id              INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    user_id         INTEGER NOT NULL,
    code            VARCHAR NOT NULL,
    ip_address      VARCHAR NULL,
    expires_at      DATETIME NOT NULL,
    used            TINYINT(1) NOT NULL DEFAULT 0,
    used_at         DATETIME NULL,
    attempts        INTEGER NOT NULL DEFAULT 0,
    phone_number    VARCHAR NULL,
    delivery_method VARCHAR NOT NULL DEFAULT 'manual',
    created_at      DATETIME NULL,
    updated_at      DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_otp_codes_user_id ON otp_codes(user_id);
CREATE INDEX IF NOT EXISTS idx_otp_codes_code ON otp_codes(code);
CREATE INDEX IF NOT EXISTS idx_otp_codes_expires_at ON otp_codes(expires_at);

-- ================================================================================
-- 26. TABLE: audit_logs
-- Purpose: System audit trail for all important actions
-- ================================================================================
CREATE TABLE IF NOT EXISTS audit_logs (
    id         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    user_id    INTEGER NULL,
    action     VARCHAR NOT NULL,
    model      VARCHAR NULL,
    model_id   INTEGER NULL,
    old_data   TEXT NULL,
    new_data   TEXT NULL,
    ip_address VARCHAR NULL,
    user_agent TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE INDEX IF NOT EXISTS idx_audit_logs_user_id ON audit_logs(user_id);
CREATE INDEX IF NOT EXISTS idx_audit_logs_action ON audit_logs(action);
CREATE INDEX IF NOT EXISTS idx_audit_logs_model ON audit_logs(model, model_id);
CREATE INDEX IF NOT EXISTS idx_audit_logs_created_at ON audit_logs(created_at);

-- Insert sample audit logs
INSERT INTO audit_logs (id, user_id, action, model, model_id, old_data, new_data, ip_address, user_agent, created_at, updated_at) VALUES
(1, 1, 'login', 'User', 1, NULL, '{"ip": "192.168.1.1"}', '192.168.1.1', 'Mozilla/5.0', datetime('now'), datetime('now')),
(2, 1, 'patient_created', 'Patient', 1, NULL, '{"name": "أحمد محمد العلي"}', '192.168.1.1', 'Mozilla/5.0', datetime('now'), datetime('now')),
(3, 1, 'reservation_created', 'Reservation', 1, NULL, '{"patient_id": 1, "course_id": 1}', '192.168.1.1', 'Mozilla/5.0', datetime('now'), datetime('now')),
(4, 3, 'login', 'User', 3, NULL, '{"ip": "192.168.1.2"}', '192.168.1.2', 'Mozilla/5.0', datetime('now'), datetime('now')),
(5, 4, 'login', 'User', 4, NULL, '{"ip": "192.168.1.3"}', '192.168.1.3', 'Mozilla/5.0', datetime('now'), datetime('now'));

-- ================================================================================
-- 27. TABLE: migrations
-- Purpose: Laravel migration tracking
-- ================================================================================
CREATE TABLE IF NOT EXISTS migrations (
    id        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    migration VARCHAR NOT NULL,
    batch     INTEGER NOT NULL
);

-- Insert migration records
INSERT INTO migrations (id, migration, batch) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_02_000001_create_courses_table', 1),
(5, '2024_01_02_000002_create_patients_table', 1),
(6, '2024_01_02_000003_create_reservations_table', 1),
(7, '2024_01_02_000004_create_cases_table', 1),
(8, '2024_01_02_000005_create_audit_and_otp_tables', 1),
(9, '2024_01_03_000001_add_system_tables', 1);

-- ================================================================================
-- SECURITY & PERMISSIONS VIEWS
-- ================================================================================

-- View: User permissions summary
CREATE VIEW IF NOT EXISTS v_user_permissions AS
SELECT 
    u.id as user_id,
    u.name as user_name,
    u.email,
    r.name as role_name,
    r.label as role_label,
    CASE 
        WHEN r.name = 'ayham' THEN 'all'
        WHEN r.name = 'admin' THEN 'admin,read,write'
        WHEN r.name = 'supervisor' THEN 'evaluate,read'
        WHEN r.name = 'student' THEN 'student,read,write'
        ELSE 'read'
    END as permissions
FROM users u
JOIN roles r ON u.role_id = r.id
WHERE u.is_active = 1;

-- View: Active reservations with details
CREATE VIEW IF NOT EXISTS v_active_reservations AS
SELECT 
    r.id,
    r.status,
    r.confirmed_at,
    r.expires_at,
    p.record_number,
    p.full_name as patient_name,
    p.phone as patient_phone,
    u.name as student_name,
    u.student_id,
    c.name as course_name,
    c.code as course_code
FROM reservations r
JOIN patients p ON r.patient_id = p.id
JOIN users u ON r.user_id = u.id
JOIN courses c ON r.course_id = c.id
WHERE r.status IN ('temporary', 'confirmed');

-- View: Case statistics
CREATE VIEW IF NOT EXISTS v_case_statistics AS
SELECT 
    dc.course_id,
    c.name as course_name,
    COUNT(*) as total_cases,
    SUM(CASE WHEN dc.status = 'pending' THEN 1 ELSE 0 END) as pending_cases,
    SUM(CASE WHEN dc.status = 'accepted' THEN 1 ELSE 0 END) as accepted_cases,
    SUM(CASE WHEN dc.status = 'completed' THEN 1 ELSE 0 END) as completed_cases,
    SUM(CASE WHEN dc.status = 'rejected' THEN 1 ELSE 0 END) as rejected_cases
FROM dental_cases dc
JOIN courses c ON dc.course_id = c.id
GROUP BY dc.course_id, c.name;

-- ================================================================================
-- SECURITY TRIGGERS (Simulated via application layer in Laravel)
-- ================================================================================

-- Note: SQLite doesn't support complex triggers like MySQL/PostgreSQL
-- Security features are implemented in Laravel application layer:
-- 1. Authentication via Laravel Sanctum
-- 2. Authorization via Laravel Policies
-- 3. Audit logging via Laravel Observers
-- 4. Rate limiting via Laravel Middleware
-- 5. Input validation via Laravel Form Requests

-- ================================================================================
-- END OF DATABASE SCHEMA
-- ================================================================================
