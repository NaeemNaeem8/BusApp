<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_parkings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->time('arrive_time');
            $table->foreignUlid('line_trip_id')->constrained('line_trips');
            $table->foreignUlid('parking_id')->constrained('parkings');
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
        Schema::dropIfExists('line_parkings');
    }
};
