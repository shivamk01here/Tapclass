<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking Tutor Rates...\n\n";

$tutors = App\Models\TutorProfile::with('subjects')->get();

foreach ($tutors as $tutor) {
    echo "Tutor: " . $tutor->user->name . "\n";
    echo "Subjects: " . $tutor->subjects->count() . "\n";
    
    foreach ($tutor->subjects as $subject) {
        echo "  - " . $subject->name . "\n";
        echo "    Online Rate: " . ($subject->pivot->online_rate ?? 'NULL') . "\n";
        echo "    Offline Rate: " . ($subject->pivot->offline_rate ?? 'NULL') . "\n";
        echo "    Online Available: " . ($subject->pivot->is_online_available ? 'Yes' : 'No') . "\n";
        echo "    Offline Available: " . ($subject->pivot->is_offline_available ? 'Yes' : 'No') . "\n";
    }
    echo "\n";
}
