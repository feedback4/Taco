<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Vendor::class);
            $table->foreignIdFor(\App\Models\Status::class);
            $table->string('number')->nullable();
            $table->dateTime('billed_at');
            $table->dateTime('due_at');

            $table->foreignIdFor(\App\Models\Tax::class)->nullable();
            $table->bigInteger('partial_amount')->nullable();
            $table->bigInteger('sub_total');
            $table->bigInteger('tax_total');
            $table->bigInteger('discount');
            $table->bigInteger('total');


            $table->text('notes')->nullable();
            $table->integer('parent_id')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
