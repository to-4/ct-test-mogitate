{{-- 商品一覧ビュー --}}
@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
<div class="product-list-container">

    {{-- 右上の商品追加ボタン --}}
    <div class="product-add">
        <!-- == 2025.8.27 == -->
        <a href="{{ route('products.create') }}" class="btn-add">+ 商品を追加</a>
        <!-- == 2025.8.27 == -->
    </div>

    {{-- 商品一覧 --}}
    <div class="product-list">
        @forelse($products as $product)
            <article class="product-card">
                <!-- == 2025.8.27 == -->
                <a class="product-image" href="{{ route('products.show', $product->id) }}">
                <!-- == 2025.8.27 == -->
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </a>
                <div class="product-info">
                    <h2 class="product-name">{{ $product->name }}</h2>
                    <p class="product-price">¥{{ number_format($product->price) }}</p>
                </div>
            </article>
        @empty
            <p class="empty">商品がありません。</p>
        @endforelse
    </div>

    {{-- ページネーション --}}
    <div class="pagination">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection
