<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Enums\StatusStar;
use App\Http\Controllers\Controller;
use App\Models\Evaluate;
use App\Models\Product;
use App\Models\Profit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{
    //Invoice
    public function invoiceStatistical()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Invoice Statistical'];
            return view('admin.statistical.invoice', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getInvoiceStatistical()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $profits = Profit::select('date', DB::raw('Sum(profit) AS totalProfit'))->groupBy('profits.date')->get(); //Lấy tổng lợi nhuận trong 1 ngày
            $data = [];
            foreach ($profits as $item) {
                $data[] = [
                    "label" => Carbon::parse($item->date)->format('Y/m/d'),
                    "value" => $item->totalProfit,
                    "color" => "#000066"
                ];
            }

            return response()->json(["data" => $data,], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getProfitTable(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }

        if (empty($request->keyword) && empty($request->time1) && empty($request->time2)) {
            $charts = Profit::select(DB::raw('Sum(profit) as totalProfit,DATE(date) as created_date'))
                ->groupBy('created_date')
                ->get();

            $charts = Profit::select(DB::raw('Sum(profit) AS totalProfit, DATE(date) AS dateFormat'))->groupBy('dateFormat')->get(); //Lấy tổng lợi nhuận trong 1 ngày
            $data = [];
            foreach ($charts as $item) {
                $data[] = [
                    "label" => Carbon::parse($item->date)->format('Y/m/d'),
                    "value" => $item->totalProfit,
                    "color" => "#000066"
                ];
            }
            return $collection = collect([
                'amount' => Profit::sum('profit'),
                'profits' => Profit::orderBy('date', 'DESC')->paginate($request->paginate),
                'chart' => $data
            ]);
        } else {
            if (empty($request->keyword)) {
                // $time1 = Carbon::parse($request->time1)->format('Y-m-d');
                // $time2 = Carbon::parse($request->time2)->format('Y-m-d');
                $startTime = $request->time1;
                $endTime = $request->time2;
                $profits = Profit::whereBetween(DB::raw('DATE(date)'), array($startTime, $endTime))->get();

                // $charts = Profit::whereBetween(DB::raw('DATE(date)'), array($time1, $time2))->select(DB::raw('Sum(profit) AS totalProfit,  DATE(date) AS dateFormat'))->groupBy('dateFormat')->get(); //Lấy tổng lợi nhuận trong 1 ngày

                $charts = Profit::where(function ($q) use ($startTime, $endTime) {
                    if ($startTime) {
                        $q->whereDate('date', '>=', $startTime);
                    }
                    if ($endTime) {
                        $q->whereDate('date', '<=', $endTime);
                    }
                })
                    ->select(DB::raw('Sum(profit) as totalProfit,DATE(date) as created_date'))
                    ->groupBy('created_date')
                    ->get();


                $data = [];
                foreach ($charts as $item) {
                    $data[] = [
                        "label" => Carbon::parse($item->created_date)->format('Y/m/d'),
                        "value" => $item->totalProfit,
                        "color" => "#000066"
                    ];
                }
                $amount = 0;
                foreach ($profits as $item) {
                    $amount += $item->profit;
                }
                return $collection = collect([
                    'amount' => $amount,
                    'profits' => Profit::whereBetween(DB::raw('DATE(date)'), array($startTime, $endTime))->paginate($request->paginate),
                    'chart' => $data
                ]);
            }

            $charts = Profit::where('date', 'LIKE', '%' . $request->keyword . '%')->select('date', DB::raw('Sum(profit) AS totalProfit'))->groupBy('profits.date')->get(); //Lấy tổng lợi nhuận trong 1 ngày
            $data = [];
            foreach ($charts as $item) {
                $data[] = [
                    "label" => Carbon::parse($item->date)->format('Y/m/d'),
                    "value" => $item->totalProfit,
                    "color" => "#000066"
                ];
            }
            $profits = Profit::where('date', 'LIKE', '%' . $request->keyword . '%')->orderBy('date', 'DESC')->get();
            $amount = 0;
            foreach ($profits as $item) {
                $amount += $item->profit;
            }
            return $collection = collect([
                'amount' => $amount,
                'profits' => Profit::where('date', 'LIKE', '%' . $request->keyword . '%')->orderBy('date', 'DESC')->paginate($request->paginate),
                'chart' => $data,
            ]);
        }
    }
    //Invoice

    //Product
    public function productStatistical()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Product Statistical'];
            return view('admin.statistical.product', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getProductStatistical()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $products = Product::where('status', '=', StatusSale::UP)->get();
            $productSold = Product::where('status', '=', StatusSale::UP)->orderBy("product_sold", "ASC")->get();
            $productView = Product::where('status', '=', StatusSale::UP)->orderBy("views", "ASC")->get();

            $dataProductStock = [];
            $dataProductView = [];
            $dataProductSold = [];

            foreach ($products as $item) {
                $dataProductStock[] = [
                    "label" => $item->name,
                    "value" => $item->quantity,
                ];
            }

            foreach ($productView as $item) {
                $dataProductView[] = [
                    "label" => $item->name,
                    "value" => $item->views,
                    "color" => "#BB0000"
                ];
            }

            foreach ($productSold as $item) {
                $dataProductSold[] = [
                    "label" => $item->name,
                    "value" => $item->product_sold,
                    "color" => "#000066"
                ];
            }
            return response()->json(["dataProductStock" => $dataProductStock, "dataProductView" => $dataProductView, "dataProductSold" => $dataProductSold], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    //Rating
    public function ratingStatistical()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Rating Statistical'];
            return view('admin.statistical.rating', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getRatingStatistical()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $starOne = Evaluate::where('star_vote', '=', StatusStar::ONESTAR)->count();
            $starTwo = Evaluate::where('star_vote', '=', StatusStar::TWOSTARS)->count();
            $starThree = Evaluate::where('star_vote', '=', StatusStar::THREESTARS)->count();
            $starFour = Evaluate::where('star_vote', '=', StatusStar::FOURSTARS)->count();
            $starFive = Evaluate::where('star_vote', '=', StatusStar::FIVESTARS)->count();

            $data = [
                "1 Star" => $starOne,
                "2 Star" => $starTwo,
                "3 Star" => $starThree,
                "4 Star" => $starFour,
                "5 Star" => $starFive,
            ];

            foreach ($data as $item => $value) {
                $dataProduct[] = [
                    "label" => $item,
                    "value" => $value,
                    "color" => "#000066"
                ];
            }
            return response()->json(["rating" => $dataProduct], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
