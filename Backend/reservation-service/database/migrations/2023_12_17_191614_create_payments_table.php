<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->enum('status', ['paid', 'pending', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
