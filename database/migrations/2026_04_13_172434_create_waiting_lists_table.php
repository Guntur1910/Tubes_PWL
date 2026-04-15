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
        if (!Schema::hasTable('waiting_lists')) {
            Schema::create('waiting_lists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('ticket_type_id')->constrained('ticket_type')->onDelete('cascade');
                $table->integer('quantity');
                $table->enum('status', ['waiting', 'notified', 'purchased', 'expired'])->default('waiting');
                $table->timestamp('notified_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('waiting_lists', function (Blueprint $table) {
                if (!Schema::hasColumn('waiting_lists', 'user_id')) {
                    $table->foreignId('user_id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('waiting_lists', 'ticket_type_id')) {
                    $table->foreignId('ticket_type_id')->constrained('ticket_type')->onDelete('cascade');
                }
                if (!Schema::hasColumn('waiting_lists', 'quantity')) {
                    $table->integer('quantity');
                }
                if (!Schema::hasColumn('waiting_lists', 'status')) {
                    $table->enum('status', ['waiting', 'notified', 'purchased', 'expired'])->default('waiting');
                }
                if (!Schema::hasColumn('waiting_lists', 'notified_at')) {
                    $table->timestamp('notified_at')->nullable();
                }
                if (!Schema::hasColumn('waiting_lists', 'expires_at')) {
                    $table->timestamp('expires_at')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiting_lists');
    }
};
