<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->id();

            // Owner (Host)
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Category
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Basic info
            $table->string('title');
            $table->text('description');

            // Pricing
            $table->decimal('price', 10, 2);

            // Location
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');

            // Status
            $table->enum('status', ['draft', 'active'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spaces');
    }
};
