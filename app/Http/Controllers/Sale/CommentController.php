<?php

namespace App\Http\Controllers\Sale;

use App\Enums\CommentRank;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getComment(Request $request, $id)
    {
        try {
            $comments = Comment::where('product_id', '=', $id)->where('rank', '=', CommentRank::FIRSTRANK)->orderBy('created_at', 'desc')->paginate(3);
            $count = Comment::where('product_id', '=', $id)->where('rank', '=', CommentRank::FIRSTRANK)->count();

            return response()->json(['comments' => $comments, 'count' => $count], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function store(CommentRequest $request, $id)
    {
        try {
            $comment = new Comment();
            $comment->name = $request->name;
            $comment->images = "1";
            $comment->product_id = $id;
            $comment->content = $request->content;
            $comment->rank = CommentRank::FIRSTRANK;
            $code = substr(md5(microtime()), rand(0, 26), 5); //tạo rundle chữ và số xong lấy 5 kí tự
            $comment->code = $code;
            $flag = $comment->save();
            if ($flag) {
                return response()->json('Comment success !', StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function replyComment(Request $request, $id)
    {
        try {
            $commentCode = Comment::find($id);
            $comment = new Comment();
            $comment->name = "ABC";
            $comment->images = "2";
            $comment->product_id = $request->idProduct;
            $comment->content = $request->repComment;
            $comment->rank = CommentRank::SECONDRANK;
            $comment->code = $commentCode->code;
            $flag = $comment->save();
            if ($flag) {
                return response()->json('Comment success !', StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getCommentReply(Request $request, $id)
    {
        try {
            // $comments = Comment::where('product_id', '=', $id)->where('rank','=',CommentRank::FIRSTRANK)->orderBy('created_at', 'desc')->get();
            $commentCode = Comment::find($id);
            $comments = Comment::where('rank', '=', CommentRank::SECONDRANK)->where('code', '=',  $commentCode->code)->orderBy('created_at', 'desc')->get();
            $countReply = Comment::where('rank', '=', CommentRank::SECONDRANK)->where('code', '=',  $commentCode->code)->get()->count();

            return response()->json(['comments' => $comments, 'countReply' => $countReply], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function replyCommentSecond(Request $request, $code)
    {
        try {
            $comment = new Comment();
            $comment->name = "ABC";
            $comment->images = "2";
            $comment->product_id = $request->idProduct;
            $comment->content = $request->repComment;
            $comment->rank = CommentRank::SECONDRANK;
            $comment->code = $code;
            $flag = $comment->save();
            if ($flag) {
                return response()->json('Comment success !', StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
