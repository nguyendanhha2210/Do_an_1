<?php

namespace App\Http\Controllers\Sale;

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
            // $comments = Comment::where('product_id', '=', $id)->orderBy('created_at', 'desc')->get();
            $comments = Comment::where('product_id', '=', $id)->orderBy('created_at', 'desc')->paginate(5);
            $count = Comment::where('product_id', '=', $id)->count();
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
            $flag = $comment->save();
            if ($flag) {
                return response()->json('Comment success !', StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
