
@extends('admin.admin')
@section('page_title', 'Quản lý sản phẩm')
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
<h1 class="text-3xl font-bold mb-6 text-gray-800">Quản lý Sản phẩm</h1>
<a href="{{ route('admin.products.create') }}"
    class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-pink-700 transition">
    + Thêm hoa mới
</a>

<div class="mt-6 bg-white p-6 rounded-lg shadow">
    <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 border-b">
            <tr class="text-left">
                <th class="p-3">ID</th>
                <th class="p-3">Tên hoa</th>
                <th class="p-3">Giá</th>
                <th class="p-3">Tồn kho</th>
                <th class="p-3">Danh mục</th>
                <th class="p-3">Ảnh</th>
                <th class="p-3">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($products as $p)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $p->product_id }}</td>
                <td class="p-3 font-medium">{{ $p->name }}</td>
                <td class="p-3 text-pink-600 font-semibold">{{ number_format($p->price) }} đ</td>
                <td class="p-3">{{ $p->stock_quantity }}</td>
                <td class="p-3">{{ $p->category_name}}</td>
                <td class="p-3">
                    <img src="{{ asset('images/' . $p->product_id . '.jpg') }}"
                    class="w-16 h-16 object-cover rounded-lg shadow">
                    
                </td>
                <td class="p-3" style="display: flex; gap: 10px; align-items: center;height: 100%">
                    <a href="{{ route('admin.products.edit', $p->product_id) }}"
                        style="height: 40px; display: block;" class=" px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                        Sửa
                    </a>
                    <form action="{{ route('admin.products.delete', $p->product_id) }}"
                            method="POST" class="inline-block"
                            onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                        @csrf
                        @method('DELETE')
                        <button style="height: 40px; display: block;" class=" px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Xóa
                        </button>
                    </form>
                        <a href="{{ route('detail',$p->product_id ) }}"
                        class="px-3 py-2 bg-gray-500 text-white rounded-lg hover:bg-yellow-600">
                        Xem Chi Tiết
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
