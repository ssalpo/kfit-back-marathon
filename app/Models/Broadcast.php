<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Broadcast extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'source_type', 'source_data'];

    protected $casts = [
        'source_data' => 'array'
    ];

    public function marathon()
    {
        return $this->hasOneThrough(
            Marathon::class,
            MarathonComponent::class,
            'model_id',
            'id',
            'id',
            'marathon_id'
        );
    }

    public function isRecordAvailable(): Attribute
    {
        return Attribute::get(
            static fn() => now()->subDays(3)->gt($this->marathon?->end)
        );
    }

    public function status(): Attribute
    {
        $status = match (true) {
            is_null($this->source_type) => 'создана',
            !is_null($this->source_type) && !$this->marathon?->start => 'запланирована',
            $this->marathon?->start => 'идет',
            $this->is_record_available => 'запись доступна',
            $this->marathon?->end && !$this->is_record_available => 'запись просрочена (удалена)',
        };

        return Attribute::get(static fn() => $status);
    }
}
