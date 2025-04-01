<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $start_at
 * @property string $finished_at
 * @property string $funds
 * @property string $sources_of_funds
 * @property int $participation_total
 * @property string $participation_coverage
 * @property string|null $lpj_url
 * @property string|null $spg_url
 * @property string $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Department $department
 * @property-read mixed $timeline_range_text
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereFunds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereLpjUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereParticipationCoverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereParticipationTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereSourcesOfFunds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereSpgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkProgram withoutTrashed()
 * @mixin \Eloquent
 */
class WorkProgram extends Model
{
    use HasUlids, SoftDeletes;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'start_at',
        'finished_at',
        'funds',
        'sources_of_funds',
        'participation_total',
        'participation_coverage',
        'department_id',
        'lpj_url',
        'spg_url'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    // example output: 29 Mar 2025 - 31 Mar 2025 (2 Days)
    public function getTimelineRangeTextAttribute()
    {
        if ($this->start_at == $this->finished_at) {
            return date('D d M Y', strtotime($this->start_at)) . '-' . date('D d M Y', strtotime($this->finished_at)) . ' (' . "1 day" . ')';
        }

        $start = Carbon::parse($this->start_at);
        $end = Carbon::parse($this->finished_at);

        $years = $start->diffInYears($end);
        $months = $start->copy()->addYears($years)->diffInMonths($end);
        $days = $start->copy()->addYears($years)->addMonths($months)->diffInDays($end);

        $years = floor($years);
        $months = floor($months);
        $days = floor($days);

        $parts = [];
        if ($years > 0) $parts[] = "$years year" . ($years > 1 ? "s" : "");
        if ($months > 0) $parts[] = "$months month" . ($months > 1 ? "s" : "");
        if ($days > 0) $parts[] = "$days day" . ($days > 1 ? "s" : "");

        return date('D d M Y', strtotime($this->start_at)) . '-' . date('D d M Y', strtotime($this->finished_at)) . ' (' . implode(" ", $parts) . ')';
    }

    protected static function boot()
    {

        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::ulid()->toBase32();
            }
        });
    }
}
