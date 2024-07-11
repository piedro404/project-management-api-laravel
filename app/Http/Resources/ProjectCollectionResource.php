<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "title" => $this->title,
            "description" => $this->description,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "tasks_count" => $this->tasks->count(),
            "start_date_format" => $this->start_date ? [
                "date" => Carbon::parse($this->start_date)->format('d/m/Y'),
                "time" => Carbon::parse($this->start_date)->format('H:i'),
            ] : null,
            "end_date_format" => $this->end_date ? [
                "date" => Carbon::parse($this->end_date)->format('d/m/Y'),
                "time" => Carbon::parse($this->end_date)->format('H:i'),
            ] : null,
            "term" => $this->end_date ?
                ($this->status == 2 ? "Concluído" : (Carbon::parse($this->end_date)->isPast() ? "Expirado"
                        : "Termina " . Carbon::parse($this->end_date)->diffForHumans()))
                : null,
            "created_at_format" => [
                "date" => Carbon::parse($this->created_at)->format('d/m/Y'),
                "time" => Carbon::parse($this->created_at)->format('H:i'),
            ],
            "updated_at_format" => [
                "date" => Carbon::parse($this->updated_at)->format('d/m/Y'),
                "time" => Carbon::parse($this->updated_at)->format('H:i'),
            ],
        ];
    }
}
