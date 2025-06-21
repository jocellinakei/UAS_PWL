<?php
namespace Database\Seeders;

use App\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $wartawanRole = Role::create(['name' => 'wartawan']);
        
        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super',
            'last_name' => 'Administrator',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
        ]);
        
        // Assign admin role to super admin
        $superAdmin->assignRole('admin');
        
        // Optional: Create example users for other roles
        $editor = User::create([
            'name' => 'Sample',
            'last_name' => 'Editor',
            'email' => 'editor@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
        ]);
        $editor->assignRole('editor');
        
        $wartawan = User::create([
            'name' => 'Sample',
            'last_name' => 'Wartawan',
            'email' => 'wartawan@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
        ]);
        $wartawan->assignRole('wartawan');
    }
}