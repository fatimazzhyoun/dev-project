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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            
            // À qui est destinée la notification
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Type de notification
            $table->enum('type', [
                'demande',          // Nouvelle demande de réservation
                'approbation',      // Demande approuvée
                'refus',            // Demande refusée
                'expiration',       // Réservation bientôt expirée
                'conflit',          // Conflit de réservation
                'maintenance',      // Maintenance planifiée
                'incident'          // Incident signalé/résolu
            ]);
            
            // Contenu
            $table->string('title')->comment('Titre de la notification');
            $table->text('message')->comment('Contenu du message');
            
            // Lien vers l'élément concerné (optionnel)
            $table->bigInteger('related_id')->nullable()->comment('ID de l\'élément lié');
            $table->string('related_type', 50)->nullable()->comment('Type: reservation, incident, etc.');
            
            // Statut de lecture
            $table->timestamp('read_at')->nullable()->comment('Quand la notification a été lue');
            
            $table->timestamp('created_at')->useCurrent();
            
            // Index
            $table->index('user_id');
            $table->index('type');
            $table->index('read_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
