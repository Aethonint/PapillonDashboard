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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
               $table->string('name'); // Product name (Card name)
                  $table->string('price'); // Product name (Card name)
                  $table->unsignedBigInteger('subcategory_id')->nullable(); // Product name (Card name)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Category relation
            $table->enum('type', ['text_only', 'image_only', 'text_image', 'fixed']); // Type of product
            $table->string('thumbnail')->nullable(); // Preview image
            $table->string('background_image'); // Main card background
            $table->json('text_zones')->nullable(); // Editable text positions
            $table->json('image_zones')->nullable(); // Editable image positions
            $table->boolean('status')->default(true); // Active or not
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
