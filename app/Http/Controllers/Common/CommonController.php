<?php

namespace App\Http\Controllers\Common;

use App\Enums\LimitNumber;
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

    public function getLimitNumber()
    {
        try {
            $response = [
                [
                    'key' => LimitNumber::FIVE,
                    'value' => LimitNumber::getDescription(LimitNumber::FIVE),
                ],
                [
                    'key' => LimitNumber::TEN,
                    'value' => LimitNumber::getDescription(LimitNumber::TEN),
                ],
                [
                    'key' => LimitNumber::TWENTY,
                    'value' => LimitNumber::getDescription(LimitNumber::TWENTY),
                ],
                [
                    'key' => LimitNumber::THIRTY,
                    'value' => LimitNumber::getDescription(LimitNumber::THIRTY),
                ],
            ];
            return response()->json($response, StatusCode::OK);
        } catch (\Exception$e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
