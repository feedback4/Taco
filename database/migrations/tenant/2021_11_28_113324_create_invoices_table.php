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
            $table->foreignIdFor(\App\Models\Action::class)->nullable();
            $table->foreignIdFor(\App\Models\Status::class);
            $table->dateTime('invoiced_at');
            $table->dateTime('due_at');
            $table->double('amount', 15, 4);
            $table->foreignIdFor(\App\Models\Client::class);
            $table->text('notes')->nullable();
            $table->integer('parent_id')->default(0);
            $table->foreignIdFor(\App\Models\Tax::class);
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
