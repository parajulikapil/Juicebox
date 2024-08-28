<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * Relation between user and post
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Fetch the record
     *
     * @param array $params
     * @return self|Collection|Paginator|null
     */
    public static function fetch(array $params = [], bool $isSingle = false): self|Collection|Paginator|null
    {
        // For pagination
        $perPage = (int) (isset($params['page']) && $params['page'] > 0 ? ( $params['per_page'] ?? (int)config('services.pagination.per_page') ): -1);
        $params = Arr::except($params, ['page', 'per_page']);
        
        // Query as per given condition
        $query = self::query()->where($params);

        // If this needs to return pagination
        if ($perPage > 0) {
            return $query->paginate($perPage);
        }
        
        // if needs to return single object
        if ($isSingle) {
            return $query->first();
        }

        // If needs to return collection
        return $query->get();
    }
}
