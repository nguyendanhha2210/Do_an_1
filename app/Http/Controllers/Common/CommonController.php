<?php

namespace App\Http\Controllers\Common;

use App\Enums\SortByOption;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function getSortOption()
    {
        try {
            $response = [
                [
                    'key' => SortByOption::NEWS,
                    'value' => SortByOption::getDescription(SortByOption::NEWS),
                ],
                [
                    'key' => SortByOption::PRICEINCREASE,
                    'value' => SortByOption::getDescription(SortByOption::PRICEINCREASE),
                ],
                [
                    'key' => SortByOption::REDUCEDPRICE,
                    'value' => SortByOption::getDescription(SortByOption::REDUCEDPRICE),
                ],
                [
                    'key' => SortByOption::AToZ,
                    'value' => SortByOption::getDescription(SortByOption::AToZ),
                ],
                [
                    'key' => SortByOption::ZToA,
                    'value' => SortByOption::getDescription(SortByOption::ZToA),
                ],
            ];
            return response()->json($response, StatusCode::OK);
        } catch (\Exception$e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
