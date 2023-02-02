<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuickSearchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_searchs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type')->nullable()->comment('Loại model lưu để index');
//            $table->integer('model_id')->nullable()->unsigned();
            $table->string('route')->nullable();
            $table->text('search_text');
        });

        // Full Text Index
//        DB::statement('ALTER TABLE quick_searchs ADD FULLTEXT fulltext_index (search_text)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quick_searchs');
    }
}
