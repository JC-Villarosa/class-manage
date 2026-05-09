<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    public function run(): void
    {
        Guardian::create([
            'first_name'     => 'Margaret',
            'last_name'      => 'Anderson',
            'contact_number' => '555-2001',
            'email'          => 'margaret.anderson@email.com',
            'address'        => '111 Guardian Ln',
        ]);

        Guardian::create([
            'first_name'     => 'Robert',
            'middle_name'    => 'Charles',
            'last_name'      => 'Anderson',
            'contact_number' => '555-2002',
            'email'          => 'robert.anderson@email.com',
            'address'        => '111 Guardian Ln',
        ]);

        Guardian::create([
            'first_name'     => 'Jennifer',
            'last_name'      => 'Taylor',
            'contact_number' => '555-2003',
            'email'          => 'jennifer.taylor@email.com',
            'address'        => '222 Guardian Way',
        ]);

        Guardian::create([
            'first_name'     => 'Michael',
            'middle_name'    => 'Paul',
            'last_name'      => 'Taylor',
            'contact_number' => '555-2004',
            'email'          => 'michael.taylor@email.com',
            'address'        => '222 Guardian Way',
        ]);

        Guardian::create([
            'first_name'     => 'Patricia',
            'last_name'      => 'Thomas',
            'contact_number' => '555-2005',
            'email'          => 'patricia.thomas@email.com',
            'address'        => '333 Guardian Blvd',
        ]);

        Guardian::create([
            'first_name'     => 'William',
            'last_name'      => 'Jackson',
            'contact_number' => '555-2006',
            'email'          => 'william.jackson@email.com',
            'address'        => '444 Guardian Ct',
        ]);

        Guardian::create([
            'first_name'     => 'Linda',
            'middle_name'    => 'Ann',
            'last_name'      => 'White',
            'contact_number' => '555-2007',
            'email'          => 'linda.white@email.com',
            'address'        => '555 Guardian Ter',
        ]);

        Guardian::create([
            'first_name'     => 'Richard',
            'last_name'      => 'Harris',
            'contact_number' => '555-2008',
            'email'          => 'richard.harris@email.com',
            'address'        => '666 Guardian Pl',
        ]);
    }
}
