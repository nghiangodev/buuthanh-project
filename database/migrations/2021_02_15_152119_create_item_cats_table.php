<?php
/** @noinspection ALL */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_cats', static function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('dob')->nullable();
            $table->tinyInteger('age')->nullable();
            $table->tinyInteger('gender')->default(\App\Enums\Gender::MALE)->comment('1: Nam; 2: Nữ');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('numberal_id')->nullable();
            $table->unsignedBigInteger('star_resolution_id')->nullable();

            $table->tinyInteger('state')->default(App\Enums\ActiveState::ACTIVE)->nullable()->comment('-1: Chưa kích hoạt; 1: Đã kích hoạt');
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->index()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
