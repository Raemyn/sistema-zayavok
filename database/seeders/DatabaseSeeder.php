<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lead;
use App\Models\Comment;
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
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'admin',
                'password' => Hash::make('admin'),
            ]
        );

        // Создаём одну заявку
        $lead = Lead::updateOrCreate(
            ['email' => 'user@example.com'], // уникальный идентификатор по email
            [
                'name'    => 'Иван Иванов',
                'phone'   => '9001234567',
                'message' => 'Протечка в ванной',
                'status'  => 'new',
            ]
        );

        // Создаём комментарий к этой заявке
        Comment::updateOrCreate(
            ['lead_id' => $lead->id, 'user_id' => $admin->id],
            [
                'body' => 'Немедленно обработать',
            ]
        );
    }
}
