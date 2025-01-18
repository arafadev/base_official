<?php
namespace App\Models;
use App\Traits\UploadTrait;

class Settlement extends Model
{
    const IMAGEPATH = 'settlements';
    
    use UploadTrait;

    protected $guarded = [];

    public function transactionable()
    {
        //? rel with users, admins, providers, delegates
        return $this->morphTo();
    }

    public function getStatusTextAttribute()
    {
        return __('site.settlements_status_' . $this->attributes['status']);
    }

    public function financialtransactionable()
    {
        return $this->belongsToMany(FinancialTransaction::class, 'financial_transaction_settlements', 'settlement_id', 'financial_id');
    }

    public static function boot()
    {
        parent::boot();
        /* creating, created, updating, updated, deleting, deleted, forceDeleted, restored */

        static::deleted(function ($model) {
            $model->deleteFile($model->attributes['image'], 'settlements');
        });
    }

}
