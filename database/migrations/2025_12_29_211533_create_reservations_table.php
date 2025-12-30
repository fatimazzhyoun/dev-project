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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('Utilisateur qui fait la réservation');
            
            $table->foreignId('resource_id')
                  ->constrained('resources')
                  ->onDelete('cascade')
                  ->comment('Ressource réservée');
            
            // Période de réservation
            $table->datetime('start_date')->comment('Date de début');
            $table->datetime('end_date')->comment('Date de fin');
            
            // Status de la réservation
            $table->enum('status', [
                'pending',      // En attente d'approbation
                'approved',     // Approuvée
                'refused',      // Refusée
                'active',       // Active (en cours)
                'terminated'    // Terminée
            ])->default('pending');
            
            // Justification et réponse
            $table->text('justification')->comment('Pourquoi l\'utilisateur a besoin de cette ressource');
            $table->text('response_message')->nullable()->comment('Message du responsable (si refusé ou commentaire)');
            
            // Qui a approuvé/refusé
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('Responsable qui a traité la demande');
            
            $table->timestamp('approved_at')->nullable()->comment('Quand la demande a été traitée');
            
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('user_id');
            $table->index('resource_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
