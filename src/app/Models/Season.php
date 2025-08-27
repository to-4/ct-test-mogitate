<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Season model
 *
 * 季節情報
 *
 * Corresponding table: seasons
 *
 * Properties:
 *
 * @property int $id
 *     主キーID（自動採番）
 *
 * @property string $name
 *     季節名
 *
 * @property Carbon|null $created_at
 *     タスクが作成された日時（Laravelが自動で管理）
 *
 * @property Carbon|null $updated_at
 *     タスクが最後に更新された日時（Laravelが自動で管理）
 */
class Season extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_season');
    }
}
