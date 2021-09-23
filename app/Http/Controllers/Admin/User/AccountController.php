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

class AccountController extends Controller
{
    public function loginForm(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.users.login');
        }

        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');
            $credentials['role_id'] = RoleStateType::MANAGERMENT;

            $message = '';
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect(route('admin.home'));
            } else {
                $message = 'Please check email address and password !';
            }

            return view('admin.users.login', [
                'message' => $message,
                'old_email' => $request->email,
                'old_password' => $request->password,
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin.users.login'));
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $flag = $user->save();
            if ($flag) {
                return response()->json($user, StatusCode::CREATED);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::UNAUTHORIZED);
        }
    }

    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['User List'];
            return view('admin.users.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getUser(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $role = $request->role;
            $users = User::where('role_id', '!=', RoleStateType::MANAGERMENT)->where('role_id', '=', RoleStateType::SALER)->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('email', 'like', '%' . $search . '%');
                }
            })->where(function ($st) use ($role) {
                if ($role) {
                    $st->where('role_id', '=', $role);
                }
            })
                ->orderBy('created_at', 'desc')->paginate($paginate);
            return response()->json($users, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function showViewUser($id)
    {
        $breadcrumbs = ['User Detail'];
        $goBack = '/admin/user';
        return view('admin.users.detailuser', ['breadcrumbs' => $breadcrumbs, 'goBack' => $goBack]);
    }

    public function getUserDetail(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $userDetail = User::where('id', $id)->first();
            $orders = Order::where('customer_id', $id)->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('order_date', 'like', '%' . $search . '%');
                }
            })->orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json(["userDetails" => $userDetail, "orders" =>  $orders], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
