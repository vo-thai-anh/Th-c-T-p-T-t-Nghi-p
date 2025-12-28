@extends('admin.admin')

@section('admin_content')

{{-- Thông báo --}}
@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<a href="{{ url()->previous() }}"
    class="inline-flex items-center text-gray-700 hover:text-black mb-4">
    ← Quay lại
</a>

<h1 class="text-3xl font-bold mb-6 text-gray-800">Chỉnh sửa hóa đơn</h1>

<div class="bg-white p-6 rounded-lg shadow w-full max-w-3xl">

    <form action="{{ route('admin.order.updateBill', $inv->orderdt_id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Thông tin khách hàng --}}
        <h2 class="font-semibold text-lg mb-4">Thông tin khách hàng</h2>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="font-semibold">Họ tên</label>
                <input type="text" value="{{ $inv->fullname }}" disabled
                        class="w-full p-2 border rounded bg-gray-100">
            </div>

            <div>
                <label class="font-semibold">SĐT</label>
                <input type="text" value="{{ $inv->phone_number }}"disabled
                        class="w-full p-2 border rounded bg-gray-100">
            </div>

            <div class="col-span-2">
                <label class="font-semibold">Địa chỉ</label>
                <input type="text" value="{{ $inv->address }}"disabled
                        class="w-full p-2 border rounded bg-gray-100">
            </div>
        </div>

        {{-- Thông tin đơn hàng --}}
        <h2 class="font-semibold text-lg mb-4">Thông tin đơn hàng</h2>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="font-semibold">Tổng tiền</label>
                <input type="text" value="{{ number_format($inv->final_total) }} đ" disabled
                        class="w-full p-2 border rounded bg-gray-100">
            </div>

            <div>
                <label class="font-semibold">Phí ship</label>
                <input type="text" value="{{ number_format($inv->shipping_fee) }} đ" disabled
                        class="w-full p-2 border rounded bg-gray-100">
            </div>
        </div>

        <h2 class="font-semibold text-lg mb-4">Cập nhật trạng thái</h2>

        <div class="grid grid-cols-2 gap-4 mb-6">
            {{-- Trạng thái đơn hàng --}}
            <div>
                <label class="font-semibold">Trạng thái đơn hàng</label>
                <select name="order_status"
                        class="w-full p-2 border rounded">
                    <option value="Chờ Xử Lý" {{ $inv->donhang == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="Đang Giao" {{ $inv->donhang == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                    <option value="Hoàn Thành" {{ $inv->donhang == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="Đã Hủy" {{ $inv->donhang == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>

            {{-- Trạng thái thanh toán --}}
            <div>
                <label class="font-semibold">Thanh toán</label>
                <select name="payment_status"
                        class="w-full p-2 border rounded">
                    <option value="Chưa Thanh Toán"
                        {{ $inv->thanhtoan == 'chua thanh toan' ? 'selected' : '' }}>
                        Chưa thanh toán
                    </option>
                    <option value="Đã Thanh Toán"
                        {{ $inv->thanhtoan == 'da thanh toan' ? 'selected' : '' }}>
                        Đã thanh toán
                    </option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label class="font-semibold">Ghi chú</label>
            <textarea name="note"
                    class="w-full p-3 border rounded"
                    rows="3">{{ $inv->note }}</textarea>
        </div>

        <button class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
            Cập nhật hóa đơn
        </button>

    </form>
</div>

@endsection
