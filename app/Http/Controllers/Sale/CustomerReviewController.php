<?php

namespace App\Http\Controllers\Sale;

use App\Enums\CommentRank;
use App\Enums\OrderDetailVote;
use App\Enums\OrderStatus;
use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Enums\StatusStar;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Sale\CustmerReviewRequest;
use App\Models\Description;
use App\Models\Evaluate;
use App\Models\EvaluateImage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    public function getVoteProduct(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return view('admin.users.login');
        }
        try {
            $orderDetails = OrderDetail::where('order_code', $request->orderCode)->with('product')->orderBy('status_vote', 'asc')->get();
            return response()->json($orderDetails, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }


    public function customerReview(CustmerReviewRequest $request)
    {
        if (!Auth::guard('sales')->check()) {
            return view('admin.users.login');
        } else {
            DB::beginTransaction();
            try {
                $evaluate = new  Evaluate();
                $evaluate->user_id = Auth::guard('sales')->id();
                $evaluate->order_code = $request->order_code;
                $evaluate->product_id = $request->product_id;
                $evaluate->star_vote = $request->star_vote;
                $evaluate->content = $request->content;
                $evaluate->rank = CommentRank::FIRSTRANK;
                $evaluate->save();

                if (!empty($request->files)) {
                    $insertDataImages = [];
                    foreach ($request->files as $key => $ABC) {
                        foreach ($ABC as $data) {
                            $fileName = $data->getClientOriginalName();
                            $data->move('uploads/comments', $fileName);
                            $insertDataImages[] = [
                                'evaluate_id' => $evaluate->id,
                                'url' => $fileName,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                    }
                    EvaluateImage::insert($insertDataImages);
                }

                //Tính TB số sao mỗi lần KH đánh giá
                $averageStars = Evaluate::where('product_id', $request->product_id)->avg('star_vote');
                $abc = round($averageStars, 1);
                $product = Product::where('id', $request->product_id)->first();
                $product->star_vote = $abc;
                $product->update();

                //update trạng thái đã vote từng sp trong Order Detail
                $orderDetail = OrderDetail::where('order_code', $request->order_code)->where('product_id', $request->product_id)->first();
                $orderDetail->status_vote =  OrderDetailVote::VOTED;
                $orderDetail->update();

                //Lọc tất cả các sp trong Order Detail nếu đánh giá hết chuyển trạng thái Order đã đánh giá
                $countOrderDetail = OrderDetail::where('order_code', $request->order_code)->count();
                $countEvalue = Evaluate::where('order_code', $request->order_code)->count();
                if ($countOrderDetail == $countEvalue) {
                    $order = Order::where('order_code', $request->order_code)->first();
                    $order->order_status = OrderStatus::EVALUATED;
                    $order->update();
                } else {
                }

                DB::commit();
                return response()->json(StatusCode::OK);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
            }
        }
    }

    public function getViewVoted(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return view('admin.users.login');
        }
        try {
            $evaluate = Evaluate::where('order_code', $request->order_code)->where('product_id', $request->product_id)->with('evaluateImages')->first();
            return response()->json($evaluate, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getVotedProduct(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return view('admin.users.login');
        }
        try {
            $orderDetails = OrderDetail::where('order_code', $request->orderCode)->where('status_vote', OrderDetailVote::VOTED)->with('product')->get();
            return response()->json($orderDetails, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getEvaluated(Request $request)
    {
        try {
            $evaluates = Evaluate::where('product_id', $request->product_id)->with(['product', 'user','evaluateImages'])->orderBy('created_at', 'desc')->paginate(5);
            return response()->json(["evaluates" => $evaluates], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getSelect5Star(Request $request)
    {
        try {
            $evaluate5Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::FIVESTARS)->with(['product', 'user','evaluateImages'])->orderBy('created_at', 'desc')->paginate(5);
            $count5Stars = $evaluate5Stars->count();
            return response()->json(["evaluate5Stars" => $evaluate5Stars, "count5Stars" => $count5Stars], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getSelect4Star(Request $request)
    {
        try {
            $evaluate4Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::FOURSTARS)->with(['product', 'user','evaluateImages'])->orderBy('created_at', 'desc')->paginate(5);
            $count4Stars = $evaluate4Stars->count();
            return response()->json(["evaluate4Stars" => $evaluate4Stars, "count4Stars" => $count4Stars], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getSelect3Star(Request $request)
    {
        try {
            $evaluate3Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::THREESTARS)->with(['product', 'user','evaluateImages'])->orderBy('created_at', 'desc')->paginate(5);
            $count3Stars = $evaluate3Stars->count();
            return response()->json(["evaluate3Stars" => $evaluate3Stars, "count3Stars" => $count3Stars], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getSelect2Star(Request $request)
    {
        try {
            $evaluate2Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::TWOSTARS)->with(['product', 'user','evaluateImages'])->orderBy('created_at', 'desc')->paginate(5);
            $count2Stars = $evaluate2Stars->count();
            return response()->json(["evaluate2Stars" => $evaluate2Stars, "count2Stars" => $count2Stars], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getSelect1Star(Request $request)
    {
        try {
            $evaluate1Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::ONESTAR)->with(['product', 'user','evaluateImages'])->orderBy('created_at', 'desc')->paginate(5);
            $count1Stars = $evaluate1Stars->count();
            return response()->json(["evaluate1Stars" => $evaluate1Stars, "count1Stars" => $count1Stars], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getCountStar(Request $request)
    {
        try {
            $count1Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::ONESTAR)->count();
            $count2Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::TWOSTARS)->count();
            $count3Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::THREESTARS)->count();
            $count4Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::FOURSTARS)->count();
            $count5Stars = Evaluate::where('product_id', $request->product_id)->where('star_vote', StatusStar::FIVESTARS)->count();
            $countAll = Evaluate::where('product_id', $request->product_id)->count();
            $countAllImage = Evaluate::where('product_id', $request->product_id)->whereHas('evaluateImages', function ($query) {
                $query->where('url','!=','');})->count();

            return response()->json(
                [
                    "count1Stars" => $count1Stars,
                    "count2Stars" => $count2Stars,
                    "count3Stars" => $count3Stars,
                    "count4Stars" => $count4Stars,
                    "count5Stars" => $count5Stars,
                    "countAll" => $countAll,
                    "countAllImage" => $countAllImage,
                ],
                StatusCode::OK
            );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
