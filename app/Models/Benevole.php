<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Benevole
 *
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole query()
 * @mixin \Eloquent
 */
class Benevole extends Model
{
    use HasFactory;

    protected $table = 'benevoles';
    protected $guarded = ['id'];
    protected $with = ['user'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
