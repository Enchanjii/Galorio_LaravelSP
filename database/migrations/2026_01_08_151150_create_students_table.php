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
    Schema::create('students', function (Blueprint $table) {
        $table->id(); // Primary key (ID)
        $table->string('name'); // Student name
        $table->string('email')->unique(); // Unique email
        $table->integer('age')->nullable(); // Optional age
        $table->timestamps(); // Adds created_at and updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
