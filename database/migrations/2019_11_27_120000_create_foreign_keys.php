<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration {

	public function up()
	{
        Schema::table('file', function(Blueprint $table) {
            $table->foreign('folder_id')->references('id')->on('folder')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('file', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
	}

	public function down()
	{
		Schema::table('file', function(Blueprint $table) {
			$table->dropForeign('file_folder_id');
		});
		Schema::table('file', function(Blueprint $table) {
			$table->dropForeign('file_user_id');
		});
	}
}
