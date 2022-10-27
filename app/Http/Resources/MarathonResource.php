<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarathonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'preview' => $this->preview,
            'start' => $this->when($this->start, $this->start->format('Y-m-d H:i:s')),
            'end' => $this->when($this->end, $this->end->format('Y-m-d H:i:s')),
            'status' => $this->status,
            'trainers' => $this->whenLoaded('trainers', fn() => $this->trainers->pluck('trainer_id')),
            'broadcast' => BroadcastResource::make($this->whenLoaded('broadcast'))
        ];
    }
}
