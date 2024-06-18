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
            $table->unsignedBigInteger('client_id')->index();
            $table->unsignedBigInteger('client_address_id')->index();
            $table->unsignedBigInteger('delivery_address_id')->index();
            $table->unsignedBigInteger('cost_id')->index();
            $table->unsignedBigInteger('google_calendar_event_id')->nullable()->index();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();
            $table->softDeletes();
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
