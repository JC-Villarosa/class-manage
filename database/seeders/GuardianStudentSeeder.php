<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Database\Seeder;

class GuardianStudentSeeder extends Seeder
{
    public function run(): void
    {
        $guardians = Guardian::all();
        $students = Student::all();

        $students[0]->guardians()->attach($guardians[0]->id, ['relationship' => 'Mother']);
        $students[0]->guardians()->attach($guardians[1]->id, ['relationship' => 'Father']);

        $students[1]->guardians()->attach($guardians[2]->id, ['relationship' => 'Mother']);
        $students[1]->guardians()->attach($guardians[3]->id, ['relationship' => 'Father']);

        $students[2]->guardians()->attach($guardians[4]->id, ['relationship' => 'Mother']);

        $students[3]->guardians()->attach($guardians[5]->id, ['relationship' => 'Father']);
        $students[3]->guardians()->attach($guardians[2]->id, ['relationship' => 'Uncle']);

        $students[4]->guardians()->attach($guardians[6]->id, ['relationship' => 'Mother']);
        $students[4]->guardians()->attach($guardians[7]->id, ['relationship' => 'Father']);

        $students[5]->guardians()->attach($guardians[0]->id, ['relationship' => 'Mother']);
        $students[5]->guardians()->attach($guardians[1]->id, ['relationship' => 'Father']);

        $students[6]->guardians()->attach($guardians[4]->id, ['relationship' => 'Grandmother']);

        $students[7]->guardians()->attach($guardians[2]->id, ['relationship' => 'Mother']);
        $students[7]->guardians()->attach($guardians[3]->id, ['relationship' => 'Father']);
    }
}
