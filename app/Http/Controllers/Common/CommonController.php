<?php

namespace App\Http\Controllers\Common;

use App\Enums\LimitNumber;
use App\Enums\OrderStatus;
use App\Enums\SortByOption;
use App\Enums\StatusCode;
use App\Enums\WareHouserOption;
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

    public function getWareHouserOption()
    {
        try {
            $response = [
                [
                    'key' => WareHouserOption::PERMITTED,
                    'value' => WareHouserOption::getDescription(WareHouserOption::PERMITTED),
                ],
                [
                    'key' => WareHouserOption::ENTERED,
                    'value' => WareHouserOption::getDescription(WareHouserOption::ENTERED),
                ],
                [
                    'key' => WareHouserOption::EXCELIMPORT,
                    'value' => WareHouserOption::getDescription(WareHouserOption::EXCELIMPORT),
                ],
            ];
            return response()->json($response, StatusCode::OK);
        } catch (\Exception$e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getOrderStatus()
    {
        try {
            $response = [
                [
                    'key' => OrderStatus::ORDER,
                    'value' => OrderStatus::getDescription(OrderStatus::ORDER),
                ],
                [
                    'key' => OrderStatus::SHIPPING,
                    'value' => OrderStatus::getDescription(OrderStatus::SHIPPING),
                ],
                [
                    'key' => OrderStatus::SUCCESS,
                    'value' => OrderStatus::getDescription(OrderStatus::SUCCESS),
                ],
                [
                    'key' => OrderStatus::EVALUATED,
                    'value' => OrderStatus::getDescription(OrderStatus::EVALUATED),
                ],
                [
                    'key' => OrderStatus::FAILURE,
                    'value' => OrderStatus::getDescription(OrderStatus::FAILURE),
                ],
                [
                    'key' => OrderStatus::RETURNS,
                    'value' => OrderStatus::getDescription(OrderStatus::RETURNS),
                ],
            ];
            return response()->json($response, StatusCode::OK);
        } catch (\Exception$e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
