<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('spaces', function (Blueprint $table) {

            $table->integer('capacity')->default(1);
            $table->integer('min_capacity')->default(1);
            $table->string('available_slots')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('spaces', function (Blueprint $table) {

            $table->dropColumn(['capacity','min_capacity','available_slots']);

        });
    }

};