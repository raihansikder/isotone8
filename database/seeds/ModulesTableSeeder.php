<?php

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $module_names = ['modules', 'users', 'groups', 'tenants'];

        foreach ($module_names as $module_name) {
            if (DB::table('modules')->where('name', $module_name)->doesntExist()) {
                DB::table('modules')->insert([
                    'uuid' => Webpatser\Uuid\Uuid::generate(4),
                    'name' => $module_name,
                    'title' => str_singular($module_name),
                    'description' => 'Manage ' . str_singular($module_name),
                    'parent_id' => 0,
                    'modulegroup_id' => 0,
                    'level' => 0,
                    'order' => 0,
                    'default_route' => $module_name . '.index',
                    'color_css' => 'aqua',
                    'icon_css' => 'fa fa-plus',
                    'is_active' => 1,
                    'created_by' => 1,
                    'created_at' => now(),
                    'updated_by' => 1,
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
