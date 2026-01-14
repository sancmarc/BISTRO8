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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sold_to');
            $table->date('delivery_date');
            $table->date('billing_date');
            $table->date('payment_date');
            $table->string('processing');
            $table->decimal('usage', total: 8, places: 2);
            $table->text('memo')->nullable();
            $table->decimal('cut_fee', total: 8, places: 2);
            $table->decimal('final_price', total: 8, places: 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
