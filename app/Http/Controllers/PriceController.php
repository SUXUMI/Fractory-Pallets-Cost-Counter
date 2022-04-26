<?php

namespace App\Http\Controllers;

use App\Contracts\ContainersCounter;
use App\Http\Requests\ApiPriceRequest;
use App\Services\FractoryApiService;

class PriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ApiPriceRequest $request, ContainersCounter $container, FractoryApiService $apiService)
    {
        $output = [];

        try {
            // add items into the pallet(s)
            collect($request->get('parts'))->each(fn($item) => $container->addItem(...$item));

            // calculate required pallet(s)
            $palletsCount = $container->getContainersCount();

            // dd($container);

            // get final output
            $output = $apiService->getPalletsCost('GB', 'PE20 3PW', $palletsCount);
        }
        catch (\Exception $e) {
            $output = [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }

        return $output;
    }
}
