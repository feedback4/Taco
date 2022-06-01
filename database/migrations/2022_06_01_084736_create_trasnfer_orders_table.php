<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrasnferOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trasnfer_orders', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->dateTime('transfer_at');
            $table->foreignId('from_inventory_id');
            $table->foreignIdFor(\App\Models\Inventory::class);
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
        Schema::dropIfExists('trasnfer_orders');
    }
}
