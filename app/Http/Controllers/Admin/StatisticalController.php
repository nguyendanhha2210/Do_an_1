<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
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
        $amount = 0;
        if (empty($request->keyword) && empty($request->time1) && empty($request->time2)) {
            return $collection = collect([
                'amount' => Profit::sum('profit'),
                'profits' => Profit::orderBy('date', 'DESC')->paginate($request->paginate)
            ]);
        } else {
            if (empty($request->keyword)) {
                $time1 = Carbon::parse($request->time1)->format('Y-m-d');
                $time2 = Carbon::parse($request->time2)->format('Y-m-d');
                $profits = Profit::whereBetween(DB::raw('DATE(date)'), array($time1, $time2))->get();
                foreach ($profits as $item) {
                    $amount += $item->profit;
                }
                return $collection = collect([
                    'amount' => $amount,
                    'profits' => Profit::whereBetween(DB::raw('DATE(date)'), array($time1, $time2))->paginate($request->paginate)
                ]);
            }

            $profits = Profit::where('date', 'LIKE', '%' . $request->keyword . '%')->orderBy('date', 'DESC')->get();
            foreach ($profits as $item) {
                $amount += $item->ThanhTien;
            }
            return $collection = collect([
                'amount' => $amount,
                'profits' => Profit::where('date', 'LIKE', '%' . $request->keyword . '%')->orderBy('date', 'DESC')->paginate($request->paginate)
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
        
    }
}
