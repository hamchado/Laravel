<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * منصة ملتقى - نظام إدارة عيادة الأسنان
     * Multaqa Dental Platform - Database Seeder
     */
    public function run(): void
    {
        $this->command->info('🦷 بدء تعبئة قاعدة بيانات منصة ملتقى...');
        
        // 1. Seed Roles (الأدوار)
        $this->seedRoles();
        
        // 2. Seed Users (المستخدمين)
        $this->seedUsers();
        
        // 3. Seed Courses (المقررات)
        $this->seedCourses();
        
        // 4. Seed Course Schedules (جداول المقررات)
        $this->seedCourseSchedules();
        
        // 5. Seed Course Rules (قواعد المقررات)
        $this->seedCourseRules();
        
        // 6. Seed Course Evaluation Stages (مراحل التقييم)
        $this->seedCourseEvaluationStages();
        
        // 7. Seed Course Works (أعمال المقررات)
        $this->seedCourseWorks();
        
        // 8. Seed Course Student Relations (علاقات الطلاب بالمقررات)
        $this->seedCourseStudents();
        
        // 9. Seed Patients (المرضى)
        $this->seedPatients();
        
        // 10. Seed Patient Teeth (أسنان المرضى)
        $this->seedPatientTeeth();
        
        // 11. Seed Patient Health (الحالة الصحية)
        $this->seedPatientHealth();
        
        // 12. Seed Patient Perio (الحالة اللثوية)
        $this->seedPatientPerio();
        
        // 13. Seed Reservations (الحجوزات)
        $this->seedReservations();
        
        // 14. Seed Audit Logs (سجلات المراقبة)
        $this->seedAuditLogs();
        
        // 15. Seed Migrations (تسجيل الهجرات)
        $this->seedMigrations();
        
        $this->command->info('✅ تمت تعبئة قاعدة البيانات بنجاح!');
        $this->command->info('');
        $this->command->info('🔑 بيانات تسجيل الدخول الافتراضية:');
        $this->command->info('   - الطالب: student@multaqa.com / Student@123');
        $this->command->info('   - المشرف الإداري: admin@multaqa.com / Admin@123');
        $this->command->info('   - المشرف السريري: supervisor@multaqa.com / Super@123');
        $this->command->info('   - مدير النظام: ayham@multaqa.com / Ayham@123');
    }

    /**
     * Seed Roles - الأدوار
     */
    private function seedRoles(): void
    {
        $this->command->info('  📋 تعبئة الأدوار...');
        
        $roles = [
            ['id' => 1, 'name' => 'student', 'label' => 'طالب'],
            ['id' => 2, 'name' => 'admin', 'label' => 'مشرف إداري'],
            ['id' => 3, 'name' => 'supervisor', 'label' => 'مشرف سريري'],
            ['id' => 4, 'name' => 'ayham', 'label' => 'مدير النظام'],
        ];
        
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']],
                array_merge($role, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Users - المستخدمين
     */
    private function seedUsers(): void
    {
        $this->command->info('  👥 تعبئة المستخدمين...');
        
        $users = [
            [
                'id' => 1,
                'student_id' => '202312345',
                'name' => 'أيهم رياض حمشدو',
                'email' => 'student@multaqa.com',
                'role_id' => 1,
                'password' => Hash::make('Student@123'),
                'phone' => '0935123456',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'student_id' => '202398765',
                'name' => 'خالد العمر',
                'email' => 'khaled@multaqa.com',
                'role_id' => 1,
                'password' => Hash::make('Student@123'),
                'phone' => '0937654321',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'student_id' => 'admin',
                'name' => 'المشرف الإداري',
                'email' => 'admin@multaqa.com',
                'role_id' => 2,
                'password' => Hash::make('Admin@123'),
                'phone' => '0911111111',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'student_id' => 'supervisor',
                'name' => 'المشرف السريري',
                'email' => 'supervisor@multaqa.com',
                'role_id' => 3,
                'password' => Hash::make('Super@123'),
                'phone' => '0922222222',
                'is_active' => true,
            ],
            [
                'id' => 5,
                'student_id' => 'ayham',
                'name' => 'أيهم - مدير النظام',
                'email' => 'ayham@multaqa.com',
                'role_id' => 4,
                'password' => Hash::make('Ayham@123'),
                'phone' => '0933333333',
                'is_active' => true,
            ],
        ];
        
        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['id' => $user['id']],
                array_merge($user, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Courses - المقررات
     */
    private function seedCourses(): void
    {
        $this->command->info('  📚 تعبئة المقررات...');
        
        $courses = [
            [
                'id' => 1,
                'code' => 'A',
                'slug' => 'course-a',
                'name' => 'مداواة الأسنان الترميمية 4',
                'supervisors' => 'د. أحمد الخطيب، د. سارة القاسم',
                'schedule' => 'السبت 8:00-12:00',
                'location' => 'عيادة الترميم 10',
                'max_reservations' => 2,
                'session_limit' => 2,
                'is_active' => true,
            ],
            [
                'id' => 2,
                'code' => 'B',
                'slug' => 'course-b',
                'name' => 'تخدير و قلع الأسنان 4',
                'supervisors' => 'د. محمد العلي، د. فاطمة الزهراء',
                'schedule' => 'الأحد 9:00-13:00',
                'location' => 'عيادة الجراحة 7',
                'max_reservations' => 3,
                'session_limit' => 3,
                'is_active' => true,
            ],
            [
                'id' => 3,
                'code' => 'C',
                'slug' => 'course-c',
                'name' => 'النسج حول سنية 2',
                'supervisors' => 'د. خالد العمر، د. ليلى الحسن',
                'schedule' => 'الثلاثاء 10:00-14:00',
                'location' => 'عيادة اللثة 15',
                'max_reservations' => 2,
                'session_limit' => 2,
                'is_active' => true,
            ],
            [
                'id' => 4,
                'code' => 'D',
                'slug' => 'course-d',
                'name' => 'مداواة الأسنان اللبية 4',
                'supervisors' => 'د. يوسف الدين، د. نور الهدى',
                'schedule' => 'الأربعاء 8:00-11:00',
                'location' => 'عيادة العلاج اللبي 3',
                'max_reservations' => 2,
                'session_limit' => 2,
                'is_active' => true,
            ],
        ];
        
        foreach ($courses as $course) {
            DB::table('courses')->updateOrInsert(
                ['id' => $course['id']],
                array_merge($course, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Course Schedules - جداول المقررات
     */
    private function seedCourseSchedules(): void
    {
        $this->command->info('  📅 تعبئة جداول المقررات...');
        
        $schedules = [
            ['id' => 1, 'course_id' => 1, 'group_name' => 'المجموعة أ', 'day_of_week' => 'saturday', 'start_time' => '08:00', 'end_time' => '12:00', 'location' => 'عيادة الترميم 10'],
            ['id' => 2, 'course_id' => 2, 'group_name' => 'المجموعة أ', 'day_of_week' => 'sunday', 'start_time' => '09:00', 'end_time' => '13:00', 'location' => 'عيادة الجراحة 7'],
            ['id' => 3, 'course_id' => 3, 'group_name' => 'المجموعة أ', 'day_of_week' => 'tuesday', 'start_time' => '10:00', 'end_time' => '14:00', 'location' => 'عيادة اللثة 15'],
            ['id' => 4, 'course_id' => 4, 'group_name' => 'المجموعة أ', 'day_of_week' => 'wednesday', 'start_time' => '08:00', 'end_time' => '11:00', 'location' => 'عيادة العلاج اللبي 3'],
        ];
        
        foreach ($schedules as $schedule) {
            DB::table('course_schedules')->updateOrInsert(
                ['id' => $schedule['id']],
                array_merge($schedule, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Course Rules - قواعد المقررات
     */
    private function seedCourseRules(): void
    {
        $this->command->info('  ⚖️ تعبئة قواعد المقررات...');
        
        $rules = [
            ['id' => 1, 'course_id' => 1, 'max_cases_per_session' => 2, 'allow_grants' => true, 'grant_unlimited' => true, 'prevent_duplicate_tooth' => true, 'notes' => 'قواعد المقرر أ'],
            ['id' => 2, 'course_id' => 2, 'max_cases_per_session' => 3, 'allow_grants' => true, 'grant_unlimited' => true, 'prevent_duplicate_tooth' => true, 'notes' => 'قواعد المقرر ب'],
            ['id' => 3, 'course_id' => 3, 'max_cases_per_session' => 2, 'allow_grants' => true, 'grant_unlimited' => true, 'prevent_duplicate_tooth' => true, 'notes' => 'قواعد المقرر ج'],
            ['id' => 4, 'course_id' => 4, 'max_cases_per_session' => 2, 'allow_grants' => true, 'grant_unlimited' => true, 'prevent_duplicate_tooth' => true, 'notes' => 'قواعد المقرر د'],
        ];
        
        foreach ($rules as $rule) {
            DB::table('course_rules')->updateOrInsert(
                ['id' => $rule['id']],
                array_merge($rule, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Course Evaluation Stages - مراحل التقييم
     */
    private function seedCourseEvaluationStages(): void
    {
        $this->command->info('  📊 تعبئة مراحل التقييم...');
        
        $stages = [
            // Course A stages
            ['id' => 1, 'course_id' => 1, 'stage_number' => 1, 'stage_name' => 'فحص أولي', 'required_images' => 1, 'requires_panorama' => false, 'description' => 'الفحص الأولي للحالة'],
            ['id' => 2, 'course_id' => 1, 'stage_number' => 2, 'stage_name' => 'تنفيذ المعالجة', 'required_images' => 2, 'requires_panorama' => false, 'description' => 'تنفيذ الإجراء العلاجي'],
            ['id' => 3, 'course_id' => 1, 'stage_number' => 3, 'stage_name' => 'متابعة نهائية', 'required_images' => 1, 'requires_panorama' => true, 'description' => 'المتابعة النهائية مع بانوراما'],
            // Course B stages
            ['id' => 4, 'course_id' => 2, 'stage_number' => 1, 'stage_name' => 'فحص قبل القلع', 'required_images' => 1, 'requires_panorama' => false, 'description' => 'الفحص قبل إجراء القلع'],
            ['id' => 5, 'course_id' => 2, 'stage_number' => 2, 'stage_name' => 'إجراء القلع', 'required_images' => 2, 'requires_panorama' => false, 'description' => 'إجراء عملية القلع'],
            ['id' => 6, 'course_id' => 2, 'stage_number' => 3, 'stage_name' => 'متابعة ما بعد القلع', 'required_images' => 1, 'requires_panorama' => true, 'description' => 'المتابعة بعد القلع'],
            // Course C stages
            ['id' => 7, 'course_id' => 3, 'stage_number' => 1, 'stage_name' => 'فحص لثوي', 'required_images' => 1, 'requires_panorama' => false, 'description' => 'الفحص اللثوي الأولي'],
            ['id' => 8, 'course_id' => 3, 'stage_number' => 2, 'stage_name' => 'تنظيف جيب عميق', 'required_images' => 2, 'requires_panorama' => false, 'description' => 'إجراء التنظيف العميق'],
            ['id' => 9, 'course_id' => 3, 'stage_number' => 3, 'stage_name' => 'متابعة لثوية', 'required_images' => 1, 'requires_panorama' => true, 'description' => 'المتابعة اللثوية النهائية'],
            // Course D stages
            ['id' => 10, 'course_id' => 4, 'stage_number' => 1, 'stage_name' => 'فحص عصبي', 'required_images' => 1, 'requires_panorama' => false, 'description' => 'الفحص العصبي الأولي'],
            ['id' => 11, 'course_id' => 4, 'stage_number' => 2, 'stage_name' => 'علاج العصب', 'required_images' => 2, 'requires_panorama' => false, 'description' => 'إجراء علاج العصب'],
            ['id' => 12, 'course_id' => 4, 'stage_number' => 3, 'stage_name' => 'حشو قناة', 'required_images' => 1, 'requires_panorama' => true, 'description' => 'حشو قناة الجذر'],
        ];
        
        foreach ($stages as $stage) {
            DB::table('course_evaluation_stages')->updateOrInsert(
                ['id' => $stage['id']],
                array_merge($stage, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Course Works - أعمال المقررات
     */
    private function seedCourseWorks(): void
    {
        $this->command->info('  🔧 تعبئة أعمال المقررات...');
        
        $works = [
            // Course A works
            ['id' => 1, 'course_id' => 1, 'name' => 'حشو تجميلي (Composite)', 'required_count' => 10, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 2, 'course_id' => 1, 'name' => 'حشو خلفي (Amalgam)', 'required_count' => 8, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 3, 'course_id' => 1, 'name' => 'تيجان مؤقتة', 'required_count' => 6, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 4, 'course_id' => 1, 'name' => 'تلبيس دائم', 'required_count' => 5, 'evaluation_stages' => 3, 'required_images' => 3, 'is_active' => true],
            ['id' => 5, 'course_id' => 1, 'name' => 'جسر سنية', 'required_count' => 4, 'evaluation_stages' => 3, 'required_images' => 3, 'is_active' => true],
            // Course B works
            ['id' => 6, 'course_id' => 2, 'name' => 'قلع بسيط', 'required_count' => 12, 'evaluation_stages' => 3, 'required_images' => 1, 'is_active' => true],
            ['id' => 7, 'course_id' => 2, 'name' => 'قلع جراحي', 'required_count' => 8, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 8, 'course_id' => 2, 'name' => 'قلع عقل', 'required_count' => 6, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 9, 'course_id' => 2, 'name' => 'تخدير موضعي', 'required_count' => 15, 'evaluation_stages' => 2, 'required_images' => 1, 'is_active' => true],
            ['id' => 10, 'course_id' => 2, 'name' => 'تخدير عظمي (Block)', 'required_count' => 10, 'evaluation_stages' => 2, 'required_images' => 1, 'is_active' => true],
            // Course C works
            ['id' => 11, 'course_id' => 3, 'name' => 'تنظيف جيب عميق (Scaling)', 'required_count' => 15, 'evaluation_stages' => 2, 'required_images' => 1, 'is_active' => true],
            ['id' => 12, 'course_id' => 3, 'name' => 'جراحة إعادة تشكيل اللثة', 'required_count' => 8, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 13, 'course_id' => 3, 'name' => 'زراعة أسنان (Implant)', 'required_count' => 6, 'evaluation_stages' => 3, 'required_images' => 3, 'is_active' => true],
            ['id' => 14, 'course_id' => 3, 'name' => 'تجميل لثة (Gingivoplasty)', 'required_count' => 8, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 15, 'course_id' => 3, 'name' => 'كشط جذر (Root Planing)', 'required_count' => 12, 'evaluation_stages' => 2, 'required_images' => 1, 'is_active' => true],
            // Course D works
            ['id' => 16, 'course_id' => 4, 'name' => 'علاج عصب أولي (RCT)', 'required_count' => 10, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 17, 'course_id' => 4, 'name' => 'علاج عصب ثانوي (Re-RCT)', 'required_count' => 6, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 18, 'course_id' => 4, 'name' => 'حشو قناة (Obturation)', 'required_count' => 12, 'evaluation_stages' => 3, 'required_images' => 2, 'is_active' => true],
            ['id' => 19, 'course_id' => 4, 'name' => 'استئصال لب جزئي (Pulpotomy)', 'required_count' => 8, 'evaluation_stages' => 2, 'required_images' => 1, 'is_active' => true],
            ['id' => 20, 'course_id' => 4, 'name' => 'علاج أسنان أطفال', 'required_count' => 10, 'evaluation_stages' => 2, 'required_images' => 1, 'is_active' => true],
        ];
        
        foreach ($works as $work) {
            DB::table('course_works')->updateOrInsert(
                ['id' => $work['id']],
                array_merge($work, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Course Students - علاقات الطلاب بالمقررات
     */
    private function seedCourseStudents(): void
    {
        $this->command->info('  🎓 تعبئة علاقات الطلاب بالمقررات...');
        
        $relations = [
            ['id' => 1, 'course_id' => 1, 'user_id' => 1, 'group_name' => 'المجموعة أ'],
            ['id' => 2, 'course_id' => 2, 'user_id' => 1, 'group_name' => 'المجموعة أ'],
            ['id' => 3, 'course_id' => 3, 'user_id' => 1, 'group_name' => 'المجموعة أ'],
            ['id' => 4, 'course_id' => 4, 'user_id' => 1, 'group_name' => 'المجموعة أ'],
            ['id' => 5, 'course_id' => 1, 'user_id' => 2, 'group_name' => 'المجموعة أ'],
            ['id' => 6, 'course_id' => 2, 'user_id' => 2, 'group_name' => 'المجموعة أ'],
        ];
        
        foreach ($relations as $relation) {
            DB::table('course_student')->updateOrInsert(
                ['id' => $relation['id']],
                array_merge($relation, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Patients - المرضى
     */
    private function seedPatients(): void
    {
        $this->command->info('  🏥 تعبئة بيانات المرضى...');
        
        $patients = [
            [
                'id' => 1,
                'record_number' => 'MED-2026-0001',
                'full_name' => 'أحمد محمد العلي',
                'phone' => '0944111222',
                'birth_year' => 1990,
                'age' => 36,
                'gender' => 'male',
                'age_type' => 'adult',
                'access_type' => 'public',
                'governorate' => 'دمشق',
                'address' => 'شارع الحمزة',
                'notes' => 'مريض منتظم',
                'parent_name' => null,
                'parent_phone' => null,
                'parent_birth_year' => null,
                'added_by' => 1,
            ],
            [
                'id' => 2,
                'record_number' => 'MED-2026-0002',
                'full_name' => 'سارة خالد النجار',
                'phone' => '0955333444',
                'birth_year' => 1985,
                'age' => 41,
                'gender' => 'female',
                'age_type' => 'adult',
                'access_type' => 'private',
                'governorate' => 'حلب',
                'address' => 'شارع النيل',
                'notes' => 'تحتاج متابعة',
                'parent_name' => null,
                'parent_phone' => null,
                'parent_birth_year' => null,
                'added_by' => 1,
            ],
            [
                'id' => 3,
                'record_number' => 'MED-2026-0003',
                'full_name' => 'محمد علي حسن',
                'phone' => '0966555777',
                'birth_year' => 1995,
                'age' => 31,
                'gender' => 'male',
                'age_type' => 'adult',
                'access_type' => 'public',
                'governorate' => 'حمص',
                'address' => 'شارع الثورة',
                'notes' => null,
                'parent_name' => null,
                'parent_phone' => null,
                'parent_birth_year' => null,
                'added_by' => 1,
            ],
            [
                'id' => 4,
                'record_number' => 'MED-2026-0004',
                'full_name' => 'فاطمة أحمد',
                'phone' => '0977888999',
                'birth_year' => 2018,
                'age' => 8,
                'gender' => 'female',
                'age_type' => 'child',
                'access_type' => 'private',
                'governorate' => 'دمشق',
                'address' => 'شارع الفردوس',
                'notes' => 'طفلة',
                'parent_name' => 'أحمد أحمد',
                'parent_phone' => '0988000111',
                'parent_birth_year' => 1985,
                'added_by' => 1,
            ],
            [
                'id' => 5,
                'record_number' => 'MED-2026-0005',
                'full_name' => 'عمر خالد الدوسري',
                'phone' => '0999000111',
                'birth_year' => 1978,
                'age' => 48,
                'gender' => 'male',
                'age_type' => 'adult',
                'access_type' => 'public',
                'governorate' => 'اللاذقية',
                'address' => 'شارع البحر',
                'notes' => 'مريض جديد',
                'parent_name' => null,
                'parent_phone' => null,
                'parent_birth_year' => null,
                'added_by' => 1,
            ],
            [
                'id' => 6,
                'record_number' => 'MED-2026-0006',
                'full_name' => 'حسن يوسف',
                'phone' => '0911222333',
                'birth_year' => 2019,
                'age' => 7,
                'gender' => 'male',
                'age_type' => 'child',
                'access_type' => 'private',
                'governorate' => 'طرطوس',
                'address' => 'شارع الجامعة',
                'notes' => 'طفل',
                'parent_name' => 'يوسف حسن',
                'parent_phone' => '0922333444',
                'parent_birth_year' => 1980,
                'added_by' => 1,
            ],
        ];
        
        foreach ($patients as $patient) {
            DB::table('patients')->updateOrInsert(
                ['id' => $patient['id']],
                array_merge($patient, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Patient Teeth - أسنان المرضى
     */
    private function seedPatientTeeth(): void
    {
        $this->command->info('  🦷 تعبئة بيانات الأسنان...');
        
        $teeth = [
            ['id' => 1, 'patient_id' => 1, 'tooth_number' => 16, 'condition' => 'decayed', 'sub_condition' => 'عميقة', 'label' => 'ضرس علوي أيمن', 'is_primary' => false],
            ['id' => 2, 'patient_id' => 1, 'tooth_number' => 36, 'condition' => 'filled', 'sub_condition' => 'تجميلي', 'label' => 'ضرس سفلي أيسر', 'is_primary' => false],
            ['id' => 3, 'patient_id' => 2, 'tooth_number' => 11, 'condition' => 'healthy', 'sub_condition' => null, 'label' => 'قاطع علوي أيمن', 'is_primary' => false],
            ['id' => 4, 'patient_id' => 3, 'tooth_number' => 46, 'condition' => 'missing', 'sub_condition' => 'مفقود', 'label' => 'ضرس سفلي أيمن', 'is_primary' => false],
            ['id' => 5, 'patient_id' => 4, 'tooth_number' => 51, 'condition' => 'decayed', 'sub_condition' => 'سطحية', 'label' => 'قاطع طفولي علوي أيمن', 'is_primary' => true],
            ['id' => 6, 'patient_id' => 5, 'tooth_number' => 26, 'condition' => 'filled', 'sub_condition' => 'خلفي', 'label' => 'ضرس علوي أيسر', 'is_primary' => false],
            ['id' => 7, 'patient_id' => 6, 'tooth_number' => 71, 'condition' => 'healthy', 'sub_condition' => null, 'label' => 'قواطع طفولية سفلى', 'is_primary' => true],
        ];
        
        foreach ($teeth as $tooth) {
            DB::table('patient_teeth')->updateOrInsert(
                ['id' => $tooth['id']],
                array_merge($tooth, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Patient Health - الحالة الصحية
     */
    private function seedPatientHealth(): void
    {
        $this->command->info('  💊 تعبئة البيانات الصحية...');
        
        DB::table('patient_health')->updateOrInsert(
            ['id' => 1],
            [
                'patient_id' => 1,
                'diseases' => json_encode(['سكري', 'ضغط']),
                'diabetes_controlled' => true,
                'bp_controlled' => true,
                'medications' => 'ميتفورمين، كابتوبريل',
                'allergies' => 'لا يوجد',
                'surgery_history' => 'لا يوجد',
                'pregnancy_status' => null,
                'pregnancy_month' => null,
                'notes' => 'مريض تحت السيطرة',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Seed Patient Perio - الحالة اللثوية
     */
    private function seedPatientPerio(): void
    {
        $this->command->info('  🩺 تعبئة البيانات اللثوية...');
        
        DB::table('patient_perio')->updateOrInsert(
            ['id' => 1],
            [
                'patient_id' => 1,
                'pocket_depth' => '3-4mm',
                'bleeding_points' => 5,
                'mobility' => 'درجة 1',
                'recession' => 'بسيط',
                'furcation' => 'لا يوجد',
                'plaque_index' => 'متوسط',
                'calculus_index' => 'قليل',
                'notes' => 'حالة لثية متوسطة',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Seed Reservations - الحجوزات
     */
    private function seedReservations(): void
    {
        $this->command->info('  📋 تعبئة الحجوزات...');
        
        $reservations = [
            [
                'id' => 1,
                'patient_id' => 1,
                'user_id' => 1,
                'course_id' => 1,
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'cancelled_at' => null,
                'expires_at' => now()->addDays(7),
            ],
            [
                'id' => 2,
                'patient_id' => 2,
                'user_id' => 1,
                'course_id' => 4,
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'cancelled_at' => null,
                'expires_at' => now()->addDays(7),
            ],
            [
                'id' => 3,
                'patient_id' => 3,
                'user_id' => 1,
                'course_id' => 1,
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'cancelled_at' => null,
                'expires_at' => now()->addDays(7),
            ],
            [
                'id' => 4,
                'patient_id' => 5,
                'user_id' => 1,
                'course_id' => 2,
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'cancelled_at' => null,
                'expires_at' => now()->addDays(7),
            ],
            [
                'id' => 5,
                'patient_id' => 6,
                'user_id' => 1,
                'course_id' => 4,
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'cancelled_at' => null,
                'expires_at' => now()->addDays(7),
            ],
        ];
        
        foreach ($reservations as $reservation) {
            DB::table('reservations')->updateOrInsert(
                ['id' => $reservation['id']],
                array_merge($reservation, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Audit Logs - سجلات المراقبة
     */
    private function seedAuditLogs(): void
    {
        $this->command->info('  📜 تعبئة سجلات المراقبة...');
        
        $logs = [
            [
                'id' => 1,
                'user_id' => 1,
                'action' => 'login',
                'model' => 'User',
                'model_id' => 1,
                'old_data' => null,
                'new_data' => json_encode(['ip' => '192.168.1.1']),
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'action' => 'patient_created',
                'model' => 'Patient',
                'model_id' => 1,
                'old_data' => null,
                'new_data' => json_encode(['name' => 'أحمد محمد العلي']),
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'action' => 'reservation_created',
                'model' => 'Reservation',
                'model_id' => 1,
                'old_data' => null,
                'new_data' => json_encode(['patient_id' => 1, 'course_id' => 1]),
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
            ],
            [
                'id' => 4,
                'user_id' => 3,
                'action' => 'login',
                'model' => 'User',
                'model_id' => 3,
                'old_data' => null,
                'new_data' => json_encode(['ip' => '192.168.1.2']),
                'ip_address' => '192.168.1.2',
                'user_agent' => 'Mozilla/5.0',
            ],
            [
                'id' => 5,
                'user_id' => 4,
                'action' => 'login',
                'model' => 'User',
                'model_id' => 4,
                'old_data' => null,
                'new_data' => json_encode(['ip' => '192.168.1.3']),
                'ip_address' => '192.168.1.3',
                'user_agent' => 'Mozilla/5.0',
            ],
        ];
        
        foreach ($logs as $log) {
            DB::table('audit_logs')->updateOrInsert(
                ['id' => $log['id']],
                array_merge($log, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    /**
     * Seed Migrations - تسجيل الهجرات
     */
    private function seedMigrations(): void
    {
        $this->command->info('  🔄 تعبئة سجل الهجرات...');
        
        $migrations = [
            ['id' => 1, 'migration' => '0001_01_01_000000_create_users_table', 'batch' => 1],
            ['id' => 2, 'migration' => '0001_01_01_000001_create_cache_table', 'batch' => 1],
            ['id' => 3, 'migration' => '0001_01_01_000002_create_jobs_table', 'batch' => 1],
            ['id' => 4, 'migration' => '2024_01_02_000001_create_courses_table', 'batch' => 1],
            ['id' => 5, 'migration' => '2024_01_02_000002_create_patients_table', 'batch' => 1],
            ['id' => 6, 'migration' => '2024_01_02_000003_create_reservations_table', 'batch' => 1],
            ['id' => 7, 'migration' => '2024_01_02_000004_create_cases_table', 'batch' => 1],
            ['id' => 8, 'migration' => '2024_01_02_000005_create_audit_and_otp_tables', 'batch' => 1],
            ['id' => 9, 'migration' => '2024_01_03_000001_add_system_tables', 'batch' => 1],
        ];
        
        foreach ($migrations as $migration) {
            DB::table('migrations')->updateOrInsert(
                ['id' => $migration['id']],
                $migration
            );
        }
    }
}
