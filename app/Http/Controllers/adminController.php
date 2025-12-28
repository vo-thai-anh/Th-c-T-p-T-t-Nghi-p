<?php

namespace App\Http\Controllers;


use App\Models\Order_table;
use App\Models\Payment;


class adminController extends Controller
{
    public function verifyPayment($order_id)
    {
        Payment::where('order_id', $order_id)
            ->update(['status' => 'Đã Thanh Toán']);

        Order_table::where('order_id', $order_id)
            ->update(['status' => 'Hoàn Tất']);

        return back()->with('success', 'Xác nhận thanh toán thành công');
    }
    public function index()
{
    return view('admin.dashboard', [
        'totalOrders'     => Order_table::count(),
        'pendingOrders'   => Order_table::where('status','pending')->count(),
        'completedOrders' => Order_table::where('status','completed')->count(),
        'totalRevenue'    => Order_table::where('status','completed')->sum('final_total'),
        'unpaidPayments'  => Payment::where('status','unpaid')->count(),
        'latestOrders'    => Order_table::latest()->take(5)->get(),
    ]);
}

}
