<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('maintenances', function (Blueprint $table) {
        $table->id();
        
        // On lie la maintenance à une ressource (ex: Serveur-01)
        // Si on supprime la ressource, on supprime ses maintenances (cascade)
        $table->foreignId('resource_id')->constrained('resources')->onDelete('cascade');
        
        $table->dateTime('start_date'); // Date de début
        $table->dateTime('end_date')->nullable(); // Date de fin (peut être vide si on ne sait pas)
        $table->text('reason'); // Pourquoi ? (ex: "Changement disque dur")
        $table->enum('status', ['planifie', 'en_cours', 'termine'])->default('planifie');
        
        $table->timestamps();
    });
}
};
