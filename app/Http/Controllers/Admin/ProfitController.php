<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeRequest;
use App\Models\Profit;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfitController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Profit List'];
            return view('admin.profits.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getData(Request $request)
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
                // dd($time2);
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
}
