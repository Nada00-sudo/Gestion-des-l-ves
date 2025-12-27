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
        Schema::create('emplois', function (Blueprint $table) {
            $table->id();

            // utilisateur (student ou prof)
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // emploi du temps
            $table->string('jour');         
            $table->time('heure_debut');  
            $table->time('heure_fin');       
            $table->string('matiere');    
            $table->string('salle')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emplois');
    }
};
