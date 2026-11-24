<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('category');
            $table->string('level');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->date('joined_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
