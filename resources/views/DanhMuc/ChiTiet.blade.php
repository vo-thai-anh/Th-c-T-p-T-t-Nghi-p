@extends('layouts.app')
@section('content')
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
<section class="product-detail container">
    <div class="product-main-content">
        <div class="product-gallery">
            <div class='product-image-wrapper detail-image'>
                <img src="{{ asset('images/' . $data->product_id . '.jpg') }}" alt="{{ $data->name }}">
            </div>
            </div>
        <div class="product-info">
            
            <h1 class='product-detail-title'>{{ $data->name }}</h1>
            
            <div class="product-rating">
                <p>5.0 ⭐⭐⭐⭐⭐ (Đã bán 1k+)</p>
            </div>
            
            <p class='product-detail-price'>{{ number_format($data->price , 0, ',', '.') }} ₫</p>
            
            <div class="product-description-short">
                <p>Thành phần: 100% hoa tươi nguyên chất thu hoạch tự nhiên.</p>
                <p>Độ tươi: Rất cao</p>
            </div>
             <form action="{{ route('additems') }}" method="POST">
                @csrf
                
                <input type="hidden" name="product_id" value="{{ $data->product_id }}">

            
                <div class="quantity-control mb-4 flex items-center gap-4">
                    <label for="quantity" class="text-gray-600 font-medium">Số lượng:</label>
                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        value="1"
                        min="1"
                        max="100"
                        class="form-control p-2 border border-gray-300 rounded-md w-20 text-center"
                    >
                </div>
            <button class="btn-buy-now">Thêm vào giỏ hàng</button>
            <div class="product-share-links">
                <span style="color:#6b7280">Chia sẻ:</span>
                <a href="#" class="btn-social btn-facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="#" class="btn-social btn-instagram"><i class="fab fa-instagram"></i> Instagram</a>
            </div>
        </div>
    </div>
    <div class="product-tabs">
        <h2 class="section-title">Mô tả sản phẩm</h2>
        <p class="description-text">{{ $data->description ?? 'Hiện chưa có mô tả chi tiết cho sản phẩm này.' }}</p>
    </div>
</section>

@endsection