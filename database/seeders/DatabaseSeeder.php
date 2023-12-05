<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Rating;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // $table->string('firstname');
        // $table->string('lastname');
        // $table->string('email')->unique();
        // $table->string('address')->nullable();
        // $table->string('phone_number')->unique()->nullable();
        // $table->boolean('phone_number_verified')->default(false);
        // $table->string('profile_pic')->nullable();
        // $table->string('role');
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('password');
        // \App\Models\User::factory()->create([
        //     'firstname' => 'Admin',
        //     'lastname' => 'admin',
        //     'email' => 'ajumaoas39@gmail.com',
        //     'role' => 'admin',
        //     'password' => 'asdasd'
        // ]);
        Listing::factory(15)->create();
        Rating::factory(15)->create();
        User::factory(10)->create();
    }
}
