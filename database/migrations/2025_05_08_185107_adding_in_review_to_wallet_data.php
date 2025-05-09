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
        Schema::table('wallet_data', function (Blueprint $table) {
            $table->enum('in_review', ['0', '1'])->default('0')->after('is_disqualified')->comment('0 = No, 1 = Yes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_data', function (Blueprint $table) {
            $table->dropColumn('in_review');
        });
    }
};
