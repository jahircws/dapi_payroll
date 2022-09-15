<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['department_name'=>'Agriculture', 'is_active'=>true],
            ['department_name'=>'Environment', 'is_active'=>true],
            ['department_name'=>'Accountant', 'is_active'=>true],
            ['department_name'=>'Developer', 'is_active'=>true]
        ];

        foreach($datas as $data){
            Department::create($data);
        }
    }
}
