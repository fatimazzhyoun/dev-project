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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Clé-valeur pour les paramètres
            $table->string('key')->unique()->comment('Clé du paramètre');
            $table->text('value')->nullable()->comment('Valeur du paramètre');
            $table->string('type', 50)->default('string')->comment('Type: string, boolean, integer, json');
            
            // Informations supplémentaires
            $table->string('group', 50)->default('general')->comment('Groupe: general, email, maintenance, etc.');
            $table->string('label')->comment('Libellé affiché dans l\'interface');
            $table->text('description')->nullable()->comment('Description du paramètre');
            
            // Valeur par défaut
            $table->text('default_value')->nullable();
            
            // Options pour select/radio (JSON)
            $table->json('options')->nullable()->comment('Options disponibles pour ce paramètre');
            
            // Est-ce modifiable par l'admin?
            $table->boolean('is_editable')->default(true);
            
            $table->timestamps();
            
            // Index
            $table->index('key');
            $table->index('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
