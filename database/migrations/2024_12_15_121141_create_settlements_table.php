<?php

use App\Enums\SettlementStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settlements', function (Blueprint $table) {
			$table->id();
			$table->morphs('providerable');
			$table->string('settlement_num', 50)->nullable();                                                   // Nullable varchar equivalent column.
			$table->double('amount')->default(0.0);                                                             // Double equivalent column with default value.
			$table->double('total_admin_commission')->default(0.0);                                             // Double equivalent column with default value.
			$table->string('status', '50')->default(SettlementStatus::PENDING)->comment(SettlementStatus::all());
			$table->enum('type', ['due', 'indebtedness'])->default('due');
			$table->text('rejected_reason')->nullable();
			$table->string('image')->nullable();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('settlements');
	}
}
