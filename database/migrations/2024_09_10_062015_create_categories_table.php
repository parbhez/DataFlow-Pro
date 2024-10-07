<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // // Check if there are tables that reference categories (e.g., category_offer)
        // if (Schema::hasTable('category_offer')) {
        //     Schema::table('category_offer', function (Blueprint $table) {
        //         $table->dropForeign(['category_id']);
        //     });
        // }

        // Now drop the categories table
        Schema::dropIfExists('categories');
    }
};
