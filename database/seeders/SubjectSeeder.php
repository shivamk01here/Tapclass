<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Core Academic Subjects
            ['name' => 'Mathematics', 'icon' => '📐'],
            ['name' => 'Physics', 'icon' => '⚛️'],
            ['name' => 'Chemistry', 'icon' => '🧪'],
            ['name' => 'Biology', 'icon' => '🧬'],
            ['name' => 'English', 'icon' => '📚'],
            ['name' => 'Hindi', 'icon' => '🇮🇳'],
            
            // Social Sciences
            ['name' => 'History', 'icon' => '📜'],
            ['name' => 'Geography', 'icon' => '🌍'],
            ['name' => 'Political Science', 'icon' => '🏛️'],
            ['name' => 'Economics', 'icon' => '📊'],
            ['name' => 'Sociology', 'icon' => '👥'],
            ['name' => 'Psychology', 'icon' => '🧠'],
            
            // Languages
            ['name' => 'Sanskrit', 'icon' => '🕉️'],
            ['name' => 'Tamil', 'icon' => '📖'],
            ['name' => 'Telugu', 'icon' => '📖'],
            ['name' => 'Marathi', 'icon' => '📖'],
            ['name' => 'Bengali', 'icon' => '📖'],
            ['name' => 'Gujarati', 'icon' => '📖'],
            ['name' => 'Kannada', 'icon' => '📖'],
            ['name' => 'Malayalam', 'icon' => '📖'],
            ['name' => 'Punjabi', 'icon' => '📖'],
            ['name' => 'Urdu', 'icon' => '📖'],
            ['name' => 'French', 'icon' => '🇫🇷'],
            ['name' => 'German', 'icon' => '🇩🇪'],
            ['name' => 'Spanish', 'icon' => '🇪🇸'],
            
            // Commerce Stream
            ['name' => 'Accountancy', 'icon' => '💰'],
            ['name' => 'Business Studies', 'icon' => '💼'],
            ['name' => 'Commerce', 'icon' => '🏦'],
            
            // Computer Science & IT
            ['name' => 'Computer Science', 'icon' => '💻'],
            ['name' => 'Information Technology', 'icon' => '🖥️'],
            ['name' => 'Programming', 'icon' => '⌨️'],
            ['name' => 'Web Development', 'icon' => '🌐'],
            ['name' => 'Data Science', 'icon' => '📈'],
            
            // Competitive Exams
            ['name' => 'JEE Preparation', 'icon' => '🎓'],
            ['name' => 'NEET Preparation', 'icon' => '⚕️'],
            ['name' => 'CAT Preparation', 'icon' => '📋'],
            ['name' => 'UPSC Preparation', 'icon' => '🏛️'],
            ['name' => 'SSC Preparation', 'icon' => '📝'],
            
            // Arts & Humanities
            ['name' => 'Philosophy', 'icon' => '🤔'],
            ['name' => 'Literature', 'icon' => '📖'],
            ['name' => 'Fine Arts', 'icon' => '🎨'],
            ['name' => 'Music', 'icon' => '🎵'],
            ['name' => 'Dance', 'icon' => '💃'],
            
            // Vocational & Others
            ['name' => 'Environmental Science', 'icon' => '🌱'],
            ['name' => 'Physical Education', 'icon' => '⚽'],
            ['name' => 'Home Science', 'icon' => '🏠'],
            ['name' => 'Agriculture', 'icon' => '🌾'],
            ['name' => 'Statistics', 'icon' => '📊'],
            ['name' => 'Biotechnology', 'icon' => '🧫'],
            
            // Primary Level
            ['name' => 'General Science', 'icon' => '🔬'],
            ['name' => 'Social Studies', 'icon' => '🌏'],
            ['name' => 'EVS (Environmental Studies)', 'icon' => '🌿'],
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject['name'],
                'slug' => Str::slug($subject['name']),
                'icon' => $subject['icon'],
                'is_active' => true,
            ]);
        }
    }
}
