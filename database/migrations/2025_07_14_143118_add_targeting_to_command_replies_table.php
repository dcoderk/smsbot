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
        Schema::table('command_replies', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('command_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->after('company_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('command_replies', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
