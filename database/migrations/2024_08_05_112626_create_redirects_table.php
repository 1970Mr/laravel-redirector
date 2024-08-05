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
        Schema::create('redirects', static function (Blueprint $table) {
            $table->id();
            $table->string('source_url')->unique();
            $table->string('destination_url');
            $table->integer('status_code')->default(301);
            $table->boolean('is_active')->default(true)->comment('1: active, 0: inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};