<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
