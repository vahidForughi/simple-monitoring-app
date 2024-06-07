<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitors', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name', 50);
            $table->unsignedInteger('interval');
            $table->text('url');
            $table->unsignedTinyInteger('method')->default(\App\Models\Monitor::METHOD['GET']);
            $table->json('body')->nullable();
            $table->dateTime('monitored_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitors');
    }
};
