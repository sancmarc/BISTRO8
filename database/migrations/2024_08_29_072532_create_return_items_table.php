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
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('billing_id')->constrained('billings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('returned_by');
            $table->string('reason')->nullable();
            $table->decimal('quantity_stocks', total: 8, places: 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
