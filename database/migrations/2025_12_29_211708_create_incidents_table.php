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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            
            // Qui signale l'incident
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('Utilisateur qui signale');
            
            // Quelle ressource
            $table->foreignId('resource_id')
                  ->constrained('resources')
                  ->onDelete('cascade')
                  ->comment('Ressource concernée');
            
            // Réservation liée (optionnel)
            $table->foreignId('reservation_id')
                  ->nullable()
                  ->constrained('reservations')
                  ->onDelete('set null')
                  ->comment('Réservation concernée (si applicable)');
            
            // Description de l'incident
            $table->string('title')->comment('Titre court de l\'incident');
            $table->text('description')->comment('Description détaillée');
            
            // Priorité
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])
                  ->default('medium')
                  ->comment('Niveau de priorité');
            
            // Status
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])
                  ->default('open')
                  ->comment('État de l\'incident');
            
            // Résolution
            $table->foreignId('resolved_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('Qui a résolu l\'incident');
            
            $table->timestamp('resolved_at')->nullable()->comment('Quand résolu');
            $table->text('resolution_notes')->nullable()->comment('Notes de résolution');
            
            $table->timestamps();
            
            // Index
            $table->index('user_id');
            $table->index('resource_id');
            $table->index('status');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
