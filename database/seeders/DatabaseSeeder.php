<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Arif',
            'email' => 'arif@gmail.com',
            'password' => bcrypt(12345678),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),

        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(12345678),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => bcrypt(12345678),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),

        ]);

        User::create([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => bcrypt(12345678),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),

        ]);

        // \App\Models\User::factory(2)->create();
        \App\Models\Message::factory(200)->create();
    }
}
