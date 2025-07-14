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
        Schema::table('commands', function (Blueprint $table) {
            // Add the company_id column. Allow null for global commands by Super Admin.
            $table->foreignId('company_id')->nullable()->after('id')->constrained()->onDelete('cascade');

            // Drop the old unique index on just the 'trigger'
            $table->dropUnique('commands_trigger_unique');

            // Add a new unique index for the combination of company and trigger
            $table->unique(['company_id', 'trigger']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commands', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');

            $table->dropUnique('commands_company_id_trigger_unique');
            $table->unique('trigger');
        });
    }
};
