<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_trade', function (Blueprint $table) {
            
            $table->foreignId('picture_id')->constrained('pictures')->onDelete('cascade');
            $table->foreignId('trade_id')->constrained('trades')->onDelete('cascade');
            $table->boolean('kind');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('picture_trade');
    }
};
