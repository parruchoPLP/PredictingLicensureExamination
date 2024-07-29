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
        Schema::create('deleted_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('timestamped_name');
            $table->string('path');
            $table->timestamp('deleted_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deleted_files');
    }
};
