@extends('layouts.app')

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
    <form id="update-form" method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="show-form">
        @csrf
        @method('PUT')

        <div class="show-left">
            {{-- 画像 --}}
            <div class="image-box">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>

            {{-- ファイル選択 --}}
            <div class="form-group file-upload">
                <label class="file-label">
                    <span class="file-button">ファイルを選択</span>
                    <input type="file" name="image" id="fileInput" onchange="updateFileName(this)">
                </label>
                <span class="file-name" id="fileName">
                    {{ $product->image ? basename($product->image) : '選択されていません' }}
                </span>
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
    </form> {{-- ← 更新フォームここまで --}}

    {{-- アクション行：中央に［戻る／保存］、右端に削除 --}}
    <div class="actions-row">

        <div class="center-actions">
            <a href="{{ session('products.index_url', route('products.index')) }}" class="btn btn-back">戻る</a>
            {{-- 更新フォームを送信（form属性で #update-form（外部フォーム） を送信） --}}
            <button type="submit" form="update-form" class="btn btn-save">変更を保存</button>
        </div>

        {{-- 削除（独立したフォーム） --}}
        <form method="POST" action="{{ route('products.destroy', $product->id) }}"
            class="form-delete" onsubmit="return confirm('本当に削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete" aria-label="商品を削除">🗑</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateFileName(input) {
    const fileName = input.files.length > 0 ? input.files[0].name : '選択されていません';
    document.getElementById('fileName').textContent = fileName;
}
</script>
@endpush