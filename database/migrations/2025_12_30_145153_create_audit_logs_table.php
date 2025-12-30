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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            
            // Qui a fait l'action
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('Utilisateur qui a fait l\'action');
            
            // Quelle action
            $table->string('action', 100)->comment('Type d\'action: created, updated, deleted, approved, etc.');
            $table->string('model_type', 100)->comment('Type de modèle: User, Resource, Reservation, etc.');
            $table->bigInteger('model_id')->comment('ID du modèle concerné');
            
            // Détails de l'action
            $table->json('old_values')->nullable()->comment('Valeurs avant modification');
            $table->json('new_values')->nullable()->comment('Valeurs après modification');
            
            // Informations contextuelles
            $table->string('ip_address', 45)->nullable()->comment('Adresse IP');
            $table->text('user_agent')->nullable()->comment('Navigateur/Appareil');
            $table->string('url')->nullable()->comment('URL où l\'action a été faite');
            
            $table->timestamp('created_at')->useCurrent();
            
            // Index pour recherches rapides
            $table->index('user_id');
            $table->index('action');
            $table->index('model_type');
            $table->index(['model_type', 'model_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
