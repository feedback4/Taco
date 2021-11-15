<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompoundElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compound_element', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Compound::class);
            $table->foreignIdFor(\App\Models\Element::class);
            $table->string('percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compound_element');
    }
}
