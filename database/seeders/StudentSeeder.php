<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'custom_id'      => 'STU-00001',
            'first_name'     => 'Alice',
            'middle_name'    => 'Marie',
            'last_name'      => 'Anderson',
            'contact_number' => '555-1001',
        ]);

        Student::create([
            'custom_id'      => 'STU-00002',
            'first_name'     => 'Benjamin',
            'last_name'      => 'Taylor',
            'contact_number' => '555-1002',
        ]);

        Student::create([
            'custom_id'      => 'STU-00003',
            'first_name'     => 'Charlotte',
            'middle_name'    => 'Grace',
            'last_name'      => 'Thomas',
            'contact_number' => '555-1003',
        ]);

        Student::create([
            'custom_id'      => 'STU-00004',
            'first_name'     => 'Daniel',
            'last_name'      => 'Jackson',
            'contact_number' => '555-1004',
        ]);

        Student::create([
            'custom_id'      => 'STU-00005',
            'first_name'     => 'Olivia',
            'middle_name'    => 'Rose',
            'last_name'      => 'White',
            'contact_number' => '555-1005',
        ]);

        Student::create([
            'custom_id'      => 'STU-00006',
            'first_name'     => 'Ethan',
            'last_name'      => 'Harris',
            'contact_number' => '555-1006',
        ]);

        Student::create([
            'custom_id'      => 'STU-00007',
            'first_name'     => 'Sophia',
            'middle_name'    => 'Jane',
            'last_name'      => 'Martin',
            'contact_number' => '555-1007',
        ]);

        Student::create([
            'custom_id'      => 'STU-00008',
            'first_name'     => 'James',
            'last_name'      => 'Garcia',
            'contact_number' => '555-1008',
        ]);
    }
}
