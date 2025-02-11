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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Авто-инкрементный ID
            $table->string('name', 50)->unique(); // Название товара
            $table->text('description')->nullable(); // Описание
            $table->float('price'); // Цена
            $table->integer('stock'); // Количество на складе
            $table->string('image')->nullable(); // Изображение товара
            $table->timestamps(); // created_at и updated_at
            $table->integer('discount')->default(0); // Скидка в процентах (0 = нет скидки)
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