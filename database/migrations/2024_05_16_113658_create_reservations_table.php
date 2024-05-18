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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->date('date');
            $table->date('check_in');
            $table->date('check_out');
            $table->foreignId('coupon_id')->nullable();
            $table->unsignedTinyInteger('status')->comment('Payment Status,1 ok 0 pending')->index();
            $table->integer('total_rooms')->default(1);
            $table->decimal('coupon_fee',10,2)->default(0);
            $table->decimal('tax',10,2)->default(0);
            $table->decimal('total_price',10,2)->index();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
