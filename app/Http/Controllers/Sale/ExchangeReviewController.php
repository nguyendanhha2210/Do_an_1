<?php

namespace App\Http\Controllers\Sale;

use App\Enums\CommentRank;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\ExchangeReview;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExchangeReviewController extends Controller
{
    public function getExchangeReview(Request $request)
    {
        try {
            $exchangeReviews = ExchangeReview::where('rank', '=', CommentRank::FIRSTRANK)->orderBy('created_at', 'desc')->paginate(3);
            return response()->json(['exchangeReviews' => $exchangeReviews], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        try {
            $idUser = Auth::guard('sales')->id();
            $user = User::find($idUser);
            $ExchangeReview = new ExchangeReview();
            $ExchangeReview->name = $user->name;
            $ExchangeReview->images = $user->images;
            $ExchangeReview->content = $request->content;
            $ExchangeReview->rank = CommentRank::FIRSTRANK;
            $code = substr(md5(microtime()), rand(0, 26), 5); //tạo rundle chữ và số xong lấy 5 kí tự
            $ExchangeReview->code = $code;
            $flag = $ExchangeReview->save();
            if ($flag) {
                return response()->json('ExchangeReview success !', StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function replyExchangeReview(Request $request, $id)
    {
        try {
            $idUser = Auth::guard('sales')->id();
            $user = User::find($idUser);
            $ExchangeReviewCode = ExchangeReview::find($id);
            $ExchangeReview = new ExchangeReview();
            $ExchangeReview->name = $user->name;
            $ExchangeReview->images =  $user->images;
            $ExchangeReview->content = $request->repExchangeReview;
            $ExchangeReview->rank = CommentRank::SECONDRANK;
            $ExchangeReview->code = $ExchangeReviewCode->code;
            $flag = $ExchangeReview->save();
            if ($flag) {
                return response()->json('ExchangeReview success !', StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getExchangeReviewReply(Request $request, $id)
    {
        try {
            // $ExchangeReviews = ExchangeReview::where('product_id', '=', $id)->where('rank','=',CommentRank::FIRSTRANK)->orderBy('created_at', 'desc')->get();
            $exchangeReviewCode = ExchangeReview::find($id);
            $exchangeReviews = ExchangeReview::where('rank', '=', CommentRank::SECONDRANK)->where('code', '=',  $exchangeReviewCode->code)->orderBy('created_at', 'desc')->get();
            $countReply = ExchangeReview::where('rank', '=', CommentRank::SECONDRANK)->where('code', '=',  $exchangeReviewCode->code)->get()->count();

            return response()->json(['exchangeReviews' => $exchangeReviews, 'countReply' => $countReply], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function replyExchangeReviewSecond(Request $request, $code)
    {
        try {
            $idUser = Auth::guard('sales')->id();
            $user = User::find($idUser);
            $ExchangeReview = new ExchangeReview();
            $ExchangeReview->name = $user->name;
            $ExchangeReview->images = $user->images;
            $ExchangeReview->content = $request->repExchangeReview;
            $ExchangeReview->rank = CommentRank::SECONDRANK;
            $ExchangeReview->code = $code;
            $flag = $ExchangeReview->save();
            if ($flag) {
                return response()->json('ExchangeReview success !', StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function exchangeReviewDelete(Request $request)
    {
        $codeExchangeReview = $request->codeExchangeReview;
        $idExchangeReview = $request->idExchangeReview;

        $ExchangeReview = ExchangeReview::where('code', '=', $codeExchangeReview)->where('id', '=', $idExchangeReview)->first();
        if ($ExchangeReview->rank == CommentRank::FIRSTRANK) {
            $ExchangeReviews = ExchangeReview::where('code', '=', $codeExchangeReview)->get();
            foreach ($ExchangeReviews as $key) {
                if ($key->code = $codeExchangeReview) {
                    $key->delete();
                }
            }
        } else {
            ExchangeReview::where('code', '=', $codeExchangeReview)->where('id', '=', $idExchangeReview)->delete();
        }
    }

    public function fillImage()
    {
        try {
            $idUser = Auth::guard('sales')->id();
            $user = User::where('id', $idUser)->first();

            return view('admin.types.index', ['user' => $user->images]);
            // return response()->json(["image" => $user->images], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
