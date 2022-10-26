<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Broadcast extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title'];

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
}
