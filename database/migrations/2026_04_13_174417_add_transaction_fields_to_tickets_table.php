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
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'transaction_id')) {
                $table->foreignId('transaction_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('tickets', 'ticket_code')) {
                $table->string('ticket_code', 50)->nullable()->unique()->after('transaction_id');
            }
            if (!Schema::hasColumn('tickets', 'qr_code_path')) {
                $table->string('qr_code_path')->nullable()->after('ticket_code');
            }
            if (!Schema::hasColumn('tickets', 'status')) {
                $table->enum('status', ['unused', 'used', 'cancelled'])->default('unused')->after('qr_code_path');
            }
            if (!Schema::hasColumn('tickets', 'used_at')) {
                $table->timestamp('used_at')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'used_at')) {
                $table->dropColumn('used_at');
            }
            if (Schema::hasColumn('tickets', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('tickets', 'qr_code_path')) {
                $table->dropColumn('qr_code_path');
            }
            if (Schema::hasColumn('tickets', 'ticket_code')) {
                $table->dropColumn('ticket_code');
            }
            if (Schema::hasColumn('tickets', 'transaction_id')) {
                $table->dropForeign(['transaction_id']);
                $table->dropColumn('transaction_id');
            }
        });
    }
};
