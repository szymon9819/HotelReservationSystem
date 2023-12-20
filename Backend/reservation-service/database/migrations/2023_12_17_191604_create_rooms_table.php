<?php

declare(strict_types=1);

use App\Enums\RoomType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->enum('room_type', RoomType::getValues());
            $table->decimal('price_per_night', 10, 2);
            $table->boolean('availability')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotels');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
