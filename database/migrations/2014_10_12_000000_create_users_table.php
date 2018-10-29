<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable()->default(null);
            $table->unsignedInteger('tenant_id')->nullable()->default(null);

            $table->string('name')->nullable()->default(null);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('email_confirmed')->default(false);
            $table->dateTime('email_confirmed_at')->nullable()->default(null);
            $table->string('email_confirmation_code',36)->nullable();

            $table->string('access_token',36)->nullable()->default(null);
            $table->dateTime('access_token_generated_at')->nullable()->default(null);
            $table->string('api_token',36)->nullable()->default(null);
            $table->dateTime('access_token_generated_at')->nullable()->default(null);


            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
