<?php

namespace App\Http\Controllers;
use App\Models\Order_table;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Orderdt;
use Illuminate\Support\Facades\DB;
use App\Models\Cartitem;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class orderdtController extends Controller
{
    public function indexBill()
    {
        $invoices = DB::table('orderdts')
            ->leftJoin('order_tables', 'order_tables.order_id', '=', 'orderdts.order_id')
            ->leftJoin('users', 'users.user_id', '=', 'order_tables.user_id')
            ->leftJoin('products', 'products.product_id', '=', 'orderdts.product_id')
            ->leftJoin('payments', 'order_tables.order_id', '=', 'payments.order_id')
            ->select('orderdts.orderdt_id','users.fullname','users.phone_number',
            'users.address','order_tables.final_total','order_tables.shipping_fee','order_tables.status as donhang'
            ,'payments.payment_method','orderdts.created_at','order_tables.note','payments.status as thanhtoan')
            ->orderBy('orderdts.orderdt_id', 'desc')
            ->paginate(100);
        return view('admin.indexBill', compact('invoices'));
    }

    public function editBill(string $id)
    {
        $inv = DB::table('orderdts')
            ->leftJoin('order_tables', 'order_tables.order_id', '=', 'orderdts.order_id')
            ->leftJoin('users', 'users.user_id', '=', 'order_tables.user_id')
            ->leftJoin('payments', 'order_tables.order_id', '=', 'payments.order_id')
            ->where('orderdts.orderdt_id', $id)
            ->select(
                'orderdts.orderdt_id',
                'orderdts.order_id',

                'users.fullname',
                'users.phone_number',
                'users.address',

                'order_tables.final_total',
                'order_tables.shipping_fee',
                'order_tables.status as donhang',
                'order_tables.note',

                'payments.payment_method',
                'payments.status as thanhtoan'
            )
            ->first();

        if (!$inv) {
            return redirect()->route('admin.order.indexbill')
                ->with('error', 'Bill không tồn tại');
        }

        return view('admin.editBill', compact('inv'));
    }
    public function updateBill(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $orderdt = Orderdt::find($id);
            if (!$orderdt) {
                return back()->with('error', 'Hóa đơn không tồn tại');
            }

            $order = Order_table::find($orderdt->order_id);
            $user = User::find($order->user_id);
            $payment = Payment::where('order_id', $order->order_id)->first();

            $validated = $request->validate([
                'fullname'      => 'nullable|string|max:255',
                'phone_number'  => 'nullable|string|max:15',
                'address'       => 'nullable|string|max:255',
                'final_total'   => 'nullable|decimal:2',
                'shipping_fee'  => 'nullable|decimal:2',
                'order_status'  => 'nullable|string|max:50',
                'payment_status'=> 'nullable|string|max:50',
                'note'          => 'nullable|string|max:255',
            ]);

            if ($user) {
                $user->update([
                    'fullname'     => $validated['fullname'] ?? $user->fullname,
                    'phone_number' => $validated['phone_number'] ?? $user->phone_number,
                    'address'      => $validated['address'] ?? $user->address,
                ]);
            }

            if ($order) {
                $order->update([
                    'final_total'  => $validated['final_total'] ?? $order->final_total,
                    'shipping_fee' => $validated['shipping_fee'] ?? $order->shipping_fee,
                    'status'       => $validated['order_status'] ?? $order->status,
                    'note'         =>$validated['note'] ?? $order->note
                ]);
            }

            if ($payment) {
                $payment->update([
                    'status' => $validated['payment_status'] ?? $payment->status,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.order.indexbill')
                ->with('success', 'Cập nhật hóa đơn thành công');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deletebill(String $id)
    {
        DB::beginTransaction();
        try {

            Orderdt::where('orderdt_id', $id)->delete();

            DB::commit();
            return back()->with('success', 'Xóa hóa đơn thành công');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể xóa hóa đơn');
        }
    }
}
