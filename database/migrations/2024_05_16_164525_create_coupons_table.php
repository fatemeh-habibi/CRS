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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code')->unique();
            $table->float('discount_amount');
            $table->foreignId('room_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->tinyInteger('used')->nullable();
            $table->enum('type' , ['percent'  , 'fixed']);
            $table->enum('status' , ['enable'  , 'disable']);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
