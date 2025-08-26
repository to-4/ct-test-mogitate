<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product model
 *
 * 商品情報
 *
 * Corresponding table: products
 *
 * Properties:
 *
 * @property int $id
 *     主キーID（自動採番）
 *
 * @property varchar(255) $name
 *     商品名
 *
 * @property int $price
 *     商品料金
 *
 * @property varchar(255) $image
 *     商品画像
 *
 * @property text $description
 *     商品説明
 *
 * @property Carbon|null $created_at
 *     タスクが作成された日時（Laravelが自動で管理）
 *
 * @property Carbon|null $updated_at
 *     タスクが最後に更新された日時（Laravelが自動で管理）
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class, 'product_season');
    }
}
