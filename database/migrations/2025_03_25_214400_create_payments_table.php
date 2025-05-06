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

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction')->unique();
            $table->foreignId('reservation_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ["cash","mercadopago"]);
            $table->dateTime('payment_date');
            $table->enum('status', ["pending","completed","failed"]);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
