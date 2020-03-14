<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChangelogEntryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < rand(8, 12); $i++) {
            DB::table('changelog_entries')->insert([
                'category_id' => rand(1, 7),
                'title' => $faker->sentence(3),
                'content' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'published' => 1,
                'published_at' => $faker->dateTimeThisMonth(),
                'created_at' => $faker->dateTimeThisYear()
            ]);
        }
    }
}
