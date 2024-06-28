<?php

use App\Models\TypeRequest;
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
        Schema::create('type_requests', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('new_register_type');
            $table->string('card_image')->nullable();
            $table->integer('status')->default(TypeRequest::pending);
            $table->foreignUlid('user_id')->constrained('users');
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
        Schema::dropIfExists('type_requests');
    }
};
