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
        Schema::create('sendbills', function (Blueprint $table) {
            $table->uuid('id')->primary()->uniqid();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('job')->nullable();
            $table->string('phone');
            $table->string('economic_unit');
            $table->string('ceo_name')->nullable();
            $table->string('contractual_power')->nullable();
            $table->string('file');
            $table->string('status')->default('در حال بررسی');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sendbills');
    }
};
