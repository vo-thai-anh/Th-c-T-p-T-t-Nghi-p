<?php

namespace App\Http\Controllers;

use App\Models\Order_table;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Orderdt;
use Illuminate\Support\Facades\DB;
use App\Models\Cartitem;
use App\Models\Payment;
use Exception;

class order_tableController extends Controller
{
        public function indexOrder(){
            $order=DB::table('orderdts')
            ->leftJoin('order_tables','order_tables.order_id','=','Orderdts.order_id')
            ->leftJoin('payments','payments.order_id','=','order_tables.order_id')
            ->select('orderdts.orderdt_id','orderdts.order_id','order_tables.fullname','order_tables.final_total','payments.status')
            ->orderBy('order_tables.order_id','desc')
            ->get();
            return view('admin.indexOrder',compact('order'));
        }
        public function detailorder(string $id)
        {
            $details = DB::table('orderdts')
                ->join('order_tables', 'order_tables.order_id', '=', 'orderdts.order_id')
                ->leftJoin('payments', 'payments.order_id', '=', 'order_tables.order_id')
                ->where('order_tables.order_id', $id)
                ->select(
                    'order_tables.order_id',
                    'order_tables.fullname',
                    'orderdts.name',
                    'order_tables.phone',
                    'order_tables.address',
                    'order_tables.shipping_fee',
                    'order_tables.final_total',
                    'order_tables.note',
                    'order_tables.method_pay',
                    'payments.status',
                    'orderdts.quantity',
                    'orderdts.price'
                )
                ->get();

            return view('admin.detailOrder', compact('details'));
        }
    
    public function deleteorder(string $id)
    {
        DB::beginTransaction();
        try {
            // Xóa payment
            Payment::where('order_id', $id)->delete();

            // Xóa chi tiết đơn hàng
            Orderdt::where('order_id', $id)->delete();

            // Xóa đơn hàng
            Order_table::where('order_id', $id)->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Xóa đơn hàng thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể xóa đơn hàng');
        }
    }


    protected function getOrCreateCartId()
    {
        $userId = Auth::id();
        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        return $cart->cart_id;
    }
    public function thanhtoan(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $cartId = $this->getOrCreateCartId();
            $items = Cartitem::where('cart_id', $cartId)->get();

            if ($items->isEmpty()) {
                return back()->with('error', 'Giỏ hàng rỗng');
            }

            foreach ($items as $item) {
                $stock = Stock::where('product_id', $item->product_id)
                    ->lockForUpdate()->first();

                if (!$stock || $stock->quantity < $item->quantity) {
                    DB::rollBack();
                    return back()->with(
                        'error',
                        'Sản phẩm ' . $item->name_product . ' không đủ hàng'
                    );
                }
            }

            $order = Order_table::create([
                'user_id' => $userId,
                'total_amount' => $request->total_amount,
                'shipping_fee' => $request->shipping_fee,
                'final_total' => $request->final_total,
                'status' => 'pending',
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'address' => $request->address,
                'note' => $request->note,
                'method_pay' => $request->method_pay,
            ]);

            foreach ($items as $item) {
                Orderdt::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item->product_id,
                    'name' => $item->name_product,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                Stock::where('product_id', $item->product_id)
                    ->decrement('quantity', $item->quantity);
            }

            Payment::create([
                'order_id' => $order->order_id,
                'user_id' => $userId,
                'amount' => $request->final_total,
                'payment_method' => $request->method_pay,
                'status' => 'unpaid',
            ]);

            Cartitem::where('cart_id', $cartId)->delete();
            DB::commit();

            if ($request->method_pay == 'Bank Transfer') {
                return redirect()->route('payment.qrbank', $order->order_id);
            }

            return redirect()->route('cartitems')
                ->with('success', 'Đặt hàng thành công');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function formthanhtoan()
    {
        //lấy user id
        $cart_id=$this->getOrCreateCartId();
        // biến giỏ hàng truy vấn bảng cartitems trong databse
        $productsincart= DB::table('cartitems')
        ->join('products','cartitems.product_id','=','products.product_id')
        ->where('cartitems.cart_id',$cart_id)
        ->select('cartitems.*','products.name as name','products.price as price')
        ->get();

    if($productsincart->isEmpty()){
        return redirect()->route('cartitems')->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
    }
    $subTotalItem = 0;
    $fintal_total =0;
    foreach ($productsincart as $item) {
        $subTotalItem += $item->quantity * $item->price;
    }

    $shippingFee = random_int(0,50)*1000; // Phí vận chuyển cố định
    $fintal_total = $subTotalItem + $shippingFee;
        return view('order_table.checkout',[
            'final_total'=>$fintal_total,
            'productsInCart' => $productsincart,
            'subTotalItem' => $subTotalItem,
            'shippingFee' => $shippingFee,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    
}
