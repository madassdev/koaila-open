<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Configuration::class,'config_id');
            $table->string('stripe_id')->nullable();
            $table->string('usage_tracking_id')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('data_mappings');
    }
};
