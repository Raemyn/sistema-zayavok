<?php
namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаём пользователя admin/admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // уникальный идентификатор
            [
                'name'     => 'admin',
                'password' => Hash::make('admin'), // хэшируем пароль
            ]
        );
    }
}
