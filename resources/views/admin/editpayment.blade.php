@extends('admin.admin')

@section('admin_content')

{{-- Thông báo --}}
@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
        {{ session('error') }}
    </div>
@endif
<a href="{{ url()->previous() }}"
    class="inline-flex items-center text-black-600 hover:text-gray-800 mb-4">
    ← Quay lại
</a>

<div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl">

    <form action="{{ route('admin.payment.updatepayment', $payment->payment_id) }}"
            method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-semibold">Khách hàng</label>
        <input type="text"
                value="{{ $payment->fullnam }}"
                disabled
                class="w-full p-3 border rounded-lg mb-4 bg-gray-100">

        <label class="block mb-2 font-semibold">Số tiền</label>
        <input type="text"
                value="{{ number_format($payment->amount) }} đ"
                disabled
                class="w-full p-3 border rounded-lg mb-4 bg-gray-100">

        <label class="block mb-2 font-semibold">Phương thức</label>
        <input type="text"
                value="{{$payment->payment_method}}"
                disabled
                class="w-full p-3 border rounded-lg mb-4 bg-gray-100">

        <label class="block mb-2 font-semibold">Trạng thái</label>
        <input type="text"
                value="{{$payment->status}}"
                disabled
                class="w-full p-3 border rounded-lg mb-4 bg-gray-100">

        <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Cập nhật thanh toán
        </button>
    </form>

</div>

@endsection
