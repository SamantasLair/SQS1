<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use App\Models\QuizAttempt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_answers')->delete();
        DB::table('quiz_attempts')->delete();
        DB::table('options')->delete();
        DB::table('questions')->delete();
        DB::table('quizzes')->delete();
        DB::table('users')->delete();

        $admin1 = User::create([
            'name' => 'Admin SQS',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_premium' => true,
            'email_verified_at' => now(),
        ]);

        $user1 = User::create([
            'name' => 'User Biasa Satu',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_premium' => false,
            'email_verified_at' => now(),
        ]);
        
        $userPremium = User::create([
            'name' => 'User Premium',
            'email' => 'premium@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_premium' => true,
            'email_verified_at' => now(),
        ]);

        // Data Kuis Contoh
        $quiz1 = Quiz::create([
            'user_id' => $user1->id,
            'title' => 'Kuis Sejarah Indonesia',
            'description' => 'Tes pengetahuan Anda tentang sejarah Indonesia.',
            'join_code' => 'SEJARAH',
            'timer' => 30,
            'generation_source' => 'manual',
        ]);

        $q1 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Siapa presiden pertama Indonesia?',
            'question_type' => 'multiple_choice',
        ]);

        Option::create(['question_id' => $q1->id, 'option_text' => 'Soekarno', 'is_correct' => true]);
        Option::create(['question_id' => $q1->id, 'option_text' => 'Soeharto', 'is_correct' => false]);
        Option::create(['question_id' => $q1->id, 'option_text' => 'B.J. Habibie', 'is_correct' => false]);
        Option::create(['question_id' => $q1->id, 'option_text' => 'Gus Dur', 'is_correct' => false]);
    }
}