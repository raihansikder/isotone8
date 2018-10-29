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
            $table->string('uuid', 64)->nullable()->default(null);
            $table->unsignedInteger('tenant_id')->nullable()->default(null);
            $table->string('name', 36)->nullable()->default(null);

            /*********************************/
            /*  Custom columns
            /*********************************/
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->rememberToken();

            // Email confirmation fields
            $table->boolean('email_confirmed')->default(false);
            $table->dateTime('email_confirmed_at')->nullable()->default(null);
            $table->string('email_confirmation_code', 128)->nullable();

            // Access token
            $table->string('access_token', 256)->nullable()->default(null);
            $table->dateTime('access_token_generated_at')->nullable()->default(null);

            // API token
            $table->string('api_token', 256)->nullable()->default(null);
            $table->dateTime('api_token_generated_at')->nullable()->default(null);

            // Can tenant edit a row?
            $table->boolean('tenant_editable')->default(true);

            // Permission and user group
            $table->string('permissions', 2056)->nullable()->default(null);
            $table->string('usergroups', 2056)->nullable()->default(null); // Stores object/json
            $table->string('usergroup_ids_csv', 256)->nullable()->default(null); // 1,2,3
            $table->string('usergroup_titles_csv', 1024)->nullable()->default(null); // Super admin, Tenant admin

            /*********************************/
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
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
