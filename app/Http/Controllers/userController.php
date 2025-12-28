<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order_table;
use App\Models\Orderdt;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

// Thay 1 bằng ID của tài khoản đang gặp lỗi

    public function indexUser(){
        $user = DB::table('users')
            ->select('user_id','username','phone_number','email','role')
            ->orderBy('user_id','desc')
            ->paginate(10);
            return view('admin.indexUser',compact('user'));
    }
    public function register(){
        return view('login-logout.register');
    }
    public function acpregister(request $request){
        $request->validate([
            'username'=>'required|string|max:255|unique:users,username' ,
            'password'=>'required|string|min:1|confirmed',
            'email'=>'required|email|max:255|unique:users,email',
            'fullname'=>'required|string|max:100',
            'phone_number'=> 'required|string|max:15',
            'address' => 'required|string|max:255',
            'role' => 'nullable|string|in:user,admin'
        ]);
        try{
            $user=User::create([
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'email'=>$request->email,
            'fullname'=>$request->fullname,
            'phone_number'=>$request->phone_number,
            'address'=>$request->address,
            'role'=>$request->role ??'user'
        ]);
                return redirect()->intended('login')
            ->with('success', 'Đăng ký thành công');
        }
        catch(Exception $e){
            return back()->with('error',' đã trùng '.$e->getMessage());
        }
    }
    public function login(){
        return view('login-logout.login');
    }
    public function checklogin(request $request){
        $request->validate([
        'email'=>'required|email',
        'password'=>'required|string|min:1',
    ]);
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
        $user = Auth::user();
        if($user->isadmin()){
            return redirect('admin/admin/dashboard')->with('success','đăng nhập thành công');
        }
        return redirect('/')->with('success','đăng nhập thành công ');
    }
        return back()->withErrors(['email'=>'email hoặc mật khẩu không đúng',])
        ->withInput();
    }
    public function logout(request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success','Đăng xuất thành công');
    }
    // public function checklogin(request $request){
    //     $request->validate([
    //         'username'=>'required|string',
    //         'password'=>'required|string'
    //     ]);
    //     $user=user::where('username',$request->username)->first();
    //     if( !$user || !Hash::check($request->password,$user->password)){
    //         return redirect()
    //         ->route('login')
    //         ->withErrors(['username'=>'Thông tin đăng nhập không hợp lệ'])
    //         ->withInput($request->only('username'));
    //     }
    //     else{
    //         Auth::login($user);
    //         return redirect()->intended('/')->with('success','Đăng nhập thành công');
    //     }
    // }
    public function deleteuser(string $id)
    {
        DB::beginTransaction();
        try {
            if (Auth::id() == $id) {
                return back()->with('error', 'Không thể xóa chính bạn');
            }
            $orders = Order_table::where('user_id', $id)->pluck('order_id');
            
            Orderdt::whereIn('order_id', $orders)->delete();
            Payment::whereIn('order_id', $orders)->delete();
            Order_table::where('user_id', $id)->delete();
            Cart::where('user_id', $id)->delete();
            User::where('user_id', $id)->delete();
            DB::commit();
            return back()->with('success', 'Xóa người dùng thành công');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể xóa người dùng: ' . $e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.user.indexUser')->with('alert', [
                'type' => 'warning',
                'title' => 'Không tìm thấy!',
                'message' => 'User không tồn tại.'
            ]);
        }
        return view('admin.editUser', compact('user'));
    }
    public function updateuser(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('alert', [
                'type' => 'warning',
                'title' => 'Không tìm thấy!',
                'message' => 'User không tồn tại.'
            ]);
        }

        $validated = $request->validate([
            'username'        => 'nullable|string|max:255',
            'email'           => 'nullable|email|unique:users,email,' . $user->user_id . ',user_id',
            'fullname'        => 'nullable|string|max:255',
            'phone_number'    => 'nullable|string|max:15',
            'address'         => 'nullable|string|max:255',
            'role'            => 'nullable|string',
        ]);

        $user->update([
            'username'      => $validated['username'] ?? $user->username,
            'email'         => $validated['email'] ?? $user->email,
            'fullname'      => $validated['fullname'] ?? $user->fullname,
            'phone_number'  => $validated['phone_number'] ?? $user->phone_number,
            'address'       => $validated['address'] ?? $user->address,
            'role'          => $validated['role'] ?? $user->role,
        ]);

        if ($user->order_table) {
            $user->order_table->update([
                'fullname'  => $validated['fullname'] ?? $user->order_table->fullname,
                'phone'     => $validated['phone_number'] ?? $user->order_table->phone,
                'address'   => $validated['address'] ?? $user->order_table->address,
            ]);
        }

        return redirect()->route('admin.user.indexUser')->with('alert', [
            'type' => 'success',
            'title' => 'Cập nhật thành công!',
            'message' => 'User đã được cập nhật.'
        ]);
    }
    public function reset(string $id){
        User::where('user_id', $id)->update([
        'password' => Hash::make('1')
    ]);
    return back()->with('success', 'Đã reset mật khẩu về 1');
    }
}
