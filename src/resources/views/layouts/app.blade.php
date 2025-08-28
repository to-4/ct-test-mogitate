<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    {{-- 共通 --}}
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    {{-- ページ固有 CSS は各 Blade から差し込む --}}
    @stack('styles')
</head>
<body>
<header class="site-header">
    <div class="container">
        <h1 class="logo">
            <a href="{{ route('products.index') }}">mogitate</a>
        </h1>
    </div>
</header>

{{-- ページごとのトップバー（タイトル＋アクション） --}}
<div class="topbar">
    <div class="container topbar-inner">
        <h2 class="page-title">@yield('page_title', '')</h2>
        <div class="page-actions">
            @yield('page_actions') {{-- ここに [+ 商品を追加] など差し込む --}}
        </div>
    </div>
</div>

<main class="site-main container">
    <div class="layout">
        {{-- サイドバー：枠は常に表示。中身は @section('sidebar') がある時のみ --}}
        <aside class="sidebar">
            @hasSection('sidebar')
                @yield('sidebar')
            @else
                <div class="sidebar-empty"></div> {{-- 空枠用の余白だけ --}}
            @endif
        </aside>

        {{-- メインコンテンツ --}}
        <div class="main-content">

            {{-- フラッシュメッセージ（任意） --}}
            @if(session('status'))
                <div class="flash flash-success">{{ session('status') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</main>

{{-- 画面ごとの追加JS（必要なら各Bladeで @push('scripts') を使用） --}}
@stack('scripts')
</body>
</html>
