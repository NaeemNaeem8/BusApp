<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('line_trips', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('line_id')->constrained('lines');
            $table->foreignUlid('trip_id')->constrained('trips');
            $table->softDeletes();
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
        Schema::dropIfExists('line_trips');
    }
};
