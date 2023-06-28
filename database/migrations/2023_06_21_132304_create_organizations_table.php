<?php

use App\Models\Organization;
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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number_of_employees');
            $table->timestamps();
        });

        // Add organization_id and role to users table.
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Organization::class, 'organization_id')->nullable();
            $table->string('role')->nullable(); //  admin, member.
            $table->boolean('invite_accepted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');

        // Remove organization_id and role from users table.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('organization_id');
            $table->dropColumn('role');
            $table->dropColumn('invite_accepted');
        });
    }
};