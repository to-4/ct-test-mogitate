@extends('layouts.app')

@section('page_title', '商品登録')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush

{{-- ※sidebar セクションは定義しない → 空枠だけ表示 --}}

@section('content')
<div class="product-create">

    <h2 class="page-title">商品登録</h2>

    {{-- 登録フォーム --}}
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="create-form">
        @csrf

        {{-- 商品名 --}}
        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 値段 --}}
        <div class="form-group">
            <label for="price">値段</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}">
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
                            {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                        {{ $season->name }}
                    </label>
                @endforeach
            </div>
            @error('seasons')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品説明 --}}
        <div class="form-group">
            <label for="description">商品説明</label>
            <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 画像 --}}
        <div class="form-group">
            <label for="image">商品画像</label>
            <input type="file" id="image" name="image">
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="form-buttons">
            <!-- <a href="{{ route('products.index') }}" class="btn btn-back">戻る</a> -->
            <a href="{{ session('products.index_url', route('products.index')) }}" class="btn btn-back">戻る</a>
            <button type="submit" class="btn btn-save">登録</button>
        </div>
    </form>
</div>
@endsection
