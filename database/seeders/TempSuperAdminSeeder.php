<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TempSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // تأكد من عدم وجود المستخدم مسبقاً
        if (!User::where('email', 'temp_superadmin@multaqa.com')->exists()) {
            $user = User::create([
                'name' => 'Temporary Super Admin',
                'email' => 'temp_superadmin@multaqa.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Temp@123456'),
                'remember_token' => Str::random(10),
            ]);
            
            $this->command->info('🎉 ===================================');
            $this->command->info('✅ Temporary Super Admin Created!');
            $this->command->info('📧 Email: temp_superadmin@multaqa.com');
            $this->command->info('🔑 Password: Temp@123456');
            $this->command->info('⚠️  IMPORTANT: Delete this user later!');
            $this->command->info('====================================');
        } else {
            $this->command->info('ℹ️  Temp admin already exists.');
        }
    }
}
