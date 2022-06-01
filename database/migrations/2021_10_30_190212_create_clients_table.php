<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('type');
//            $table->string('address')->nullable();
            $table->foreignIdFor(\App\Models\Status::class);
            $table->foreignIdFor(\App\Models\Company::class)->nullable();
            $table->string('code')->nullable()->unique();
            $table->string('location');
            $table->string('payment');
            $table->bigInteger('balance')->nullable();
            $table->boolean('vat')->default(true);
            $table->string('due_to_days')->nullable()->default(14);
            $table->dateTime('last_action_at')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
