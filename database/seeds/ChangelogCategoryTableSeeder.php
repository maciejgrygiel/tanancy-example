<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChangelogCategoryTableSeeder extends Seeder
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
            DB::table('changelog_categories')->insert([
                'name' => $faker->catchPhrase(),
                'color' => $faker->hexColor(),
                'created_at' => $faker->dateTimeThisYear()
            ]);
        }
    }
}
