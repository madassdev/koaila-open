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
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('uuid')->nullable();
            $table->dropColumn('api_token');
        });
        foreach (\App\Models\Configuration::all() as $config){
            $config->update(['uuid'=>\Illuminate\Support\Str::uuid()]);
        }
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('uuid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('api_token')->nullable();
            $table->dropColumn('uuid');
        });
    }
};
