<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trip_buses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('line_parking_id')->constrained('line_parkings');
            $table->foreignUlid('bus_id')->constrained('buses');
            $table->foreignUlid('driver_id')->constrained('drivers');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trip_buses');
    }
};
