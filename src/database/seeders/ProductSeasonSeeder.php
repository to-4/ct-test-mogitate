<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Season;
use Carbon\Carbon;


class ProductSeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 商品ごとに複数の季節を紐づけられる配列
        $pairs = [
            ['product' => 'キウイ',        'seasons' => ['秋', '冬']],
            ['product' => 'ストロベリー',  'seasons' => ['春']],
            ['product' => 'オレンジ',      'seasons' => ['冬']],
            ['product' => 'スイカ',        'seasons' => ['夏']],
            ['product' => 'ピーチ',        'seasons' => ['夏']],
            ['product' => 'シャインマスカット', 'seasons' => ['夏', '秋']],
            ['product' => 'パイナップル',  'seasons' => ['春', '夏']],
            ['product' => 'ブドウ',        'seasons' => ['夏', '秋']],
            ['product' => 'バナナ',        'seasons' => ['夏']],
            ['product' => 'メロン',        'seasons' => ['春', '夏']],
        ];

        $rows = [];
        $now = Carbon::now();

        foreach ($pairs as $p) {
            $productId = Product::where('name', $p['product'])->value('id');

            // 存在確認
            if (!$productId) {
                continue;
            }

            foreach ($p['seasons'] as $seasonName) {
                $seasonId = Season::where('name', $seasonName)->value('id');

                if ($seasonId) {
                    $rows[] = [
                        'product_id' => $productId,
                        'season_id'  => $seasonId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        if ($rows) {
            DB::table('product_season')->insert($rows);
        }
    }
}
