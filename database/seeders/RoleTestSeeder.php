<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleTestSeeder extends Seeder
{
    /**
     * Seed test users with different roles for permission testing.
     * 
     * This seeder creates 4 test users, one for each role:
     * - Administrator (full access)
     * - Dokter (view-only access)
     * - Resepsionis (CRUD access to specific modules)
     * - Perawat (TBD permissions)
     */
    public function run(): void
    {
        // Ensure roles exist (they should be created manually or through migration)
        $roles = [
            'Administrator' => 'Admin dengan akses penuh',
            'Dokter' => 'Dokter dengan akses view-only',
            'Resepsionis' => 'Resepsionis dengan akses CRUD terbatas',
            'Perawat' => 'Perawat dengan akses TBD'
        ];

        foreach ($roles as $roleName => $description) {
            Role::firstOrCreate(
                ['nama_role' => $roleName],
                ['keterangan' => $description]
            );
        }

        // Create test users
        $testUsers = [
            [
                'nama' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
                'role' => 'Administrator'
            ],
            [
                'nama' => 'Dokter Test',
                'email' => 'dokter@test.com',
                'password' => Hash::make('password'),
                'role' => 'Dokter'
            ],
            [
                'nama' => 'Resepsionis Test',
                'email' => 'resepsionis@test.com',
                'password' => Hash::make('password'),
                'role' => 'Resepsionis'
            ],
            [
                'nama' => 'Perawat Test',
                'email' => 'perawat@test.com',
                'password' => Hash::make('password'),
                'role' => 'Perawat'
            ]
        ];

        foreach ($testUsers as $userData) {
            // Create or update user
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'nama' => $userData['nama'],
                    'password' => $userData['password']
                ]
            );

            // Get the role
            $role = Role::where('nama_role', $userData['role'])->first();

            if ($role) {
                // Assign role to user (create or update)
                RoleUser::updateOrCreate(
                    [
                        'iduser' => $user->iduser,
                        'idrole' => $role->idrole
                    ],
                    [
                        'status' => true
                    ]
                );
            }
        }

        $this->command->info('✅ Test users created successfully!');
        $this->command->info('');
        $this->command->info('Login credentials (all passwords: password):');
        $this->command->info('  Administrator: admin@test.com');
        $this->command->info('  Dokter:        dokter@test.com');
        $this->command->info('  Resepsionis:   resepsionis@test.com');
        $this->command->info('  Perawat:       perawat@test.com');
    }
}
