<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Teachers and Teacher Accounts
        $teachers = Teacher::factory(30)->create();

        // Create Grades, Groups, and Students
        $grades = Grade::factory(6)->create();

        // Create Subjects
        $subjects = Subject::factory(7)->create();

        foreach ($grades as $grade) {
            $alphabet = 'A';
            for ($i = 1; $i <= 3; $i++) { // Buat 3 Group per Grade
                $groupName = "{$grade->name}-{$alphabet}";
                $group = Group::factory()->create([
                    'grade_id' => $grade->id,
                    'name' => $groupName,
                ]);

                // Buat 40 Siswa per Group
                Student::factory(40)->create(['group_id' => $group->id]);

                // Buat 5 Jadwal per Group
                for ($j = 0; $j < 5; $j++) {
                    $teacher = $teachers->random();
                    $subject = $subjects->random();

                    Schedule::factory()->create([
                        'teacher_id' => $teacher->id,
                        'subject_id' => $subject->id,
                        'group_id' => $group->id,
                    ]);
                }

                // Increment alphabet
                $alphabet++;
            }
        }
    }
}
