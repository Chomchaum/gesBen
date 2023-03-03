<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Participation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Participation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Participation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Participation query()
 * @mixin \Eloquent
 */
class Participation extends Model
{
    use HasFactory;

    protected $table = 'participations';
    protected $guarded = ['id'];
}