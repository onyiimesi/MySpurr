<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            ['name' => 'Access Bank', 'code' => '044', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Zenith Bank', 'code' => '057', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'First Bank', 'code' => '011', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Guaranty Trust Bank', 'code' => '058', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Union Bank', 'code' => '032', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Fidelity Bank', 'code' => '070', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Sterling Bank', 'code' => '232', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Ecobank Nigeria', 'code' => '050', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'United Bank for Africa (UBA)', 'code' => '033', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Wema Bank', 'code' => '035', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Unity Bank', 'code' => '215', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Stanbic IBTC Bank', 'code' => '221', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Standard Chartered Bank', 'code' => '068', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Heritage Bank', 'code' => '030', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Polaris Bank', 'code' => '076', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Jaiz Bank', 'code' => '301', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Keystone Bank', 'code' => '082', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Providus Bank', 'code' => '101', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'SunTrust Bank', 'code' => '100', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Globus Bank', 'code' => '001', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
            ['name' => 'Titan Trust Bank', 'code' => '102', 'created_at' => Carbon::now(), 'updated_at' =>  Carbon::now()],
        ];
    
        foreach ($banks as $bank) {
            DB::table('banks')->insert($bank);
        }
    }
}
