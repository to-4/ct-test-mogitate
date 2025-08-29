@extends('layouts.app')

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
            <label for="name">商品名 <span class="badge badge-required">必須</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                placeholder="商品名を入力">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 値段 --}}
        <div class="form-group">
            <label for="price">値段 <span class="badge badge-required">必須</span></label>
            <input type="number" id="price" name="price" value="{{ old('price') }}"
                placeholder="値段を入力">
            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 画像 --}}
        <div class="form-group">
            <label for="image">商品画像 <span class="badge badge-required">必須</span></label>
            <div class="image-preview" id="imagePreview"></div>
            <div class="file-upload">
                <label class="file-label">
                    <span class="file-button">ファイルを選択</span>
                    <input type="file" id="image" name="image" onchange="updateFileInfo(this)">
                </label>
                <span class="file-name" id="fileName">選択されていません</span>
            </div>
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 季節 --}}
        <div class="form-group">
            <label>季節 <span class="badge badge-required">必須</span><span class="season-notes">複数選択可</span></label>
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
            <label for="description">商品説明 <span class="badge badge-required">必須</span></label>
            <textarea id="description" name="description" placeholder="商品の説明を入力" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="form-buttons">
            <a href="{{ session('products.index_url', route('products.index')) }}" class="btn btn-back">戻る</a>
            <button type="submit" class="btn btn-save">登録</button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
function updateFileInfo(input) {
    const fileNameSpan = document.getElementById('fileName');
    const preview = document.getElementById('imagePreview');

    console.log(input.files);
    console.log(fileNameSpan);
    console.log(preview);

    if (input.files && input.files[0]) {
        fileNameSpan.textContent = input.files[0].name;

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="プレビュー">`;
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        fileNameSpan.textContent = "選択されていません";
        preview.innerHTML = "";
    }
}
</script>
@endpush