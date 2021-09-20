<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommentRank;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Evaluate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyCommentController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Comment List'];
            return view('admin.replycomments.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getData(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $replyComments = Evaluate::orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($replyComments, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function singleSend(Request $request)
    {
        try {
            $evaluate = Evaluate::find($request->id);
            $evaluate->rank = CommentRank::SECONDRANK;
            $evaluate->reply_comment = $request->contentReply;
            $flag = $evaluate->update();
            if ($flag) {
                return response()->json(StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
