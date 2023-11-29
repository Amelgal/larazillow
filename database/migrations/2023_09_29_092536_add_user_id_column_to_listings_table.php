<?php

use App\Models\User;
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
        Schema::table('listings', function (Blueprint $table) {
            $table->foreignIdFor(
                User::class,
                'user_id'
            )->constrained(
                'users',
                'id'
            )->cascadeOnDelete(
                'cascade'
            )->cascadeOnUpdate(
                'cascade'
            )->after(
                'id'
            )->comment(
                'The user who owns the listing'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
};
