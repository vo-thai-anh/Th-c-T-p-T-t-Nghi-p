@extends('admin.admin')

@section('admin_content')

<h1 class="text-3xl font-bold mb-6 text-gray-800">Thêm hoa mới</h1>

<div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
        <label class="block mb-2 font-semibold">Tên hoa</label>
        <input type="text" name="name" class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Mô tả</label>
        <textarea name="description" class="w-full p-3 border rounded-lg mb-4"></textarea>

        <label class="block mb-2 font-semibold">Giá</label>
        <input type="number" name="price" class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Tồn kho</label>
        <input type="number" name="stock_quantity" class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Danh mục</label>
        <select name="category_id" class="w-full p-3 border rounded-lg mb-4">
            @foreach($categories as $c)
                <option value="{{ $c->cate_id }}">{{ $c->name }}</option>
            @endforeach
        </select>

        <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700">Ảnh Chính (Chọn file)</label>
            <input type="file" name="main_image" required
                    class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-pink-500 focus:border-pink-500 transition duration-150">
        </div>
        <button class="px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
            Thêm sản phẩm
        </button>
    </form>

</div>

@endsection
