<?php

use App\Models\SaleFunnel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_states', function (Blueprint $table) {
            $table->foreignIdFor(SaleFunnel::class, 'funnel_id')->nullable();

            // Remove email column, it already exists on customers table.
            $table->dropColumn('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_states', function (Blueprint $table) {
            $table->dropColumn('funnel_id');

            // Add back the email column on rollback.
            $table->string('email')->nullable();

        });
    }
};