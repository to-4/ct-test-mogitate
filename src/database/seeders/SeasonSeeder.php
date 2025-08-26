<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Season;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 指定4件
        $names = ['春', '夏', '秋', '冬'];

        foreach ($names as $name) {
            Season::updateOrCreate(['name' => $name], []);
        }
    }
}
