<?php

namespace App\Models;

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
 * @property int $private
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereOrganisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereReseauxSociaux($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereSiteWeb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereUserId($value)
 * @mixin \Eloquent
 */
class Evenement extends Model
{
    protected $table = 'evenements';

    protected $guarded = ['id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function setReseauxSociauxAttribute($value)
    {
        $this->attributes['reseaux_sociaux'] = json_encode($value);
    }
}