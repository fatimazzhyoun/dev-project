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
        Schema::create('resource_maintenances', function (Blueprint $table) {
            $table->id();
            
            // Quelle ressource
            $table->foreignId('resource_id')
                  ->constrained('resources')
                  ->onDelete('cascade')
                  ->comment('Ressource en maintenance');
            
            // Période de maintenance
            $table->datetime('start_date')->comment('Début de la maintenance');
            $table->datetime('end_date')->comment('Fin de la maintenance');
            
            // Raison et notes
            $table->text('reason')->comment('Raison de la maintenance');
            $table->text('notes')->nullable()->comment('Notes supplémentaires');
            
            // Qui a créé cette maintenance
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('Responsable/Admin qui a planifié');
            
            $table->timestamps();
            
            // Index
            $table->index('resource_id');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_maintenances');
    }
};
