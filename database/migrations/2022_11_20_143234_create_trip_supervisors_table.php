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
        Schema::create('trip_supervisors', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('line_parking_id')->constrained('line_parkings');
            $table->foreignUlid('supervisor_id')->constrained('supervisors');
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
        Schema::dropIfExists('trip_supervisors');
    }
};
