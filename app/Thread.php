<?php

namespace App;

use App\Traits\Filterable;
use App\Traits\Ownable;
use App\Traits\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use Sluggable, SluggableScopeHelpers;
    use Ownable, Filterable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder) {
            return $builder->withCount('replies');
        });
    }

    /**
     * A thread belongs to a category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A thread may have many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Add a reply to the thread.
     *
     * @param array $reply
     *
     * @return Model
     */
    public function addReply(array $reply)
    {
        return $this->replies()->create($reply);
    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path ()
    {
        return "/t/{$this->category->slug}/{$this->slug}";
    }
}
