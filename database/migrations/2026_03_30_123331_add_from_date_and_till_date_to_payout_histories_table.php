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
        Schema::table('payout_histories', function (Blueprint $table) {
            $table->date('from_date')->nullable()->after('number_of_transactions');
            $table->date('till_date')->nullable()->after('from_date');
        });
    }
};
