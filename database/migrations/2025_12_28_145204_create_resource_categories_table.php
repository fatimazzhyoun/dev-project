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
        Schema::create('resource_categories', function (Blueprint $table) {
            $table->id();
            
            // Informations de la catégorie
            $table->string('name')->unique()->comment('Nom de la catégorie');
            $table->string('slug')->unique()->comment('URL-friendly name');
            $table->text('description')->nullable()->comment('Description de la catégorie');
            $table->string('icon')->nullable()->comment('Icône CSS ou nom d\'image');
            $table->string('color', 7)->nullable()->comment('Couleur hexadécimale #RRGGBB');
            
            // Type de ressources dans cette catégorie
            $table->enum('resource_type', ['serveur', 'vm', 'stockage', 'reseau'])
                  ->comment('Type de ressources de cette catégorie');
            
            // Ordre d'affichage
            $table->integer('display_order')->default(0)->comment('Ordre d\'affichage');
            
            // Active/Inactive
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Index
            $table->index('resource_type');
            $table->index('is_active');
            $table->index('display_order');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
        
        Schema::dropIfExists('resource_categories');
    }
};
