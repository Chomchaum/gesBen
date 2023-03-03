<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\test
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $lastname
 * @property string $firstname
 * @property string $birthdate
 * @property string|null $phone
 * @property string $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benevole whereUserId($value)
 * @property-read \App\Models\User|null $user
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
