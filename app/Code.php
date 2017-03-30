<?php

namespace App;

use App\Traits\Filterable;
use App\Traits\Ownable;
use App\Traits\Publishable;
use App\Traits\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use Sluggable, SluggableScopeHelpers;
    use Ownable, Publishable, Filterable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Code is created by an user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Code must belong to a dataset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataset ()
    {
        return $this->belongsTo(Dataset::class);
    }

    /**
     * Get a string path for the code.
     *
     * @return string
     */
    public function path ()
    {
        return "/c/{$this->slug}";
    }
}
