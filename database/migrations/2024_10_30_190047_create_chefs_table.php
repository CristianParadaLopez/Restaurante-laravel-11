<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chefs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con la tabla users
            $table->string('first_name');
            $table->string('last_name');
            $table->string('specialty');
            $table->text('description')->nullable();
            $table->enum('area', ['preparacion', 'cocinar', 'servir', 'almacenamiento', 'lavar', 'pedidos']);
            $table->string('image')->nullable(); // Para la ruta de la imagen
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('chefs');
    }
    
};
