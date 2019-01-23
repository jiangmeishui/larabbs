<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
    // 一个话题对应一个分类
    public function category() {
       return $this->belongsTo(Category::class);
    }
    // 一个话题属于一个作者
    public function user() {
        return $this->belongsTo(User::class);
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
}
