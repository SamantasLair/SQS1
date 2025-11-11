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
            'email_verified_at' => now(),
        ]);

        $admin2 = User::create([
            'name' => 'Admin Kedua',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $admin3 = User::create([
            'name' => 'Admin Ketiga',
            'email' => 'admin3@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $user1 = User::create([
            'name' => 'User Biasa Satu',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
        
        $user2 = User::create([
            'name' => 'User Biasa Dua',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $user3 = User::create([
            'name' => 'User Biasa Tiga',
            'email' => 'user3@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $quiz1 = Quiz::create([
            'user_id' => $user1->id,
            'title' => 'Kuis Sejarah Indonesia',
            'description' => 'Tes pengetahuan Anda tentang sejarah Indonesia.',
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

        $q2 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Tahun berapa Indonesia merdeka?',
            'question_type' => 'multiple_choice',
        ]);

        Option::create(['question_id' => $q2->id, 'option_text' => '1942', 'is_correct' => false]);
        Option::create(['question_id' => $q2->id, 'option_text' => '1945', 'is_correct' => true]);
        Option::create(['question_id' => $q2->id, 'option_text' => '1950', 'is_correct' => false]);
        Option::create(['question_id' => $q2->id, 'option_text' => '1998', 'is_correct' => false]);
        
        $quiz2 = Quiz::create([
            'user_id' => $user2->id,
            'title' => 'Kuis Matematika Dasar',
            'description' => 'Tes matematika sederhana.',
        ]);

        $q3 = Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => '1 + 1 = ?',
            'question_type' => 'multiple_choice',
        ]);

        Option::create(['question_id' => $q3->id, 'option_text' => '2', 'is_correct' => true]);
        Option::create(['question_id' => $q3->id, 'option_text' => '1', 'is_correct' => false]);
        Option::create(['question_id' => $q3->id, 'option_text' => '3', 'is_correct' => false]);
        Option::create(['question_id' => $q3->id, 'option_text' => '0', 'is_correct' => false]);
        
        QuizAttempt::create([
            'user_id' => $user1->id,
            'quiz_id' => $quiz1->id,
            'score' => 100.00,
            'created_at' => now()->subMinutes(10),
        ]);
        QuizAttempt::create([
            'user_id' => $user2->id,
            'quiz_id' => $quiz1->id,
            'score' => 50.00,
            'created_at' => now()->subMinutes(5),
        ]);
        QuizAttempt::create([
            'user_id' => $user3->id,
            'quiz_id' => $quiz1->id,
            'score' => 100.00,
            'created_at' => now()->subMinutes(12),
        ]);

        QuizAttempt::create([
            'user_id' => $user1->id,
            'quiz_id' => $quiz2->id,
            'score' => 100.00,
            'created_at' => now()->subMinutes(2),
        ]);
        QuizAttempt::create([
            'user_id' => $user3->id,
            'quiz_id' => $quiz2->id,
            'score' => 0.00,
            'created_at' => now()->subMinutes(1),
        ]);
    }
}