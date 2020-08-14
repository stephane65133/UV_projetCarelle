<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'first_name' => 'jiofa',
            'last_name' => 'stephane',
            'email' => 'stephanejiofatamafo@gmail.com',
            'job' => 'Administrateur système',
            'is_active' => true,
            'avatar' => null,
            'facebook' => null,
            'password' => bcrypt('stephane'),
        ]);
         DB::table('users')->insert([
            'first_name' => 'tamafo',
            'last_name' => 'steph',
            'email' => 'stephanetamafo1@gmail.com',
            'job' => 'Administrateur système',
            'is_active' => true,
            'avatar' => null,
            'facebook' => null,
            'password' => bcrypt('admin'),
        ]);
        DB::table('groups')->insert([
            'name' => 'inf4',
            'description' => 'info4',
            'creator_id' => 1
        ]);
        DB::table('groups')->insert([
            'name' => 'inf5',
            'description' => 'info5',
            'creator_id' => 1
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
            'description' => 'administrateur',
            'creator_id' => 1
        ]);
        DB::table('roles')->insert([
            'name' => 'superAdmin',
            'description' => 'super administrateur',
            'creator_id' => 1
        ]);



        DB::table('permissions')->insert([
            'name' => 'read-role',
            'description' => 'lire les roles',
            'creator_id' => 1
        ]);
        DB::table('permissions')->insert([
            'name' => 'create-role',
            'description' => 'lire les roles',
            'creator_id' => 1
        ]);DB::table('permissions')->insert([
            'name' => 'read-user',
            'description' => 'lire les roles',
            'creator_id' => 1
        ]);
        DB::table('permissions')->insert([
            'name' => 'create-user',
            'description' => 'lire les roles',
            'creator_id' => 1
        ]);DB::table('permissions')->insert([
            'name' => 'read-permission',
            'description' => 'lire les roles',
            'creator_id' => 1
        ]);
        DB::table('permissions')->insert([
            'name' => 'create-group',
            'description' => 'lire les roles',
            'creator_id' => 1
        ]);DB::table('permissions')->insert([
            'name' => 'read-group',
            'description' => 'lire les roles',
            'creator_id' => 1
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete-groupe',
            'description' => 'lire les roles',
            'creator_id' => 1
        ]);

        DB::table('role_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 1
        ]);
        DB::table('role_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 2
        ]);
        DB::table('role_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 2
        ]);
        DB::table('role_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 4
        ]);
        DB::table('role_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 5
        ]);
        DB::table('role_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 6
        ]);
        DB::table('role_permissions')->insert([
            'role_id' =>1,
            'permission_id' =>7
        ]);


        DB::table('user_roles')->insert([
            'role_id' => 1,
            'user_id' => 1
        ]);DB::table('user_roles')->insert([
            'role_id' => 2,
            'user_id' => 2
        ]);
        DB::table('user_roles')->insert([
            'role_id' => 2,
            'user_id' => 1
        ]);


        DB::table('user_groups')->insert([
            'group_id' => 2,
            'user_id' => 1
        ]); 
        DB::table('user_groups')->insert([
            'group_id' => 1,
            'user_id' => 1
        ]);
        DB::table('user_groups')->insert([
            'group_id' => 1,
            'user_id' => 2
        ]);

    }
}
