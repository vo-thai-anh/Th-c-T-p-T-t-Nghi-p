@extends('layouts.app')
@section('content')
        <section class="hero-section container" >
            <div class="hero-content">
                <h1 class="hero-title">
                    Send <strong>flowers</strong> like you mean it.
                </h1>
                <p class="hero-text">
                    Where flowers are our inspiration to create lasting memories.
                    Whatever the occasion, our flowers will make it special cursus a sit amet mauris.
                </p>
                <div class="hero-signature">
                    Sara
                </div>
            </div>
            
            </section>
            <section class="product-filter container">
                <div class="filter-categories">
                    <a href="#" class="active">ALL</a>
                    <a href="#" class="">POPULAR</a>
                    <a href="#" class="">WINTER</a>
                    <a href="#" class="">VARIOUS</a>
                    <a href="#" class="">EXOTIC</a>
                    <a href="#" class="">GREENS</a>
                    <a href="#" class="">CACTUSES</a>
                </div>
                <div class="filter-dropdown">
                    FILTER ▼
                </div>
                </section>
                    <div class = "result-search">
                        <div class="sear">
                            Kết quả tìm kiếm cho: <strong>{{ $searchItem ?? 'Tất cả sản phẩm' }}</strong>
                        </div>
                            {{-- <p class="text-gray-600 mb-6"> --}}
                            <div class="list">
                                @foreach($data as $item)
                                <div class='product-item'>
                                    <div class='product-image-wrapper lily'>
                                        <img src="{{ asset('images/' . $item->product_id . '.jpg') }}" alt="{{ $item->name }}">
                                    </div>
                                    <h3 class='product-title'> {{ $item->name }} </h3>
                                    <p class='product-price'>{{ number_format($item->price, 0, ',', '.') }} VNĐ</p>
                                </div>
                                @endforeach
                            </div>
                    </div>
            @endsection

