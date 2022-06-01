<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemTransferOrdersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_transfer_order', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Item::class);
            $table->foreignIdFor(\App\Models\TransferOrder::class);
            $table->string('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_transfer_order');
    }
}
