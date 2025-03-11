<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managingDirectorRole = Role::create([
            'name' => 'managing director'
        ]);
        $supervisorRole = Role::create([
            'name' => 'supervisor'
        ]);
        $bphRole = Role::create([
            'name' => 'bph'
        ]);
    }
}
