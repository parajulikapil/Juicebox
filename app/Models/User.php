<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use App\Models\Post;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relation between user and post
     * 
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->HasMany(Post::class);
    }

    /**
     * Fetch the record based on primary key
     *
     * @param array $params
     * @return self|Collection|Paginator
     */
    public static function fetch(array $params = [], bool $isSingle = false): self|Collection|Paginator
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

    /**
     * Find user by id and return
     */
    public static function findById(int $id): self
    {
        return self::query()->find($id);
    }
}
