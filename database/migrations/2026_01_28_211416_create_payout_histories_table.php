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
        Schema::create('payout_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->decimal('base_salary', 10, 2)->default(0.00);
            $table->decimal('sales_amount', 10, 2)->default(0.00);
            $table->decimal('commission_amount', 10, 2)->default(0.00);
            $table->integer('number_of_transactions')->default(0);
            $table->date('payout_date');
            $table->timestamps();
        });
    }
};
