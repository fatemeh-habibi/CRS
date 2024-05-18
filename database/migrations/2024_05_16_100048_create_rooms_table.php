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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->integer('quest_count')->nullable();
            $table->decimal('price',10,2);
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_type_id')->constrained();
            $table->unsignedTinyInteger('activated')->default(1)->comment('0 hide, 1 show');
            $table->integer('rate')->default(0)->index();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
