<?php

namespace App\Enums;

/**
 * Class OrderType
 *
 * @method static string all()
 * @method static string|null nameFor($value)
 * @method static array toArray()
 * @method static array forApi()
 * @method static string slug(int $value)
 */
class FinancialTransactionStatus extends Base
{
	public const NEW      = 'new';
	public const PENDING  = 'pending';
	public const ACCEPTED = 'accepted';
}
