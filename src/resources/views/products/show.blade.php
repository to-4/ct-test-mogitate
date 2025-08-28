@extends('layouts.app')

@section('page_title', '商品詳細')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endpush

{{-- ※sidebar セクションは定義しない → 空枠だけ表示 --}}

@section('content')
<div class="product-show">

    {{-- パンくず --}}
    <div class="breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a> ＞ {{ $product->name }}
    </div>

    {{-- 更新フォーム --}}
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="show-form">
        @csrf
        @method('PUT')

        <div class="show-left">
            {{-- 画像 --}}
            <div class="image-box">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>

            {{-- ファイル選択 --}}
            <div class="form-group">
                <input type="file" name="image">
                @error('image')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="show-right">
            {{-- 商品名 --}}
            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}">
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 値段 --}}
            <div class="form-group">
                <label for="price">値段</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}">
                @error('price')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 季節 --}}
            <div class="form-group">
                <label>季節</label>
                <div class="season-options">
                    @foreach($seasons as $season)
                        <label>
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                {{ in_array($season->id, $selectedSeasonIds ?? []) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                    @endforeach
                </div>
                @error('seasons')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="form-group full">
            <label for="description">商品説明</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="form-buttons">
            <a href="{{ session('products.index_url', route('products.index')) }}" class="btn btn-back">戻る</a>
            <button type="submit" class="btn btn-save">変更を保存</button>
        </div>
    </form>

    {{-- 削除ボタン --}}
    <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="delete-form"
        onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-delete">🗑</button>
    </form>
</div>
@endsection
