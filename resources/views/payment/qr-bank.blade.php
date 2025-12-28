<div style="max-width:900px;margin:auto;display:flex;gap:30px">

    <div style="width:35%;border:1px solid #ddd;padding:20px">
        <h3>Thông tin đơn hàng</h3>
        <p>Mã đơn: <b>#{{ $order->order_id }}</b></p>
        <p>Số tiền:
            <b style="color:red;font-size:18px">
                {{ number_format($order->final_total) }}đ
            </b>
        </p>
    </div>

    <div style="width:65%;background:#e91e63;color:#fff;padding:30px;text-align:center">
        <h3>Quét mã QR để thanh toán</h3>

        <img src="{{ asset('images/qr-bank.jpg') }}"
            style="width:280px;background:#fff;padding:10px">

        <p>Nội dung chuyển khoản:</p>
        <b>DH{{ $order->order_id }}</b>

        <form action="{{ route('payment.confirm', $order->order_id) }}" method="POST">
            @csrf
            <button style="margin-top:20px;padding:10px 20px">
                Tôi đã chuyển khoản
            </button>
        </form>
    </div>
</div>
