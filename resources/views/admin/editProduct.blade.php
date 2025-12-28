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
<h1 class="text-3xl font-bold mb-6 text-gray-800">Sửa thông tin hoa</h1>

<div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">

    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label class="block mb-2 font-semibold">Tên hoa</label>
        <input type="text" name="name" value="{{ $product->name }}"
                class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Mô tả</label>
        <textarea name="description" class="w-full p-3 border rounded-lg mb-4">{{ $product->description }}</textarea>

        <label class="block mb-2 font-semibold">Giá</label>
        <input type="number" name="price" value="{{ $product->price }}"
                class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Tồn kho</label>
        <input type="number" name="stock_quantity"
            value="{{ $product->stock->quantity ?? 0 }}"
            class="w-full p-3 border rounded-lg mb-4">


        <label class="block mb-2 font-semibold">Danh mục</label>

        <select name="category_id" required class="w-full p-3 border rounded-lg">
            <option value="">-- Chọn danh mục --</option>

            @foreach ($categories as $c)
                <option value="{{ $c->cate_id }}"
                    {{ (string) old('category_id', $product->category_id) === (string) $c->cate_id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>


        <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700">Ảnh Chính (Chọn file)</label>
            <input type="file" name="main_image"
                    class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-pink-500 focus:border-pink-500 transition duration-150">
        </div>
        <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Cập nhật
        </button>
    </form>

</div>

@endsection
