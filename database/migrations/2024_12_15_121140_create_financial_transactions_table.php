<?php

use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\Schema;
use App\Enums\FinancialTransactionStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create( 'financial_transactions', function (Blueprint $table) {
			$table->id();
			$table->morphs('orderable');
			$table->morphs('providerable');
            $table->string('status', 50)->default( FinancialTransactionStatus::NEW )->comment(FinancialTransactionStatus::all());
            $table->double( 'order_price', 8, 2 )->default( 0 );
            $table->double( 'commission_amount', 8, 2 )->default( 0 );
            $table->double( 'vat_amount', 8, 2 )->default( 0 );
            $table->double( 'final_price', 8, 2 )->default( 0 );
            $table->double( 'due', 8, 2 )->default( 0 );
            $table->double( 'indebtedness', 8, 2 )->default( 0 );
            $table->timestamp( 'created_at' )->useCurrent();
            $table->timestamp( 'updated_at' )->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists( 'financial_transactions' );
    }
};
