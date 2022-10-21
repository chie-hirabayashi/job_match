<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    // 並び替え
    const SORT_NEW_ARRIVALS = 1;
    const SORT_VIEW_RANK = 2;
    const SORT_LIST = [
        self::SORT_NEW_ARRIVALS => '新着',
        self::SORT_VIEW_RANK => '人気',
    ];

    // マジックナンバー(作成者本人にしか意味が分からない値)が分かるように定数として定義
    // 公開非公開のステータス
    const STATUS_CLOSE = 0;
    const STATUS_OPEN = 1;
    const STATUS_LIST = [
        self::STATUS_CLOSE => '未公開',
        self::STATUS_OPEN => '公開',
    ];

    protected $fillable = [
        'title',
        'occupation_id',
        'due_date',
        'description',
        'is_published',
    ];

    // controllerでデータを取得する際の検索として書いてもいいが煩雑になるので、Builderを使用してモデルにインスタンス作成
    // 検索の間に挟んで更に検索する
    public function scopePublished(Builder $query)
    {
        $query->where('is_published', true)
            ->where('due_date', '>=', now());
        return $query;
    }

    /**
     * Get the Company that owns the JobOffer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the occupation that owns the JobOffer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    /**
     * Get all of the jobOfferViews for the JobOffer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobOfferViews()
    {
        return $this->hasMany(JobOfferView::class);
    }
}
