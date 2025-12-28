<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order_table;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class paymentController extends Controller
{

    public function indexPayment()
    {
            $payments=DB::table('payments')
            ->leftJoin('order_tables','order_tables.order_id','=','payments.order_id')
            ->leftJoin('users','payments.user_id','=','users.user_id')
            ->select('payments.payment_id','users.fullname','payments.amount','payments.payment_method','payments.status','payments.created_at')
            ->orderBy('order_tables.order_id','desc')
            ->get();
            return view('admin.indexPayment',compact('payments'));
    }

    /**
     * Xem chi tiết 1 thanh toán
     */
    // public function edit(string $id)
    // {
    //     $payment = Payment::find($id);
    //     if (!$payment) {
    //         return redirect()->route('admin.payment.editpayment')->with('alert', [
    //             'type' => 'warning',
    //             'title' => 'Không tìm thấy!',
    //             'message' => 'payment không tồn tại.'
    //         ]);
    //     }
    //     return view('admin.editpayment', compact('payment'));
    // }
    // public function updatepayment(Request $request, string $id)
    // {
    //     $payment = Payment::find($id);
    //     if (!$payment) {
    //         return redirect()->back()->with('alert', [
    //             'type' => 'warning',
    //             'title' => 'Không tìm thấy!',
    //             'message' => 'payment không tồn tại.'
    //         ]);
    //     }

    //     $validated = $request->validate([
    //         'amount'          => 'nullable|decimal:2',
    //         'phone_number'    => 'nullable|string|max:15',
    //         'address'         => 'nullable|string|max:255',
    //         'role'            => 'nullable|string',
    //     ]);

    //     $user->update([
    //         'username'      => $validated['username'] ?? $user->username,
    //         'email'         => $validated['email'] ?? $user->email,
    //         'fullname'      => $validated['fullname'] ?? $user->fullname,
    //         'phone_number'  => $validated['phone_number'] ?? $user->phone_number,
    //         'address'       => $validated['address'] ?? $user->address,
    //         'role'          => $validated['role'] ?? $user->role,
    //     ]);

    //     if ($user->order_table) {
    //         $user->order_table->update([
    //             'fullname'  => $validated['fullname'] ?? $user->order_table->fullname,
    //             'phone'     => $validated['phone_number'] ?? $user->order_table->phone,
    //             'address'   => $validated['address'] ?? $user->order_table->address,
    //         ]);
    //     }

    //     return redirect()->route('admin.user.indexUser')->with('alert', [
    //         'type' => 'success',
    //         'title' => 'Cập nhật thành công!',
    //         'message' => 'User đã được cập nhật.'
    //     ]);
    // }

    /**
     * Xóa thanh toán
     */
    public function qrBank($order_id)
    {
        $order = Order_table::findOrFail($order_id);
        return view('payment.qr-bank', compact('order'));
    }

    public function confirm($order_id)
    {
        return redirect()->route('cartitems')
            ->with('success', 'Đã gửi yêu cầu xác nhận thanh toán');
    }


    public function deletepayment(string $id)
    {
        DB::beginTransaction();
        try {

            Payment::where('payment_id', $id)->delete();
            DB::commit();
            return back()->with('success', 'Xóa thanh toán thành công');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể xóa thanh toán: ' . $e->getMessage());
        }
    }
}
