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
        Schema::create('method_trade', function (Blueprint $table) {
            
            $table->foreignId('method_id')->constrained('methods')->onDelete('cascade');
            $table->foreignId('event_info_id')->nullable()->constrained('event_info')->onDelete('cascade');
            $table->foreignId('trade_id')->constrained('trades')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('method_trade');
    }
};
