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
        Schema::create('account_requests', function (Blueprint $table) {
            $table->id();
            
            // Informations du demandeur
            $table->string('name')->comment('Nom complet');
            $table->string('email')->unique()->comment('Email');
            $table->string('phone', 20)->nullable()->comment('Téléphone');
            $table->string('department', 100)->nullable()->comment('Département/Service');
            $table->enum('requested_role', ['user', 'responsable'])->default('user')->comment('Rôle demandé');
            
            // Justification
            $table->text('justification')->comment('Pourquoi il demande un compte');
            
            // Status de la demande
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Traitement par admin
            $table->foreignId('reviewed_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('Admin qui a traité la demande');
            
            $table->timestamp('reviewed_at')->nullable()->comment('Quand traité');
            $table->text('review_notes')->nullable()->comment('Notes de l\'admin');
            
            // Si approuvé, lien vers le compte créé
            $table->foreignId('created_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('Compte créé suite à cette demande');
            
            $table->timestamps();
            
            // Index
            $table->index('status');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_requests');
    }
};
