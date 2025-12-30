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
    Schema::create('resources', function (Blueprint $table) {
        $table->id();

        // Relation Catégorie (Ajouté ici directement pour éviter les bugs)
        $table->foreignId('category_id')
              ->nullable()
              ->constrained('resource_categories')
              ->onDelete('set null')
              ->comment('Catégorie de cette ressource');

        // Informations de base
        $table->string('name');
        $table->enum('type', ['serveur', 'vm', 'stockage', 'reseau']);
        $table->text('description')->nullable();

        // Spécifications techniques
        $table->integer('cpu')->nullable()->comment('Nombre de cores CPU');
        $table->integer('ram')->nullable()->comment('RAM en GB');
        $table->string('storage', 100)->nullable()->comment('Capacité de stockage');
        $table->string('bandwidth', 100)->nullable()->comment('Bande passante réseau');
        $table->string('os', 100)->nullable()->comment('Système d\'exploitation');
        $table->string('ip_address', 45)->nullable()->comment('Adresse IP');
        $table->string('location')->nullable()->comment('Emplacement physique');

        // Status
        $table->enum('status', ['disponible', 'reserve', 'maintenance', 'desactive'])
              ->default('disponible');

        // Relation avec le responsable
        $table->foreignId('responsable_id')
              ->nullable()
              ->constrained('users')
              ->onDelete('set null')
              ->comment('Responsable technique de cette ressource');

        $table->timestamps();

        // Index
        $table->index('type');
        $table->index('status');
        $table->index('responsable_id');
        $table->index('category_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
