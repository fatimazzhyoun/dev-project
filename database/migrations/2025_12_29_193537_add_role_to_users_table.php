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
        Schema::table('users', function (Blueprint $table) {
            // Ajouter le rôle
            $table->enum('role', ['admin', 'responsable', 'user', 'guest'])
                  ->default('guest')
                  ->after('password');
            
            // Ajouter le status
            $table->enum('status', ['active', 'inactive'])
                  ->default('active')
                  ->after('role');
            
            // Informations supplémentaires
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('department', 100)->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'phone', 'department']);
        });
    }
};
