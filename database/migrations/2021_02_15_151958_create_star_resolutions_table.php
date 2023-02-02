<?php
/** @noinspection ALL */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('star_resolutions', static function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();

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
        Schema::dropIfExists('star_resolutions');
    }
}
