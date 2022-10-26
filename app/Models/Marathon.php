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
        return Attribute::get(function ($value, $attributes) {
            if (now()->between($attributes['start'], $attributes['end'])) {
                return 'start';
            }

            if (now()->gt($attributes['end'])) {
                return 'end';
            }

            return 'wait';
        });
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
        );
    }
}
