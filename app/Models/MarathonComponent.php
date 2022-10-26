<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarathonComponent extends Model
{
    use HasFactory;

    protected $with = ['marathon', 'broadcast'];

    protected $fillable = ['marathon_id', 'model_type', 'model_id'];

    public function marathon()
    {
        return $this->belongsTo(Marathon::class);
    }

    public function broadcast()
    {
        return $this->belongsTo(Broadcast::class, 'model_id');
    }
}
