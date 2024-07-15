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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('id_source')->default(0);
            $table->string('reference')->nullable();
            $table->json('product_list')->nullable();
            $table->string('payment');
            $table->integer('customer_id')->default(0);
            $table->text('carrier')->nullable();
			$table->text('id_carrier')->nullable();
            $table->text('total_paid')->nullable();
            $table->text('total_paid_tax_incl')->nullable();
            $table->text('total_paid_tax_excl')->nullable();
            $table->text('total_paid_real')->nullable();
            $table->text('total_products')->nullable();
            $table->text('total_shipping')->nullable();
            $table->text('codfee')->nullable();
			$table->text('voucher')->nullable();
			$table->json('order_object')->nullable();
            $table->longText('note')->nullable();
            $table->integer('user_id')->default(0);
            $table->json('histories')->nullable();
            $table->json('order_payments')->nullable();
            $table->integer('current_state')->default(0);
            $table->json('invoices_collection')->nullable();
            $table->json('order_details_list')->nullable();
     $table->text('message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
