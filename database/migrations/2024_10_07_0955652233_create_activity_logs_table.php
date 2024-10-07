<?php

use App\Constants\Status;
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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // Assuming a user has a foreign key
            // $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Assuming a role has a foreign key
            $table->string('role_id');
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('activity'); // Activity description
            $table->string('action'); // Action type: create, update, delete
            $table->string('status')->default(Status::ACTIVE); // Using string 'DRAFT' for the default value
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key first
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            // $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists('activity_logs');
    }
};
