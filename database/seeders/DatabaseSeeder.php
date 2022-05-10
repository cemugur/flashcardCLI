<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\FlashCard;
use App\Models\UserAnswer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // Create test user
        User::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('aDmIn'),
        ]);
        User::factory(2)->create();

        FlashCard::factory(20)->create();
        UserAnswer::factory(50)->create();
    }
}
