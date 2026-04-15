<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('carts', function (Blueprint $t) {
        $t->id();
        $t->foreignId('user_id')->constrained()->onDelete('cascade');
        $t->foreignId('event_id');
        $t->foreignId('ticket_type_id')->nullable();
        $t->integer('quantity');
        $t->integer('price');
        $t->integer('total_amount');
        $t->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
