<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BroadcastResource extends JsonResource
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
            'status' => $this->status,
            'stream_url' => $this->source_data['stream_link'] ?? null,
            'marathon' => MarathonResource::make($this->whenLoaded('marathon'))
        ];
    }
}
