@extends('admin.admin')
@section('page_title', 'Quản lý hóa đơn')
@section('admin_content')

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

<h1 class="text-3xl font-bold mb-6 text-gray-800">Quản lý hóa đơn</h1>

<div class="bg-white p-6 rounded-lg shadow overflow-x-auto">

    <table class="w-full border border-gray-300 rounded-lg">
        <thead class="bg-gray-100 border-b">
            <tr class="text-left text-sm">
                <th class="p-3">Mã hóa đơn</th>
                <th class="p-3">Khách hàng</th>
                <th class="p-3">Số Điện Thoại</th>
                <th class="p-3">Địa Chỉ</th>
                <th class="p-3">Tổng tiền</th>
                <th class="p-3">Phí ship</th>
                <th class="p-3">Trạng Thái Đơn Hàng</th>
                <th class="p-3">Trạng Thái Thanh Toán</th>
                <th class="p-3">PTTT</th>
                <th class="p-3">Note</th>
                <th class="p-3">Ngày tạo</th>
                <th class="p-3">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $inv)
                <tr class="border-b hover:bg-gray-50 text-sm">
                    <td class="p-3 font-semibold">
                        {{ $inv->orderdt_id }}
                    </td>
                    <td class="p-3">
                        {{ $inv->fullname }}
                    </td>
                    <td class="p-3">
                        {{ $inv->phone_number }}
                    </td>
                    <td class="p-3">
                        {{ $inv->address }}
                    </td>
                    <td class="p-3 text-pink-600 font-semibold">
                        {{ number_format($inv->final_total) }} đ
                    </td>

                    <td class="p-3">
                        {{ number_format($inv->shipping_fee) }} đ
                    </td>

                    <td class="p-3">
                        {{ $inv->donhang}}
                    </td>

                    <td class="p-3">
                        {{ $inv->thanhtoan}}
                    </td>

                    <td class="p-3">
                        {{ $inv->payment_method }}
                    </td>

                    <td class="p-3">
                        {{ $inv->note }}
                    </td>
                    <td class="p-3">
                        {{ $inv->created_at }}
                    </td>

                    <td class="p-3 flex gap-2">
                        <a href="{{ route('admin.order.editBill', $inv->orderdt_id) }}"
                            class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-500">
                            sửa
                        </a>
                        <form action="{{ route('admin.order.deletebill', $inv->orderdt_id) }}"
                                method="POST"
                                onsubmit="return confirm('Xóa hóa đơn này?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-4 text-center text-gray-500">
                        Chưa có hóa đơn nào
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
