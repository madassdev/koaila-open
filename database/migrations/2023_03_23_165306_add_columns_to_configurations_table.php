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
            $table->json('aha_moment')->nullable();
            $table->json('features')->nullable();
            $table->json('conversion_channel')->nullable();
            $table->string('pricing_page_url')->nullable();
            $table->dropColumn('configuration');
            $table->dropColumn('type');
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
            $table->dropColumn('aha_moment');
            $table->dropColumn('features');
            $table->dropColumn('conversion_channel');
            $table->dropColumn('pricing_page_url');
            $table->json('configuration')->nullable();
            $table->string('type')->nullable();
        });
    }
};
