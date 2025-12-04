<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@studentpedia.com'],
            [
                'name' => 'Platform Admin',
                'password' => Hash::make('admin123'),
                'role' => 'platform', // penting! sesuai middleware role:platform
            ]
        );
    }
}
