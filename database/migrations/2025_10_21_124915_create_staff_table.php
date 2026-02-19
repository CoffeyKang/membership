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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('nick_name')->nullable();
            $table->string('full_name')->nullable(false);
            $table->string('phone_number')->nullable(false);
            $table->integer('base_salary')->default(3500);
            $table->integer('monthly_minimum_sales_amount')->default(10000);
            $table->float('commission_rate')->default(0.4);
            $table->integer('bonus')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_left')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
