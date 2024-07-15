<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination_product', function (Blueprint $table) {
            $table->id();
            $table->integer('destination_id')->default(0);
            $table->integer('product_id')->default(0);
            $table->integer('id_entry')->default(0);
            $table->boolean('import')->default(0);
            $table->boolean('upd')->default(0);
            $table->boolean('del')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destination_product');
    }
}
