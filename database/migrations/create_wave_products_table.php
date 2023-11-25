<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wave_products', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('unit_price')->nullable();
            $table->boolean('is_sold')->nullable();
            $table->boolean('is_bought')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->json('taxes')->nullable();
            $table->json('account')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(
            'wave_products'
        );
    }
};
