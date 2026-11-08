<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body');
            $table->string('image')->nullable();
            $table->string('status')->default('draft'); // draft | published | scheduled
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes(); // tạo cột deleted_at cho thùng rác
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};