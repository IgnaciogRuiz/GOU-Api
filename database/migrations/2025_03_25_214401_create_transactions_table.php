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
        Schema::disableForeignKeyConstraints();

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction')->unique();
            $table->foreignId('payment_id')->constrained();
            $table->foreignId('driver_id')->constrained('users');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('company_final_amount', 10, 2);
            $table->dateTime('transaction_date');
            $table->enum('status', ["pending","processed","failed"]);
            $table->foreignId('user_id');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
