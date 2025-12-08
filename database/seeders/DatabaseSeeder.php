<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $password = Hash::make('password');

        Schema::disableForeignKeyConstraints();

        DB::table('user_answers')->truncate();
        DB::table('quiz_attempts')->truncate();
        DB::table('options')->truncate();
        DB::table('questions')->truncate();
        DB::table('quizzes')->truncate();
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();

        $roles = ['user', 'pro', 'premium', 'academic', 'admin'];
        $quizTopics = [
            'Matematika Dasar', 'Fisika Kuantum', 'Sejarah Dunia', 'Biologi Sel', 
            'Kimia Organik', 'Sastra Indonesia', 'Pemrograman Web', 'Kecerdasan Buatan',
            'Ekonomi Makro', 'Geografi', 'Bahasa Inggris', 'Sosiologi', 'Astronomi'
        ];

        foreach (range('A', 'Z') as $index => $char) {
            $role = $roles[$index % count($roles)];
            $isPremium = in_array($role, ['pro', 'premium', 'academic', 'admin']);
            
            $user = User::create([
                'name' => "User {$char} - {$role}",
                'email' => strtolower($char) . "@example.com",
                'password' => $password,
                'role' => $role,
                'is_premium' => $isPremium,
                'email_verified_at' => now(),
                'ai_usage_count' => rand(0, 5),
                'last_ai_usage_date' => now(),
            ]);

            $numberOfQuizzes = rand(2, 5);

            for ($i = 0; $i < $numberOfQuizzes; $i++) {
                $topic = $quizTopics[array_rand($quizTopics)];
                
                $quiz = Quiz::create([
                    'user_id' => $user->id,
                    'title' => "Kuis {$topic} Bagian " . ($i + 1),
                    'description' => $faker->paragraph(),
                    'join_code' => strtoupper(Str::random(6)),
                    'timer' => $faker->randomElement([15, 30, 45, 60, 90, 120]),
                    'generation_source' => $faker->randomElement(['manual', 'ai']),
                    'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                ]);

                $numberOfQuestions = rand(5, 15);

                for ($j = 0; $j < $numberOfQuestions; $j++) {
                    $qType = $faker->randomElement(['multiple_choice', 'multiple_choice', 'multiple_choice', 'essay']);
                    
                    $question = Question::create([
                        'quiz_id' => $quiz->id,
                        'question_text' => $faker->sentence(10) . '?',
                        'question_type' => $qType,
                        'topic' => $topic,
                    ]);

                    if ($qType === 'multiple_choice') {
                        $correctIndex = rand(0, 3);
                        for ($k = 0; $k < 4; $k++) {
                            Option::create([
                                'question_id' => $question->id,
                                'option_text' => $faker->sentence(3),
                                'is_correct' => ($k === $correctIndex),
                            ]);
                        }
                    } else {
                        Option::create([
                            'question_id' => $question->id,
                            'option_text' => $faker->text(200),
                            'is_correct' => true,
                        ]);
                    }
                }
            }
        }

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@sqs.com',
            'password' => $password,
            'role' => 'admin',
            'is_premium' => true,
            'email_verified_at' => now(),
        ]);
    }
}