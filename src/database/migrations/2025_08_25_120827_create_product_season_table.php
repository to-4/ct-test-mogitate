<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_season', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->comment('商品ID')
                  ->constrained(table: 'products', column: 'id')
                  ->cascadeOnDelete();
            $table->foreignId('season_id')->comment('季節ID')
                  ->constrained(table: 'seasons', column: 'id')
                  ->cascadeOnDelete();
            $table->timestamps();

            // 重複防止（同じ product_id と season_id の組み合わせは1つだけ）
            $table->unique(['product_id', 'season_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_season');
    }
}
