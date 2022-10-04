<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // 'role-list',
            // 'role-add',
            // 'role-edit',
            // 'role-delete',
            // 'role-view',
            // 'user-list',
            // 'user-add',
            // 'user-edit',
            // 'user-delete',
            // 'user-view',
            // 'product-list',
            // 'product-add',
            // 'product-edit',
            // 'product-delete',
            // 'product-view',
            // 'category-list',
            // 'category-add',
            // 'category-edit',
            // 'category-delete',
            // 'category-view',
            // 'customer-list',
            // 'customer-delete',
            // 'customer-view',
            // 'cart-list',
            // 'dashboard-appuser-chart',
            // 'dashboard-appuser-list',
            // 'dashboard-appuser-counter'
        ];

        foreach ($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }
    }
}
