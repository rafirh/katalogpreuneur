<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ub.ac.id'],
            [
                'name' => 'Administrator UB',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'email_verified_at' => now(),
            ],
        );

        $this->call([
            KategoriSeeder::class,
            ProdukSeeder::class,
        ]);
    }
}

