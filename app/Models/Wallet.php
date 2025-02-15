<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
	use HasFactory;

	protected $fillable = [
		'walletable_id',
		'walletable_type',
		'balance',
		'available_balance',
		'debt_balance',
	];

	public function walletable()
	{
		return $this->morphTo();
	}

	public function transactions()
	{
		return $this->hasMany(WalletTransaction::class, 'wallet_id', 'id');
	}

}
