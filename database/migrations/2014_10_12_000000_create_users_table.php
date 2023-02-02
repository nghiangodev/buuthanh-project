<?php

use App\Enums\ActiveState;
use App\Enums\Confirmation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('username')->unique();
            $table->string('name')->default('')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 12)->nullable();
            $table->string('avatar')->nullable()->comment('Tên file');
            $table->tinyInteger('state')->default(ActiveState::ACTIVE)->comment('-1: Chưa kích hoạt; 1: Đã kích hoạt');

            $table->unsignedBigInteger('actor_id')->nullable();
            $table->string('actor_type')->nullable();
            $table->index(['actor_id', 'actor_type']);

            $table->tinyInteger('subscribe')->nullable()->default(Confirmation::NO)->comment('Có nhận thông báo hay không: (-1: Không sử dụng; 1: có sử dụng)');
            $table->string('subscribe_type', 12)->comment('Phương thức nhận thông báo: (1: Email; 2: SMS;)')->nullable();

            $table->tinyInteger('use_otp')->nullable()->default(Confirmation::NO)->comment('Có sử dụng OTP hay không: (-1: Không sử dụng; 1: có sử dụng)');
            $table->string('otp', 6)->nullable();
            $table->string('otp_type', 12)->comment('Phương thức nhận OTP: (1: Email; 2: SMS;)')->nullable();
            $table->timestamp('otp_expired_at')->nullable()->comment('OTP hết hạn trong 5 phút');

            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->string('password');
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
}
