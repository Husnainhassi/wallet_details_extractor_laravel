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
        Schema::create('wallet_data', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('wallet_address')->unique();
            $table->float('roi')->nullable();
            $table->float('win_rate')->nullable();
            $table->timestamp('created_at')->useCurrent(); 
            $table->timestamp('updated_at')->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_data');
    }
};
