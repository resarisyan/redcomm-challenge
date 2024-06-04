<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $notes = [];

        for ($i = 0; $i < 50; $i++) {
            $notes[] = [
                'id' => $faker->uuid,
                'title' => $faker->sentence,
                'desc' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('notes')->insert($notes);
    }
}
