<?php

use App\Models\Listing;
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
        Schema::create('listing_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('filename');

            $table->foreignIdFor(
              Listing::class,
                'listing_id'
            )->constrained(
                'listings',
                'id'
            )->cascadeOnDelete(
                'cascade'
            )->cascadeOnUpdate(
                'cascade'
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
        Schema::dropIfExists('listing_images');
    }
};
