@extends('admin.admin')

@section('admin_content')
    @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
<a href="{{ url()->previous() }}"
    class="inline-flex items-center text-black-600 hover:text-gray-800 mb-4">
    ← Quay lại
</a>
<h1 class="text-3xl font-bold mb-6 text-gray-800">Chi tiết Đơn Hàng</h1>

<div class="mt-6 bg-white p-6 rounded-lg shadow overflow-x-auto">
<table class="w-full border border-gray-300 rounded-lg">
    <thead class="bg-gray-100 border-b">
        <tr class="text-left text-sm">
            <th class="p-3">Khách hàng</th>
            <th class="p-3">Sản phẩm</th>
            <th class="p-3">Số lượng</th>
            <th class="p-3">Giá</th>
            <th class="p-3">Tổng tiền</th>
            <th class="p-3">Thanh toán</th>
            <th class="p-3">SĐT</th>
            <th class="p-3">Địa chỉ</th>
            <th class="p-3">Ship</th>
            <th class="p-3">Ghi chú</th>
            <th class="p-3">PTTT</th>
        </tr>
    </thead>

    <tbody>
        @foreach($details as $or)
        <tr class="border-b hover:bg-gray-50 text-sm">
            <td class="p-3">{{ $or->fullname }}</td>
            <td class="p-3">{{ $or->name }}</td>
            <td class="p-3">{{ $or->quantity }}</td>

            <td class="p-3 text-pink-600">
                {{ number_format($or->price) }} đ
            </td>

            <td class="p-3 font-semibold">
                {{ number_format($or->final_total) }} đ
            </td>

            <td class="p-3">
                <span class="px-2 py-1 rounded bg-blue-100 text-blue-700">
                    {{ $or->status }}
                </span>
            </td>

            <td class="p-3">{{ $or->phone }}</td>
            <td class="p-3">{{ $or->address }}</td>
            <td class="p-3">{{ number_format($or->shipping_fee) }} đ</td>
            <td class="p-3">{{ $or->note }}</td>
            <td class="p-3">{{ $or->method_pay }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
