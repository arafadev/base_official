<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
          $table->id();
          $table->string('name',50);
          $table->string('country_code',5)->default('966');
          $table->string('phone',15);
          $table->string('email',50);
          $table->string('password',100)->nullable();
          $table->string('avatar', 50)->nullable();
          $table->boolean('is_active')->default(false);   // by otp active
          $table->boolean('is_approved')->default(false); // by admin 
          $table->boolean('is_blocked')->default(false);  // by admin
          $table->string('lang', 3)->default('ar');
          $table->boolean('is_notify')->default(true);
          $table->string('code', 10)->nullable();
          $table->timestamp('code_expire')->nullable();
        //   $table->double('lat', 10, 8)->nullable();
        //   $table->double('lng', 11, 8)->nullable();
        //   $table->string('map_desc')->nullable();
        //   $table->decimal('wallet_balance', 9,2)->default(0);
          $table->softDeletes();
          $table->timestamp('created_at')->useCurrent();
          $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
      }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
