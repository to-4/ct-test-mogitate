<form method="GET" action="{{ route('products.search') }}" class="sidebar-form">
    {{-- 検索入力欄 + ボタン --}}
    <div class="form-group">
        <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
        <button type="submit" class="btn-search">検索</button>
    </div>

    <hr>

    {{-- 見出し --}}
    <div class="section-title">価格順で表示</div>

    {{-- 並び替え --}}
    <div class="form-group">
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="">価格で並べ替え</option>
            <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順</option>
            <option value="low"  {{ request('sort') == 'low'  ? 'selected' : '' }}>低い順</option>
        </select>
    </div>

    <hr>

    {{-- 並び替えタグ表示 --}}
    @if($sort)
        <div class="sort-tags badges">
            @if($sort === 'high')
                <span class="tag badge">
                    高い順に表示
                    <a href="{{ route('products.index', request()->except('sort')) }}" class="tag-remove">×</a>
                </span>
            @elseif($sort === 'low')
                <span class="tag badge">
                    低い順に表示
                    <a href="{{ route('products.index', request()->except('sort')) }}" class="tag-remove">×</a>
                </span>
            @endif
        </div>
    @endif

    {{-- キーワードバッジ（スペース区切りで複数対応） --}}
    @if(request('keyword'))
        <div class="badges">
            @foreach(preg_split('/\s+/u', request('keyword')) as $word)
                @if($word !== '')
                    <span class="badge">{{ $word }}</span>
                @endif
            @endforeach
        </div>
    @endif
</form>
