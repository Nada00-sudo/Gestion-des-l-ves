<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('semestre'); // S1, S2...

            $table->string('matiere1');
            $table->float('note1');

            $table->string('matiere2');
            $table->float('note2');

            $table->string('matiere3');
            $table->float('note3');

            $table->string('matiere4');
            $table->float('note4');

            $table->string('matiere5');
            $table->float('note5');

            $table->float('moyenne');
            $table->string('decision'); // Admis / Ajourné

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultats');
    }
};
