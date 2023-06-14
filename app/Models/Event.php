<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $nom
 * @property int $user_id
 * @property string|null $organisation
 * @property string|null $description
 * @property string|null $site_web
 * @property string|null $reseaux_sociaux
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereOrganisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereReseauxSociaux($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereSiteWeb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
