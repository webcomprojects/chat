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
        Schema::create('infobills', function (Blueprint $table) {
            $table->uuid('id')->primary()->uniqid();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('job')->nullable();
            $table->string('phone');
            $table->string('economic_unit');
            $table->string('ceo_name')->nullable();
            $table->string('contractual_power')->nullable();
            $table->string('made16_status')->default(0);
            $table->string('Two_way_electricity_rate');

            $table->string('middle_load_meter_consumption');
            $table->string('middle_load_allocation_coefficient');
            $table->string('middle_load_electricity_supply_rate');

            $table->string('peak_load_meter_consumption');
            $table->string('peak_load_allocation_coefficient');
            $table->string('peak_load_electricity_supply_rate');

            $table->string('low_load_meter_consumption');
            $table->string('low_load_allocation_coefficient');
            $table->string('low_load_electricity_supply_rate');

            // $table->string('file');
            // $table->string('type_industry')->nullable();
            // $table->string('network_admin')->nullable();
            // $table->string('tariff_code')->nullable();
            // $table->string('contract_period')->nullable();
            // $table->string('voltag_level')->nullable();
            // $table->string('maxi_meter')->nullable();
            // $table->string('total_price')->nullable();
            // $table->string('intermediate_load_energy_consumption')->nullable();
            // $table->string('low_energy_consumption')->nullable();
            // $table->string('high_energy_consumption')->nullable();
            // $table->string('friday_peak_consumption')->nullable();
            // $table->string('active_summation')->nullable();
            // $table->string('reactive_consumption')->nullable();
            $table->string('status')->default('در حال بررسی');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infobills');
    }
};
