<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Laravel\Sanctum\Contracts\HasAbilities;

/**
 * 
 *
 * @property mixed $id 3 occurrences
 * @property array<array-key, mixed>|null $abilities 3 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 3 occurrences
 * @property \Illuminate\Support\Carbon|null $expires_at 3 occurrences
 * @property string|null $name 3 occurrences
 * @property string|null $token 3 occurrences
 * @property string|null $tokenable_id 3 occurrences
 * @property string|null $tokenable_type 3 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 3 occurrences
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $tokenable
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken aggregate($function = null, $columns = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereAbilities($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereExpiresAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereToken($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereTokenableId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereTokenableType($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|PersonalAccessToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PersonalAccessToken extends Model implements HasAbilities
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token',
    ];

    /**
     * Get the tokenable model that the access token belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function tokenable()
    {
        return $this->morphTo('tokenable');
    }

    /**
     * Find the token instance matching the given token.
     *
     * @param  string  $token
     * @return static|null
     */
    public static function findToken($token)
    {
        if (strpos($token, '|') === false) {
            return static::where('token', hash('sha256', $token))->first();
        }

        [$id, $token] = explode('|', $token, 2);

        if ($instance = static::find($id)) {
            return hash_equals($instance->token, hash('sha256', $token)) ? $instance : null;
        }
    }

    /**
     * Determine if the token has a given ability.
     *
     * @param  string  $ability
     * @return bool
     */
    public function can($ability)
    {
        return in_array('*', $this->abilities) ||
               array_key_exists($ability, array_flip($this->abilities));
    }

    /**
     * Determine if the token is missing a given ability.
     *
     * @param  string  $ability
     * @return bool
     */
    public function cant($ability)
    {
        return ! $this->can($ability);
    }
}
