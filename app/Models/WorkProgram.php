<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $attributes = [
        'lpj_url' => 'Belum diunggah',
        'spg_url' => 'Belum diunggah',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    
    protected static function boot(){
        
        parent::boot();
        static::creating(function($model){
            if(!$model->id){
                $model->id = Str::ulid()->toBase32();
            }
        });

    }
}
