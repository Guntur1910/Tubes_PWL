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
        if (!Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('ticket_code', 50)->nullable()->unique();
                $table->string('qr_code_path')->nullable();
                $table->enum('status', ['unused', 'used', 'cancelled'])->default('unused');
                $table->timestamp('used_at')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('tickets', function (Blueprint $table) {
                if (!Schema::hasColumn('tickets', 'transaction_id')) {
                    $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('tickets', 'ticket_code')) {
                    $table->string('ticket_code', 50)->nullable()->unique();
                }
                if (!Schema::hasColumn('tickets', 'qr_code_path')) {
                    $table->string('qr_code_path')->nullable();
                }
                if (!Schema::hasColumn('tickets', 'status')) {
                    $table->enum('status', ['unused', 'used', 'cancelled'])->default('unused');
                }
                if (!Schema::hasColumn('tickets', 'used_at')) {
                    $table->timestamp('used_at')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
