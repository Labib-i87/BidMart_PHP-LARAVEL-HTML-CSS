<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('biddings', function (Blueprint $table) {

            $table->unsignedBigInteger('pid');
            $table->unsignedBigInteger('uid');
            $table->primary(['pid', 'uid']);

            $table->foreign('pid')->references('pid')->on('products');
            $table->foreign('uid')->references('id')->on('users');
            $table->decimal('amount');
            $table->unsignedBigInteger('card_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biddings');
    }
};