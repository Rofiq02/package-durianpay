<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Promo;

use RofiqDev\DurianPay\Http\Client as HttpClient;
use RofiqDev\DurianPay\Customer\Info as CustomerInfo;
use DateTime;

class Promo
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function create(
        string $label,
        string $description,
        string $promoCode,
        int $minOrderAmount,
        int $maxOrderAmount,
        int $maxDiscountAmount,
        DateTime $startsAt,
        DateTime $endsAt,
        string $promoDetails,
        int $discountAmount,
        int $limitAmount,
        Constants $promoType = Constants::PROMO_TYPE_VA,
        Constants $promoSubType = Constants::PROMO_SUBTYPE_DIRECT_DISCOUNT,
        Constants $discountType = Constants::DISCOUNT_PERCENTAGE,
        Constants $limitType = Constants::LIMIT_QUOTA,
        Constants $priceDeductionType = Constants::DEDUCTION_TOTAL_PRICE
    ) {
        $endpoint = 'merchants/promos';
        $headers = ['Content-Type' => 'application/json'];
        $payloads = [
            'currency' => 'IDR',
            'label' => $label,
            'description' => $description,
            'code' => $promoCode,
            'starts_at' => $startsAt->format(DateTime::ATOM),
            'ends_at' => $endsAt->format(DateTime::ATOM),
            'min_order_amount' => (string) $minOrderAmount,
            'max_discount_amount' => (string) $maxDiscountAmount,
            'type' => $promoType,
            'promo_details' => [
                'bin_list' => [12, 23], // ???????????
                'bank_codes' => ['BCA'], // ???????????
            ],
            'discount' => $discountAmount,
            'discount_type' => $discountType,
            'limit_type' => $limitType,
            'limit' => $limitAmount,
            'sub_type' => $promoSubType,
            'price_deduction_type' => $priceDeductionType,
        ];

        return $this->httpClient->post($endpoint, $payloads, $headers);
    }
}
