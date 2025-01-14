<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function financialable()
    {
        return $this->morphTo();
    }

    
    public function settlement() 
	{
		return $this->belongsToMany(Settlement::class, 'financial_transaction_settlements', 'financial_id', 'settlement_id');
	}
}

    