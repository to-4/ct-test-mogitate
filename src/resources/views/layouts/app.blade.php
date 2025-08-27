<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>
<body>
<header class="site-header">
    <div class="container">
        <h1 class="logo">mogitate</h1>

        {{-- 検索フォーム --}}
        <form method="GET" action="{{ route('products.index') }}" class="search-form">
            <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
            <button type="submit" class="btn-search">検索</button>

            <label for="sort" class="label">価格順で表示</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">価格で並べ替え</option>
                <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順</option>
                <option value="low"  {{ request('sort') == 'low' ? 'selected' : '' }}>低い順</option>
            </select>
        </form>
    </div>
</header>

<main class="site-main container">
    @yield('content')
</main>
</body>
</html>
