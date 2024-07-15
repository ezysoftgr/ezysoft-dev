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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('id_source')->nullable();
            $table->string('reference')->nullable();
            $table->text('price')->nullable();
            $table->text('mpn')->nullable();
            $table->text('ean')->nullable();
            $table->text('name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_short')->nullable();
            $table->integer('id_lang')->default(0);
            $table->text('manufacturer')->nullable();
            $table->json('images')->nullable();
			$table->longText('default_image')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('category_full_path')->default(0);
            $table->integer('id_category_default')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('skroutz_price')->default(0);
            $table->string('shopflix_price')->default(0);
            $table->string('available_now')->nullable();
			$table->string('wholesale_price')->nullable();
			$table->text('meta_description')->nullable();
			$table->text('meta_title')->nullable();
            $table->json('features')->nullable();
			$table->boolean('active')->default(1);
            $table->text('category_name_default')->nullable();
            $table->json('categories_ids')->nullable();
            $table->boolean('has_image')->default(0);
            $table->boolean('has_features')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
