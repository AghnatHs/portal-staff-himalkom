<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property-read \App\Models\User|null $author
 * @property-read \App\Models\WorkProgram|null $workProgram
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgramComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgramComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgramComment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgramComment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgramComment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgramComment withoutTrashed()
 * @mixin \Eloquent
 */
class WorkProgramComment extends Model
{
    use HasUlids, SoftDeletes;
    public $incrementing = false;
    protected $keyType = 'string';

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workProgram(): BelongsTo
    {
        return $this->belongsTo(WorkProgram::class);
    }
}
