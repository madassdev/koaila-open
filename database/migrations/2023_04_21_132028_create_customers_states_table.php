<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_states', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Customer::class,'customer_id');
            $table->string('email');
            $table->timestamp('date');
            $table->jsonb('plans');
            $table->json('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_states');
    }
};
