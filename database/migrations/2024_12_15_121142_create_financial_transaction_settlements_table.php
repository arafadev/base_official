<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the 'financial_transaction_settlements' table
		Schema::create('financial_transaction_settlements', function (Blueprint $table) {
			$table->id();                                                                                                               // Create a primary key column named 'id'
			$table->foreignId('settlement_id')->constrained('settlements')->cascadeOnDelete()->cascadeOnUpdate();                       // Create a foreign key column named 'settlement_id' that references the 'settlements' table
			$table->foreignId('financial_id')->constrained('financial_transactions')->cascadeOnDelete()->cascadeOnUpdate(); // Create a foreign key column named 'financial_transaction_id' that references the 'financial_transactions' table
			$table->timestamp('created_at')->useCurrent();                                                                              // Create a timestamp column named 'created_at' with current timestamp as default value
			$table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();                                                        // Create a timestamp column named 'updated_at' with current timestamp as default and on update value
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('financial_transaction_settlements');
	}
};
