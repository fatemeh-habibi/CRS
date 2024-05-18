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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transactionID')->unique()->nullable();
            $table->decimal('amount',10,2);
            $table->date('paid_at')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('reservation_id');
            $table->enum('method', ['cash', 'credit_cards','debit_cards','gift_cards','mobile']);
            $table->unsignedTinyInteger('status')->comment('Payment Status,1 paied 0 cancel')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
