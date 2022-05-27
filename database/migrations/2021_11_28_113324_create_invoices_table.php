<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();


            $table->dateTime('invoiced_at');
            $table->dateTime('due_at');
            $table->string('number')->nullable();
            $table->text('notes')->nullable();
            $table->foreignIdFor(\App\Models\Tax::class)->nullable();
            $table->string('partial_amount')->nullable();
            $table->string('sub_total');
            $table->string('tax_total')->default(0);
            $table->string('discount')->default(0);
            $table->string('total');


            $table->foreignIdFor(\App\Models\Client::class);
            $table->foreignIdFor(\App\Models\Status::class);

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
        Schema::dropIfExists('invoices');
    }
}
