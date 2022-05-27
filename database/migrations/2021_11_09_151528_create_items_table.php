<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('quantity');
            $table->string('description')->nullable();
            $table->string('price');

            $table->string('unit')->default('kg');
            $table->string('type')->default('material');
            $table->string('cost')->nullable();

            $table->foreignIdFor(\App\Models\Bill::class)->nullable();
            $table->foreignIdFor(\App\Models\Element::class)->nullable();

            $table->foreignIdFor(\App\Models\Invoice::class)->nullable();
            $table->foreignIdFor(\App\Models\Product::class)->nullable();

            $table->foreignIdFor(\App\Models\Inventory::class)->nullable();
            $table->foreignIdFor(\App\Models\ProductionOrder::class)->nullable();

            $table->foreignIdFor(\App\Models\User::class);

            $table->dateTime('expire_at')->nullable();
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
        Schema::dropIfExists('items');
    }
}
