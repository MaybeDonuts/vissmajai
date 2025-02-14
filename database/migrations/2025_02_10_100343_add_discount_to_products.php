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
            if (!Schema::hasColumn('products', 'discount')) {
                $table->integer('discount')->nullable()->default(0);
            }
            if (!Schema::hasColumn('products', 'discount_start')) {
                $table->timestamp('discount_start')->nullable();
            }
            if (!Schema::hasColumn('products', 'discount_end')) {
                $table->timestamp('discount_end')->nullable();
            }
        });
        
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['discount', 'discount_start', 'discount_end']);
        });
    }
    
};
