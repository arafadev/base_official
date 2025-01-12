<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{

		public function up()
		{
			Schema::create('complaints', function (Blueprint $table) {
				$table->id();
				$table->nullableMorphs('userable');
				$table->string('complaint_num')->nullable();
				$table->string('user_name', 50)->nullable();
				$table->string('phone', 20)->nullable();
				$table->string('email', 50)->nullable();
				$table->longText('complaint')->nullable();
				$table->timestamps();
			});
		}

	public function down()
	{
		Schema::dropIfExists('complaints');
	}
}
