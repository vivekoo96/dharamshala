<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('booking_rooms', function (Blueprint $table) {
            $table->integer('adults_male')->default(1)->after('room_id');
            $table->integer('adults_female')->default(0)->after('adults_male');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_rooms', function (Blueprint $table) {
            $table->dropColumn(['adults_male', 'adults_female']);
        });
    }
};
