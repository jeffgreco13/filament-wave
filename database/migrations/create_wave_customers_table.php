<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wave_customers', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name')->nullable();
            $table->json('address')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('toll_free')->nullable();
            $table->string('website')->nullable();
            $table->text('internal_notes')->nullable();
            $table->json('currency')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->json('meta')->nullable(); // Used to store additional information about the customer, like outstandingBalance, overdueAmount, createdAt, modifiedAt, etc.

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(
            'wave_customers'
        );
    }
};
