<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Promo;

class Constants
{
    public const DISCOUNT_FLAT = 'flat';
    public const DISCOUNT_PERCENTAGE = 'percentage';

    public const LIMIT_QUOTA = 'quota';
    public const LIMIT_BUDGET = 'budget';

    public const DEDUCTION_TOTAL_PRICE = 'total_price';
    public const DEDUCTION_PRODUCT_PRICE = 'product_price';
    public const DEDUCTION_SHIPPING_PRICE = 'shipping_price';

    public const PROMO_TYPE_CARD = 'card_promos';
    public const PROMO_TYPE_EWALLET = 'ewallet_promos';
    public const PROMO_TYPE_VA = 'va_promos';

    public const PROMO_SUBTYPE_DIRECT_DISCOUNT = 'direct_discount';
    public const PROMO_SUBTYPE_CASHBACK = 'cashback';
}
