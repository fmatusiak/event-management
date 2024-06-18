<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id')->index();
            $table->decimal('transport_price')->default(0);
            $table->decimal('addons_price')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('total_cost')->default(0);
            $table->decimal('deposit_cost')->default(0);
            $table->decimal('remaining_cost')->default(0);
            $table->boolean('deposit_paid')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('package_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costs');
    }
}

;
