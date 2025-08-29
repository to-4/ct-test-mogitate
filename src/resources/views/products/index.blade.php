{{-- 商品一覧ビュー --}}
@extends('layouts.app')

@section('title', '商品一覧')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

{{-- トップバー差し込み --}}
@section('page_title', '商品一覧')
@section('page_actions')
<a href="{{ route('products.create') }}" class="btn-add">+ 商品を追加</a>
@endsection

{{-- サイドバーの中身（検索など） --}}
@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="product-list-container">
    {{-- 商品一覧 --}}
    <div class="product-list">
        @forelse($products as $product)
            <article class="product-card">
                <a class="product-image" href="{{ route('products.show', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </a>
                <div class="product-info">
                    <div class="product-meta">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <p class="product-price">¥{{ number_format($product->price) }}</p>
                    </div>
                </div>
            </article>
        @empty
            <p class="empty">商品がありません。</p>
        @endforelse
    </div>

    {{-- ページネーション --}}
    <div class="pagination">
        {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection
