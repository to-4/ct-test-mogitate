<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductStoreRequest;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $q = Product::query();

        if ($request->filled('keyword')) {
            $q->where('name', 'like', '%'.$request->keyword.'%');
        }

        $sort = $request->sort;
        if ($sort === 'high') {
            $q->orderBy('price', 'desc');
        } else if ($sort === 'low') {
            $q->orderBy('price', 'asc');
        }

        $products = $q->paginate(6)->appends($request->query());

        // 現在の一覧URL（ページ番号・検索条件つき）を保存
        session(['products.index_url' => $request->fullUrl()]);

        return view('products.index', compact('products', 'sort'));
    }

    public function show($productId, Request $request)
    {
        // Eager Loading で season 情報も一緒に取得
        // - $product->seasons でアクセス可能に
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();

        // 直前のリクエストで withInput() されているか（= バリデーションで戻ってきた等）
        // Laravel の FormRequest や Validator が失敗すると、自動で
        //  1. withErrors(...) → session('errors') にメッセージが入る
        //  2. withInput()  → session('_old_input') に入力値が入る
        //      => という2つが同時にセットされます
        $hasOld = $request->hasSession() && $request->session()->has('_old_input');

        // seasons のチェック状態を決める
        // - バリデーション戻りの場合：old を最優先。キーが無ければ「全て外し」（空配列）として扱う
        // - 初回表示/通常遷移：DBの現在値（関連ID）を使う
        if ($hasOld) {
            // old('seasons') が null の場合 = チェックボックス未送信（全部外した）
            $selectedSeasonIds = $request->old('seasons', []);  // 空配列フォールバック＝全部外し
        } else {
            $selectedSeasonIds = $product->seasons->modelKeys(); // DBの関連ID配列
        }

        return view('products.show', compact('product','seasons','selectedSeasonIds'));
    }

    public function create()
    {
        // 季節の選択肢を取得してビューへ
        $seasons = Season::all();

        return view('products.create', compact('seasons'));
    }

    public function store(ProductStoreRequest $request)
    {
        // バリデーション
        $validated = $request->validated();

        // 画像ファイルの保存（storage/app/public/products に格納）
        $path = $request->file('image')->store('products', 'public');

        // products テーブルへ登録
        $product = Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'description' => $validated['description'],
            'image'       => $path, // DB には storage 内の相対パスを保存
        ]);

        // 中間テーブル（product_season）へ登録
        $product->seasons()->sync($validated['seasons']);

        // 登録完了後、一覧へリダイレクト
        $backUrl = session('products.index_url', route('products.index'));
        return redirect($backUrl)->with('status', '商品を登録しました');
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        // バリデーション済みデータの取得
        $validated = $request->validated();

        // 同時更新を安全に
        $product = Product::findOrFail($id);
        DB::transaction(function () use ($validated, $request, $product) {

            // 本体の更新
            $product->name        = $validated['name'];
            $product->price       = $validated['price'];
            $product->description = $validated['description'] ?? '';

            // 画像アップロードがある場合
            if ($request->hasFile('image')) {
                // 旧画像を消したい場合はここで削除（任意）
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $path = $request->file('image')->store('products', 'public');
                $product->image = $path;
            }

            $product->save();

            // seasons（多対多）を同期
            // チェックが全て外されると seasons が送られないので空配列にフォールバック
            $seasonIds = $validated['seasons'] ?? [];
            $product->seasons()->sync($seasonIds); // 差分更新（追加・削除を自動で反映）
        });

        $backUrl = session('products.index_url', route('products.index'));
        return redirect($backUrl)->with('status', '更新しました');
    }

    public function destroy($productId)
    {

        $product = Product::findOrFail($productId);

        // 関連データ（seasons）を同期解除
        $product->seasons()->detach();

        // 本体削除
        $product->delete();

        // 戻り先（元の一覧URLがセッションに残っていればそこへ）
        $backUrl = session('products.index_url', route('products.index'));
        return redirect($backUrl)->with('status', '商品を削除しました');
    }
}
