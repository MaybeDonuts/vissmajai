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
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('discount_start')->nullable()->change();
            $table->timestamp('discount_end')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dateTime('discount_start')->nullable()->change();
            $table->dateTime('discount_end')->nullable()->change();
        });
    }
    
};
