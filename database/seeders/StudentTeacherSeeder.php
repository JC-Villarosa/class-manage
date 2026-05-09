<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class StudentTeacherSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $teachers = Teacher::all();

        $students[0]->teachers()->attach([$teachers[0]->id, $teachers[1]->id]);
        $students[1]->teachers()->attach([$teachers[1]->id, $teachers[2]->id]);
        $students[2]->teachers()->attach([$teachers[0]->id, $teachers[3]->id, $teachers[4]->id]);
        $students[3]->teachers()->attach([$teachers[2]->id]);
        $students[4]->teachers()->attach([$teachers[1]->id, $teachers[3]->id]);
        $students[5]->teachers()->attach([$teachers[0]->id, $teachers[2]->id, $teachers[4]->id]);
        $students[6]->teachers()->attach([$teachers[3]->id, $teachers[4]->id]);
        $students[7]->teachers()->attach([$teachers[0]->id, $teachers[1]->id, $teachers[2]->id]);
    }
}
