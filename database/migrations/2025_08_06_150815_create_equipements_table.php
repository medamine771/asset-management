<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->foreignId('categorie_id')
            ->nullable() 
            ->constrained('categories')
            ->nullOnDelete();
            $table->foreignId('emplacement_id')
            ->nullable()
            ->constrained('emplacements')
            ->nullOnDelete();

            $table->string('etat')->default('bon');
            $table->date('date_acquisition')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipements');
    }
};
