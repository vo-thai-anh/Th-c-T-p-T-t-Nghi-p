@extends('admin.admin')
@section('page_title', 'Quản lý thanh toán')
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

<h1 class="text-3xl font-bold mb-6 text-gray-800">Quản lý thanh toán</h1>

<div class="bg-white p-6 rounded-lg shadow overflow-x-auto">

    <table class="w-full border border-gray-300 rounded-lg">
        <thead class="bg-gray-100 border-b">
            <tr class="text-left text-sm">
                <th class="p-3">ID</th>
                <th class="p-3">Khách hàng</th>
                <th class="p-3">Số tiền</th>
                <th class="p-3">Phương thức</th>
                <th class="p-3">Trạng thái</th>
                <th class="p-3">Ngày tạo</th>
                <th class="p-3">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @forelse($payments as $pay)
                <tr class="border-b hover:bg-gray-50 text-sm">
                    <td class="p-3">
                        {{ $pay->payment_id }}
                    </td>
                    <td class="p-3">
                        {{ $pay->fullname }}
                    </td>
                    <td class="p-3">
                        {{  number_format($pay->amount)}}.000
                    </td>
                    <td class="p-3">
                        {{ $pay->payment_method }}
                    </td>
                    <td class="p-3">
                        {{ $pay->status }}
                    </td>
                    <td class="p-3">
                        {{ $pay->created_at }}
                    </td>
                    <td>
                        <form action="{{ route('admin.payment.deletepayment', $pay->payment_id) }}"
                                method="POST"
                                onsubmit="return confirm('Xóa thanh toán này?')">
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
                        Chưa có dữ liệu thanh toán
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
