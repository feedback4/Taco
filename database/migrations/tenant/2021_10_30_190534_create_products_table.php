<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code'); //->unique()
            $table->string('texture')->nullable();
            $table->string('gloss')->nullable();
            $table->string('color_family')->nullable();
            $table->string('curing_time')->nullable();
            $table->string('last_price')->nullable();
            $table->foreignIdFor(\App\Models\Formula::class);
            $table->foreignIdFor(\App\Models\Category::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
