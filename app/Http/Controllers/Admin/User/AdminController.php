<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\LimitTimeForgot;
use App\Enums\OrderStatus;
use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Admin Account'];
            return view('admin.users.admin', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getAdmin(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $admins = User::where('role_id', '=', RoleStateType::MANAGERMENT)->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('email', 'like', '%' . $search . '%');
                }
            })->orderBy('created_at', 'desc')->paginate($paginate);
            return response()->json($admins, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        try {
            $admin = new User();
            $admin->name = $request->name;
            $admin->email  = $request->email;
            $admin->role_id  = RoleStateType::MANAGERMENT;
            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $admin->email_verified_at  = $today;
            $admin->password  =  bcrypt($request->password);
            $admin->reset_password_token  = "";
            $admin->reset_password_token_expire  = $today;
            $admin->remember_token  = "";
            $flagadmin = $admin->save();
            if ($flagadmin) {
                return response()->json(StatusCode::OK);  //Lưu thành công gọi ra đg dẫn về list
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $admin = User::where('id', $id)->firstOrFail();
            $admin->name = $request->name;
            $admin->email  = $request->email;
            $admin->role_id  = RoleStateType::MANAGERMENT;
            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $admin->email_verified_at  = $today;
            $admin->password  =  bcrypt($request->password);
            $admin->reset_password_token  = "";
            $admin->reset_password_token_expire  = $today;
            $admin->remember_token  = "";
            $admin->save();
            return response()->json(StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function destroy($id)
    {
        $admin = User::find($id);
        $admin->delete();
    }
}
