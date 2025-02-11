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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Внешний ключ на пользователя
            $table->decimal('total_price', 10, 2); // Общая сумма заказа
            $table->string('status')->default('pending'); // Статус (pending, completed, canceled)
            $table->timestamps();
            $table->string('payment_method')->default('наличные');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
