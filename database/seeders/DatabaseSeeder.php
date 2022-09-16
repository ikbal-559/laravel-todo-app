<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use App\Models\User;
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
        User::factory()
            ->has(
                Task::factory()
                    ->count(3)
                    ->state(function (array $attributes, User $user) {
                        return ['created_by' => $user->id];
                    })
            )
            ->count(50)
            ->create();
    }
}
