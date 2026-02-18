<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseEvaluationStage;
use App\Models\CourseRule;
use App\Models\CourseSchedule;
use App\Models\CourseWork;
use App\Models\Patient;
use App\Models\PatientTooth;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Roles =====
        $studentRole = Role::firstOrCreate(['name' => 'student'], ['label' => 'طالب']);
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['label' => 'مشرف إداري']);
        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor'], ['label' => 'مشرف سريري']);
        $ayhamRole = Role::firstOrCreate(['name' => 'ayham'], ['label' => 'مدير النظام']);

        // ===== Users =====
        $studentUser = User::firstOrCreate(
            ['student_id' => '202312345'],
            ['name' => 'أيهم رياض حمشدو', 'email' => 'student@multaqa.com', 'phone' => '0935123456', 'role_id' => $studentRole->id, 'password' => 'Student@123']
        );

        $student2 = User::firstOrCreate(
            ['student_id' => '202398765'],
            ['name' => 'خالد العمر', 'email' => 'khaled@multaqa.com', 'phone' => '0937654321', 'role_id' => $studentRole->id, 'password' => 'Student@123']
        );

        User::firstOrCreate(
            ['student_id' => 'admin'],
            ['name' => 'المشرف الإداري', 'email' => 'admin@multaqa.com', 'phone' => '0911111111', 'role_id' => $adminRole->id, 'password' => 'Admin@123']
        );

        User::firstOrCreate(
            ['student_id' => 'supervisor'],
            ['name' => 'المشرف السريري', 'email' => 'supervisor@multaqa.com', 'phone' => '0922222222', 'role_id' => $supervisorRole->id, 'password' => 'Super@123']
        );

        User::firstOrCreate(
            ['student_id' => 'ayham'],
            ['name' => 'أيهم - مدير النظام', 'email' => 'ayham@multaqa.com', 'phone' => '0933333333', 'role_id' => $ayhamRole->id, 'password' => 'Ayham@123']
        );

        // ===== Courses =====
        $restorative = Course::firstOrCreate(
            ['slug' => 'restorative4'],
            ['code' => 'A', 'name' => 'مداواة الأسنان الترميمية 4', 'supervisors' => 'د.أحمد النجار - د.أنس أحمد', 'schedule' => 'السبت 8:00 - 12:00', 'location' => 'عيادة الترميم 10', 'max_reservations' => 2, 'session_limit' => 2]
        );

        $exodontia = Course::firstOrCreate(
            ['slug' => 'exodontia4'],
            ['code' => 'B', 'name' => 'تخدير و قلع الأسنان 4', 'supervisors' => 'د.خالد محمود - د.محمد خالد', 'schedule' => 'الأحد 9:00 - 13:00', 'location' => 'عيادة الجراحة 7', 'max_reservations' => 3, 'session_limit' => 3]
        );

        $periodontics = Course::firstOrCreate(
            ['slug' => 'periodontics2'],
            ['code' => 'C', 'name' => 'النسج حول سنية 2', 'supervisors' => 'د.سارة عبدالله - د.فاطمة الزهراء', 'schedule' => 'الثلاثاء 10:00 - 14:00', 'location' => 'عيادة اللثة 15', 'max_reservations' => 2, 'session_limit' => 2]
        );

        $endodontics = Course::firstOrCreate(
            ['slug' => 'endodontics4'],
            ['code' => 'D', 'name' => 'مداواة الأسنان اللبية 4', 'supervisors' => 'د.لينا حسن - د.عمرو خالد', 'schedule' => 'الأربعاء 8:00 - 11:00', 'location' => 'عيادة العلاج اللبي 3', 'max_reservations' => 2, 'session_limit' => 2]
        );

        // Enroll students in courses
        $studentUser->courses()->syncWithoutDetaching([$restorative->id, $exodontia->id, $periodontics->id, $endodontics->id]);
        $student2->courses()->syncWithoutDetaching([$restorative->id, $exodontia->id]);

        // ===== Course Schedules =====
        $schedules = [
            [$restorative->id, null, 'saturday', '08:00', '12:00', 'عيادة الترميم 10'],
            [$exodontia->id, null, 'sunday', '09:00', '13:00', 'عيادة الجراحة 7'],
            [$periodontics->id, null, 'tuesday', '10:00', '14:00', 'عيادة اللثة 15'],
            [$endodontics->id, null, 'wednesday', '08:00', '11:00', 'عيادة العلاج اللبي 3'],
        ];
        foreach ($schedules as [$cid, $group, $day, $start, $end, $loc]) {
            CourseSchedule::firstOrCreate(
                ['course_id' => $cid, 'day_of_week' => $day],
                ['group_name' => $group, 'start_time' => $start, 'end_time' => $end, 'location' => $loc]
            );
        }

        // ===== Course Rules =====
        foreach ([$restorative, $exodontia, $periodontics, $endodontics] as $course) {
            CourseRule::firstOrCreate(
                ['course_id' => $course->id],
                ['max_cases_per_session' => $course->session_limit ?? 2, 'allow_grants' => true, 'grant_unlimited' => true, 'prevent_duplicate_tooth' => true]
            );
        }

        // ===== Course Evaluation Stages =====
        $evalStages = [
            [$restorative->id, 1, 'فحص أولي', 1, false],
            [$restorative->id, 2, 'تنفيذ المعالجة', 2, false],
            [$restorative->id, 3, 'متابعة نهائية', 1, true],
            [$exodontia->id, 1, 'تشخيص وتخطيط', 1, true],
            [$exodontia->id, 2, 'تنفيذ القلع', 2, false],
            [$exodontia->id, 3, 'متابعة ما بعد القلع', 1, false],
            [$periodontics->id, 1, 'فحص أولي', 1, false],
            [$periodontics->id, 2, 'العلاج', 2, false],
            [$periodontics->id, 3, 'تقييم نهائي', 1, false],
            [$endodontics->id, 1, 'تشخيص وأشعة', 1, true],
            [$endodontics->id, 2, 'تنفيذ العلاج اللبي', 2, true],
            [$endodontics->id, 3, 'حشو قناة نهائي', 1, true],
        ];
        foreach ($evalStages as [$cid, $num, $name, $imgs, $panorama]) {
            CourseEvaluationStage::firstOrCreate(
                ['course_id' => $cid, 'stage_number' => $num],
                ['stage_name' => $name, 'required_images' => $imgs, 'requires_panorama' => $panorama]
            );
        }

        // ===== Course Works =====
        $this->createWorks($restorative, [
            ['حشوة تجميلية (كومبوزيت)', 10, 3, 2, false],
            ['تاج دائم (Crown)', 8, 3, 2, false],
            ['جسر سنّي ثابت (Bridge)', 6, 3, 2, true],
            ['ترميم ما بعد القلع', 4, 2, 1, false],
            ['حشوة زجاجية (GIC)', 12, 3, 2, false],
        ]);

        $this->createWorks($exodontia, [
            ['خلع سن عقل مدفون', 8, 3, 2, true],
            ['خلع جراحي بسيط', 10, 2, 1, false],
            ['خلع جراحي معقد', 6, 3, 2, true],
            ['تخدير سطحي (Infiltration)', 15, 2, 1, false],
            ['تخدير عظمي (Block)', 10, 2, 1, false],
        ]);

        $this->createWorks($periodontics, [
            ['تنظيف جيب عميق (Scaling)', 15, 2, 1, false],
            ['جراحة إعادة تشكيل اللثة', 8, 3, 2, false],
            ['زراعة أسنان (Implant)', 6, 3, 3, true],
            ['تجميل لثة (Gingivoplasty)', 8, 3, 2, false],
            ['كشط جذر (Root Planing)', 12, 2, 1, false],
        ]);

        $this->createWorks($endodontics, [
            ['علاج عصب أولي (RCT)', 10, 3, 2, true],
            ['علاج عصب ثانوي (Re-RCT)', 6, 3, 2, true],
            ['حشو قناة (Obturation)', 12, 3, 2, true],
            ['استئصال لب جزئي (Pulpotomy)', 8, 2, 1, false],
            ['علاج أسنان أطفال', 10, 2, 1, false],
        ]);

        // ===== Test Patients =====
        $patient1 = Patient::firstOrCreate(
            ['record_number' => 'MED-2026-0001'],
            ['full_name' => 'أحمد محمد العلي', 'phone' => '0935123456', 'birth_year' => 1990, 'age' => 36, 'gender' => 'male', 'age_type' => 'adult', 'access_type' => 'public', 'governorate' => 'دمشق', 'address' => 'دمشق - المزة', 'added_by' => $studentUser->id]
        );

        $patient2 = Patient::firstOrCreate(
            ['record_number' => 'MED-2026-0002'],
            ['full_name' => 'سارة خالد النجار', 'phone' => '0987654321', 'birth_year' => 1985, 'age' => 41, 'gender' => 'female', 'age_type' => 'adult', 'access_type' => 'private', 'governorate' => 'دمشق', 'address' => 'دمشق - المالكي', 'added_by' => $studentUser->id]
        );

        $patient3 = Patient::firstOrCreate(
            ['record_number' => 'MED-2026-0003'],
            ['full_name' => 'محمد علي حسن', 'phone' => '0912345678', 'birth_year' => 1995, 'age' => 31, 'gender' => 'male', 'age_type' => 'adult', 'access_type' => 'public', 'governorate' => 'حلب', 'address' => 'حلب - الجميلية', 'added_by' => $studentUser->id]
        );

        $patient4 = Patient::firstOrCreate(
            ['record_number' => 'MED-2026-0004'],
            ['full_name' => 'فاطمة أحمد', 'phone' => '0998765432', 'birth_year' => 2018, 'age' => 8, 'gender' => 'female', 'age_type' => 'child', 'access_type' => 'private', 'parent_name' => 'أحمد محمد', 'parent_phone' => '0912345678', 'added_by' => $studentUser->id]
        );

        $patient5 = Patient::firstOrCreate(
            ['record_number' => 'MED-2026-0005'],
            ['full_name' => 'عمر خالد الدوسري', 'phone' => '0944556677', 'birth_year' => 1978, 'age' => 48, 'gender' => 'male', 'age_type' => 'adult', 'access_type' => 'public', 'governorate' => 'حمص', 'address' => 'حمص - الوعر', 'added_by' => $studentUser->id]
        );

        // Patient teeth
        $teethData = [
            [$patient1->id, 36, 'restorative', 'class2'],
            [$patient1->id, 46, 'restorative', 'class3'],
            [$patient2->id, 14, 'endodontic', null],
            [$patient2->id, 25, 'extraction', 'simple'],
            [$patient3->id, 37, 'restorative', 'class4'],
            [$patient5->id, 48, 'extraction', 'surgical'],
        ];
        foreach ($teethData as [$pid, $num, $cond, $sub]) {
            PatientTooth::firstOrCreate(
                ['patient_id' => $pid, 'tooth_number' => $num],
                ['condition' => $cond, 'sub_condition' => $sub]
            );
        }

        // ===== Reservations =====
        Reservation::firstOrCreate(
            ['patient_id' => $patient1->id, 'user_id' => $studentUser->id, 'course_id' => $restorative->id],
            ['status' => 'confirmed', 'confirmed_at' => now()]
        );

        Reservation::firstOrCreate(
            ['patient_id' => $patient2->id, 'user_id' => $studentUser->id, 'course_id' => $endodontics->id],
            ['status' => 'confirmed', 'confirmed_at' => now()]
        );

        Reservation::firstOrCreate(
            ['patient_id' => $patient3->id, 'user_id' => $studentUser->id, 'course_id' => $restorative->id],
            ['status' => 'confirmed', 'confirmed_at' => now()]
        );

        Reservation::firstOrCreate(
            ['patient_id' => $patient5->id, 'user_id' => $studentUser->id, 'course_id' => $exodontia->id],
            ['status' => 'confirmed', 'confirmed_at' => now()]
        );
    }

    private function createWorks(Course $course, array $works): void
    {
        foreach ($works as [$name, $required, $evalStages, $reqImages, $reqPanorama]) {
            CourseWork::firstOrCreate(
                ['course_id' => $course->id, 'name' => $name],
                ['required_count' => $required, 'evaluation_stages' => $evalStages, 'required_images' => $reqImages, 'requires_panorama' => $reqPanorama]
            );
        }
    }
}
