<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::create([
            'first_name'     => 'John',
            'middle_name'    => 'Michael',
            'last_name'      => 'Smith',
            'subject'        => 'Mathematics',
            'contact_number' => '555-0101',
            'address'        => '123 Main St',
        ]);

        Teacher::create([
            'first_name'     => 'Sarah',
            'middle_name'    => 'Elizabeth',
            'last_name'      => 'Johnson',
            'subject'        => 'English',
            'contact_number' => '555-0102',
            'address'        => '456 Oak Ave',
        ]);

        Teacher::create([
            'first_name'     => 'David',
            'middle_name'    => 'Robert',
            'last_name'      => 'Williams',
            'subject'        => 'Science',
            'contact_number' => '555-0103',
            'address'        => '789 Pine Rd',
        ]);

        Teacher::create([
            'first_name'     => 'Emily',
            'last_name'      => 'Brown',
            'subject'        => 'History',
            'contact_number' => '555-0104',
            'address'        => '321 Elm St',
        ]);

        Teacher::create([
            'first_name'     => 'Christopher',
            'middle_name'    => 'James',
            'last_name'      => 'Davis',
            'subject'        => 'Physical Education',
            'contact_number' => '555-0105',
            'address'        => '654 Maple Dr',
        ]);
    }
}
