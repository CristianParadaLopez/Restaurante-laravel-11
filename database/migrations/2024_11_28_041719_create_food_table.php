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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string("image")->nullable();
            $table->string("description")->nullable();
            $table->text('ingredients')->nullable();
            $table->string('proteins')->nullable();
            $table->integer('calories')->nullable();
            $table->string('size')->nullable();
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories') // Relación con la tabla 'categories'
                  ->onDelete('set null');     // Si se elimina la categoría, este campo queda como NULL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
