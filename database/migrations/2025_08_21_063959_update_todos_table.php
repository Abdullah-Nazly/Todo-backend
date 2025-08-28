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
        Schema::table('todos', function (Blueprint $table) {
            // Drop description and timestamps if they exist
            if (Schema::hasColumn('todos', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('todos', 'created_at')) {
                $table->dropColumn(['created_at', 'updated_at']);
            }

            // Rename completed to status
            if (Schema::hasColumn('todos', 'completed')) {
                $table->renameColumn('completed', 'status');
            }

            // Add creation_date as nullable first
            if (!Schema::hasColumn('todos', 'creation_date')) {
                $table->date('creation_date')->nullable()->after('title');
            }
        });

        // Fill existing rows with today’s date
        DB::table('todos')->update(['creation_date' => now()->toDateString()]);

        // Make the column NOT NULL
        Schema::table('todos', function (Blueprint $table) {
            $table->date('creation_date')->nullable(false)->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            // Add description and timestamps back
            $table->text('description')->nullable()->after('title');
            $table->timestamps();

            // Rename status back to completed
            if (Schema::hasColumn('todos', 'status')) {
                $table->renameColumn('status', 'completed');
            }

            // Drop creation_date
            if (Schema::hasColumn('todos', 'creation_date')) {
                $table->dropColumn('creation_date');
            }
        });
    }
};
