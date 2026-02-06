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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('key'); // Translation key (e.g., 'welcome_title')
            $table->string('locale', 5); // Language code (en, hi, gu, mr)
            $table->text('value'); // Translated text
            $table->string('group')->default('public'); // Group name (public, admin, etc.)
            $table->timestamps();

            // Indexes for faster queries
            $table->index(['key', 'locale']);
            $table->index('group');

            // Unique constraint: one translation per key+locale combination
            $table->unique(['key', 'locale', 'group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
