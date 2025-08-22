<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('actifs_numeriques', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type', ['logiciel', 'licence', 'abonnement', 'compte', 'certificat']);
            $table->string('fournisseur')->nullable();
            $table->string('cle_licence')->nullable();
            $table->date('date_acquisition')->nullable();
            $table->date('date_expiration')->nullable();
            $table->decimal('cout', 10, 2)->nullable();
            $table->enum('etat', ['actif', 'expiré', 'suspendu'])->default('actif');
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->unsignedBigInteger('equipement_id')->nullable();
            $table->timestamps();

            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('equipement_id')->references('id')->on('equipements')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('actifs_numeriques');
    }
};
