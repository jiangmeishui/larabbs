<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug'
    ];
    // 一个话题对应一个分类
    public function category() {
       return $this->belongsTo(Category::class);
    }
    // 一个话题属于一个作者
    public function user() {
        return $this->belongsTo(User::class);
    }
    // 一个话题下有多条回复
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // 使用本地作用域,作集合条件约束,返回一个查询构造器,需要在方法前加score前缀,调用时
    // 不用加
    public function scopeWithOrder($query, $order) {
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
        // 由于有关联模型,预防N+1问题
        return $query->with('user', 'category');
    }

    public function scopeRecent($query) {
        // 按创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeRecentReplied($query) {
        return  $query->orderBy('updated_at', 'desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    /*
     * 更新话题回复数
     */
    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
