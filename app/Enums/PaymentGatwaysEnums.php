<?php
namespace App\Enums;
/**
 * @method static string all()
 * @method static string allKeys()
 * @method static string|null nameFor($value)
 * @method static array toArray()
 * @method static array forApi()
 * @method static string slug(int $value)
 * @method static array withTitle(string $file = 'enums', string $prefix = '')
 * @method static array toResource(int $value, string $file = 'enums', string $prefix = '')
 * @method static int|string randomValue()
 */
class PaymentGatwaysEnums extends Base
{
	public const PAYPAL = 'Paypal';
    public const STRIPE = 'Stripe';
    public const PAYMOB = 'Paymob';
    public const MYFATOORAH = 'Myfatoorah';
    public const TAP = 'Tap';
    public const MOYASAR = 'Moyasar';
    public const ALRAJHI = 'Alrajhi';




}
