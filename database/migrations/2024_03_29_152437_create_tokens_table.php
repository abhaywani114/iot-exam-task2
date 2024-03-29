<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token_no');
            $table->string('job_no');
            $table->string('vehicle_no');
            $table->string('vehicle_type');
            $table->string('user_id');
            $table->string('service_id');
            $table->enum('status', ['waiting', 'inprogress', 'done'])->default('waiting');
            $table->timestamp('timer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
