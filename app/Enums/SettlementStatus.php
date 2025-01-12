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
class SettlementStatus extends Base
{
	public const PENDING     = 'pending';
	public const ACCEPTED    = 'accepted';
	public const WAITING_PAY = 'waiting_pay';
	public const PAYED       = 'payed';
	public const REJECTED    = 'rejected';
	public const CANCELLED   = 'cancelled';
}
