<?php
namespace App\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('documents')->insert([
                'division_id' => rand(0, 20),
                'recipient_user_id' => rand(0, 1000),
                'issuer_user_id' => rand(0, 1000),
                'number' => Str::random(2) . str_pad(rand(0, 10000), 5, '0', STR_PAD_LEFT)
            ]);
        }
    }
}
