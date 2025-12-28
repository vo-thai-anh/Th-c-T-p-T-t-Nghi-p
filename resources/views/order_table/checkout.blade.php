@extends('layouts.app')

@section('content')
<div class="container">
    <div class="checkout-card">
        <h1 class="title">Hoàn Tất Đơn Hàng</h1>
                @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                @endif
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif
        <form  action="{{ route('thanhtoan') }}" method="POST">
            @csrf
            <div class="checkout-grid">
                <div class="checkout-info">
                    <section class="section-info">
                        <h2>Thông Tin Nhận Hàng</h2>
                        <div class="form-group">
                            <input type="hidden" name="status" required value="pending">
                        </div>
                        <div class="form-group">
                            <label>Tên người nhận *</label>
                            <input type="text" name="fullname" required value="{{ Auth::user()->fullname }}">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại *</label>
                            <input type="text" name="phone" required value="{{ Auth::user()->phone_number }}">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ giao hàng *</label>
                            <input type="text" name="address" required value="{{ Auth::user()->address }}">
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea name="note">  </textarea>
                        </div>
                    </section>

                    <section class="section-payment">
                        <h2>Phương Thức Thanh Toán</h2>
                        <label><input type="radio" name="method_pay" value="COD" checked> Thanh toán khi nhận hàng</label>
                        <label><input type="radio" name="method_pay" value="Bank Transfer"> Chuyển khoản ngân hàng</label>
                    </section>
                </div>
                
                <div class="checkout-summary">
                    
                    <h2>Đơn Hàng Của Bạn</h2>

                    <div class="cart-items">
                        @foreach ($productsInCart as $item)
                            <div class="cart-item">
                                <span>{{ $item->name }} x {{ $item->quantity }}</span>
                                <span>{{ number_format($item->quantity * $item->price) }}₫</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($subTotalItem) }}₫</span>
                        <input type="hidden" name="total_amount" value="{{ $subTotalItem }}">
                    </div>

                    <div class="summary-row">
                        <span>Phí vận chuyển:</span>
                        <span>{{ number_format($shippingFee) }}₫</span>
                        <input type="hidden" name="shipping_fee" value="{{ $shippingFee }}">
                    </div>

                    <div class="summary-row total">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($final_total) }}₫</span>
                        <input type="hidden" name="final_total" value="{{$final_total}}">
                    </div>
                    <button class="btn-submit">
                            ĐẶT HÀNG NGAY
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

