<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            'permissions' => [
                'actions' => [],
                'is_show' => 0,
                'full_name'=>'permissions'
            ],
            'hazmatCompany' => [
                'actions' => ['read' => 0, 'add' => 0,'edit' => 0, 'remove' => 0],
                "is_show" => 1,
                'full_name' => 'hazmat Company'
            ],
            'clientCompany' => [
                'actions' => ['read' => 0, 'add' => 0,'edit' => 0, 'remove' => 0],
                "is_show" => 1,
                'full_name' => 'Client Company'
            ],

            'ships' => [
                'actions' => ['read' => 0, 'add' => 0, 'edit' => 0,'remove' => 0,'view' => 0],
                "is_show" => 1,
                'full_name' => 'Ships'
            ],

            'roles' => [
                'actions' => ['read' => 0, 'add' => 0, 'edit' => 0,'remove' => 0],
                "is_show" => 1,
                 'full_name' => 'Roles'
            ],

            'users' => [
                'actions' => ['read' => 0, 'add' => 0,  'edit' => 0],
                "is_show" => 1,
                'full_name' => 'Users'
            ],

            'documentdeclaration' => [
                'actions' => ['read' => 0, 'add' => 0, 'edit' => 0,'remove' => 0],
                "is_show" => 1,
                'full_name' => 'Document Declaration'

            ],
            'assign_team' => [
                'actions' => ['add' => 0],
                "is_show" => 0,
                'full_name' => 'Assign Team'
            ],
            'majorrepair' => [
                'actions' => ['read' => 0, 'add' => 0, 'edit' => 0,'remove' => 0],
                "is_show" => 1,
                'full_name' => 'Major Repair'

            ],
            'shoredp' => [
                'actions' => ['read' => 0, 'add' => 0, 'edit' => 0,'remove' => 0],
                "is_show" => 1,
                'full_name' => 'Shoredp'

            ],
            'responsibleperson' => [
                'actions' => ['read' => 0, 'add' => 0, 'edit' => 0,'remove' => 0],
                "is_show" => 1,
                'full_name' => 'Responsibleperson'

            ],

         
        ];

        foreach ($permissions as $entity => $permissionData) {
            $actions = $permissionData['actions'];
            $is_show = $permissionData['is_show'];
            Permission::firstOrCreate(['name' => $entity, 'group_type' => 'main', 'is_show' => $is_show,'full_name'=>$permissionData['full_name']]);
            if (@$actions) {
                foreach ($actions as $key => $action) {
                    $subPermission = "$entity.$key";
                    $sub_is_show = "$action";
                    Permission::firstOrCreate(['name' => $subPermission, 'group_type' => $entity, 'is_show' => $sub_is_show,'full_name'=>$subPermission]);
                }
            }
        }
    }
}
