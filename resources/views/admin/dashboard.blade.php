@extends('admin.admin')

@section('page_title', 'Dashboard')

@section('admin_content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded shadow">
        <p>Tổng đơn hàng</p>
        <h3 class="text-2xl font-bold">{{ $totalOrders }}</h3>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <p>Doanh thu</p>
        <h3 class="text-2xl font-bold text-green-600">
            {{ number_format($totalRevenue) }} đ
        </h3>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <p>Đơn chờ xử lý</p>
        <h3 class="text-2xl font-bold text-yellow-500">{{ $pendingOrders }}</h3>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <p>Thanh toán chưa trả</p>
        <h3 class="text-2xl font-bold text-red-500">{{ $unpaidPayments }}</h3>
    </div>

</div>

<div class="bg-white p-6 rounded shadow">
    <h3 class="font-semibold mb-4">Đơn hàng mới nhất</h3>

    <table class="w-full">
        @foreach($latestOrders as $order)
        <tr class="border-b">
            <td>#{{ $order->order_id }}</td>
            <td>{{ $order->fullname }}</td>
            <td>{{ number_format($order->final_total) }} đ</td>
            <td>{{ $order->status }}</td>
        </tr>
        @endforeach
    </table>
</div>

@endsection
