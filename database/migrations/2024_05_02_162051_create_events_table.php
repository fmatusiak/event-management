<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('note')->nullable();
            $table->bigInteger('client_id')->nullable()->index();
            $table->bigInteger('client_address_id')->nullable()->index();
            $table->bigInteger('delivery_address_id')->nullable()->index();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('gmail_sync')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('client_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('delivery_address_id')->references('id')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
}

;
