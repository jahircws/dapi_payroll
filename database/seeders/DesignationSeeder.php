<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['designation_name'=>'Web Developer', 'is_active'=>true],
            ['designation_name'=>'Manager', 'is_active'=>true],
            ['designation_name'=>'Accountant', 'is_active'=>true],
            ['designation_name'=>'PHP Developer', 'is_active'=>true],
            ['designation_name'=>'Chief operations officer (COO)', 'is_active'=>true],
            ['designation_name'=>'Chief executive officer (CEO)', 'is_active'=>true],
            ['designation_name'=>'Chief financial officer (CFO)', 'is_active'=>true],
            ['designation_name'=>'Chief technology officer (CTO)', 'is_active'=>true],
        ];

        foreach($datas as $data){
            Designation::create($data);
        }
    }
}
