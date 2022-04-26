<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FractoryApiService
{
    public function __construct(protected Http $client)
    {
    }

    /**
     * @throws \Exception
     */
    public function getPalletsCost(string $countryCode, string $postalCode, int $palletsCount): array
    {
        $endpoint = $this->getPalletsCostEndpoint();

        $result = $this->client::post($endpoint, [
                'countryCode' => $countryCode, // 'GB',
                'postalCode' => $postalCode, // 'PE20 3PW',
                'pallets' => $palletsCount,
            ])
            ->onError(fn() => throw new \Exception('Unable to fetch data from API'))
            ->object()
        ;

        return [
            'cost' => $result->totalCost->value,
            'provider' => $result->provider,
            'pallets' => $palletsCount,
        ];
    }

    private function getPalletsCostEndpoint(): string
    {
        return config('services.fractory.endpoint').'/getprice/pallet/';
    }
}
