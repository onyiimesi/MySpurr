<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'uuid' => (string) Str::uuid(),
                'first_name' => 'Onyedika',
                'last_name' => 'Chukwu',
                'email' => 'email@gmail.com',
                'password' => Hash::make('12345678'),
                'type' => 'business',
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => (string) Str::uuid(),
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@gmail.com',
                'password' => Hash::make('12345678'),
                'type' => 'business',
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'uuid' => (string) Str::uuid(),
                'first_name' => 'Mary',
                'last_name' => 'Ann',
                'email' => 'mary@gmail.com',
                'password' => Hash::make('12345678'),
                'type' => 'business',
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($types as $type) {
            DB::table('businesses')->insert($type);
        }
    }
}
