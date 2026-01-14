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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('part_name');
            $table->string('part_area');
            $table->decimal('weight', total: 8, places: 2);
            $table->decimal('basic_unit_price', total: 8, places: 2);
            $table->decimal('cost_price', total: 8, places: 2);
            $table->decimal('unit_price', total: 8, places: 2);
            $table->decimal('selling_price', total: 8, places: 2);
            $table->date('arrival_date');
            $table->date('expiration_date');
            $table->string('storage_location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
