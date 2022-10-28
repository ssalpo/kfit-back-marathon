<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marathon extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'preview', 'start', 'end'];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function status(): Attribute
    {
        $status = match (true) {
            $this->is_start => 'start',
            $this->is_end => 'start',
            default => 'wait'
        };

        return Attribute::get(static fn() => $status);
    }

    public function isStart(): Attribute
    {
        return Attribute::get(
            static fn($value, $attributes) => now()->between($attributes['start'], $attributes['end'])
        );
    }

    public function isEnd(): Attribute
    {
        return Attribute::get(
            static fn($value, $attributes) => now()->gt($attributes['end'])
        );
    }

    public function trainers()
    {
        return $this->hasMany(MarathonTrainer::class);
    }

    public function components()
    {
        return $this->hasMany(MarathonComponent::class);
    }

    public function broadcast()
    {
        return $this->hasOneThrough(
            Broadcast::class,
            MarathonComponent::class,
            'marathon_id',
            'id',
            'id',
            'model_id'
        )->where('model_type', 'broadcast');
    }
}
