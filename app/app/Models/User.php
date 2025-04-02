<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * 
 *
 * @property mixed $id 14 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 14 occurrences
 * @property string|null $email 14 occurrences
 * @property string|null $name 14 occurrences
 * @property string|null $password 14 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 14 occurrences
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User aggregate($function = null, $columns = [])
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
}
