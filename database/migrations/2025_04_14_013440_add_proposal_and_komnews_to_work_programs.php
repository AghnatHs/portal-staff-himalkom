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
        Schema::table('work_programs', function (Blueprint $table) {
            $table->string('proposal_url')->nullable()->default(null);
            $table->string('komnews_url')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_programs', function (Blueprint $table) {
            $table->dropColumn('proposal_url');
            $table->dropColumn('komnews_url');
        });
    }
};
